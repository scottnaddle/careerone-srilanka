<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'prov_id'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'prov_id' => 'string',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'prov_id');
    }

    public function divisionalSecretariats()
    {
        return $this->hasMany(DivisionalSecretariats::class, 'dist_id');
    }
//    public function counselings()
//    {
//       return $this->hasMany(
//           CgoCounseling::class,
//           'location',
//           'id'
//       )
//       ->when(request()->filled('search'), function($query) {
//           return $query->where('title', 'LIKE', "%" . request('search') . "%");
//       })
//       ->when(request()->filled('startDate'), function($query) {
//           return $query->whereDate('cgo_counselings.created_at', '>=', request('startDate'));
//       })
//       ->when(request()->filled('endDate'), function($query) {
//           return $query->whereDate('cgo_counselings.created_at', '<=', request('endDate'));
//       });
//    }
    public function counselings()
    {
        return $this->hasMany(
            CgoCounseling::class,
            'location',
            'id'
        )
            ->where(function ($query) {
                $query->where('status', '!=', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                    ->orWhere(function ($query) {
                        $query->where('status', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                            ->whereNotNull('result');
                    });
            })
            ->when(request()->filled('search'), function($query) {
                return $query->where('title', 'LIKE', '%' . request('search') . '%');
            })
            ->when(request()->filled('startDate'), function($query) {
                return $query->whereDate('cgo_counselings.created_at', '>=', request('startDate'));
            })
            ->when(request()->filled('endDate'), function($query) {
                return $query->whereDate('cgo_counselings.created_at', '<=', request('endDate'));
            });
    }
//    public function countCounselingFCodeId($code_id, $type)
//    {
//        return $this->counselings()->where($type, $code_id)->count();
//    }

    public function countCounselingFCodeId($code_id, $type)
    {
        return $this->counselings()
            ->where($type, $code_id)
            ->where(function ($query) {
                $query->where('status', '!=', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                    ->orWhere(function ($query) {
                        $query->where('status', \App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                            ->whereNotNull('result');
                    });
            })
            ->count();
    }

    public function institutes() {
        return $this->hasMany(Institute::class, 'dist_id')->orderBy('name', 'asc');
    }
}
