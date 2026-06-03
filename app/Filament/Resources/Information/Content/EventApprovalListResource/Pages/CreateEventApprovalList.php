<?php

namespace App\Filament\Resources\Information\Content\EventApprovalListResource\Pages;

use App\Filament\Resources\Information\Content\EventApprovalListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Button;
use Filament\Pages\Actions\Action;
class CreateEventApprovalList extends CreateRecord
{
    protected static string $resource = EventApprovalListResource::class;
    protected static bool $canCreateAnother = false;
    public static string | Alignment $formActionsAlignment = Alignment::Right;

    protected function getRedirectUrl(): string
{
    return EventApprovalListResource::getUrl('index');
}
}
