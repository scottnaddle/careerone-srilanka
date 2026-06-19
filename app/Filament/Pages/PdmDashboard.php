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
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.pdm-dashboard';

    public static function getNavigationLabel(): string
    {
        return __('menu.pdm-dashboard');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('menu.dashboard');
    }

    public function getTitle(): string
    {
        return __('menu.pdm-dashboard');
    }

    public string $dateRange = 'all';
    public ?string $startDate = null;
    public ?string $endDate = null;

    /**
     * Clear custom dates when switching to a predefined date range.
     */
    public function updatedDateRange($value): void
    {
        if ($value !== 'custom') {
            $this->startDate = null;
            $this->endDate = null;
        }
    }

    /**
     * Get date range boundaries based on selected range key.
     */
    protected function getDateRangeRange(): ?array
    {
        if ($this->dateRange === 'all') {
            return null;
        }

        $now = now();
        switch ($this->dateRange) {
            case 'today':
                return [$now->startOfDay()->toDateTimeString(), $now->endOfDay()->toDateTimeString()];
            case 'yesterday':
                return [now()->subDay()->startOfDay()->toDateTimeString(), now()->subDay()->endOfDay()->toDateTimeString()];
            case '7days':
                return [now()->subDays(7)->startOfDay()->toDateTimeString(), $now->toDateTimeString()];
            case '30days':
                return [now()->subDays(30)->startOfDay()->toDateTimeString(), $now->toDateTimeString()];
            case '90days':
                return [now()->subDays(90)->startOfDay()->toDateTimeString(), $now->toDateTimeString()];
            case 'this_month':
                return [now()->startOfMonth()->toDateTimeString(), now()->endOfMonth()->toDateTimeString()];
            case 'last_month':
                return [now()->subMonth()->startOfMonth()->toDateTimeString(), now()->subMonth()->endOfMonth()->toDateTimeString()];
            case 'this_year':
                return [now()->startOfYear()->toDateTimeString(), now()->endOfYear()->toDateTimeString()];
            case 'custom':
                if ($this->startDate && $this->endDate) {
                    try {
                        return [
                            \Carbon\Carbon::parse($this->startDate)->startOfDay()->toDateTimeString(),
                            \Carbon\Carbon::parse($this->endDate)->endOfDay()->toDateTimeString()
                        ];
                    } catch (\Exception $e) {
                        return null;
                    }
                } elseif ($this->startDate) {
                    try {
                        return [
                            \Carbon\Carbon::parse($this->startDate)->startOfDay()->toDateTimeString(),
                            $now->toDateTimeString()
                        ];
                    } catch (\Exception $e) {
                        return null;
                    }
                } elseif ($this->endDate) {
                    try {
                        return [
                            '1970-01-01 00:00:00',
                            \Carbon\Carbon::parse($this->endDate)->endOfDay()->toDateTimeString()
                        ];
                    } catch (\Exception $e) {
                        return null;
                    }
                }
                return null;
            default:
                if (is_numeric($this->dateRange) && strlen($this->dateRange) === 4) {
                    $year = (int) $this->dateRange;
                    return ["{$year}-01-01 00:00:00", "{$year}-12-31 23:59:59"];
                }
                return null;
        }
    }

    /**
     * Apply date range filter to standard Eloquent query builder.
     */
    protected function applyDateFilter($query)
    {
        $range = $this->getDateRangeRange();
        if ($range) {
            return $query->whereBetween('created_at', $range);
        }
        return $query;
    }

    /**
     * Get platform statistics.
     */
    public function getStats(): array
    {
        return [
            [
                'label' => __('admin/dashboard.pdm.career_tests'),
                'value' => number_format($this->applyDateFilter(CareerTestTraineeResult::query())->count()) . '(' . number_format($this->applyDateFilter(CareerTestTraineeResult::distinct('trainee_id'))->count('trainee_id')) . ') / ' . number_format($this->applyDateFilter(CareerTestTraineeResult::whereHas('careerTest', fn ($q) => $q->where('test_type', 2)))->count()) . '(' . number_format($this->applyDateFilter(CareerTestTraineeResult::whereHas('careerTest', fn ($q) => $q->where('test_type', 2))->distinct('trainee_id'))->count('trainee_id')) . ')',
                'sub' => __('admin/dashboard.pdm.career_tests_sub'),
                'icon' => 'heroicon-o-academic-cap',
                'color' => 'blue',
                'link' => '/admin/career-tests',
            ],
            [
                'label' => __('admin/dashboard.pdm.trainees'),
                'value' => $this->applyDateFilter(TraineeUser::where('active', true))->count(),
                'sub' => __('admin/dashboard.pdm.active_trainees'),
                'icon' => 'heroicon-o-user',
                'color' => 'sky',
                'link' => '/admin/trainees',
            ],
            [
                'label' => __('admin/dashboard.pdm.portfolios'),
                'value' => $this->applyDateFilter(TraineeUser::has('portfolio'))->count(),
                'sub' => __('admin/dashboard.pdm.trainees_with_portfolio'),
                'icon' => 'heroicon-o-document-text',
                'color' => 'green',
                'link' => '/admin/trainees',
            ],
            [
                'label' => __('admin/dashboard.pdm.companies'),
                'value' => $this->applyDateFilter(Company::where('active', true)
                    ->whereNotNull('verified_at')
                    ->whereNotNull('verified_by'))->count(),
                'sub' => __('admin/dashboard.pdm.active_verified'),
                'icon' => 'heroicon-o-building-office',
                'color' => 'amber',
                'link' => '/admin/companies',
            ],
            [
                'label' => __('admin/dashboard.pdm.tvet_institutes'),
                'value' => $this->applyDateFilter(Institute::query())->count(),
                'sub' => __('admin/dashboard.pdm.registered_institutes'),
                'icon' => 'heroicon-o-building-library',
                'color' => 'purple',
                'link' => '/admin/api/institutes',
            ],
            [
                'label' => __('admin/dashboard.pdm.cgo_trained'),
                'value' => $this->applyDateFilter(CgoUser::where('active', true)
                    ->whereNotNull('verify_at')
                    ->whereNotNull('verify_by'))->count(),
                'sub' => __('admin/dashboard.pdm.active_approved'),
                'icon' => 'heroicon-o-user-group',
                'color' => 'rose',
                'link' => '/admin/approved-c-g-o-details',
            ],
            [
                'label' => __('admin/dashboard.pdm.content_videos'),
                'value' => $this->applyDateFilter(Content::where('content_type', 'video')
                    ->where('status', StatusEnumsManagement::APPROVED_BY_ADMIN->value))->count(),
                'sub' => __('admin/dashboard.pdm.approved_tvec'),
                'icon' => 'heroicon-o-video-camera',
                'color' => 'orange',
                'link' => '/admin/content/videos',
            ],
            [
                'label' => __('admin/dashboard.pdm.content_documents'),
                'value' => $this->applyDateFilter(Content::where('content_type', '!=', 'video')
                    ->where('status', StatusEnumsManagement::APPROVED_BY_ADMIN->value))->count(),
                'sub' => __('admin/dashboard.pdm.approved_tvec'),
                'icon' => 'heroicon-o-document',
                'color' => 'indigo',
                'link' => '/admin/content/documents',
            ],
        ];
    }

    /**
     * Get OJT programs statistics.
     */
    public function getOjtStats(): array
    {
        return [
            'total' => $this->applyDateFilter(OJT::query())->count(),
            'matched' => $this->applyDateFilter(OJT::has('ojtMatches'))->count(),
            'companies' => $this->applyDateFilter(OJT::distinct('company_id'))->count('company_id'),
        ];
    }

    /**
     * Get job vacancies statistics.
     */
    public function getJobsStats(): array
    {
        return [
            'total' => $this->applyDateFilter(Job::query())->count(),
            'matched' => $this->applyDateFilter(Job::has('appliesTypeMatch'))->count(),
            'companies' => $this->applyDateFilter(Job::distinct('company_id'))->count('company_id'),
        ];
    }

    /**
     * Get total participants count.
     */
    public function getTotal(): int
    {
        return $this->applyDateFilter(TraineeUser::where('active', true))->count()
             + $this->applyDateFilter(Company::where('active', true)->whereNotNull('verified_at')->whereNotNull('verified_by'))->count()
             + $this->applyDateFilter(CgoUser::where('active', true)->whereNotNull('verify_at')->whereNotNull('verify_by'))->count();
    }
}
