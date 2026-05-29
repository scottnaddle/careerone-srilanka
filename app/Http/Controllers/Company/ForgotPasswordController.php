<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Auth\MailConfirmRequest;
use App\Http\Requests\Company\Auth\ResetPasswordRequest;
use App\Mail\SendResetPasswordLinkForCompany;
use App\Models\CompanyRecruiter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        return view('company.auth.forgot-password.enter-mail');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(MailConfirmRequest $request)
    {
        $email = $request->email;
        $key = 'reset-password-' . $email;

        // Check the rate limit
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return back()->with('error', 'Too many requests. Please try again later.');
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

        Mail::to($email)->send(new SendResetPasswordLinkForCompany($token));

        return redirect()->route('company.auth.login')->with('message', 'We have emailed your password reset link!');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token)
    {
        return view('company.auth.forgot-password.change-password', ['token' => $token]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(ResetPasswordRequest $request)
    {
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid request!');
        }

        $user = CompanyRecruiter::where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('company.auth.login')->with('message', 'Your password has been changed!');
    }
}
