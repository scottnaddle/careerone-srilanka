<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeRegCourse extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'trainee_id', 'reg_course_id', 'batch_no', 'start_date', 'end_date'
    ];
}
