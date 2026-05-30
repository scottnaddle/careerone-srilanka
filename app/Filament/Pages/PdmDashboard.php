<?php

namespace App\Filament\Pages;

use App\Enums\StatusEnumsManagement;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\Content;
use App\Models\Institute;
use App\Models\Job;
use App\Models\OJT;
use App\Models\OjtTraineeApply;
use App\Models\TraineeUser;
use Filament\Pages\Page;

class PdmDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'PDM';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.pdm-dashboard';

    public function getStats(): array
    {
        return [
            [
                'label' => 'Career Key Test',
                'value' => number_format(CareerTestTraineeResult::whereHas(
                    'careerTest',
                    fn ($q) => $q->where('test_type', 2)
                )->count()) . ' (' . number_format(CareerTestTraineeResult::whereHas(
                    'careerTest',
                    fn ($q) => $q->where('test_type', 2)
                )->distinct('trainee_id')->count('trainee_id')) . ')',
                'sub' => 'Total results (unique trainees)',
                'icon' => 'heroicon-o-academic-cap',
                'color' => 'blue',
                'link' => '/admin/career-tests?tableFilters[test_type][value]=2',
            ],
            [
                'label' => 'Trainees',
                'value' => TraineeUser::where('active', true)->count(),
                'sub' => 'Active trainees',
                'icon' => 'heroicon-o-user',
                'color' => 'sky',
                'link' => '/admin/trainees',
            ],
            [
                'label' => 'Portfolios',
                'value' => TraineeUser::has('portfolio')->count(),
                'sub' => 'Trainees with portfolio',
                'icon' => 'heroicon-o-document-text',
                'color' => 'green',
                'link' => '/admin/trainees',
            ],
            [
                'label' => 'Companies',
                'value' => Company::where('active', true)
                    ->whereNotNull('verified_at')
                    ->whereNotNull('verified_by')->count(),
                'sub' => 'Active & verified',
                'icon' => 'heroicon-o-building-office',
                'color' => 'amber',
                'link' => '/admin/companies',
            ],
            [
                'label' => 'TVET Institutes',
                'value' => Institute::count(),
                'sub' => 'Registered institutes',
                'icon' => 'heroicon-o-building-library',
                'color' => 'purple',
                'link' => '/admin/api/institutes',
            ],
            [
                'label' => 'CGO Trained',
                'value' => CgoUser::where('active', true)
                    ->whereNotNull('verify_at')
                    ->whereNotNull('verify_by')->count(),
                'sub' => 'Active & approved',
                'icon' => 'heroicon-o-user-group',
                'color' => 'rose',
                'link' => '/admin/approved-c-g-o-details',
            ],
            [
                'label' => 'Content Videos',
                'value' => Content::where('content_type', 'video')
                    ->where('status', StatusEnumsManagement::APPROVED_BY_ADMIN->value)->count(),
                'sub' => 'Approved by TVEC',
                'icon' => 'heroicon-o-video-camera',
                'color' => 'orange',
                'link' => '/admin/content/videos',
            ],
            [
                'label' => 'Content Documents',
                'value' => Content::where('content_type', '!=', 'video')
                    ->where('status', StatusEnumsManagement::APPROVED_BY_ADMIN->value)->count(),
                'sub' => 'Approved by TVEC',
                'icon' => 'heroicon-o-document',
                'color' => 'indigo',
                'link' => '/admin/content/documents',
            ],
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

    public function getJobsStats(): array
    {
        return [
            'total' => Job::count(),
            'matched' => Job::has('appliesTypeMatch')->count(),
            'companies' => Job::distinct('company_id')->count('company_id'),
        ];
    }

    public function getTotal(): int
    {
        return TraineeUser::where('active', true)->count()
             + Company::where('active', true)->whereNotNull('verified_at')->whereNotNull('verified_by')->count()
             + CgoUser::where('active', true)->whereNotNull('verify_at')->whereNotNull('verify_by')->count();
    }
}
