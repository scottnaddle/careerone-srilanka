<?php

namespace App\Filament\Resources\ContentResource\Widgets;

use App\Services\Admin\ContentService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class ContentTableWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    protected ContentService $contentService;
    public array $data;
    public ?string $titleHeader = 'Contents Uploading';
    public ?string $namePage = 'content';
    public string $type;

    public function __construct()
    {
        $this->contentService = new ContentService(
            new \App\Models\Content()
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->contentService->getContents($this->type, $this->data)
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
                    ->visible($this->type == 'cgo' || $this->type == 'institute'),
                    Tables\Columns\TextColumn::make('total_video')
                    ->alignCenter()
                    ->label(__('admin/cgo_performance.video'))
                    ->visible($this->type == 'cgo' || $this->type == 'institute'),
                    Tables\Columns\TextColumn::make('total_content')
                    ->label(__('admin/cgo_performance.content'))
                    ->alignCenter()
                    ->visible($this->type == 'cgo' || $this->type == 'institute'),
                Tables\Columns\TextColumn::make('institute_name')
                    ->label(__('admin/cgo_performance.institute'))->limit(25)
                    ->visible($this->type == 'institute'),
                Tables\Columns\TextColumn::make('company_name')
                    ->label(__('admin/cgo_performance.company'))
                    ->visible($this->type == 'company'),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                (string) str(__('admin/cgo_performance.contents_uploading.title'))
                    ->title(),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label(__('admin/cgo_performance.view_more'))
                    ->url(url('/admin/content/documents'))
//                    ->url(url('/admin/information/content/content-lists'))
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
            ->emptyStateHeading(__('admin/cgo_performance.contents_uploading.no_content_found'));
    }
}
