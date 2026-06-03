<?php

namespace App\Models;

use App\Enums\CgoCounselingStatusEnums;
use App\Enums\CgoCounselingTypeEnums;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CounselingAttachment;

class CgoCounseling extends Model
{
    use HasFactory;

    protected $table = 'cgo_counselings';

    protected $fillable = [
        'title',
        'detail_information',
        'counseling_field_id',
        'available_time',
        'registration_date',
        'trainee_id',
        'trainee_nic',
        'status',
        'institute_id',
        'location',
        'counseling_type',
        'shift',
        'result',
        'trainee_offline_firstname',
        'trainee_offline_lastname',
        'trainee_offline_mobile',
        'trainee_offline_institute',
        'trainee_offline_email',
        'suggested_institutes',
        'suggested_nvq_courses',
        'suggested_tvec_courses',
        'created_by',
        'updated_by',
        'temporary_save',
    ];

    public function counselingField() {
        return $this->belongsTo(CounselingField::class, 'counseling_field_id', 'id');
    }

    public function traineeUser() {
        return $this->belongsTo(TraineeUser::class, 'trainee_id', 'id');
    }

    public function cgoCounselingAssignHistory() {
        return $this->hasMany(CgoCounselingAssignHistory::class, 'counseling_id', 'id');
    }

    public function cgoUser() {
        return $this->hasOneThrough(CgoUser::class,CgoCounselingAssignHistory::class, 'counseling_id','id','id','assignee_to')->orderBy('id','desc');
    }

    public function institute() {
        return $this->belongsTo(Institute::class, 'institute_id', 'id');
    }

    public function getListOfCounseling() {
        return $this->select()
            ->with('counselingField')
            ->with('traineeUser')
            ->get();
    }
    protected function statusName(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => CgoCounselingStatusEnums::getCgoCounselingStatusName(CgoCounselingStatusEnums::from($attribute['status']))
        );
    }

    protected function typeName(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => CgoCounselingTypeEnums::getCgoCounselingTypeName(CgoCounselingTypeEnums::from($attribute['type']))
        );
    }

    protected function isAm(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => Carbon::parse($attribute['available_time'])->hour < 12
        );
    }

    protected function isPm(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => Carbon::parse($attribute['available_time'])->hour >= 12
        );
    }
    public function counselingAttachment(){
        return $this->hasMany(CounselingAttachment::class,'counseling_id','id');
    }
    public function district(){
        return $this->belongsTo(District::class, 'location', 'id');
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

        return $this->belongsTo(CategorySystem::class, 'counseling_field_id')
                    ->where('module', 'counseling')
                    ->select('id', \DB::raw("$moduleColumn as name"))
                    ->orderBy('name', 'asc');
    }
    public function trainee_name(){
        return $this->hasMany(TraineeUser::class ,'id','trainee_id');
    }

}
