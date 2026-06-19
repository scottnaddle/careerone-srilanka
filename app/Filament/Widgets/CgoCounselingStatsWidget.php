<?php

namespace App\Filament\Widgets;

use App\Models\CgoCounseling;
use App\Models\Institute;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CgoCounselingStatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.cgo-counseling-stats-widget';

    protected int | string | array $columnSpan = 'full';

    // Input data from the Page (passed in by Filament)
    public ?array $data = [];

    // Renamed $data to $stats to hold the output data, to avoid overwriting the input data
    public ?array $stats = [];

    public ?string $headOfficeFilter = null;
    public ?string $dateRange = 'this_month';
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?string $selectedYear = null;
    public bool $isLoading = false;

    public function mount(): void
    {
        $this->initializeHeadOfficeFilter();
        $this->initializeDateFilters();
        $this->loadData();
    }

    /**
     * Static method to check permission to view the widget
     */
    public static function canView(): bool
    {
        $user = auth('admin')->user();
        return $user && ($user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('naita_admin'));
    }

    /**
     * Dynamic Getter: Get the current user
     */
    protected function getAuthUser()
    {
        return auth('admin')->user();
    }

    protected function isSuperAdmin(): bool
    {
        $user = $this->getAuthUser();
        return $user && $user->hasRole('super_admin');
    }

    protected function isAdmin(): bool
    {
        $user = $this->getAuthUser();
        return $user && $user->hasRole('admin');
    }

    protected function getAuthTvetType(): ?string
    {
        $user = $this->getAuthUser();
        return $user->tvet_type ?? null;
    }

    /**
     * Initialize the head_office filter from the passed-in data
     */
    protected function initializeHeadOfficeFilter(): void
    {
        if (!$this->isSuperAdmin()) {
            $this->headOfficeFilter = null;
            return;
        }

        $headOffice = $this->data['head_office'] ?? null;

        if ($headOffice && is_string($headOffice) && !empty(trim($headOffice))) {
            $this->headOfficeFilter = trim($headOffice);
            Log::info('CGO Counseling Widget - Head office filter applied:', ['head_office' => $this->headOfficeFilter]);
        } else {
            $this->headOfficeFilter = null;
        }
    }

    public function getAvailableYears(): array
    {
        $currentYear = (int) Carbon::now()->year;
        $startYear = 2025;
        $years = [];

        for ($year = $currentYear-1; $year >= $startYear; $year--) {
            $years[] = $year;
        }

        return array_unique($years);
    }

    protected function initializeDateFilters(): void
    {
        if (!$this->dateRange) {
            $this->dateRange = 'this_month';
        }
        $this->applyDateRange();
    }

    protected function applyDateRange(): void
    {
        $now = Carbon::now();

        switch ($this->dateRange) {
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
                $this->selectedYear = null;
                break;

            case 'last_year':
                $lastYear = $now->copy()->subYear();
                $this->startDate = $lastYear->copy()->startOfYear()->format('Y-m-d 00:00:00');
                $this->endDate = $lastYear->copy()->endOfYear()->format('Y-m-d 23:59:59');
                $this->selectedYear = null;
                break;

            default:
                if (preg_match('/^year_(\d{4})$/', $this->dateRange, $matches)) {
                    $year = (int) $matches[1];
                    $this->startDate = Carbon::create($year, 1, 1, 0, 0, 0)->format('Y-m-d H:i:s');
                    $this->endDate = Carbon::create($year, 12, 31, 23, 59, 59)->format('Y-m-d H:i:s');
                    $this->selectedYear = $year;
                } else {
                    $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d 00:00:00');
                    $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d 23:59:59');
                    $this->dateRange = 'this_month';
                    $this->selectedYear = null;
                }
                break;
        }
    }

    protected function getAllowedInstituteIds(): array
    {
        if ($this->isSuperAdmin()) {
            $query = Institute::query();
            if ($this->headOfficeFilter && !empty(trim($this->headOfficeFilter))) {
                $query->where('institute_head_office', $this->headOfficeFilter);
            }
            return $query->pluck('id')->toArray();
        }

        if ($this->isAdmin() && $tvetType = $this->getAuthTvetType()) {
            return Institute::where('institute_head_office', $tvetType)
                ->pluck('id')
                ->toArray();
        }

        return [];
    }

    protected function getFilteredCounselingQuery()
    {
        $query = CgoCounseling::query();
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            return $query->whereRaw('1 = 0');
        }

        $query->whereIn('institute_id', $allowedInstituteIds);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query;
    }

    protected function getCancelRate(int $total, int $cancelled): float
    {
        return $total > 0 ? round(($cancelled / $total) * 100, 1) : 0;
    }

    protected function getCompletionRate(int $total, int $completed): float
    {
        return $total > 0 ? round(($completed / $total) * 100, 1) : 0;
    }

    protected function getStatsByField(): array
    {
        $fields = [
            1 => ['name' => 'Career Path', 'color' => '#3b82f6'],
            2 => ['name' => 'Employment', 'color' => '#10b981'],
            3 => ['name' => 'Portfolio Clinic', 'color' => '#f59e0b'],
            4 => ['name' => 'OJT', 'color' => '#8b5cf6'],
        ];

        $stats = [];
        $query = $this->getFilteredCounselingQuery();

        foreach ($fields as $fieldId => $fieldInfo) {
            $count = (clone $query)->where('counseling_field_id', $fieldId)->count();
            $completed = (clone $query)->where('counseling_field_id', $fieldId)->where('status', 3)->count();
            $cancelled = (clone $query)->where('counseling_field_id', $fieldId)->where('status', 4)->count();

            $stats[$fieldId] = [
                'name' => $fieldInfo['name'],
                'total' => $count,
                'completed' => $completed,
                'cancelled' => $cancelled,
                'completion_rate' => $this->getCompletionRate($count, $completed),
                'cancel_rate' => $this->getCancelRate($count, $cancelled),
                'color' => $fieldInfo['color'],
            ];
        }

        return $stats;
    }

    protected function getStatsByType(): array
    {
        $types = [
            1 => ['name' => 'Offline guidance', 'color' => '#06b6d4'],
            2 => ['name' => 'Online guidance', 'color' => '#ec489a'],
            3 => ['name' => 'Guidance without reservation', 'color' => '#6366f1'],
        ];

        $stats = [];
        $query = $this->getFilteredCounselingQuery();

        foreach ($types as $typeId => $typeInfo) {
            $count = (clone $query)->where('counseling_type', $typeId)->count();
            $completed = (clone $query)->where('counseling_type', $typeId)->where('status', 3)->count();
            $cancelled = (clone $query)->where('counseling_type', $typeId)->where('status', 4)->count();

            $stats[$typeId] = [
                'name' => $typeInfo['name'],
                'total' => $count,
                'completed' => $completed,
                'cancelled' => $cancelled,
                'completion_rate' => $this->getCompletionRate($count, $completed),
                'cancel_rate' => $this->getCancelRate($count, $cancelled),
                'color' => $typeInfo['color'],
            ];
        }

        return $stats;
    }

    public function loadData(): void
    {
        $this->isLoading = true;

        try {
            $query = $this->getFilteredCounselingQuery();

            $totalCounseling = (clone $query)->count();
            $completedCounseling = (clone $query)->where('status', 3)->count();
            $cancelledCounseling = (clone $query)->where('status', 4)->count();

            // SAVE TO $stats INSTEAD OF $data
            $this->stats = [
                'total_counseling' => $totalCounseling,
                'completed_counseling' => $completedCounseling,
                'cancelled_counseling' => $cancelledCounseling,
                'completion_rate' => $this->getCompletionRate($totalCounseling, $completedCounseling),
                'cancel_rate' => $this->getCancelRate($totalCounseling, $cancelledCounseling),
                'stats_by_field' => $this->getStatsByField(),
                'stats_by_type' => $this->getStatsByType(),
            ];

        } finally {
            $this->isLoading = false;
        }
    }

    public function hasHeadOfficeFilter(): bool
    {
        return $this->isSuperAdmin() && $this->headOfficeFilter && !empty(trim($this->headOfficeFilter));
    }

    public function getCurrentHeadOfficeFilter(): ?string
    {
        return $this->headOfficeFilter;
    }

    public function updatedDateRange($value): void
    {
        $this->dateRange = $value;
        $this->applyDateRange();
        $this->loadData();
    }

    public function resetDateRange(): void
    {
        $this->dateRange = 'this_month';
        $this->applyDateRange();
        $this->loadData();
    }

    public function getDateRangeLabel(): string
    {
        $labels = [
            'all_time' => 'All Time',
            'this_month' =>trans('admin/performance.This Month'),
            'last_month' => trans('admin/performance.Last Month'),
            'this_year' => trans('admin/performance.This Year'),
            'last_year' => 'Last Year',
        ];

        if (preg_match('/^year_(\d{4})$/', $this->dateRange, $matches)) {
            return $matches[1];
        }

        return $labels[$this->dateRange] ?? 'This Month';
    }

    public function getDateRangeDescription(): string
    {
        if ($this->dateRange === 'all_time') {
            return 'All historical data';
        }

        if ($this->startDate && $this->endDate) {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);

            if ($start->format('Y') === $end->format('Y')) {
                if ($start->format('m') === $end->format('m')) {
                    return $start->format('F Y');
                }
                return $start->format('M d') . ' - ' . $end->format('M d, Y');
            }

            return $start->format('M d, Y') . ' - ' . $end->format('M d, Y');
        }

        return '';
    }
}
