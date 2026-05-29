<?php

namespace App\Filament\Resources\Api\NVQCoursesResource\Pages;

use App\Filament\Resources\Api\NVQCoursesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use App\Services\Admin\api\ExternalApiService;
use Exception;
use App\Models\NvqCourses;

class ListNVQCourses extends ListRecords
{
    protected static string $resource = NVQCoursesResource::class;
    public ?string $lastSyncTime = null;
    public bool $isSyncing = false;
    public bool $showSyncModal = false;
    public function mount(): void
    {
        // Fetch and set the latest sync time on mount
        $this->lastSyncTime = $this->getLastSyncTimeFromDatabase();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('lastSyncTime')
            ->label($this->getLastSyncTimeText())
            ->color('red')
            ->extraAttributes(['style' =>'color:black'])
            ->disabled(),
            Actions\Action::make('syncApi')
                ->label('Sync API')
                ->action(fn() => $this->syncApi())
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Confirm Sync API')
                ->modalSubheading('Are you sure you want to sync the NVQ Courses data from the API?')
                ->modalButton('Yes, Sync')
                ->disabled($this->isSyncing),
        ];
    }

    protected function syncApi()
    {
        $this->isSyncing = true;
        $this->showSyncModal = true;

        $this->sendNotification('Syncing data from API...');

        try {
            $apiService = app(ExternalApiService::class);
            $this->syncNVQCourse($apiService);
            $this->lastSyncTime = $this->getLastSyncTimeFromDatabase();
            $this->sendNotification('Data synced successfully!', 'success');
        } catch (\Exception $e) {
            $this->sendNotification('An error occurred: ' . $e->getMessage(), 'danger');
        } finally {
            $this->isSyncing = false;
            $this->showSyncModal = false;
        }
    }

    protected function syncNVQCourse(ExternalApiService $apiService)
    {
        $nvqCoursesData = $apiService->getApiDataNVQCOURSES();
        if ($nvqCoursesData && is_array($nvqCoursesData)) {
            foreach ($nvqCoursesData as $nvqCourse) {
                if (is_array($nvqCourse)) {
                    NvqCourses::updateOrInsert(
                        ['course_id' => $nvqCourse['message']['COURSE_ID']],
                        [
                            'course_name' => $nvqCourse['message']['COURSE_NAME'],
                            'level' => $nvqCourse['message']['NVQ_LEVELS'],
                            'ncs_code' => $nvqCourse['message']['NCS_CODE'],
                            'ncs_name' => $nvqCourse['message']['NCS_NAME'],
                            'reg_no' => $nvqCourse['message']['INSTITUTE_REG_NO'],
                            'industry_sector' => $nvqCourse['message']['INDUSTRY_SECTOR'] ?? '',
                            'created_at'=>now()
                        ]
                    );
                } else {
                    throw new \Exception('Invalid NVQ Courses data format.');
                }
            }
        } else {
            throw new \Exception('Invalid data format received for NVQ Courses.');
        }
    }

    protected function sendNotification(string $message, string $type = 'info')
    {
        $notification = Notification::make()->title($message);

        match($type) {
            'success' => $notification->success(),
            'danger' => $notification->danger(),
            default => $notification->info(),
        };

        $notification->send();
    }

    protected function getModals(): array
    {
        return [
            'syncModal' => [
                'visible' => $this->showSyncModal,
                'heading' => 'Syncing in progress...',
                'description' => 'Please wait while the data is being synchronized.',
                'buttonLabel' => 'Syncing...',
                'disabled' => true,
            ],
        ];
    }
    protected function getLastSyncTimeText(): string
    {
        return $this->lastSyncTime
            ? "Last synced on: {$this->lastSyncTime}"
            : "Data not synced yet";
    }
    protected function getLastSyncTimeFromDatabase(): ?string
    {
        return NvqCourses::query()
            ->latest('created_at')
            ->value('created_at')?->format('Y-m-d H:i:s');
    }
    
}