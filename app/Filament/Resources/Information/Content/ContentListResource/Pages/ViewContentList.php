<?php

namespace App\Filament\Resources\Information\Content\ContentListResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\Information\Content\ContentListResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use App\Services\Admin\HandelAdminService;
use App\Models\CompanyRecruiter;
use App\Models\Content;

class ViewContentList extends ViewRecord
{
    protected static string $resource = ContentListResource::class;
    protected static string $view = 'filament.pages.information.manage-content.content.content-detail';
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
    

   
public function handleBlock()
{
    if (!$this->contenData) {
        session()->flash('error', 'ID is required for approval.');
        return redirect()->back();
    }
    $success = $this->approvalService->blockContent(Content::class, $this->contenData->id);
    if ($success) {
        session()->flash('success', 'Block operation was successful.');
        return redirect()->route('filament.admin.resources.information.content.content-lists.index');
    }
    session()->flash('error', ' Not found.');
    return redirect()->back();
}

}
