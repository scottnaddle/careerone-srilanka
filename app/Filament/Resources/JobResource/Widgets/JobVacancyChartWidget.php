<?php

namespace App\Filament\Resources\JobResource\Widgets;

use App\Services\Admin\JobService;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On; // <--- Import attribute này

class JobVacancyChartWidget extends ChartWidget
{
    protected static ?string $heading;
    protected static string $view = 'filament.widgets.custom-chart-widget';
    protected static ?string $maxHeight = '500px';
    protected JobService $jobService;

    // Biến lưu trữ danh sách ID các Job đang hiển thị bên Table
    public array $filterIds = [];

    public function __construct()
    {
        $this->jobService = new JobService(
            new \App\Models\Job()
        );
        self::$heading = __('admin/dashboard.job_vacancy_title');
    }

    // Hàm lắng nghe sự kiện từ Table
    #[On('update-job-chart')]
    public function updateChartFilters(array $ids): void
    {
        $this->filterIds = $ids;
        $this->updateChartData(); // Refresh lại chart
    }

    protected function getData(): array
    {
        // LOGIC:
        // 1. Nếu có filterIds (từ table gửi sang), ta query những Job có ID trong danh sách đó.
        // 2. Nếu không (mặc định ban đầu), ta lấy dữ liệu mặc định (nên limit 5 để khớp với table trang 1).

        if (!empty($this->filterIds)) {
            // Lấy các Job theo ID đã nhận được
            // Lưu ý: Cần order theo date desc để khớp thứ tự hiển thị
            $data = \App\Models\Job::whereIn('id', $this->filterIds)
                ->orderBy('jobs.created_at', 'desc')
                ->get();
        } else {
            // Mặc định: Lấy dữ liệu gốc nhưng limit 5 dòng (vì table mặc định paginated 5)
            // Giả sử getJobChart trả về collection hoặc builder, ta xử lý tương tự
            $data = $this->jobService->getAllJobPosting()
                ->orderBy('jobs.created_at', 'desc')
                ->limit(5)
                ->get();

            // Lưu ý: Nếu method getJobChart() của bạn đã có logic phức tạp,
            // bạn có thể dùng nó nhưng cần đảm bảo nó hỗ trợ limit/filter.
            // Ở đây tôi query trực tiếp Model hoặc dùng getAllJobPosting để dễ control.
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
            'labels' => $data->map(fn ($value) => Carbon::parse($value->created_at)->format('d/m (D)')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
