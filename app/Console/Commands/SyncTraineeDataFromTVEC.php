<?php

namespace App\Console\Commands;

use App\Models\TraineeUser;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncTraineeDataFromTVEC extends Command
{
    /**
     * The command name used to run it.
     *
     * @var string
     */
    protected $signature = 'app:sync-trainee-data-from-tvec';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Synchronize trainee data from TVEC.';

    protected $traineeSyncService;

    /**
     * Initialize the command with TraineeTrainingSyncService.
     */
    public function __construct(TraineeTrainingSyncService $traineeSyncService)
    {
        parent::__construct();
        $this->traineeSyncService = $traineeSyncService;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        \Log::channel('sync_trainee')->info('🔄 Starting synchronization from TVEC for trainee...');
        $this->info('🔄 Starting synchronization from TVEC for trainee...');

        // Increase the memory and execution time limits (if needed).
        ini_set('memory_limit', '-1'); // No memory limit
        set_time_limit(0);             // No execution time limit

        $totalUsers = TraineeUser::count();
        $this->info("📊 Total Trainee Users: $totalUsers");
        \Log::channel('sync_trainee')->info("📊 Total Trainee Users: $totalUsers");

        // Use cursor() to iterate record by record to optimize memory usage
        TraineeUser::select('id', 'nic') // Only fetch the necessary columns
        ->orderBy('id')
            ->cursor()
            ->each(function ($user) {
                try {
                    // Call the sync method from TraineeSyncService
                    $this->traineeSyncService->syncTraineeTrainingInformation($user);
                    $this->info("✅ Synched successfully: {$user->nic}");
                    \Log::channel('sync_trainee')->info("✅ Synched successfully: {$user->nic}");
                } catch (\Exception $e) {
                    // Log the detailed error
                    Log::channel('sync_trainee')->error("❌ Error syncing user {$user->id}: " . $e->getMessage());
                    $this->error("❌ Error syncing user {$user->id}: " . $e->getMessage());
                }
            });

        $this->info('✅ Synchronization from TVEC completed.');
        \Log::channel('sync_trainee')->info('✅ Synchronization from TVEC completed.');
    }
}
