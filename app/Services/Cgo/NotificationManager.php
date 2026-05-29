<?php

namespace App\Services\Cgo;

use App\Models\CgoUser;
use App\Services\Cgo\Notification\EmailContentService;
use App\Services\Cgo\Notification\SMSContentService;
use App\Services\Cgo\Notification\NotificationContentService;
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
    protected $messaging;

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
    public function SendNotificationReply($data,$userName='')
    {
        //notification
        $user_id=$data->author->id ?? $data->created_by;
        $notificationContent = $this->notificationContentService->getNewReplyQna($data,$userName);
        $this->notificationService->sendNotification($data->author, new SendNotificationClass($notificationContent, $user_id),$notificationContent);


        //  //mail
        //  $emailContent = $this->emailContentService->getApprovalEmailContent($user);
        //  $this->emailService->sendEmail($user, $emailContent);


    }

    public function SendNotificationReplyContent($data, $userName = '')
    {
//        $author = $data->author ?? $data->getAuthor($data->system, $data->created_by);

        $author = $data->getAuthor($data->system, $data->created_by ?? $data->answer_by);
        $userId = $author?->id ?? $data->created_by;
        $notificationContent = $this->notificationContentService->getNewReplyContent($data, $userName);
        $this->notificationService->sendNotification($author, new SendNotificationClass($notificationContent, $userId), $notificationContent);

    }

    public function SendNotificationReplyResource($data, $userName = '')
    {
//        $author = $data->author ?? $data->getAuthor($data->system, $data->created_by);
//        $author = method_exists($data, 'getAuthor') ? ($data->getAuthor($data->system, $data->created_by) ?? $data->author) : $data->author;
        $author = $data->getAuthor($data->system, $data->created_by ?? $data->answer_by);
        $userId = $author?->id ?? $data->created_by;

        $notificationContent = $this->notificationContentService->getNewReplyResource($data, $userName);
        $this->notificationService->sendNotification($author, new SendNotificationClass($notificationContent, $userId), $notificationContent);

    }
    public function sendMembershipBlockEmail($user,$reason='')
    {
        $emailContent = $this->emailContentService->getBlockEmailContent($user,$reason);
        $this->emailService->sendEmail($user, $emailContent);

    }
    public function sendMembershipRejectEmail($user,$reason='')
    {
        $emailContent = $this->emailContentService->getRejectEmailContent($user,$reason);
        $this->emailService->sendEmail($user, $emailContent);

    }
    public function sendMembershipApprovalEmail($user)
    {
        $emailContent = $this->emailContentService->getApprovalEmailContent($user);
        $this->emailService->sendEmail($user, $emailContent);

    }
    //allocating counseling
    public function sendAllocatingAounselingNotificationtoCgo($user, $data){
        $notificationContent = $this->notificationContentService->getNotificationCgoAllocatingAounselingContent($user, $data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }
    public function CgoSubmitResultSendNotificationToTrainee($user, $data){
        $notificationContent = $this->notificationContentService->getNotificationCgoSubmitResultContent($user, $data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }
    public function approvalContentSendToCgo($user, $data){
        $notificationContent = $this->notificationContentService->approvalContentSendToCgoContent($user, $data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }
    public function rejectContentSendToCgo($user, $data){
        $notificationContent = $this->notificationContentService->rejectContentSendToCgoContent($user, $data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }
    public function rejectEventSendToCgo($user, $data){
        $notificationContent = $this->notificationContentService->rejectEventSendToCgoContent($user, $data);
        $this->notificationService->sendNotification($user, new SendNotificationClass($notificationContent, $user->id),$notificationContent);
    }
    public function SendNotificationOJTRegistrationToCGO($data_slug = '')
    {
        $cgoUsers = CgoUser::all();
        $notificationContent = $this->notificationContentService->getNewOjtRegistrtionToCGO($data_slug);

        foreach ($cgoUsers as $cgo) {
            $user_id = $cgo->id;
            $this->notificationService->sendNotification(
                $cgo,
                new SendNotificationClass($notificationContent, $user_id),
                $notificationContent
            );
        }
    }
    public function sendNotificationOJTMatchToTrainee($ojt,$traineeApply)
    {
        $notificationContent = $this->notificationContentService->getMatchOjtRegistrtionToTraineeContent($ojt);
        $this->notificationService->sendNotification($traineeApply->user, new SendNotificationClass($notificationContent, $traineeApply->user->id),$notificationContent);
    }
    public function sendNotificationJobMatchToTrainee($job,$traineeApply)
    {
        $notificationContent = $this->notificationContentService->getMatchJobRegistrtionToTraineeContent($job);
        $this->notificationService->sendNotification($traineeApply->user, new SendNotificationClass($notificationContent, $traineeApply->user->id),$notificationContent);
    }
    public function sendNotificationJobMatchToCompany($traineeApply)
    {
        $notificationContent = $this->notificationContentService->getMatchJobRegistrtionToCompanyContent($traineeApply);
        $job= $traineeApply->job;
        $owner = $job->owner;

        $this->notificationService->sendNotification(
            $owner,
            new SendNotificationClass($notificationContent, $owner->id),
            $notificationContent
        );

    }
   public function sendNotificationOJTMatchToCompany($traineeApply)
    {
        $notificationContent = $this->notificationContentService->getMatchOjtRegistrtionToCompanyContent($traineeApply);
        $ojt= $traineeApply->ojt;
        $owner = $ojt->owner;

            $this->notificationService->sendNotification(
                $owner,
                new SendNotificationClass($notificationContent, $owner->id),
                $notificationContent
            );

    }

    public function sendSelectedTraineeOJTNotification($ojt, $ojtTraineeApply)
    {
        $notificationContent = $this->notificationContentService->getSelectedTraineeOJTContent($ojt);

        $this->notificationService->sendNotification(
            $ojtTraineeApply->user,
            new SendNotificationClass($notificationContent, $ojtTraineeApply->user->id),
            $notificationContent
        );
    }

    public function sendSelectedTraineeOJTNotificationToCGO($ojt, $ojtTraineeApply)
    {
        if (!$ojtTraineeApply->matchedBy) {
            return;
        }

        $notificationContent = $this->notificationContentService->getSelectedTraineeOJTContentCGO($ojt, $ojtTraineeApply);

        $this->notificationService->sendNotification(
            $ojtTraineeApply->matchedBy,
            new SendNotificationClass($notificationContent, $ojtTraineeApply->matchedBy->id),
            $notificationContent
        );
    }
        public function sendEmployeedTraineeNotification($ojt, $ojtTraineeApply)
    {
        $notificationContent = $this->notificationContentService->getEmploymentTraineeOJTContent($ojt);

        $this->notificationService->sendNotification(
            $ojtTraineeApply->user,
            new SendNotificationClass($notificationContent, $ojtTraineeApply->user->id),
            $notificationContent
        );
    }
        public function sendEmployeedTraineeNotificationToCGO($ojt, $ojtTraineeApply)
    {
        $notificationContent = $this->notificationContentService->getEmploymentTraineeOJTContentCGO($ojt,$ojtTraineeApply);

        $this->notificationService->sendNotification(
            $ojtTraineeApply->matchedBy,
            new SendNotificationClass($notificationContent, $ojtTraineeApply->matchedBy->id),
            $notificationContent
        );
    }


    public function sendPeerReviewContentNotificationToCGO($user, $content)
    {
        $notificationContent = $this->notificationContentService->peerReviewContentAutoAssignCGOContent($user, $content);

        $this->notificationService->sendNotification(
            $user,
            new SendNotificationClass($notificationContent, $user->id),
            $notificationContent
        );
    }
    public function sendUnSelecrTraineeNotificationToTrainee($user,$ojt){
        $notificationContent=$this->notificationContentService->notificationUnselectContent($ojt);
        $this-> notificationService->sendNotification(   $user,
            new SendNotificationClass($notificationContent, $user->id),
            $notificationContent);
    }
    public function sendUnSelecrTraineeNotificationToCGO($ojt, $ojtTraineeApply)
    {
        $notificationContent = $this->notificationContentService->getUnselectTraineeOJTContentCGO($ojt,$ojtTraineeApply);

        $this->notificationService->sendNotification(
            $ojtTraineeApply->matchedBy,
            new SendNotificationClass($notificationContent, $ojtTraineeApply->matchedBy->id),
            $notificationContent
        );
    }
}
