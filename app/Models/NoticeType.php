<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeType extends Model
{
    use HasFactory;
    protected $table="notice_type";
    protected $fillable=['name','description'];
}
