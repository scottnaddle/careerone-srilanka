<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OJTAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'ojt_id', 'file_name', 'path', 'file_type', 'file_size'];

    public function event() {
        return $this->belongsTo(OJT::class);
    }
}
