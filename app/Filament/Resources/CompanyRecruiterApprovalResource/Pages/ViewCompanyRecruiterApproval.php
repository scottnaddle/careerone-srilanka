<?php

namespace App\Filament\Resources\CompanyRecruiterApprovalResource\Pages;

use App\Filament\Resources\CompanyRecruiterApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use App\Services\Cgo\NotificationManager as NotificationManagerCgo;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconPosition;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Filament\Infolists\Components\TextEntry;

class ViewCompanyRecruiterApproval extends ViewRecord
{
    protected static string $resource = CompanyRecruiterApprovalResource::class;
    protected NotificationManagerCgo $notificationManagerCgo;
    protected static ?string $title = null;
    public function getTitle(): string|Htmlable {
        return trans('menu.company_recruiter');
    }

    public function __construct()
    {
        $this->notificationManagerCgo = app(NotificationManagerCgo::class);
    }

    protected function getHeaderActions(): array
    {
        $actions = [];
        $isApprovalPending =  is_null($this->record->verify_at) && is_null($this->record->verify_by);

        if ($isApprovalPending) {

            $actions[] = Actions\Action::make('reject')
            ->label(trans('admin/performance.Reject'))
            ->color(Color::hex('#d1d5db'))
            ->modalWidth('md')
            ->modalHeading(new HtmlString('
            <div class="bg-white w-full relative">
                <div class="mb-5 flex items-center justify-center" bis_skin_checked="1">
                    <div class="rounded-full fi-color-custom bg-custom-100 dark:bg-custom-500/20 fi-color-primary p-3" style="--c-100:var(--primary-100);--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" bis_skin_checked="1">
                        <!--[if BLOCK]><![endif]-->    <svg class="fi-modal-icon h-6 w-6 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
                        </svg><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <p class="text-center font-normal">'.trans("admin/performance.Please write the reason for non-approval").'
              </p>
            </div>
            <style>
            .fi-modal-header {
            width: 100% !important;
            flex-direction: column;
            display: flex;
            }
            .absolute.end-4.top-4 {
            display:none !important;
            }
</style>
            '))
//                ->modalContent(view('components.modal-reject'))
//            ->modalDescription('Please write the reason for non-approval')
//            ->modalIcon('heroicon-o-exclamation-triangle')
            ->modalIconColor('primary')

            ->iconPosition(IconPosition::After)
            ->modalCancelActionLabel(trans('system.form.button.cancel'))
            ->modalSubmitActionLabel(trans('system.form.button.confirm'))
            ->form([
                Textarea::make('reason')
                    ->label(false)
                    ->placeholder(trans("admin/performance.Please provide additional comments (optional)"))
                    ->rows(5)
                    ->extraAttributes([
                        'class' => 'rounded-md border-gray-300',
                        'style' => 'min-height: 120px; width: 100%;',
                    ]),
            ])
            ->modalFooterActionsAlignment('center')
            ->modalSubmitAction(fn($action) => $action->extraAttributes([
                'class' => 'border border-gray-300 bg-primary text-white block w-full rounded-xl text-center',
            ]))
            ->modalCancelAction(fn($action) => $action->extraAttributes([
                'class' => 'border text-gray-700 border-gray-300 bg-white block w-full rounded-xl text-center'
            ]))
            ->action(function ($data) {
                $this->record->update([
                    'verify_at' => null,
                    'verify_by' => auth()->user()->id,
                    'email_verified_at' => null,
                    'reason' => $data['reason'],
                    'active' => false,
                ]);
                $this->notificationManagerCgo->sendMembershipRejectEmail($this->record, $data['reason']);
                Notification::make()
                    ->title(trans("admin/performance.Rejected successfully!"))
                    ->success()
                    ->send();

                return redirect()->route('filament.admin.resources.company-recruiter-approvals.index');
            })
            ->extraAttributes([
                'class' => 'action-btn-bottom',
                'style' => 'color: #374151 !important',
            ]);
            if ($this->record->is_company_verified) {
                $actions[] = Actions\Action::make('approve')
                    ->label(trans('system.form.button.approve'))
                    ->color('primary')
                    ->action(function () {
                        $this->record->update([
                            'verify_at' => now(),
                            'verify_by' => auth()->user()->id,
                            'active' => true,
                        ]);
                        $this->notificationManagerCgo->sendMembershipApprovalEmail($this->record);
                        Notification::make()
                            ->title(trans("admin/performance.Approved successfully!"))
                            ->success()
                            ->send();

                        return redirect()->route('filament.admin.resources.company-recruiter-approvals.index');
                    })->extraAttributes([
                        'class' => 'action-btn-bottom !font-normal'
                    ]);
            }else {
                $actions[] = Actions\Action::make('approve')
                    ->label(trans('system.form.button.approve'))
                    ->color('primary')
                    ->action(function () {
                    })->extraAttributes([
                        'class' => 'action-btn-bottom !font-normal cursor-not-allowed',
                        'disabled' => 'disabled'
                    ]) ->view('filament.actions.custom-action', [
                        'message' => trans('company.You need to approve Organisation first'),
                        'company_id' => $this->record->company_id
                    ]);
            }

        }
        return $actions;
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
