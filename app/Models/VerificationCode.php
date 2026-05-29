<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class VerificationCode extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'email',
        'code',
        'u_type',
        'expired_at',
        'is_reset_code'
    ];

    protected $dateTimes = [
        "expired_at",
    ];

}
