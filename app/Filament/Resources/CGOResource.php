<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CGOResource\Pages;
use App\Filament\Resources\CGOResource\RelationManagers;
use App\Models\CGO;
use App\Models\CgoUser;
use App\Models\Institute;
use App\Models\TvetType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class CGOResource extends Resource
{
    protected static ?string $model = CgoUser::class;

    protected static ?string $navigationLabel = 'CGO';
    protected static ?string $navigationGroup = 'CGO';
    protected static ?int $navigationSort = 1;

    public static $totalCgo;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Define your form schema here
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->hasRole('super_admin');
        $userTvetType = $user->tvet_type;

        $filters = [];

        if ($isSuperAdmin) {
            // Filter for super_admin: can select TVET and Institute
            $filters[] = Tables\Filters\Filter::make('tvet_type')
                ->form([
                    Forms\Components\Select::make('tvet_type')
                        ->label('Head Office')
                        ->options(TvetType::all()->pluck('head_office_name', 'head_office_code'))
                        ->preload()
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('institute_select', null);
                        }),

                    Forms\Components\Select::make('institute_select')
                        ->label('Institute')
                        ->options(function ($get) {
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
                        ->visible(function ($get) {
                            return !empty($get('tvet_type'));
                        }),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['tvet_type'])) {
                        $instituteIds = Institute::where('institute_head_office', $data['tvet_type'])
                            ->orderBy('name', 'asc')
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
            if ($userTvetType) {
                $instituteOptions = Institute::where('institute_head_office', $userTvetType)
                    ->orderBy('name', 'asc')
                    ->pluck('name', 'id')
                    ->toArray();

                $filters[] = Tables\Filters\Filter::make('institute_filter')
                    ->form([
                        Forms\Components\Select::make('institute_select')
                            ->label('Institute')
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

        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth('admin')->user();

                // If not super_admin, only show CGOs belonging to the user's institute
                if (!$user->hasRole('super_admin')) {
                    // Get tvet_type from the admin user
                    $userTvetType = $user->tvet_type;

                    if ($userTvetType) {
                        // Get all institutes belonging to the user's tvet_type
                        $instituteIds = Institute::where('institute_head_office', $userTvetType)
                            ->pluck('id')
                            ->toArray();

                        // Only show CGOs whose institute_id is in the list
                        $query->whereIn('institute_id', $instituteIds);
                    } else {
                        // If the user has no tvet_type, show nothing
                        $query->whereRaw('1 = 0');
                    }
                }
            })
            ->searchPlaceholder('Name or Email')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('institute.name')
                    ->label(__('admin/dashboard.cgo.institute'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('district.name')->label(trans('trainee.job_support.company.table.label.district')) ->sortable(),
                Tables\Columns\TextColumn::make('fullName')
                    ->label(__('admin/dashboard.cgo.name'))
                    ->getStateUsing(fn($record) => $record->fullName ?? 'N/A')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('approval')
                    ->label(__('admin/dashboard.cgo.approval'))
                    ->getStateUsing(function ($record) {
                        return $record->statusCgouser();
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Verified' => "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>",
                        'Request' => "<span style='font-size:12px;color: #a1a1a1; background-color: #dfdada; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Request</span>",
                        default => "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>Rejected</span>",
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger')
            ])
            ->paginated([10, 25, 50, 100])
            ->actions([
                Action::make('deactivate')
                    ->label(__('Deactivate'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => false, 'verify_at' => null, 'verify_by' => auth()->guard('admin')->id()]);
                    })
                    ->hidden(fn ($record) => $record->active === false),
                    //->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
                Action::make('activate')
                    ->label(__('Activate'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => true, 'verify_at' => now(), 'verify_by' => auth()->guard('admin')->id()]);
                    })
                    ->hidden(fn ($record) => $record->active === true),
                    //->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->filters($filters)
            ->striped()
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->preserveScroll()
            ->headerActions([
                Action::make('export')
                    ->label('Export')
                    ->color('success')
                    ->action(function ($livewire) {
                        return static::exportData($livewire->getFilteredTableQuery());
                    })
                    ->button(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCGOS::route('/'),
            'create' => Pages\CreateCGO::route('/create'),
            'view' => Pages\ViewCGO::route('/{record}'),
            'edit' => Pages\EditCGO::route('/{record}/edit'),
        ];
    }

    /**
     * Export data to Excel with professional formatting
     */
    public static function exportData($query): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $results = $query->get();

        if ($results->isEmpty()) {
            \Filament\Notifications\Notification::make()
                ->title('No data to export')
                ->warning()
                ->send();
            return redirect()->back();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('CGO Users');

        $highestColumn = 'J';

        // Title
        $sheet->setCellValue('A1', 'CGO USERS REPORT');
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
        $sheet->setCellValue('A4', 'Description: This report displays registered CGO (Career Guidance Officer) users and their current status.');
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
            'Institute', 'District', 'Approval Status', 'Status', 'Created At'
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
            $sheet->setCellValue('H' . $row, $record->statusCgouser());
            $sheet->setCellValue('I' . $row, $record->active ? 'Active' : 'Inactive');
            $sheet->setCellValue('J' . $row, $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : '');

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
        $sheet->setCellValue('A' . $summaryRow, 'Total CGO Users:');
        $sheet->setCellValue('B' . $summaryRow, $results->count());

        $verifiedCount = $results->filter(fn($c) => $c->statusCgouser() === 'Verified')->count();
        $requestCount = $results->filter(fn($c) => $c->statusCgouser() === 'Request')->count();
        $rejectedCount = $results->filter(fn($c) => !in_array($c->statusCgouser(), ['Verified', 'Request']))->count();

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Verified Users:');
        $sheet->setCellValue('B' . $summaryRow, $verifiedCount);

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Pending Requests:');
        $sheet->setCellValue('B' . $summaryRow, $requestCount);

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Rejected/Other Users:');
        $sheet->setCellValue('B' . $summaryRow, $rejectedCount);

        $sheet->getStyle("A" . ($lastDataRow + 3) . ":B" . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '1E293B']],
        ]);

        // Auto-fit column widths
        for ($col = 1; $col <= 10; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $fileName = 'cgo_export_' . now()->format('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'cgos_');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
