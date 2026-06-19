<?php

namespace App\Services\Admin;

use App\Models\CgoUser;
use App\Models\Company;
use App\Models\AdminUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\Event;
use App\Models\ReactiveAccountRequest;
use App\Models\TraineeUser;
use Carbon\Carbon;

class OverViewService
{
    protected CgoUser $modelCgoUser;
    protected Company $modelCompany;
    protected TraineeUser $modelTraineeUser;

    public function __construct(CgoUser $modelCgoUser, Company $modelCompany, TraineeUser $modelTraineeUser)
    {
        $this->modelCgoUser = $modelCgoUser;
        $this->modelCompany = $modelCompany;
        $this->modelTraineeUser = $modelTraineeUser;
    }

    public function countUnverifiedUsers(): array
    {
        return $this->countUnverifiedByDateRange();
    }

    public function countUnverifiedUsersFromLastWeek(): array
    {
        $endDate = Carbon::now()->subWeek()->endOfWeek();
        $startDate = Carbon::now()->subWeek()->startOfWeek();

        return $this->countUnverifiedByDateRange($startDate, $endDate);
    }

    protected function countUnverifiedByDateRange(?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        try {
            $user = auth('admin')->user();
            $isAdmin = $user->hasRole('admin');
            $instituteIds = null;

            if ($isAdmin) {
                $instituteIds = $user->institutes()->pluck('institutes.id')->toArray();
            }

            // CGO Users
            $unverifiedCgoQuery = CgoUser::whereNull('verify_at')->whereNull('verify_by');
            if ($isAdmin && !empty($instituteIds)) {
                $unverifiedCgoQuery->whereIn('institute_id', $instituteIds);
            }
            if ($startDate && $endDate) {
                $unverifiedCgoQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedCgoCount = $unverifiedCgoQuery->count();

            // Companies
            $unverifiedCompanyQuery = Company::whereNull('verified_at')->whereNull('verified_by');
            if ($startDate && $endDate) {
                $unverifiedCompanyQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedCompanyCount = $unverifiedCompanyQuery->count();

            // Content (non-video)
            $unverifiedContentQuery = Content::where('content_type', '!=', 'video')->where('status', 0);
            if ($startDate && $endDate) {
                $unverifiedContentQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedContentCount = $unverifiedContentQuery->count();

            // Videos
            $unverifiedVideoQuery = Content::where('content_type', 'video')->where('status', 0);
            if ($startDate && $endDate) {
                $unverifiedVideoQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedVideoCount = $unverifiedVideoQuery->count();

            // Admin Users
            $unverifiedAdminQuery = AdminUser::whereNull('verify_at')->whereNull('verify_by');
            if ($startDate && $endDate) {
                $unverifiedAdminQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedAdminCount = $unverifiedAdminQuery->count();

            // Events
            $unverifiedEventQuery = Event::where('status', 0);
            if ($isAdmin && !empty($instituteIds)) {
                $unverifiedEventQuery->whereHas('cgoUser', function ($query) use ($instituteIds) {
                    $query->whereIn('institute_id', $instituteIds);
                });
            }
            if ($startDate && $endDate) {
                $unverifiedEventQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedEventCount = $unverifiedEventQuery->count();

            // Company Recruiters
            $unverifiedCompanyRecruiterQuery = CompanyRecruiter::whereNull('verify_at')->whereNull('verify_by');
            if ($startDate && $endDate) {
                $unverifiedCompanyRecruiterQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedCompanyCountRecruiter = $unverifiedCompanyRecruiterQuery->count();

            // Reactive Account Requests
            $unverifiedReActiveQuery = ReactiveAccountRequest::whereNull('confirmed_at');
            if ($isAdmin && !empty($instituteIds)) {
                $unverifiedReActiveQuery->whereHas('cgoUser', function ($query) use ($instituteIds) {
                    $query->whereIn('institute_id', $instituteIds);
                });
            }
            if ($startDate && $endDate) {
                $unverifiedReActiveQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $unverifiedReActiveCount = $unverifiedReActiveQuery->count();

            return [
                'unverified_cgo_users' => $unverifiedCgoCount,
                'unverified_company_recruiters' => $unverifiedCompanyCountRecruiter,
                'unverified_content' => $unverifiedContentCount,
                'unverified_video' => $unverifiedVideoCount,
                'unverified_admin_users' => $unverifiedAdminCount,
                'unverified_event_users' => $unverifiedEventCount,
                'unverifiedCompanyCount' => $unverifiedCompanyCount,
                'unverifiedReActiveCount' => $unverifiedReActiveCount,
            ];
        } catch (\Exception $e) {
            \Log::error('Error counting unverified users: ' . $e->getMessage());
            return $this->getEmptyCountArray();
        }
    }

    public function getDailyTrendData(int $days = 7): array
    {
        $trendData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $counts = $this->countUnverifiedByDateRange(
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay()
            );
            $trendData[] = array_sum($counts); // Total unverified items for that day
        }

        return $trendData;
    }

    protected function getEmptyCountArray(): array
    {
        return [
            'unverified_cgo_users' => 0,
            'unverified_company_recruiters' => 0,
            'unverified_content' => 0,
            'unverified_video' => 0,
            'unverified_admin_users' => 0,
            'unverified_event_users' => 0,
            'unverifiedCompanyCount' => 0,
            'unverifiedReActiveCount' => 0,
        ];
    }
}
