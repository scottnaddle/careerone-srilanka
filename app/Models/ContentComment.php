<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentComment extends Model
{
    use HasFactory;
    protected $fillable = ['content_id', 'answer', 'system', 'answer_by', 'parent_id', 'type'];
    public function children()
    {
        return $this->hasMany(ContentComment::class, 'parent_id')->where('type', $this->type);
    }

    public function parent()
    {
        return $this->belongsTo(ContentComment::class, 'parent_id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'content_id', 'id');
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
        return $this->belongsTo($model, 'answer_by');
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
}
