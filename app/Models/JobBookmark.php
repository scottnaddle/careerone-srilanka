<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBookmark extends Model
{
    use HasFactory;

    protected $fillable = ['trainee_id', 'job_id'];

    public function trainee() {
        return $this->belongsTo(TraineeUser::class, 'trainee_id', 'id');
    }

    public function job() {
        return $this->belongsTo(Job::class);
    }
}
