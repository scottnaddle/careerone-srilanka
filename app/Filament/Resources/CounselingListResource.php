<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselingListResource\Pages;
use App\Models\CgoCounseling;
use App\Models\District;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CounselingListResource extends Resource
{
    protected static ?string $model = CgoCounseling::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countContentList;
    protected static ?string $modelLabel = 'Career Guidance';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        // Initialize the base query instead of using the service
        $baseQuery = CgoCounseling::query()
            ->select('cgo_counselings.*')
            ->join('institutes', 'institutes.id', '=', 'cgo_counselings.institute_id')
            ->where(function (Builder $query) {
                $query->where('cgo_counselings.status', '!=', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                    ->orWhere(function (Builder $query) {
                        $query->where('cgo_counselings.status', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                            ->whereNotNull('cgo_counselings.result');
                    });
            });

        return $table
            ->query($baseQuery)
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                TextColumn::make('counseling_type')
                    ->sortable()
                    ->label(__('admin/dashboard.counseling.detail.type'))
                    ->getStateUsing(function ($record) {
                        return getCodeNameByCodeId('counselling_type', $record->counseling_type) ?? 'N/A';
                    }),

                TextColumn::make('counseling_field_id')
                    ->label(__('admin/dashboard.counseling.detail.counseling_field'))
                    ->getStateUsing(function ($record) {
                        return getCodeNameByCodeId('counselling_field', $record->counseling_field_id) ?? 'N/A';
                    })
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('admin/dashboard.counseling.detail.title'))
                    ->searchable() // Filament automatically applies "ilike %search%" to this column
                    ->limit(50)
                    ->sortable(),

                TextColumn::make('registration_date')
                    ->label(__('admin/dashboard.counseling.detail.registraton_date'))
                    ->sortable(),

                TextColumn::make('available_time')
                    ->label(__('admin/dashboard.counseling.detail.counseling_date'))
                    ->sortable(),

                TextColumn::make('institute.name')
                    ->label(__('admin/dashboard.counseling.detail.trainee_institute'))
                    ->sortable(),

                TextColumn::make('trainee_name.full_name')
                    ->label(__('admin/dashboard.counseling.detail.trainee_name'))
                    ->getStateUsing(function ($record) {
                        if ($record->trainee_id == null) {
                            return $record->trainee_offline_firstname . ' ' . $record->trainee_offline_lastname;
                        } else {
                            return $record->traineeUser?->fullName;
                        }
                    }),
            ])
            ->paginated([10, 25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->label('District')
                    ->options(District::pluck('name', 'id')->toArray())
                    ->searchable()
                    // Put the district filter logic here
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->where('institutes.dist_id', '=', $data['value']);
                        }
                    }),

                Tables\Filters\SelectFilter::make('head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))
                    ->options(
                        \App\Models\TvetType::query()
                            ->orderBy('head_office_name')
                            ->get()
                            ->mapWithKeys(fn ($item) => [
                                $item->head_office_code => $item->head_office_name . ' (' . $item->head_office_code . ')'
                            ])
                            ->toArray()
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('institute.tvetType', function ($q) use ($data) {
                                $q->where('head_office_code', $data['value']);
                            });
                        }
                    })->visible(fn () => auth('admin')->user()->hasRole('super_admin')),

                Filter::make('custom_date_range')
                    ->label('Date Range')
                    ->form([
                        DatePicker::make('startDate')
                            ->label('Start Date')
                            // Feed data from the URL directly into the Filament input on first page load
                            ->default(request()->query('startDate')),

                        DatePicker::make('endDate')
                            ->label('End Date')
                            // Feed data from the URL directly into the Filament input on first page load
                            ->default(request()->query('endDate')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        // Get from Filament's internal state ($data); if empty (first load), fall back to the URL query directly
                        $startDate = $data['startDate'] ?? request()->query('startDate');
                        $endDate = $data['endDate'] ?? request()->query('endDate');

                        return $query
                            ->when(
                                $startDate,
                                fn (Builder $query, $date) => $query->where('cgo_counselings.created_at', '>=', Carbon::parse($date)->startOfDay())
                            )
                            ->when(
                                $endDate,
                                fn (Builder $query, $date) => $query->where('cgo_counselings.created_at', '<=', Carbon::parse($date)->endOfDay())
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        // Sync the filter label display (the gray tag above the table)
                        $startDate = $data['startDate'] ?? request()->query('startDate');
                        $endDate = $data['endDate'] ?? request()->query('endDate');

                        $indicators = [];
                        if ($startDate) {
                            $indicators[] = 'Start: ' . Carbon::parse($startDate)->format('d/m/Y');
                        }
                        if ($endDate) {
                            $indicators[] = 'End: ' . Carbon::parse($endDate)->format('d/m/Y');
                        }
                        return $indicators;
                    }),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export')
                    ->color('success')
                    ->action(function ($livewire) {
                        $filters = $livewire->tableFilters;
                        $startDate = $filters['custom_date_range']['startDate'] ?? null;
                        $endDate = $filters['custom_date_range']['endDate'] ?? null;
                        return static::exportData($livewire->getFilteredTableQuery(), $startDate, $endDate);
                    })
                    ->button(),
            ])
            ->actions([])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([]);
    }

    /**
     * Export data to Excel with professional formatting
     */
    public static function exportData($query, $startDate = null, $endDate = null): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Get the filtered data
        $results = $query->get();

        if ($results->isEmpty()) {
            Notification::make()
                ->title('No data to export')
                ->warning()
                ->send();
            return redirect()->back();
        }

        // Create a new spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Counseling List');

        $highestColumn = 'H';

        // Write Title
        $sheet->setCellValue('A1', 'CAREER GUIDANCE COUNSELING REPORT');
        $sheet->mergeCells("A1:{$highestColumn}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Write Report Time
        $reportTime = now()->format('Y-m-d H:i:s');
        $sheet->setCellValue('A2', 'Report Time: ' . $reportTime);
        $sheet->mergeCells("A2:{$highestColumn}2");

        // Write Period
        if ($startDate && $endDate) {
            $period = 'Period: ' . Carbon::parse($startDate)->format('Y-m-d') . ' to ' . Carbon::parse($endDate)->format('Y-m-d');
        } else {
            $period = 'Period: All Time';
        }
        $sheet->setCellValue('A3', $period);
        $sheet->mergeCells("A3:{$highestColumn}3");

        // Write Description
        $description = 'Description: This report displays details of career guidance counseling records, including counseling types, fields, registration and available times, and matching trainees/institutes.';
        $sheet->setCellValue('A4', $description);
        $sheet->mergeCells("A4:{$highestColumn}4");

        // Style Report Time, Period, and Description (Rows 2, 3, 4)
        $sheet->getStyle("A2:A4")->applyFromArray([
            'font' => [
                'size' => 10,
                'color' => ['rgb' => '475569'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Spacer Row 5
        $sheet->setCellValue('A5', '');

        // Headers in Row 6
        $headers = [
            __('admin/dashboard.content.no'),
            __('admin/dashboard.counseling.detail.type'),
            __('admin/dashboard.counseling.detail.counseling_field'),
            __('admin/dashboard.counseling.detail.title'),
            __('admin/dashboard.counseling.detail.registraton_date'),
            __('admin/dashboard.counseling.detail.counseling_date'),
            __('admin/dashboard.counseling.detail.trainee_institute'),
            __('admin/dashboard.counseling.detail.trainee_name'),
        ];

        foreach ($headers as $colIndex => $val) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $sheet->setCellValue($colLetter . '6', $val);
        }

        // Style Table Header (Row 6)
        $sheet->getStyle("A6:{$highestColumn}6")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '4984F6'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7EFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        // Write Data Rows
        $currentRow = 7;
        foreach ($results as $index => $record) {
            $counselingType = getCodeNameByCodeId('counselling_type', $record->counseling_type) ?? 'N/A';
            $counselingField = getCodeNameByCodeId('counselling_field', $record->counseling_field_id) ?? 'N/A';

            $traineeName = $record->trainee_id == null
                ? ($record->trainee_offline_firstname . ' ' . $record->trainee_offline_lastname)
                : ($record->traineeUser?->fullName ?? 'N/A');

            $sheet->setCellValue('A' . $currentRow, $index + 1);
            $sheet->setCellValue('B' . $currentRow, $counselingType);
            $sheet->setCellValue('C' . $currentRow, $counselingField);
            $sheet->setCellValue('D' . $currentRow, $record->title ?? 'N/A');
            $sheet->setCellValue('E' . $currentRow, $record->registration_date ? Carbon::parse($record->registration_date)->format('d/m/Y') : 'N/A');
            $sheet->setCellValue('F' . $currentRow, $record->available_time ? Carbon::parse($record->available_time)->format('d/m/Y H:i') : 'N/A');
            $sheet->setCellValue('G' . $currentRow, $record->institute->name ?? 'N/A');
            $sheet->setCellValue('H' . $currentRow, $traineeName);

            $currentRow++;
        }

        $lastDataRow = $currentRow - 1;

        // Style Data Rows
        $sheet->getStyle("A7:{$highestColumn}{$lastDataRow}")->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Left-align text columns
        $sheet->getStyle("B7:D{$lastDataRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("G7:H{$lastDataRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Apply borders to the table section only
        $sheet->getStyle("A6:{$highestColumn}{$lastDataRow}")
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Set row heights
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(15);
        $sheet->getRowDimension(6)->setRowHeight(25);
        for ($row = 7; $row <= $lastDataRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Add Summary Section
        $summaryRow = $lastDataRow + 2;
        $sheet->setCellValue('A' . $summaryRow, 'SUMMARY');
        $sheet->getStyle('A' . $summaryRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $totalRow = $summaryRow + 1;
        $sheet->setCellValue('A' . $totalRow, 'Total Records:');
        $sheet->setCellValue('B' . $totalRow, $results->count());
        $sheet->getStyle("A{$totalRow}:B{$totalRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getRowDimension($summaryRow)->setRowHeight(20);
        $sheet->getRowDimension($totalRow)->setRowHeight(20);

        // Auto size columns
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Save and Download XLSX
        $fileName = 'counseling_list_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $tempFile = tempnam(sys_get_temp_dir(), 'counseling_');
        $writer->save($tempFile);

        Notification::make()
            ->title('Export completed successfully')
            ->body("Exported {$results->count()} records to Excel file")
            ->success()
            ->send();

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCounselingLists::route('/'),
            'view' => Pages\ViewCounselingList::route('/{record}'),
        ];
    }
}
