<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\DeviceToken;

class CompanyLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        $backUrl = url()->previous();
        $excludeKeywords = ['auth', 'choose-login', 'admin', 'cgo', 'trainee', 'reset-password', 'forget-password', 'register', 'signin', 'signup', 'token-expired', 'login'];

        // Check if any exclude keyword is in the URL
        $shouldSaveBackUrl = !collect($excludeKeywords)->contains(fn($keyword) => str_contains($backUrl, $keyword));

        if ($shouldSaveBackUrl) {
            session(['backUrl' => $backUrl]);
        }

        // Redirect if authenticated
        if (Auth::guard('company')->check()) {
            return redirect()->route('homepage');
        }

        return view('company.auth.signin');
    }

    public function postLogin(LoginRequest $request)
    {

        $data = $request->except('_token');
        if (Auth::guard('company')->attempt($data)) {
            $user = Auth::guard('company')->user();
            if ($user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'company';
                Auth::guard('company')->logout();
                return view('auth-verification.reactive-account-form', compact('token', 'u_type'));
            }
            if (!Auth::guard('company')->user()->email_verified_at) {
                $token = base64_encode(Auth::guard('company')->user()->email);
                Auth::guard('company')->logout();
                return redirect('/verfication/isnotverified/company' . '/' . $token);
            }
            if (!Auth::guard('company')->user()->verify_at) {
                Auth::guard('company')->logout();
                return redirect()->route('company.auth.login')->with('error', 'Your account is not verified by administrator!');
            }
          if($request->session()->has('fcm_token')){
            DeviceToken::updateOrCreate(
                [
                    'user_id' => Auth::guard('company')->user()->id,
                    'system'       =>'company'
                ],
                ['device_token' =>  session('fcm_token')]
            );
          }
            return \Session::get('backUrl') ? redirect(\Session::get('backUrl')) : redirect()->route('homepage');
        } else {
            return back()->with('error', 'The username or password is incorrect!');
        }
    }

    public function logout()
    {
        session()->forget('backUrl');
        if (isset(Auth::guard('company')->user()->id)) {
            DeviceToken::where('user_id', Auth::guard('company')->user()->id)
                ->where('system', 'cgo')
                ->delete();
        }
        Auth::guard('company')->logout();
        return redirect()->route('homepage');
    }
}
