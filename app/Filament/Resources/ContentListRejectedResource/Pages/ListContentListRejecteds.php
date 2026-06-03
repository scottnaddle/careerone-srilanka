<?php

namespace App\Filament\Resources\ContentListRejectedResource\Pages;

use App\Filament\Resources\ContentListRejectedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContentListRejecteds extends ListRecords
{
    protected static string $resource = ContentListRejectedResource::class;
    
    protected static string $view = 'filament.pages.information.manage-content.content-list-rejected.list-document.content-list';
    public function getTitle(): string
    {
        return 'Content List Rejected';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTotal()
    {
        return ContentListRejectedResource::$countContentApprovalList;
    }
    
}
