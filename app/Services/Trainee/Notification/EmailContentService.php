<?php
namespace App\Services\Trainee\Notification;

class EmailContentService
{
    /**
     * Get content for approval email.
     *
     * @param array $data
     * @return array
     */
    public function getApprovalEmailContent($data)
    {
        return [
            'subject' => 'Your Event Has Been Approved',
            'view' => 'emails.event-approved',
            'data' => [
                'name' => $data['name'],
                'event' => $data['event'],
                'details' => $data['details'],
            ],
        ];
    }
    public function getBlockEmailContent($user){
        $name = $user->first_name.' '.$user->last_name;
        return [
            'subject' => 'Your account was locked',
            'view' => 'mail.block',
            'data' => [
                'name' => $name,
                'details' => 'Your account was locked by the administrator at '.now().'. If you believe this is a mistake, please contact support for assistance.',
            ],
        ];
    }
        /**
     * Get content for follow-up email.
     *
     * @param array $data
     * @return array
     */
    public function getFollowUpEmailContent($data)
    {
        return [
            'subject' => 'Follow-up: Event Approval',
            'view' => 'emails.event-approved-followup',
            'data' => [
                'name' => $data['name'],
                'event' => $data['event'],
                'details' => $data['details'],
            ],
        ];
    }

}
