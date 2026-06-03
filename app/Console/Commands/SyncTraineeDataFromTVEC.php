<?php

namespace App\Console\Commands;

use App\Models\TraineeUser;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncTraineeDataFromTVEC extends Command
{
    /**
     * Tên command dùng để chạy.
     *
     * @var string
     */
    protected $signature = 'app:sync-trainee-data-from-tvec';

    /**
     * Mô tả command.
     *
     * @var string
     */
    protected $description = 'Synchronize trainee data from TVEC.';

    protected $traineeSyncService;

    /**
     * Khởi tạo command với TraineeTrainingSyncService.
     */
    public function __construct(TraineeTrainingSyncService $traineeSyncService)
    {
        parent::__construct();
        $this->traineeSyncService = $traineeSyncService;
    }

    /**
     * Thực thi command.
     */
    public function handle()
    {
        \Log::info('🔄 Starting synchronization from TVEC for trainee...');
        $this->info('🔄 Starting synchronization from TVEC for trainee...');

        // Tăng giới hạn bộ nhớ và thời gian thực thi (nếu cần).
        ini_set('memory_limit', '-1'); // Không giới hạn bộ nhớ
        set_time_limit(0);             // Không giới hạn thời gian chạy

        $totalUsers = TraineeUser::count();
        $this->info("📊 Total Trainee Users: $totalUsers");
        \Log::info("📊 Total Trainee Users: $totalUsers");

        // Sử dụng cursor() để duyệt từng bản ghi giúp tối ưu bộ nhớ
        TraineeUser::select('id', 'nic') // Chỉ lấy các cột cần thiết
        ->orderBy('id')
            ->cursor()
            ->each(function ($user) {
                try {
                    // Gọi hàm đồng bộ từ TraineeSyncService
                    $this->traineeSyncService->syncTraineeTrainingInformation($user);
                    $this->info("✅ Synched successfully: {$user->nic}");
                    \Log::info("✅ Synched successfully: {$user->nic}");
                } catch (\Exception $e) {
                    // Ghi log lỗi chi tiết
                    Log::error("❌ Error syncing user {$user->id}: " . $e->getMessage());
                    $this->error("❌ Error syncing user {$user->id}: " . $e->getMessage());
                }
            });

        $this->info('✅ Synchronization from TVEC completed.');
        \Log::info('✅ Synchronization from TVEC completed.');
    }
}
