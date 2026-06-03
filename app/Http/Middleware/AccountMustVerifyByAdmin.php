<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Filament\Support\Facades\FilamentView;

class AccountMustVerifyByAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = '';
        if (Auth::guard('admin')->check()) $guard = 'admin';
        if (Auth::guard('cgo')->check()) $guard = 'cgo';
        if (\Auth::check() && \Auth::user()->email_verified_at == "") {
            $token = base64_encode(Auth::guard($guard)->user()->email);
            return redirect('/verfication/isnotverified/'.$guard.'/'.$token);
        }
        if (\Auth::check() && \Auth::user()->verify_at == "") {
            return response()->view('admin.auth.account_must_verify');
        }
        return $next($request);
    }
}
