<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;
    protected $fillable = ['sector_id', 'name', 'description', 'short_description'];
    public function getSubSectors() {
        return $this->hasMany(Sector::class, 'sector_id');
    }

    public function jobs() {
        return $this->hasMany(JobInformation::class, 'sector_id', 'id');
    }
    public function jobCompany()
    {
        return $this->hasMany(Job::class, 'sector_id', 'id');
    }
    public function parent() {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
    public function jobCompanies() {
        return $this->hasMany(Job::class, 'sector_id', 'id');
    }
}
