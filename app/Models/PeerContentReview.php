<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PeerContentReview extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'content_id',
        'cgo_user_id_1',
        'cgo_user_id_2',
        'cgo_user_id_3',
        'cgo_user_1_result',
        'cgo_user_2_result',
        'cgo_user_3_result',
        'cgo_user_1_result_details',
        'cgo_user_2_result_details',
        'cgo_user_3_result_details',
    ];

    public function content() {
        return $this->hasOne(Content::class, 'id', 'content_id');
    }

    public function hasUserResponded($userId)
    {
        return (
            ($this->cgo_user_id_1 == $userId && !is_null($this->cgo_user_1_result)) ||
            ($this->cgo_user_id_2 == $userId && !is_null($this->cgo_user_2_result)) ||
            ($this->cgo_user_id_3 == $userId && !is_null($this->cgo_user_3_result))
        );
    }

    public function getCurrentUserResult()
    {
        $userId = Auth::guard('cgo')->id();

        if ($this->cgo_user_id_1 == $userId) {
            return [
                'result' => $this->cgo_user_1_result,
                'details' => $this->cgo_user_1_result_details,
            ];
        }

        if ($this->cgo_user_id_2 == $userId) {
            return [
                'result' => $this->cgo_user_2_result,
                'details' => $this->cgo_user_2_result_details,
            ];
        }

        if ($this->cgo_user_id_3 == $userId) {
            return [
                'result' => $this->cgo_user_3_result,
                'details' => $this->cgo_user_3_result_details,
            ];
        }

        return null; // Not assigned
    }
}
