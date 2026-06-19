<?php

namespace App\Filament\Resources;

use App\Exports\ApprovedCgoUserExporter;
use App\Filament\Resources\ApprovedCGODetailResource\Pages;
use App\Filament\Resources\ApprovedCGODetailResource\RelationManagers;
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

class ApprovedCGODetailResource extends Resource
{
    protected static ?string $model = CgoUser::class;
    protected static ?string $modelLabel = 'Approved CGO Details';
//    protected static ?string $breadcrumb = 'Membership > CGO > Approved CGO Details';
    protected static ?string $navigationGroup = 'Membership';
    protected static ?string $navigationLabel = 'Approved CGO Details';
    protected static ?string $navigationParentItem = 'CGO';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string {
        return trans('menu.approved_cgo_details');
    }

    public static $totalCgo;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    public static function getEloquentQuery(): Builder {

        // Eager-load institute/district (used by *.name columns) and count the
        // related rows up-front to avoid N+1 queries per row.
        return CgoUser::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true)
            ->with(['institute', 'district'])
            ->withCount(['counselings', 'countCancelCounseling', 'events', 'contents', 'qnaAnswes']);

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
            ->searchPlaceholder('Name')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('institute.name')
                    ->label(__('admin/dashboard.cgo.institute'))
                    ->sortable()->limit('50'),
                Tables\Columns\TextColumn::make('district.name')->label(trans('trainee.job_support.company.table.label.district')) ->sortable(),
                Tables\Columns\TextColumn::make('fullName')
                    ->label(__('admin/dashboard.cgo.name'))
                    ->getStateUsing(fn($record) => $record->fullName ?? 'N/A')
                    ->searchable(['first_name', 'last_name']),
//                Tables\Columns\TextColumn::make('counseling')
//                    ->getStateUsing(fn($record) => $record->counselings->count())
//                    ->label(__('admin/dashboard.cgo.guidance'))
//                    ->alignCenter(),
//
//                Tables\Columns\TextColumn::make('cancel')->label(__('admin/dashboard.cgo.cancel'))
//                    ->getStateUsing(fn($record) => $record->countCancelCounseling->count() ?? 'N/A')->alignCenter(),
//                Tables\Columns\TextColumn::make('event')->label(__('admin/dashboard.cgo.event'))
//                    ->getStateUsing(fn($record) => $record->events->count() ?? 'N/A') ->alignCenter(),
//                Tables\Columns\TextColumn::make('content')->label(__('admin/dashboard.cgo.content'))
//                    ->getStateUsing(fn($record) => $record->contents->count() ?? 'N/A') ->alignCenter(),
//                Tables\Columns\TextColumn::make('reply')->label(__('admin/dashboard.cgo.reply'))
//                    ->getStateUsing(fn($record) => $record->qnaAnswes->count() ?? 'N/A') ->alignCenter(),
                // Counseling column
                Tables\Columns\TextColumn::make('counseling')
                    ->label(__('admin/dashboard.cgo.guidance'))
                    ->getStateUsing(fn($record) => $record->counselings_count)
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('counselings')->orderBy('counselings_count', $direction);
                    }),

                // Cancel column
                Tables\Columns\TextColumn::make('cancel')
                    ->label(__('admin/dashboard.cgo.cancel'))
                    ->getStateUsing(fn($record) => $record->count_cancel_counseling_count ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('countCancelCounseling')->orderBy('count_cancel_counseling_count', $direction);
                    }),

                // Event column
                Tables\Columns\TextColumn::make('event')
                    ->label(__('admin/dashboard.cgo.event'))
                    ->getStateUsing(fn($record) => $record->events_count ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('events')->orderBy('events_count', $direction);
                    }),

                // Content column
                Tables\Columns\TextColumn::make('content')
                    ->label(__('admin/dashboard.cgo.content'))
                    ->getStateUsing(fn($record) => $record->contents_count ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('contents')->orderBy('contents_count', $direction);
                    }),

                // Reply column
                Tables\Columns\TextColumn::make('reply')
                    ->label(__('admin/dashboard.cgo.reply'))
                    ->getStateUsing(fn($record) => $record->qna_answes_count ?? 'N/A')
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->withCount('qnaAnswes')->orderBy('qna_answes_count', $direction);
                    }),
            ])->paginated([10, 25, 50, 100])
            ->actions([
            ])
            ->filters($filters)
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->headerActions([
                Action::make('export')
                    ->label('Export')
                    ->color('success')
                    ->action(function ($livewire) {
                        return static::exportData($livewire->getFilteredTableQuery());
                    })
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // Example of user-based query modification
                // $user = auth('admin')->user();
                // if (!$user->hasRole('SuperAdmin')) {
                //     $query->where('institute_id', $user->institute_id);
                // }
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovedCGODetails::route('/'),
//            'create' => Pages\CreateApprovedCGODetail::route('/create'),
//            'edit' => Pages\EditApprovedCGODetail::route('/{record}/edit'),
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
        $sheet->setTitle('Approved CGO Details');

        $highestColumn = 'N'; // We have 14 columns

        // Title
        $sheet->setCellValue('A1', 'APPROVED CGO DETAILS REPORT');
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
        $sheet->setCellValue('A4', 'Description: This report displays detailed statistics of approved and active CGO users.');
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
            'Institute', 'District', 'Guidance', 'Cancel', 'Event', 
            'Content', 'Reply', 'Created At', 'Verified At'
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
            $sheet->setCellValue('H' . $row, $record->counselings->count());
            $sheet->setCellValue('I' . $row, $record->countCancelCounseling->count());
            $sheet->setCellValue('J' . $row, $record->events->count());
            $sheet->setCellValue('K' . $row, $record->contents->count());
            $sheet->setCellValue('L' . $row, $record->qnaAnswes->count());
            $sheet->setCellValue('M' . $row, $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : '');
            
            $verifiedAt = '';
            if ($record->verify_at) {
                try {
                    $verifiedAt = \Carbon\Carbon::parse($record->verify_at)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $verifiedAt = $record->verify_at;
                }
            }
            $sheet->setCellValue('N' . $row, $verifiedAt);

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
        $sheet->setCellValue('A' . $summaryRow, 'Total Approved CGO Users:');
        $sheet->setCellValue('B' . $summaryRow, $results->count());

        $totalGuidance = $results->sum(fn($r) => $r->counselings->count());
        $totalEvents = $results->sum(fn($r) => $r->events->count());

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Guidance Sessions:');
        $sheet->setCellValue('B' . $summaryRow, $totalGuidance);

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Events Conducted:');
        $sheet->setCellValue('B' . $summaryRow, $totalEvents);

        $sheet->getStyle("A" . ($lastDataRow + 3) . ":B" . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '1E293B']],
        ]);

        // Auto-fit column widths
        for ($col = 1; $col <= 14; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $fileName = 'approved_cgo_export_' . now()->format('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'approved_cgos_');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
