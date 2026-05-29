<?php

namespace App\Filament\Resources\HeadOfficeResource\Pages;

use App\Filament\Resources\HeadOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\TvetType;
use App\Services\Admin\api\ExternalApiService;
use Filament\Notifications\Notification;
class ListHeadOffices extends ListRecords
{
    protected static string $resource = HeadOfficeResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
    public function getBreadcrumbs(): array
    {
        return [];
    }
    public function getTitle(): string
    {
        return 'Head Office';
    }
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
            ->color('yellow')
            ->extraAttributes(['class' =>'text-gray-900'])
            ->disabled(),
            Actions\Action::make('syncApi')
                ->label('Sync API')
                ->action(fn() => $this->syncApi())
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Confirm Sync API')
                ->modalSubheading('Are you sure you want to sync the Head Office data from the API?')
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
            $this->syncHeadOffice($apiService);
            $this->lastSyncTime = $this->getLastSyncTimeFromDatabase();
            $this->sendNotification('Data synced successfully!', 'success');
        } catch (\Exception $e) {
            $this->sendNotification('An error occurred: ' . $e->getMessage(), 'danger');
        } finally {
            $this->isSyncing = false;
            $this->showSyncModal = false;
        }
    }

    protected function syncHeadOffice(ExternalApiService $apiService)
    {
        $headOffice = $apiService->getApiDataHeadOffices();
        if ($headOffice) {
            if (is_array($headOffice)) {
                TvetType::updateOrInsert(
                    ['head_office_code' =>'TVEC'],
                    [
                        'head_office_name' => 'Tertiary & Vocational Education Commission',
                    ]
                );
                foreach ($headOffice as $headOffice) {
                    if (is_array($headOffice)) {
                        TvetType::updateOrInsert(
                            ['head_office_code' => $headOffice['message']['HEAD_OFFICE_CODE']],
                            [
                                'head_office_name' => $headOffice['message']['HEAD_OFFICE_NAME'],
                            ]
                        );
                    } else {
                        $this->error('Invalid head office data format.');
                    }
                }
                TvetType::updateOrInsert(
                   ['head_office_code' =>'WOHO'],
                   [
                       'head_office_name' => 'Without Head Office',
                   ]
               );
                // $this->info('Head office data synced successfully');
            } else {
                $this->error('Invalid data format received from API.');
            }
        } else {
            $this->error('No data received from API or invalid response structure.');
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
        $latestNVQCourese = TvetType::query()->latest('created_at')->first();
        return !empty($latestNVQCourese->created_at) ? $latestNVQCourese->created_at->format('Y-m-d H:i:s') : null;
    }
}
