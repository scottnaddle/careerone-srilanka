<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Http\Requests\RegisterVerificationCodeRequest;
use App\Models\CgoUser;
use App\Models\AdminUser;
use App\Models\CompanyRecruiter;
use App\Models\TraineeUser;
use App\Models\VerificationCode;
use App\Services\Trainee\TraineeCasSyncService;
use Illuminate\Http\Request;

class RegisterVerificationCodeController extends Controller
{
    public function __construct(TraineeCasSyncService $traineeCasSyncService) {
        $this->traineeCasSyncService = $traineeCasSyncService;
    }
    public function index($u_type, $token, $verification_method) {
        $user = null;
        switch ($u_type) {
            case Constant::cgo:
                $user = CgoUser::where(['email' => base64_decode($token)])->first();

                break;
            case Constant::admin:
                $user = AdminUser::where(['email' => base64_decode($token)])->first();

                break;
            case Constant::company:
                $user = CompanyRecruiter::where(['email' => base64_decode($token)])->first();

                break;
            case Constant::trainee:
                $user = TraineeUser::where(['email' => base64_decode($token)])->first();

                break;
            default:
                break;
        }
        if ($user) {
            if ($user->email_verified_at == null) {
                return view('auth-verification.enter-code')->with(['u_type' => $u_type, 'token' => $token, 'verification_method' => $verification_method]);
            }
        }
        return redirect('/');

    }

    public function isNotVerified($u_type, $token) {
        return view('auth-verification.isnotverified')->with(['u_type' => $u_type, 'token' => $token]);
    }

    public function postCode(RegisterVerificationCodeRequest $request) {
        $data = $request->all();
        switch ($data['u_type']) {
            case Constant::cgo:
                $user = CgoUser::where(['email' => base64_decode($request->token)])->first();

                break;
            case Constant::admin:
                $user = AdminUser::where(['email' => base64_decode($request->token)])->first();

                break;
            case Constant::company:
                $user = CompanyRecruiter::where(['email' => base64_decode($request->token)])->first();

                break;
            case Constant::trainee:
                $user = TraineeUser::where(['email' => base64_decode($request->token)])->first();

                break;
            default:
                break;
        }

        $verification_code = VerificationCode::where(['email'=> base64_decode($request->token), 'u_type' => $request->u_type])->firstOrFail();
        if ($verification_code && $user) {
            if (now()->addMinute(5) < $verification_code->expired_at) {
                return back()->with('error', 'Your code has expired!');
            } else {
                if ($request->code == $verification_code->code) {
                    $verification_code->delete();
                    $user->markEmailAsVerified();
                    if ($data['u_type'] == 'admin') {
                        return redirect()->route('filament.admin.auth.login')->with('message', 'Your account activated successfully');
                    }
                    if ($data['u_type'] == 'trainee') {
                        $user->disabled = 0;
                        $this->traineeCasSyncService->updateUser($user);
                        return redirect()->route('trainee.cas.get-login')->with('message', 'Your account activated successfully');
                    }
                    return redirect()->route($data['u_type'].'.auth.login')->with('message', 'Your account activated successfully');
                } else {
                    return back()->with('error', 'Your entered code is wrong!');
                }
            }
        }else {
            return back()->with('error', '!');
        }
    }

    public function resendCode(Request $request) {
        $u_type = $request->u_type;
        $token = $request->token;
        $verification_method = $request->verification_method;
        switch ($u_type) {
            case Constant::cgo:
                $user = CgoUser::where(['email' => base64_decode($token)])->first();
                break;
            case Constant::admin:
                $user = AdminUser::where(['email' => base64_decode($token)])->first();
                break;
            case Constant::company:
                $user = CompanyRecruiter::where(['email' => base64_decode($token)])->first();
                break;
            case Constant::trainee:
                $user = TraineeUser::where(['email' => base64_decode($token)])->first();
                break;
            default:
                break;

        }
        switch ($verification_method) {
            case Constant::email:
                $user->sendEmailVerify($token);
                break;
            case Constant::sms:
                $user->sendSMSVerify($token);
                break;
        }

        return redirect()->route('verification.verify', ['u_type' => $u_type, 'token' => $token, 'verification_method' => $verification_method])->with('message', 'sended');
    }
}
