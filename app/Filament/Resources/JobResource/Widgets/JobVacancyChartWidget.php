<?php

namespace App\Filament\Resources\JobResource\Widgets;

use App\Services\Admin\JobService;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On; // <--- Import this attribute

class JobVacancyChartWidget extends ChartWidget
{
    protected static ?string $heading;
    protected static string $view = 'filament.widgets.custom-chart-widget';
    protected static ?string $maxHeight = '500px';
    protected JobService $jobService;

    // Variable storing the list of Job IDs currently shown in the table
    public array $filterIds = [];

    public function __construct()
    {
        $this->jobService = new JobService(
            new \App\Models\Job()
        );
        self::$heading = __('admin/dashboard.job_vacancy_title');
    }

    // Method listening for the event from the table
    #[On('update-job-chart')]
    public function updateChartFilters(array $ids): void
    {
        $this->filterIds = $ids;
        $this->updateChartData(); // Refresh the chart
    }

    protected function getData(): array
    {
        // LOGIC:
        // 1. If filterIds is set (sent from the table), query the Jobs whose IDs are in that list.
        // 2. Otherwise (initial default), get the default data (should limit to 5 to match table page 1).

        if (!empty($this->filterIds)) {
            // Get the Jobs by the received IDs
            // Note: order by date desc to match the display order
            $data = \App\Models\Job::whereIn('id', $this->filterIds)
                ->orderBy('jobs.created_at', 'desc')
                ->get();
        } else {
            // Default: get the original data but limit to 5 rows (because the table defaults to paginated 5)
            // Assuming getJobChart returns a collection or builder, handle it similarly
            $data = $this->jobService->getAllJobPosting()
                ->orderBy('jobs.created_at', 'desc')
                ->limit(5)
                ->get();

            // Note: if your getJobChart() method already has complex logic,
            // you can use it but must ensure it supports limit/filter.
            // Here I query the model directly or use getAllJobPosting for easier control.
        }

        return [
            'datasets' => [
                [
                    'type' => 'bar',
                    'label' => __('admin/dashboard.job_vacancy.applied'),
                    'data' => $data->map(fn ($value) => $value->appliesTypeApply()->count()),
                    'backgroundColor' => '#4984F6',
                    'borderColor' => '#4984F6',
                    'order' => 2,
                ],
                [
                    'type' => 'bar',
                    'label' => __('admin/dashboard.job_vacancy.matched'),
                    'data' => $data->map(fn ($value) => $value->appliesTypeMatch()->count()),
                    'backgroundColor' => '#E6447F',
                    'borderColor' => '#E6447F',
                    'order' => 1,
                ],
            ],
            'labels' => $data->map(fn ($value) => Carbon::parse($value->date)->format('d/m (D)')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
