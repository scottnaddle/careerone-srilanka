<?php

namespace App\Filament\Resources\Information\EventListRejectedResource\Pages;

use App\Filament\Resources\Information\EventListRejectedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventListRejecteds extends ListRecords
{
    protected static string $resource = EventListRejectedResource::class;
    protected static ?string $breadcrumb = 'Event Reject List';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
