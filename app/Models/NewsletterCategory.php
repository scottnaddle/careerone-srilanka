<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description','name_sn','name_tm', 'description_sn', 'description_tm'];
    public function newsLetters() {
        return $this->hasMany(NewLetter::class, 'newsletter_category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($newsLeterCategory) {
            $newsLeterCategory->newsLetters()->delete(); // Delete related newsletter
        });
    }
    public function getName()
    {
        return NewsletterCategory::where('id', $this->id)
            ->value(app()->getLocale()=='en' ?  'name': 'name_'.app()->getLocale()) ?? $this->name; 
    }
    public function getDescription(){
        return NewsletterCategory::where('id', $this->id)
        ->value(app()->getLocale()=='en' ?  'description': 'description_'.app()->getLocale()) ?? $this->description; 
    }
}
