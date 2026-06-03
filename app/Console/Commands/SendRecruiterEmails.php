<?php
// App/Console/Commands/SendRecruiterEmails.php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Mail\RecruiterAccountCreated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendRecruiterEmails extends Command
{
    protected $signature = 'recruiters:send-emails
                            {--email= : Send email to specific recruiter email}
                            {--all : Send to all recruiters}
                            {--dry-run : Simulate sending without actually sending emails}';

    protected $description = 'Send account creation emails to recruiters with their passwords';

    // Mảng user đầy đủ
    private $staffList = [
        ['first_name' => 'Mr.H.A', 'last_name' => 'Ravindra', 'email' => 'haravindra2637@gmail.com', 'password' => 'Welcome_haravindra2637', 'phone' => '0714553768', 'district' => 'Colombo'],
        ['first_name' => 'Mr.G.G.N', 'last_name' => 'Pushpakumara', 'email' => 'ggnpkumara@gmail.com', 'password' => 'Welcome_ggnpkumara', 'phone' => '0714553800', 'district' => 'Colombo'],
        ['first_name' => 'Mr.W.M.M.P', 'last_name' => 'Sandaruwan', 'email' => 'malithnaita@gmail.com', 'password' => 'Welcome_malithnaita', 'phone' => '0719255716', 'district' => 'Colombo'],
        ['first_name' => 'Mr.R.K.G', 'last_name' => 'Rajakaruna', 'email' => 'krajakaruna@naita.edu.lk', 'password' => 'Welcome_krajakaruna', 'phone' => '0710921851', 'district' => 'Gampaha'],
        ['first_name' => 'Mrs.G.R', 'last_name' => 'Jesudasan', 'email' => 'generalprofgayu@gmail.com', 'password' => 'Welcome_generalprofgayu', 'phone' => '0772809431', 'district' => 'Gampaha'],
        ['first_name' => 'Mrs.K.A', 'last_name' => 'Nalika Nishanthi', 'email' => 'nalikanishanthi.naita@gmail.com', 'password' => 'Welcome_nalikanishanthi', 'phone' => '0714553798', 'district' => 'Gampaha'],
        ['first_name' => 'Mrs.K.K', 'last_name' => 'Nishshanka', 'email' => 'kumudininishshanka@gmail.com', 'password' => 'Welcome_kumudininishshanka', 'phone' => '0717459899', 'district' => 'Kurunegala'],
        ['first_name' => 'Mr.T.M.T.B', 'last_name' => 'Karunarathne', 'email' => 'ruwansaelectropower@gmail.com', 'password' => 'Welcome_ruwansaelectropower', 'phone' => '0714553749', 'district' => 'Kurunegala'],
        ['first_name' => 'Mrs.U.H.E.S', 'last_name' => 'Rathnayake', 'email' => 'sewwandir708@gmail.com', 'password' => 'Welcome_sewwandir708', 'phone' => '0717459427', 'district' => 'Kurunegala'],
        ['first_name' => 'Mr.Milan ', 'last_name' => 'Wickramasinghe', 'email' => 'milannaita1982@gmail.com', 'password' => 'Welcome_milannaita1982', 'phone' => '0710757704', 'district' => 'Kalutara'],
        ['first_name' => 'Mr.T.M', 'last_name' => 'Amarawansha', 'email' => 'tmamarawansha@gmail.com', 'password' => 'Welcome_tmamarawansha', 'phone' => '0718705361', 'district' => 'Kalutara'],
        ['first_name' => 'Mrs.M.A.L', 'last_name' => 'Hansikа', 'email' => 'lahirunih@gmail.com', 'password' => 'Welcome_lahirunih', 'phone' => '0711827253', 'district' => 'Kalutara'],
        ['first_name' => 'Mr. M.D.C', 'last_name' => 'Brashil', 'email' => 'pansilu74@gmail.com', 'password' => 'Welcome_pansilu74', 'phone' => '0718705366', 'district' => 'Galle'],
        ['first_name' => 'Mrs.M.P', 'last_name' => 'Wickramarachchi', 'email' => 'maneshapr@gmail.com', 'password' => 'Welcome_maneshapr', 'phone' => '0711192444', 'district' => 'Galle'],
        ['first_name' => 'Mrs.T.G.K', 'last_name' => 'Mangalika', 'email' => 'krishanthimangalika@gmail.com', 'password' => 'Welcome_krishanthimangalika', 'phone' => '0714562634', 'district' => 'Galle'],
        ['first_name' => 'Mr.A.C', 'last_name' => 'Saman Kumara', 'email' => 'anilsamankumara89@gmail.com', 'password' => 'Welcome_anilsamankumara89', 'phone' => '0718705321', 'district' => 'Kandy'],
        ['first_name' => 'Mr.S.A', 'last_name' => 'Meddewithana', 'email' => 'sanjeewa.naita@gmail.com', 'password' => 'Welcome_sanjeewa', 'phone' => '0717459807', 'district' => 'Kandy'],
        ['first_name' => 'Mr.M.W.M.P', 'last_name' => 'Wijesinghe', 'email' => 'pwijesinghe54@gmail.com', 'password' => 'Welcome_pwijesinghe54', 'phone' => '0710922111', 'district' => 'Kandy'],
        ['first_name' => 'Mr', 'last_name' => 'Yang', 'email' => 'skehsleh@gmail.com', 'password' => 'Welcome_skehsleh', 'phone' => '0710922000', 'district' => 'Colombo'],
    ];

    public function handle()
    {
        // Lấy company NAITA
        $company = Company::where('name', 'Organization_NAITA')->first();

        if (!$company) {
            $this->error("Company Organization_NAITA not found. Please run seeder first.");
            $this->info("Run: php artisan db:seed --class=NaitaRecruiterSeeder");
            return 1;
        }

        if ($this->option('email')) {
            // Gửi cho 1 email cụ thể
            $userData = $this->findUserByEmail($this->option('email'));
            if (!$userData) {
                $this->error("User not found in staff list: {$this->option('email')}");
                return 1;
            }

            $recruiter = CompanyRecruiter::where('email', $this->option('email'))->first();
            if (!$recruiter) {
                $this->error("Recruiter not found in database: {$this->option('email')}");
                return 1;
            }

            $this->sendEmail($recruiter, $userData['password']);

        } elseif ($this->option('all')) {
            // Gửi cho tất cả
            $successCount = 0;
            $failCount = 0;

            foreach ($this->staffList as $userData) {
                $recruiter = CompanyRecruiter::where('email', $userData['email'])->first();

                if (!$recruiter) {
                    $this->warn("Recruiter not found: {$userData['email']}");
                    $failCount++;
                    continue;
                }

                if ($this->sendEmail($recruiter, $userData['password'])) {
                    $successCount++;
                } else {
                    $failCount++;
                }

                // Delay để tránh rate limit
                usleep(500000); // 0.5 giây
            }

            $this->newLine();
            $this->info("========== SUMMARY ==========");
            $this->info("✓ Success: {$successCount}");
            $this->info("✗ Failed: {$failCount}");
            $this->info("Total: " . count($this->staffList));

        } else {
            $this->error("Please specify --email or --all option");
            $this->info("Usage:");
            $this->info("  - Send to one: php artisan recruiters:send-emails --email=user@example.com");
            $this->info("  - Send to all: php artisan recruiters:send-emails --all");
            $this->info("  - Dry run: php artisan recruiters:send-emails --all --dry-run");
            return 1;
        }

        return 0;
    }

    private function findUserByEmail($email)
    {
        foreach ($this->staffList as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }

    private function sendEmail($recruiter, $password)
    {
        if ($this->option('dry-run')) {
            $this->line("[DRY RUN] Would send email to: {$recruiter->email}");
            $this->line("  - Name: {$recruiter->first_name} {$recruiter->last_name}");
            $this->line("  - Password: {$password}");
            $this->line("  - Phone: {$recruiter->telephone}");
            return true;
        }

        try {
            Mail::to($recruiter->email)->send(new RecruiterAccountCreated($recruiter, $password));
            $this->info("✓ Email sent to: {$recruiter->email} ({$recruiter->first_name} {$recruiter->last_name})");
            return true;
        } catch (\Exception $e) {
            $this->error("✗ Failed to send email to: {$recruiter->email}");
            $this->error("  Error: " . $e->getMessage());
            return false;
        }
    }
}
