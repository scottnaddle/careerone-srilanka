<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeMatch extends Model
{
    use HasFactory;

    protected $fillable = ['trainee_id', 'job_id', 'match_time', 'created_by'];

    public function matchedBy() {
        return $this->belongsTo(CgoUser::class, 'created_by');
    }
}
