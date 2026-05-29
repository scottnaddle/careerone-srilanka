<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $url,
        public string $userType,
    ) {}

    public function build()
    {
        $typeLabel = match ($this->userType) {
            'trainee' => 'Trainee',
            'company' => 'Company',
            'cgo' => 'Career Guidance Officer',
        };

        return $this->subject("Your {$typeLabel} Login Link — TVET CareerOne")
            ->markdown('emails.magic-link', [
                'url' => $this->url,
                'userType' => $typeLabel,
            ]);
    }
}
