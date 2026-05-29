<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CareerTestTraineeResult;

class CareerTest extends Model
{
    use HasFactory;
    public function traineeResult()
    {
        return $this->hasMany(CareerTestTraineeResult::class, 'career_test_id');
    }
    public function codeManagement()
    {
        return $this->belongsTo(CodeManagement::class, 'test_type', 'code_id')->where('module','career_test_type');
    }
}
