<?php

namespace App\Filament\Resources\Information\Content\EventApprovalListResource\Pages;

use App\Filament\Resources\Information\Content\EventApprovalListResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventApprovalLists extends ListRecords
{
    protected static string $resource = EventApprovalListResource::class;
    protected static ?string $breadcrumb = 'Event Approval List';
//    protected static string $view = 'filament.pages.information.manage-event.event.event-approval.event-approval-list';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
    public $showModal = false;
    protected function getContentVideo()
    {
        return Event::where('type', 'video')
        ->where('status', 0)
        ->paginate(9);
    }
    public function openModalContentUploading(){
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    protected function getTotal()
    {
        return EventApprovalListResource::$countEvnet;
    }
}
