<?php

namespace App\Models;

use App\Models\CgoUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\AdminUser;
class Content extends Model
{
    use HasFactory;
    protected $fillable = [
        'content_type',
        'title',
        'slug',
        'intro',
        'video_url',
        'attachment_details',
        'author',
        'license',
        'system',
        'status',
        'size',
        'created_by',
        'reason',
        'category_id',
        'thumbnail'
    ];
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

    public function category() {
        return $this->belongsTo(CareerGuidanceCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(ContentComment::class, 'content_id')->whereNull('parent_id')
            ->where(function ($query) {
                $query->where('type', 'content')
                    ->orWhere('type', '');
        });
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

    public function peerReview() {
        return $this->hasOne(PeerContentReview::class, 'content_id');
    }

    public function editCategory($categoryId)
    {
        $this->update(['category_id' => $categoryId]);
    }

}
