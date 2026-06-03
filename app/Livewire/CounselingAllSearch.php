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
     * Lấy danh sách districts dựa trên role của user
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
     * Lấy dữ liệu districts đã được filter
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
     * Export dữ liệu ra Excel với định dạng chuyên nghiệp
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

        // Lấy danh sách counseling types và fields
        $counselingTypes = getCodeList('counselling_type', app()->getLocale());
        $counselingFields = getCodeList('counselling_field', app()->getLocale());

        $user = Auth::guard('admin')->user();
        $userRole = $user->hasRole('super_admin') ? 'Super Admin' : 'Admin';

        // Tính tổng số cột
        $totalColumns = 3 + count($counselingTypes) + count($counselingFields); // No + District + Total + Types + Fields
        $lastColumnLetter = $this->getColumnLetter($totalColumns - 1);

        // Tạo Spreadsheet mới
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set tiêu đề sheet
        $sheet->setTitle('Counseling Results');

        // ===== STYLE DEFINITIONS =====
        $infoHeaderStyle = [
            'font' => ['bold' => true, 'size' => 11],
        ];

        $mainHeaderStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2B579A'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '1F2937'],
            ],
        ];

        // ===== TITLE =====
        $sheet->setCellValue('A1', 'COUNSELING REPORT');
        $sheet->mergeCells('A1:' . $lastColumnLetter . '1');
        $sheet->getStyle('A1')->applyFromArray($titleStyle);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // ===== HEADER INFORMATION =====
        $infoRow = 3;
        $sheet->setCellValue('A' . $infoRow, 'Export Date:');
        $sheet->setCellValue('B' . $infoRow, Carbon::now()->format('d/m/Y H:i:s'));
        $sheet->getStyle('A' . $infoRow)->applyFromArray($infoHeaderStyle);

        $infoRow++;
        $sheet->setCellValue('A' . $infoRow, 'User Role:');
        $sheet->setCellValue('B' . $infoRow, $userRole);
        $sheet->getStyle('A' . $infoRow)->applyFromArray($infoHeaderStyle);

        $infoRow++;
        $sheet->setCellValue('A' . $infoRow, 'Date Range:');
        $sheet->setCellValue('B' . $infoRow, Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y'));
        $sheet->getStyle('A' . $infoRow)->applyFromArray($infoHeaderStyle);

        $infoRow++;
        $sheet->setCellValue('A' . $infoRow, 'Total Districts with Data:');
        $sheet->setCellValue('B' . $infoRow, $districtsWithData->count());
        $sheet->getStyle('A' . $infoRow)->applyFromArray($infoHeaderStyle);

        // ===== MAIN HEADER =====
        $headerRow = $infoRow + 2;

        // Fixed columns
        $sheet->setCellValue('A' . $headerRow, 'No.');
        $sheet->setCellValue('B' . $headerRow, 'District');
        $sheet->setCellValue('C' . $headerRow, 'Total Counseling');

        // Counseling type columns
        $colIndex = 3; // Start from 4th column (0-based index 3 = column D)
        foreach ($counselingTypes as $type) {
            $sheet->setCellValue($this->getColumnLetter($colIndex) . $headerRow, $type->code_name);
            $colIndex++;
        }

        // Counseling field columns
        foreach ($counselingFields as $field) {
            $sheet->setCellValue($this->getColumnLetter($colIndex) . $headerRow, $field->code_name);
            $colIndex++;
        }

        // Apply main header style
        $sheet->getStyle('A' . $headerRow . ':' . $lastColumnLetter . $headerRow)->applyFromArray($mainHeaderStyle);
        $sheet->getRowDimension($headerRow)->setRowHeight(35);

        // Add note for column types
        $noteRow = $headerRow + 1;
        $sheet->setCellValue('A' . $noteRow, '');
        $sheet->setCellValue('B' . $noteRow, '');
        $sheet->setCellValue('C' . $noteRow, '');

        // Add type indicator
        $colIndex = 3;
        foreach ($counselingTypes as $type) {
            $colLetter = $this->getColumnLetter($colIndex);
            $sheet->setCellValue($colLetter . $noteRow, '(Type)');
            $sheet->getStyle($colLetter . $noteRow)->getFont()->setItalic(true)->setSize(9);
            $sheet->getStyle($colLetter . $noteRow)->getFont()->getColor()->setRGB('6B7280');
            $colIndex++;
        }

        foreach ($counselingFields as $field) {
            $colLetter = $this->getColumnLetter($colIndex);
            $sheet->setCellValue($colLetter . $noteRow, '(Field)');
            $sheet->getStyle($colLetter . $noteRow)->getFont()->setItalic(true)->setSize(9);
            $sheet->getStyle($colLetter . $noteRow)->getFont()->getColor()->setRGB('6B7280');
            $colIndex++;
        }

        // ===== DATA ROWS =====
        $dataStartRow = $noteRow + 1;
        $row = $dataStartRow;
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

            // Alternating row colors
            if ($index % 2 == 0) {
                $sheet->getStyle('A' . $row . ':' . $lastColumnLetter . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F3F4F6');
            }

            $row++;
        }

        $lastDataRow = $row - 1;

        // ===== BORDERS =====
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ];
        $sheet->getStyle('A' . $headerRow . ':' . $lastColumnLetter . $lastDataRow)
            ->applyFromArray($borderStyle);

        // ===== ALIGNMENT =====
        // Center align No., Total Counseling, and all count columns
        $sheet->getStyle('A' . $dataStartRow . ':A' . $lastDataRow)
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C' . $dataStartRow . ':' . $lastColumnLetter . $lastDataRow)
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ===== SUMMARY SECTION =====
        $summaryStartRow = $lastDataRow + 3;

        // Summary title
        $sheet->setCellValue('A' . $summaryStartRow, 'SUMMARY');
        $sheet->mergeCells('A' . $summaryStartRow . ':B' . $summaryStartRow);
        $sheet->getStyle('A' . $summaryStartRow)->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A' . $summaryStartRow)->getFont()->getColor()->setRGB('1F2937');

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'Total Counseling Records:');
        $sheet->setCellValue('C' . $summaryStartRow, $totalCounselings);
        $sheet->getStyle('A' . $summaryStartRow)->applyFromArray($infoHeaderStyle);
        $sheet->getStyle('C' . $summaryStartRow)->getFont()->setBold(true);

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'Total Districts:');
        $sheet->setCellValue('C' . $summaryStartRow, $districtsWithData->count());
        $sheet->getStyle('A' . $summaryStartRow)->applyFromArray($infoHeaderStyle);
        $sheet->getStyle('C' . $summaryStartRow)->getFont()->setBold(true);

        // Add district breakdown
        $summaryStartRow += 2;
        $sheet->setCellValue('A' . $summaryStartRow, 'District Breakdown');
        $sheet->getStyle('A' . $summaryStartRow)->getFont()->setBold(true)->setSize(12);

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'District');
        $sheet->setCellValue('C' . $summaryStartRow, 'Total Counselings');
        $sheet->getStyle('A' . $summaryStartRow . ':C' . $summaryStartRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB'],
            ],
        ]);

        foreach ($districtTotals as $districtName => $total) {
            $summaryStartRow++;
            $sheet->setCellValue('A' . $summaryStartRow, $districtName);
            $sheet->setCellValue('C' . $summaryStartRow, $total);
        }

        // ===== COLUMN WIDTH =====
        $sheet->getColumnDimension('A')->setWidth(8);  // No.
        $sheet->getColumnDimension('B')->setWidth(30); // District
        $sheet->getColumnDimension('C')->setWidth(18); // Total Counseling

        // Dynamic columns
        $colIndex = 3;
        foreach ($counselingTypes as $type) {
            $sheet->getColumnDimension($this->getColumnLetter($colIndex))->setWidth(18);
            $colIndex++;
        }
        foreach ($counselingFields as $field) {
            $sheet->getColumnDimension($this->getColumnLetter($colIndex))->setWidth(18);
            $colIndex++;
        }

        // ===== FREEZE PANE =====
        $sheet->freezePane('D' . ($headerRow + 1));

        // ===== AUTOFILTER =====
        $sheet->setAutoFilter('A' . $headerRow . ':' . $lastColumnLetter . $lastDataRow);

        // ===== SAVE AND DOWNLOAD =====
        $fileName = 'counseling_results_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        // Tạo temporary file
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
