<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OJT extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company_id', 'number_of_recruitments', 'period', 'gender', 'min_age', 'max_age', 'age_limitation', 'min_work_experience', 'max_work_experience', 'work_experience_limitation', 'required_skills', 'application_starttime', 'application_endtime', 'registration_date', 'slug', 'hr_name', 'hr_email', 'hr_contact_info', 'roles', 'status', 'created_by', 'system'];
    public function applies() {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id', 'id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sector() {
        return $this->belongsTo(Sector::class);
    }

    public function district() {
        return $this->hasOneThrough(District::class, Company::class, 'id','id', 'company_id', 'district_id');
    }

    public function ojtMatches()
    {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id', 'id')->where('apply_type','ojt_match');
    }

    public function attachFiles() {
        return $this->hasMany(OJTAttachment::class, 'ojt_id', 'id');
    }

    public function isMarkByTrainee($traineeId) {
        return OjtBookmark::where('trainee_id', $traineeId)->where('ojt_id', $this->id)->first();
    }

    public function owner() {
        return $this->belongsTo(CompanyRecruiter::class, 'created_by', 'id');
    }

    public function isApplyByTrainee($traineeId) {
        return OjtTraineeApply::where('trainee_id', $traineeId)->where('ojt_id', $this->id) ->where('apply_type','apply')->first();
    }

    public function isMatchedByCgo($traineeId) {
        return OjtTraineeApply::where('trainee_id', $traineeId)->where('ojt_id', $this->id) ->where('apply_type','ojt_match')->first();
    }

    public function bookmarks() {
        return $this->hasMany(OjtBookmark::class, 'ojt_id');
    }
    public function checkMatched($jobId, $traineeId)
    {
        $traineeId = OjtTraineeApply::where(['ojt_id' => $jobId, 'trainee_id' => $traineeId])->where('apply_type','ojt_match')->first();
        if ($traineeId)
            return true;
        return false;
    }
    public function getCurrentOJTMatch($ojt_id, $trainee_id){
        return OjtTraineeApply::where(['ojt_id' => $ojt_id, 'trainee_id' => $trainee_id])->where('apply_type','ojt_match')->first();
    }

    public function applied() {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id')->where('apply_type', 'apply');
    }

    public function matched() {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id')->where('apply_type', 'ojt_match');
    }

    public function finalList() {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id')
            ->whereNotNull('selected')
            ->select('trainee_id', 'ojt_id', 'selected')
            ->distinct();
    }

    public function unread()
    {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id', 'id')
            ->whereNull('read');
    }

    public function shortlist()
    {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id', 'id')
            ->whereNotNull('employeed');
    }

    public function ojtTraineeApplies()
    {
        return $this->hasMany(OjtTraineeApply::class, 'ojt_id');
    }
}
