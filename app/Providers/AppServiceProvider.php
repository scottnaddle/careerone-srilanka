<?php

namespace App\Providers;

use App\Jobs\ProcessAutoAssignCounseling;
use App\Services\Cgo\CounselingService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use App\Http\Responses\CustomLoginResponse;
use Filament\Http\Responses\Auth\LoginResponse as FilamentLoginResponse;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Gate;
use App\Models\AdminUser;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, CustomLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
            request()->server->set('HTTPS', request()->header('X-Forwarded-Proto', 'https') == 'https' ? 'on' : 'off');
        }
        $this->app->bindMethod([ProcessAutoAssignCounseling::class, 'handle'],
            fn(ProcessAutoAssignCounseling $job, Application $app) => $job->handle($app->make(CounselingService::class)));
            Gate::define('use-translation-manager', function (?AdminUser $user) {
                return $user !== null && $user->hasRole('super_admin');
            });
    }
}
