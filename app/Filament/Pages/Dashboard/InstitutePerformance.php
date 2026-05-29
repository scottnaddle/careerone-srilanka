<?php

namespace App\Filament\Pages\Dashboard;

use App\Enums\TypeTraineeApply;
use App\Filament\Resources\CompanyResource\Widgets\JobPostingTableWidget;
use App\Filament\Resources\ContentResource\Widgets\ContentTableWidget;
use App\Filament\Resources\EventResource\Widgets\EventTableWidget;
use App\Models\TvetType;
use Filament\Pages\Page;
use App\Filament\Resources\OJTResource\Widgets\OJTTableWidget;
use App\Filament\Resources\CareerGuideResource\Widgets\CareerGuidanceTableWidget;
use App\Filament\Widgets\CountQnAByRole\QuestionsAndAnswersTableWidget;
use App\Filament\Widgets\TraineeTableWidget;

class InstitutePerformance extends Page
{
    protected static ?string $navigationLabel = 'Institute Performance';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.dashboard.institute-performance';

    protected array $data = [];
    protected $head_offices;
    protected ?string $heading;

    public function __construct()
    {
        $this->heading = __('admin/institute_performance.institute_performance');
        $this->head_offices = TvetType::orderBy('head_office_name', 'asc')->get();
    }


    public function mount()
    {
        $this->data = [
            'keywords_search' => request()->query('keywords_search', null),
            'tvet_type' => request()->query('tvet_type', null),
            'head_office' => request()->query('head_office', null),
        ];
    }

    public function getTVETType()
    {
        return TvetType::query()->get();
    }

    protected function getFooterWidgets(): array
    {
        return [
            CareerGuidanceTableWidget::make([
                'data' => $this->data,
                'type' => 'institute',
            ]),
            TraineeTableWidget::make([
                'data' => $this->data,
                'type' => 'institute',
            ]),
            JobPostingTableWidget::make([
                'data' => array_merge($this->data, ['apply_type' => TypeTraineeApply::JOB_MATCH->value]),
//                'titleHeader' => __('admin/institute_performance.match_job'),
                'titleHeader' => __('admin/cgo_performance.matched_job.title'),
                'namePage' => 'jobMatch',
                'type' => 'institute',
            ]),
            OJTTableWidget::make([
                'data' => $this->data,
                'type' => 'institute',
            ]),
            EventTableWidget::make([
                'data' => $this->data,
                'type' => 'institute',
            ]),
            ContentTableWidget::make([
                'data' => $this->data,
                'type' => 'institute',
            ]),
            // JobPostingTableWidget::make([
            //     'data' => array_merge($this->data, ['apply_type' => TypeTraineeApply::APPLY->value]),
            //     'titleHeader' => __('admin/institute_performance.job_apply'),
            //     'namePage' => 'jobApply',
            //     'type' => 'institute',
            // ]),

            // QuestionsAndAnswersTableWidget::make([
            //     'data' => $this->data,
            //     'titleHeader' => 'Q&A Reply',
            //     'namePage' => 'qnaReply',
            //     'type' => 'institute',
            // ]),
        ];
    }
}
