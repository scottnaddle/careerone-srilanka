<?php
namespace App\Services\Trainee\Notification;
use App\Services\IconTypeServiceNotification;
use Carbon\Carbon;
class NotificationContentService{
    protected $iconTypeService;
    public function __construct(IconTypeServiceNotification $iconTypeService)
    {
        $this->iconTypeService = $iconTypeService;
    }

    public function getApprovalNotificationContent($data)
    {
        return [
            'message' => 'Your event has been approved.',
            'details' => 1,//type icon
        ];
    }
    public function getFollowUpNotificationContent($data)
    {
        return [
            'message' => 'Reminder: Your event has been approved.',
            'details' => 2,//type icon
        ];
    }
    public function sendAllocatingAounselingContent($data){
        return[
            'message'=> '',
            'detail'=>3,//type icon
        ];
    }
    public function getMatchJobNotificationOfCgoContent($trainee, $data)
{
    return [
        'key' => 'notification.notification.match_job_cgo',
        'message' => 'You have been matched with a job at ' . $data->company->name . ' for the position of ' . $data->title . '.',
        'params' => [
            'company_name' => $data->company->name,
            'job_name' => $data->title,
            'idJob'=>$data->id,
            'type' => 'Matched job of company',

        ],
       
        'icon' => $this->iconTypeService->iconStorage(),
        'href' => route('trainee.job-support.job-list.job-detail', [
            'job_id' => $data->id,
            'slug' => $data->slug,
        ]),
    ];
}

    // public function getMatchJobNotificationOfCgoContent($trainee, $data){
    //     return[
    //         'message' => 'You have been matched with a job at '.$data->company->name.' for the position of '.$data->title.'.',
    //         'icon'=> $this->iconTypeService->iconStorage(),
    //         'job_name'=>$data->title,
    //         'company_name'=>$data->company->name,
    //         'idJob'=>$data->id,
    //         'type'=>'Matched job of company',
    //         'href'=>route('trainee.job-support.job-list.job-detail', ['job_id' => $data->id, 'slug'=>$data->slug]) 
    //     ];
    // }
    // public function getNotificationCgoConfirmCounselingToTraineeContent($user,$data){
    //     return [
    //         'message'=> 'You are confirmed of request counseling',
    //         'type'=>'Confirmed of request counseling',
    //         'idCounseling'=>$data->id,
    //         'icon'=> $this->iconTypeService->iconStorage(),
    //         'href'=>route('trainee.career-guidance.counseling.counseling-list.show', ['id' => $data->id])
    //     ];
    // }
    public function getNotificationCgoConfirmCounselingToTraineeContent($user, $data)
{
    $formattedDate = Carbon::parse($data->available_time)->format('d-m-Y');
    return [
        'key' => 'notification.notification.confirmed_request_of_couseling',
        'message' => 'You are confirmed of request counseling available time is : '.$formattedDate.'',
        'params' => [
            'trainee_name' => $user->name ?? 'Trainee',
            'available_time'=>$formattedDate,
            'idCounseling' => $data->id,
             'type' => 'Confirmed of request counseling',
        ],
        'icon' => $this->iconTypeService->iconStorage(),
        'href' => route('trainee.career-guidance.counseling.counseling-list.show', ['id' => $data->id]),
    ];
}

    // public function getSelectedTraineeApplyContent($data){
    //     return [
    //         'message'=> 'You are selected to '.$data->job->title.' of '.$data->username_company.'',
    //         'type'=>'Selected to job',
    //         'job_name'=>$data->job->title,
    //         'company_name'=>$data->username_company,
    //         'idJob'=>$data->job->id,
    //         'icon'=> $this->iconTypeService->iconStorage(),
    //         'href'=>route('trainee.job-support.job-list.job-detail', ['job_id' => $data->job->id, 'slug'=>$data->job->slug])
    //     ];
    // }
    public function getSelectedTraineeApplyContent($data)
{
    return [
        'key' => 'notification.notification.selected_to_job',
        'message'=> 'You are selected to '.$data->job->title.' of '.$data->username_company.'',
        'params' => [
            'job_name' => $data->job->title,
            'company_name' => $data->username_company,
            'idJob' => $data->job->id,
             'type' => 'Selected to job',
        ],
       
        'icon' => $this->iconTypeService->iconStorage(),
        'href' => route('trainee.job-support.job-list.job-detail', [
            'job_id' => $data->job->id,
            'slug' => $data->job->slug,
        ]),
    ];
}

    // public function getemployeedTraineeApplyContent($data){
    //     return [
    //         'message'=> 'You are employed to '.$data->job->title.' of '.$data->username_company.'',
    //         'type'=>'Employed to job',
    //         'job_name'=>$data->job->title,
    //         'company_name'=>$data->username_company,
    //         'idJob'=>$data->job->id,
    //         'icon'=> $this->iconTypeService->iconStorage(),
    //         'href'=>route('trainee.job-support.job-list.job-detail', ['job_id' => $data->job->id, 'slug'=>$data->job->slug])
    //     ];
    // }
    public function getemployeedTraineeApplyContent($data)
{
    return [
        'key' => 'notification.notification.employed_to_job',
        'message'=> 'You are employed to '.$data->job->title.' of '.$data->username_company.'',
        'params' => [
            'job_name' => $data->job->title,
            'company_name' => $data->username_company,
            'idJob' => $data->job->id,
             'type' => 'Employed to job',
        ],
        'icon' => $this->iconTypeService->iconStorage(),
        'href' => route('trainee.job-support.job-list.job-detail', [
            'job_id' => $data->job->id,
            'slug' => $data->job->slug,
        ]),
    ];
}

    // public function getMatchJobNotificationOfCgoContentSendCompany($user, $data){
    //     $full_name_trainee= $user->first_name.' '.$user->last_name;
    //     return[
    //         'message'=> ''.$data->title.' is matched with '.$full_name_trainee.'',
    //         'icon'=> $this->iconTypeService->iconStorage(),
    //         'href'=>route('company.job-support.job-vacancy.candidate-list.list',['job_id'=>$data->id,'slug'=>$data->slug])
    //     ];
    // }
    public function getMatchJobNotificationOfCgoContentSendCompany($user, $data)
{
    $fullNameTrainee = $user->full_name ;

    return [
        'key' => 'notification.notification.job_matched_trainee',
        'message'=> ''.$data->title.' is matched with '.$fullNameTrainee.'',
        'params' => [
            'job_name' => $data->title,
            'trainee_name' => $fullNameTrainee,
            'idJob'=>$data->id,
             'type' => 'Matched Job Notification',
        ],
        'icon' => $this->iconTypeService->iconStorage(),
        'href' => route('company.job-support.job-vacancy.candidate-list.list', [
            'job_id' => $data->id,
            'slug' => $data->slug,
        ]),
    ];
}
public function getMatchOJTNotificationOfCgoContentSendCompany($user, $data)
{
    $fullNameTrainee = $user->full_name ;

    return [
        'key' => 'notification.notification.job_matched_trainee',
        'message'=> ''.$data->title.' is matched with '.$fullNameTrainee.'',
        'params' => [
            'job_name' => $data->title,
            'trainee_name' => $fullNameTrainee,
            'idJob'=>$data->id,
             'type' => 'Matched Job Notification',
        ],
        'icon' => $this->iconTypeService->iconStorage(),
        'href' => route('company.job-support.job-vacancy.candidate-list.list', [
            'job_id' => $data->id,
            'slug' => $data->slug,
        ]),
    ];
}
public function getNewJobRegistrtionToCGO($data_slug)
{

    return [
        'key' => 'notification.notification.send_all_cgo_registrtion_job',
        'message' => 'New job vacancy registered.',
        'params' => [
                     'type' => 'Send all notification all cgo when registration Job',
                    ],

        'icon' => $this->iconTypeService->iconStorage(),
        'href' =>  $data_slug,
    ];
}


}