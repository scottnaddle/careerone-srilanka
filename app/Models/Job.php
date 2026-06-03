<?php

namespace App\Models;

use App\Enums\TypeTraineeApply;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'job_type',
        'job_location',
        'sector_id',
        'company_id',
        'working_day',
        'start_date',
        'start_time',
        'end_time',
        'min_salary',
        'max_salary',
        'discussion_salary',
        'gender',
        'min_age',
        'max_age',
        'not_limit_age',
        'min_work_experience',
        'max_work_experience',
        'not_limit_experience',
        'required_skills',
        'application_starttime',
        'application_endtime',
        'slug',
        'hr_name',
        'hr_email',
        'hr_contact_info',
        'roles',
        'status',
        'created_by',
        'number_of_recruitments',
        'salary_currency',
        'work_type',
        'nvq_level',
        'sector_information',
        'salary_type'
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function applies()
    {
        return $this->hasMany(TraineeApply::class);
    }
    public function district()
    {
        return $this->hasOneThrough(District::class, Company::class, 'id', 'id', 'company_id', 'district_id');
    }
    public function appliesWithCondition($field, $value)
    {
        return $this->applies()->where($field, $value);
    }
    public function appliesTypeApply()
    {
        return $this->hasMany(TraineeApply::class)->where('apply_type', TypeTraineeApply::APPLY);
    }
    public function appliesTypeMatch()
    {
        return $this->hasMany(TraineeApply::class)->where('apply_type', TypeTraineeApply::JOB_MATCH)->select('trainee_id', 'job_id', 'apply_type')
            ->distinct();
    }

    public function matches()
    {
        return $this->hasMany(TraineeMatch::class);
    }

    public function unread()
    {
        return $this->hasMany(TraineeApply::class)
            ->select('trainee_id', 'job_id', \DB::raw('COUNT(*) as aggregate'))
            ->whereNull('read')
            ->groupBy('trainee_id', 'job_id');
    }


    public function shortlist()
    {
        return $this->hasMany(TraineeApply::class)
            ->select('trainee_id', 'job_id', \DB::raw('COUNT(*) as aggregate'))
            ->whereNotNull('employeed')
            ->groupBy('trainee_id', 'job_id');
    }

    public function checkMatched($jobId, $traineeId)
    {
        $traineeId = TraineeApply::where(['job_id' => $jobId, 'trainee_id' => $traineeId, 'apply_type' => TypeTraineeApply::JOB_MATCH])->first();
        if ($traineeId)
            return true;
        return false;
    }

    public function owner() {
        return $this->belongsTo(CompanyRecruiter::class, 'created_by', 'id');
    }

    public function checkJobMatchEmployed($jobId, $traineeId)
    {
        $traineeId = TraineeApply::where(['job_id' => $jobId, 'trainee_id' => $traineeId])->whereNotNull('employeed')->first();
        if ($traineeId)
            return true;
        return false;
    }

    public function checkEmployed($jobId, $traineeId) {
        $traineeId = TraineeApply::where(['job_id' => $jobId, 'trainee_id' => $traineeId])->first();
        if ($traineeId)
            return true;
        return false;
    }

    public function isMarkByTrainee($traineeId)
    {
        return JobBookmark::where('trainee_id', $traineeId)->where('job_id', $this->id)->first();
    }

    public function isApplyByTrainee($traineeId)
    {
        return TraineeApply::where('trainee_id', $traineeId)->where('job_id', $this->id)->where('apply_type', 'apply')->first();
    }

    public function isMatchedByCgo($traineeId)
    {
        return TraineeApply::where('trainee_id', $traineeId)->where('job_id', $this->id)->where('apply_type', 'job_match')->first();
    }

    public function createdBy($creatorId)
    {
        $user = CompanyRecruiter::where('id', $creatorId)->first();
        return $user->first_name . " " . $user->last_name;
    }
    public function companyRecruiter()
    {
        return $this->belongsTo(CompanyRecruiter::class, 'created_by');
    }
    public function bookmarks()
    {
        return $this->hasMany(JobBookmark::class, 'job_id');
    }
}
