<?php

namespace App\Filament\Widgets;

use App\Models\TraineeUser;
use App\Models\NVQLevel;
use App\Models\Institute;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NvqLevelPyramid extends Widget
{
    protected static string $view = 'filament.widgets.nvq-level-pyramid';

    protected static bool $isLazy = false;

    public ?string $dateRange = 'this_month';
    public ?string $headOfficeFilter = null;

    public array $data = [];

    protected int | string | array $columnSpan = 'full';

    protected ?string $currentUserRole = null;
    protected ?string $currentUserTvetType = null;

    public function mount(): void
    {
        $this->initializeUserPermissions();
        $this->initializeHeadOfficeFilter();
    }

    protected function initializeHeadOfficeFilter(): void
    {
        // If naita_admin, no filter needed (already handled in getAllowedInstituteIds)
        if ($this->isNaitaAdmin()) {
            $this->headOfficeFilter = null;
            return;
        }

        if (!$this->isSuperAdmin()) {
            $this->headOfficeFilter = null;
            return;
        }

        $headOffice = $this->data['head_office'] ?? null;

        if ($headOffice && is_string($headOffice) && !empty(trim($headOffice))) {
            $this->headOfficeFilter = trim($headOffice);
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
        } elseif ($user && $user->hasRole('naita_admin')) {
            $this->currentUserRole = 'naita_admin';
            $this->currentUserTvetType = 'NAITA'; // Defaults to NAITA
        } elseif ($user && $user->hasRole('admin')) {
            $this->currentUserRole = 'admin';
            $this->currentUserTvetType = $user->tvet_type ?? null;
        } else {
            $this->currentUserRole = 'user';
            $this->currentUserTvetType = null;
        }
    }
    protected function isNaitaAdmin(): bool
    {
        $this->ensurePermissionsInitialized();
        return $this->currentUserRole === 'naita_admin';
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

        if ($this->isNaitaAdmin()) {
            // Naita admin gets all institutes with head_office = 'NAITA'
            return Institute::where('institute_head_office', 'NAITA')
                ->pluck('id')
                ->toArray();
        }

        if ($this->isAdmin() && $this->currentUserTvetType) {
            return Institute::where('institute_head_office', $this->currentUserTvetType)
                ->pluck('id')
                ->toArray();
        }

        return [];
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
        // Send the new data down to the frontend
        $this->dispatch('updateNvqChart', data: $this->chartData);
    }

    public function updatedDateRange(): void
    {
        // Send the new data down to the frontend
        $this->dispatch('updateNvqChart', data: $this->chartData);
    }

    public function getDateRangeLabel(): string
    {
        $labels = [
            'all_time' => trans('admin/performance.All Time'),
            'this_month' =>trans('admin/performance.This Month'),
            'last_month' => trans('admin/performance.Last Month'),
            'this_year' => trans('admin/performance.This Year'),
//            'last_year' => 'Last Year',
        ];

        if (preg_match('/^year_(\d{4})$/', $this->dateRange, $matches)) {
            return $matches[1];
        }

        return $labels[$this->dateRange] ?? 'This Month';
    }

    public function getDateRangeDescription(): string
    {
        if ($this->dateRange === 'all_time') {
            return trans('admin/performance.All historical data');
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

    protected function applyInstituteFilter($query): void
    {
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            $query->whereRaw('1 = 0');
            return;
        }

        $query->whereHas('institutes', function ($q) use ($allowedInstituteIds) {
            $q->whereIn('institutes.id', $allowedInstituteIds);
        });
    }

    protected function applyInstituteFilterToRawQuery($query, string $alias = 'trainee_users'): void
    {
        $allowedInstituteIds = $this->getAllowedInstituteIds();

        if (empty($allowedInstituteIds)) {
            $query->whereRaw('1 = 0');
            return;
        }

        $query->whereIn("{$alias}.id", function ($subQuery) use ($allowedInstituteIds) {
            $subQuery->select('trainee_id')
                ->from('trainee_institutes')
                ->whereIn('institute_id', $allowedInstituteIds);
        });
    }


    #[\Livewire\Attributes\Computed]
    public function nvqData(): array
    {
        try {
            $levels = NVQLevel::where('level', '!=', 'No NVQ')
                ->orderByRaw('CAST(SUBSTRING(level FROM 2) AS INTEGER)')
                ->get();

            $allowedInstituteIds = $this->getAllowedInstituteIds();

            if (empty($allowedInstituteIds)) {
                return [];
            }

            // Get the list of trainees with their highest NVQ
            $traineeHighestNvq = DB::table('trainee_users')
                ->join('trainee_n_v_q_s', 'trainee_users.id', '=', 'trainee_n_v_q_s.trainee_id')
                ->join('n_v_q_levels', 'trainee_n_v_q_s.nvq_id', '=', 'n_v_q_levels.id')
                ->where('trainee_users.active', true);

            $bounds = $this->getDateRangeBounds();
            if ($bounds) {
                $traineeHighestNvq->whereBetween('trainee_users.created_at', $bounds);
            }

            $this->applyInstituteFilterToRawQuery($traineeHighestNvq, 'trainee_users');

            // Subquery to get each trainee with a single, unique NVQ
            $subQuery = $traineeHighestNvq
                ->select(
                    'trainee_users.id',
                    'n_v_q_levels.level',
                    DB::raw('ROW_NUMBER() OVER (PARTITION BY trainee_users.id ORDER BY CAST(SUBSTRING(n_v_q_levels.level FROM 2) AS INTEGER) DESC) as rn')
                );

            $counts = DB::table(DB::raw("({$subQuery->toSql()}) as ranked"))
                ->mergeBindings($subQuery)
                ->where('rn', 1)
                ->select('level', DB::raw('COUNT(*) as total'))
                ->groupBy('level')
                ->pluck('total', 'level')
                ->toArray();

            // Count No NVQ
            $noNvqQuery = TraineeUser::query()
                ->where('active', true)
                ->whereNotExists(function($q) {
                    $q->select(DB::raw(1))
                        ->from('trainee_n_v_q_s')
                        ->whereColumn('trainee_n_v_q_s.trainee_id', 'trainee_users.id');
                });

            if ($bounds) {
                $noNvqQuery->whereBetween('created_at', $bounds);
            }

            $this->applyInstituteFilter($noNvqQuery);

            $noNvqCount = $noNvqQuery->count();
            $counts['No NVQ'] = $noNvqCount;

            $colors = [
                'L1' => '#3b82f6',
                'L2' => '#10b981',
                'L3' => '#f59e0b',
                'L4' => '#ef4444',
                'L5' => '#8b5cf6',
                'L6' => '#ec489a',
                'L7' => '#06b6d4',
                'No NVQ' => '#9ca3af',
            ];

            $data = [];
            $totalStudents = $this->totalStudents;

            foreach ($levels as $level) {
                $count = $counts[$level->level] ?? 0;
                $data[$level->level] = [
                    'count' => $count,
                    'percentage' => $totalStudents > 0 ? round(($count / $totalStudents) * 100, 1) : 0,
                    'color' => $colors[$level->level] ?? '#9ca3af',
                ];
            }

            $data['No NVQ'] = [
                'count' => $noNvqCount,
                'percentage' => $totalStudents > 0 ? round(($noNvqCount / $totalStudents) * 100, 1) : 0,
                'color' => $colors['No NVQ'],
            ];

            return $data;
        } catch (\Exception $e) {
            Log::error('Error in getNvqDataProperty: ' . $e->getMessage());
            return [];
        }
    }

    #[\Livewire\Attributes\Computed]
    public function totalStudents(): int
    {
        try {
            $query = TraineeUser::query()->where('active', true);

            $bounds = $this->getDateRangeBounds();
            if ($bounds) {
                $query->whereBetween('created_at', $bounds);
            }

            $this->applyInstituteFilter($query);
            return $query->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    #[\Livewire\Attributes\Computed]
    public function averageLevel(): float
    {
        try {
            $allowedInstituteIds = $this->getAllowedInstituteIds();
            if (empty($allowedInstituteIds)) return 0;

            $query = DB::table('trainee_users')
                ->join('trainee_n_v_q_s', 'trainee_users.id', '=', 'trainee_n_v_q_s.trainee_id')
                ->join('n_v_q_levels', 'trainee_n_v_q_s.nvq_id', '=', 'n_v_q_levels.id')
                ->where('trainee_users.active', true);

            $bounds = $this->getDateRangeBounds();
            if ($bounds) {
                $query->whereBetween('trainee_users.created_at', $bounds);
            }

            $this->applyInstituteFilterToRawQuery($query, 'trainee_users');

            $levels = $query->pluck('n_v_q_levels.level');
            if ($levels->isEmpty()) return 0;

            $numericLevels = $levels->map(function($level) {
                return (int) str_replace('L', '', $level);
            });

            return round($numericLevels->avg(), 2);
        } catch (\Exception $e) {
            return 0;
        }
    }

    #[\Livewire\Attributes\Computed]
    public function mostPopularLevel(): string
    {
        try {
            $data = $this->nvqData;
            if (empty($data)) return 'N/A';

            // Filter to keep only levels with count > 0
            $nonZeroData = array_filter($data, fn($item) => $item['count'] > 0);

            // If no level has count > 0
            if (empty($nonZeroData)) {
                return 'None';
            }

            $maxCount = max(array_column($nonZeroData, 'count'));
            $popularLevels = array_filter($nonZeroData, fn($item) => $item['count'] === $maxCount);

            if (empty($popularLevels)) return 'None';

            return implode(', ', array_keys($popularLevels));
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function chartData(): array
    {
        try {
            $data = $this->nvqData;
            $orderedKeys = ['L1', 'L2', 'L3', 'L4', 'L5', 'L6', 'L7', 'No NVQ'];

            $labels = [];
            $values = [];
            $colors = [];

            foreach ($orderedKeys as $key) {
                if (isset($data[$key])) {
                    $labels[] = $key;
                    $values[] = $data[$key]['count'];
                    $colors[] = $data[$key]['color'];
                }
            }

            return [
                'labels' => $labels,
                'values' => $values,
                'colors' => $colors,
            ];
        } catch (\Exception $e) {
            return ['labels' => [], 'values' => [], 'colors' => []];
        }
    }

    public function getTotalEnrollmentsProperty(): int
    {
        return $this->totalStudents;
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
