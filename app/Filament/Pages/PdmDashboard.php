<?php

namespace App\Filament\Pages;

use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\CgoUser;
use App\Models\Institute;
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
        return [
            [
                'label' => 'Career Tests',
                'value' => CareerTestTraineeResult::count(),
                'icon' => 'heroicon-o-academic-cap',
                'color' => 'blue',
            ],
            [
                'label' => 'Portfolios',
                'value' => Portfolio::count(),
                'icon' => 'heroicon-o-document-text',
                'color' => 'green',
            ],
            [
                'label' => 'Company Members',
                'value' => CompanyRecruiter::whereNotNull('email_verified_at')->count(),
                'icon' => 'heroicon-o-building-office',
                'color' => 'amber',
            ],
            [
                'label' => 'TVET Institutes',
                'value' => Institute::where('active_status', 'Active')->count(),
                'icon' => 'heroicon-o-building-library',
                'color' => 'purple',
            ],
            [
                'label' => 'CGO Trained',
                'value' => CgoUser::whereNotNull('email_verified_at')->count(),
                'icon' => 'heroicon-o-user-group',
                'color' => 'rose',
            ],
            [
                'label' => 'Content / Deliverables',
                'value' => Content::where('status', 'approved')->count(),
                'icon' => 'heroicon-o-folder',
                'color' => 'indigo',
            ],
        ];
    }

    public function getTotal(): int
    {
        return TraineeUser::where('active', true)->count()
             + CompanyRecruiter::whereNotNull('email_verified_at')->count()
             + CgoUser::whereNotNull('email_verified_at')->count();
    }
}
