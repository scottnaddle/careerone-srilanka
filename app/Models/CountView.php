<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountView extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'content_id', 'user_id', 'ip_address', 'user_agent', 'viewed_at'
    ];

    protected $dates = ['viewed_at'];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

}
