<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CgoCounselingAssignHistory extends Model
{
    use HasFactory;

    protected $table = 'cgo_counseling_assign_histories';

    protected $fillable = [
        'counseling_id',
        'assignee_from',
        'assignee_to',
        'time',
        'created_by',
        'updated_by',
    ];

    public function cgoCounseling() {
        return $this->belongsTo(CgoCounseling::class, 'counseling_id', 'id');
    }
    public function cgoAssignTo(){
        return $this->belongsTo(CgoUser::class, 'assignee_to', 'id');
    }
}
