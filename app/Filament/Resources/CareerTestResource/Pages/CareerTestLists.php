<?php

namespace App\Filament\Resources\CareerTestResource\Pages;

use App\Filament\Resources\CareerTestResource;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\Institute;
use App\Models\TraineeInstitute;
use App\Models\TraineeUser;
use DatePeriod;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Request;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;

class CareerTestLists extends ListRecords
{
    protected static string $resource = CareerTestResource::class;
    protected static string $view = 'filament.pages.career-guidance.carrer-test.carrer-test-trainee-result';

    public ?string $record = null;
    public ?string $period = 'this_month';
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?int $startMonth = null;
    public ?int $startYear = null;
    public ?int $endMonth = null;
    public ?int $endYear = null;

    public function mount(): void
    {
        parent::mount();
        $this->record = request()->route('record');

        // Get filter parameters from the URL
        $this->period = request()->query('period', 'this_month');
        $this->startDate = request()->query('startDate');
        $this->endDate = request()->query('endDate');
        $this->startMonth = request()->query('startMonth');
        $this->startYear = request()->query('startYear');
        $this->endMonth = request()->query('endMonth');
        $this->endYear = request()->query('endYear');

        // Get date range based on all available parameters
        $dates = $this->getDateRangeFromPeriod($this->period);
        $this->startDate = $dates[0] ? $dates[0]->format('Y-m-d') : Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = $dates[1] ? $dates[1]->format('Y-m-d') : Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        $query = $this->getCareerTestTraineeResultsQuery($this->record);

        return $table
            ->query($query)
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->columns([
                TextColumn::make('test_type')
                    ->label(__('admin/career_test.career_test.table.career_test'))
                    ->getStateUsing(function ($record) {
                        return getCodeNameByCodeId('career_test_type', $record->careerTest->test_type) ?? 'N/A';
                    })->sortable(),
                TextColumn::make('institute.name')
                    ->label(__('admin/career_test.career_test.table.trainee_institute')),
                TextColumn::make('fullName')
                    ->label(__('admin/career_test.career_test.table.trainee_name'))
                    ->getStateUsing(function ($record) {
                        return $record->name ?? '';
                    }),
                TextColumn::make('created_at')
                    ->label(__('admin/career_test.career_test.table.date_of_test'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approval')
                    ->label(__('admin/career_test.career_test.table.result'))
                    ->getStateUsing(function ($record) {
                        return $record->test_type == 1 || $record->test_type == 2 ? 'View More' : 'Download';
                    })
                    ->formatStateUsing(function ($state, $record) {
                        if ($state === 'View More') {
                            return "<a target='_blank' href='" . route('admin.career-test.view-result', ['id' => $record->id]) . "'
                                        class='text-blue-500 flex items-center gap-1 font-medium'>
                                        " . __('admin/career_test.career_test.view_details') . "
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'
                                            stroke-width='2' stroke='currentColor' class='size-5'>
                                            <path stroke-linecap='round' stroke-linejoin='round' d='M9 5l7 7-7 7' />
                                        </svg>
                                    </a>";
                        } else if ($state === 'Download') {
                            return "<a href='" . route('admin.career-test.download-result', ['id' => $record->id]) . "' target='_blank'
                                        class='text-primary text-base md:text-base flex items-center gap-1'>$state
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'
                                            stroke-width='1.5' stroke='currentColor' class='size-4'>
                                            <path stroke-linecap='round' stroke-linejoin='round'
                                                d='M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3' />
                                        </svg>
                                    </a>";
                        }
                    })
                    ->html(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('test_type')
                    ->preload()
                    ->options(function () {
                        $testTypes = getCodeList('career_test_type');
                        $option = [];
                        foreach ($testTypes as $type) {
                            $option[$type->code_id] = $type->code_name;
                        }
                        return $option;
                    })
                    ->searchable(),

                // Filter by date range
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('From Date')
                            ->default($this->startDate),
                        DatePicker::make('date_to')
                            ->label('To Date')
                            ->default($this->endDate),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['date_to'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['date_from'] ?? null) {
                            $indicators['date_from'] = 'From: ' . Carbon::parse($data['date_from'])->format('d/m/Y');
                        }
                        if ($data['date_to'] ?? null) {
                            $indicators['date_to'] = 'To: ' . Carbon::parse($data['date_to'])->format('d/m/Y');
                        }
                        return $indicators;
                    }),

                Tables\Filters\Filter::make('month_filter')
                    ->form([
                        DatePicker::make('month')
                            ->label('Select Month')
                            ->format('Y-m')
                            ->displayFormat('F Y'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['month'])) {
                            $date = Carbon::parse($data['month']);
                            $query->whereYear('created_at', $date->year)
                                ->whereMonth('created_at', $date->month);
                        }
                    }),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($livewire) {
                        return $this->exportToExcel($livewire->getFilteredTableQuery());
                    })
                    ->button(),
            ]);
    }

    /**
     * Get date range from period with support for month/year custom parameters
     */
    private function getDateRangeFromPeriod($period): array
    {
        $now = Carbon::now();

        // If startDate and endDate are provided directly, use them
        if ($this->startDate && $this->endDate && $period !== 'custom') {
            try {
                return [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ];
            } catch (\Exception $e) {
                // Fallback if dates are invalid
            }
        }

        switch ($period) {
            case 'today':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay()];

            case 'this_week':
                return [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()];

            case 'this_month':
                // If custom month/year provided, use them
                if ($this->startMonth && $this->startYear) {
                    try {
                        $startDate = Carbon::createFromDate($this->startYear, $this->startMonth, 1)->startOfMonth();
                        $endMonth = $this->endMonth ?? $this->startMonth;
                        $endYear = $this->endYear ?? $this->startYear;
                        $endDate = Carbon::createFromDate($endYear, $endMonth, 1)->endOfMonth();
                        return [$startDate, $endDate];
                    } catch (\Exception $e) {
                        // Fallback to current month
                    }
                }
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];

            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                return [$lastMonth->startOfMonth(), $lastMonth->endOfMonth()];

            case 'this_quarter':
                return [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()];

            case 'this_year':
                // Use the year from startDate if available, otherwise current year
                if ($this->startDate) {
                    try {
                        $year = Carbon::parse($this->startDate)->year;
                        return [
                            Carbon::createFromDate($year, 1, 1)->startOfDay(),
                            Carbon::createFromDate($year, 12, 31)->endOfDay()
                        ];
                    } catch (\Exception $e) {
                        // Fallback to current year
                    }
                }
                if ($this->startYear) {
                    try {
                        return [
                            Carbon::createFromDate($this->startYear, 1, 1)->startOfDay(),
                            Carbon::createFromDate($this->startYear, 12, 31)->endOfDay()
                        ];
                    } catch (\Exception $e) {
                        // Fallback to current year
                    }
                }
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];

            case 'custom':
                // Priority 1: Direct startDate/endDate parameters
                if ($this->startDate && $this->endDate) {
                    try {
                        return [
                            Carbon::parse($this->startDate)->startOfDay(),
                            Carbon::parse($this->endDate)->endOfDay()
                        ];
                    } catch (\Exception $e) {
                        // Fallback
                    }
                }

                // Priority 2: Month/Year parameters
                if ($this->startMonth && $this->startYear) {
                    try {
                        $startDate = Carbon::createFromDate($this->startYear, $this->startMonth, 1)->startOfMonth();
                        $endMonth = $this->endMonth ?? $this->startMonth;
                        $endYear = $this->endYear ?? $this->startYear;
                        $endDate = Carbon::createFromDate($endYear, $endMonth, 1)->endOfMonth();
                        return [$startDate, $endDate];
                    } catch (\Exception $e) {
                        // Fallback
                    }
                }

                // Fallback: Current month
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];

            default:
                // For unknown periods, check if dates are provided
                if ($this->startDate && $this->endDate) {
                    try {
                        return [
                            Carbon::parse($this->startDate)->startOfDay(),
                            Carbon::parse($this->endDate)->endOfDay()
                        ];
                    } catch (\Exception $e) {
                        // Fallback
                    }
                }
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
        }
    }

    /**
     * Get period label for display
     */
    private function getPeriodLabel($period): string
    {
        $labels = [
            'today' => 'Today',
            'this_week' => 'This Week',
            'this_month' => 'This Month',
            'last_month' => 'Last Month',
            'this_quarter' => 'This Quarter',
            'this_year' => 'This Year',
            'custom' => 'Custom Range'
        ];

        return $labels[$period] ?? 'This Month';
    }

    /**
     * Export data to an Excel file with clickable hyperlinks
     */
    public function exportToExcel($query)
    {
        // Get the filtered data
        $results = $query->get();

        if ($results->isEmpty()) {
            Notification::make()
                ->title('No data to export')
                ->warning()
                ->send();
            return;
        }

        // Get the institute name
        $instituteName = Institute::find($this->record)?->name ?? 'All Institutes';

        // Get the date range for the export header
        $periodLabel = $this->getPeriodLabel($this->period);

        // Format the date range for display
        $dateRangeText = Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y');

        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the sheet title
        $sheet->setTitle('Career Test Results');

        // ===== TITLE =====
        $sheet->setCellValue('A1', 'CAREER TEST RESULTS REPORT');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // ===== HEADER INFORMATION =====
        $infoRow = 3;

        $sheet->setCellValue('A' . $infoRow, 'Export Date:');
        $sheet->setCellValue('B' . $infoRow, Carbon::now()->format('d/m/Y H:i:s'));
        $sheet->getStyle('A' . $infoRow)->getFont()->setBold(true);

        $infoRow++;
        $sheet->setCellValue('A' . $infoRow, 'Institute:');
        $sheet->setCellValue('B' . $infoRow, $instituteName);
        $sheet->getStyle('A' . $infoRow)->getFont()->setBold(true);

        $infoRow++;
        $sheet->setCellValue('A' . $infoRow, 'Period:');
        $sheet->setCellValue('B' . $infoRow, $periodLabel);
        $sheet->getStyle('A' . $infoRow)->getFont()->setBold(true);

        $infoRow++;
        $sheet->setCellValue('A' . $infoRow, 'Date Range:');
        $sheet->setCellValue('B' . $infoRow, $dateRangeText);
        $sheet->getStyle('A' . $infoRow)->getFont()->setBold(true);

        $infoRow++;
        $sheet->setCellValue('A' . $infoRow, 'Total Records:');
        $sheet->setCellValue('B' . $infoRow, $results->count());
        $sheet->getStyle('A' . $infoRow)->getFont()->setBold(true);

        // ===== MAIN HEADER =====
        $headerRow = $infoRow + 2;
        $headers = [
            'A' => 'No.',
            'B' => 'Career Test',
            'C' => 'Trainee Institute',
            'D' => 'Trainee Name',
            'E' => 'Test Date',
            'F' => 'Result Type',
            'G' => 'Result Link',
        ];

        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col . $headerRow, $header);
        }

        // Style cho header columns
        $headerStyle = $sheet->getStyle('A' . $headerRow . ':G' . $headerRow);
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setRGB('4F46E5');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $headerStyle->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension($headerRow)->setRowHeight(25);

        // ===== DATA ROWS =====
        $row = $headerRow + 1;
        foreach ($results as $index => $record) {
            $testType = getCodeNameByCodeId('career_test_type', $record->careerTest->test_type) ?? 'N/A';

            // Determine the type and link
            if ($record->test_type == 1 || $record->test_type == 2) {
                $resultType = 'View Online';
                $resultUrl = route('admin.career-test.view-result', ['id' => $record->id]);
            } else {
                $resultType = 'Download PDF';
                $resultUrl = route('admin.career-test.download-result', ['id' => $record->id]);
            }

            // Fill in the data
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $testType);
            $sheet->setCellValue('C' . $row, $record->institute->name ?? 'N/A');
            $sheet->setCellValue('D' . $row, $record->name ?? 'N/A');
            $sheet->setCellValue('E' . $row, Carbon::parse($record->created_at)->format('d/m/Y'));
            $sheet->setCellValue('F' . $row, $resultType);

            // Create a clickable hyperlink in Excel
            $cell = $sheet->getCell('G' . $row);
            $cell->setValue('Click to View Result');
            $cell->getHyperlink()->setUrl($resultUrl);
            $cell->getHyperlink()->setTooltip('Click to view career test result for: ' . ($record->name ?? 'N/A'));

            // Style cho hyperlink cell
            $cell->getStyle()->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE));
            $cell->getStyle()->getFont()->setUnderline(Font::UNDERLINE_SINGLE);
            $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Alternating row colors
            if ($index % 2 == 0) {
                $sheet->getStyle('A' . $row . ':G' . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F3F4F6');
            }

            $row++;
        }

        // ===== STYLE BORDERS =====
        $lastDataRow = $row - 1;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ];
        $sheet->getStyle('A' . $headerRow . ':G' . $lastDataRow)->applyFromArray($styleArray);

        // ===== AUTO WIDTH =====
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set minimum width
        $sheet->getColumnDimension('G')->setWidth(25);

        // ===== ALIGNMENT =====
        $sheet->getStyle('A' . $headerRow . ':A' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E' . $headerRow . ':G' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ===== SUMMARY SECTION =====
        $summaryRow = $lastDataRow + 3;

        $sheet->setCellValue('A' . $summaryRow, 'SUMMARY');
        $sheet->mergeCells('A' . $summaryRow . ':B' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A' . $summaryRow)->getFont()->getColor()->setRGB('1F2937');

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Records:');
        $sheet->setCellValue('B' . $summaryRow, $results->count());
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);

        $summaryRow++;
        $viewOnlineCount = $results->filter(function($record) {
            return $record->test_type == 1 || $record->test_type == 2;
        })->count();
        $sheet->setCellValue('A' . $summaryRow, 'View Online Results:');
        $sheet->setCellValue('B' . $summaryRow, $viewOnlineCount);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);

        $summaryRow++;
        $downloadPdfCount = $results->filter(function($record) {
            return !($record->test_type == 1 || $record->test_type == 2);
        })->count();
        $sheet->setCellValue('A' . $summaryRow, 'Download PDF Results:');
        $sheet->setCellValue('B' . $summaryRow, $downloadPdfCount);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);

        // ===== FREEZE PANE =====
        $sheet->freezePane('A' . ($headerRow + 1));

        // ===== SAVE AND DOWNLOAD =====
        $fileName = 'career_test_results_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'career_test_');
        $writer->save($tempFile);

        // Send a success notification
        Notification::make()
            ->title('Export completed successfully')
            ->body("Exported {$results->count()} records to Excel file with clickable links")
            ->success()
            ->send();

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Get the query for Career Test Trainee Results with date filtering
     */
    public function getCareerTestTraineeResultsQuery($id)
    {
        $query = CareerTestTraineeResult::query()
            ->with(['careerTest', 'trainee', 'institute']);

        // Filter by institute
        if ($id) {
            $query->where('institute_id', $id);
        }

        // Apply date range filter using the determined startDate and endDate
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        }

        return $query;
    }
}
