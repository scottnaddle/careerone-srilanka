<?php
namespace App\Services\Cgo\Notification;
use App\Services\IconTypeServiceNotification;
class NotificationContentService{
    protected $iconTypeService;

    /**
     * Create a new NotificationService instance.
     *
     * @param  IconTypeServiceNotification  $iconTypeService
     * @return void
     */
    public function __construct(IconTypeServiceNotification $iconTypeService)
    {
        $this->iconTypeService = $iconTypeService;
    }
    public function getNewReplyQna($data,$userName)
    {
        $from_name = $data->qNA->title ?? $data->title;
        $data_slug = $data->qNA->slug ?? $data->slug;

        return [
            'key' => 'notification.notification.reply_qna',
            'message' => 'You have new reply from '.$userName.'.',
            'params' => ['qna_name' => $userName,
                         'type' => 'Reply QnA',
                         'Qna' =>  $data->qNA->id ?? $data->id,
                        ],

            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('informations.qnas.reply', ['slug' => $data_slug]),
        ];
    }

    public function getNewReplyContent($data,$userName)
    {
        $from_name = $data->qNA->title ?? $data->title;
        $content_id = $data->content->id ?? $data->id;
        return [
            'key' => 'notification.notification.reply_qna',
            'message' => 'You have new reply from '.$userName.'.',
            'params' => ['qna_name' => $userName,
                         'type' => 'Reply Content',
                         'Qna' =>  $content_id,
            ],

            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('career-guidance.career-information.contents.details', ['id' => base64_encode($content_id)]),
        ];
    }

    public function getNewReplyResource($data,$userName)
    {
        $from_name = $data->qNA->title ?? $data->title;
        $content_id = $data->resource->id ?? $data->id;
        return [
            'key' => 'notification.notification.reply_qna',
            'message' => 'You have new reply from '.$userName.'.',
            'params' => ['qna_name' => $userName,
                         'type' => 'Reply Resource',
                         'Qna' =>  $content_id,
            ],

            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('cgo.informations.content-management.resource.details', ['id' => base64_encode($content_id)]),
        ];
    }

    public function getNewOjtRegistrtionToCGO($data_slug)
    {

        return [
            'key' => 'notification.notification.send_all_cgo_registrtion_ojt',
            'message' => 'New OJT information registered.',
            'params' => [
                         'type' => 'Send all notification all cgo when registration OJT',
                        ],

            'icon' => $this->iconTypeService->iconStorage(),
            'href' =>  $data_slug,
        ];
    }

    public function getFollowUpNotificationContent($data)
    {
        return [
            'message' => 'Reminder: Your event has been approved.',
            'details' => 2,
        ];
    }
    public function getReplyNotificationContent($user,$data){
        return [
            'message' => $user->first_name .' '. $user->last_name.' Replied to your comment:'. $data['answer'],
            'details' => 2,
        ];
    }


    public function getNotificationCgoAllocatingAounselingContent($user,$data){
        $traineeName = $data->user_name_trainee_online ?? $user->full_name;
        return [
            'key' => 'notification.notification.allocated_counseling',
            'message' => 'You are allocated counseling by ' . $traineeName . '.',
            'params' => ['trainee_name' => $traineeName,
                         'idCounseling' => $data->id,
                         'type' => 'Allocated Counseling',
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('cgo.career-guidance.counseling.counseling-list.show', ['id' => $data->id]),
        ];
    }
     public function getNotificationCgoSubmitResultContent($user,$data){
        $traineeName = $data->user_name_trainee_online ?? $user->full_name;
        return [
            'key' => 'notification.notification.cgo_result_counseling',
            'message' => 'The results have been registered for the requested guidance. Please register the satisfaction of guidance.',
            'params' => ['trainee_name' => $traineeName,
                         'idCounseling' => $data->id,
                         'type' => 'Cgo Submit',
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('trainee.career-guidance.counseling.counseling-history', ['#show-'.$data->id]),
        ];
    }
    public function approvalContentSendToCgoContent($user,$data){
        if($data->getTable()=='events'){
            $route=route('informations.events.event');
        }else{
            if($data->content_type=='video'){
                $route=route('cgo.informations.content-management.videos.list');
            }else{
                $route=route('cgo.informations.content-management.documents.list');
            }
        }

        return [
            'key' => 'notification.notification.approval_content',
            'message' => 'Your post has been approved by the administrator and has been successfully published.',
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => $route,
        ];
    }
    public function rejectContentSendToCgoContent($user,$data){
        if($data->getTable()=='events'){
            $route=route('informations.events.event');
        }else{
            if($data->content_type=='video'){
                $route=route('cgo.informations.content-management.videos.list');
            }else{
                $route=route('cgo.informations.content-management.documents.list');
            }
        }
        return [
            'key' => 'notification.notification.reject_content',
            'message' => 'Your article was rejected for the reason:'.$data->reason.'',
            'params' => [
                'reason' => $data->reason,
                'type' => 'Reject Content',
            ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => $route,
        ];
    }
    public function getMatchOjtRegistrtionToTraineeContent($ojt){
        return [
            'key' => 'notification.notification.send_match_ojt_trainee',
            'message' => 'You are matched OJT of company '.$ojt->company->name.'.',
            'params' => [
                         'idOJT' => $ojt->id,
                         'type' => 'Matched OJT',
                        'company_name' => $ojt->company->name,
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('trainee.job-support.ojt.ojt-detail', ['id'=>$ojt->id,'slug'=>$ojt->slug]),
        ];
    }

    public function getMatchJobRegistrtionToTraineeContent($job){
        return [
            'key' => 'notification.notification.send_match_job_trainee',
            'message' => 'You are matched Job of company '.$job->company->name.'.',
            'params' => [
                'idJob' => $job->id,
                'type' => 'Matched Job',
                'company_name' => $job->company->name,
            ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('trainee.job-support.job-list.job-detail', ['job_id'=>$job->id,'slug'=>$job->slug]),
        ];
    }

    public function getMatchOjtRegistrtionToCompanyContent($ojtApply){
        return [
            'key' => 'notification.notification.send_match_ojt_company',
            'message' => 'OJT '.$ojtApply->ojt->title.' is matched with '.$ojtApply->user->full_name.'.',
            'params' => [
                         'idOJT' => $ojtApply->ojt->id,
                         'type' => 'Matched OJT',
                         'trainee_name'=>$ojtApply->user->full_name,
                         'ojt_name'=>$ojtApply->ojt->title
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('company.job-support.ojt-list.detail', ['slug'=>$ojtApply->ojt->slug]),
        ];
    }

    public function getMatchJobRegistrtionToCompanyContent($traineeApply){
        return [
            'key' => 'notification.notification.send_match_job_company',
            'message' => 'Job '.$traineeApply->job->title.' is matched with '.$traineeApply->user->full_name.'.',
            'params' => [
                'idjob' => $traineeApply->job->id,
                'type' => 'Matched Job',
                'trainee_name'=>$traineeApply->user->full_name,
                'job_name'=>$traineeApply->job->title
            ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('company.job-support.job-vacancy.show', ['job_id' => $traineeApply->job->id,'slug'=>$traineeApply->job->slug]),
        ];
    }

    public function getSelectedTraineeOJTContent($ojt){
        return [
            'key' => 'notification.notification.selected_to_ojt',
            'message' => 'You are selected to '.$ojt->title.' of '.$ojt->company->name.'.',
            'params' => [
                         'idOJT' => $ojt->id,
                         'type' => 'Selected OJT',
                        'company_name' => $ojt->company->name,
                        'ojt_name' => $ojt->title,
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('trainee.job-support.ojt.ojt-detail', ['id'=>$ojt->id,'slug'=>$ojt->slug]),
        ];
    }
    public function getSelectedTraineeOJTContentCGO($ojt,$isOJTTraineeApply){
        return [
            'key' => 'notification.notification.send_select_ojt_cgo',
            'message' => 'OJT '.$ojt->title.' was selected with trainee '.$isOJTTraineeApply->user->full_name.'',
            'params' => [
                         'idOJT' => $ojt->id,
                         'type' => 'Selected OJT',
                        'ojt_name' => $ojt->title,
                        'trainee_name' => $isOJTTraineeApply->user->full_name,
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('trainee.job-support.ojt.ojt-detail', ['id'=>$ojt->id,'slug'=>$ojt->slug]),
        ];
    }
     public function getEmploymentTraineeOJTContent($ojt){
        return [
            'key' => 'notification.notification.employed_to_ojt',
            'message' => 'You are employed  to '.$ojt->title.' of '.$ojt->company->name.'.',
            'params' => [
                         'idOJT' => $ojt->id,
                         'type' => 'employed OJT',
                        'company_name' => $ojt->company->name,
                        'ojt_name' => $ojt->title,
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('trainee.job-support.ojt.ojt-detail', ['id'=>$ojt->id,'slug'=>$ojt->slug]),
        ];
    }
    public function getEmploymentTraineeOJTContentCGO($ojt,$isOJTTraineeApply){
        return [
            'key' => 'notification.notification.send_employee_ojt_cgo',
            'message' => 'OJT '.$ojt->title.' has employed trainee '.$isOJTTraineeApply->user->full_name.'',
            'params' => [
                         'idOJT' => $ojt->id,
                         'type' => 'Selected OJT',
                        'ojt_name' => $ojt->title,
                        'trainee_name' => $isOJTTraineeApply->user->full_name,
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('cgo.job-support.ojt-list.ojt_detail', ['id'=>$ojt->id]),
        ];
    }

    public function peerReviewContentAutoAssignCGOContent($user,$content){
        return [
            'key' => 'notification.notification.send_notification_peer_review_cgo',
            'message' => 'You was assigned to review new content published by '.$content->getAuthor('cgo', $user->id)->fullName.'.',
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('cgo.informations.content-management.peer-review.list', ['id'=>$content->id]),
        ];
    }
    public function notificationUnselectContent($ojtApply){
        $ojt= $ojtApply->ojt;
        return [
            'key' => 'notification.notification.send_unselect_ojt',
            'message' => 'You have been unselected from the OJT program:'.$ojt->title.'',
            'params' => [
                        'idOJT' => $ojt->id,
                         'type' => 'unselect OJT',
                         'ojt_name' => $ojt->title,
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('trainee.job-support.ojt.ojt-detail', ['id'=>$ojt->id,'slug'=>$ojt->slug]),
        ];
    }
     public function getUnselectTraineeOJTContentCGO($trainee,$isOJTTraineeApply){
         $ojt= $isOJTTraineeApply->ojt;
        return [
            'key' => 'notification.notification.send_unselect_ojt_cgo',
            'message' => 'OJT '.$ojt->title.' was unselect with trainee '.$isOJTTraineeApply->user->full_name.'',
            'params' => [
                         'idOJT' => $ojt->id,
                         'type' => 'Unselect OJT',
                        'ojt_name' => $ojt->title,
                        'trainee_name' => $isOJTTraineeApply->user->full_name,
                        ],
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('cgo.job-support.ojt-list.ojt_detail', ['id'=>$ojt->id]),
        ];
    }
}
