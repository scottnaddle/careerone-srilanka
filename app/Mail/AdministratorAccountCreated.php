<?php

namespace App\Mail;

use App\Models\AdminUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdministratorAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public AdminUser $administrator,
        public string $plainPassword
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Administrator Account Has Been Created - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.administrator-account-created',
            with: [
                'name' => $this->administrator->fullName,
                'email' => $this->administrator->email,
                'password' => $this->plainPassword,
                'loginUrl' => url('/admin/auth/login'),
                'appName' => config('app.name'),
            ]
        );
    }
}
