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

class TraineeUser extends Authenticatable implements HasName
{
    use \App\Models\Traits\HasMagicLink;
    use HasApiTokens, HasFactory, Notifiable, HasGenerateCode;

    protected $table = 'trainee_users';
    protected $fillable = [
        'nic',
        'username',
        'email',
        'password',
        'full_name',
        'first_name',
        'last_name',
        'telephone',
        'mobile',
        'institute_id',
        'district_id',
        'email_verified_at',
        'active',
        'open_to_work',
        'public_portfolio',
        'recommended_by_user_id',
        'recommended_by_user_system',
        'std_surname',
        'std_initials',
        'gender',
        'contact_address',
        'permanant_address',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::trainee);
        Mail::to($this->email)->send(new SendEmailVerificationCode($verificationCode->code, $token));
    }
    public function getFilamentName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function sendSMSVerify($token)
    {
        $verificationCode = $this->generateVerificationCodeFor($this, Constant::trainee);
        $sms_service = new ESMSService();
        $session = $sms_service->createSession();
        \Log::info(['session: ' => $session]);
        $message = trans('auth.verification.verify_message', ['code' => $verificationCode->code], 'en');
        $status = $sms_service->sendMessagesMultiLang($session,'TVEC', $message, [$this->mobile], 0);
        $sms_service->closeSession($session);
        \Log::info(['status: ' => $status]);
    }

    public function hasVerifiedEmail()
    {
        return $this->email_verified_at != null;
    }

    public function nvqs()
    {
        return $this->belongsToMany(NVQLevel::class, TraineeNVQ::class, 'trainee_id', 'nvq_id');
    }

    public function institutes() {
        return $this->belongsToMany(Institute::class, TraineeInstitute::class, 'trainee_id', 'institute_id')->orderBy('name', 'asc');
    }
    public function sectors() {
        return $this->belongsToMany(Sector::class, TraineeSector::class, 'trainee_id', 'sector_id');
    }
    public function portfolio() {
        return $this->hasOne(Portfolio::class, 'trainee_id');
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


    public function cgoCounseling()
    {
        return $this->hasMany(CgoCounseling::class, 'trainee_id', 'id');
    }

    public function traineeInformation()
    {
        return $this->hasOne(TraineeTrainingHistory::class, 'trainee_id');
    }
    public function jobApplies() {
        return $this->hasMany(TraineeApply::class, 'trainee_id')->where('apply_type', 'apply');
    }
    public function jobMatches() {
        return $this->hasMany(TraineeApply::class, 'trainee_id')->where('apply_type', 'job_match');
    }

//    public function jobMatches() {
//        return $this->hasMany(TraineeMatch::class, 'trainee_id')->distinct('job_id');
//    }

    public function isKeep() {
        $isKept = KeepTrainee::where(['trainee_id' => $this->id, 'system'=> activeGuard(), 'keeper_id' => auth(activeGuard())->user()?->id])->first();
        if ($isKept) return true;
        return false;
    }
    //Khong dung
    public function institute() {
        return $this->belongsTo(TraineeInstitute::class, 'institute_id');
    }

    public function isMatchOJT($ojt_id) {
        $isMatch = OjtTraineeApply::where(['trainee_id' => $this->id, 'ojt_id' => $ojt_id])->first();
        if ($isMatch) return true;
        return false;
    }

    public function isMatchJob($job_id) {
        $isMatch = TraineeMatch::where(['trainee_id' => $this->id, 'job_id' => $job_id])->first();
        $isApplyMatch = TraineeApply::where(['trainee_id' => $this->id, 'job_id' => $job_id, 'apply_type' => 'job_match'])->first();
        if ($isMatch || $isApplyMatch) return true;
        return false;
    }

    public function keepTrainee() {
        return $this->hasMany(KeepTrainee::class, 'trainee_id', 'id');
    }

    public function ojtMatches()
    {
        return $this->hasMany(OjtTraineeApply::class, 'trainee_id', 'id');
    }


    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attribute) => $attribute['full_name'] ?? $attribute['first_name']. ' '. $attribute['last_name'],
        );
    }

    public function jobMarks() {
        return $this->hasMany(JobBookmark::class, 'trainee_id', 'id');
    }

    public function companyMarks() {
        return $this->hasMany(CompanyBookmark::class, 'trainee_id', 'id');
    }

    public function nvq() {
        return $this->belongsTo(NVQLevel::class, 'nvq_id', 'id');
    }

    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class, 'user_id', 'id')
                    ->where('system', '=', 'trainee');
    }

    public function careerTest() {
        return $this->hasMany(CareerTestTraineeResult::class, 'trainee_id');
    }

    public function traineeResume() {
        return $this->hasMany(Resume::class, 'trainee_id');
    }
    public function isFullyVerified()
    {
        return !is_null($this->active);
    }
    public function UserReActive()
    {
        return $this->hasMany(ReactiveAccountRequest::class, 'user_id')
            ->where('reactive_account_requests.user_type', 'trainee');
    }
    public function ojtMatchesWhereIdOJT($ojt_id)
    {
        return $this->hasMany(OjtTraineeApply::class, 'trainee_id', 'id')->where('ojt_id',$ojt_id);
    }
    public function traineeInstitutes() {
        return $this->hasMany(TraineeInstitute::class, 'trainee_id');
    }

}
