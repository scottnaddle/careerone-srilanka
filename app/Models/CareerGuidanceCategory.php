<?php

namespace App\Models;

use App\Enums\StatusEnumsManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerGuidanceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug','sort'];

    public function careerGuidances() {
        return $this->hasMany(CareerGuidance::class, 'category_id', 'id');
    }

    public function contents() {
        return $this->hasMany(Content::class, 'category_id', 'id');
    }
    public function resources() {
        return $this->hasMany(Resource::class, 'category_id', 'id');
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->contents()->delete();
            $category->resources()->delete();
        });
    }

//    public function contentApproved()
//    {
//        return $this->hasMany(Content::class, 'category_id', 'id')->whereHas('peerReview', function ($query) {
//            $query->whereNotNull('cgo_user_1_result')
//                ->whereNotNull('cgo_user_2_result')
//                ->whereNotNull('cgo_user_3_result')
//                ->whereRaw('
//                (
//                    COALESCE(cgo_user_1_result, 0) +
//                    COALESCE(cgo_user_2_result, 0) +
//                    COALESCE(cgo_user_3_result, 0)
//                ) / 3 > 75
//            ');
//        });
//    }
    public function contentApproved()
    {
        return $this->hasMany(Content::class, 'category_id', 'id')
            ->where(function ($query) {
                $query->where('status', StatusEnumsManagement::APPROVED_BY_ADMIN)
                    ->orWhere('status', StatusEnumsManagement::APPROVED_BY_ASSOCIATION);
            });
    }
}
