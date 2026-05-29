<?php

namespace App\Models;

use App\Enums\NoticeTypeEnums;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';

    protected $fillable = [
        'title',
        'type',
        'status',
        'description',
        'system_enum',
        'created_by',
        'is_publish',
        'start_date',
        'end_date',
        'updated_by',
    ];

    public function getNoticeCGOList($request)
    {
        $query = self::query()->orderBy('created_at', 'desc');
        if ($request->has('search_query')) {
            $query->where('title', 'ILIKE', '%' . $request->search_query . '%');
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        return $query->paginate(10)->appends($request->query());
    }

    protected function typeName(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => NoticeTypeEnums::getNoticeTypeName(NoticeTypeEnums::from($attribute['type']))
        );
    }

    //public function createdBy()
    //{
    //    return $this->belongsTo(AdminUser::class, 'created_by', 'id');
    //}

    // TODO: create ADMIN user then relate to this

    public function getNoticeDetail($id)
    {
        return $this->query()
            //->with('createdBy') TODO: create ADMIN user then relate to this
            ->find($id);
    }
    public function category(){
        return $this->belongsTo(NoticeType::class, 'type');
    }
    public function categoryModule()
    {
        $language = app()->getLocale();
        $moduleColumn = match ($language) {
            'en' => 'code_name_en',
            'tm' => 'code_name_tm',
            'sn' => 'code_name_sn',
            default => 'code_name_en',
        };

        return $this->belongsTo(CategorySystem::class, 'type')
                    ->where('module', 'notice')
                    ->select('id', \DB::raw("$moduleColumn as name"))
                    ->orderBy('name', 'asc');
    }

    public function noticeType()
    {
        $language = app()->getLocale();
        $moduleColumn = match ($language) {
            'en' => 'code_name_en',
            'tm' => 'code_name_tm',
            'sn' => 'code_name_sn',
            default => 'code_name_en',
        };

        return $this->belongsTo(CategorySystem::class, 'type')
            ->where('module', 'notice_type')
            ->select('code_id', \DB::raw("$moduleColumn as name"))
            ->orderBy('code_id', 'asc');
    }

    public function author() {
        return $this->belongsTo(AdminUser::class,'created_by');
    }
}
