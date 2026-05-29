<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'event_type', 'slug', 'details', 'thumbnail', 'start_time', 'end_time', 'system', 'status', 'created_by','reason','sort', 'place', 'show_on_homepage', 'is_main_event'];
    protected $casts = [
        'start_time' => 'datetime:m/d/Y',
        'end_time' => 'datetime:m/d/Y',
        'show_on_homepage' => 'boolean',
    ];

    public function attachments() {
        return $this->hasMany(EventAttachment::class, 'event_id');
    }
   public function author()
   {
       switch ($this->system) {
           case 'cgo':
               return $this->belongsTo(CgoUser::class, 'created_by');
           case 'company':
               return $this->belongsTo(CompanyRecruiter::class, 'created_by');
           case 'admin':
               return $this->belongsTo(AdminUser::class, 'created_by');
           default:
               return null;
       }
   }
   public function getFullNameAttribute()
   {
       $author = $this->author; // Lấy đối tượng tác giả
       return $author ? "{$author->first_name} {$author->last_name}" : 'Unknown'; // Trả về tên đầy đủ hoặc 'Unknown' nếu không tìm thấy
   }

    public function recruiter() {
        return $this->belongsTo(CompanyRecruiter::class, 'created_by');
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


        return $this->belongsTo(CodeManagement::class, 'event_type')
                    ->where('module', 'event_type')
                    ->select('code_id as id', \DB::raw("$moduleColumn as name"))
                    ->orderBy('name', 'asc');
    }


}
