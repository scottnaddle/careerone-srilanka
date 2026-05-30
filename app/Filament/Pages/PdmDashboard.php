<?php

namespace App\Filament\Pages;

use App\Enums\StatusEnumsManagement;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\CgoUser;
use App\Models\Institute;
use App\Models\Job;
use App\Models\OJT;
use App\Models\OjtTraineeApply;
use App\Models\Portfolio;
use App\Models\TraineeUser;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class PdmDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'PDM';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.pdm-dashboard';

    public function getStats(): array
    {
        $careerKeyTests = CareerTestTraineeResult::whereHas(
            'careerTest',
            fn ($q) => $q->where('test_type', 2)
        )->count();

        $ojtTotal = OJT::count();

        $jobTotal = Job::count();
        $jobMatched = Job::has('appliesTypeMatch')->count();
        $companiesWithJobs = Job::distinct('company_id')->count('company_id');

        return [
            [
                'label' => 'Career Key Test',
                'value' => $careerKeyTests,
                'sub' => 'Cumulative test results',
                'icon' => 'heroicon-o-academic-cap',
                'color' => 'blue',
                'link' => '/admin/career-tests?tableFilters[test_type][value]=2',
            ],
            [
                'label' => 'Portfolios',
                'value' => Portfolio::count(),
                'sub' => 'Registered portfolios',
                'icon' => 'heroicon-o-document-text',
                'color' => 'green',
                'link' => '/admin/trainees',
            ],
            [
                'label' => 'Company Members',
                'value' => CompanyRecruiter::whereNotNull('email_verified_at')->count(),
                'sub' => 'Verified recruiters',
                'icon' => 'heroicon-o-building-office',
                'color' => 'amber',
                'link' => '/admin/companies',
            ],
            [
                'label' => 'TVET Institutes',
                'value' => Institute::where('active_status', 'Active')->count(),
                'sub' => 'Active institutes',
                'icon' => 'heroicon-o-building-library',
                'color' => 'purple',
                'link' => '/admin/head-offices',
            ],
            [
                'label' => 'CGO Trained',
                'value' => CgoUser::whereNotNull('email_verified_at')->count(),
                'sub' => 'Verified CGOs',
                'icon' => 'heroicon-o-user-group',
                'color' => 'rose',
                'link' => '/admin/c-g-o-s',
            ],
            [
                'label' => 'CGO OJT Match',
                'value' => OjtTraineeApply::where('apply_type', 'ojt_match')->count(),
                'sub' => 'Trainee recommendations by CGO',
                'icon' => 'heroicon-o-hand-raised',
                'color' => 'orange',
                'link' => '/admin/o-j-t-s',
            ],
            [
                'label' => 'Content / Deliverables',
                'value' => Content::where('status', StatusEnumsManagement::APPROVED->value)->count(),
                'sub' => 'Approved content',
                'icon' => 'heroicon-o-folder',
                'color' => 'indigo',
                'link' => '/admin/contents',
            ],
        ];
    }

    public function getJobsStats(): array
    {
        return [
            'total' => Job::count(),
            'matched' => Job::has('appliesTypeMatch')->count(),
            'companies' => Job::distinct('company_id')->count('company_id'),
        ];
    }

    public function getOjtStats(): array
    {
        return [
            'total' => OJT::count(),
            'matched' => OJT::has('ojtMatches')->count(),
            'companies' => OJT::distinct('company_id')->count('company_id'),
        ];
    }

    public function getTotal(): int
    {
        return TraineeUser::where('active', true)->count()
             + CompanyRecruiter::whereNotNull('email_verified_at')->count()
             + CgoUser::whereNotNull('email_verified_at')->count();
    }
}
