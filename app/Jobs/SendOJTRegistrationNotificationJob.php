<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class SendOJTRegistrationNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $notificationManager;
    protected $id_content;
    /**
     * Create a new job instance.
     */
    public function __construct($id_content)
    {
        $this->id_content = $id_content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
                $notificationManager = app()->make('App\Services\Cgo\NotificationManager');
                $notificationManager->SendNotificationOJTRegistrationToCGO(
                    route('cgo.job-support.ojt-list.ojt_detail', $this->id_content)
                );
    }
}
