<?php
namespace App\Filament\Resources\Information\Content\ContentAppovalListResource\Pages;

use App\Filament\Resources\Information\Content\ContentAppovalListResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContentAppovalList extends CreateRecord
{
    protected static string $resource = ContentAppovalListResource::class;
    protected static string $view = 'filament.pages.information.manage-content.content.content-approval.content-approval-list';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            // The form components go here
            \Filament\Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required(),

            \Filament\Forms\Components\Textarea::make('details')
                ->label('Details')
                ->rows(4),

            // Add other components if needed
        ];
    }

  
    protected function afterCreate(Event $record): void
    {
        $this->notify('success', 'Content Approval List has been created successfully!');
    }
}
