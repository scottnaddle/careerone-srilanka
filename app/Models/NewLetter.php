<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewLetter extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'thumbnail', 'attachment', 'newsletter_category_id','title_sn', 'description_sn','title_tm', 'description_tm', 'attachment_sn', 'attachment_tm'];
    public function newsletterCategory()
    {
        return $this->belongsTo(NewsletterCategory::class, 'newsletter_category_id');
    }
    private function getLocalizedAttribute($column)
    {
        $locale = app()->getLocale();
        $localizedColumn = ($locale == 'en') ? $column : "{$column}_{$locale}";

        return $this->attributes[$localizedColumn] ?? $this->attributes[$column] ?? null;
    }

    public function getName()
    {
        return $this->getLocalizedAttribute('title');
    }
    public function getDescription()
    {
        return $this->getLocalizedAttribute('description');
    }
    public function getAttachment()
    {
        return $this->getLocalizedAttribute('attachment');
    }
}
