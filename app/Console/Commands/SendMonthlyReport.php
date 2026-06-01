<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Mail\MonthlyReportMail;
use Carbon\Carbon;

class SendMonthlyReport extends Command
{
    protected $signature = 'report:monthly';
    protected $description = 'Generate monthly report and send via email';

    // Biến lưu đường dẫn log file
    protected $logFile;
    protected $logPath;

    public function __construct()
    {
        parent::__construct();

        // Tạo thư mục logs nếu chưa có
        $this->logPath = storage_path('logs/monthly_reports');
        if (!file_exists($this->logPath)) {
            mkdir($this->logPath, 0755, true);
        }

        // Tạo tên file log theo ngày tháng năm
        $this->logFile = $this->logPath . '/report_' . now()->format('Y-m-d_H-i-s') . '.log';
    }

    public function handle()
    {
        $startTime = microtime(true);

        // Ghi log bắt đầu
        $this->writeLog("==========================================");
        $this->writeLog("MONTHLY REPORT CRON JOB STARTED");
        $this->writeLog("Time: " . now()->format('Y-m-d H:i:s'));
        $this->writeLog("==========================================");

        try {
            $this->info('Starting monthly report generation...');
            $this->writeLog("INFO: Starting monthly report generation");

            // Gather all data
            $this->writeLog("INFO: Gathering report data...");
            $reportData = $this->gatherReportData();
            $this->writeLog("SUCCESS: Data gathered successfully", [
                'membership_count' => $reportData['membership']['total_members'],
                'jobs_count' => $reportData['job_support']['jobs']['total']
            ]);

            // Generate report content
            $this->writeLog("INFO: Generating report content...");
            $reportContent = $this->generateReportContent($reportData);

            // Save report content to file (backup)
            $this->saveReportBackup($reportContent, $reportData);

            // Send email
            $this->writeLog("INFO: Sending email to " . env('REPORT_EMAIL', 'careerone@tvec.gov.lk'));
            Mail::to(env('REPORT_EMAIL', 'careerone@tvec.gov.lk'))
                ->send(new MonthlyReportMail($reportContent, $reportData));

            $executionTime = round((microtime(true) - $startTime), 2);

            // Ghi log thành công
            $this->writeLog("==========================================");
            $this->writeLog("SUCCESS: Monthly report sent successfully");
            $this->writeLog("Execution time: {$executionTime} seconds");
            $this->writeLog("Log file: " . $this->logFile);
            $this->writeLog("==========================================");

            $this->info('Monthly report sent successfully!');

            // Xóa log cũ hơn 90 ngày
            $this->cleanOldLogs();

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $executionTime = round((microtime(true) - $startTime), 2);

            // Ghi log lỗi
            $this->writeLog("==========================================");
            $this->writeLog("ERROR: Monthly report failed");
            $this->writeLog("Error message: " . $e->getMessage());
            $this->writeLog("Error file: " . $e->getFile());
            $this->writeLog("Error line: " . $e->getLine());
            $this->writeLog("Execution time: {$executionTime} seconds");
            $this->writeLog("Trace: " . $e->getTraceAsString());
            $this->writeLog("==========================================");

            Log::error('Monthly report failed: ' . $e->getMessage());
            $this->error('Failed to send report: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }

    /**
     * Ghi log vào file riêng
     */
    private function writeLog($message, $extraData = [])
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$message}";

        if (!empty($extraData)) {
            $logMessage .= " | " . json_encode($extraData, JSON_PRETTY_PRINT);
        }

        // Ghi vào file log riêng
        file_put_contents($this->logFile, $logMessage . PHP_EOL, FILE_APPEND);

        // Nếu muốn ghi cả vào laravel log
        // Log::channel('daily')->info($message);
    }

    /**
     * Lưu backup nội dung report vào file
     */
    private function saveReportBackup($reportContent, $reportData)
    {
        $backupFile = $this->logPath . '/report_content_' . now()->format('Y-m-d') . '.txt';
        $content = "REPORT BACKUP - " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= str_repeat("=", 70) . "\n";
        $content .= $reportContent;
        $content .= "\n\n" . str_repeat("=", 70) . "\n";
        $content .= "END OF BACKUP\n";

        file_put_contents($backupFile, $content);
        $this->writeLog("INFO: Report backup saved to: " . $backupFile);
    }

    /**
     * Xóa log cũ hơn số ngày quy định
     */
    private function cleanOldLogs($daysToKeep = 90)
    {
        $this->writeLog("INFO: Cleaning old logs (keeping {$daysToKeep} days)");

        $files = glob($this->logPath . '/report_*.log');
        $now = now();
        $deletedCount = 0;

        foreach ($files as $file) {
            $fileTime = filemtime($file);
            $fileDate = Carbon::createFromTimestamp($fileTime);

            if ($fileDate->diffInDays($now) > $daysToKeep) {
                unlink($file);
                $deletedCount++;
            }
        }

        // Xóa file backup cũ
        $backupFiles = glob($this->logPath . '/report_content_*.txt');
        foreach ($backupFiles as $file) {
            $fileTime = filemtime($file);
            $fileDate = Carbon::createFromTimestamp($fileTime);

            if ($fileDate->diffInDays($now) > $daysToKeep) {
                unlink($file);
                $deletedCount++;
            }
        }

        $this->writeLog("INFO: Cleaned {$deletedCount} old log files");
    }

    // Các hàm gatherReportData, getMembershipData, etc. giữ nguyên như code trước
    private function gatherReportData()
    {
        // ... (giữ nguyên code từ previous response)
        return [
            'membership' => $this->getMembershipData(),
            'guidance' => $this->getGuidanceData(),
            'job_support' => $this->getJobSupportData(),
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'report_month' => now()->format('F Y'),
            'applications_by_date' => $this->getApplicationsByDate()
        ];
    }

    private function getMembershipData()
    {
        // ... (giữ nguyên code)
        return [
            'trainee_users' => DB::table('trainee_users')->count(),
            'cgo_users' => DB::table('cgo_users')->count(),
            'admin_users' => DB::table('admin_users')->count(),
            'companies' => DB::table('companies')->count(),
            'company_recruiters' => DB::table('company_recruiters')->count(),
            'total_members' => DB::table('trainee_users')->count() +
                DB::table('cgo_users')->count() +
                DB::table('admin_users')->count(),
            'new_this_month' => [
                'trainee_users' => DB::table('trainee_users')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'companies' => DB::table('companies')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ]
        ];
    }

    private function getGuidanceData()
    {
        // ... (giữ nguyên code)
        return [
            'completed_counselings' => DB::table('cgo_counselings')->where('status', 3)->count(),
            'cancelled_counselings' => DB::table('cgo_counselings')->where('status', 4)->count(),
            'total_counselings' => DB::table('cgo_counselings')->count(),
            'this_month' => [
                'completed' => DB::table('cgo_counselings')
                    ->where('status', 3)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'cancelled' => DB::table('cgo_counselings')
                    ->where('status', 4)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ]
        ];
    }

    private function getJobSupportData()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        return [
            'jobs' => [
                'total' => DB::table('jobs')->count(),
                'active' => DB::table('jobs')->where('status', 1)->count(),
                'pending' => DB::table('jobs')->where('status', 0)->count(),
                'rejected' => DB::table('jobs')->where('status', 2)->count(),
                'this_month' => DB::table('jobs')
                    ->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->count(),
                'applications_starting_this_month' => DB::table('jobs')
                    ->where('application_starttime', '<=', $endOfMonth)
                    ->where('application_endtime', '>=', $startOfMonth)
                    ->where('status', 1)
                    ->count(),
                'applications_ending_this_month' => DB::table('jobs')
                    ->whereMonth('application_endtime', $now->month)
                    ->whereYear('application_endtime', $now->year)
                    ->where('status', 1)
                    ->count(),
            ],
            'o_j_t_s' => [
                'total' => DB::table('o_j_t_s')->count(),
                'active' => DB::table('o_j_t_s')->where('status', 1)->count(),
                'pending' => DB::table('o_j_t_s')->where('status', 0)->count(),
                'rejected' => DB::table('o_j_t_s')->where('status', 2)->count(),
                'this_month' => DB::table('o_j_t_s')
                    ->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->count(),
                'applications_starting_this_month' => DB::table('o_j_t_s')
                    ->where('application_starttime', '<=', $endOfMonth)
                    ->where('application_endtime', '>=', $startOfMonth)
                    ->where('status', 1)
                    ->count(),
            ],
            'trainee_applies' => [
                'job_match' => DB::table('trainee_applies')->where('apply_type', 'job_match')->count(),
                'apply' => DB::table('trainee_applies')->where('apply_type', 'apply')->count(),
                'total' => DB::table('trainee_applies')->count(),
                'this_month' => DB::table('trainee_applies')
                    ->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->count(),
                'successful' => DB::table('trainee_applies')->whereNotNull('employeed')->count(),
            ],
            'ojt_trainee_applies' => [
                'job_match' => DB::table('ojt_trainee_applies')->where('apply_type', 'job_match')->count(),
                'apply' => DB::table('ojt_trainee_applies')->where('apply_type', 'apply')->count(),
                'total' => DB::table('ojt_trainee_applies')->count(),
                'this_month' => DB::table('ojt_trainee_applies')
                    ->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->count(),
                'successful' => DB::table('ojt_trainee_applies')->whereNotNull('employeed')->count(),
            ]
        ];
    }

    private function getApplicationsByDate()
    {
        $now = Carbon::now();

        return [
            'jobs_starting_next_30_days' => DB::table('jobs')
                ->where('application_starttime', '>=', $now)
                ->where('application_starttime', '<=', $now->copy()->addDays(30))
                ->where('status', 1)
                ->select('title', 'application_starttime', 'application_endtime')
                ->limit(10)
                ->get(),
            'jobs_ending_next_30_days' => DB::table('jobs')
                ->where('application_endtime', '>=', $now)
                ->where('application_endtime', '<=', $now->copy()->addDays(30))
                ->where('status', 1)
                ->select('title', 'application_endtime')
                ->limit(10)
                ->get(),
            'ojt_starting_next_30_days' => DB::table('o_j_t_s')
                ->where('application_starttime', '>=', $now)
                ->where('application_starttime', '<=', $now->copy()->addDays(30))
                ->where('status', 1)
                ->select('title', 'application_starttime', 'application_endtime')
                ->limit(10)
                ->get(),
        ];
    }

    private function generateReportContent($data)
    {
        // ... (giữ nguyên generateReportContent từ previous response)
        $content = "MONTHLY REPORT - {$data['report_month']}\n";
        $content .= "Generated: {$data['generated_at']}\n";
        $content .= str_repeat("=", 70) . "\n\n";

        // Membership Section
        $content .= "MEMBERSHIP STATISTICS\n";
        $content .= str_repeat("-", 50) . "\n";
        $content .= sprintf("%-25s: %10s\n", "Trainee Users", number_format($data['membership']['trainee_users']));
        $content .= sprintf("%-25s: %10s\n", "CGO Users", number_format($data['membership']['cgo_users']));
        $content .= sprintf("%-25s: %10s\n", "Admin Users", number_format($data['membership']['admin_users']));
        $content .= sprintf("%-25s: %10s\n", "Companies", number_format($data['membership']['companies']));
        $content .= sprintf("%-25s: %10s\n", "Company Recruiters", number_format($data['membership']['company_recruiters']));
        $content .= sprintf("%-25s: %10s\n", "Total Members", number_format($data['membership']['total_members']));
        $content .= sprintf("%-25s: %10s\n", "New Trainees (This Month)", number_format($data['membership']['new_this_month']['trainee_users']));
        $content .= sprintf("%-25s: %10s\n\n", "New Companies (This Month)", number_format($data['membership']['new_this_month']['companies']));

        // Guidance Section
        $content .= "GUIDANCE STATISTICS\n";
        $content .= str_repeat("-", 50) . "\n";
        $content .= sprintf("%-25s: %10s\n", "Completed Counselings", number_format($data['guidance']['completed_counselings']));
        $content .= sprintf("%-25s: %10s\n", "Cancelled Counselings", number_format($data['guidance']['cancelled_counselings']));
        $content .= sprintf("%-25s: %10s\n", "Total Counselings", number_format($data['guidance']['total_counselings']));
        $content .= sprintf("%-25s: %10s\n", "This Month - Completed", number_format($data['guidance']['this_month']['completed']));
        $content .= sprintf("%-25s: %10s\n\n", "This Month - Cancelled", number_format($data['guidance']['this_month']['cancelled']));

        // Job Support Section
        $content .= "JOB SUPPORT STATISTICS\n";
        $content .= str_repeat("-", 50) . "\n";

        $content .= "JOBS:\n";
        $content .= sprintf("  %-23s: %10s\n", "Total Jobs", number_format($data['job_support']['jobs']['total']));
        $content .= sprintf("  %-23s: %10s\n", "Active (Status=1)", number_format($data['job_support']['jobs']['active']));
        $content .= sprintf("  %-23s: %10s\n", "Pending (Status=0)", number_format($data['job_support']['jobs']['pending']));
        $content .= sprintf("  %-23s: %10s\n", "Rejected (Status=2)", number_format($data['job_support']['jobs']['rejected']));
        $content .= sprintf("  %-23s: %10s\n", "New (This Month)", number_format($data['job_support']['jobs']['this_month']));
        $content .= sprintf("  %-23s: %10s\n", "Apps Starting This Month", number_format($data['job_support']['jobs']['applications_starting_this_month']));
        $content .= sprintf("  %-23s: %10s\n\n", "Apps Ending This Month", number_format($data['job_support']['jobs']['applications_ending_this_month']));

        $content .= "OJT:\n";
        $content .= sprintf("  %-23s: %10s\n", "Total OJTs", number_format($data['job_support']['o_j_t_s']['total']));
        $content .= sprintf("  %-23s: %10s\n", "Active (Status=1)", number_format($data['job_support']['o_j_t_s']['active']));
        $content .= sprintf("  %-23s: %10s\n", "Pending (Status=0)", number_format($data['job_support']['o_j_t_s']['pending']));
        $content .= sprintf("  %-23s: %10s\n", "Rejected (Status=2)", number_format($data['job_support']['o_j_t_s']['rejected']));
        $content .= sprintf("  %-23s: %10s\n", "New (This Month)", number_format($data['job_support']['o_j_t_s']['this_month']));
        $content .= sprintf("  %-23s: %10s\n\n", "Apps Starting This Month", number_format($data['job_support']['o_j_t_s']['applications_starting_this_month']));

        $content .= "TRAINEE APPLICATIONS:\n";
        $content .= sprintf("  %-23s: %10s\n", "Job Match", number_format($data['job_support']['trainee_applies']['job_match']));
        $content .= sprintf("  %-23s: %10s\n", "Direct Apply", number_format($data['job_support']['trainee_applies']['apply']));
        $content .= sprintf("  %-23s: %10s\n", "Total Applications", number_format($data['job_support']['trainee_applies']['total']));
        $content .= sprintf("  %-23s: %10s\n", "This Month", number_format($data['job_support']['trainee_applies']['this_month']));
        $content .= sprintf("  %-23s: %10s\n\n", "Successful", number_format($data['job_support']['trainee_applies']['successful'] ?? 0));

        $content .= "OJT TRAINEE APPLICATIONS:\n";
        $content .= sprintf("  %-23s: %10s\n", "Job Match", number_format($data['job_support']['ojt_trainee_applies']['job_match']));
        $content .= sprintf("  %-23s: %10s\n", "Direct Apply", number_format($data['job_support']['ojt_trainee_applies']['apply']));
        $content .= sprintf("  %-23s: %10s\n", "Total Applications", number_format($data['job_support']['ojt_trainee_applies']['total']));
        $content .= sprintf("  %-23s: %10s\n\n", "This Month", number_format($data['job_support']['ojt_trainee_applies']['this_month']));
        $content .= sprintf("  %-23s: %10s\n\n", "Successful", number_format($data['job_support']['ojt_trainee_applies']['successful'] ?? 0));
        // Upcoming Applications Section
        $content .= "UPCOMING APPLICATIONS (Next 30 Days)\n";
        $content .= str_repeat("-", 50) . "\n";

        if ($data['applications_by_date']['jobs_starting_next_30_days']->count() > 0) {
            $content .= "Jobs Starting:\n";
            foreach ($data['applications_by_date']['jobs_starting_next_30_days'] as $job) {
                $content .= sprintf("  • %s - Starts: %s\n",
                    $job->title,
                    Carbon::parse($job->application_starttime)->format('Y-m-d')
                );
            }
        }

        if ($data['applications_by_date']['jobs_ending_next_30_days']->count() > 0) {
            $content .= "\nJobs Ending Soon:\n";
            foreach ($data['applications_by_date']['jobs_ending_next_30_days'] as $job) {
                $content .= sprintf("  • %s - Ends: %s\n",
                    $job->title,
                    Carbon::parse($job->application_endtime)->format('Y-m-d')
                );
            }
        }

        $content .= "\n" . str_repeat("=", 70) . "\n";
        $content .= "End of Report - " . now()->format('Y-m-d H:i:s') . "\n";

        return $content;
    }
}
