<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institute;
use App\Models\CareerTest;
use App\Models\TraineeUser;

class CareerTestTraineeResult extends Model
{
    use HasFactory;
    public function careerTest()
    {
        return $this->belongsTo(CareerTest::class, 'career_test_id','id');
    }

    public function trainee()
    {
        return $this->belongsTo(TraineeUser::class, 'trainee_id', 'id');
    }

    public function traineeInstitute()
    {
        return $this->hasOne(TraineeInstitute::class, 'trainee_id', 'trainee_id')
            ->where(function ($query) {
                $query->whereDate('start_date', '<=', $this->created_at ?? now())
                      ->whereDate('end_date', '>=', $this->created_at ?? now());
            });
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id', 'id');
    }



}
