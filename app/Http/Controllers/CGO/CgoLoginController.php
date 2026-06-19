<?php

namespace App\Http\Controllers\CGO;

use App\Http\Controllers\Controller;
use App\Http\Requests\CGO\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\DeviceToken;

class CgoLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        $backUrl = url()->previous();
        $excludeKeywords = ['auth', 'choose-login', 'admin', 'company', 'trainee', 'reset-password', 'forget-password', 'register', 'signin', 'signup', 'token-expired', 'login'];

        // Check if any exclude keyword is in the URL
        $shouldSaveBackUrl = !collect($excludeKeywords)->contains(fn($keyword) => str_contains($backUrl, $keyword));

        if ($shouldSaveBackUrl) {
            session(['backUrl' => $backUrl]);
        }

        // Redirect if authenticated
        if (Auth::guard('cgo')->check()) {
            return redirect()->route('homepage');
        }

        return view('cgo.auth.signin');
    }

    public function postLogin(LoginRequest $request)
    {


              $data = $request->except('_token');
        if (Auth::guard('cgo')->attempt($data)) {
            $user = Auth::guard('cgo')->user();
            $user->update(['last_login_at' => now()]);
            if ($user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'cgo';
                Auth::guard('cgo')->logout();
                return view('auth-verification.reactive-account-form', compact('token', 'u_type'));
            }
            if (!Auth::guard('cgo')->user()->email_verified_at) {
                $token = base64_encode(Auth::guard('cgo')->user()->email);
                Auth::guard('cgo')->logout();
                return redirect('/verfication/isnotverified/cgo' . '/' . $token);
            }
            if (!Auth::guard('cgo')->user()->verify_at) {
                Auth::guard('cgo')->logout();
                return redirect()->route('cgo.auth.login')->with('error', 'Your account is not verified by administrator!');
            }
            $backUrl = session()->get('backUrl');
             if($request->session()->has('fcm_token')){
                DeviceToken::updateOrCreate(
                    [
                        'user_id' => Auth::guard('cgo')->user()->id,
                        'system'       =>'cgo'
                    ],
                    ['device_token' =>  session('fcm_token')]
                );
            }
            session()->forget('backUrl');
            return $backUrl ? redirect($backUrl) : redirect()->route('homepage');
        } else {
            return back()->with('error', 'The username or password is incorrect!');
        }
    }

    public function logout()
    {
        session()->forget('backUrl');
        if (isset(Auth::guard('cgo')->user()->id)) {
            DeviceToken::where('user_id', Auth::guard('cgo')->user()->id)
                ->where('system', 'cgo')
                ->delete();
        }
        Auth::guard('cgo')->logout();
        return redirect()->route('homepage');
    }
}
