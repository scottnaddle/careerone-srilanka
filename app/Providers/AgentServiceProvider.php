<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Agent::class, function () {
            return new Agent();
        });
    }

    public function boot(): void
    {
        View::share('agent', app(Agent::class));
    }
}
