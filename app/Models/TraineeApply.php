<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeApply extends Model
{
    use HasFactory;

	protected $fillable = ['trainee_id', 'job_id', 'apply_time', 'read', 'selected', 'selected_by', 'apply_type','unselect_at'];

    public function user() {
        return $this->belongsTo(TraineeUser::class, 'trainee_id');
    }

    public function job() {
        return $this->belongsTo(Job::class);
    }
    public function traineeMatched() {
        return $this->belongsTo(TraineeUser::class,'trainee_id');
    }
}

