<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeepTrainee extends Model
{
    use HasFactory;

    protected $fillable = ['trainee_id', 'keeper_id', 'system'];
    public function trainee() {
        return $this->belongsTo(TraineeUser::class, 'trainee_id', 'id');
    }
}
