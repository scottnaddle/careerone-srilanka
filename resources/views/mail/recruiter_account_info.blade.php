<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 85%; margin: 0 auto; padding: 25px; border: 1px solid #e1e1e1; border-radius: 8px; }
        .header { border-bottom: 2px solid #3490dc; padding-bottom: 10px; margin-bottom: 20px; }
        .credentials { background: #f8fafc; padding: 20px; border-left: 4px solid #3490dc; margin: 20px 0; }
        .footer { font-size: 0.9em; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Welcome, {{ $recruiter->first_name }} {{ $recruiter->last_name }}!</h2>
    </div>
    <div class="content">
        <p>Your recruiter account has been successfully created for <strong>{{ $recruiter->company->name }}</strong>.</p>

        <p>Please use the following credentials to log in to <a href="https://careerone.gov.lk">CareerOne Platform</a>:</p>
        <div class="credentials">
            <strong>Login Email:</strong> {{ $recruiter->email }} <br>
            <strong>Temporary Password:</strong> <code>{{ $password }}</code>
        </div>

        <p>For security reasons, we strongly recommend that you change your password immediately after your first login.</p>
        <p>Please refer to the <a href="https://drive.google.com/drive/folders/1RuF6q94XG_sHTKZJ36KD_GsX0z8-PICu?usp=sharing">User Manual</a> to continue. </p>
    </div>
    <div class="footer">
        <p>Best Regards,<br>The Support Team</p>
    </div>
</div>
</body>
</html>
