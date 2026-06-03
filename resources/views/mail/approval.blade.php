<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approval Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; background-color: #ffffff; padding: 20px; margin: 0 auto; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #5cb85c;">Congratulations! Your Account is Approved</h2>
        
        <p>Dear {{ $name }},</p>

        <p>We are delighted to inform you that your account on {{ config('app.app_name') }} has been approved. You can now access all available features and services on our platform.</p>

        <p>If you have any questions or need assistance, please feel free to reach out to us via email at <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}.</p>

        <p>Welcome aboard, and we look forward to supporting you in your journey with  {{ config('app.app_name') }}.</p>

        <p>Sincerely,<br>
            {{ config('app.app_name') }}</p>
    </div>

</body>
</html>
