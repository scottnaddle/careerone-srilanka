<?php

namespace App\Http\Controllers\SchoolKid;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trainee\Auth\LoginRequest;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolKidLoginController extends Controller
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
        if (Auth::guard('schoolkid')->check()) {
            return redirect()->route('homepage');
        }

        return view('schoolkid.auth.signin');
    }

    public function postLogin(LoginRequest $request)
    {

        $data = $request->except('_token');
        if (Auth::guard('schoolkid')->attempt($data)) {
            $user = Auth::guard('schoolkid')->user();
            if ($user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'schoolkid';
                Auth::guard('schoolkid')->logout();
                return view('auth-verification.reactive-account-form', compact('token', 'u_type'));
            }
            if (!Auth::guard('schoolkid')->user()->email_verified_at) {
                $token = base64_encode(Auth::guard('schoolkid')->user()->email);
                Auth::guard('schoolkid')->logout();
                return redirect('/verfication/isnotverified/schoolkid' . '/' . $token);
            }
            if($request->session()->has('fcm_token')){
                DeviceToken::updateOrCreate(
                    [
                        'user_id' => Auth::guard('schoolkid')->user()->id,
                        'system'       =>'schoolkid'
                    ],
                    ['device_token' =>  session('fcm_token'),
                     'system'       =>'schoolkid'
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
        if (isset(Auth::guard('schoolkid')->user()->id)) {
            DeviceToken::where('user_id', Auth::guard('schoolkid')->user()->id)
                ->where('system', 'schoolkid')
                ->delete();
        }
        Auth::guard('schoolkid')->logout();
        session()->invalidate();
        session()->regenerateToken();
        if (\phpCAS::isAuthenticated()) {
            \phpCAS::logoutWithRedirectService(env('CAS_CLIENT_SERVICE'));
        }
        return redirect()->route('homepage');
    }
}
