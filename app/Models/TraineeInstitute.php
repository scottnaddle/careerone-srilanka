<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeInstitute extends Model
{
    use HasFactory;
    protected $fillable = ['trainee_id', 'institute_id', 'start_date', 'end_date'];
    public function institute() {
        return $this->belongsTo(Institute::class, 'institute_id');
    }
}
