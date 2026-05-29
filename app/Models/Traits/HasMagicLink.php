<?php

namespace App\Models\Traits;

use App\Mail\MagicLinkMail;
use Illuminate\Support\Facades\Mail;

trait HasMagicLink
{
    public function sendMagicLink(string $rawToken, string $userType): void
    {
        $url = route('magic-link.verify', [
            'token' => $rawToken,
            'user_type' => $userType,
            'email' => $this->email,
        ]);

        Mail::to($this->email)->send(new MagicLinkMail($url, $userType));
    }
}
