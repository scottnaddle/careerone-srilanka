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

        // 1. ĐỒNG BỘ LOGIC PHÂN QUYỀN GIỐNG HỆT LIVEWIRE
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

        // Bỏ filter 'active_status' để không bị thiếu dữ liệu so với lưới Livewire
        // $query->where('active_status', 'Active');

        // 2. LỌC THEO KHOẢNG THỜI GIAN TEST
        $query->whereHas('carrerTestsTraineeResult', function($subQuery) {
            if ($this->startDate && $this->endDate) {
                $subQuery->whereDate('created_at', '>=', $this->startDate)
                    ->whereDate('created_at', '<=', $this->endDate);
            }
        });

        // 3. SẮP XẾP VÀ TRẢ VỀ
        return $query->orderBy('name', 'asc')->get();
    }

    public function headings(): array
    {
        // THÊM CỘT ID ĐỂ CHỐNG NHẦM LẪN KHI TRÙNG TÊN
        $headings = ['No.', 'Institute ID', 'Institute Name'];

        foreach ($this->carrerTestType as $type) {
            $headings[] = $type->code_name;
        }

        $headings[] = 'Member';
        $headings[] = 'Non-member';
        $headings[] = 'Total';

        return $headings;
    }

    public function map($institute): array
    {
        static $index = 0;
        $index++;

        $memberStats = $institute->countCareerTestByInstituteMember($this->startDate, $this->endDate);

        $row = [
            $index,
            $institute->id, // MAP TRƯỜNG ID VÀO ĐÂY
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
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4984F6'],
            ],
        ]);

        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Căn giữa cho cột ID (Cột B) và các cột số liệu phía sau
        $lastColumn = $sheet->getHighestColumn();
        $sheet->getStyle('B2:B' . $sheet->getHighestRow())
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2:' . $lastColumn . $sheet->getHighestRow())
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function title(): string
    {
        return 'Career Test Results';
    }
}
