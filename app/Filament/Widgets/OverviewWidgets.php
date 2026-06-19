<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Services\Admin\OverViewService;

class OverviewWidgets extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = '30s';
    protected int|string|array $columnSpan = 'full';
    protected int $columns = 4;
    protected OverViewService $overviewService;

    public function __construct()
    {
        $this->overviewService = app(OverViewService::class);
    }

    protected function getColumns(): int
    {
        return $this->columns;
    }

    protected function getStats(): array
    {
        $currentCount = $this->overviewService->countUnverifiedUsers();
        $previousCount = $this->overviewService->countUnverifiedUsersFromLastWeek();

        $data = $this->getStatsDataForRole($currentCount, $previousCount);

        return array_map(function ($stat) use ($previousCount) {
            $trend = $this->calculateTrend(
                $stat['current_value'] ?? $stat['value'],
                $stat['previous_value'] ?? 0
            );

            return Stat::make($stat['title'], $stat['value'])
                ->description($trend['label'])
                ->descriptionIcon($trend['icon'])
                ->color($stat['color'])
                ->url($stat['link'])
                ->chart($trend['chart_data'] ?? null);
        }, $data);
    }

    protected function getStatsDataForRole(array $currentCount, array $previousCount): array
    {
        if (!auth('admin')->check()) {
            return [];
        }

        $user = auth('admin')->user();
        $role = 'default';

        if ($user->hasRole('super_admin')) {
            $role = 'super_admin';
        } elseif ($user->hasRole('naita_admin')) {
            $role = 'naita_admin';
        }

        $roleConfigs = $this->getRoleConfigurations($currentCount, $previousCount);
        return $roleConfigs[$role] ?? $roleConfigs['default'];
    }

    protected function getRoleConfigurations(array $current, array $previous): array
    {
        $commonStats = [
            'cgo_approval' => [
                'title' => __('admin/dashboard.cgo_approval'),
                'value' => $current['unverified_cgo_users'] ?? 0,
                'previous_value' => $previous['unverified_cgo_users'] ?? 0,
                'color' => 'bg-[#FFB13D]',
                'link' => route('filament.admin.pages.cgo-approval-list'),
            ],
            'events_approval' => [
                'title' => __('admin/dashboard.events_approval'),
                'value' => $current['unverified_event_users'] ?? 0,
                'previous_value' => $previous['unverified_event_users'] ?? 0,
                'color' => 'bg-[#FFB13D]',
                'link' => route('filament.admin.resources.information.content.event-approval-lists.index'),
            ],
            'reactive_user' => [
                'title' => __('admin/dashboard.reactive_user'),
                'value' => $current['unverifiedReActiveCount'] ?? 0,
                'previous_value' => $previous['unverifiedReActiveCount'] ?? 0,
                'color' => 'bg-[#FFB13D]',
                'link' => '/admin/user-re-actives?tableFilters[approval][value]=requested',
            ],
        ];

        return [
            'super_admin' => array_merge($commonStats, [
                'company_approval' => [
                    'title' => __('admin/dashboard.company_approval'),
                    'value' => $current['unverifiedCompanyCount'] ?? 0,
                    'previous_value' => $previous['unverifiedCompanyCount'] ?? 0,
                    'color' => 'bg-[#FFB13D]',
                    'link' => route('filament.admin.pages.company-approval-list'),
                ],
                'company_recruiter' => [
                    'title' => __('admin/dashboard.company_recruiter'),
                    'value' => $current['unverified_company_recruiters'] ?? 0,
                    'previous_value' => $previous['unverified_company_recruiters'] ?? 0,
                    'color' => 'bg-[#FFB13D]',
                    'link' => route('filament.admin.resources.company-recruiter-approvals.index'),
                ],
                'admin_approval' => [
                    'title' => __('admin/dashboard.admin_approval'),
                    'value' => $current['unverified_admin_users'] ?? 0,
                    'previous_value' => $previous['unverified_admin_users'] ?? 0,
                    'color' => 'bg-[#FFB13D]',
                    'link' => route('filament.admin.pages.administrator-approval-list'),
                ],
                'contents_document' => [
                    'title' => __('admin/dashboard.contents_document_approval'),
                    'value' => $current['unverified_content'] ?? 0,
                    'previous_value' => $previous['unverified_content'] ?? 0,
                    'color' => 'bg-[#FFB13D]',
                    'link' => '/admin/content/documents?tableFilters[status][value]=0',
                ],
                'contents_video' => [
                    'title' => __('admin/dashboard.contents_video_approval'),
                    'value' => $current['unverified_video'] ?? 0,
                    'previous_value' => $previous['unverified_video'] ?? 0,
                    'color' => 'bg-[#FFB13D]',
                    'link' => '/admin/content/videos?tableFilters[status][value]=0',
                ],
            ]),
            'naita_admin' => array_merge($commonStats, [
                'company_approval' => [
                    'title' => __('admin/dashboard.company_approval'),
                    'value' => $current['unverifiedCompanyCount'] ?? 0,
                    'previous_value' => $previous['unverifiedCompanyCount'] ?? 0,
                    'color' => 'bg-[#FFB13D]',
                    'link' => route('filament.admin.pages.company-approval-list'),
                ],
                'company_recruiter' => [
                    'title' => __('admin/dashboard.company_recruiter'),
                    'value' => $current['unverified_company_recruiters'] ?? 0,
                    'previous_value' => $previous['unverified_company_recruiters'] ?? 0,
                    'color' => 'bg-[#FFB13D]',
                    'link' => route('filament.admin.resources.company-recruiter-approvals.index'),
                ],
            ]),
            'default' => array_values($commonStats),
        ];
    }

    protected function calculateTrend(int $currentValue, int $previousValue): array
    {
        $difference = $currentValue - $previousValue;
        $percentageChange = $previousValue > 0
            ? round(($difference / $previousValue) * 100, 1)
            : ($currentValue > 0 ? 100 : 0);

        $chartData = $this->getWeeklyChartData();

        if ($difference > 0) {
            return [
                'label' => "+{$difference} from last week",
                'icon' => 'heroicon-m-arrow-trending-up',
                'chart_data' => $chartData,
            ];
        } elseif ($difference < 0) {
            $absDifference = abs($difference);
            return [
                'label' => "-{$absDifference} from last week",
                'icon' => 'heroicon-m-arrow-trending-down',
                'chart_data' => $chartData,
            ];
        }

        return [
            'label' => 'No change from last week',
            'icon' => 'heroicon-m-arrows-right-left',
            'chart_data' => $chartData,
        ];
    }

    protected function getWeeklyChartData(): array
    {
        // You can implement this to return actual 7-day data
        // For now, returning sample data
        return [12, 15, 10, 18, 14, 20, $this->overviewService->countUnverifiedUsers()['unverified_cgo_users'] ?? 0];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.widgets.custom-stats-overview-widget', [
            'stats' => $this->getStats(),
        ]);
    }
}
