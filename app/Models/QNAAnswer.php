<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QNAAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['qna_id', 'answer', 'system', 'answer_by', 'parent_id'];

    public function children()
    {
        return $this->hasMany(QNAAnswer::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(QNAAnswer::class, 'parent_id');
    }

    public function qNA() {
        return $this->belongsTo(QNA::class, 'qna_id', 'id');
    }

    public function author() {
        $model = CgoUser::class;
        switch ($this->system){
            case 'admin':
                $model = AdminUser::class;
                break;
            case 'company':
                $model = CompanyRecruiter::class;
                break;
            case 'trainee':
                $model = TraineeUser::class;
                break;
            case 'schoolkid':
                $model = SchoolKid::class;
                break;
        }
        return $this->belongsTo($model, 'answer_by');
    }
}
