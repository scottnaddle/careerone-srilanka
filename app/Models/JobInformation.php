<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobInformation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'sector_id', 'description', 'knowledge', 'skills', 'duties_of_the_job', 'related_occupations', 'benefits', 'expected_income_per_month', 'created_by', 'attachment_details'];
    protected $casts = [
        'attachment_details' => 'array',
    ];
    public function sector() {
        $tmp = Sector::where('id', $this->sector_id)->first();
        if ($tmp->sector_id != null) {
            $sector = Sector::where('id', $tmp->sector_id)->first();
            $sector->sub_sector_name = $tmp->name;
            return $sector;
        }else {
            $tmp->sub_sector_name = '-';
        }
        return $tmp;
    }

    public function sectors()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }


}
