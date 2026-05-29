<?php

namespace App\Filament\Resources\Information\Content\EventListResource\Pages;

use App\Filament\Resources\Information\Content\EventListResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Models\Event;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListEventLists extends ListRecords
{
    protected static string $resource = EventListResource::class;
    protected static string $view = 'filament.pages.information.manage-event.event.event-list';
    protected static ?string $title = '';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTotal()
    {
        return EventListResource::$countEvnet;
    }
    public function table(Table $table): Table {
        return parent::table($table)->modifyQueryUsing(function (Builder $query) {
            if ($this->isTableReordering) {
                $query->where('show_on_homepage', true);
            }

            return $query;
        });
    }
//    public function reorderTable(array $order): void {
//        $firstFour = array_slice($order, 0, 4);
//
//        foreach ($firstFour as $key => $item) {
//            $event = Event::find($item);
//
//            if (!$event) {
//                Notification::make()
//                    ->title("Event with ID $item not found.")
//                    ->danger()
//                    ->send();
//                return;
//            }
//
////            if ($event->status != 2 || !$event->show_on_homepage) {
////                Notification::make()
////                    ->title("Only approved events with 'Show on homepage' enabled are allowed.")
////                    ->danger()
////                    ->send();
////                return;
////            }
//            $event->sort = $key+1;
//            $event->save();
//            Notification::make()
//                ->title("Valid event: " . $event->title)
//                ->info()
//                ->send();
//        }
//    }


}
