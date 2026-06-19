<?php

namespace App\Filament\Resources\QuestionsAndAnswersResource\Widgets;

use App\Models\QNA;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class QuestionAndAnswersChartWidget extends ChartWidget
{
    protected static ?string $heading;
    protected static string $view = 'filament.widgets.custom-chart-widget';
    protected static ?string $maxHeight = '500px';

    public int $currentPage = 1;

    public function __construct()
    {
        self::$heading = __('admin/dashboard.qna.title_chart');
    }

    #[On('update-qna-chart-page')]
    public function updateChartPage(int $page = 1): void
    {
        $this->currentPage = $page;
        $this->updateChartData();
    }

    protected function getData(): array
    {
        // 1. Get all data (sorted DESC - newest first)
        $allData = $this->getAllQNAsStats();

        // 2. Slice the data by current page (5 rows per page)
        // Page 1: rows 1-5 (5 most recent days)
        // Page 2: rows 6-10 (5 older days)
        $chunkData = $allData->forPage($this->currentPage, 5);

        // 3. Reverse for display on the chart (older dates on the left -> newer dates on the right)
        $chartData = $chunkData->sortBy('date')->values();

        return [
            'datasets' => [
                [
                    'label' => 'Trainee',
                    'data' => $chartData->pluck('trainee_count'),
                    'backgroundColor' => '#4984F6',
                ],
                [
                    'label' => 'CGO',
                    'data' => $chartData->pluck('cgo_count'),
                    'backgroundColor' => '#46b392',
                ],
                [
                    'label' => 'Company',
                    'data' => $chartData->pluck('company_count'),
                    'backgroundColor' => '#9966FF',
                ],
            ],
            'labels' => $chartData->map(fn ($item) => Carbon::parse($item->date)->format('d/m (D)')),
        ];
    }

    private function getAllQNAsStats()
    {
        return QNA::selectRaw("
                DATE(created_at) as date,
                COUNT(CASE WHEN system = 'cgo' THEN 1 ELSE NULL END) as cgo_count,
                COUNT(CASE WHEN system = 'company' THEN 1 ELSE NULL END) as company_count,
                COUNT(CASE WHEN system = 'trainee' THEN 1 ELSE NULL END) as trainee_count,
                COUNT(*) as total_count
            ")
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy('date', 'DESC') // Must sort DESC to match the table order
            // NO LIMIT HERE
            ->get();
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // ... getOptions unchanged
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
