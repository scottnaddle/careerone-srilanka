<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqArticle extends Model
{
    use HasFactory;

    protected $table = 'faq_articles';

    protected $fillable = [
        'faq_id',
        'question',
        'answer',
        'url'
    ];

    public function faq() {
        return $this->belongsTo(Faq::class, 'faq_id', 'id');
    }
}
