{{-- resources/views/emails/cgo/inactive-reminder.blade.php --}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGO Inactive Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a5568;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f7fafc;
            padding: 30px;
            border-radius: 0 0 5px 5px;
            border: 1px solid #e2e8f0;
        }
        .button {
            display: inline-block;
            background-color: #4299e1;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .warning {
            background-color: #fed7d7;
            border-left: 4px solid #e53e3e;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #718096;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>CGO System Notification</h2>
</div>

<div class="content">
    <h3>Hello {{ $name }},</h3>

    @if($inactiveDays >= 30)
        <div class="warning">
            <strong>⚠️ Important Notice</strong><br>
            You haven't logged into the CGO system for <strong>{{ $inactiveDays }} days</strong>.
        </div>
    @else
        <p>We noticed you haven't logged into the CGO system for <strong>{{ $inactiveDays }} days</strong>.</p>
    @endif

    <p>To keep your account active and stay updated with the latest information, please log in at your earliest convenience.</p>

    <div style="text-align: center;">
        <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
    </div>

    <p>If you're having trouble accessing your account or need assistance, please contact our support team:</p>
    <p>
        📧 <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a><br>
        📞 Support Hotline: [0117608040]
    </p>

    <hr>
    <p style="font-size: 14px; color: #718096;">
        This is an automated reminder. If you have already logged in recently, please ignore this email.
    </p>
</div>

<div class="footer">
    <p>© Tertiary and Vocational Education Commission - Ministry of Education, Higher Education & Vocational Education. All rights reserved.</p>
</div>
</body>
</html>
