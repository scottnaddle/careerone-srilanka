<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as NotificationFirebase;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userData;
    protected $notificationClass;
    protected $contentData;
    protected $messaging;

    /**
     * Create a new instance of the job.
     */
    public function __construct($userData, $notificationClass, $contentData, $messaging)
    {
        $this->userData = $userData;
        $this->notificationClass = $notificationClass;
        $this->contentData = $contentData;
        $this->messaging = $messaging;
    }

    public function handle()
    {
        if (!$this->userData) {
            Log::channel('queue')->error('userData is null in SendNotificationJob');
            return;
        }
        try {
            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $sent_message = "send-message-{$this->userData->nic}";
            $pusher->trigger('NotificationEvent', $sent_message, $this->contentData);
            Log::channel('queue')->info('Pusher notification sent successfully');
        } catch (\Exception $e) {
            Log::channel('queue')->error('Pusher notification failed: ' . $e->getMessage());
        }
        try {
            if (!empty($this->userData->deviceTokens[0]->device_token)) {
                $firebase = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
                $this->messaging = $firebase->createMessaging();

                $notification_firebase = NotificationFirebase::create(env('APP_NAME'), $this->contentData['message']);
                $dataPayload = array_merge(
                    ['message' => $this->contentData['message']],
                    $this->contentData['params']
                );
                $message = CloudMessage::withTarget('token', $this->userData->deviceTokens[0]->device_token)
                    ->withNotification($notification_firebase)
                    ->withData($dataPayload);
                $this->messaging->send($message);

                Log::channel('queue')->info('Firebase notification sent successfully');
            }
        } catch (\Exception $e) {
            Log::channel('queue')->error('Firebase notification failed: ' . $e->getMessage());
        }
        try {
            Notification::send($this->userData, $this->notificationClass);
            Log::channel('queue')->info('Database notification sent successfully');
        } catch (\Exception $e) {
            Log::channel('queue')->error('Database notification failed: ' . $e->getMessage());
        }
    }
}
