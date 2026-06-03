<?php

namespace App\Filament\Resources\Information\Content\EventApprovalListResource\Pages;

use App\Filament\Resources\Information\Content\EventApprovalListResource;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use App\Models\Event;
use Filament\Forms\Components\Select;
use App\Services\Admin\HandelAdminService;
use Filament\Notifications\Notification;
use App\Services\Cgo\NotificationManager as NotificationManagerCgo;
class ViewEventApprovalList extends ViewRecord
{
    protected static string $resource = EventApprovalListResource::class;
    protected static string $view = 'filament.pages.information.manage-event.event.event-approval.event-approval-detail';
    protected HandelAdminService $approvalService;
    protected NotificationManagerCgo $notificationManagerCgo;
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
        $this->notificationManagerCgo = app(NotificationManagerCgo::class);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public $detailid;
    public $showModal = false;
    public $additionalComments;
    public $contenData;
    public function mount($record): void
    {
        parent::mount($record);
        $this->contenData = $this->record;
        $detailId = request()->route('record');
        $this->detailid = Event::findOrFail($detailId);
    }
    protected function getFirstFormSchema(): array
    {
        return [
            DateTimePicker::make('created_at')
                ->label('Preroid')
                ->native(false)
                ->disabled()
                ->columnSpan('full'),

            Select::make('event_type')
                ->label('Category')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->columnSpan('full'),

            TextInput::make('system')
                ->label('Author/Member')
                ->disabled()
                ->columnSpan('w-1/2'),

            TextInput::make('title')
                ->label('Title')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('details')
                ->label('Detail')
                ->disabled()
                ->columnSpan('full'),
        ];
    }
    public function showApprovalModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'additionalComments']);
    }

    public function approveItem()
    {
        if (empty($this->additionalComments)) {
            Notification::make()
                ->title('Reason is required !')
                ->danger()
                ->send();

            return;
        }

        try {
            $event = Event::findOrFail($this->detailid->id);
            $event->status = \App\Enums\StatusEnumsManagement::NON_APPROVAL->value;
            $event->reason = $this->additionalComments;
            if($event->system=='cgo'){
                $user=CgoUser::find($event->created_by);
            }else if($event->system=='company'){
                $user=CompanyRecruiter::find($event->created_by);
            }else if($event->system=='admin'){
                $user=AdminUser::find($event->created_by);
            }
            $this->notificationManagerCgo->rejectContentSendToCgo( $user,$event);
            $event->save();

            Notification::make()
                ->title('Event updated successfully!')
                ->success()
                ->send();

            $this->closeModal();

            return redirect()->route('filament.admin.resources.information.content.event-approval-lists.index');
        } catch (\Exception $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function handleApproval()
    {
        if (!$this->detailid) {
            session()->flash('error', 'User ID is required for approval.');
            return;
        }

        $success = $this->approvalService->approveContent(Event::class, $this->detailid->id);

        if ($success) {
            Notification::make()
            ->title('Event approved successfully!')
            ->success()
            ->send();
            return redirect()->route('filament.admin.resources.information.content.event-approval-lists.index');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
}
