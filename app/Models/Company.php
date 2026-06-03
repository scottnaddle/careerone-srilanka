<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\JobStatusEnum;
class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'office_type', 'date_of_establishment', 'name_of_representation', 'hotline', 'number_workers', 'business_registration_number', 'enterprise_id', 'co_business', 'website', 'attachment_details', 'logo', 'district_id', 'slug', 'verified_at', 'verified_by', 'ds_id', 'company_information', 'address','active','sns_channel','reason','services','short_bio'];

    public function jobs()
    {
        // If company is headquarter, see more job of company branches.
        if ($this->office_type == 1) { // headquarters
            return Job::whereIn('company_id', function ($query) {
                $query->select('id')
                    ->from('companies')
                    ->where('headquarter_id', $this->id)
                    ->orWhere('id', $this->id);
            });
        } else {
            return $this->hasMany(Job::class, 'company_id');
        }
    }


    public function jobRecruitings()
    {
        return $this->hasMany(Job::class, 'company_id')
            ->where('status', JobStatusEnum::PROGRESS->value) // Manage job status by table. crontab run every day to update
            ->when($this->office_type == 1, function ($query) {
                // If company is a headquarter, get jobs from branches too
                $query->orWhereIn('company_id', function ($subQuery) {
                    $subQuery->select('id')
                        ->from('companies')
                        ->where('headquarter_id', $this->id);
                });
            });

    }

    public function ojts()
    {
        return $this->hasMany(OJT::class, 'company_id');
    }
    public function events()
    {
        return $this->hasManyThrough(Event::class, CompanyRecruiter::class, 'company_id', 'created_by')->where('system', 'company')->where('status', 2);
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function ds()
    {
        return $this->belongsTo(DivisionalSecretariats::class, 'ds_id', 'id');
    }
//    public function co_business()
//    {
//        return $this->belongsTo(CoBusiness::class, 'co_business_id', 'id');
//    }

    public function getDistrict()
    {
        $district = District::where(['id' => $this->district_id])->first();

        return $district->name;
    }

    public function recruiters()
    {
        return $this->hasMany(CompanyRecruiter::class);
    }

    public function isMarkByTrainee($trainee_id)
    {
        return CompanyBookmark::where('trainee_id', $trainee_id)->where('company_id', $this->id)->first();
    }

    public function bookmarks()
    {
        return $this->hasMany(CompanyBookmark::class);
    }

//    public function checkIsRecruiting()
//    {
//        $today = now(); // Get the current date and time
//
//        $filteredJobs = $this->jobs()
//            ->where('application_starttime', '<=', $today)
//            ->where('application_endtime', '>=', $today)
//            ->get();
//
//        return $filteredJobs;
//    }
    public function checkIsRecruiting()
    {
        $today = now(); // Get the current date and time

        $filteredJobs = $this->jobs()
            ->where(function($query) use ($today) {
                $query->whereNull('application_starttime')
                    ->orWhere('application_starttime', '<=', $today);
            })
            ->where(function($query) use ($today) {
                $query->whereNull('application_endtime')
                    ->orWhere('application_endtime', '>=', $today);
            })
            ->get();

        return $filteredJobs;
    }

    public function traineeApplied()
    {
        return $this->hasManyThrough(TraineeApply::class, Job::class, 'company_id', 'job_id');
    }
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class, 'user_id', 'id')
            ->where('system', '=', 'company');
    }
    public function isFullyVerified()
    {
        return !is_null($this->verified_at) && !is_null($this->verified_by);
    }

    public function isPendingVerified()
    {
        return is_null($this->verified_at) && is_null($this->verified_by);
    }

    public function applies()
    {
        return $this->hasManyThrough(TraineeApply::class, Job::class, 'company_id', 'job_id');
    }

    public function matches()
    {
        return $this->hasManyThrough(TraineeMatch::class, Job::class, 'company_id', 'job_id');
    }

    public function districtQuery()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function statusCompanyList(){
        if(is_null($this->verified_at) && is_null($this->verified_by)){
            return 'Request';
        }else if(!is_null($this->verified_at) && !is_null($this->verified_at)){
            return 'Verified';
        }else{
            return 'Rejected';
        }
    }
}
