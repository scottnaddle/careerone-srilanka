<?php

namespace App\Models;

use App\Constant\Constant;
use App\Mail\SendEmailVerificationCode;
use App\Services\ESMSService;
use App\Traits\HasGenerateCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasName;

class CompanyRecruiter extends Authenticatable implements HasName
{
    use \App\Models\Traits\HasMagicLink;
    use HasApiTokens, HasFactory, Notifiable, HasGenerateCode;
    protected $fillable = ['first_name',
                           'username',
                           'last_name',
                           'email',
                           'password',
                           'telephone',
                           'verify_at',
                           'verify_by',
                           'email_verified_at',
                           'profile_image',
                           'company_id',
                           'reason',
                           'active',
                           'recommended_by_user_id',
                           'recommended_by_user_system'
                        ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::company);
        Mail::to($this->email)->send(new SendEmailVerificationCode($verificationCode->code, $token));
    }

    public function sendSMSVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::company);
        $sms_service = new ESMSService();
        $session = $sms_service->createSession();
        \Log::info(['session: ' => $session]);
        $message = trans('auth.verification.verify_message', ['code' => $verificationCode->code], 'en');
        $status = $sms_service->sendMessagesMultiLang($session,'TVEC', $message, [$this->telephone], 0);
        $sms_service->closeSession($session);
        \Log::info(['status: ' => $status]);
    }
    public function getFilamentName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
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

    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function isFullyVerified()
    {
        return !is_null($this->verify_at) && !is_null($this->email_verified_at) && !is_null($this->verify_by);
    }
    public function statusCompanyUser(){
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
            ->where('reactive_account_requests.user_type', 'company');
    }
    public function getIsCompanyVerifiedAttribute(): bool
    {
        return optional($this->company)->verified_by && optional($this->company)->verified_at;
    }
}
