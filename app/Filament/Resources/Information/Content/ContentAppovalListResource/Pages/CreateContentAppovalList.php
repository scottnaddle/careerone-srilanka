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
            // Các thành phần của form ở đây
            \Filament\Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required(),

            \Filament\Forms\Components\Textarea::make('details')
                ->label('Details')
                ->rows(4),

            // Thêm các thành phần khác nếu cần
        ];
    }

  
    protected function afterCreate(Event $record): void
    {
        $this->notify('success', 'Content Approval List has been created successfully!');
    }
}
