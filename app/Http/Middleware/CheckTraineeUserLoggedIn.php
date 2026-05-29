<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTraineeUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('trainee')->check()) {
//            return redirect()->route('trainee.auth.login');
            return redirect()->route('trainee.cas.get-login');
        } else {
            $user = Auth::guard('trainee')->user();
            if (!$user->email_verified_at) {
                return redirect()->route('verification.isnotverified', ['u_type' => 'trainee', 'token' => base64_encode($user->email)]);
            }
            if ($user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'trainee';
                Auth::guard('trainee')->logout();
                return response()->view('auth-verification.reactive-account-form', compact('token', 'u_type'));
//                return redirect()->route('trainee.auth.login')->withErrors(['account_deactivated' => "Your account is not active in our system! Please contact admin or create a new one!"]);
            }
        }
        return $next($request);
    }
}
