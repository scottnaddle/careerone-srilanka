<?php

namespace App\Filament\Resources\Api\REQCoursesResource\Pages;

use App\Filament\Resources\Api\REQCoursesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use App\Services\Admin\api\ExternalApiService;
use Exception;
use App\Models\ReqCourse;
class ListREQCourses extends ListRecords
{
    protected static string $resource = REQCoursesResource::class;

    public bool $isSyncing = false;
    public bool $showSyncModal = false;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('syncApi')
                ->label('Sync API')
                ->action(fn() => $this->syncApi())
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Confirm Sync API')
                ->modalSubheading('Are you sure you want to sync the REQ Courses data from the API?')
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
            $this->syncRegCourses($apiService);
            $this->sendNotification('Data synced successfully!', 'success');
        } catch (\Exception $e) {
            $this->sendNotification('An error occurred: ' . $e->getMessage(), 'danger');
        } finally {
            $this->isSyncing = false;
            $this->showSyncModal = false;
        }
    }

    protected function syncRegCourses(ExternalApiService $apiService)
    {
        $regCoursesData = $apiService->getApiDataREGCOURSES();

        if (!is_array($regCoursesData)) {
            throw new \Exception('Invalid data format received from API.');
        }

        foreach ($regCoursesData as $course) {
            if (is_array($course) && isset($course['message'])) {
                ReqCourse::updateOrInsert(
                    ['course_id' => $course['message']['COURSE_ID']],
                    [
                        'institute_reg_no' => $course['message']['INSTITUTE_REG_NO'],
                        'institute_name' => $course['message']['INSTITUTE_NAME'],
                        'district_code' => $course['message']['DISTRICT_CODE'],
                        'course_name' => $course['message']['COURSE_NAME'],
                        'course_duration' => $course['message']['COURSE_DURATION'],
                        'course_mode' => $course['message']['COURSE_MODE'],
                        'course_medium' => $course['message']['COURSE_MEDIUM'],
                        'entry_qualification' => $course['message']['ENTRY_QUALIFICATION'],
                        'industry_sector' => $course['message']['INDUSTRY_SECTOR'] ?? '',
                    ]
                );
            } else {
                throw new \Exception('Invalid course data format for course ID: ' . ($course['message']['COURSE_ID'] ?? 'Unknown'));
            }
        }
    }

    protected function sendNotification(string $message, string $type = 'info')
    {
        $notification = Notification::make()->title($message);

        match ($type) {
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
}