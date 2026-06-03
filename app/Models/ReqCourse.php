<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqCourse extends Model
{
    use HasFactory;
    protected $table='reg_courses';
    protected $fillable = [
        'institute_reg_no',
        'institute_name',
        'district_code',
        'course_id',
        'course_name',
        'course_duration',
        'course_mode',
        'course_medium',
        'entry_qualification',
    ];
}
