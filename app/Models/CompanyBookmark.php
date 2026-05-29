<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBookmark extends Model
{
    use HasFactory;

    protected $fillable = ['trainee_id', 'company_id'];

    public function trainee() {
        return $this->belongsTo(TraineeUser::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
