<?php

namespace App\Services\Trainee;

use App\Services\Trainee\Notification\EmailContentService;
use App\Services\Trainee\Notification\SMSContentService;
use App\Services\Trainee\Notification\NotificationContentService;
use App\Services\ESMSService;
use App\Services\NotificationService;
use App\Services\EmailService;
use App\Notifications\CGO\SendNotificationClass;
use App\Mail\CommonMailable;
use App\Models\CgoUser;

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


    public function sendMembershipApprovalNotification($user, $data)
    {

        $notificationContent = $this->notificationContentService->getApprovalNotificationContent($data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);


        $emailContent = $this->emailContentService->getApprovalEmailContent($data);
        // $this->emailService->sendEmail($user, $emailContent);
        // Tạo instance của mailable với thông tin từ emailContent
        // $mailable = new \App\Mail\BaseMailable(
        //     $emailContent['subject'],
        //     $emailContent['view'],
        //     $emailContent['data']
        // );

        // // Gửi email
        // $this->emailService->sendEmail($user, $mailable);
    }
    public function sendMembershipBlockEmail($user)
    {
        $emailContent = $this->emailContentService->getBlockEmailContent($user);
        $this->emailService->sendEmail($user, $emailContent);

    }
    //allocating counseling
    public function sendAllocatingAounselingNotification($user, $data){

        $notificationContent = $this->notificationContentService->sendAllocatingAounselingContent($data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }

    // public function sendFollowUpNotification($user, $data)
    // {

    //     $notificationContent = $this->notificationContentService->getFollowUpNotificationContent($data);
    //     $this->notificationService->sendNotification($user, new YourNotificationClass($notificationContent));


    //     $emailContent = $this->emailContentService->getFollowUpEmailContent($data);
    //     $this->emailService->sendEmail($user, $emailContent);
    // }

    // public function sendSMSNotification($user, $data)
    // {
    //     $smsContent = $this->smsContentService->getApprovalSMSContent($data);
    //     $this->smsService->sendMessages($user->phone, $smsContent);
    // }


    //match job of Cgo
    public function matchJobNotificationOfCgo($user, $data){
        $notificationContent = $this->notificationContentService->getMatchJobNotificationOfCgoContent($user, $data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
        //send to company
        $notificationContentCompany= $this->notificationContentService->getMatchJobNotificationOfCgoContentSendCompany($user,$data);
        $this->notificationService->sendNotification($data->companyRecruiter, new SendNotificationClass($notificationContentCompany, $data->companyRecruiter->id),$notificationContentCompany);
    }
    public function matchJobNotificationOfCgoSendCompany($user, $data){

    }
    //allocating counseling
    public function sendNotificationCgoConfirmCounselingToTrainee($user, $data){

        $notificationContent = $this->notificationContentService->getNotificationCgoConfirmCounselingToTraineeContent($user, $data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }
    public function sendSelectedTraineeApplyNotification($data){
        $notificationContent = $this->notificationContentService->getSelectedTraineeApplyContent($data);
        $this->notificationService->sendNotification($data->user, new SendNotificationClass($notificationContent, $data->user->id),$notificationContent);
    }
    public function sendEmployeedTraineeApplyNotification($data){
        $notificationContent = $this->notificationContentService->getemployeedTraineeApplyContent($data);
        $this->notificationService->sendNotification($data->user, new SendNotificationClass($notificationContent, $data->user->id),$notificationContent);
    }
    public function SendNotificationJobRegistrationToCGO($data_slug = '')
    {
        $cgoUsers = CgoUser::all();
        $notificationContent = $this->notificationContentService->getNewJobRegistrtionToCGO($data_slug);

        foreach ($cgoUsers as $cgo) {
            $user_id = $cgo->id;
            $this->notificationService->sendNotification(
                $cgo,
                new SendNotificationClass($notificationContent, $user_id),
                $notificationContent
            );
        }
    }

}
