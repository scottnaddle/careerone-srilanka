<?php

namespace App\Filament\Resources\ComapnyUserListResource\Pages;

use App\Filament\Resources\ComapnyUserListResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Services\Cgo\NotificationManager as NotificationManagerCgo;
use Filament\Support\Colors\Color;

class ViewComapnyUserList extends ViewRecord
{
    protected static string $resource = ComapnyUserListResource::class;
    protected NotificationManagerCgo $notificationManagerCgo;
    protected static string $view = 'filament.pages.membership.company.company-recruiter-details';

    public function __construct()
    {
        $this->notificationManagerCgo = app(NotificationManagerCgo::class);
    }

    protected function getHeaderActions(): array
    {
        $actions = [];
        if (auth('admin')->user()->hasRole('super_admin') || auth('admin')->user()->hasRole('naita_admin')) {
            $isApprovalPending = is_null($this->record->verify_at);

            if ($isApprovalPending) {
                $actions[] = Actions\Action::make('approve')
                    ->label(trans('system.form.button.approve'))
                    ->color('primary')
//                    ->icon('heroicon-s-check')
                    ->requiresConfirmation()
                    ->action(function () {
                        $this->record->update([
                            'verify_at' => now(),
                            'verify_by' => auth('admin')->user()->id,
                        ]);
                        $this->notificationManagerCgo->sendMembershipApprovalEmail($this->record);
                        Notification::make()
                            ->title(trans("admin/performance.Approved successfully!"))
                            ->success()
                            ->send();

                        return redirect()->route('filament.admin.resources.company-recruiter-approvals.index');
                    })->extraAttributes([
                        'class' => 'action-btn-bottom'
                    ]);
            }
//            $canReject = (is_null($this->record->verify_at) && is_null($this->record->verify_by)) || (!is_null($this->record->verify_at) && !is_null($this->record->verify_by));
            $canReject = is_null($this->record->verify_at) === is_null($this->record->verify_by);

            if ($canReject) {
                $actions[] = Actions\Action::make('reject')
                    ->label(__('admin/performance.Withdrawal'))
                    ->color(Color::hex('#d1d5db'))
                    ->form([
                        Textarea::make('reason')
                            ->rows(10)
                            ->cols(20)
                            ->required(),
                    ])
                    ->action(function ($data) {

                        $this->record->update([
                            'verify_at' => null,
                            'verify_by' => auth('admin')->user()->id,
                            'active' => 0,
                            'reason' => $data['reason'],
                        ]);
                        $this->notificationManagerCgo->sendMembershipBlockEmail($this->record,$data['reason']);

                        Notification::make()
                            ->title(trans("admin/performance.Rejected successfully!"))
                            ->success()
                            ->send();

                        return redirect()->route('filament.admin.resources.company-recruiter-approvals.index');
                    })->extraAttributes([
                        'class' => 'action-btn-bottom',
                        'style' => 'color: #374151 !important'
                    ]);
            }
            $canactive = $this->record->UserReActive()->whereNull('reactive_account_requests.confirmed_at')->first();

            if ($canactive) {
                $actions[] = Actions\Action::make('approve')
                ->label(__('admin/performance.Approve Active'))
                ->color('primary')
//                ->requiresConfirmation()
                ->action(function () {
                    $updatedRows1 = $this->record->UserReActive()
                        ->whereNull('confirmed_at')
                        ->update([
                            'confirmed_at' => now(),
                        ]);
                    $updatedRows2 = $this->record
                        ->update([
                            'verify_at' => now(),
                            'verify_by' => auth()->guard('admin')->id(),
                            'active' => true,
                        ]);
                    if ($updatedRows1 > 0 && $updatedRows2) {
                        Notification::make()
                            ->title(trans("admin/performance.Approved successfully!"))
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('No records to approve!')
                            ->warning()
                            ->send();
                    }
                    $this->redirectRoute('filament.admin.resources.user-re-actives.index', [
                        'tableFilters' => [
                            'approval' => [
                                'value' => 'requested'
                            ]
                        ]
                    ]);
                });

            }

        }
        return $actions;

    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

}
