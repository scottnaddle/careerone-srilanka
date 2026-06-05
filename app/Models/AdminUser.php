<?php

namespace App\Models;

use App\Constant\Constant;
use App\Mail\SendEmailVerificationCode;
use App\Notifications\UserRegisterVerification;
use App\Services\ESMSService;
use App\Traits\HasGenerateCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUser extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory;
    use Notifiable;
    use HasGenerateCode;
    use HasRoles;
    protected $guard = 'admin';
    protected $table='admin_users';
    protected $fillable = [
        'nic', 'first_name','last_name','username','tvet_type','institute_id', 'verify_at', 'verify_by', 'role', 'email', 'password','phone', 'email_verified_at','active'
    ];
    public function getFilamentName(): string
    {
        return $this->first_name . ' ' . $this->last_name; // Hoặc format khác tùy ý
    }
    public function getFilamentUserName(): string
    {
        return "{$this->firstname} {$this->lastname}" ?? $this->email;
    }

    public function canAccessPanel(Panel $panel): bool
    {
//        if ($panel->getId() === 'admin') {
//            return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
//        }
//
        return true;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function sendEmailVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::admin);
        Mail::to($this->email)->send(new SendEmailVerificationCode($verificationCode->code, $token));
    }

    public function sendSMSVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::admin);
        $sms_service = new ESMSService();
        $session = $sms_service->createSession();
        \Log::info(['session: ' => $session]);
        $message = trans('auth.verification.verify_message', ['code' => $verificationCode->code], 'en');
        $status = $sms_service->sendMessagesMultiLang($session,'TVEC', $message, [$this->phone], 0);
        $sms_service->closeSession($session);
        \Log::info(['status: ' => $status]);
    }
    public function hasVerifiedEmail()
    {
        return $this->email_verified_at != null;
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
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

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['first_name'] . ' ' . $attribute['last_name'],
        );
    }

public function isFullyVerified()
    {
        return !is_null($this->verify_at) && !is_null($this->email_verified_at) && !is_null($this->verify_by);
    }
//     public function roles()
// {
//     return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
//                 ->wherePivot('model_type', AdminUser::class);
// }

// // Quan hệ nhiều-nhiều với Permission
// public function permissions()
// {
//     return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id')
//                 ->wherePivot('model_type', AdminUser::class);
// }
public function team()
{
    return $this->belongsTo(Team::class);
}
public function tvetType(){
    return $this->belongsTo(TvetType::class,'tvet_type','head_office_code');
}
public function statusAdminUser(){
    if(is_null($this->verify_at) && is_null($this->verify_by)){
        return 'Request';
    }else if(!is_null($this->verify_at) && !is_null($this->verify_by)){
        return 'Verified';
    }else{
        return 'Rejected';
    }
}
public function scopeVerified($query)
{
    return $query->whereNotNull('verify_at')->whereNotNull('verify_by');
}
public function UserReActive()
{
    return $this->hasMany(ReactiveAccountRequest::class, 'user_id')
        ->where('reactive_account_requests.user_type', 'admin');
}

}
