<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionalSecretariats extends Model
{
    use HasFactory;

    public function institutes()
    {
        return $this->hasMany(Institute::class, 'ds_id', 'ds_code')->orderBy('name', 'asc');
    }
}
