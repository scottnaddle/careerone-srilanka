<?php

namespace App\Filament\Pages\Dashboard;

use App\Filament\Resources\JobResource\Widgets\JobVacancyChartWidget;
use App\Filament\Resources\JobResource\Widgets\JobVacancyTableWidget;
use App\Filament\Widgets\OverviewWidgets;
use App\Filament\Widgets\MemberSignupChartWidget;
use App\Filament\Widgets\MemberSignupTableWidget;
use App\Filament\Resources\CounselingResource\Widgets\CounselingOverviewTableWidget;
use App\Filament\Resources\CounselingResource\Widgets\CounselingOverviewChartWidget;
use App\Filament\Resources\QuestionsAndAnswersResource\Widgets\QuestionsAndAnswersTableWidget;
use App\Filament\Resources\QuestionsAndAnswersResource\Widgets\QuestionAndAnswersChartWidget;
use App\Filament\Widgets\ShowCountInformation;
use Filament\Pages\Page;


class Overview extends Page
{
    protected static ?string $navigationLabel = 'Overview';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.dashboard.overview';
    protected ?string $heading;

    public function __construct()
    {
        if (auth('admin')->user()->hasRole('super_admin')) {
            $this->heading = __('admin/dashboard.weekly_task');
        }

    }

    protected function getHeaderWidgets(): array
    {
        if (auth('admin')->user()->hasRole('super_admin')) {
            return [

                OverviewWidgets::class,
                MemberSignupTableWidget::class,
                MemberSignupChartWidget::class,
                ShowCountInformation::class,
                JobVacancyTableWidget::class,
                JobVacancyChartWidget::class,
                CounselingOverviewTableWidget::class,
                CounselingOverviewChartWidget::class,
                QuestionsAndAnswersTableWidget::class,
                QuestionAndAnswersChartWidget::class,
            ];
        }
        return [
            MemberSignupTableWidget::class,
            MemberSignupChartWidget::class,
            JobVacancyTableWidget::class,
            JobVacancyChartWidget::class,
            CounselingOverviewTableWidget::class,
            CounselingOverviewChartWidget::class,
            QuestionsAndAnswersTableWidget::class,
            QuestionAndAnswersChartWidget::class,
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            //
        ];
    }

}
