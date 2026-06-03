<?php

namespace App\Models;

use App\Enums\FaqSystemEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'category_name',
        'description',
        'system',
    ];

    public function getFaqCGOList($request) {
        $query = $this->select('id', 'category_name', 'description',  'system')
                      ->orderBy('created_at', 'desc');

        //count total article in faq
        $query->withCount('faqArticle');

        return $query->paginate($request->per_page ?? 10);
    }

    public function faqArticle() {
        return $this->hasMany(FaqArticle::class, 'faq_id', 'id');
    }
}
