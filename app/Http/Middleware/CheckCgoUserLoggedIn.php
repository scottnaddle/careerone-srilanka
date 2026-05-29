<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCgoUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('cgo')->check()) {
            return redirect()->route('cgo.auth.login');
        } else {
            $user = Auth::guard('cgo')->user();
            if (!$user->email_verified_at) {
                return redirect()->route('verification.isnotverified', ['u_type' => 'cgo', 'token' => base64_encode($user->email)]);
            }
            if ($user->active == false) {
                $token = base64_encode($user->id);
                $u_type = 'cgo';
                Auth::guard('cgo')->logout();
                return response()->view('auth-verification.reactive-account-form', compact('token', 'u_type'));
            }
        }
        return $next($request);
    }
}
