<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentViewLog extends Model
{
    use HasFactory;
    protected $fillable = ['view_log'];

    protected $casts = [
        'view_log' => 'array',
    ];
}
