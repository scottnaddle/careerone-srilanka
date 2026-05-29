<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OjtTraineeApply extends Model
{
    use HasFactory;
    protected $fillable = ['trainee_id', 'ojt_id', 'apply_time', 'read', 'selected', 'selected_by', 'employeed', 'apply_type','matched_by','rejected_at','unselect_at'];

    public function user() {
        return $this->belongsTo(TraineeUser::class, 'trainee_id');
    }

    public function ojt() {
        return $this->belongsTo(OJT::class);
    }
    public function traineeMatched() {
        return $this->belongsTo(TraineeUser::class,'trainee_id');
    }
    public function checkOjtTraineeApply($traineeId=0,$ojt_id=0){
        return OjtTraineeApply::where('trainee_id', $traineeId)->where('apply_type', 'apply')->where('ojt_id',$ojt_id)->first();
    }
    public function matchedBy() {
        return $this->belongsTo(CgoUser::class, 'matched_by');
    }
}
