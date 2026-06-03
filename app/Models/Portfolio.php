<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;
    protected $fillable = ['trainee_id', 'data'];

    protected $casts = [
        'data' => 'array'
    ];

    public function trainee(){
        return $this->belongsTo(TraineeUser::class, 'trainee_id');
    }
}
