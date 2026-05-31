<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trainee\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceToken;

class TraineeLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        $backUrl = url()->previous();
        $excludeKeywords = ['auth', 'choose-login', 'admin', 'company', 'cgo', 'reset-password', 'forget-password', 'register', 'signin', 'signup', 'token-expired', 'login'];

        // Check if any exclude keyword is in the URL
        $shouldSaveBackUrl = !collect($excludeKeywords)->contains(fn($keyword) => str_contains($backUrl, $keyword));

        if ($shouldSaveBackUrl) {
            session(['backUrl' => $backUrl]);
        }

        // Redirect if authenticated
        if (Auth::guard('trainee')->check()) {
            return redirect()->route('homepage');
        }

        return view('trainee.auth.signin');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $loginValue = $credentials['email'];
        $isEmail = filter_var($loginValue, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $attempt = Auth::guard('trainee')->attempt($credentials);
        } else {
            // NIC login
            $user = \App\Models\TraineeUser::where('nic', $loginValue)->first();
            if ($user && Auth::guard('trainee')->getProvider()->validateCredentials($user, ['password' => $credentials['password']])) {
                Auth::guard('trainee')->login($user);
                $attempt = true;
            } else {
                $attempt = false;
            }
        }

        if ($attempt) {
            $user = Auth::guard('trainee')->user();
            if ($user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'trainee';
                Auth::guard('trainee')->logout();
                return view('auth-verification.reactive-account-form', compact('token', 'u_type'));
            }
            if (!Auth::guard('trainee')->user()->email_verified_at) {
                $token = base64_encode(Auth::guard('trainee')->user()->email);
                Auth::guard('trainee')->logout();
                return redirect('/verfication/isnotverified/trainee' . '/' . $token);
            }
        if($request->session()->has('fcm_token')){
            DeviceToken::updateOrCreate(
                [
                    'user_id' => Auth::guard('trainee')->user()->id,
                    'system'       =>'trainee'
                ],
                ['device_token' =>  session('fcm_token'),
                 'system'       =>'trainee'
                ]
            );
        }
            $backUrl = session()->get('backUrl');
            session()->forget('backUrl');
            return $backUrl ? redirect($backUrl) : redirect()->route('homepage');
        } else {
            return back()->with('error', 'The username or password is incorrect!');
        }

    }

    public function logout()
    {
        session()->forget('backUrl');
        if (isset(Auth::guard('trainee')->user()->id)) {
            DeviceToken::where('user_id', Auth::guard('trainee')->user()->id)
                ->where('system', 'trainee')
                ->delete();
        }
        Auth::guard('trainee')->logout();
        session()->invalidate();
        session()->regenerateToken();
        if (\phpCAS::isAuthenticated()) {
            \phpCAS::logoutWithRedirectService(env('CAS_CLIENT_SERVICE'));
        }
        return redirect()->route('homepage');
    }
}
