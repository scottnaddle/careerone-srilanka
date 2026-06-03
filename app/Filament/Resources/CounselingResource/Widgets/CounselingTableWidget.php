<?php

namespace App\Filament\Resources\CounselingResource\Widgets;

use App\Models\QNAAnswer;
use Filament\Widgets\ChartWidget;

class CounselingTableWidget extends ChartWidget
{
    protected static ?string $heading = 'Q&A Weekly Chart';
    protected static string $view = 'filament.widgets.custom-chart-widget';
    protected static ?string $maxHeight = '500px';
    protected function getData(): array
    {
        $currentWeekData = $this->getQNAsForCurrentWeek()->get();
        if ($currentWeekData->isEmpty()) {
            return $this->getEmptyData();
        }

        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $dailyCounts = $this->getDailyCountsForCurrentWeek($currentWeekData, $daysOfWeek);
        return [
            'datasets' => [
                [
                    'label' => 'QNA Count',
                    'data' => $dailyCounts,
                    'backgroundColor' => '#4984F6',
                ],
            ],
            'labels' => $daysOfWeek,
        ];
    }
    
    private function getDailyCountsForCurrentWeek($items, $daysOfWeek)
    {
        $dailyCounts = array_fill(0, 7, 0);
    
        foreach ($items as $item) {
            $dayOfWeek = $item->day_of_week;
            $dailyCounts[$dayOfWeek] = $item->qna_count;
        }
    
        return $dailyCounts;
    }
    
    private function getQNAsForCurrentWeek()
    {
        return QNAAnswer::selectRaw("
                EXTRACT(dow FROM q_n_a_answers.created_at) as day_of_week,
                COUNT(*) as qna_count
            ")
            ->whereRaw("EXTRACT(week FROM q_n_a_answers.created_at) = EXTRACT(week FROM CURRENT_DATE)")
            ->whereRaw("EXTRACT(year FROM q_n_a_answers.created_at) = EXTRACT(year FROM CURRENT_DATE)")
            ->groupBy('day_of_week')
            ->orderBy('day_of_week', 'ASC');
    }
    
    private function getEmptyData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'QNA Count',
                    'data' => array_fill(0, 7, 0),
                    'backgroundColor' => '#4984F6',
                ],
            ],
            'labels' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
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
                'x' => [
                    'stacked' => false,
                    'barThickness' => 20,
                ],
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
        ];
    }
}
