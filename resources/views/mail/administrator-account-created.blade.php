<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Account Created</title>
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
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .credentials {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #4F46E5;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin: 15px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Welcome to {{ $appName }}!</h1>
</div>

<div class="content">
    <h2>Dear {{ $name }},</h2>

    <p>Your administrator account has been successfully created in the {{ $appName }} system.</p>

    <div class="credentials">
        <h3>Your Login Credentials:</h3>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Password:</strong> <span style="font-family: monospace; font-size: 16px; background-color: #f3f4f6; padding: 4px 8px; border-radius: 4px;">{{ $password }}</span></p>
    </div>

    <div class="warning">
        <strong>⚠️ Important Security Notice:</strong>
        <ul style="margin: 10px 0 0 20px; padding: 0;">
            <li>Please change your password immediately after your first login</li>
            <li>Do not share your password with anyone</li>
            <li>Contact system administrator if you face any issues</li>
        </ul>
    </div>

    <div style="text-align: center;">
        <a href="{{ $loginUrl }}" class="button" style="color:#fff;">Login to Your Account</a>
    </div>

    <p>If the button doesn't work, copy and paste this link into your browser:</p>
    <p style="word-break: break-all; font-size: 12px; color: #6b7280;">{{ $loginUrl }}</p>

    <p>Best regards,<br>
        <strong>The Admin Team</strong></p>
</div>

<div class="footer">
    <p>This is an automated message. Please do not reply to this email.</p>
    <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
</div>
</body>
</html>
