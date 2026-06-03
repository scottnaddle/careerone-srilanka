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

    // Biến lưu trang hiện tại, mặc định là 1
    public int $currentPage = 1;

    public function __construct()
    {
        $this->counseligService = new CounselingService(new \App\Models\CgoCounseling());
        self::$heading =__('admin/dashboard.counseling.title');
    }

    // --- NHẬN SỰ KIỆN SỐ TRANG ---
    #[On('update-chart-page')]
    public function updateChartPage(int $page = 1): void
    {
        $this->currentPage = $page;
        $this->updateChartData();
    }
    // -----------------------------

    protected function getData(): array
    {
        // Lấy tất cả dữ liệu
        $allData = $this->counseligService->getCounselingChart();

        // Cắt dữ liệu theo trang
        $perPage = 5;
        $chunkData = $allData->forPage($this->currentPage, $perPage);

        // Đảo ngược để hiển thị ngày cũ bên trái, mới bên phải (nếu cần)
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
