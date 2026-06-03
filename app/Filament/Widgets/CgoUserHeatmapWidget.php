<?php

namespace App\Filament\Widgets;

use App\Models\CgoUser;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CgoUserHeatmapWidget extends ChartWidget
{
    protected static ?string $heading = null;
    protected static ?string $maxHeight = '800px';

    public function getHeading(): string
    {
        return trans('admin/performance.CGO Activity Heatmap');
    }

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    // Filter mặc định
    public ?string $filter = 'this_month';

    protected function getData(): array
    {
        $users = $this->getUserActivityData();

        $datasets = [
            [
                'label' => trans('admin/performance.Logins'),
                'data' => $users->pluck('total_logins')->toArray(),
                'backgroundColor' => 'rgba(54, 162, 235, 0.8)',   // Xanh dương
                'borderColor' => '#ffffff',
                'borderWidth' => 1,
            ],
            [
                'label' => trans('admin/performance.Completed Counselings'),
                'data' => $users->pluck('total_completed_counselings')->toArray(),
                'backgroundColor' => 'rgba(255, 99, 132, 0.8)',   // Đỏ hồng
                'borderColor' => '#ffffff',
                'borderWidth' => 1,
            ],
            [
                'label' => trans('admin/performance.Contents Created'),
                'data' => $users->pluck('total_contents')->toArray(),
                'backgroundColor' => 'rgba(255, 206, 86, 0.8)',   // Vàng
                'borderColor' => '#ffffff',
                'borderWidth' => 1,
            ],
            [
                'label' => trans('admin/performance.Events Created'),
                'data' => $users->pluck('total_events')->toArray(),
                'backgroundColor' => 'rgba(75, 192, 192, 0.8)',   // Xanh ngọc
                'borderColor' => '#ffffff',
                'borderWidth' => 1,
            ],
            [
                'label' => trans('admin/performance.Q&A Answers'),
                'data' => $users->pluck('total_qna_answers')->toArray(),
                'backgroundColor' => 'rgba(153, 102, 255, 0.8)',  // Tím
                'borderColor' => '#ffffff',
                'borderWidth' => 1,
            ],
        ];

        return [
            'datasets' => $datasets,
            'labels' => $users->map(fn ($user) => $user->full_name)->toArray(),
        ];
    }

    protected function getUserActivityData()
    {
        $user = auth('admin')->user();
        $baseQuery = CgoUser::query()
            ->select('cgo_users.*');

        if (!$user->hasRole('super_admin')) {
            // Admin: only get CGOs from institutes with head_office = user's tvet_type
            $baseQuery->whereHas('institute', function ($query) use ($user) {
                $query->where('institute_head_office', $user->tvet_type);
            });
        }

        $baseQuery->selectSub(function ($query) {
            $query->selectRaw('COUNT(*)')
                ->from('activity_log')
                ->whereRaw('cgo_users.id::text = activity_log.causer_id::text')
                ->whereRaw('LOWER(activity_log.causer_type) = ?', [strtolower('App\Models\CGOUser')])
                ->where('activity_log.log_name', 'Access')
                ->whereRaw('activity_log.properties->>\'guard\' = ?', ['cgo']);

            $this->applyDateFilter($query, 'activity_log.created_at');
        }, 'total_logins')

            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('cgo_counselings')
                    ->join('cgo_counseling_assign_histories',
                        'cgo_counseling_assign_histories.counseling_id',
                        '=',
                        'cgo_counselings.id')
                    ->whereRaw('cgo_users.id::text = cgo_counseling_assign_histories.assignee_to::text')
                    ->where('cgo_counselings.status', 3);

                $this->applyDateFilter($query, 'cgo_counselings.created_at');
            }, 'total_completed_counselings')

            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('contents')
                    ->whereRaw('cgo_users.id::text = contents.created_by::text')
                    ->where('contents.system', 'cgo');

                $this->applyDateFilter($query, 'contents.created_at');
            }, 'total_contents')

            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('events')
                    ->whereRaw('cgo_users.id::text = events.created_by::text')
                    ->where('events.system', 'cgo')
                    ->where('events.status', 2); // Only approved events

                $this->applyDateFilter($query, 'events.created_at');
            }, 'total_events')

            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('q_n_a_answers')
                    ->whereRaw('cgo_users.id::text = q_n_a_answers.answer_by::text')
                    ->where('q_n_a_answers.system', 'cgo');

                $this->applyDateFilter($query, 'q_n_a_answers.created_at');
            }, 'total_qna_answers');

        // 2. Wrap the base query and apply the complex sorting on the evaluated aliases
        return CgoUser::query()
            ->fromSub($baseQuery, 'aggs')
            ->orderByRaw('(COALESCE(aggs.total_logins, 0) +
                  COALESCE(aggs.total_completed_counselings, 0) * 3 +
                  COALESCE(aggs.total_contents, 0) * 2 +
                  COALESCE(aggs.total_events, 0) * 2 +
                  COALESCE(aggs.total_qna_answers, 0)) DESC')
            ->limit(10)
            ->get();
    }

    /**
     * Logic filter ngày tháng đồng bộ với CgoCounselingStatsWidget
     */
    protected function applyDateFilter($query, $dateField)
    {
        $now = Carbon::now();

        switch ($this->filter) {
            case 'all_time':
                // Không thêm điều kiện where (lấy tất cả)
                break;

            case 'this_month':
                $query->whereBetween($dateField, [
                    $now->copy()->startOfMonth(),
                    $now->copy()->endOfMonth()
                ]);
                break;

            case 'last_month':
                $query->whereBetween($dateField, [
                    $now->copy()->subMonth()->startOfMonth(),
                    $now->copy()->subMonth()->endOfMonth()
                ]);
                break;

            case 'this_year':
                $query->whereBetween($dateField, [
                    $now->copy()->startOfYear(),
                    $now->copy()->endOfYear()
                ]);
                break;

            case 'last_year':
                $query->whereBetween($dateField, [
                    $now->copy()->subYear()->startOfYear(),
                    $now->copy()->subYear()->endOfYear()
                ]);
                break;

            default:
                // Xử lý các năm được chọn tự động (VD: year_2025, year_2026)
                if (preg_match('/^year_(\d{4})$/', $this->filter, $matches)) {
                    $year = (int) $matches[1];
                    $query->whereBetween($dateField, [
                        Carbon::create($year, 1, 1)->startOfDay(),
                        Carbon::create($year, 12, 31)->endOfDay()
                    ]);
                } else {
                    // Fallback mặc định
                    $query->whereBetween($dateField, [
                        $now->copy()->startOfMonth(),
                        $now->copy()->endOfMonth()
                    ]);
                }
                break;
        }
    }

    protected function generateHeatmapColors($values, $type)
    {
        $colors = [];
        $maxValue = match($type) {
            'logins' => 50,
            'counselings' => 20,
            'contents' => 30,   // Added for contents
            'events' => 15,
            'qnas' => 30,
            default => 10
        };

        foreach ($values as $value) {
            if ($value == 0) {
                $colors[] = '#f3f4f6'; // Gray for no activity
                continue;
            }

            $percentage = min(100, ($value / $maxValue) * 100);

            if ($percentage < 25) {
                $colors[] = '#e6f7e6'; // Very light green
            } elseif ($percentage < 50) {
                $colors[] = '#b3e6b3'; // Light green
            } elseif ($percentage < 75) {
                $colors[] = '#66cc66'; // Medium green
            } else {
                $colors[] = '#339933'; // Dark green
            }
        }

        return $colors;
    }

    /**
     * Khởi tạo danh sách filter trên giao diện ChartWidget
     */
    protected function getFilters(): ?array
    {
        $filters = [
            'all_time' => trans('admin/performance.All Time'),
            'this_month' => trans('admin/performance.This Month'),
            'last_month' => trans('admin/performance.Last Month'),
            'this_year' => trans('admin/performance.This Year'),
        ];

        // Lấy tự động các năm từ 2025 đến hiện tại giống widget trên
        $currentYear = (int) Carbon::now()->year;
        $startYear = 2025;

        for ($year = $currentYear-1; $year >= $startYear; $year--) {
            $filters["year_{$year}"] = (string) $year;
        }

        return $filters;
    }

    protected function getType(): string
    {
        return 'bar'; // Using bar chart as heatmap
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // Horizontal bars for better heatmap effect
            'responsive' => true,
            'maintainAspectRatio' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => trans('admin/performance.Activity Count'),
                    ],
                ],
                'y' => [
                    'title' => [
                        'display' => true,
                        'text' => trans('admin/performance.CGO Users'),
                    ],
                ],
            ],
        ];
    }
}
