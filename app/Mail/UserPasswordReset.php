<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plainPassword;
    public $userType;

    public function __construct($user, $plainPassword, $userType)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
        $this->userType = $userType;
    }

    public function build()
    {
        return $this->subject('[CareerOne] Your New Password')
            ->markdown('mail.user-password-reset');
    }
}
