<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CgoCounseling;

class CounselingAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'counseling_id', 'file_name', 'path', 'file_type', 'file_size'];
    public function cgoCounseling(){
        return $this->belongsTo(CgoCounseling::class,'counseling_id','id');
    }
}
