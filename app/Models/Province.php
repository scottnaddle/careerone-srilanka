<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $casts = [
        'id' => 'string',
    ];
    protected $keyType = 'string';

    public function districts() {
        return $this->hasMany(District::class, 'prov_id');
    }

    public function institutes() {
        return $this->hasManyThrough(Institute::class, District::class,  'prov_id', 'dist_id', 'id', 'id')->orderBy('name', 'asc');
    }
}
