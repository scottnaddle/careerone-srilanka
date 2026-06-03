<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendJobRegistrationNotificationSendCGOJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $notificationManager;
    protected $slug;
    /**
     * Create a new job instance.
     */
    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
                $notificationManager = app()->make('App\Services\Trainee\NotificationManager');
                $notificationManager->SendNotificationJobRegistrationToCGO(
                    route('cgo.job-support.job-list.job-details', $this->slug)
                );
    }
}
