<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvetType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description','head_office_code','head_office_name'];
}
