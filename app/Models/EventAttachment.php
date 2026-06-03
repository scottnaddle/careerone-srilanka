<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'event_id', 'file_name', 'path', 'file_type', 'file_size'];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
