<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NvqCourses extends Model
{
    use HasFactory;
    protected $fillable=['course_id','course_name','level','tvec_registration_number','reg_no','ncs_code','ncs_name'];
}
