<!-- resources/views/emails/monthly-report.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background: #4CAF50; color: white; padding: 20px; text-align: center; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .section-title { background: #f4f4f4; padding: 10px; margin: -15px -15px 15px -15px; border-radius: 5px 5px 0 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f4f4f4; }
        .total { font-weight: bold; color: #4CAF50; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Monthly Report</h2>
        <p>{{ $reportData['generated_at'] }}</p>
    </div>

    <!-- Membership Section -->
    <div class="section">
        <div class="section-title">
            <h3>Membership Statistics</h3>
        </div>
        <table>
            <tr><th>Category</th><th>Count</th></tr>
            <tr><td>Trainee Users</td><td>{{ number_format($reportData['membership']['trainee_users']) }}</td></tr>
            <tr><td>CGO Users</td><td>{{ number_format($reportData['membership']['cgo_users']) }}</td></tr>
            <tr><td>Admin Users</td><td>{{ number_format($reportData['membership']['admin_users']) }}</td></tr>
            <tr><td>Companies</td><td>{{ number_format($reportData['membership']['companies']) }}</td></tr>
            <tr><td>Company Recruiters</td><td>{{ number_format($reportData['membership']['company_recruiters']) }}</td></tr>
            <tr class="total"><td><strong>Total Members</strong></td><td><strong>{{ number_format($reportData['membership']['total_members']) }}</strong></td></tr>
        </table>
    </div>

    <!-- Guidance Section -->
    <div class="section">
        <div class="section-title">
            <h3>Guidance Statistics</h3>
        </div>
        <table>
            <tr><th>Category</th><th>Count</th></tr>
            <tr><td>Completed Counselings</td><td>{{ number_format($reportData['guidance']['completed_counselings']) }}</td></tr>
            <tr><td>Cancelled Counselings</td><td>{{ number_format($reportData['guidance']['cancelled_counselings']) }}</td></tr>
            <tr><td>Total Counselings</td><td>{{ number_format($reportData['guidance']['total_counselings']) }}</td></tr>
            <tr><td>This Month - Completed</td><td>{{ number_format($reportData['guidance']['this_month']['completed']) }}</td></tr>
            <tr><td>This Month - Cancelled</td><td>{{ number_format($reportData['guidance']['this_month']['cancelled']) }}</td></tr>
        </table>
    </div>

    <!-- Job Support Section -->
    <div class="section">
        <div class="section-title">
            <h3>Job Support Statistics</h3>
        </div>

        <h4>Jobs</h4>
        <table>
            <tr><th>Category</th><th>Count</th></tr>
            <tr><td>Total Jobs</td><td>{{ number_format($reportData['job_support']['jobs']['total']) }}</td></tr>
            <tr><td>Active Jobs</td><td>{{ number_format($reportData['job_support']['jobs']['active']) }}</td></tr>
            <tr><td>New (This Month)</td><td>{{ number_format($reportData['job_support']['jobs']['this_month']) }}</td></tr>
        </table>

        <h4>OJT</h4>
        <table>
            <tr><th>Category</th><th>Count</th></tr>
            <tr><td>Total OJTs</td><td>{{ number_format($reportData['job_support']['o_j_t_s']['total']) }}</td></tr>
            <tr><td>Active OJTs</td><td>{{ number_format($reportData['job_support']['o_j_t_s']['active']) }}</td></tr>
            <tr><td>New (This Month)</td><td>{{ number_format($reportData['job_support']['o_j_t_s']['this_month']) }}</td></tr>
        </table>

        <h4>Trainee Applications</h4>
        <table>
            <tr><th>Category</th><th>Count</th></tr>
            <tr><td>Job Match</td><td>{{ number_format($reportData['job_support']['trainee_applies']['job_match']) }}</td></tr>
            <tr><td>Apply</td><td>{{ number_format($reportData['job_support']['trainee_applies']['apply']) }}</td></tr>
            <tr><td>Total</td><td>{{ number_format($reportData['job_support']['trainee_applies']['total']) }}</td></tr>
            <tr><td>This Month</td><td>{{ number_format($reportData['job_support']['trainee_applies']['this_month']) }}</td></tr>
        </table>

        <h4>OJT Trainee Applications</h4>
        <table>
            <tr><th>Category</th><th>Count</th></tr>
            <tr><td>Job Match</td><td>{{ number_format($reportData['job_support']['ojt_trainee_applies']['job_match']) }}</td></tr>
            <tr><td>Apply</td><td>{{ number_format($reportData['job_support']['ojt_trainee_applies']['apply']) }}</td></tr>
            <tr><td>Total</td><td>{{ number_format($reportData['job_support']['ojt_trainee_applies']['total']) }}</td></tr>
            <tr><td>This Month</td><td>{{ number_format($reportData['job_support']['ojt_trainee_applies']['this_month']) }}</td></tr>
        </table>
    </div>
</div>
</body>
</html>
