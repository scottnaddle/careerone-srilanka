<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Services\Admin\ContentService;
use App\Services\Admin\EventService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class EventTableWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    protected EventService $eventService;
    public array $data;
    public ?string $titleHeader = 'Events Uploading';
    public ?string $namePage = 'event';
    public string $type;

    public function __construct()
    {
        $this->eventService = new EventService(
            new \App\Models\Event()
        );
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->eventService->getEvents($this->type, $this->data)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('cgo_full_name')
                    ->label(__('admin/cgo_performance.cgo_name'))
                    ->getStateUsing(function ($record) {
                        return $record->cgo_first_name . ' ' . $record->cgo_last_name;
                    })
                    ->visible($this->type == 'cgo'),
                Tables\Columns\TextColumn::make('institute_name')
                    ->label(__('admin/cgo_performance.institute'))
                    ->visible($this->type == 'institute')->limit(25),
                Tables\Columns\TextColumn::make('institute_head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))->alignCenter()
                    ->visible($this->type == 'cgo'),
                Tables\Columns\TextColumn::make('company_name')
                    ->limit(30)
                    ->label(__('admin/cgo_performance.company'))
                    ->visible($this->type == 'company'),
                    Tables\Columns\TextColumn::make('institute_head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))->alignCenter()
                    ->visible($this->type == 'cgo' || $this->type == 'institute'),
                    Tables\Columns\TextColumn::make('district_name')->label(__('admin/cgo_performance.district'))->visible($this->type == 'company'),
                Tables\Columns\TextColumn::make('request')
                    ->alignCenter()
                    ->label(__('admin/cgo_performance.request'))
                   ,
                Tables\Columns\TextColumn::make('approval')
                    ->alignCenter()
                    ->label(__('admin/cgo_performance.approval'))
                   ,

            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                (string) str(__('admin/cgo_performance.events_uploading.title'))
                    ->title(),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label(__('admin/cgo_performance.view_more'))
                    ->url(url('/admin/information/content/event-lists'))
                    ->icon('heroicon-o-chevron-right')
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ])
            // ->recordUrl(
            //     fn (Model $record): string => url('admin/jobs/company?company_id=' . $record->company_id), // Open all company jobs page
            // )
            ->openRecordUrlInNewTab()
            ->queryStringIdentifier($this->namePage)
            ->emptyStateHeading(__('admin/cgo_performance.events_uploading.no_event_found'));
    }
}
