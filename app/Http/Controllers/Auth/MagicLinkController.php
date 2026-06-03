<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MagicLinkController extends Controller
{
    protected $guardMap = [
        'trainee' => ['model' => \App\Models\TraineeUser::class, 'guard' => 'trainee', 'login_route' => 'trainee.auth.login'],
        'company' => ['model' => \App\Models\CompanyRecruiter::class, 'guard' => 'company', 'login_route' => 'company.auth.login'],
        'cgo' => ['model' => \App\Models\CgoUser::class, 'guard' => 'cgo', 'login_route' => 'cgo.auth.login'],
    ];

    /**
     * Show the magic link request form.
     */
    public function showForm()
    {
        return view('auth.magic-link');
    }

    /**
     * Send magic link email.
     */
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'user_type' => 'required|in:trainee,company,cgo',
        ]);

        $config = $this->guardMap[$request->user_type];
        $user = $config['model']::where('email', $request->email)->first();

        // Always respond the same way to prevent email enumeration
        if (!$user) {
            return back()->with('message', __('auth.magic_link_sent'));
        }

        // Generate token
        $token = Str::random(64);
        $user->magic_link_token = hash('sha256', $token);
        $user->magic_link_expires_at = now()->addMinutes(10);
        $user->save();

        // Send email
        $user->sendMagicLink($token, $request->user_type);

        return back()->with('message', __('auth.magic_link_sent'));
    }

    /**
     * Verify magic link and log in.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'user_type' => 'required|in:trainee,company,cgo',
            'email' => 'required|email',
        ]);

        $config = $this->guardMap[$request->user_type];
        $user = $config['model']::where('email', $request->email)
            ->where('magic_link_token', hash('sha256', $request->token))
            ->where('magic_link_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('magic-link.form')
                ->with('error', __('auth.magic_link_invalid'));
        }

        // Clear token
        $user->magic_link_token = null;
        $user->magic_link_expires_at = null;
        $user->save();

        // Login
        Auth::guard($config['guard'])->login($user, true);

        return redirect()->intended($this->getDashboardRoute($request->user_type));
    }

    private function getDashboardRoute(string $type): string
    {
        return match ($type) {
            'trainee' => route('trainee.my-page.my-page'),
            'company' => route('company.my-page.my-page'),
            'cgo' => route('cgo.my-page.my-page'),
        };
    }
}
