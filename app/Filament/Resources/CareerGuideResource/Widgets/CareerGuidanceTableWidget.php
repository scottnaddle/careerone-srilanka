<?php

namespace App\Filament\Resources\CareerGuideResource\Widgets;

use App\Services\Admin\CounselingService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class CareerGuidanceTableWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    protected CounselingService $counselingService;
    public array $data;
    public ?string $titleHeader = 'Career Guidance Widget';
    public ?string $namePage = 'content';
    public string $type;

    public function __construct()
    {
        $this->counselingService = new CounselingService(
            new \App\Models\CgoCounseling()
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->counselingService->getGuidanceCGOPerformance($this->type, $this->data)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),
                    Tables\Columns\TextColumn::make('cgo_full_name')
                    ->label(__('admin/cgo_performance.cgo_name'))
                    ->limit(30)
                    ->getStateUsing(function ($record) {
                        return $record->first_name . ' ' . $record->last_name;
                    })
                    ->visible($this->type == 'cgo')
                    ,
                    Tables\Columns\TextColumn::make('first_name')
                    ->label(__('admin/institute_performance.institute_name'))
                    ->limit(25)
                    ->visible($this->type == 'institute')
                    ,

                Tables\Columns\TextColumn::make('institute_head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))->alignCenter(),

               Tables\Columns\TextColumn::make('cgo_count')
                   ->label(__('admin/cgo_performance.CGO'))
                   ->alignCenter()
                   ->getStateUsing(function ($record) {
                    return $record->count_cgo;
                    })
                   ->visible($this->type == 'institute'),

                Tables\Columns\TextColumn::make('total_requests')
                    ->label(__('admin/cgo_performance.total_requests'))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_confirms')
                    ->label(__('admin/cgo_performance.total_confirms'))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_completions')
                    ->label(__('admin/cgo_performance.total_completions'))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_cancellations')
                    ->label(__('admin/cgo_performance.total_cancellations'))
                    ->alignCenter(),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                (string) str(__('admin/cgo_performance.career_guidance.title'))
                    ->title(),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                    ->label(__('admin/cgo_performance.view_more'))
//                    ->url(fn () => url('/admin/counseling-lists?tableFilters[head_office][value]=' . ($this->data['head_office'] ?? '')))
                    ->url(fn () => url('/admin/counseling-lists'))
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
