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

    // Variable storing the list of dates
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

    // --- REVISE THIS BLOCK ---

    // 1. Rename the function so it doesn't clash with Filament's original function
    // 2. Still keep the Attribute listening for the 'update-chart-dates' event
    #[On('update-chart-dates')]
    public function updateChartFilters(array $dates): void
    {
        // Update the local variable
        $this->filterDates = $dates;

        // Call the parent's original function (no parameters) to trigger redrawing the chart
        $this->updateChartData();
    }
    // ------------------------

    protected function getData(): array
    {
        // The data-fetching logic stays the same as before
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
                    // ... the other datasets stay the same
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
