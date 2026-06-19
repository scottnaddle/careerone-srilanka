<?php

namespace App\Exports;

use App\Models\Institute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CareerTestExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $carrerTestType;

    public function __construct($startDate, $endDate, $carrerTestType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->carrerTestType = $carrerTestType;
    }

    public function collection()
    {
        $query = Institute::query();

        // 1. MIRROR THE EXACT SAME PERMISSION LOGIC AS LIVEWIRE
        if (auth('admin')->check() && !auth('admin')->user()->hasRole('super_admin')) {
            $institutes = auth('admin')->user()->institutes;
            if ($institutes && $institutes->isNotEmpty()) {
                $instituteIds = $institutes->pluck('id')->filter()->values()->toArray();
                if (!empty($instituteIds)) {
                    $query->whereIn('id', $instituteIds);
                } else {
                    $query->whereRaw('1 = 0');
                }
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Drop the 'active_status' filter so data is not missing compared to the Livewire grid
        // $query->where('active_status', 'Active');

        // 2. FILTER BY TEST DATE RANGE
        $query->whereHas('carrerTestsTraineeResult', function($subQuery) {
            if ($this->startDate && $this->endDate) {
                $subQuery->whereDate('created_at', '>=', $this->startDate)
                    ->whereDate('created_at', '<=', $this->endDate);
            }
        });

        // 3. SORT AND RETURN
        return $query->orderBy('name', 'asc')->get();
    }

    public function headings(): array
    {
        $count = count($this->carrerTestType);

        $row1 = ['Career Test Results Report'];
        
        $reportTime = now()->format('Y-m-d H:i:s');
        $row2 = ['Report Time: ' . $reportTime];

        if ($this->startDate && $this->endDate) {
            $period = 'Period: ' . $this->startDate . ' to ' . $this->endDate;
        } else {
            $period = 'Period: All Time';
        }
        $row3 = [$period];

        $row4 = ['Description: This report displays statistics of career tests taken by trainees, categorized by test type and member status for each institute.'];

        $row5 = ['']; // Empty spacer row

        $row6 = ['No.', 'Institute Name'];
        $row6[] = 'Career Test Type';
        for ($i = 1; $i < $count; $i++) {
            $row6[] = '';
        }
        $row6[] = 'Member Type';
        $row6[] = '';
        $row6[] = 'Total';

        $row7 = ['', ''];
        foreach ($this->carrerTestType as $type) {
            $row7[] = $type->code_name;
        }
        $row7[] = 'Member';
        $row7[] = 'Non-member';
        $row7[] = '';

        return [$row1, $row2, $row3, $row4, $row5, $row6, $row7];
    }

    public function map($institute): array
    {
        static $index = 0;
        $index++;

        $memberStats = $institute->countCareerTestByInstituteMember($this->startDate, $this->endDate);

        $row = [
            $index,
            $institute->name,
        ];

        foreach ($this->carrerTestType as $type) {
            $testStats = $institute->countCareerTestByInstitute($this->startDate, $this->endDate, $type->code_id);
            $row[] = $testStats['member'] + $testStats['non_member'];
        }

        $row[] = $memberStats['member'];
        $row[] = $memberStats['non_member'];
        $row[] = $memberStats['member'] + $memberStats['non_member'];

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $count = count($this->carrerTestType);
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Convert columns to letters dynamically
        $colA = 'A';
        $colB = 'B';
        $colStartType = 'C';
        $colEndType = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2 + $count);
        $colStartMember = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(3 + $count);
        $colEndMember = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(4 + $count);
        $colTotal = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(5 + $count);

        // Merge title, report time, period, and description rows
        $sheet->mergeCells("A1:{$highestColumn}1");
        $sheet->mergeCells("A2:{$highestColumn}2");
        $sheet->mergeCells("A3:{$highestColumn}3");
        $sheet->mergeCells("A4:{$highestColumn}4");

        // Style the Title (Row 1)
        $sheet->getStyle("A1")->applyFromArray([
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

        // Merge cells for headers (Rows 6 & 7)
        $sheet->mergeCells("{$colA}6:{$colA}7");
        $sheet->mergeCells("{$colB}6:{$colB}7");
        $sheet->mergeCells("{$colStartType}6:{$colEndType}6");
        $sheet->mergeCells("{$colStartMember}6:{$colEndMember}6");
        $sheet->mergeCells("{$colTotal}6:{$colTotal}7");

        // Style the headers (Row 6 and Row 7)
        $sheet->getStyle("A6:{$highestColumn}7")->applyFromArray([
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

        // Style the data rows (Row 8 onwards)
        $sheet->getStyle("A8:{$highestColumn}{$highestRow}")->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Left-align Institute Name in data rows
        $sheet->getStyle("B8:B{$highestRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Apply borders to the table section only
        $sheet->getStyle("A6:{$highestColumn}{$highestRow}")
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Set custom row heights
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(15);
        $sheet->getRowDimension(6)->setRowHeight(25);
        $sheet->getRowDimension(7)->setRowHeight(25);
        for ($row = 8; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Add Summary Section
        $grandTotal = 0;
        for ($row = 8; $row <= $highestRow; $row++) {
            $grandTotal += (int)$sheet->getCell($colTotal . $row)->getValue();
        }

        $summaryStartRow = $highestRow + 2;

        // Summary title
        $sheet->setCellValue('A' . $summaryStartRow, 'SUMMARY');
        $sheet->getStyle('A' . $summaryStartRow)->applyFromArray([
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

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'Total Career Test Records:');
        $sheet->setCellValue('B' . $summaryStartRow, $grandTotal);
        $sheet->getStyle("A{$summaryStartRow}:B{$summaryStartRow}")->applyFromArray([
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

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'Total Institutes:');
        $sheet->setCellValue('B' . $summaryStartRow, $highestRow - 7);
        $sheet->getStyle("A{$summaryStartRow}:B{$summaryStartRow}")->applyFromArray([
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

        // Add institute breakdown
        $summaryStartRow += 2;
        $sheet->setCellValue('A' . $summaryStartRow, 'Institute Breakdown');
        $sheet->getStyle('A' . $summaryStartRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '1E293B'],
            ],
        ]);

        $summaryStartRow++;
        $sheet->setCellValue('A' . $summaryStartRow, 'Institute Name');
        $sheet->setCellValue('B' . $summaryStartRow, 'Total Career Tests');
        $sheet->getStyle('A' . $summaryStartRow . ':B' . $summaryStartRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '4984F6'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7EFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $breakdownStartRow = $summaryStartRow;

        for ($row = 8; $row <= $highestRow; $row++) {
            $summaryStartRow++;
            $instName = $sheet->getCell('B' . $row)->getValue();
            $instTotal = $sheet->getCell($colTotal . $row)->getValue();
            $sheet->setCellValue('A' . $summaryStartRow, $instName);
            $sheet->setCellValue('B' . $summaryStartRow, $instTotal);
        }

        // Style breakdown data rows
        $sheet->getStyle('A' . ($breakdownStartRow + 1) . ':B' . $summaryStartRow)->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A' . ($breakdownStartRow + 1) . ':A' . $summaryStartRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Apply borders to breakdown table
        $sheet->getStyle('A' . $breakdownStartRow . ':B' . $summaryStartRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        // Heights for all summary rows
        for ($r = $highestRow + 2; $r <= $summaryStartRow; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(20);
        }
    }

    public function title(): string
    {
        return 'Career Test Results';
    }
}
