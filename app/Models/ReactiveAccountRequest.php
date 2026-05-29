<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactiveAccountRequest extends Model
{
    use HasFactory;

    public function profile()
    {
        return match($this->user_type) {
            'admin' => $this->hasOne(AdminUser::class, 'id', 'user_id'),
            'cgo' => $this->hasOne(CgoUser::class, 'id', 'user_id'),
            'trainee' => $this->hasOne(TraineeUser::class, 'id', 'user_id'),
            'company' => $this->hasOne(CompanyRecruiter::class, 'id', 'user_id'),
            default => $this->morphTo(), 
        };
    }
}
