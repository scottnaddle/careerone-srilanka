<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class Banner extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory, HasUlids;

     /**
     * @var array<int, string>
     */
    protected $table="banners";
    protected $fillable = [
        'banner_category_id',
        'sort',
        'title',
        'banner_title',
        'description',
        'image_url',
        'click_url',
        'click_url_target',
        'is_visible',
        'start_date',
        'end_date',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BannerCategory::class, 'banner_category_id');
    }

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banners')
            ->singleFile();
    }

    public $incrementing = false;
    protected $keyType = 'string';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function bannerImage() {
        return $this->hasOne(Media::class, 'model_id');
    }
}
