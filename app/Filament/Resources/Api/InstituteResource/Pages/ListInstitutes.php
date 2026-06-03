<?php
namespace App\Filament\Resources\Api\InstituteResource\Pages;

use App\Filament\Resources\Api\InstituteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use App\Services\Admin\api\ExternalApiService;
use App\Models\Institute;
use App\Models\TvetType;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ListInstitutes extends ListRecords
{
    protected static string $resource = InstituteResource::class;
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
        ->extraAttributes([
            'class' => 'text-sm text-gray-600 block mt-2',
            'style' => 'cursor: default; background: none; border: none; padding: 0;  color: black;'
        ])
        ->disabled(),
        Actions\Action::make('syncApi')
            ->label('Sync API')
            ->action(function () {
                $this->syncApi();
            })
            ->color('primary')
            ->requiresConfirmation()
            ->modalHeading('Confirm Sync API')
            ->modalSubheading('Are you sure you want to sync the institute data from the API?')
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
            $this->syncHeadOffices($apiService);
            $this->syncInstitutes($apiService);
            $this->lastSyncTime = $this->getLastSyncTimeFromDatabase();
            $this->sendNotification('Data synced successfully!', 'success');
        } catch (NotFoundHttpException $e) {
            \Log::error('Send notification error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->sendNotification('An error occurred: ' . $e->getMessage(), 'danger');
        } finally {
            $this->isSyncing = false;
            $this->showSyncModal = false;
        }
    }

    protected function syncHeadOffices(ExternalApiService $apiService)
    {
        // $headOfficesData = $apiService->getApiDataHeadOffices();

        // if (is_array($headOfficesData)) {
        //     foreach ($headOfficesData as $headOffice) {
        //         if (is_array($headOffice)) {
        //             TvetType::updateOrInsert(
        //                 ['head_office_code' => $headOffice['message']['HEAD_OFFICE_CODE']],
        //                 ['head_office_name' => $headOffice['message']['HEAD_OFFICE_NAME']]
        //             );
        //         } else {
        //             throw new Exception('Invalid head office data format.');
        //         }
        //     }
        //     TvetType::updateOrInsert(
        //         ['head_office_code' => 'WOHO'],
        //         ['head_office_name' => 'Without Head Office',
        //            'created_at'=>now(),],
        //     );
        // } else {
        //     throw new Exception('Invalid data format received for head offices.');
        // }
    }

    protected function syncInstitutes(ExternalApiService $apiService)
    {
        $instituteData = $apiService->getApiDataInstitute();

        if (is_array($instituteData)) {
            foreach ($instituteData as $institute) {
                Institute::updateOrInsert(
                    ['reg_no' => $institute['message']['INSTITUTE_REG_NO']],
                    [
                        'name' => $institute['message']['INSTITUTE_NAME'],
                        'dist_id' => $institute['message']['DISTRICT_CODE'],
                        'district_name' => $institute['message']['DISTRICT_NAME'],
                        'address' => $institute['message']['ADDRESS'],
                        'phone' => $institute['message']['TELEPHONE'],
                        'valid_from' => $institute['message']['VALID_FROM'],
                        'valid_to' => $institute['message']['VALID_TO'],
                        'ownership' => $institute['message']['OWNERSHIP'],
                        'active_status' => $institute['message']['ACTIVE_STATUS'],
                        'institute_head_office' => $institute['message']['INSTITUTE_HEAD_OFFICE'] ?? 'WOHO',
                        'created_at'=>now(),
                    ]
                );
            }
        } else {
            throw new Exception('Invalid data format received for institutes.');
        }
    }

    protected function sendNotification(string $message, string $type = 'info')
    {
        $notification = Notification::make()->title($message);

        switch ($type) {
            case 'success':
                $notification->success();
                break;
            case 'danger':
                $notification->danger();
                break;
            default:
                $notification->info();
                break;
        }

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
        $latestInstitute = Institute::query()->latest('created_at')->first();
        return !empty($latestInstitute->created_at) ? $latestInstitute->created_at->format('Y-m-d H:i:s') : null;
    }
}
