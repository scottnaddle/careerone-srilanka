<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CareerGuidance extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'thumbnail', 'slug', 'intro', 'video_url', 'system', 'status', 'created_by'];

    public function category()
    {
        return $this->belongsTo(CareerGuidanceCategory::class);
    }

    public function owner()
    {
        $model = CgoUser::class;
        switch ($this->system) {
            case 'company':
                $model = CompanyRecruiter::class;
                break;
            case 'admin':
                $model = AdminUser::class;
                break;
        }

        return $this->belongsTo($model, 'created_by', 'id');
    }
    public function getThumbnailUrlAttribute()
{
    return $this->thumbnail ? Storage::url($this->thumbnail) : null;
}
}
