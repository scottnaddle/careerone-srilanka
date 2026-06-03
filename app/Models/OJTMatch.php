<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OJTMatch extends Model
{
    use HasFactory;
    protected $fillable = ['trainee_id', 'ojt_id', 'matched_time', 'matched_by', 'system'];

    public function traineeMatched() {
        return $this->belongsTo(TraineeUser::class,'trainee_id');
    }

    public function matchedBy() {
        return $this->belongsTo(CgoUser::class, 'matched_by');
    }

    public function ojt() {

    }

}
