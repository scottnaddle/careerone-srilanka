<?php

namespace App\Filament\Resources\Api\PackagesResource\Pages;

use App\Filament\Resources\Api\PackagesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use App\Services\Admin\api\ExternalApiService;
use Exception;
use App\Models\NvqCourses;
use App\Models\NVQLevel;
class ListPackages extends ListRecords
{
    protected static string $resource = PackagesResource::class;

    public bool $isSyncing = false;
    public bool $showSyncModal = false;
    public ?string $lastSyncTime = null;
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
            ->color('yellow')
            ->extraAttributes(['class' =>'text-gray-900'])
            ->disabled(),
            Actions\Action::make('syncApi')
                ->label('Sync API')
                ->action(fn() => $this->syncApi())
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Confirm Sync API')
                ->modalSubheading('Are you sure you want to sync the NVQ Level data from the API?')
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
            $this->syncPackages($apiService);
            $this->lastSyncTime = $this->getLastSyncTimeFromDatabase();
            $this->sendNotification('Data synced successfully!', 'success');
        } catch (\Exception $e) {
            $this->sendNotification('An error occurred: ' . $e->getMessage(), 'danger');
        } finally {
            $this->isSyncing = false;
            $this->showSyncModal = false;
        }
    }

    protected function syncPackages(ExternalApiService $apiService)
    {
        $packagesData = $apiService->getApiDataPACKAGES();
        
        if (!is_array($packagesData)) {
            throw new \Exception('Invalid data format received from API.');
        }

        foreach ($packagesData as $package) {
            if (is_array($package) && isset($package['message'])) {
                NVQLevel::updateOrInsert(
                    ['code' => $package['message']['PACKAGE_CODE']],
                    [
                        'name' => $package['message']['PACKAGE_NAME'],
                        'version' => $package['message']['PACKAGE_VERSION'],
                        'level' => $package['message']['PACKAGE_LEVEL'],
                        'ncs_code' => $package['message']['NCS_CODE'],
                        'ncs_name' => $package['message']['NCS_NAME'],
                    ]
                );
            } else {
                throw new \Exception('Invalid NVQ package data format.');
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
    protected function getLastSyncTimeText(): string
    {
        return $this->lastSyncTime
            ? "Last synced on: {$this->lastSyncTime}"
            : "Data not synced yet";
    }
    protected function getLastSyncTimeFromDatabase(): ?string
    {
        $latestNVQLevel = NVQLevel::query()->latest('created_at')->first();
        return !empty($latestNVQLevel->created_at) ? $latestNVQLevel->created_at->format('Y-m-d H:i:s') : null;
    }
}