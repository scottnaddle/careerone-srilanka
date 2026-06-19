<?php

namespace App\Exports;

use App\Models\TraineeUser;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use App\Models\TraineeInstitute;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TraineeListExportCgo implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function traineeUserFilter(Request $request, $matched = null, $ojt_id = null)
    {
        $query = TraineeUser::query();
        $query->where('active', true);

        if ($ojt_id) {
            $query->whereHas('ojtMatches', function ($query) use ($ojt_id) {
                $query->where('ojt_id', $ojt_id);
                $query ->where('apply_type','ojt_match');
            });
        }

        // Search across the username, first_name, and last_name fields
        if ($request->has('search') && $request->query('search') != '') {
            $searchTerm = '%' . $request->query('search') . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query
                    ->where('first_name', 'ILIKE', $searchTerm)
                    ->orWhere('last_name', 'ILIKE', $searchTerm)
                    ->orWhere('full_name', 'ILIKE', $searchTerm)
                    ->orWhere('nic', 'ILIKE', $searchTerm)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ILIKE', $searchTerm);
            });
        }
        if ($request->has('has-portfolio') && $request->query('has-portfolio') == 1) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('trainee_id')
                    ->from('portfolios')
                    ->whereNotNull('trainee_id');
            });
        }

        // Filter by trainee type
        if ($request->has('trainee_type') && $request->query('trainee_type') != 'all') {
            $traineeType = $request->query('trainee_type');
            if ($traineeType == 'keep') {
                $query->whereHas('keepTrainee', function ($query) {
                    $query->where('trainee_id', DB::raw('trainee_users.id'));
                });
            } elseif ($traineeType == 'unkeep') {
                $query->whereDoesntHave('keepTrainee');
            }
        }

        // Sort by first_name
        return $query->orderBy('full_name', 'asc');
    }

    public function collection()
    {
        $query = $this->traineeUserFilter($this->request);

        $list_trainee_ids = TraineeInstitute::where(
            'institute_id',
            auth('cgo')->user()?->institute_id
        )
            ->groupBy('trainee_id')
            ->pluck('trainee_id');

        $query->whereIn('id', $list_trainee_ids);

        return $query->get();
    }

    public function headings(): array
    {
        return [
            ['TRAINEE LIST REPORT'],
            ['Report Time: ' . now()->format('Y-m-d H:i:s')],
            ['Period: All Time'],
            ['Description: This report displays registered trainees under the CGO portal.'],
            [''],
            ['No.', 'Full Name', 'Contact Address', 'Mobile', 'Email']
        ];
    }

    public function map($trainee): array
    {
        static $index = 0;
        $index++;
        $unpack = function ($val) {
            if (is_array($val)) {
                return $val[app()->getLocale()] ?? array_values($val)[0] ?? '';
            }
            return $val;
        };

        return [
            $index,
            $unpack($trainee->full_name),
            $unpack($trainee->contact_address),
            $trainee->mobile,
            $trainee->email,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

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

        // Style the headers (Row 6)
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

        // Style the data rows (Row 7 onwards)
        $sheet->getStyle("A7:{$highestColumn}{$highestRow}")->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Left-align text descriptions in data rows (Full Name, Contact Address, Email)
        foreach (['B', 'C', 'E'] as $col) {
            $sheet->getStyle("{$col}7:{$col}{$highestRow}")
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }

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
        for ($row = 7; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Add Summary Section
        $summaryRow = $highestRow + 2;
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

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Trainees:');
        $sheet->setCellValue('B' . $summaryRow, $highestRow - 6);
        $sheet->getStyle("A{$summaryRow}:B{$summaryRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        $sheet->getRowDimension($summaryRow - 1)->setRowHeight(20);
        $sheet->getRowDimension($summaryRow)->setRowHeight(20);
    }
}

