<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\WidgetConfiguration;
use App\Services\Admin\OverViewService;

class OverviewWidgets extends StatsOverviewWidget
{
    protected string $title = 'CGO Approval';
    protected string $value = '200';
    protected ?string $description = 'Average Days to approval';
    protected string $color = 'bg-[#4984F6]';
    protected string $link = '';

    protected array $data = [];
    protected OverViewService $memberSignupService;
    public function __construct()
    {
        $this->memberSignupService = new OverViewService(
            new \App\Models\CgoUser(),
            new \App\Models\Company(),
            new \App\Models\TraineeUser()
        );
    }

    protected function getStats(): array
    {
     $resultCount= $this->memberSignupService->countUnverifiedUsers();
        // Get data
        $data = [
            0 => [
                'title' => __('admin/dashboard.cgo_approval'),
                'value' => $resultCount['unverified_cgo_users'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
                'link' => route('filament.admin.pages.cgo-approval-list'),
            ],
            1 => [
                'title' => __('admin/dashboard.company_approval'),
                'value' => $resultCount['unverifiedCompanyCount'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
                'link' => route('filament.admin.pages.company-approval-list'),
            ],
            2 => [
                'title' => __('admin/dashboard.company_recruiter'),
                'value' => $resultCount['unverified_company_recruiters'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
                'link' => route('filament.admin.resources.company-recruiter-approvals.index'),
            ],
            3 => [
                'title' => __('admin/dashboard.admin_approval'),
                'value' => $resultCount['unverified_admin_users'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
                'link' => route('filament.admin.pages.administrator-approval-list'),
            ],

            4 => [
                'title' => __('admin/dashboard.contents_document_approval'),
                'value' => $resultCount['unverified_content'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
//                'link' => route('filament.admin.resources.information.content.content-appoval-lists.index'),
                'link' => '/admin/content/documents?tableFilters[status][value]=0',
            ],
            5 => [
                'title' => __('admin/dashboard.contents_video_approval'),
                'value' => $resultCount['unverified_video'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
                //                'link' => route('filament.admin.resources.information.content.content-appoval-lists.index'),
                'link' => '/admin/content/videos?tableFilters[status][value]=0',
            ],
            6 => [
                'title' =>  __('admin/dashboard.events_approval'),
                'value' => $resultCount['unverified_event_users'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
                'link' => route('filament.admin.resources.information.content.event-approval-lists.index'),
            ],
            7 => [
                'title' =>  __('admin/dashboard.reactive_user'),
                'value' => $resultCount['unverifiedReActiveCount'],
                'description' => '',
                'color' => 'bg-[#FFB13D]',
                'link' => '/admin/user-re-actives?tableFilters[approval][value]=requested',
            ],
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
        return view('filament.widgets.custom-stats-overview-widget', [
            'stats' => $this->getStats(),
        ]);
    }
}
