<?php

namespace App\Providers;

use App\Contracts\Services\CounselingServiceInterface;
use App\Services\Cgo\CounselingService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All the container bindings that should be registered.
     *
     * @var array
     */
    public array $bindings = [
        CounselingServiceInterface::class => CounselingService::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
