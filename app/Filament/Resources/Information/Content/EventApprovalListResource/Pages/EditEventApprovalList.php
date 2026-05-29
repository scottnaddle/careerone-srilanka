<?php

namespace App\Filament\Resources\Information\Content\EventApprovalListResource\Pages;

use App\Filament\Resources\Information\Content\EventApprovalListResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use App\Services\Admin\HandelAdminService;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
class EditEventApprovalList extends EditRecord
{
    protected static string $resource = EventApprovalListResource::class;
    protected HandelAdminService $approvalService;
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }
    protected static string $view = 'filament.pages.information.manage-event.event.event-approval.event-approval-edit';
    public $contenData;
    public $detailid;
    public $showModal = false;
    public $additionalComments;
    public function mount($record): void
    {
        parent::mount($record);
        $this->contenData = $this->record;
        $detailId = request()->route('record');
        $this->detailid = Event::findOrFail($detailId);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
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
                ->disabled()
                ->searchable()
                ->columnSpan('w-1/2'),

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
            // TextInput::make('reason')
            //     ->label('Reason for reject')
            //     ->disabled()
            //     ->columnSpan('full'),



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
            $event->status = '2';
            $event->reason = $this->additionalComments;
            $event->save();

            Notification::make()
                ->title('Event updated successfully!')
                ->success()
                ->send();

            $this->closeModal();

            return redirect()->route('filament.admin.resources.information.content.content-appoval-lists.index');
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
            session()->flash('success', 'User has been approved successfully.');
            return redirect()->route('filament.admin.resources.information.content.event-approval-lists.index');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
