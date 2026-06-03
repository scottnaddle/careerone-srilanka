<?php

namespace App\Filament\Widgets;

use App\Services\Admin\MemberSignupService;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class MemberSignupChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Member Signup';
    protected static string $view = 'filament.widgets.custom-chart-widget';

    protected MemberSignupService $memberSignupService;

    // Biến lưu trữ danh sách ngày
    public array $filterDates = [];

    public function __construct()
    {
        $this->memberSignupService = new MemberSignupService(
            new \App\Models\CgoUser(),
            new \App\Models\Company(),
            new \App\Models\TraineeUser()
        );
        self::$heading = __('admin/dashboard.member_signup_title');
    }

    // --- SỬA LẠI ĐOẠN NÀY ---

    // 1. Đổi tên hàm để không trùng với hàm gốc của Filament
    // 2. Vẫn giữ Attribute lắng nghe sự kiện 'update-chart-dates'
    #[On('update-chart-dates')]
    public function updateChartFilters(array $dates): void
    {
        // Cập nhật biến local
        $this->filterDates = $dates;

        // Gọi hàm gốc của cha (không tham số) để kích hoạt việc vẽ lại biểu đồ
        $this->updateChartData();
    }
    // ------------------------

    protected function getData(): array
    {
        // Logic lấy dữ liệu giữ nguyên như cũ
        $query = $this->memberSignupService->getMemberSignupTableData();

        if (!empty($this->filterDates)) {
            $data = $query->whereIn('date', $this->filterDates)
                ->orderBy('date', 'DESC')
                ->get();
        } else {
            $data = $query->limit(5)
                ->orderBy('date', 'DESC')
                ->get();
        }
        if (auth('admin')->user()->hasRole('super_admin')) {
            return [
                'datasets' => [
                    [
                        'type' => 'bar',
                        'label' => __('admin/dashboard.member_signup.cgo'),
                        'data' => $data->map(fn ($value) => $value->cgo_total),
                        'backgroundColor' => '#E6447F',
                        'borderColor' => '#E6447F',
                    ],
                    // ... các dataset khác giữ nguyên
                    [
                        'type' => 'bar',
                        'label' => __('admin/dashboard.member_signup.company'),
                        'data' => $data->map(fn ($value) => $value->company_total),
                        'backgroundColor' => '#FFD540',
                        'borderColor' => '#FFD540',
                    ],
                    [
                        'type' => 'bar',
                        'label' => __('admin/dashboard.member_signup.trainee'),
                        'data' => $data->map(fn ($value) => $value->trainee_total),
                        'backgroundColor' => '#4984F6',
                        'borderColor' => '#4984F6',
                    ],
                    [
                        'type' => 'bar',
                        'label' => __('admin/dashboard.member_signup.admin'),
                        'data' => $data->map(fn ($value) => $value->admin_total),
                        'backgroundColor' => '#63a94d',
                        'borderColor' => '#63a94d',
                    ],
                ],
                'labels' => $data->map(fn ($value) => Carbon::parse($value->date)->format('d/m (D)')),
            ];
        }else {
            return [
                'datasets' => [
                    [
                        'type' => 'bar',
                        'label' => __('admin/dashboard.member_signup.cgo'),
                        'data' => $data->map(fn ($value) => $value->cgo_total),
                        'backgroundColor' => '#E6447F',
                        'borderColor' => '#E6447F',
                    ],
                    [
                        'type' => 'bar',
                        'label' => __('admin/dashboard.member_signup.trainee'),
                        'data' => $data->map(fn ($value) => $value->trainee_total),
                        'backgroundColor' => '#4984F6',
                        'borderColor' => '#4984F6',
                    ],
                ],
                'labels' => $data->map(fn ($value) => Carbon::parse($value->date)->format('d/m (D)')),
            ];
        }

    }

    protected function getType(): string
    {
        return 'bar';
    }
}
