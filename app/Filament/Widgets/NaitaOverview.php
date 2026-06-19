<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Company;
use App\Models\Job;
use App\Models\OJT;
use App\Models\CompanyRecruiter;
use App\Models\TraineeApply;
use App\Models\OjtTraineeApply;
use App\Enums\TypeTraineeApply;
use Carbon\Carbon;

class NaitaOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Get Naita company IDs
        $naitaCompanyIds = Company::where('is_belongs_to_naita', true)->pluck('id');

        // Date ranges for comparison
        $now = Carbon::now();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // Helper to get count up to a specific date (all records up to end of last month)
        $countUpToLastMonth = function ($query) use ($lastMonthEnd) {
            return $query->where('created_at', '<=', $lastMonthEnd)->count();
        };

        // --- Companies ---
        $companiesQuery = Company::where('is_belongs_to_naita', true);
        $totalCompanies = $companiesQuery->count();
        $prevCompanies = $countUpToLastMonth($companiesQuery);
        $companiesChange = $this->calculateChange($totalCompanies, $prevCompanies);

        // --- Jobs ---
        $jobsQuery = Job::whereIn('company_id', $naitaCompanyIds);
        $totalJobs = $jobsQuery->count();
        $prevJobs = $countUpToLastMonth($jobsQuery);
        $jobsChange = $this->calculateChange($totalJobs, $prevJobs);

        // --- Active Jobs ---
        $activeJobsQuery = Job::whereIn('company_id', $naitaCompanyIds)->where('status', 1);
        $totalActiveJobs = $activeJobsQuery->count();
        $prevActiveJobs = $countUpToLastMonth($activeJobsQuery);
        $activeJobsChange = $this->calculateChange($totalActiveJobs, $prevActiveJobs);

        // --- OJTs ---
        $ojtsQuery = OJT::whereIn('company_id', $naitaCompanyIds);
        $totalOjts = $ojtsQuery->count();
        $prevOjts = $countUpToLastMonth($ojtsQuery);
        $ojtsChange = $this->calculateChange($totalOjts, $prevOjts);

        // --- Active OJTs ---
        $activeOjtsQuery = OJT::whereIn('company_id', $naitaCompanyIds)->where('status', 1);
        $totalActiveOjts = $activeOjtsQuery->count();
        $prevActiveOjts = $countUpToLastMonth($activeOjtsQuery);
        $activeOjtsChange = $this->calculateChange($totalActiveOjts, $prevActiveOjts);

        // --- Recruiters ---
        $recruitersQuery = CompanyRecruiter::whereIn('company_id', $naitaCompanyIds);
        $totalRecruiters = $recruitersQuery->count();
        $prevRecruiters = $countUpToLastMonth($recruitersQuery);
        $recruitersChange = $this->calculateChange($totalRecruiters, $prevRecruiters);

        // --- Job Matches ---
        $jobMatchesQuery = TraineeApply::whereIn('job_id', function ($q) use ($naitaCompanyIds) {
            $q->select('id')->from('jobs')->whereIn('company_id', $naitaCompanyIds);
        })->where('apply_type', TypeTraineeApply::JOB_MATCH);
        $totalJobMatches = $jobMatchesQuery->count();
        $prevJobMatches = $countUpToLastMonth($jobMatchesQuery);
        $jobMatchesChange = $this->calculateChange($totalJobMatches, $prevJobMatches);

        // --- Job Applies ---
        $jobAppliesQuery = TraineeApply::whereIn('job_id', function ($q) use ($naitaCompanyIds) {
            $q->select('id')->from('jobs')->whereIn('company_id', $naitaCompanyIds);
        })->where('apply_type', TypeTraineeApply::APPLY);
        $totalJobApplies = $jobAppliesQuery->count();
        $prevJobApplies = $countUpToLastMonth($jobAppliesQuery);
        $jobAppliesChange = $this->calculateChange($totalJobApplies, $prevJobApplies);

        // --- OJT Matches ---
        $ojtMatchesQuery = OjtTraineeApply::whereIn('ojt_id', function ($q) use ($naitaCompanyIds) {
            $q->select('id')->from('o_j_t_s')->whereIn('company_id', $naitaCompanyIds);
        })->where('apply_type', 'ojt_match');
        $totalOjtMatches = $ojtMatchesQuery->count();
        $prevOjtMatches = $countUpToLastMonth($ojtMatchesQuery);
        $ojtMatchesChange = $this->calculateChange($totalOjtMatches, $prevOjtMatches);

        // --- OJT Applies ---
        $ojtAppliesQuery = OjtTraineeApply::whereIn('ojt_id', function ($q) use ($naitaCompanyIds) {
            $q->select('id')->from('o_j_t_s')->whereIn('company_id', $naitaCompanyIds);
        })->where('apply_type', 'apply');
        $totalOjtApplies = $ojtAppliesQuery->count();
        $prevOjtApplies = $countUpToLastMonth($ojtAppliesQuery);
        $ojtAppliesChange = $this->calculateChange($totalOjtApplies, $prevOjtApplies);

        return [
            Stat::make(trans('admin/performance.Companies'), $totalCompanies)
                ->description($companiesChange)
                ->descriptionColor($companiesChange > 0 ? 'success' : ($companiesChange < 0 ? 'danger' : 'secondary'))
                ->icon('heroicon-o-building-office')
                ->url('/admin/company-jobs')
                ->color('success'),

            Stat::make(trans('admin/performance.Jobs'), $totalJobs)
                ->description($jobsChange)
                ->descriptionColor($jobsChange > 0 ? 'success' : ($jobsChange < 0 ? 'danger' : 'secondary'))
                ->url('/admin/jobs')
                ->icon('heroicon-o-briefcase'),

            // Add Active Jobs
            Stat::make(trans('admin/performance.Active Jobs'), $totalActiveJobs)
                ->descriptionColor($activeJobsChange > 0 ? 'success' : ($activeJobsChange < 0 ? 'danger' : 'secondary'))
                ->url('/admin/jobs')
                ->icon('heroicon-o-check-badge'),

            Stat::make(trans('admin/performance.OJT'), $totalOjts)
                ->description($ojtsChange)
                ->descriptionColor($ojtsChange > 0 ? 'success' : ($ojtsChange < 0 ? 'danger' : 'secondary'))
                ->url('/admin/o-j-t-s')
                ->icon('heroicon-o-academic-cap'),

            // Add Active OJT
            Stat::make(trans('admin/performance.Active OJT'), $totalActiveOjts)
                ->descriptionColor($activeOjtsChange > 0 ? 'success' : ($activeOjtsChange < 0 ? 'danger' : 'secondary'))
                ->url('/admin/o-j-t-s')
                ->icon('heroicon-o-check-badge'),

            Stat::make(trans('admin/performance.Recruiters'), $totalRecruiters)
                ->description($recruitersChange)
                ->descriptionColor($recruitersChange > 0 ? 'success' : ($recruitersChange < 0 ? 'danger' : 'secondary'))
                ->icon('heroicon-o-users'),

            Stat::make(trans('admin/performance.Job Match'), $totalJobMatches)
                ->description($jobMatchesChange)
                ->descriptionColor($jobMatchesChange > 0 ? 'success' : ($jobMatchesChange < 0 ? 'danger' : 'secondary'))
                ->icon('heroicon-o-hand-thumb-up'),

            Stat::make(trans('admin/performance.Job Apply'), $totalJobApplies)
                ->description($jobAppliesChange)
                ->descriptionColor($jobAppliesChange > 0 ? 'success' : ($jobAppliesChange < 0 ? 'danger' : 'secondary'))
                ->icon('heroicon-o-document-arrow-down'),

            Stat::make(trans('admin/performance.OJT Match'), $totalOjtMatches)
                ->description($ojtMatchesChange)
                ->descriptionColor($ojtMatchesChange > 0 ? 'success' : ($ojtMatchesChange < 0 ? 'danger' : 'secondary'))
                ->icon('heroicon-o-hand-thumb-up'),

            Stat::make(trans('admin/performance.OJT Apply'), $totalOjtApplies)
                ->description($ojtAppliesChange)
                ->descriptionColor($ojtAppliesChange > 0 ? 'success' : ($ojtAppliesChange < 0 ? 'danger' : 'secondary'))
                ->icon('heroicon-o-document-arrow-down'),
        ];
    }

    /**
     * Calculate percentage change and return formatted string.
     */
    private function calculateChange(int $current, int $previous): string
    {
        if ($previous == 0) {
            return $current > 0 ? '↑ '.trans('admin/performance.compared to previous month') : trans('admin/performance.No change compared to previous month');
        }

        $change = (($current - $previous) / $previous) * 100;
        $formatted = round(abs($change), 1);
        $arrow = $change >= 0 ? '↑' : '↓';

        return "{$arrow} {$formatted}% ".trans('admin/performance.compared to previous month');
    }

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('naita_admin') ?? false;
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
