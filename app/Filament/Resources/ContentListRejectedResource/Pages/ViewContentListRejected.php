<?php

namespace App\Filament\Resources\ContentListRejectedResource\Pages;

use App\Filament\Resources\ContentListRejectedResource;
use App\Models\Content;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Services\Admin\HandelAdminService;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ViewContentListRejected extends ViewRecord
{
    protected static string $resource = ContentListRejectedResource::class;
    public $showModal=false;
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    protected static string $view = 'filament.pages.information.manage-content.content-list-rejected.content-detail';
    protected HandelAdminService $approvalService;
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }
    public $contenData;
    public $detailid;
    public function mount($record): void
    {
        parent::mount($record);
        $this->contenData = $this->record;
        $detailId = request()->route('record');
        $this->detailid = Content::findOrFail($detailId);
    }


    protected function getFirstFormSchema(): array
    {
        $schema = [
            TextInput::make('created_at')
                ->label('Date')
                ->disabled()
                ->columnSpan(1),
    
            TextInput::make('author')
                ->label('Author/Member')
                ->disabled()
                ->columnSpan(1),
    
            TextInput::make('title')
                ->label('Title')
                ->disabled()
                ->columnSpan('full'),
    
            Textarea::make('intro')
                ->label('Detail')
                ->autosize()
                ->columnSpan('full'),
        ];
        if (!empty($this->record->reason)) {
            $schema[] = TextInput::make('reason')
                ->label('Reason for reject')
                ->disabled()
                ->columnSpan('full');
        }
    
        return $schema;
    }

    public function handleApproval()
    {
        if (!$this->detailid) {
            session()->flash('error', ' ID content is required for approval.');
            return;
        }

        $success = $this->approvalService->approveContent(Content::class, $this->detailid->id);

        if ($success) {
            session()->flash('success', 'User has been approved successfully.');
            return redirect()->route('filament.admin.resources.content-list-rejecteds.index');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
}
