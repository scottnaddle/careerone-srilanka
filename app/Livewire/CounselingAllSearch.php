<?php

namespace App\Livewire;

use App\Models\District;
use App\Models\Institute;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;

class CounselingAllSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $sector = '';
    public $startDate = '';
    public $endDate = '';
    public $district = '';
    public $counselingField = '';
    public $counselingType = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'sector' => ['except' => ''],
        'district' => ['except' => ''],
        'counselingField' => ['except' => ''],
        'counselingType' => ['except' => ''],
    ];
    protected $listeners = ['export-requested' => 'export'];

    public function mount($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate ?? request()->query('startDate', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $this->endDate = $endDate ?? request()->query('endDate', Carbon::now()->endOfMonth()->format('Y-m-d'));
    }

    /**
     * Get the list of districts based on the user's role
     */
    private function getAccessibleDistricts()
    {
        $user = Auth::guard('admin')->user();

        if ($user->hasRole('super_admin')) {
            return District::query();
        }

        $instituteIds = $user->institutes->pluck('id')->toArray();

        $districtIds = Institute::whereIn('id', $instituteIds)
            ->whereNotNull('dist_id')
            ->pluck('dist_id')
            ->unique()
            ->toArray();

        if (empty($districtIds)) {
            return District::query()->whereRaw('1 = 0');
        }

        return District::whereIn('id', $districtIds);
    }

    /**
     * Get the filtered district data
     */
    public function getFilteredDistricts()
    {
        $districtQuery = $this->getAccessibleDistricts();

        return $districtQuery
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->sector, function ($query) {
                $query->where('sector_id', $this->sector);
            })
            ->when($this->district, function ($query) {
                $query->where('id', $this->district);
            })
            ->with(['counselings' => function ($query) {
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($this->startDate)->startOfDay(),
                        Carbon::parse($this->endDate)->endOfDay()
                    ]);
                }

                $query->where(function ($q) {
                    $q->where('status', '!=', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                        ->orWhere(function ($q2) {
                            $q2->where('status', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                                ->whereNotNull('result');
                        });
                });
            }])
            ->get();
    }

    public function render()
    {
        $language = app()->getLocale();

        $allDistricts = $this->getFilteredDistricts();

        $districts = $allDistricts->filter(function ($district) {
            return $district->counselings->count() > 0;
        })->values();

        $totalRecords = 0;
        foreach ($districts as $district) {
            $totalRecords += $district->counselings->count();
        }

        $counselingType = getCodeList('counselling_type', $language);
        $counselingField = getCodeList('counselling_field', $language);

        $user = Auth::guard('admin')->user();
        $isSuperAdmin = $user->hasRole('super_admin');

        return view('livewire.counseling-all-search', [
            'districts' => $districts,
            'allDistrictsCount' => $allDistricts->count(),
            'showCounselingType' => $counselingType,
            'showCounselingField' => $counselingField,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'totalRecords' => $totalRecords,
            'isSuperAdmin' => $isSuperAdmin,
            'accessibleDistrictCount' => $allDistricts->count(),
        ]);
    }

    /**
     * Convert column number to letter (0-based)
     * Example: 0 => 'A', 1 => 'B', 25 => 'Z', 26 => 'AA'
     */
    private function getColumnLetter($columnNumber)
    {
        $letter = '';
        while ($columnNumber >= 0) {
            $letter = chr($columnNumber % 26 + 65) . $letter;
            $columnNumber = floor($columnNumber / 26) - 1;
        }
        return $letter;
    }

    /**
     * Export the data to Excel with professional formatting
     */
    public function export()
    {
        $districts = $this->getFilteredDistricts();

        $districtsWithData = $districts->filter(function ($district) {
            return $district->counselings->count() > 0;
        })->values();

        if ($districtsWithData->isEmpty()) {
            session()->flash('error', 'No data to export');
            return;
        }

        // Get the list of counseling types and fields
        $counselingTypes = getCodeList('counselling_type', app()->getLocale());
        $counselingFields = getCodeList('counselling_field', app()->getLocale());

        $user = Auth::guard('admin')->user();
        $userRole = $user->hasRole('super_admin') ? 'Super Admin' : 'Admin';

        $countTypes = count($counselingTypes);
        $countFields = count($counselingFields);

        // Calculate the total number of columns
        $totalColumns = 3 + $countTypes + $countFields; // No + District + Total + Types + Fields
        $lastColumnLetter = $this->getColumnLetter($totalColumns - 1);

        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the sheet title
        $sheet->setTitle('Counseling Results');

        // ===== TITLE =====
        $sheet->setCellValue('A1', 'COUNSELING REPORT');
        $sheet->mergeCells('A1:' . $lastColumnLetter . '1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // ===== HEADER INFORMATION =====
        $sheet->setCellValue('A2', 'Report Time: ' . now()->format('Y-m-d H:i:s'));
        $sheet->mergeCells('A2:' . $lastColumnLetter . '2');

        $period = 'Period: ' . Carbon::parse($this->startDate)->format('Y-m-d') . ' to ' . Carbon::parse($this->endDate)->format('Y-m-d');
        $sheet->setCellValue('A3', $period);
        $sheet->mergeCells('A3:' . $lastColumnLetter . '3');

        $description = 'Description: This report displays statistics of career guidance counseling records by district, categorized by counseling types and counseling fields.';
        $sheet->setCellValue('A4', $description);
        $sheet->mergeCells('A4:' . $lastColumnLetter . '4');

        $sheet->getStyle('A2:A4')->applyFromArray([
            'font' => [
                'size' => 10,
                'color' => ['rgb' => '475569'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Spacer Row 5
        $sheet->setCellValue('A5', '');

        // ===== MAIN HEADER ROW 6 & 7 =====
        // Column letters coordinate helpers
        $startTypeCol = $this->getColumnLetter(3);
        $endTypeCol = $this->getColumnLetter(3 + $countTypes - 1);
        $startFieldCol = $this->getColumnLetter(3 + $countTypes);
        $endFieldCol = $this->getColumnLetter(3 + $countTypes + $countFields - 1);

        $row6 = [
            __('admin/dashboard.counseling.no'),
            __('admin/dashboard.counseling.table.district'),
            __('admin/dashboard.counseling.table.counseling'),
        ];

        // Fill remaining row6 cells
        for ($i = 3; $i < $totalColumns; $i++) {
            $row6[] = '';
        }

        foreach ($row6 as $colIndex => $val) {
            $colLetter = $this->getColumnLetter($colIndex);
            $sheet->setCellValue($colLetter . '6', $val);
        }

        // Set top group headers text
        $sheet->setCellValue($startTypeCol . '6', __('admin/dashboard.counseling.table.counseling_type'));
        $sheet->setCellValue($startFieldCol . '6', __('admin/dashboard.counseling.table.counseling_field'));

        // Fill Row 7 values
        $row7 = ['', '', ''];
        foreach ($counselingTypes as $type) {
            $row7[] = $type->code_name;
        }
        foreach ($counselingFields as $field) {
            $row7[] = $field->code_name;
        }

        foreach ($row7 as $colIndex => $val) {
            $colLetter = $this->getColumnLetter($colIndex);
            $sheet->setCellValue($colLetter . '7', $val);
        }

        // Merges for double-row headers
        $sheet->mergeCells('A6:A7');
        $sheet->mergeCells('B6:B7');
        $sheet->mergeCells('C6:C7');
        if ($countTypes > 1) {
            $sheet->mergeCells("{$startTypeCol}6:{$endTypeCol}6");
        }
        if ($countFields > 1) {
            $sheet->mergeCells("{$startFieldCol}6:{$endFieldCol}6");
        }

        // Apply main header style
        $sheet->getStyle('A6:' . $lastColumnLetter . '7')->applyFromArray([
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

        // ===== DATA ROWS =====
        $row = 8;
        $totalCounselings = 0;
        $districtTotals = [];

        foreach ($districtsWithData as $index => $district) {
            // No.
            $sheet->setCellValue('A' . $row, $index + 1);

            // District name
            $sheet->setCellValue('B' . $row, $district->name);

            // Total counseling
            $totalForDistrict = $district->counselings->count();
            $sheet->setCellValue('C' . $row, $totalForDistrict);
            $totalCounselings += $totalForDistrict;
            $districtTotals[$district->name] = $totalForDistrict;

            // Counseling type counts
            $colIndex = 3;
            foreach ($counselingTypes as $type) {
                $count = $district->countCounselingFCodeId(
                    $type->code_id,
                    'counseling_type',
                    $this->startDate,
                    $this->endDate
                );
                $sheet->setCellValue($this->getColumnLetter($colIndex) . $row, $count);
                $colIndex++;
            }

            // Counseling field counts
            foreach ($counselingFields as $field) {
                $count = $district->countCounselingFCodeId(
                    $field->code_id,
                    'counseling_field_id',
                    $this->startDate,
                    $this->endDate
                );
                $sheet->setCellValue($this->getColumnLetter($colIndex) . $row, $count);
                $colIndex++;
            }

            $row++;
        }

        $lastDataRow = $row - 1;

        // Apply data rows style
        $sheet->getStyle('A8:' . $lastColumnLetter . $lastDataRow)->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Left align District Name column
        $sheet->getStyle('B8:B' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // ===== BORDERS =====
        $sheet->getStyle('A6:' . $lastColumnLetter . $lastDataRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        // Set row heights
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(15);
        $sheet->getRowDimension(6)->setRowHeight(25);
        $sheet->getRowDimension(7)->setRowHeight(25);
        for ($r = 8; $r <= $lastDataRow; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(20);
        }

        // ===== SUMMARY SECTION =====
        $summaryStartRow = $lastDataRow + 2;

        // Summary title
        $sheet->setCellValue('A' . $summaryStartRow, 'SUMMARY');
        $sheet->getStyle('A' . $summaryStartRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'Total Counseling Records:');
        $sheet->setCellValue('B' . $summaryStartRow, $totalCounselings);
        $sheet->getStyle("A{$summaryStartRow}:B{$summaryStartRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'Total Districts:');
        $sheet->setCellValue('B' . $summaryStartRow, $districtsWithData->count());
        $sheet->getStyle("A{$summaryStartRow}:B{$summaryStartRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Add district breakdown
        $summaryStartRow += 2;
        $sheet->setCellValue('A' . $summaryStartRow, 'District Breakdown');
        $sheet->getStyle('A' . $summaryStartRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '1E293B'],
            ],
        ]);

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'District');
        $sheet->setCellValue('B' . $summaryStartRow, 'Total Counselings');
        $sheet->getStyle('A' . $summaryStartRow . ':B' . $summaryStartRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '4984F6'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7EFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $breakdownStartRow = $summaryStartRow;

        foreach ($districtTotals as $districtName => $total) {
            $summaryStartRow++;
            $sheet->setCellValue('A' . $summaryStartRow, $districtName);
            $sheet->setCellValue('B' . $summaryStartRow, $total);
        }

        // Style breakdown data rows
        $sheet->getStyle('A' . ($breakdownStartRow + 1) . ':B' . $summaryStartRow)->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A' . ($breakdownStartRow + 1) . ':A' . $summaryStartRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Apply borders to breakdown table
        $sheet->getStyle('A' . $breakdownStartRow . ':B' . $summaryStartRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        // Auto size columns dynamically (handles Z, AA, AB, etc.)
        for ($col = 1; $col <= $totalColumns; $col++) {
            $colLetter = $this->getColumnLetter($col - 1);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // ===== FREEZE PANE =====
        $sheet->freezePane('D8');

        // ===== SAVE AND DOWNLOAD =====
        $fileName = 'counseling_results_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'counseling_');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSector()
    {
        $this->resetPage();
    }

    public function updatingDistrict()
    {
        $this->resetPage();
    }
}
