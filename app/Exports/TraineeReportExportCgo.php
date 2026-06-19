<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TraineeReportExportCgo implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $trainees;

    public function __construct($trainees)
    {
        $this->trainees = $trainees;
    }

    public function collection()
    {
        return $this->trainees;
    }

    public function headings(): array
    {
        return [
            ['Trainee Report'],
            ['Generated on: ' . now()->format('Y-m-d H:i:s')],
            [''],
            [
                'Name',
                'NIC',
                'Email',
                'Mobile',
                'Portfolio',
                'NVQ Levels',
                'Career Tests Taken',
                'Counselings Taken',
            ]
        ];
    }

    public function map($trainee): array
    {
        $unpack = function ($val) {
            if (is_array($val)) {
                $localeVal = $val[app()->getLocale()] ?? array_values($val)[0] ?? '';
                return is_array($localeVal) ? json_encode($val) : (string) $localeVal;
            }
            if (is_object($val) && !method_exists($val, '__toString')) {
                return json_encode($val);
            }
            return (string) $val;
        };

        $fullName = $unpack($trainee->full_name ?? $trainee->first_name . ' ' . $trainee->last_name);
        $portfolioStatus = $trainee->portfolio ? 'Yes' : 'No';
        $nvqLevels = $trainee->nvqs ? $trainee->nvqs->map(function($n) use ($unpack) {
            $name = $unpack($n->name);
            $level = $unpack($n->level);
            return '• ' . $name . ' (' . $level . ')';
        })->implode("\n") : '';
        $careerTestCount = (string) ($trainee->career_test_count ?? 0);
        $counselingCount = (string) ($trainee->cgo_counseling_count ?? 0);

        return [
            $fullName,
            $trainee->nic,
            $trainee->email,
            $trainee->mobile,
            $portfolioStatus,
            $nvqLevels,
            $careerTestCount,
            $counselingCount,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Title style
            1 => ['font' => ['bold' => true, 'size' => 14]],
            // Date description style
            2 => ['font' => ['italic' => true, 'color' => ['argb' => 'FF666666']]],
            // Headers style
            4 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFEFEFEF']
                ]
            ],
            // Enable text wrapping for NVQ Levels column (F)
            'F' => ['alignment' => ['wrapText' => true]],
        ];
    }
}
