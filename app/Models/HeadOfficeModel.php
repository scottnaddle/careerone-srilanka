<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadOfficeModel extends Model
{
    use HasFactory;
    protected $fillable=['head_office_code','head_office_name'];
    protected $table='head_offices';

    public function institutes()
    {
        return $this->hasMany(Institute::class, 'institute_head_office', 'head_office_code')->orderBy('name', 'asc');
    }
}
