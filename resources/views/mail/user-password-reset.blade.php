@component('mail::message')
    # Emergency Password Reset

    Hello {{ $user->email }},

    Your account has been reset and activated by an administrator.

    **Your new password is:**
    {{ $plainPassword }}

    Please log in and change your password immediately.

    Thanks, The Support Team
    CareerOne Platform
@endcomponent
