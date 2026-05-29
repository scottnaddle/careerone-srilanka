<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspension Notice</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; background-color: #ffffff; padding: 20px; margin: 0 auto; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #d9534f;">NOTICE: YOUR ACCOUNT IS SUSPENDED</h2>
        
        <p>Dear {{ $name }},</p>

        <p>Career One would like to inform you that your account on {{ config('app.app_name') }} has been suspended due to irregularities and violations of our policies.</p>
        <p>Reason :{{ $reason }}</p>
        <p>If you have any questions, please contact us via email at <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a>.</p>

        <p>Sincerely,<br>
            {{ config('app.app_name') }}</p>
    </div>

</body>
</html>