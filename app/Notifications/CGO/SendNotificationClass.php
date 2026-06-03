<?php

namespace App\Notifications\CGO;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendNotificationClass extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $message;
    private $userId;
    public function __construct($message, $userId)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    public function via($notifiable)
    {
        //, 'broadcast'
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        \Log::channel('queue')->info('Payload being sent to DB notification', [
        'MESSAGE' =>  $this->message,
        'user_id' => $this->userId,
    ]);
        return [
            'message' => $this->message,
            'user_id' => $this->userId,
        ];
    }

}
