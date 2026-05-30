<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountMustVerifyByAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for AJAX/API requests and login-related routes
        if ($request->ajax() || $request->expectsJson() || $request->is('admin/auth/*')) {
            return $next($request);
        }

        $guard = null;
        if (Auth::guard('admin')->check()) $guard = 'admin';
        if (Auth::guard('cgo')->check()) $guard = 'cgo';

        if ($guard && Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            if (is_null($user->email_verified_at)) {
                $token = base64_encode($user->email);
                return redirect('/verification/isnotverified/' . $guard . '/' . $token);
            }

            if (is_null($user->verify_at)) {
                return response()->view('admin.auth.account_must_verify');
            }
        }

        return $next($request);
    }
}
