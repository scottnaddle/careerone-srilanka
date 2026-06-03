<?php
namespace App\Services\Cgo\Notification;

class EmailContentService
{
    /**
     * Get content for approval email.
     *
     * @param array $data
     * @return array
     */
    // public function getApprovalEmailContent($data)
    // {
    //     return [
    //         'subject' => 'Your Event Has Been Approved',
    //         'view' => 'mail.Cgo.testmail',
    //         'data' => [
    //             'name' => 'Jony dang', //$data['name'],
    //             'event' => 'Xin chào', //$data['event'],
    //             'details' =>'abc', //$data['details'],
    //         ],
    //     ];
    // }
    public function getBlockEmailContent($user,$reason){
        $name = $user->first_name.' '.$user->last_name;
        return [
            'subject' => 'Your account was locked',
            'view' => 'mail.block',
            'data' => [
                'name' => $name,
                'details' => 'Your account was locked by the administrator at '.now().'. If you believe this is a mistake, please contact support for assistance.',
                'reason'=>$reason
            ],
        ];
    }
    public function getRejectEmailContent($user,$reason){
        $name = $user->first_name.' '.$user->last_name;
        return [
            'subject' => 'NOTICE YOUR ACCOUNT IS SUSPENDED',
            'view' => 'mail.reject',
            'data' => [
                'name' => $name,
                'details' => 'Your account was locked by the administrator at '.now().'. If you believe this is a mistake, please contact support for assistance.',
                'reason'=>$reason
            ],
        ];
    }
    public function getApprovalEmailContent($user){
        $name = $user->first_name.' '.$user->last_name;
        return [
            'subject' => 'Congratulations! Your Account is Approved',
            'view' => 'mail.approval',
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
