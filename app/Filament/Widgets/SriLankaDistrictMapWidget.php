<?php

namespace App\Filament\Widgets;

use App\Models\CgoUser;
use App\Models\District;
use App\Models\TraineeUser;
use App\Models\Institute;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SriLankaDistrictMapWidget extends Widget
{
    protected static string $view = 'filament.widgets.sri-lanka-district-map';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public string $userType = 'cgo';

    // Đổi từ dateFilter sang dateRange cho đồng bộ
    public ?string $dateRange = 'this_month';
    public ?string $headOfficeFilter = null;

    // Nhận data từ page
    public array $data = [];

    // Lưu thông tin người dùng hiện tại
    protected ?string $currentUserRole = null;
    protected ?string $currentUserTvetType = null;

    // Thêm traineeStats
    public array $traineeStats = [];

    public function mount(): void
    {
        $this->initializeUserPermissions();
        $this->initializeHeadOfficeFilter();
    }

    protected function initializeHeadOfficeFilter(): void
    {
        if (!$this->isSuperAdmin()) {
            $this->headOfficeFilter = null;
            return;
        }

        $headOffice = $this->data['head_office'] ?? null;

        if ($headOffice && is_string($headOffice) && !empty(trim($headOffice))) {
            $this->headOfficeFilter = trim($headOffice);
            Log::info('Head office filter applied from page data:', ['head_office' => $this->headOfficeFilter]);
        } else {
            $this->headOfficeFilter = null;
        }
    }

    public static function canView(): bool
    {
        $user = auth('admin')->user();
        return $user && ($user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('naita_admin'));
    }

    protected function initializeUserPermissions(): void
    {
        $user = auth('admin')->user();

        if ($user && $user->hasRole('super_admin')) {
            $this->currentUserRole = 'super_admin';
            $this->currentUserTvetType = null;
        } elseif ($user && ($user->hasRole('admin') || $user->hasRole('naita_admin'))) {
            $this->currentUserRole = 'admin';
            $this->currentUserTvetType = $user->tvet_type ?? null;
        } else {
            $this->currentUserRole = 'user';
            $this->currentUserTvetType = null;
        }
    }

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

    // Bảng dịch ID Database sang ID của thẻ <path> trong file SVG Simplemaps
    protected function getSvgIdMapping(): array
    {
        return [
            'D10' => 'LK11', '10' => 'LK11', 'D11' => 'LK13', '11' => 'LK13',
            'D12' => 'LK12', '12' => 'LK12', 'D13' => 'LK32', '13' => 'LK32',
            'D14' => 'LK31', '14' => 'LK31', 'D15' => 'LK33', '15' => 'LK33',
            'D16' => 'LK41', '16' => 'LK41', 'D17' => 'LK44', '17' => 'LK44',
            'D18' => 'LK23', '18' => 'LK23', 'D19' => 'LK22', '19' => 'LK22',
            'D20' => 'LK43', '20' => 'LK43', 'D21' => 'LK21', '21' => 'LK21',
            'D22' => 'LK45', '22' => 'LK45', 'D23' => 'LK42', '23' => 'LK42',
            'D25' => 'LK51', '25' => 'LK51', 'D26' => 'LK52', '26' => 'LK52',
            'D27' => 'LK53', '27' => 'LK53', 'D28' => 'LK71', '28' => 'LK71',
            'D29' => 'LK72', '29' => 'LK72', 'D30' => 'LK81', '30' => 'LK81',
            'D31' => 'LK82', '31' => 'LK82', 'D32' => 'LK91', '32' => 'LK91',
            'D33' => 'LK92', '33' => 'LK92', 'D35' => 'LK61', '35' => 'LK61',
            'D36' => 'LK62', '36' => 'LK62',
            'Colombo' => 'LK11', 'Kalutara' => 'LK13', 'Gampaha' => 'LK12',
            'Matara' => 'LK32', 'Galle' => 'LK31', 'Hambantota' => 'LK33',
            'Jaffna' => 'LK41', 'Vavuniya' => 'LK44', 'Nuwara Eliya' => 'LK23',
            'Matale' => 'LK22', 'Mannar' => 'LK43', 'Kandy' => 'LK21',
            'Mullaitivu' => 'LK45', 'Kilinochchi' => 'LK42', 'Batticaloa' => 'LK51',
            'Ampara' => 'LK52', 'Trincomalee' => 'LK53', 'Anuradhapura' => 'LK71',
            'Polonnaruwa' => 'LK72', 'Badulla' => 'LK81', 'Monaragala' => 'LK82',
            'Ratnapura' => 'LK91', 'Kegalle' => 'LK92', 'Kurunegala' => 'LK61',
            'Puttalam' => 'LK62',
        ];
    }

    protected function formatData($districts, $counts): array
    {
        $totalSum = array_sum($counts);
        $mapping = $this->getSvgIdMapping();
        $data = [];

        foreach ($districts as $district) {
            $count = $counts[$district->id] ?? 0;
            // Tính phần trăm dựa trên TỔNG SỐ, không phải giá trị lớn nhất
            $percentage = $totalSum > 0 ? round(($count / $totalSum) * 100, 1) : 0;

            // Xác định màu dựa trên phần trăm, KHỚP VỚI LEGEND
            $color = '#f3f4f6'; // Màu cho 0%
            if ($percentage > 0) {
                if ($percentage <= 20) $color = '#fee2e2';
                elseif ($percentage <= 40) $color = '#fecaca';
                elseif ($percentage <= 60) $color = '#fca5a5';
                elseif ($percentage <= 80) $color = '#f87171';
                else $color = '#ef4444';
            }

            $cleanId = strtoupper(trim((string)$district->id));
            $cleanName = trim($district->name);
            $svgId = $mapping[$cleanId] ?? $mapping[$cleanName] ?? ('UNKNOWN_' . $district->id);

            $data[$svgId] = [
                'name' => $district->name,
                'count' => $count,
                'percentage' => $percentage,
                'color' => $color,
            ];
        }

        return $data;
    }

    #[\Livewire\Attributes\Computed]
    public function mapData(): array
    {
        $this->ensurePermissionsInitialized();
        $districts = District::all();

        if (!$this->isSuperAdmin() && !$this->isAdmin()) {
            return $this->formatData($districts, []);
        }

        if ($this->userType === 'cgo') {
            return $this->getCgoDataByDistrict($districts);
        }

        return $this->getTraineeDataByDistrict($districts);
    }

    protected function getCgoDataByDistrict($districts): array
    {
        $this->ensurePermissionsInitialized();
        $bounds = $this->getDateRangeBounds();

        if ($this->isSuperAdmin()) {
            $query = CgoUser::query()
                ->whereNotNull('verify_at')
                ->whereNotNull('verify_by')
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id');

            if ($this->headOfficeFilter && !empty(trim($this->headOfficeFilter))) {
                $query->where('institutes.institute_head_office', $this->headOfficeFilter);
            }

            // Áp dụng bộ lọc thời gian
            if ($bounds) {
                $query->whereBetween('cgo_users.created_at', $bounds);
            }

            $counts = $query->select('institutes.dist_id', DB::raw('COUNT(*) as total'))
                ->groupBy('institutes.dist_id')
                ->pluck('total', 'dist_id')
                ->toArray();

            return $this->formatData($districts, $counts);
        }

        if ($this->isAdmin()) {
            $allowedInstituteIds = $this->getAllowedInstituteIds();

            if (empty($allowedInstituteIds)) {
                return $this->formatData($districts, []);
            }

            $query = CgoUser::query()
                ->whereNotNull('verify_at')
                ->whereNotNull('verify_by')
                ->whereIn('cgo_users.institute_id', $allowedInstituteIds)
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id');

            // Áp dụng bộ lọc thời gian
            if ($bounds) {
                $query->whereBetween('cgo_users.created_at', $bounds);
            }

            $counts = $query->select('institutes.dist_id', DB::raw('COUNT(*) as total'))
                ->groupBy('institutes.dist_id')
                ->pluck('total', 'dist_id')
                ->toArray();

            return $this->formatData($districts, $counts);
        }

        return $this->formatData($districts, []);
    }

    protected function getTraineeDataByDistrict($districts): array
    {
        $this->ensurePermissionsInitialized();
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            $this->traineeStats = [
                'total_trainees' => 0,
                'unique_trainees' => 0,
                'total_enrollments' => 0,
            ];
            return $this->formatData($districts, []);
        }

        $baseQuery = DB::table('trainee_users')
            ->join('trainee_institutes', 'trainee_users.id', '=', 'trainee_institutes.trainee_id')
            ->join('institutes', 'trainee_institutes.institute_id', '=', 'institutes.id')
            ->where('trainee_users.active', true)
            ->whereIn('institutes.id', $allowedInstituteIds);

        // Áp dụng bộ lọc thời gian
        $bounds = $this->getDateRangeBounds();
        if ($bounds) {
            $baseQuery->whereBetween('trainee_users.created_at', $bounds);
        }

        $uniqueTrainees = (clone $baseQuery)->distinct('trainee_users.id')->count('trainee_users.id');
        $totalEnrollments = $baseQuery->count();
        $totalActiveTrainees = TraineeUser::where('active', true)->count();

        $this->traineeStats = [
            'total_trainees' => $totalActiveTrainees,
            'unique_trainees' => $uniqueTrainees,
            'total_enrollments' => $totalEnrollments,
        ];

        // Query cho $counts array
        $countsQuery = DB::table('trainee_users')
            ->join('trainee_institutes', 'trainee_users.id', '=', 'trainee_institutes.trainee_id')
            ->join('institutes', 'trainee_institutes.institute_id', '=', 'institutes.id')
            ->where('trainee_users.active', true)
            ->whereIn('institutes.id', $allowedInstituteIds);

        if ($bounds) {
            $countsQuery->whereBetween('trainee_users.created_at', $bounds);
        }

        $counts = $countsQuery->select('institutes.dist_id', DB::raw('COUNT(DISTINCT trainee_users.id) as total'))
            ->groupBy('institutes.dist_id')
            ->pluck('total', 'dist_id')
            ->toArray();

        return $this->formatData($districts, $counts);
    }

    /**
     * Logic đồng bộ cho các bộ lọc ngày tháng
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

    protected function getDateRangeBounds(): ?array
    {
        $now = Carbon::now();

        switch ($this->dateRange) {
            case 'all_time':
                return null;
            case 'this_month':
                return [$now->copy()->startOfMonth()->format('Y-m-d 00:00:00'), $now->copy()->endOfMonth()->format('Y-m-d 23:59:59')];
            case 'last_month':
                return [$now->copy()->subMonth()->startOfMonth()->format('Y-m-d 00:00:00'), $now->copy()->subMonth()->endOfMonth()->format('Y-m-d 23:59:59')];
            case 'this_year':
                return [$now->copy()->startOfYear()->format('Y-m-d 00:00:00'), $now->copy()->endOfYear()->format('Y-m-d 23:59:59')];
            case 'last_year':
                return [$now->copy()->subYear()->startOfYear()->format('Y-m-d 00:00:00'), $now->copy()->subYear()->endOfYear()->format('Y-m-d 23:59:59')];
            default:
                if (preg_match('/^year_(\d{4})$/', $this->dateRange, $matches)) {
                    $year = (int) $matches[1];
                    return [Carbon::create($year, 1, 1)->startOfDay(), Carbon::create($year, 12, 31)->endOfDay()];
                }
                return [$now->copy()->startOfMonth()->format('Y-m-d 00:00:00'), $now->copy()->endOfMonth()->format('Y-m-d 23:59:59')];
        }
    }

    public function resetDateRange(): void
    {
        $this->dateRange = 'this_month';
        unset($this->mapData); // Clear cache property
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

        $bounds = $this->getDateRangeBounds();
        if ($bounds) {
            $start = Carbon::parse($bounds[0]);
            $end = Carbon::parse($bounds[1]);

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

    public function getTraineeStats(): array
    {
        return $this->traineeStats;
    }

    public function getHeadOfficeOptions(): array
    {
        if (!$this->isSuperAdmin()) {
            return [];
        }

        return Institute::select('institute_head_office')
            ->whereNotNull('institute_head_office')
            ->distinct()
            ->pluck('institute_head_office')
            ->filter()
            ->values()
            ->toArray();
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
