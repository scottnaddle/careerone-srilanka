<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeTrainingHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'trainee_id', 'content', 'nvq_content'
    ];
}
