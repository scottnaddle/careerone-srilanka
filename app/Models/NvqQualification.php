<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NvqQualification extends Model
{
    use HasFactory;
    protected $fillable=['nvq_id','nvq_name','version','nvq_level','ncs_code','ncs_name','description'];
    protected $table='nvq_qualifications';
}
