<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;
    protected $fillable = [
        'popup_name',
        'title',
        'title_sn',
        'title_tm',
        'message',
        'image',
        'status',
        'start_time',
        'end_time',
    ];
}
