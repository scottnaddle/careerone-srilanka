<?php

namespace App\Filament\Resources\PopupResource\Pages;

use App\Filament\Resources\PopupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Filament\Notifications\Notification;

class ListPopups extends ListRecords
{
    protected static string $resource = PopupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('configure_success_popup')
                ->label('Success & Recognition Config')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('primary')
                ->form([
                    Forms\Components\Toggle::make('show_success_popup')
                        ->label('Enable Success & Recognition Popup')
                        ->default(env('SHOW_PLATFORM_SUCCESS', false)),
                ])
                ->action(function (array $data) {
                    $newValue = $data['show_success_popup'];
                    setEnvValue('SHOW_PLATFORM_SUCCESS', $newValue);
                    
                    Notification::make()
                        ->title($newValue ? 'Success & Recognition Popup enabled!' : 'Success & Recognition Popup disabled!')
                        ->success()
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}

