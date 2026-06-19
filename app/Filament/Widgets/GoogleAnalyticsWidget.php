<?php

namespace App\Filament\Widgets;

use App\Services\GoogleAnalyticsService;
use Filament\Widgets\Widget;
use Livewire\Attributes\Url;

class GoogleAnalyticsWidget extends Widget
{
    protected static string $view = 'filament.widgets.google-analytics-widget';

    // Set widget width to span the full dashboard page
    protected int | string | array $columnSpan = 'full';

    // Synchronized filters (can be query parameters in the URL if needed)
    #[Url]
    public string $dateRange = '7days';

    #[Url]
    public string $activeMetric = 'activeUsers';

    #[Url]
    public string $activeDimension = 'pageTitle';

    // Variables synchronized to the frontend for Alpine.js
    public bool $isConfigured = false;
    public ?string $configError = null;
    public array $overview = [];
    public array $chartLabels = [];
    public array $chartValues = [];
    public string $metricLabel = '';
    public string $metricColor = '#3b82f6';
    public array $breakdown = [];

    /**
     * List of supported date range filter options.
     */
    public function getDateRanges(): array
    {
        return [
            'today' => __('admin/dashboard.ga.today'),
            'yesterday' => __('admin/dashboard.ga.yesterday'),
            '7days' => __('admin/dashboard.ga.7days'),
            '30days' => __('admin/dashboard.ga.30days'),
            '90days' => __('admin/dashboard.ga.90days'),
        ];
    }

    /**
     * List of main metrics supported for filtering and display.
     */
    public function getMetricsList(): array
    {
        return [
            'activeUsers' => [
                'label' => __('admin/dashboard.ga.active_users'),
                'description' => __('admin/dashboard.ga.active_users_desc'),
                'color' => '#3b82f6', // Blue
            ],
            'screenPageViews' => [
                'label' => __('admin/dashboard.ga.page_views'),
                'description' => __('admin/dashboard.ga.page_views_desc'),
                'color' => '#10b981', // Green
            ],
            'sessions' => [
                'label' => __('admin/dashboard.ga.sessions'),
                'description' => __('admin/dashboard.ga.sessions_desc'),
                'color' => '#f59e0b', // Amber/Orange
            ],
        ];
    }

    /**
     * List of dimensions for breakdown in the details table.
     */
    public function getDimensionsList(): array
    {
        return [
            'pagePath' => __('admin/dashboard.ga.pagePath'),
            'pageTitle' => __('admin/dashboard.ga.pageTitle'),
            'deviceCategory' => __('admin/dashboard.ga.deviceCategory'),
            'sessionSourceMedium' => __('admin/dashboard.ga.sessionSourceMedium'),
            'country' => __('admin/dashboard.ga.country'),
            'city' => __('admin/dashboard.ga.city'),
        ];
    }

    /**
     * Get date range boundaries based on date range key.
     */
    protected function getDateRangeBoundaries(): array
    {
        switch ($this->dateRange) {
            case 'today':
                return ['start' => 'today', 'end' => 'today'];
            case 'yesterday':
                return ['start' => 'yesterday', 'end' => 'yesterday'];
            case '30days':
                return ['start' => '30daysAgo', 'end' => 'today'];
            case '90days':
                return ['start' => '90daysAgo', 'end' => 'today'];
            case '7days':
            default:
                return ['start' => '7daysAgo', 'end' => 'today'];
        }
    }

    /**
     * Prepare view data for rendering in the Blade template.
     */
    protected function getViewData(): array
    {
        $service = app(GoogleAnalyticsService::class);

        // Case when Google Analytics is not configured
        if (!$service->isConfigured()) {
            $this->isConfigured = false;
            $this->configError = $service->getConfigError();
            $this->overview = [
                'activeUsers' => 0,
                'sessions' => 0,
                'screenPageViews' => 0,
                'averageSessionDuration' => '0s',
            ];
            $this->chartLabels = [];
            $this->chartValues = [];
            $this->metricLabel = '';
            $this->metricColor = '#3b82f6';
            $this->breakdown = [];
            return [];
        }

        $this->isConfigured = true;
        $this->configError = null;

        $boundaries = $this->getDateRangeBoundaries();

        // 1. Fetch overview stats (4 cards)
        $this->overview = $service->getOverviewStats($boundaries['start'], $boundaries['end']);

        // 2. Fetch trend chart data based on selected metric
        $trendData = $service->getDailyTrend($boundaries['start'], $boundaries['end'], $this->activeMetric);
        $this->chartLabels = array_keys($trendData);
        $this->chartValues = array_values($trendData);

        // 3. Fetch detailed breakdown data
        $this->breakdown = $service->getDimensionBreakdown(
            $boundaries['start'],
            $boundaries['end'],
            $this->activeDimension,
            $this->activeMetric,
            7 // Get top 7 items
        );

        // Fetch color and label configuration for current active metric
        $metricConfig = $this->getMetricsList()[$this->activeMetric] ?? $this->getMetricsList()['activeUsers'];
        $this->metricLabel = $metricConfig['label'];
        $this->metricColor = $metricConfig['color'];

        // Dispatch event to update chart data in Alpine.js frontend
        $this->dispatch('analytics-data-updated', 
            labels: $this->chartLabels,
            values: $this->chartValues,
            color: $this->metricColor,
            label: $this->metricLabel
        );

        return [];
    }
}
