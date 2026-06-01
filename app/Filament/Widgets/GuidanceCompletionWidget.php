<?php

namespace App\Filament\Widgets;

use App\Models\CareerTestTraineeResult;
use App\Models\CgoCounseling;
use App\Models\Portfolio;
use App\Models\TraineeUser;
use App\Models\Institute;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GuidanceCompletionWidget extends Widget
{
    use InteractsWithPageFilters;

    protected static string $view = 'filament.widgets.guidance-completion-widget';

    protected int | string | array $columnSpan = 'full';

    // Dữ liệu đầu vào từ Page (để Filament truyền vào)
    public ?array $data = [];

    // Biến output để lưu dữ liệu thống kê, tránh ghi đè input
    public ?array $stats = [];

    public ?string $headOfficeFilter = null;
    public ?string $dateRange = 'this_month';
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?string $selectedYear = null;
    public bool $isLoading = false;

    // User permissions
    protected ?string $currentUserRole = null;
    protected ?string $currentUserTvetType = null;

    public function mount(): void
    {
        $this->initializeUserPermissions();
        $this->initializeHeadOfficeFilter();
        $this->initializeDateFilters();
        $this->loadData();
    }

    /**
     * Static method kiểm tra quyền xem widget
     */
    public static function canView(): bool
    {
        $user = auth('admin')->user();
        return $user && ($user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('naita_admin'));
    }

    /**
     * Khởi tạo quyền của người dùng hiện tại
     */
    protected function initializeUserPermissions(): void
    {
        $user = auth('admin')->user();

        if ($user && $user->hasRole('super_admin')) {
            $this->currentUserRole = 'super_admin';
            $this->currentUserTvetType = null;
        } elseif ($user && $user->hasRole('admin')) {
            $this->currentUserRole = 'admin';
            $this->currentUserTvetType = $user->tvet_type ?? null;
        } else {
            $this->currentUserRole = 'user';
            $this->currentUserTvetType = null;
        }

        Log::info('Guidance Widget - User permissions initialized:', [
            'role' => $this->currentUserRole,
            'tvet_type' => $this->currentUserTvetType
        ]);
    }

    /**
     * Khởi tạo head_office filter từ data được truyền vào
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
            Log::info('Guidance Widget - Head office filter applied:', ['head_office' => $this->headOfficeFilter]);
        } else {
            $this->headOfficeFilter = null;
        }
    }

    /**
     * Khởi tạo các filter ngày tháng
     */
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

    /**
     * Đảm bảo permissions được khởi tạo trước khi dùng
     */
    protected function ensurePermissionsInitialized(): void
    {
        if ($this->currentUserRole === null) {
            $this->initializeUserPermissions();
        }
    }

    protected function isSuperAdmin(): bool
    {
        $this->ensurePermissionsInitialized();
        return $this->currentUserRole === 'super_admin';
    }

    protected function isAdmin(): bool
    {
        $this->ensurePermissionsInitialized();
        return $this->currentUserRole === 'admin';
    }

    protected function getAllowedInstituteIds(): array
    {
        $this->ensurePermissionsInitialized();

        if ($this->isSuperAdmin()) {
            $query = Institute::query();

            if ($this->headOfficeFilter && !empty(trim($this->headOfficeFilter))) {
                $query->where('institute_head_office', $this->headOfficeFilter);
            }

            return $query->pluck('id')->toArray();
        }

        if ($this->isAdmin() && $this->currentUserTvetType) {
            return Institute::where('institute_head_office', $this->currentUserTvetType)
                ->pluck('id')
                ->toArray();
        }

        return [];
    }

    protected function getFilteredTraineesQuery()
    {
        $query = TraineeUser::where('active', true);
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            return $query->whereRaw('1 = 0');
        }

        $query->whereHas('institutes', function ($q) use ($allowedInstituteIds) {
            $q->whereIn('institutes.id', $allowedInstituteIds);
        });

        // Note: Không filter theo created_at cho Trainee vì ta thường muốn tính completion rate dựa trên TỔNG SỐ trainee đang active
        return $query;
    }

    protected function getFilteredTestResultsQuery()
    {
        $query = CareerTestTraineeResult::query();
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            return $query->whereRaw('1 = 0');
        }

        $query->whereIn('institute_id', $allowedInstituteIds);

        // Áp dụng filter thời gian
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query;
    }

    protected function getGuestTestTakersCount(): int
    {
        return (clone $this->getFilteredTestResultsQuery())
            ->whereNull('trainee_id')
            ->count();
    }

    protected function getTraineeTestTakersCount(): int
    {
        return (clone $this->getFilteredTestResultsQuery())
            ->whereNotNull('trainee_id')
            ->distinct('trainee_id')
            ->count('trainee_id');
    }

    protected function getFilteredCounselingQuery()
    {
        $query = CgoCounseling::query();
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            return $query->whereRaw('1 = 0');
        }

        $query->join('trainee_users', 'cgo_counselings.trainee_id', '=', 'trainee_users.id')
            ->join('trainee_institutes', 'trainee_users.id', '=', 'trainee_institutes.trainee_id')
            ->whereIn('trainee_institutes.institute_id', $allowedInstituteIds)
            ->where('trainee_users.active', true)
            ->select('cgo_counselings.*');

        // Áp dụng filter thời gian
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('cgo_counselings.created_at', [$this->startDate, $this->endDate]);
        }

        return $query;
    }

    protected function getCounselingTotalCount(): int
    {
        return $this->getFilteredCounselingQuery()
            ->distinct('cgo_counselings.trainee_id')
            ->count('cgo_counselings.trainee_id');
    }

    protected function getCounselingRequestedCount(): int
    {
        return $this->getFilteredCounselingQuery()
            ->where('status', 1)
            ->distinct('cgo_counselings.trainee_id')
            ->count('cgo_counselings.trainee_id');
    }

    protected function getCounselingCompletedCount(): int
    {
        return $this->getFilteredCounselingQuery()
            ->where('status', 3)
            ->distinct('cgo_counselings.trainee_id')
            ->count('cgo_counselings.trainee_id');
    }

    protected function getFilteredPortfolioQuery()
    {
        $query = Portfolio::query();
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            return $query->whereRaw('1 = 0');
        }

        $query->join('trainee_users', 'portfolios.trainee_id', '=', 'trainee_users.id')
            ->join('trainee_institutes', 'trainee_users.id', '=', 'trainee_institutes.trainee_id')
            ->whereIn('trainee_institutes.institute_id', $allowedInstituteIds)
            ->where('trainee_users.active', true)
            ->select('portfolios.*');

        // Áp dụng filter thời gian
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('portfolios.created_at', [$this->startDate, $this->endDate]);
        }

        return $query;
    }

    public function loadData(): void
    {
        $this->isLoading = true;

        try {
            $totalTrainees = $this->getFilteredTraineesQuery()->count();

            $traineeTestTakers = $this->getTraineeTestTakersCount();
            $guestTestTakers = $this->getGuestTestTakersCount();
            $totalTestTakers = $traineeTestTakers + $guestTestTakers;
            $testPercentage = $totalTrainees > 0 ? round(($traineeTestTakers / $totalTrainees) * 100, 1) : 0;

            $counselingTotal = $this->getCounselingTotalCount();
            $counselingRequested = $this->getCounselingRequestedCount();
            $counselingCompleted = $this->getCounselingCompletedCount();
            $careerPercentage = $totalTrainees > 0 ? round(($counselingCompleted / $totalTrainees) * 100, 1) : 0;

            $hasPortfolio = $this->getFilteredPortfolioQuery()
                ->distinct('portfolios.trainee_id')
                ->count('portfolios.trainee_id');
            $portfolioPercentage = $totalTrainees > 0 ? round(($hasPortfolio / $totalTrainees) * 100, 1) : 0;

            $this->stats = [
                'total_trainees' => $totalTrainees,
                'psychometric' => [
                    'count' => $totalTestTakers,
                    'trainee_count' => $traineeTestTakers,
                    'guest_count' => $guestTestTakers,
                    'percentage' => $testPercentage,
                ],
                'career_guidance' => [
                    'total_count' => $counselingTotal,
                    'requested_count' => $counselingRequested,
                    'completed_count' => $counselingCompleted,
                    'percentage' => $careerPercentage,
                ],
                'employment_support' => [
                    'count' => $hasPortfolio,
                    'percentage' => $portfolioPercentage,
                ],
            ];

        } finally {
            $this->isLoading = false;
        }
    }

    // Các hàm Helper xử lý date dropdown
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
            'all_time' => trans('admin/performance.All Time'),
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

    // Lấy thông tin completion
    public function getCompletionRate(string $type): float
    {
        return $this->stats[$type]['percentage'] ?? 0;
    }

    public function getCompletionCount(string $type): int
    {
        if ($type === 'career_guidance') {
            return $this->stats[$type]['completed_count'] ?? 0;
        }
        return $this->stats[$type]['count'] ?? 0;
    }

    public function getOverallCompletionRate(): float
    {
        $total = 0;
        $count = 0;

        foreach (['psychometric', 'career_guidance', 'employment_support'] as $type) {
            if (isset($this->stats[$type])) {
                $total += $this->stats[$type]['percentage'];
                $count++;
            }
        }

        return $count > 0 ? round($total / $count, 1) : 0;
    }

    public function hasHeadOfficeFilter(): bool
    {
        return $this->isSuperAdmin() && $this->headOfficeFilter && !empty(trim($this->headOfficeFilter));
    }

    public function getCurrentHeadOfficeFilter(): ?string
    {
        return $this->headOfficeFilter;
    }
}
