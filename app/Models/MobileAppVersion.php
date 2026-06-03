<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileAppVersion extends Model
{
    use HasFactory;
    protected $fillable = [
        'version',
        'description',
        'platform',
    ];
}
