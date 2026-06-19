<?php

namespace App\Filament\Resources\CounselingResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Services\Admin\CounselingService;
use Carbon\Carbon;
use Livewire\Attributes\On;

class CounselingOverviewChartWidget extends ChartWidget
{
    protected static ?string $heading;
    protected static ?string $maxHeight = '500px';
    protected static string $view = 'filament.widgets.custom-chart-widget';
    protected CounselingService $counseligService;

    // Variable storing the current page, defaults to 1
    public int $currentPage = 1;

    public function __construct()
    {
        $this->counseligService = new CounselingService(new \App\Models\CgoCounseling());
        self::$heading =__('admin/dashboard.counseling.title');
    }

    // --- RECEIVE THE PAGE NUMBER EVENT ---
    #[On('update-chart-page')]
    public function updateChartPage(int $page = 1): void
    {
        $this->currentPage = $page;
        $this->updateChartData();
    }
    // -----------------------------

    protected function getData(): array
    {
        // Get all data
        $allData = $this->counseligService->getCounselingChart();

        // Slice the data by page
        $perPage = 5;
        $chunkData = $allData->forPage($this->currentPage, $perPage);

        // Reverse so older dates show on the left, newer on the right (if needed)
        $chartData = $chunkData->sortBy('date')->values();

        return [
            'datasets' => [
                [
                    'label' => 'Request',
                    'data' => $chartData->pluck('request_count'),
                    'backgroundColor' => '#4984F6',
                    'borderColor' => '#4984F6',
                ],
                [
                    'label' => 'Confirm',
                    'data' => $chartData->pluck('confirm_count'),
                    'backgroundColor' => '#E6447F',
                    'borderColor' => '#E6447F',
                ],
                [
                    'label' => 'Completed',
                    'data' => $chartData->pluck('completed_count'),
                    'backgroundColor' => '#28A745',
                    'borderColor' => '#28A745',
                ],
            ],
            'labels' => $chartData->map(fn($item) => Carbon::parse($item->date)->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): ?array
    {
        return [
            'responsive' => true,
            'scales' => [
                'x' => ['stacked' => false, 'barThickness' => 20],
                'y' => ['beginAtZero' => true],
            ],
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
        ];
    }
}
