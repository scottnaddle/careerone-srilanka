<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeSector extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'trainee_id', 'sector_id'
    ];
}
