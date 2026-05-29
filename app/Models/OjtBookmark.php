<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OjtBookmark extends Model
{
    use HasFactory;

    protected $fillable = ['trainee_id', 'ojt_id'];

    public function trainee() {
        return $this->belongsTo(TraineeUser::class, 'trainee_id', 'id');
    }

    public function ojt() {
        return $this->belongsTo(OJT::class);
    }
}
