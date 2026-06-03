<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolKidUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('schoolkid')->check()) {
            return redirect()->route('schoolkid.auth.login');
        } else {
            $user = Auth::guard('schoolkid')->user();
            if (!$user->email_verified_at) {
                return redirect()->route('verification.isnotverified', ['u_type' => 'schoolkid', 'token' => base64_encode($user->email)]);
            }
            if ($user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'schoolkid';
                Auth::guard('schoolkid')->logout();
                return response()->view('auth-verification.reactive-account-form', compact('token', 'u_type'));
//                return redirect()->route('trainee.auth.login')->withErrors(['account_deactivated' => "Your account is not active in our system! Please contact admin or create a new one!"]);
            }
        }
        return $next($request);
    }
}
