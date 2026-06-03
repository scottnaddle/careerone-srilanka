<?php

namespace App\Providers;

use App\Policies\ExportPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ActivityPolicy;
use Spatie\Activitylog\Models\Activity;
use  App\Policies\PortfolioPolicy;
use App\Models\Portfolio;
use Filament\Actions\Exports\Models\Export;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Activity::class => ActivityPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
        Export::class => ExportPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
