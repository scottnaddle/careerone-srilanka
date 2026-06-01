<?php

namespace App\Mail;

use App\Models\CgoUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CgoInactiveReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CgoUser $cgo,
        public int $inactiveDays
    ) {}

    public function envelope(): Envelope
    {
        $daysText = $this->inactiveDays === 0 ? 'never' : $this->inactiveDays;
        return new Envelope(
            subject: "[Reminder] You haven't logged in for {$daysText} days",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cgo.inactive-reminder',
            with: [
                'name' => $this->cgo->name,
                'email' => $this->cgo->email,
                'inactiveDays' => $this->inactiveDays,
                'loginUrl' => route('cgo.auth.login'),
                'supportEmail' => config('mail.support_email', 'careerone@tvec.gov.lk'),
            ]
        );
    }
}
