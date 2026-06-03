<?php

namespace App\Services;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;
use App\Events\NotificationEvent;
use Kreait\Firebase\Factory;
use App\Jobs\SendNotificationJob;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as NotificationFirebase;
use Illuminate\Support\Facades\Log;
class NotificationService
{
    protected $messaging;
    public function sendNotification($user, $notification,$contentData)
    {

        try {
            SendNotificationJob::dispatch($user, $notification,$contentData, $this->messaging);
        }catch (\Exception $e){
            \Log::channel('queue')->error('Error in sending notification reply: ' . $e->getMessage());
        }
    }
}
