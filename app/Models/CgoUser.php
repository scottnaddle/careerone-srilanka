<?php

namespace App\Models;

use App\Constant\Constant;
use App\Mail\SendEmailVerificationCode;
use App\Traits\HasGenerateCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\ActivityLogger;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use App\Services\ESMSService;
use Filament\Models\Contracts\HasName;
use App\Models\ActivityLog;
class CgoUser extends Authenticatable implements HasName
{
    use \App\Models\Traits\HasMagicLink;
    use HasApiTokens, HasFactory, Notifiable, HasGenerateCode;
    protected $fillable = ['nic', 'first_name', 'last_name', 'email', 'password', 'telephone', 'profile_image', 'district_id', 'institute_id', 'verify_at', 'verify_by', 'email_verified_at', 'attached_file','reason', 'active', 'last_login_at', 'last_login_reminder_sent_at'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'last_login_reminder_sent_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
    public function getFilamentName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function sendEmailVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::cgo);
        Mail::to($this->email)->send(new SendEmailVerificationCode($verificationCode->code, $token));
    }

    public function sendSMSVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::cgo);
        $sms_service = new ESMSService();
        $session = $sms_service->createSession();
        \Log::info(['session: ' => $session]);
        $message = trans('auth.verification.verify_message', ['code' => $verificationCode->code], 'en');
        $status = $sms_service->sendMessagesMultiLang($session,'TVEC', $message, [$this->telephone], 0);
        $sms_service->closeSession($session);
        \Log::info(['status: ' => $status]);
    }

    public function hasVerifiedEmail()
    {
        return $this->email_verified_at != null;
    }

    public function markEmailAsVerified()
    {
        $this->update([
            'email_verified_at' => now(),
        ]);
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }

    public function qnas() {
        return $this->hasMany(QNA::class, 'created_by');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['first_name'] . ' ' . $attribute['last_name'],
        );
    }

    public function qnaAnswers() {
        return $this->hasMany(QNAAnswer::class, 'answer_by');
    }

    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class, 'user_id', 'id')
                    ->where('system', '=', 'cgo');
    }
    public function isFullyVerified()
    {
        return !is_null($this->verify_at) && !is_null($this->email_verified_at) && !is_null($this->verify_by);
    }
    public function counselings()
    {
        return $this->hasManyThrough(
            CgoCounseling::class,
            CgoCounselingAssignHistory::class,
            'assignee_to',
            'id',
            'id',
            'counseling_id'
        );
    }

    public function completedCounselings()
    {
        return $this->hasManyThrough(
            CgoCounseling::class,
            CgoCounselingAssignHistory::class,
            'assignee_to',
            'id',
            'id',
            'counseling_id'
        )->where('cgo_counselings.status', 3);
    }

    public function countCancelCounseling(){
        return $this->hasMany(UserAction::class,'cgo_user_id','id')
                    ->where('action','Rejected counseling');
    }
    public function events(){
        return $this->hasMany(Event::class,'created_by','id')->where('system','cgo');
    }
    public function contents(){
        return $this->hasMany(Content::class,'created_by','id')->where('system','cgo');
    }
    public function qnaAnswes(){
        return $this->hasMany(QNAAnswer::class,'answer_by','id')->where('system','cgo');
    }
    public function statusCgouser(){
        if(is_null($this->verify_at) && is_null($this->verify_by)){
            return 'Request';
        }else if(!is_null($this->verify_at) && !is_null($this->verify_by)){
            return 'Verified';
        }else{
            return 'Rejected';
        }
    }
    public function UserReActive()
    {
        return $this->hasMany(ReactiveAccountRequest::class, 'user_id')
            ->where('reactive_account_requests.user_type', 'cgo');
    }

    /**
     * Relationship get login activities
     */
    public function loginActivities()
    {
        return $this->morphMany(ActivityLog::class, 'causer')
            ->where('log_name', 'Access')
            ->whereRaw('properties->>\'guard\' = ?', ['cgo']);
    }

    /**
     * total login time
     */
    public function getTotalLoginCountAttribute()
    {
        return $this->loginActivities()->count();
    }

    /**
     * this week
     */
    public function getLoginCountThisWeekAttribute()
    {
        return $this->loginActivities()
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->count();
    }

    /**
     * this month
     */
    public function getLoginCountThisMonthAttribute()
    {
        return $this->loginActivities()
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->count();
    }

    /**
     * last month
     */
    public function getLoginCountLastMonthAttribute()
    {
        return $this->loginActivities()
            ->whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ])
            ->count();
    }

    /**
     * this quarter
     */
    public function getLoginCountThisQuarterAttribute()
    {
        return $this->loginActivities()
            ->whereBetween('created_at', [
                now()->startOfQuarter(),
                now()->endOfQuarter()
            ])
            ->count();
    }

    /**
     * this year
     */
    public function getLoginCountThisYearAttribute()
    {
        return $this->loginActivities()
            ->whereBetween('created_at', [
                now()->startOfYear(),
                now()->endOfYear()
            ])
            ->count();
    }

    public function scopeInactive($query, $days = 30)
    {
        return $query->where(function($q) use ($days) {
            $q->where('last_login_at', '<', Carbon::now()->subDays($days))
                ->orWhereNull('last_login_at');
        });
    }

    // Scope để lấy CGO chưa được nhắc nhở gần đây
    public function scopeNotRemindedRecently($query, $days = 7)
    {
        return $query->where(function($q) use ($days) {
            $q->whereNull('last_login_reminder_sent_at')
                ->orWhere('last_login_reminder_sent_at', '<', Carbon::now()->subDays($days));
        });
    }

}
