<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerExpertInterview extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'thumbnail', 'slug', 'intro', 'video_url', 'system', 'status', 'created_by'];

    public function owner()
    {
        $model = AdminUser::class;
//        switch ($this->system) {
//            case 'company':
//                $model = CompanyRecruiter::class;
//                break;
//            case 'admin':
//                $model = AdminUser::class;
//                break;
//        }

        return $this->belongsTo($model, 'created_by', 'id');
    }
}
