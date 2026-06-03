<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QNA extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['status', 'title', 'slug', 'description', 'system', 'created_by'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function replies()
    {
        return $this->hasMany(QNAAnswer::class, 'qna_id')->whereNull('parent_id');
    }
    public function allRepliesCount()
    {
        $replies = $this->replies()->with('children')->get(); // Ensure eager loading for children
        $totalReplies = $replies->count();

        foreach ($replies as $reply) {
            $totalReplies += $reply->children->count();
        }

        return $totalReplies;
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
            case 'schoolkid':
                $model = SchoolKid::class;
                break;
        }
        return $this->belongsTo($model, 'created_by');
    }


    //    public function author() {
    //        $system = $this->system;
    //        $userID = $this->created_by;
    //        $userModel = User::class;
    //        switch ($system) {
    //            case 'cgo':
    //                $userModel = CgoUser::class;
    //                break;
    //            case 'company':
    //                $userModel = Company::class;
    //                break;
    //        }
    //        return $author = $userModel::where('id', $userID)->first();
    //    }

    public function attachments()
    {
        return $this->hasMany(QnaAttachment::class, 'qna_id');
    }
}
