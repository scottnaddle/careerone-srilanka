<?php

namespace App\Filament\Resources\Information\EventListRejectedResource\Pages;

use App\Filament\Resources\Information\EventListRejectedResource;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use App\Models\Event;
use Filament\Notifications\Notification;
use App\Services\Admin\HandelAdminService;
use Filament\Resources\Pages\ViewRecord;

class ViewEventListRejected extends ViewRecord
{
    protected static string $resource = EventListRejectedResource::class;
    protected static string $view = 'filament.pages.information.manage-event.event.event-reject.event-detail';
 

    public $detailid;
    public $showModal = false;
    public $additionalComments;
    protected HandelAdminService $approvalService;
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public $contenData;
    public function mount($record): void
    {
        parent::mount($record);
        $this->contenData = $this->record;
        $detailId = request()->route('record');
        $this->detailid = Event::findOrFail($detailId);
    }
    public function showApprovalModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'additionalComments']);
    }
    protected function getFirstFormSchema(): array
    {
        return [
            DateTimePicker::make('created_at')
            ->label('Preroid')
            ->native(false)
            ->columnSpan('full'),

            Select::make('event_type')
                ->label('Category')
                ->relationship('category', 'name')
                ->searchable()
                ->required()
                ->preload()
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
            // TextInput::make('reason_for_refusal')
            //     ->label('Reason for reject')
            //     ->disabled()
            //     ->columnSpan('full'),
               


        ];
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
            $event->status = '1';
            $event->reason = $this->additionalComments;
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
            ->title('Event updated successfully!')
            ->success()
            ->send();
            return redirect()->route('filament.admin.resources.information.event-list-rejecteds.index');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
}
