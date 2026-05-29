<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use HasFactory;
    protected $fillable=['cgo_user_id','action','ip_address'];
    protected $table='user_actions';
}
