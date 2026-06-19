<?php

namespace App\Loggers;

use Filament\Facades\Filament;
use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;

class CustomAccessLogger
{
    /**
     * Log user login with a custom guard
     * Automatically saves causer_id and causer_type into their own columns
     */
    public function handle(Login $event)
    {
        if($event->guard == 'trainee') {
            $description = $event->user->full_name.' logged in';
        } else {
            $description = Filament::getUserName($event->user).' logged in';
        }

        app(ActivityLogger::class)
            ->useLog(config('filament-logger.access.log_name'))
            ->setLogStatus(app(ActivityLogStatus::class))
            ->causedBy($event->user) // THIS IS KEY - sets causer_id and causer_type automatically
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'guard' => $event->guard
                // No need to add causer_type here
            ])
            ->event('Login')
            ->log($description);
    }
}
