<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'file', 'category_id','name_sn', 'description_sn','name_tm', 'description_tm', 'file_sn', 'file_tm'];
    
    public function category() {
        return $this->belongsTo(PolicyCategory::class);
    }
//    protected static function booted()
//    {
//        static::creating(function ($policy) {
//            // Prepend 'storage/' to the file attribute if it exists
//            if ($policy->file) {
//                $policy->file = 'storage/' . $policy->file;
//            }
//        });
//
//        static::updating(function ($policy) {
//            // Prepend 'storage/' to the file attribute if it exists during update
//            if ($policy->file) {
//                $policy->file = 'storage/' . $policy->file;
//            }
//        });
//    }
    private function getLocalizedAttribute($column)
    {
        $locale = app()->getLocale();
        $localizedColumn = ($locale == 'en') ? $column : "{$column}_{$locale}";

        return $this->attributes[$localizedColumn] ?? $this->attributes[$column] ?? null;
    }

    public function getName()
    {
        return $this->getLocalizedAttribute('name');
    }
    public function getDescription()
    {
        return $this->getLocalizedAttribute('description');
    }
    public function getAttachment()
    {
        return $this->getLocalizedAttribute('file');
    }
}
