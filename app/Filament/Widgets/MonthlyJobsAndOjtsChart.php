<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Company;
use App\Models\Job;
use App\Models\OJT;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonthlyJobsAndOjtsChart extends ChartWidget
{
    protected static ?string $heading = null;

    public function getHeading(): string
    {
        return trans('admin/performance.Jobs & OJTs Created');
    }
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    // Sử dụng chung 1 filter state mặc định
    public ?string $filter = 'this_month';

    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected ?int $selectedYear = null;

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('naita_admin') ?? false;
    }

    // Khởi tạo danh sách filter gộp chung cả các mốc thời gian và các năm
    protected function getFilters(): ?array
    {
        $filters = [
            'all_time'   => trans('admin/performance.All Time'),
            'this_month' =>trans('admin/performance.This Month'),
            'last_month' => trans('admin/performance.Last Month'),
            'this_year'  => trans('admin/performance.This Year'),
        ];

        $currentYear = (int) Carbon::now()->year;
        $startYear = 2025;

        // Bổ sung các năm trước vào chung dropdown list
        for ($year = $currentYear - 1; $year >= $startYear; $year--) {
            $filters['year_' . $year] = (string) $year;
        }

        return $filters;
    }

    // Logic xử lý startDate và endDate đồng bộ với GuidanceCompletionWidget
    protected function applyDateRange(string $filterValue): void
    {
        $now = Carbon::now();

        switch ($filterValue) {
            case 'all_time':
                $this->startDate = null;
                $this->endDate = null;
                $this->selectedYear = null;
                break;

            case 'this_month':
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d 00:00:00');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d 23:59:59');
                $this->selectedYear = null;
                break;

            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                $this->startDate = $lastMonth->copy()->startOfMonth()->format('Y-m-d 00:00:00');
                $this->endDate = $lastMonth->copy()->endOfMonth()->format('Y-m-d 23:59:59');
                $this->selectedYear = null;
                break;

            case 'this_year':
                $this->startDate = $now->copy()->startOfYear()->format('Y-m-d 00:00:00');
                $this->endDate = $now->copy()->endOfYear()->format('Y-m-d 23:59:59');
                $this->selectedYear = $now->year;
                break;

            case 'last_year':
                $lastYear = $now->copy()->subYear();
                $this->startDate = $lastYear->copy()->startOfYear()->format('Y-m-d 00:00:00');
                $this->endDate = $lastYear->copy()->endOfYear()->format('Y-m-d 23:59:59');
                $this->selectedYear = $lastYear->year;
                break;

            default:
                if (preg_match('/^year_(\d{4})$/', $filterValue, $matches)) {
                    $year = (int) $matches[1];
                    $this->startDate = Carbon::create($year, 1, 1, 0, 0, 0)->format('Y-m-d H:i:s');
                    $this->endDate = Carbon::create($year, 12, 31, 23, 59, 59)->format('Y-m-d H:i:s');
                    $this->selectedYear = $year;
                } else {
                    $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d 00:00:00');
                    $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d 23:59:59');
                    $this->filter = 'this_month';
                    $this->selectedYear = null;
                }
                break;
        }
    }

    protected function getData(): array
    {
        $filterValue = $this->filter ?? 'this_month';
        $this->applyDateRange($filterValue);

        $naitaCompanyIds = Company::where('is_belongs_to_naita', true)->pluck('id');

        $jobsQuery = Job::whereIn('company_id', $naitaCompanyIds);
        $ojtsQuery = OJT::whereIn('company_id', $naitaCompanyIds);

        // Áp dụng khoảng thời gian (startDate, endDate) đã tính được
        if ($this->startDate && $this->endDate) {
            $jobsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
            $ojtsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        // Với tháng này hoặc tháng trước: Hiển thị chi tiết từng ngày
        if ($filterValue === 'this_month' || $filterValue === 'last_month') {
            return $this->getDailyData($jobsQuery, $ojtsQuery, Carbon::parse($this->startDate));
        }

        // Vói Tất cả thời gian: Giới hạn 12 tháng gần nhất để tránh biểu đồ quá dày đặc
        if ($filterValue === 'all_time') {
            $startLimit = now()->subMonths(11)->startOfMonth();
            $jobsQuery->where('created_at', '>=', $startLimit);
            $ojtsQuery->where('created_at', '>=', $startLimit);
        }

        // Group dữ liệu theo tháng (YYYY-MM) cho các trường hợp còn lại (năm, all_time)
        $jobsData = $jobsQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        $ojtsData = $ojtsQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        $labels = [];
        $jobsValues = [];
        $ojtsValues = [];

        if ($filterValue === 'all_time') {
            // Hiển thị dải 12 tháng
            for ($i = 11; $i >= 0; $i--) {
                $monthStr = now()->subMonths($i)->format('Y-m');
                $labels[] = now()->subMonths($i)->format('M Y');
                $jobsValues[] = $jobsData[$monthStr]->total ?? 0;
                $ojtsValues[] = $ojtsData[$monthStr]->total ?? 0;
            }
        } else {
            // Trường hợp theo năm (this_year, last_year, year_2024...)
            $targetYear = $this->selectedYear ?? now()->year;
            for ($month = 1; $month <= 12; $month++) {
                $monthStr = sprintf('%04d-%02d', $targetYear, $month);
                $labels[] = Carbon::create($targetYear, $month, 1)->format('M Y');
                $jobsValues[] = $jobsData[$monthStr]->total ?? 0;
                $ojtsValues[] = $ojtsData[$monthStr]->total ?? 0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jobs',
                    'data' => $jobsValues,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'OJTs',
                    'data' => $ojtsValues,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    // Hàm support riêng biệt để xử lý dữ liệu biểu đồ theo Ngày
    protected function getDailyData($jobsQuery, $ojtsQuery, Carbon $startMonth): array
    {
        $jobsDaily = $jobsQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')"))
            ->orderBy('day', 'asc')
            ->get()
            ->keyBy('day');

        $ojtsDaily = $ojtsQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')"))
            ->orderBy('day', 'asc')
            ->get()
            ->keyBy('day');

        $labels = [];
        $jobsValues = [];
        $ojtsValues = [];
        $daysInMonth = $startMonth->daysInMonth;

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $day = $startMonth->copy()->day($d)->format('Y-m-d');
            $labels[] = $startMonth->copy()->day($d)->format('d M');
            $jobsValues[] = $jobsDaily[$day]->total ?? 0;
            $ojtsValues[] = $ojtsDaily[$day]->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => trans('admin/performance.Jobs'),
                    'data' => $jobsValues,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => trans('admin/performance.OJTs'),
                    'data' => $ojtsValues,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
