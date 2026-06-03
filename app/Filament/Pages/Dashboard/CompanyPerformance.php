<?php

namespace App\Filament\Pages\Dashboard;

use App\Enums\TypeTraineeApply;
use App\Filament\Resources\CompanyResource\Widgets\JobPostingTableWidget;
use App\Filament\Resources\ContentResource\Widgets\ContentTableWidget;
use App\Filament\Resources\EventResource\Widgets\EventTableWidget;
use App\Filament\Widgets\CountQnAByRole\QuestionsAndAnswersTableWidget;
use App\Models\Sector;
use App\Filament\Resources\OJTResource\Widgets\OJTTableWidget;
use Filament\Pages\Page;

class CompanyPerformance extends Page
{
    protected static ?string $navigationLabel = 'Company Performance';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.dashboard.company-performance';

    protected array $data = [];
    protected ?string $heading;

    public function __construct()
    {
        $this->heading = __('admin/institute_performance.company_performance');
    }
    protected function getSector()
    {
        return Sector::get();
    }

    public function mount()
    {
        $this->data = [
            'keywords_search' => request()->query('keywords_search', null),
            'sector_id' => request()->query('sector_id', null),

        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            JobPostingTableWidget::make([
                'data' => $this->data,
                'titleHeader' => 'Posted Job',
                'namePage' => 'jobposting',
                'type' => 'company',
            ]),
            JobPostingTableWidget::make([
                'data' => array_merge($this->data, ['apply_type' => TypeTraineeApply::APPLY->value]),
                'titleHeader' => __('admin/institute_performance.job_apply'),
                'namePage' => 'jobApply',
                'type' => 'company',
            ]),
            JobPostingTableWidget::make([
                'data' => array_merge($this->data, ['apply_type' => TypeTraineeApply::JOB_MATCH->value]),
                'titleHeader' => __('admin/institute_performance.matched_job'),
                'namePage' => 'jobMatch',
                'type' => 'company',
            ]),
            OJTTableWidget::make([
                'data' => $this->data,
                'type' => 'company',
            ]),
            EventTableWidget::make([
                'data' => $this->data,
                'type' => 'company',
            ]),
            QuestionsAndAnswersTableWidget::make([
                'data' => $this->data,
                'titleHeader' => 'Q&A',
                'namePage' => 'qnaReply',
                'type' => 'company',
            ]),




        ];
    }

}
