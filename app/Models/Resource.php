<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content_type',
        'slug',
        'intro',
        'video_url',
        'attachment_details',
        'created_by',
        'system',
        'category_id',
        'thumbnail',
        'views',
        'likes'
    ];

    public function category() {
        return $this->belongsTo(CareerGuidanceCategory::class, 'category_id');
    }
    public function comments()
    {
        return $this->hasMany(ContentComment::class, 'content_id')->whereNull('parent_id')->where('type', 'resource');
    }

    public function getAuthor($system, $userId) {
        $model = null;

        switch ($system) {
            case 'cgo':
                $model = CgoUser::class;
                break;
            case 'company':
                $model = CompanyRecruiter::class;
                break;
            case 'admin':
                $model = AdminUser::class;
                break;
            case 'trainee':
                $model = TraineeUser::class;
                break;
            default:
                return null;
        }
        return $model::find($userId);
    }

    public function author() {
        $model = CgoUser::class;
        switch ($this->system){
            case 'admin':
                $model = AdminUser::class;
                break;
            case 'company':
                $model = CompanyRecruiter::class;
                break;
            case 'trainee':
                $model = TraineeUser::class;
                break;
        }
        return $this->belongsTo($model, 'created_by');
    }
}
