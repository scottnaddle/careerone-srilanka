<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\WidgetConfiguration;
use App\Services\Admin\OverViewServiceCountUser;

class ShowCountInformation extends StatsOverviewWidget
{
    protected string $title = 'CGO Approval';
    protected string $value = '200';
    protected ?string $description = 'Average Days to approval';
    protected string $color = 'bg-[#4984F6]';
    protected string $link = '';

    protected array $data = [];
    protected OverViewServiceCountUser $memberSignupService;
    public function __construct()
    {
        $this->memberSignupService = new OverViewServiceCountUser(
            new \App\Models\CgoUser(),
            new \App\Models\Company(),
            new \App\Models\CompanyRecruiter(),
            new \App\Models\TraineeUser()
        );
    }

    protected function getStats(): array
    {
     $resultCount= $this->memberSignupService->countUnverifiedUsers();
        // Get data
        $isAdmin = auth('admin')->user()->hasRole('super_admin') || auth('admin')->user()->hasRole('naita_admin');

        $data = $isAdmin ? [
            0 => [
                'title' => __('admin/dashboard.member_signup.trainee'),
                'value' => $resultCount['unverifiedTraineeCount'],
                'description' => '',
                'color' => 'bg-[#4984F6]',
                'link' => route('filament.admin.resources.trainees.index'),
            ],
            1 => [
                'title' => __('admin/dashboard.member_signup.company'),
                'value' => $resultCount['unverifiedCompanyCount'],
                'description' => '',
                'color' => 'bg-[#4984F6]',
                'link' => route('filament.admin.resources.companies.index'),
            ],
            2 => [
                'title' => __('admin/dashboard.member_signup.company_user'),
                'value' => $resultCount['unverified_company_recruiters'],
                'description' => '',
                'color' => 'bg-[#4984F6]',
                'link' => route('filament.admin.resources.comapny-user-lists.index'),
            ],
            3 => [
                'title' => __('admin/dashboard.job_vacancy_title'),
                'value' => $resultCount['unverifiedJobCount'],
                'description' => '',
                'color' => 'bg-[#4984F6]',
                'link' => route('filament.admin.resources.jobs.index'),
            ],
            4 => [
                'title' => __('admin/dashboard.member_signup.cgo'),
                'value' => $resultCount['unverified_cgo_users'],
                'description' => '',
                'color' => 'bg-[#4984F6]',
                'link' => route('filament.admin.resources.c-g-o-s.index'),
            ]
        ] : [
            0 => [
                'title' => __('admin/dashboard.member_signup.trainee'),
                'value' => $resultCount['unverifiedTraineeCount'],
                'description' => '',
                'color' => 'bg-[#4984F6]',
                'link' => route('filament.admin.resources.trainees.index'),
            ],
            1 => [
                'title' => __('admin/dashboard.member_signup.cgo'),
                'value' => $resultCount['unverified_cgo_users'],
                'description' => '',
                'color' => 'bg-[#4984F6]',
                'link' => route('filament.admin.resources.c-g-o-s.index'),
            ]
        ];


        return array_map(function ($stat) {
            return Stat::make($stat['title'], $stat['value'])
                ->description($stat['description'])
                ->color($stat['color'])
                ->url($stat['link']);
        }, $data);
    }
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.widgets.custom-show-count-information-overview-widget', [
            'stats' => $this->getStats(),
        ]);
    }
}
