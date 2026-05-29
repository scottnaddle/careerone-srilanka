<?php

namespace App\Services\Admin;

use App\Enums\JobStatusEnum;
use App\Models\Job;
use Filament\Forms\Components\Builder;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\AdminUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\Event;
use App\Models\ReactiveAccountRequest;
use App\Models\TraineeUser;

class OverViewService
{
    protected object $modelCgoUser;
    protected object $modelCompanyRecruiter;
    protected object $modelTraineeUser;

    /**
     * MemberSignup constructor.
     * @param CgoUser $modelCgoUser
     * @param Company $modelCompany
     * @param TraineeUser $modelTraineeUser
     */
    public function __construct(CgoUser $modelCgoUser, Company $modelCompany, TraineeUser $modelTraineeUser)
    {
        $this->modelCgoUser = $modelCgoUser;
        $this->modelCompanyRecruiter = $modelCompany;
        $this->modelTraineeUser = $modelTraineeUser;
    }
    public function countUnverifiedUsers(): array
    {
        try {
            $unverifiedCgoCount = CgoUser::whereNull('verify_at')->whereNull('verify_by')->count() ?? 0;
            $unverifiedCompanyCount = Company::whereNull('verified_at')->whereNull('verified_by')->count() ?? 0;
            $unverifiedContentCount = Content::where('content_type', '!=', 'video')->where('status', 0)->count() ?? 0;
            $unverifiedVideoCount = Content::where('content_type', 'video')->where('status', 0)->count() ?? 0;
            $unverifiedAdminCount = AdminUser::whereNull('verify_at')->whereNull('verify_by')->count() ?? 0;
            $unverifiedEventCount = Event::where('status', 0)->count() ?? 0;
            $unverifiedCompanyCountRecruiter = CompanyRecruiter::whereNull('verify_at')->whereNull('verify_by')->count() ?? 0;
            $unverifiedReActiveCount = ReactiveAccountRequest::whereNull('confirmed_at')->count() ?? 0;
            return [
                'unverified_cgo_users' => $unverifiedCgoCount,
                'unverified_company_recruiters' => $unverifiedCompanyCountRecruiter,
                'unverified_content' => $unverifiedContentCount,
                'unverified_video' => $unverifiedVideoCount,
                'unverified_admin_users' => $unverifiedAdminCount,
                'unverified_event_users' => $unverifiedEventCount,
                'unverifiedCompanyCount'=>$unverifiedCompanyCount,
                'unverifiedReActiveCount'=>$unverifiedReActiveCount
            ];
        } catch (\Exception $e) {
            return [
                'unverified_cgo_users' => 0,
                'unverified_company_recruiters' => 0,
                'unverified_content' => 0,
                'unverified_video' => 0,
                'unverified_admin_users' => 0,
                'unverified_event_users' => 0,
                'unverifiedCompanyCount'=>0
            ];
        }
    }


}
