<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Mail\SendResetPasswordLinkForTrainee;
use App\Models\TraineeUser;
use App\Services\Trainee\TraineeCasSyncService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Http\Requests\Trainee\Auth\MailConfirmRequest;
use App\Http\Requests\Trainee\Auth\ResetPasswordRequest;

class ForgotPasswordController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        return view('trainee.auth.forgot-password.enter-mail');
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

        Mail::to($email)->send(new SendResetPasswordLinkForTrainee($token));

        return redirect()->route('trainee.cas.get-login')->with('message', 'We have emailed your password reset link!');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token)
    {
        return view('trainee.auth.forgot-password.change-password', ['token' => $token]);
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

        $user = TraineeUser::where('email', $request->email)->first();

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
            $user->password = $request->password;
            $casSyncService = new TraineeCasSyncService();
            $casSyncService->changePassword($user);
        }
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('trainee.cas.get-login')->with('message', 'Your password has been changed!');
    }
}
