<?php

namespace App\Filament\Resources\OJTResource\Widgets;

use App\Services\Admin\OJTService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class OJTTableWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    protected OJTService $OJT;
    public array $data;
    public ?string $titleHeader = 'Contents Uploading';
    public ?string $namePage = 'content';
    public string $type;

    public function __construct()
    {
        $this->OJT = new OJTService(
            new \App\Models\OJT()
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->OJT->getMatchedOJT($this->type, $this->data)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter()
                ,
                Tables\Columns\TextColumn::make('name_1')
                ->label(__('admin/cgo_performance.company_name'))
                ->limit(30)
                ->getStateUsing(function ($record) {
                    return $record->name;
                })
                ->visible($this->type=='company'),

                Tables\Columns\TextColumn::make('name_2')
                    ->getStateUsing(function ($record) {
                    return $record->name;
                })
                ->label(__('admin/cgo_performance.institute'))->visible($this->type=='institute')->limit(25),
                Tables\Columns\TextColumn::make('district')
                ->label(__('admin/cgo_performance.district'))->visible($this->type=='company'),

//                Tables\Columns\TextColumn::make('matched_job')
//                ->alignCenter()
//                ->label(__('admin/cgo_performance.matched_job_titlle'))
//                ->visible($this->type !=='institute'),
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('admin/cgo_performance.cgo_name'))
                    ->limit(50)
                    ->getStateUsing(function ($record) {
                        return $record->first_name . ' ' . $record->last_name;
                    })
                    ->visible($this->type=='cgo')
                    ,
                    Tables\Columns\TextColumn::make('institute_head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))  ->visible($this->type=='cgo' || $this->type=='institute')->alignCenter(),
                    Tables\Columns\TextColumn::make('total_matches')
                    ->label(__('admin/cgo_performance.ojt_matched'))  ->visible($this->type=='cgo'  || $this->type=='institute')->alignCenter(),
                Tables\Columns\TextColumn::make('matched_ojt')
                    ->label(__('admin/cgo_performance.ojt_matched'))->visible($this->type=='company')->alignCenter(),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                __('admin/cgo_performance.ojt_matched'),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label(__('admin/cgo_performance.view_more'))
                    ->url(url('/admin/o-j-t-s'))
                    ->icon('heroicon-o-chevron-right' )
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
