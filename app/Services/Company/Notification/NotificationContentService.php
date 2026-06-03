<?php
namespace App\Services\Company\Notification;
use App\Services\IconTypeServiceNotification;
class NotificationContentService{
    protected $iconTypeService;
    public function __construct(IconTypeServiceNotification $iconTypeService)
    {
        $this->iconTypeService = $iconTypeService;
    }
    public function getToggleApplyContent($user, $data)
    {
        return [
            'key' => 'notification.notification.trainee_apply_job',
            'message' => $data->title . ' is applied by ' . $user . '.',
            'params' => [
                'job_name' => $data->title,
                'trainee_name' => $user,
                'type' => 'Trainee apply job',
            ],
           
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('company.job-support.job-vacancy.candidate-list.list', [
                'job_id' => $data->id,
                'slug' => $data->slug,
            ]),
        ];
    }
    
    public function getNotifcationApplyOJTContent($user, $data,$trainee_name)
    {
        return [
            'key' => 'notification.notification.trainee_apply_job',
            'message' => $data->title . ' is applied by ' . $trainee_name . '.',
            'params' => [
                'job_name' => $data->title,
                'trainee_name' => $trainee_name,
                'type' => 'Trainee apply ojt',
            ],
           
            'icon' => $this->iconTypeService->iconStorage(),
            'href' => route('company.job-support.ojt-list.detail', [
                'slug' => $data->slug,
            ]),
        ];
    }
}