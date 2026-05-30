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
                'value' => CareerTestTraineeResult::whereHas(
                    'careerTest',
                    fn ($q) => $q->where('test_type', 2)
                )->count(),
                'sub' => 'Test results (type 2)',
                'icon' => 'heroicon-o-academic-cap',
                'color' => 'blue',
                'link' => '/admin/career-tests?tableFilters[test_type][value]=2',
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
                'value' => Company::whereNotNull('verified_by')->count(),
                'sub' => 'Verified companies',
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
                'value' => CgoUser::whereNotNull('verify_by')->count(),
                'sub' => 'Admin-approved CGOs',
                'icon' => 'heroicon-o-user-group',
                'color' => 'rose',
                'link' => '/admin/approved-c-g-o-details',
            ],
            [
                'label' => 'Content Videos',
                'value' => Content::where('content_type', 'video')
                    ->where('status', StatusEnumsManagement::APPROVED->value)->count(),
                'sub' => 'Approved videos',
                'icon' => 'heroicon-o-video-camera',
                'color' => 'orange',
                'link' => '/admin/content/videos',
            ],
            [
                'label' => 'Content Documents',
                'value' => Content::where('content_type', '!=', 'video')
                    ->where('status', StatusEnumsManagement::APPROVED->value)->count(),
                'sub' => 'Approved documents',
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
             + Company::whereNotNull('verified_by')->count()
             + CgoUser::whereNotNull('verify_by')->count();
    }
}
