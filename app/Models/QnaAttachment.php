<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QnaAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'qna_id', 'file_name', 'path', 'file_type', 'file_size'];

    public function qna() {
        return $this->belongsTo(QNA::class);
    }
}
