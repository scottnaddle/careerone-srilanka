<?php

namespace App\Console\Commands;

use App\Models\CgoUser;
use App\Mail\CgoInactiveReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendInactiveCgoReminder extends Command
{
    protected $signature = 'cgo:send-inactive-reminder
                            {--days=30 : Number of days inactive}
                            {--dry-run : Run without actually sending emails}';

    protected $description = 'Send reminder emails to CGOs who haven\'t logged in for X days';

    public function handle()
    {
        $days = (int) $this->option('days');
        $isDryRun = $this->option('dry-run');

        $this->info("Checking CGOs inactive for >= {$days} days...");

        // Get the list of CGOs who have not logged in within the last $days days
        // AND have not been sent a reminder in the past 7 days
        $inactiveCgos = CgoUser::where(function($query) use ($days) {
            $query->where('last_login_at', '<', Carbon::now()->subDays($days))
                ->orWhereNull('last_login_at'); // Never logged in
        })
            ->where(function($query) {
                $query->whereNull('last_login_reminder_sent_at')
                    ->orWhere('last_login_reminder_sent_at', '<', Carbon::now()->subDays(7));
            })
            ->get();

        $count = $inactiveCgos->count();
        $this->info("Found {$count} inactive CGOs");

        if ($count === 0) {
            $this->info("No inactive CGOs to notify.");
            return Command::SUCCESS;
        }

        if ($isDryRun) {
            $this->warn("DRY RUN MODE - No emails will be sent");
            foreach ($inactiveCgos as $cgo) {
                $lastLogin = $cgo->last_login_at ?? 'Never';
                $this->line("- {$cgo->email} (Last login: {$lastLogin})");
            }
            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($count);
        $sentCount = 0;

        foreach ($inactiveCgos as $cgo) {
            try {
                // Calculate the actual number of inactive days
                $inactiveDays = $cgo->last_login_at
                    ? Carbon::parse($cgo->last_login_at)->diffInDays(now())
                    : $days;

                // Send the email
                Mail::to($cgo->email)->send(new CgoInactiveReminder($cgo, $inactiveDays));

                // Update the time the reminder was sent
                $cgo->update(['last_login_reminder_sent_at' => now()]);

                $sentCount++;
                Log::channel('cgo_reminder')->info("Sent inactive reminder to CGO: {$cgo->email}");

            } catch (\Exception $e) {
                Log::channel('cgo_reminder')->error("Failed to send reminder to {$cgo->email}: " . $e->getMessage());
                $this->error("\nFailed: {$cgo->email}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully sent {$sentCount} reminders out of {$count}");

        return Command::SUCCESS;
    }
}
