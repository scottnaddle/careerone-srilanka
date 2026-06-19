<?php

namespace App\Filament\Pages\Dashboard;

use App\Enums\TypeTraineeApply;
use App\Filament\Resources\CompanyResource\Widgets\JobPostingTableWidget;
use App\Filament\Resources\ContentResource\Widgets\ContentTableWidget;
use App\Filament\Resources\OJTResource\Widgets\OJTTableWidget;
use App\Filament\Resources\CareerGuideResource\Widgets\CareerGuidanceTableWidget;
use App\Filament\Resources\CounselingResource\Widgets\CounselingOverviewTableWidget;
use App\Filament\Resources\EventResource\Widgets\EventTableWidget;
use App\Filament\Resources\JobResource\Widgets\JobVacancyChartWidget;
use App\Filament\Resources\JobResource\Widgets\JobVacancyTableWidget;
use App\Filament\Widgets\CgoCounselingStatsWidget;
use App\Filament\Widgets\CgoUserHeatmapWidget;
use App\Filament\Widgets\MemberSignupChartWidget;
use App\Filament\Widgets\MemberSignupTableWidget;
use App\Filament\Widgets\SriLankaDistrictMapWidget;
use App\Models\District;
use App\Models\HeadOfficeModel;
use App\Models\TvetType;
use Filament\Pages\Page;
use App\Filament\Widgets\CountQnAByRole\QuestionsAndAnswersTableWidget;

class CgoPerformance extends Page
{
    protected static ?string $navigationLabel = 'CGO Performance';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.dashboard.c-g-o-performance';

    protected array $data = [];
    protected $head_offices;
    protected ?string $heading;

    public function __construct()
    {
        $this->heading = __('admin/cgo_performance.cgo_performance');
        $this->head_offices = TvetType::orderBy('head_office_name', 'asc')->get();
    }

    public function mount()
    {
        $user = auth('admin')->user();

        $headOffice = request()->query('head_office');

        if ($headOffice === null) {
            if ($user->hasRole('naita_admin')) {
                $headOffice = 'NAITA';
            } elseif (! $user->hasRole('super_admin')) {
                $headOffice = $user->tvet_type;
            }
        }

        $this->data = [
            'keywords_search' => request()->query('keywords_search'),
            'sector_id' => request()->query('sector_id'),
            'head_office' => $headOffice,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            CgoCounselingStatsWidget::make([
                'data' => $this->data
            ]),
            CgoUserHeatmapWidget::class,
            CareerGuidanceTableWidget::make([
                'data' => $this->data,
                'type' => 'cgo',
            ]),
            QuestionsAndAnswersTableWidget::make([
                'data' => $this->data,
                'titleHeader' => 'Q&A Reply',
                'namePage' => 'qnaReply',
                'type' => 'cgo',
            ]),
            JobPostingTableWidget::make([
                'data' => $this->data,
                'titleHeader' => __('admin/cgo_performance.matched_job.title'),
                'namePage' => 'jobMatch',
                'type' => 'cgo',
            ]),
            OJTTableWidget::make([
                'data' => $this->data,
                'type' => 'cgo',
            ]),
            EventTableWidget::make([
                'data' => $this->data,
                'type' => 'cgo',
            ]),

            ContentTableWidget::make([
                'data' => $this->data,
                'type' => 'cgo',
            ]),
        ];
    }
}
