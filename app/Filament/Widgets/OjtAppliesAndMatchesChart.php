<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Company;
use App\Models\OjtTraineeApply;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OjtAppliesAndMatchesChart extends ChartWidget
{
    protected static ?string $heading = null;
    public function getHeading(): string
    {
        return trans('admin/performance.OJT Applies & Matches Trend');
    }
    protected static ?int $sort = 3;

    // Share a single default filter state
    public ?string $filter = 'this_month';

    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected ?int $selectedYear = null;

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('naita_admin') ?? false;
    }

    // Initialize the filter list
    protected function getFilters(): ?array
    {
        $filters = [
            'all_time'   => trans('admin/performance.All Time'),
            'this_month' =>trans('admin/performance.This Month'),
            'last_month' => trans('admin/performance.Last Month'),
            'this_year'  => trans('admin/performance.This Year'),
//            'last_year'  => 'Last Year',
        ];

        $currentYear = (int) Carbon::now()->year;
        $startYear = 2025;

        // Add the years into the dropdown list
        for ($year = $currentYear - 1; $year >= $startYear; $year--) {
            $filters['year_' . $year] = (string) $year;
        }

        return $filters;
    }

    // Logic for parsing the filter into startDate and endDate
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

        // Shared base query using the o_j_t_s table
        $baseQuery = OjtTraineeApply::whereIn('ojt_id', function($q) use ($naitaCompanyIds) {
            $q->select('id')->from('o_j_t_s')->whereIn('company_id', $naitaCompanyIds);
        });

        // Split the queries for Applies and Matches
        $appliesQuery = (clone $baseQuery)->where('apply_type', 'apply');
        $matchesQuery = (clone $baseQuery)->where('apply_type', 'ojt_match');

        // Apply the time filter
        if ($this->startDate && $this->endDate) {
            $appliesQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
            $matchesQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        // Handle day-by-day display for This Month / Last Month
        if ($filterValue === 'this_month' || $filterValue === 'last_month') {
            return $this->getDailyData($appliesQuery, $matchesQuery, Carbon::parse($this->startDate));
        }

        // Limit to the most recent 12 months for All Time
        if ($filterValue === 'all_time') {
            $startLimit = now()->subMonths(11)->startOfMonth();
            $appliesQuery->where('created_at', '>=', $startLimit);
            $matchesQuery->where('created_at', '>=', $startLimit);
        }

        // Group by month (YYYY-MM)
        $appliesData = $appliesQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        $matchesData = $matchesQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        $labels = [];
        $appliesValues = [];
        $matchesValues = [];

        if ($filterValue === 'all_time') {
            // Build the span of the most recent 12 months
            for ($i = 11; $i >= 0; $i--) {
                $monthStr = now()->subMonths($i)->format('Y-m');
                $labels[] = now()->subMonths($i)->format('M Y');
                $appliesValues[] = $appliesData[$monthStr]->total ?? 0;
                $matchesValues[] = $matchesData[$monthStr]->total ?? 0;
            }
        } else {
            // Build the 12 months of a specific year
            $targetYear = $this->selectedYear ?? now()->year;
            for ($month = 1; $month <= 12; $month++) {
                $monthStr = sprintf('%04d-%02d', $targetYear, $month);
                $labels[] = Carbon::create($targetYear, $month, 1)->format('M Y');
                $appliesValues[] = $appliesData[$monthStr]->total ?? 0;
                $matchesValues[] = $matchesData[$monthStr]->total ?? 0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => trans('admin/performance.OJT Applies'),
                    'data' => $appliesValues,
                    'borderColor' => '#10b981', // Emerald
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => trans('admin/performance.OJT Matches'),
                    'data' => $matchesValues,
                    'borderColor' => '#8b5cf6', // Violet/Purple
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    // Helper function to aggregate data by day
    protected function getDailyData($appliesQuery, $matchesQuery, Carbon $startMonth): array
    {
        $appliesDaily = $appliesQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')"))
            ->orderBy('day', 'asc')
            ->get()
            ->keyBy('day');

        $matchesDaily = $matchesQuery->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')"))
            ->orderBy('day', 'asc')
            ->get()
            ->keyBy('day');

        $labels = [];
        $appliesValues = [];
        $matchesValues = [];
        $daysInMonth = $startMonth->daysInMonth;

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $day = $startMonth->copy()->day($d)->format('Y-m-d');
            $labels[] = $startMonth->copy()->day($d)->format('d M');
            $appliesValues[] = $appliesDaily[$day]->total ?? 0;
            $matchesValues[] = $matchesDaily[$day]->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => trans('admin/performance.OJT Applies'),
                    'data' => $appliesValues,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => trans('admin/performance.OJT Matches'),
                    'data' => $matchesValues,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
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
