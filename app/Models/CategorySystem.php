<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySystem extends Model
{
    use HasFactory;
    protected $fillable=['code_id','code_name_en','code_name_tm','code_name_sn','module'];
    protected $table='code_managements';

}
