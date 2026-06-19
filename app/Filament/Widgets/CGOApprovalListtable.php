<?php

namespace App\Filament\Widgets;

use App\Models\CgoUser;
use App\Services\Admin\HandelAdminService;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use App\Services\Admin\SearchComponentAdminService;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use App\Models\TvetType;
use App\Models\Institute;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use App\Services\CGOApprovalService;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class CGOApprovalListtable extends BaseWidget
{
    protected static string $view = 'filament-widgets::table-widget';
    protected SearchComponentAdminService $searchService;
    public array $data;
    public $searchTime = 'all';
    public $query;
    public static $totalCgo; // Declare a public property
    protected HandelAdminService $approvalService;

    public function __construct()
    {
        $this->searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );

        $this->approvalService = new HandelAdminService();
    }

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getTableHeading(): ?string
    {
        return ''; // Hide the table heading
    }

    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.pages.cgo-approval-list');
    }

    protected function getTableQuery(): Builder
    {
        $query = CgoUser::query()
            ->whereNull('verify_by')
            ->whereNull('verify_at');

        $user = auth('admin')->user();

        // Filter by institute based on user role
        if (!$user->hasRole('super_admin')) {
            $userTvetType = $user->tvet_type;
            if ($userTvetType) {
                $instituteIds = Institute::where('institute_head_office', $userTvetType)
                    ->pluck('id')
                    ->toArray();
                $query->whereIn('institute_id', $instituteIds);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Handle search
        if (!empty($this->data['search'])) {
            $searchTerm = '%' . $this->data['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', $searchTerm)
                    ->orWhere('last_name', 'like', $searchTerm);
            });
        }

        // Handle institute filter
        if (!empty($this->data['institute'])) {
            $query->where('institute_id', $this->data['institute']);
        }

        // Handle time filter
        if ($this->searchTime !== 'all') {
            $query->whereDate('created_at', '<=', now()->subDays(30));
        }

        // Handle sorting
        if (!empty($this->data['search_time'])) {
            if ($this->data['search_time'] === 'recently') {
                $query->orderBy('created_at', 'desc');
            } elseif ($this->data['search_time'] === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        self::$totalCgo = $query->count();

        return $query;
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('approve')
                ->label(__('system.form.button.approve'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function (EloquentCollection $records) {
                    foreach ($records as $record) {
                        $success = $this->approvalService->approve(CgoUser::class, $record->id);

                        if ($success) {
                            Notification::make()
                                ->title('Action Success!')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Something wrong !')
                                ->danger()
                                ->send();
                        }
                    }
                }),

            Tables\Actions\BulkAction::make('reject')
                ->label(__('system.filter.status.reject'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label(__('Reason'))
                        ->required()->rows(5)
                        ->maxLength(250),
                ])
                ->action(function (EloquentCollection $records, array $data) {
                    foreach ($records as $record) {
                        $success = $this->approvalService->rejectCgo(CgoUser::class, $record->id, $data['reason']);
                    }

                    if ($success) {
                        Notification::make()
                            ->title('Action Success!')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Something wrong !')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('index')
                ->rowIndex()
                ->alignCenter()
                ->sortable()
                ->label('No.'),
            Tables\Columns\TextColumn::make('institute.name')
                ->label(__('company.job_support.trainee_list.filter.institution'))
                ->sortable(),
            Tables\Columns\TextColumn::make('district.name')
                ->label(trans('trainee.job_support.company.table.label.district'))
                ->sortable(),
            Tables\Columns\TextColumn::make('fullName')
                ->label(trans('trainee.my_page.full_name'))
                ->searchable(['first_name', 'last_name'])
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('admin/dashboard.cgo.created_at'))
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->hasRole('super_admin');

        $filters = [];

        if ($isSuperAdmin) {
            // Filter for super_admin: can select TVET and Institute
            $filters[] = Filter::make('tvet_type')
                ->form([
                    Select::make('tvet_type')
                        ->label(__('admin/dashboard.cgo.tvet_type'))
                        ->options(TvetType::all()->pluck('head_office_name', 'head_office_code'))
                        ->preload()
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('institute_select', null);
                        }),

                    Select::make('institute_select')
                        ->label(__('admin/dashboard.cgo.institute_name'))
                        ->options(function (callable $get) {
                            $tvetCode = $get('tvet_type');
                            if ($tvetCode) {
                                return Institute::where('institute_head_office', $tvetCode)
                                    ->orderBy('name', 'asc')
                                    ->pluck('name', 'id');
                            }
                            return [];
                        })
                        ->preload()
                        ->searchable()
                        ->visible(fn(callable $get) => !empty($get('tvet_type'))),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['tvet_type'])) {
                        $instituteIds = Institute::where('institute_head_office', $data['tvet_type'])
                            ->pluck('id')
                            ->toArray();
                        $query->whereIn('institute_id', $instituteIds);
                    }

                    if (!empty($data['institute_select'])) {
                        $query->where('institute_id', $data['institute_select']);
                    }
                });
        } else {
            // Filter for regular admin: only show institutes belonging to their tvet_type
            $userTvetType = $user->tvet_type;

            if ($userTvetType) {
                $instituteOptions = Institute::where('institute_head_office', $userTvetType)
                    ->orderBy('name', 'asc')
                    ->pluck('name', 'id')
                    ->toArray();

                $filters[] = Filter::make('institute_filter')
                    ->form([
                        Select::make('institute_select')
                            ->label(__('admin/dashboard.cgo.institute_name'))
                            ->options($instituteOptions)
                            ->preload()
                            ->searchable()
                            ->placeholder('All Institutes'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['institute_select'])) {
                            $query->where('institute_id', $data['institute_select']);
                        }
                    });
            }
        }

        return $filters;
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('viewMore')
                ->label(__('system.action.view_more'))
                ->icon('heroicon-o-eye')
                ->action(function ($record) {
                    return redirect()->route('filament.admin.pages.cgo-approval-detail', ['id' => $record->id]);
                }),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\Action::make('export')
                ->label('Export')
                ->color('success')
                ->action(function ($livewire) {
                    return static::exportData($livewire->getFilteredTableQuery());
                })
                ->button(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    /**
     * Export data to Excel with professional formatting
     */
    public static function exportData($query): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $results = $query->get();

        if ($results->isEmpty()) {
            Notification::make()
                ->title('No data to export')
                ->warning()
                ->send();
            return redirect()->back();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pending CGO Approvals');

        $highestColumn = 'I';

        // Title
        $sheet->setCellValue('A1', 'PENDING CGO APPROVALS REPORT');
        $sheet->mergeCells("A1:{$highestColumn}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E293B']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Report Time
        $sheet->setCellValue('A2', 'Report Time: ' . now()->format('Y-m-d H:i:s'));
        $sheet->mergeCells("A2:{$highestColumn}2");

        // Period
        $sheet->setCellValue('A3', 'Period: All Time');
        $sheet->mergeCells("A3:{$highestColumn}3");

        // Description
        $sheet->setCellValue('A4', 'Description: This report displays CGO users pending approval.');
        $sheet->mergeCells("A4:{$highestColumn}4");

        $sheet->getStyle('A2:A4')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '475569']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->setCellValue('A5', ''); // Spacer

        // Headers
        $headers = [
            'No.', 'First Name', 'Last Name', 'Email', 'Telephone', 
            'Institute', 'District', 'Requested At', 'Status'
        ];

        foreach ($headers as $colIndex => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $sheet->setCellValue($colLetter . '6', $header);
        }

        $sheet->getStyle("A6:{$highestColumn}6")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '4984F6'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7EFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        $row = 7;
        foreach ($results as $index => $record) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $record->first_name);
            $sheet->setCellValue('C' . $row, $record->last_name);
            $sheet->setCellValue('D' . $row, $record->email);
            $sheet->setCellValue('E' . $row, $record->telephone);
            $sheet->setCellValue('F' . $row, $record->institute?->name ?? 'N/A');
            $sheet->setCellValue('G' . $row, $record->district?->name ?? 'N/A');
            $sheet->setCellValue('H' . $row, $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : '');
            $sheet->setCellValue('I' . $row, $record->statusCgouser());

            $row++;
        }

        $lastDataRow = $row - 1;

        // Styles for data rows
        $sheet->getStyle("A7:{$highestColumn}{$lastDataRow}")->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Left align text descriptions
        foreach (['B', 'C', 'D', 'F', 'G'] as $col) {
            $sheet->getStyle("{$col}7:{$col}{$lastDataRow}")
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }

        // Borders
        $sheet->getStyle("A6:{$highestColumn}{$lastDataRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        // Set Heights
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(15);
        $sheet->getRowDimension(6)->setRowHeight(25);
        for ($r = 7; $r <= $lastDataRow; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(20);
        }

        // Summary Section
        $summaryRow = $lastDataRow + 2;
        $sheet->setCellValue('A' . $summaryRow, 'SUMMARY');
        $sheet->getStyle('A' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1E293B']],
        ]);

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Pending Approvals:');
        $sheet->setCellValue('B' . $summaryRow, $results->count());

        $sheet->getStyle("A" . ($lastDataRow + 3) . ":B" . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '1E293B']],
        ]);

        // Auto-fit column widths
        for ($col = 1; $col <= 9; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $fileName = 'pending_cgo_approvals_export_' . now()->format('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'pending_cgos_');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
