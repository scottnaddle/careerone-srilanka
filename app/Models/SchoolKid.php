<?php

namespace App\Models;

use App\Constant\Constant;
use App\Mail\SendEmailVerificationCode;
use App\Services\ESMSService;
use App\Traits\HasGenerateCode;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class SchoolKid extends Authenticatable implements HasName
{
    use HasApiTokens, HasFactory, Notifiable, HasGenerateCode;
    protected $table = 'school_kids';
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'telephone',
        'mobile',
        'district_id',
        'email_verified_at',
        'active',
        'recommended_by_user_id',
        'recommended_by_user_system',
        'gender',
        'contact_address',
        'permanant_address',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::schoolkid);
        Mail::to($this->email)->send(new SendEmailVerificationCode($verificationCode->code, $token));
    }
    public function getFilamentName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    // sendSMSVerify - do NOT retry here
    public function sendSMSVerify($token)
    {
        try {
            $verificationCode = $this->generateVerificationCodeFor($this, Constant::schoolkid);

            if (!$verificationCode) {
                \Log::error('Failed to generate verification code', [
                    'user_id' => $this->id,
                    'mobile' => $this->mobile
                ]);
                throw new \Exception('Verification code generation failed');
            }

            if (empty($this->mobile)) {
                \Log::error('User mobile number is empty', ['user_id' => $this->id]);
                throw new \Exception('Mobile number is required');
            }

            $sms_service = new ESMSService();
            $session = $sms_service->createSession();

            \Log::info('Session created', [
                'session' => $session,
                'user_id' => $this->id,
                'mobile' => $this->mobile
            ]);

            $message = trans('auth.verification.verify_message', ['code' => $verificationCode->code], 'en');

            // Call sendMessagesMultiLang (it already has retry logic inside)
            $status = $sms_service->sendMessagesMultiLang(
                $session,
                'TVEC',
                $message,
                $this->mobile,
                0  // messageType
            // Do NOT pass maxRetries and retryDelay here since the function already has defaults
            );

            \Log::info('SMS send response', [
                'status_code' => $status,
                'user_id' => $this->id,
                'mobile' => $this->mobile
            ]);

            // Close the session
            $sms_service->closeSession($session);

            // Check the result
            if ($status != 200) {
                \Log::error('Failed to send verification SMS', [
                    'user_id' => $this->id,
                    'mobile' => $this->mobile,
                    'status_code' => $status,
                    'verification_code' => $verificationCode->code
                ]);

                throw new \Exception("Failed to send SMS. Status code: {$status}");
            }

            \Log::info('Verification SMS sent successfully', [
                'user_id' => $this->id,
                'mobile' => $this->mobile
            ]);

            return true;

        } catch (\Exception $e) {
            \Log::error('Failed to send verification SMS', [
                'user_id' => $this->id,
                'mobile' => $this->mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function hasVerifiedEmail()
    {
        return $this->email_verified_at != null;
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => $attribute['first_name']. ' '. $attribute['last_name'],
        );
    }

    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function UserReActive()
    {
        return $this->hasMany(ReactiveAccountRequest::class, 'user_id')
            ->where('reactive_account_requests.user_type', 'trainee');
    }
}
