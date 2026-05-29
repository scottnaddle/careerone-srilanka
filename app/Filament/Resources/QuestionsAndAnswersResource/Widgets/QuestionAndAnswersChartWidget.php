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
        // 1. Lấy toàn bộ dữ liệu (Sort DESC - Mới nhất lên đầu)
        $allData = $this->getAllQNAsStats();

        // 2. Cắt dữ liệu theo trang hiện tại (5 dòng mỗi trang)
        // Trang 1: Lấy dòng 1-5 (5 ngày mới nhất)
        // Trang 2: Lấy dòng 6-10 (5 ngày cũ hơn)
        $chunkData = $allData->forPage($this->currentPage, 5);

        // 3. Đảo ngược lại để hiển thị trên biểu đồ (Ngày cũ bên trái -> Ngày mới bên phải)
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
            ->orderBy('date', 'DESC') // Bắt buộc Sort DESC để khớp thứ tự với Table
            // KHÔNG CÓ LIMIT Ở ĐÂY
            ->get();
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // ... getOptions giữ nguyên
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
