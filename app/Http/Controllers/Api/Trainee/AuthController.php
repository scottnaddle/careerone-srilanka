<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Constant\Constant;
use App\Http\Controllers\Api\Trainee\BaseController as BaseController;
use App\Mail\SendResetPasswordLinkForTrainee;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\District;
use App\Models\Institute;
use App\Models\NVQLevel;
use App\Models\Occupation;
use App\Models\SchoolKid;
use App\Models\TraineeUser;
use App\Models\VerificationCode;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\DeviceToken;
use App\Models\ReqCourse;
use App\Models\Sector;
use App\Models\TraineeInstitute;
use App\Models\TraineeNVQ;
use App\Models\TraineeRegCourse;
use App\Models\TraineeSector;
use App\Models\TraineeTrainingHistory;
use App\Services\Trainee\TraineeCasSyncService;
use App\Services\Trainee\TraineeInformationService;

class AuthController extends BaseController
{
    public $traineeCasSyncService;
    public $traineeInfomationService;
    public $traineeSyncService;

    public function __construct(TraineeTrainingSyncService $traineeSyncService)
    {
        $this->traineeCasSyncService = new TraineeCasSyncService();
        $this->traineeInfomationService = new TraineeInformationService();
        $this->traineeSyncService = $traineeSyncService;
    }

    public function getRegister(): JsonResponse
    {
        $institutes = Institute::get();
        $districts = District::get();
        $recommendedCgo = CgoUser::where('active', true)->get()->each(function ($cgo) {
            $cgo->system = 'cgo';
        });

        $recommendedAdmin = AdminUser::where('active', true)->get()->each(function ($admin) {
            $admin->system = 'admin';
        });

        $recommendedList = $recommendedCgo->merge($recommendedAdmin);
        $data = [
            'institutes' => $institutes,
            'districts' => $districts,
            'recommendedList' => $recommendedList
        ];
        return $this->sendResponse($data, '');
    }
    // Register
    public function register(Request $request): JsonResponse
    {
        if ($request->user_type == 'schoolkid') {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'repassword' => 'required|same:password',
                'first_name' => 'min:0|max:20',
                'last_name' => 'min:0|max:20',
                'email' => 'required|unique:school_kids,email|min:2|max:100',
                'mobile' => 'required|unique:school_kids,mobile',
                'verification_type' => 'required',
                'agree_terms' => 'accepted',
                'user_type' => 'required'
            ], [
                'repassword.same' => 'Password does not match.'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $verificationMethod = $request->verification_type;
            $data = $request->except(['_token', 'verification_type', 'accept_terms']);
            $password = bcrypt($request->password);

            $userData = $this->buildManualSchoolKidData($data, $password);

            $user = SchoolKid::create($userData);

            // Send verification
            $token = base64_encode($request->email);
            $this->sendVerification($user, $token, $verificationMethod);
            return $this->sendResponse('Register successfully', ['message' => 'User registered successfully. Please check your email for verification link.']);
        }else {
            $validator = Validator::make($request->all(), [
                'nic' => ['required', 'string', 'regex:/^(?:\d{9}[VXvx]|\d{12})$/', 'unique:trainee_users,nic'],
                'password' => 'required',
                'repassword' => 'required|same:password',
                'first_name' => 'min:0|max:20',
                'last_name' => 'min:0|max:20',
                //            'full_name' => 'min:0|max:100',
                'email' => 'required|unique:trainee_users,email|min:2|max:100',
                //            'telephone' => 'required',
                'mobile' => 'required|unique:trainee_users,mobile',
                'verification_type' => 'required',
                'agree_terms' => 'accepted',
                'user_type' => 'required'
            ], [
                'repassword.same' => 'Password does not match.'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $isManual = $request->has('manual') && $request->manual == 1;

            $traineeInformations = $this->traineeInfomationService->getTraineeInformation($request->nic)['message'][0];
            $password = bcrypt($request->password);
            $verification_method = $request->verification_type;
            $data = $request->except(['_token', 'verification_type', 'accept_terms']);
            if ($isManual) {
                $data['full_name'] = $data['first_name'] . ' ' . $data['last_name'];
                $userData = $this->buildManualUserData($data, $password);
            } else {
                $traineeInfo = $this->traineeInfomationService->getTraineeInformation($request->nic)['message'];
                if ($traineeInfo != 'No Information.') {
                    $traineeInfo = $traineeInfo[0];
                    $userData = $this->buildAutoUserData($data, $password, $traineeInfo);
                }else {
                    return $this->sendError('Not found trainee information in NVQ System.', $request->nic);
                }
            }
            $user = TraineeUser::create($userData);

            // Sync with external systems
            $data['disabled'] = 0;
            $this->traineeCasSyncService->signUp($data);

            if (!$isManual) {
                $this->traineeSyncService->syncTraineeTrainingInformation($user);
            }
            if ($request->has('attached_file')) {
                $attached_file = $request->file('attached_file');
                $storage_path = storage_path('app/public/' . activeGuard() . '/' . 'attached_file/' . $user->id);
                $filename = pathinfo($attached_file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $attached_file->getClientOriginalExtension();
                $fileNameToStore = $filename . '.' . $extension;
                $attached_file->move($storage_path, $fileNameToStore);
                $path = 'storage/' . activeGuard() . '/' . 'attached_file/' . $user->id . '/' . $fileNameToStore;
                $user->update([
                    'attached_file' => $path
                ]);
            }

            $token = base64_encode($request->email);
            switch ($verification_method) {
                case Constant::email:
                    $user->sendEmailVerify($token);
                    break;
                case Constant::sms:
                    $user->sendSMSVerify($token);
                    break;
            }
            return $this->sendResponse('Register successfully', ['message' => 'User registered successfully. Please check your email for verification link.']);
        }

    }

    private function buildManualUserData($data, $password)
    {
        $recommendedBy = $data['recommended_by'] ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }
        return [
            'nic' => $data['nic'],
            'username' => $data['email'],
            'email' => $data['email'],
            'password' => $password,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'full_name' => $data['first_name'] . ' ' . $data['last_name'],
            'contact_address' => $data['contact_address'],
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'open_to_work' => 1,
            'public_portfolio' => 1,
            'recommended_by_user_id' => $userId,
            'recommended_by_user_system' => $system,
        ];
    }

    private function buildAutoUserData($data, $password, $info)
    {
        $recommendedBy = $data['recommended_by'] ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }
        return [
            'nic' => $data['nic'],
            'username' => $data['email'],
            'email' => $data['email'],
            'password' => $password,
            'first_name' => $info['STD_FIRST_NAME'],
            'last_name' => $info['STD_SURNAME'],
            'full_name' => $data['full_name'],
            'permanant_address' => $info['STD_PERMANANT_ADDRESS'],
            'contact_address' => $info['STD_CONTACT_ADDRESS'],
            'gender' => getCodeIdByStringEn('gender', $info['STD_GENDER']),
            'mobile' => $data['mobile'],
            'std_surname' => $info['STD_SURNAME'],
            'std_initials' => $info['STD_INITIALS'],
            'open_to_work' => 1,
            'public_portfolio' => 1,
            'recommended_by_user_id' => $userId,
            'recommended_by_user_system' => $system,
        ];
    }

    // Login
    public function login(Request $request): JsonResponse
    {
        if ($request->user_type == 'schoolkid') {
            $validator = Validator::make($request->all(), [
                'email' => ['required'],
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $user = SchoolKid::where('email', $request->email)->first();

            if ($user) {
                if (!$user->hasVerifiedEmail()) {
                    $data['email'] = $user->email;
                    $data['verifiedEmail'] = false;
                    return $this->sendError('Unverified.', ['message' => 'User has not verified.', 'data' => $data]);
                }
                if (\Hash::check($request->password, $user->password)) {

                    if ($user->active == false) {
                        return $this->sendError('Account deactived.', ['error' => 'Your account is not active in our system! Please contact admin or create a new one!'],);
                    }

                    $tokenResult = $user->createToken('MyApp');
                    $token = $tokenResult->accessToken;
                    $token->expires_at = now()->addDays(30);
                    $token->save();
                    // Save the device token if provided
                    if ($request->filled('device_token')) {
                        $existingToken = DeviceToken::where('user_id', $user->id)
                            ->where('system', 'schoolkid')
                            ->first();

                        if ($existingToken) {

                            $existingToken->update(['device_token' => $request->device_token]);
                        } else {
                            DeviceToken::create([
                                'user_id' => $user->id,
                                'system' => 'schoolkid',
                                'device_token' => $request->device_token
                            ]);
                        }
                    }
                    $success['token'] =  $tokenResult->plainTextToken;
                    $success['fullName'] =  $user->fullName;
                    $success['nic'] =  $user->nic;
                    $success['email'] =  $user->email;
                    $success['user_type'] = 'schoolkid';
                    $success['expires_at'] =  Carbon::parse($token->expires_at)->toDateTimeString();
                    return $this->sendResponse($success, 'User login successfully.');
                } else {
                    return $this->sendError('Unauthorised.', ['error' => 'The username or password is incorrect!']);
                }
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'User does not exist']);
            }
        }else {
            $validator = Validator::make($request->all(), [
                'nic' => ['required'],
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $user = TraineeUser::where('nic', $request->nic)->first();

            if ($user) {
                if (!$user->hasVerifiedEmail()) {
                    $data['email'] = $user->email;
                    $data['verifiedEmail'] = false;
                    return $this->sendError('Unverified.', ['message' => 'User has not verified.', 'data' => $data]);
                }
                if (\Hash::check($request->password, $user->password)) {

                    if ($user->active == false) {
                        return $this->sendError('Account deactived.', ['error' => 'Your account is not active in our system! Please contact admin or create a new one!'],);
                    }

                    $tokenResult = $user->createToken('MyApp');
                    $token = $tokenResult->accessToken;
                    $token->expires_at = now()->addDays(30);
                    $token->save();
                    // Save the device token if provided
                    if ($request->filled('device_token')) {
                        $existingToken = DeviceToken::where('user_id', $user->id)
                            ->where('system', 'trainee')
                            ->first();

                        if ($existingToken) {

                            $existingToken->update(['device_token' => $request->device_token]);
                        } else {
                            DeviceToken::create([
                                'user_id' => $user->id,
                                'system' => 'trainee',
                                'device_token' => $request->device_token
                            ]);
                        }
                    }
                    $success['token'] =  $tokenResult->plainTextToken;
                    $success['fullName'] =  $user->fullName;
                    $success['nic'] =  $user->nic;
                    $success['email'] =  $user->email;
                    $success['expires_at'] =  Carbon::parse($token->expires_at)->toDateTimeString();
                    return $this->sendResponse($success, 'User login successfully.');
                } else {
                    return $this->sendError('Unauthorised.', ['error' => 'The username or password is incorrect!']);
                }
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'User does not exist']);
            }
        }

    }

    // Forgot password
    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email'], ['email.email' => 'This email is invalid!', 'user_type' => 'required']);
        $email = $request->email;
        if ($request->user_type == 'schoolkid') {
            $exist = SchoolKid::where('email', $email)->first();
        }else {
            $exist = TraineeUser::where('email', $email)->first();
        }

        if (!$exist) {
            return $this->sendError('Error.', ['error' => 'This email is not existed.']);
        }

        $key = 'reset-password-' . $email;

        // Check the rate limit
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return $this->sendError('Error.', ['error' => 'Too many requests. Please try again later.']);
        }

        // Allow one request twice minutes
        RateLimiter::hit($key, 120);

        $token = Str::random(60);

        $passwordReset = DB::table('password_resets')->where('email', $email)->first();

        if ($passwordReset) {
            DB::table('password_resets')->where('email', $email)->update([
                'token' => $token,
                'expired_at' => now()->addMinutes(5),
                'created_at' => Carbon::now()
            ]);
        } else {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'expired_at' => now()->addMinutes(5),
                'created_at' => Carbon::now()
            ]);
        }

        Mail::to($email)->send(new SendResetPasswordLinkForTrainee($token));
        return $this->sendResponse('Success.', ['message', 'We have emailed your password reset link!']);
    }

    // Verify email
    public function verifyEmail(Request $request): JsonResponse
    {
        if ($request->user_type && $request->user_type == 'schoolkid') {
            $user = SchoolKid::where('email', $request->email)->first();
            $verification_code = VerificationCode::where(['email' => $user->email, 'u_type' => Constant::schoolkid])->firstOrFail();
        }else {
            $user = TraineeUser::where('email', $request->email)->first();
            $verification_code = VerificationCode::where(['email' => $user->email, 'u_type' => Constant::trainee])->firstOrFail();
        }

        if (!$user) {
            return $this->sendError('Error.', ['message' => 'User not found']);
        }
        if ($user->hasVerifiedEmail()) {
            return $this->sendError('Error.', ['message' => 'Email already verified.']);
        }

        if ($verification_code && $user) {
            if (now()->addMinute(5) < $verification_code->expired_at) {
                return $this->sendError('Error.', ['message' => 'Your code has expired!']);
            } else {
                if ($request->code == $verification_code->code) {
                    $user->markEmailAsVerified();
                    if ($request->user_type != 'schoolkid') {
                        $user->disabled = 0;
                        $this->traineeCasSyncService->updateUser($user);
                    }
                    return $this->sendResponse('Success.', ['message', 'Your account activated successfully!']);
                } else {
                    return $this->sendError('Error.', ['message' => 'Your entered code is wrong!']);
                }
            }
        } else {
            return $this->sendError('Error.', ['message' => 'Unable to verify email!']);
        }
    }

    // Resend verification
    public function resendVerification(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email', 'verification_method' => 'required', 'user_type' => 'required']);
        if ($request->user_type == 'schoolkid') {
            $user = SchoolKid::where('email', $request->email)->first();
        }else {
            $user = TraineeUser::where('email', $request->email)->first();
        }
        if (!$user) {
            return $this->sendError('Error.', ['message' => 'User not found']);
        }
        if ($user->hasVerifiedEmail()) {
            return $this->sendError('Error.', ['message' => 'Email already verified.']);
        }
        $method = $request->verification_method;
        $token = base64_encode($user->email);
        switch ($method) {
            case Constant::email:
                $user->sendEmailVerify($token);
                break;
            case Constant::sms:
                $user->sendSMSVerify($token);
                break;
        }

        return $this->sendResponse('Success', ['message' => 'Verification link sent.']);
    }

    public function logout(Request $request)
    {
        //        $request->user()->token()->revoke();
        DeviceToken::where('user_id', Auth::guard('sanctum')->user()->id)
            ->where('system', 'trainee')
            ->delete();
        Auth::guard('sanctum')->user()->tokens()->delete();
        return $this->sendResponse('Success', ['message' => 'Successfully logged out.']);
    }


    // public function getTraineeUserCVs() {
    //     $traineeUserCVs =
    // }

    public function syncTraineeTrainingInformation($user)
    {
        try {
            // Fetch trainee training information
            $traineeTrainingInformations = $this->traineeInfomationService->getTrainingHistoryInformation($user->nic);

            if ($traineeTrainingInformations['message'] != 'No Information.') {
                // Save trainee training history
                $traineeTrainingHistory = new TraineeTrainingHistory();
                $traineeTrainingHistory->trainee_id = $user->id;
                $traineeTrainingHistory->content = json_encode($traineeTrainingInformations['message']);
                $traineeTrainingHistory->save();

                // Save NVQ information
                \Log::info("---------Syncing user information with NIC: " . $user->nic . '--------------');
                foreach ($traineeTrainingInformations['message'] as $item) {
                    // Ensure NVQ record is found before saving
                    $nvq = NVQLevel::where(DB::raw('LOWER(code)'), strtolower($item['NVQ_QUALIFICATION']['QUALIFICATION_CODE']))->first();
                    if ($nvq) {
                        \Log::info("NVQ: " . $item['NVQ_QUALIFICATION']['QUALIFICATION_NAME']);
                        \Log::info("- Effectivedate: " . $item['NVQ_QUALIFICATION']['EFFECTIVE_DATE']);
                        \Log::info("- Found in DB: " . json_encode($nvq));
                        $traineeNvq = new TraineeNVQ();
                        $traineeNvq->trainee_id = $user->id;
                        $traineeNvq->nvq_id = $nvq->id;
                        $traineeNvq->effective_date = $item['NVQ_QUALIFICATION']['EFFECTIVE_DATE'];
                        $traineeNvq->save();
                    }

                    // Ensure Institute record is found before saving
                    $institute = Institute::where(DB::raw('LOWER(reg_no)'), strtolower($item['INSTITUTE']['INSTITUTE_REG_NO']))->first();
                    if ($institute) {
                        \Log::info("Institute: " . $item['INSTITUTE']['INSTITUTE_NAME']);
                        \Log::info("- Start date: " . $item['COURSE']['START_DATE']);
                        \Log::info("- End date: " . $item['COURSE']['END_DATE']);
                        \Log::info("- Found in DB: " . json_encode($institute));
                        $traineeInstitute = new TraineeInstitute();
                        $traineeInstitute->trainee_id = $user->id;
                        $traineeInstitute->institute_id = $institute->id;
                        $traineeInstitute->start_date = $item['COURSE']['START_DATE'];
                        $traineeInstitute->end_date = $item['COURSE']['END_DATE'];
                        $traineeInstitute->save();
                    }

                    $sector = Sector::where(DB::raw('LOWER(name)'), strtolower($item['COURSE']['INDUSTRY_SECTOR']))->first();
                    if ($sector) {
                        \Log::info("Sector: " . $item['COURSE']['INDUSTRY_SECTOR']);
                        \Log::info("- Start date: " . $item['COURSE']['START_DATE']);
                        \Log::info("- End date: " . $item['COURSE']['END_DATE']);
                        \Log::info("- Found in DB: " . json_encode($sector));
                        $traineeSector = new TraineeSector();
                        $traineeSector->trainee_id = $user->id;
                        $traineeSector->sector_id = $sector->id;
                        $traineeSector->start_date = $item['COURSE']['START_DATE'];
                        $traineeSector->end_date = $item['COURSE']['END_DATE'];
                        $traineeSector->save();
                    }

                    $course = ReqCourse::where(DB::raw('LOWER(institute_reg_no)'), strtolower($item['INSTITUTE']['INSTITUTE_REG_NO']))
                        ->where(DB::raw('LOWER(course_name)'), strtolower($item['COURSE']['COURSE_NAME']))
                        ->first();
                    if ($course) {
                        \Log::info("Course: " . $item['COURSE']['COURSE_NAME']);
                        \Log::info("- Start date: " . $item['COURSE']['START_DATE']);
                        \Log::info("- End date: " . $item['COURSE']['END_DATE']);
                        \Log::info("- Found in DB: " . json_encode($course));
                        $traineeRegCourse = new TraineeRegCourse();
                        $traineeRegCourse->trainee_id = $user->id;
                        $traineeRegCourse->reg_course_id = $course->id;
                        $traineeRegCourse->start_date = $item['COURSE']['START_DATE'];
                        $traineeRegCourse->end_date = $item['COURSE']['END_DATE'];
                        $traineeRegCourse->save();
                    }
                }
            }
        } catch (\Exception $e) {
            // Handle the exception by logging the error or returning a custom message
            \Log::error('Error syncing trainee training information: ' . $e->getMessage());

            // Optionally, you can rethrow the exception or handle it gracefully
            // return response()->json(['error' => 'An error occurred while syncing trainee information.']);
        }
    }

    private function buildManualSchoolKidData($data, $password)
    {
        $recommendedBy = $data['recommended_by'] ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }
        return [
            'username' => $data['email'],
            'email' => $data['email'],
            'password' => $password,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'contact_address' => $data['contact_address'],
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'district_id' => $data['district_id'],
            'recommended_by_user_id' => $userId,
            'recommended_by_user_system' => $system,
        ];
    }

    private function sendVerification($user, $token, $method)
    {
        match ($method) {
            Constant::email => $user->sendEmailVerify($token),
            Constant::sms => $user->sendSMSVerify($token),
            default => null
        };
    }
}
