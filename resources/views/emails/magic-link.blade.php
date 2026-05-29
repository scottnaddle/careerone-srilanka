@component('mail::message')
# Your {{ $userType }} Login Link

Click the button below to instantly sign in to your {{ $userType }} account. This link expires in **10 minutes**.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Sign In Now
@endcomponent

If the button doesn't work, copy and paste this URL:
[{{ $url }}]({{ $url }})

**Didn't request this?** You can safely ignore this email.

Thanks,<br>
TVET CareerOne
@endcomponent
