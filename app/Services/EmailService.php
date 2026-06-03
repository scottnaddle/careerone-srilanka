<?php
namespace App\Services;
use App\Jobs\SendEmailJob;
use Safe\Exceptions\ExecException;

class EmailService
{
    public function sendEmail($user, $emailContent)
    {
        try {
            SendEmailJob::dispatch($user, $emailContent);
        } catch (\Exception $e) {
            \Log::error('Error sending email: ' . $e->getMessage());
        }
    }
    
}
