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

class OverViewServiceCountUser
{
    protected object $modelCgoUser;
    protected object $modelCompanyRecruiter;
    protected object $modelTraineeUser;
    protected object $modelCompany;

    /**
     * MemberSignup constructor.
     * @param CgoUser $modelCgoUser
     * @param Company $modelCompany
     * @param TraineeUser $modelTraineeUser
     * @param CompanyRecruiter $modelCompanyRecruiter
     */
    public function __construct(CgoUser $modelCgoUser, Company $modelCompany, CompanyRecruiter $modelCompanyRecruiter, TraineeUser $modelTraineeUser)
    {
        $this->modelCgoUser = $modelCgoUser;
        $this->modelCompany = $modelCompany;
        $this->modelCompanyRecruiter = $modelCompanyRecruiter;
        $this->modelTraineeUser = $modelTraineeUser;
    }
    public function countUnverifiedUsers(): array
    {
        $admin = auth('admin')->user();
        try {
            if (auth('admin')->user()->hasRole('super_admin')) {
                $unverifiedCgoCount = CgoUser::where('active',true)->whereNotNull('verify_at')->whereNotNull('verify_by')->count() ?? 0;
                $unverifiedTraineeCount = TraineeUser::where('active', true)->count() ?? 0;
            }else {
                $cgoQuery = CgoUser::where('active',true)->whereNotNull('verify_at')->whereNotNull('verify_by');
                $cgoQuery->whereHas('institute', function ($query) use ($admin) {
                    $query->where('institute_head_office', $admin->tvet_type);
                });
                $unverifiedCgoCount = $cgoQuery->count() ?? 0;

                $traineeQuery = TraineeUser::where('active', true);
                $traineeQuery->whereHas('institutes', function ($q) use ($admin) {
                    $q->where('institute_head_office', $admin->tvet_type);
                });
                $unverifiedTraineeCount = $traineeQuery->count() ?? 0;
            }

            $unverifiedJobCount = Job::count() ?? 0;
            $unverifiedCompanyCountRecruiter = CompanyRecruiter::where('active',true)->whereNotNull('verify_at')->whereNotNull('verify_by')->count() ?? 0;
            $unverifiedCompanyCount = Company::where('active',true)->whereNotNull('verified_at')->whereNotNull('verified_by')->count() ?? 0;
            return [
                'unverified_cgo_users' => $unverifiedCgoCount,
                'unverified_company_recruiters' => $unverifiedCompanyCountRecruiter,
                'unverifiedTraineeCount'=>$unverifiedTraineeCount,
                'unverifiedJobCount'=>$unverifiedJobCount,
                'unverifiedCompanyCount'=>$unverifiedCompanyCount,
            ];
        } catch (\Exception $e) {
            return [
                'unverified_cgo_users' => 0,
                'unverified_company_recruiters' => 0,
                'unverifiedTraineeCount' => 0,
                'unverifiedJobCount' => 0,
                'unverifiedCompanyCount'=> 0,
            ];
        }
    }


}
