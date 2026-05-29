<?php

namespace App\Services\Company;

use App\Services\Company\Notification\EmailContentService;
use App\Services\Company\Notification\SMSContentService;
use App\Services\Company\Notification\NotificationContentService;
use App\Services\ESMSService;
use App\Services\NotificationService;
use App\Notifications\CGO\SendNotificationClass;
use App\Services\EmailService;
use Illuminate\Support\Facades\Mail;

class NotificationManager
{
    protected $emailService;
//    protected $smsService;
    protected $notificationService;
    protected $emailContentService;
    protected $smsContentService;
    protected $notificationContentService;

    public function __construct(
        EmailService $emailService,
//        ESMSService $smsService,
        NotificationService $notificationService,
        EmailContentService $emailContentService,
        SMSContentService $smsContentService,
        NotificationContentService $notificationContentService
    ) {
        $this->emailService = $emailService;
//        $this->smsService = $smsService;
        $this->notificationService = $notificationService;
        $this->emailContentService = $emailContentService;
        $this->smsContentService = $smsContentService;
        $this->notificationContentService = $notificationContentService;
    }

    public function sendToggleApplyNotification($user,$data){
        $notificationContent = $this->notificationContentService->getToggleApplyContent($user,$data);
        $this->notificationService->sendNotification($data->companyRecruiter, new SendNotificationClass($notificationContent, $data->companyRecruiter->id),$notificationContent);
    }
    public function sendNotificationApplyOJT($user, $ojt,$trainee_name){
        $notificationContent= $this->notificationContentService->getNotifcationApplyOJTContent($user, $ojt,$trainee_name);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }
}
