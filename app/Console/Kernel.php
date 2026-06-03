<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        // Đăng ký command của bạn
        \App\Console\Commands\SyncApiData::class,
        \App\Console\Commands\ChangeStatusJob::class,
        \App\Console\Commands\SendMonthlyReport::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('sync:apidata')->dailyAt('01:00');
//        $schedule->command('app:change-status-job')->dailyAt('01:00');
        $schedule->command('app:sync-trainee-data-from-tvec')->dailyAt('01:00');

        $schedule->command('cgo:send-inactive-reminder --days=30')
            ->dailyAt('09:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/cgo-reminder.log'));
        $schedule->command('report:monthly')
            ->monthlyOn(1, '00:00') // Run at midnight on the 1st day of each month
            ->timezone('Asia/Colombo') // Sri Lanka timezone
            ->emailOutputOnFailure('admin@yourdomain.com');
//        $schedule->command('app:sync-trainee-data-from-tvec')->weeklyOn(0, '01:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
