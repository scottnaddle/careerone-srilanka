<?php

namespace App\Mail;

use App\Models\CompanyRecruiter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecruiterAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $recruiter;
    public $password;

    public function __construct(CompanyRecruiter $recruiter, $password)
    {
        $this->recruiter = $recruiter;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('[CareerOne Platform] Welcome! Your Recruiter Account Information')
            ->view('mail.recruiter_account_info');
    }
}
