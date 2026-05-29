<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeNVQ extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'trainee_id', 'nvq_id', 'effective_date', 'course_mode'
    ];
}
