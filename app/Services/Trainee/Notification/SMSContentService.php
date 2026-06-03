<?php
namespace App\Services\Trainee\Notification;

class SMSContentService{
    public function getApprovalSMSContent($data)
    {
        return 'Your event has been approved. Details: ' . $data['details'];
    }

    public function getFollowUpSMSContent($data)
    {
        return 'Reminder: Your event has been approved. Check details.';
    }
}