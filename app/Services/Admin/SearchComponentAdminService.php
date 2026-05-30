<?php

namespace App\Services\Admin;

use App\Models\Company;
use App\Models\District;
use App\Models\Sector;
use App\Models\CompanyRecruiter;
use App\Models\CgoUser;
use App\Models\AdminUser;
use App\Models\CgoCounseling;
use App\Models\Content;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Institute;
use App\Models\Notice;
use App\Models\QNA;
use App\Models\TraineeUser;
use Illuminate\Support\Facades\DB;

class SearchComponentAdminService
{
    protected object $model;
    protected $district;
    protected $company;
    protected $sector;

    public function __construct(Company $company, District $district, Sector $sector)
    {
        $this->sector = $sector;
        $this->district = $district;
        $this->company = $company;
    }
    public function searchTrainee($data = [])
    {
        $trainee = TraineeUser::query();


        // Search by name
        if (!empty($data['search'])) {
            $trainee->where('full_name', 'like', '%' . $data['search'] . '%');
        }

        // Filter by sector if needed (uncomment and modify as required)
        // if (!empty($data['sector'])) {
        //     $trainee->whereHas('companies', function($query) use ($data) {
        //         $query->where('district', $data['sector']);
        //     });
        // }

        // Filter by date
        if (isset($data['date'])) {
            $trainee->whereDate('updated_at', $data['date']);
        }


        if (!empty($data['province'])) {
            $instituteIds = [];
            $districts = District::where('prov_id', $data['province'])->pluck('id');
            $instituteIds = Institute::whereIn('dist_id', $districts)->pluck('id')->toArray();
        }
        if (!empty($data['district'])) {
            $instituteIds = [];
            $instituteIds = array_merge($instituteIds, Institute::where('dist_id', $data['district'])->pluck('id')->toArray());
        }
        if (!empty($data['division'])) {
            $instituteIds = [];
            $instituteIds = array_merge($instituteIds, Institute::where('ds_id', $data['division'])->pluck('id')->toArray());
        }

        if (!empty($data['search_time'])) {
            $trainee->orderBy('updated_at', $data['search_time'] === 'recently' ? 'desc' : 'asc');
            $trainee->orderBy('updated_at', $data['search_time'] === 'recently' ? 'desc' : 'asc');
        } else {
            $trainee->orderBy('updated_at', 'desc');
        }


        return $trainee;
    }






    public function searchCompany($data = [])
    {
        $company = Company::select([
            'companies.id',
            'companies.name as name',
            'districts.name as district_name',
            'companies.verified_at',
            'companies.verified_by'
        ])
            ->join('districts', 'districts.id', '=', 'companies.district_id');


        // Apply filters based on input
        if (!isset($data['no_check_verify'])) {
            $company->whereNull('companies.verified_by')
                ->whereNull('companies.verified_at');
        }

        if (isset($data['company'])) {
            $company->where('companies.id', $data['company']);
        }

        if (isset($data['sector'])) {
            $company->join('jobs', 'jobs.company_id', '=', 'companies.id')->where('jobs.sector_id', $data['sector']);
        }
        if (isset($data['date'])) {
            $company->whereDate('companies.updated_at', $data['date']);
        }

        if (isset($data['district'])) {
            $company->where('companies.district_id', $data['district']);
        }

        if (!empty($data['search_status']) && $data['search_status'] != 'all') {
            if ($data['search_status'] === 'approved') {
                $company->whereNotNull('companies.verified_by')
                    ->whereNotNull('companies.verified_at');
            } elseif ($data['search_status'] === 'non_approved') {
                $company->whereNull('companies.verified_by')
                    ->whereNull('companies.verified_at');
            }
        }
        $company->groupBy('companies.id', 'companies.name', 'districts.name', 'companies.verified_at', 'companies.verified_by');
        $company->totalCompany = $company->get()->count();

        return $company;
    }






    public function searchCgo($data = [])
    {

        $cgo = CgoUser::query();
        if (!isset($data['no_check_verify'])) {
            $cgo->whereNull('verify_by')
                ->whereNotNull('email_verified_at');
        }
        if (!empty($data['search'])) {
            $cgo->where(function ($query) use ($data) {
                $query->where('first_name', 'like', '%' . $data['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $data['search'] . '%');
            });
        }
        if (isset($data['institute'])) {
            $cgo->where('institute_id', $data['institute']);
        }
        if (isset($data['check_reject'])) {
            $cgo->whereNotNull('verify_by')
                ->whereNull('verify_at');
        }
        if (isset($data['TVET_type'])) {
            // $cgo->where('company_recruiters.company_id', $data['company']);
        }
        if (isset($data['date'])) {
            $cgo->whereDate('updated_at', $data['date']);
        }
        if (!empty($data['search_time'])) {
            if ($data['search_time'] === 'recently') {

                $cgo->orderBy('updated_at', 'desc');
            } elseif ($data['search_time'] === 'oldest') {
                $cgo->orderBy('updated_at', 'asc');
            }
        } else {
            // Default sort: newly created first
            $cgo->orderBy('updated_at', 'desc');
        }

        return $cgo;
    }

    public function searchAdmin($data = [])
    {
        $admin = AdminUser::selectRaw("*");
        if (!isset($data['no_check_verify'])) {
            $admin->whereNull('verify_by')
                ->whereNotNull('email_verified_at');
        }

        if (!empty($data['search'])) {
            $admin->where(function ($query) use ($data) {
                $query->where('first_name', 'like', '%' . $data['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $data['search'] . '%');
            });
        }
        if (isset($data['date'])) {
            $admin->whereDate('updated_at', $data['date']);
        }
        if (isset($data['tvet_type'])) {
            $admin->where('tvet_type', $data['tvet_type']);
        }
        if (!empty($data['search_time'])) {
            if ($data['search_time'] === 'recently') {
                $admin->orderBy('updated_at', 'desc');
            } elseif ($data['search_time'] === 'oldest') {
                $admin->orderBy('updated_at', 'asc');
            }
        } else {
            $admin->orderBy('updated_at', 'desc');
        }
        if (!empty($data['search_status']) && $data['search_status'] != 'all') {
            if ($data['search_status'] === 'approved') {
                $admin->whereNotNull('verify_by')
                    ->whereNotNull('verify_at');
            } elseif ($data['search_status'] === 'non_approved') {
                $admin->whereNull('verify_by')
                    ->whereNull('verify_at');
            }
        }
        return $admin;
    }

    public function searchContent($data = [])
    {
        $content = Content::query();
        if (isset($data['type'])) {
            $content->where('content_type', '!=', 'video');
        } else {
            $content->where('content_type', '=', 'video');
        }
        if (!empty($data['search'])) {
            $content->where(function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['search'] . '%');
            });
        }
        if(isset($data['check_reject'])){
            $content->where('status', '=', \App\Enums\StatusEnumsManagement::NON_APPROVAL->value);
        }elseif(isset($data['check_approved'])){
            $content->where('status', '=', \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value);
        }else if(isset($data['show_list_content'])){
            $content->where('status', '=', \App\Enums\StatusEnumsManagement::NON_APPROVAL->value)
            ->orWhere('status', '=', \App\Enums\StatusEnumsManagement::APPROVED->value )
            ;
        }
        if (isset($data['member'])) {
            $content->where('system', $data['member']);
        }
        if (!empty($data['search_time'])) {
            if ($data['search_time'] === 'all') {
                $content->orderBy('created_at', 'desc');
            } elseif ($data['search_time'] === 'old') {
                $content->orderBy('created_at', 'asc');
            }
        }

        return $content;
    }
    public function searchEvent($data = [])
    {

        $event = Event::query();

        if(isset($data['check_reject'])){
            $event->where('status', '=', '1');
        }elseif(isset($data['check_approved'])){
            $event->where('status', '=', '2');
        }else{
            $event->where('status', '=', '0');
        }
        if (!empty($data['search'])) {
            $event->where(function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['search'] . '%');
            });
        }
        if (isset($data['member'])) {
            $event->where('system', $data['member']);
        }
        if (isset($data['type'])) {
            // $content->where('system', $data['member']);
        }
        if (!empty($data['search_time'])) {
            if ($data['search_time'] === 'recently') {
                $event->orderBy('updated_at', 'desc');
            } elseif ($data['search_time'] === 'oldest') {
                $event->orderBy('updated_at', 'asc');
            }
        } else {
            // Default sort: newly created first
            $event->orderByRaw("CASE WHEN sort = 0 THEN 1 ELSE 0 END, sort ASC");
        }

        return $event;
    }

    public function searchQNA($data = [])
    {

        $event = QNA::query();
        if (!isset($data['no_check_verify'])) {
            $event->whereNull('status');
        }
        if (!empty($data['search'])) {
            $event->where(function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['search'] . '%');
            });
        }
        if (!empty($data['search_time'])) {
            if ($data['search_time'] === 'recently') {
                $event->orderBy('created_at', 'desc');
            } elseif ($data['search_time'] === 'oldest') {
                $event->orderBy('created_at', 'asc');
            }
        }

        return $event;
    }
    public function searchNotice($data = [])
    {

        $event = Notice::query();
        if (!empty($data['search'])) {
            $event->where(function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['search'] . '%');
            });
        }
        if (!empty($data['search_time'])) {
            if ($data['search_time'] === 'recently') {
                $event->orderBy('updated_at', 'desc');
            } elseif ($data['search_time'] === 'oldest') {
                $event->orderBy('updated_at', 'asc');
            }
        } else {
            $event->orderBy('updated_at', 'desc');
        }

        return $event;
    }
    public function searchFAQ($data = [])
    {

        $faq = Faq::query();
        // if (!isset($data['no_check_verify'])) {
        //     $faq->whereNull('status');
        // }
        if (!empty($data['search'])) {
            $faq->where(function ($query) use ($data) {
                $query->where('category_name', 'like', '%' . $data['search'] . '%');
            });
        }
        if (!empty($data['search_time'])) {
            if ($data['search_time'] === 'recently') {
                $faq->orderBy('updated_at', 'desc');
            } elseif ($data['search_time'] === 'oldest') {
                $faq->orderBy('updated_at', 'asc');
            }
        }

        return $faq;
    }
    public function searchCompanyUser($data = [])
    {

        $companyUser = CompanyRecruiter::query();
        if (!empty($data['search'])) {
            $companyUser->where(function ($query) use ($data) {
                $query->where('category_name', 'like', '%' . $data['search'] . '%');
            });
        }
        if (isset($data['check_approval'])) {
            $companyUser->whereNull('verify_by');
            $companyUser->whereNull('verify_at');
        }
        if (!empty($data['company_id'])) {
            $companyUser->where('company_id', $data['company_id']);
        }
        return $companyUser;
    }
    public function searchCounseling($data = [])
    {

        $counseling = CgoCounseling::select('cgo_counselings.*')

        ->join('institutes','institutes.id','=','cgo_counselings.institute_id')
            ->where(function ($query) {
                $query->where('cgo_counselings.status', '!=', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                    ->orWhere(function ($query) {
                        $query->where('cgo_counselings.status', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                            ->whereNotNull('cgo_counselings.result');
                    });
            });

        if (!empty($data['search'])) {
            $counseling->where(function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['search'] . '%');
            });
        }
        if(!empty($data['district'])){
            $counseling->where('institutes.dist_id','=',$data['district']);
        }
        return $counseling;
    }
}
