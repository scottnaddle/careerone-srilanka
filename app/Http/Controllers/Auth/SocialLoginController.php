<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\TraineeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    private const GUARD_MAP = [
        'trainee' => ['model' => TraineeUser::class, 'guard' => 'trainee', 'dashboard' => 'trainee.my-page.my-page'],
        'company' => ['model' => CompanyRecruiter::class, 'guard' => 'company', 'dashboard' => 'company.my-page.my-page'],
        'cgo' => ['model' => CgoUser::class, 'guard' => 'cgo', 'dashboard' => 'cgo.my-page.my-page'],
    ];

    /**
     * Redirect to Google OAuth.
     */
    public function redirect(Request $request)
    {
        $request->validate(['user_type' => 'required|in:trainee,company,cgo']);
        $request->session()->put('social_user_type', $request->user_type);
        $request->session()->put('social_redirect', $request->redirect ?? url()->previous());

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback.
     */
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/choose-login')->with('error', 'Google login failed. Please try again.');
        }

        $userType = $request->session()->get('social_user_type', 'trainee');
        $config = self::GUARD_MAP[$userType] ?? self::GUARD_MAP['trainee'];

        // Find or create user
        $user = $config['model']::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create new user from Google data
            $user = $this->createUserFromGoogle($config['model'], $googleUser);
        }

        // Login
        Auth::guard($config['guard'])->login($user, true);

        return redirect()->intended(route($config['dashboard']));
    }

    private function createUserFromGoogle(string $model, $googleUser)
    {
        $nameParts = explode(' ', $googleUser->getName() ?? $googleUser->getEmail(), 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        return $model::create([
            'email' => $googleUser->getEmail(),
            'username' => $googleUser->getEmail(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $googleUser->getName() ?? $googleUser->getEmail(),
            'password' => bcrypt(Str::random(32)),
            'active' => true,
            'email_verified_at' => now(),
            'verify_at' => now(),
            'open_to_work' => 1,
            'public_portfolio' => 1,
        ]);
    }
}
