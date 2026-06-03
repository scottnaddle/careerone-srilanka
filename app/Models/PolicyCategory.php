<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','name_sn','name_tm', 'description_sn', 'description_tm'];

    public function policies() {
        return $this->hasMany(Policy::class, 'category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($policyCategory) {
            $policyCategory->policies()->delete(); // Delete related policies
        });
    }
   public function getName()
{
    return PolicyCategory::where('id', $this->id)
        ->value(app()->getLocale()=='en' ?  'name': 'name_'.app()->getLocale()) ?? $this->name; 
}
public function getDescription(){
    return PolicyCategory::where('id', $this->id)
    ->value(app()->getLocale()=='en' ?  'description': 'description_'.app()->getLocale()) ?? $this->description; 
}

}