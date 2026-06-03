<?php

namespace App\Filament\Widgets\CountQnAByRole;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Services\Admin\QuestionsAndAnswersService;

class QuestionsAndAnswersTableWidget extends BaseWidget
{
     protected static string $view = 'filament.widgets.custom-table-widget';
    protected QuestionsAndAnswersService $questionsAndAnswersService;
    public array $data;
    public ?string $titleHeader = 'Q&A Reply';
    public ?string $namePage = 'qna';
    public string $type;

    public function __construct()
    {
        $this->questionsAndAnswersService = new QuestionsAndAnswersService(
            new \App\Models\QNA()
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->questionsAndAnswersService->getQNAs($this->type, $this->data)
            )
            ->columns([
                Tables\Columns\TextColumn::make('No.')
                    ->label(__('admin/cgo_performance.no'))
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
                    ->visible($this->type == 'institute' )->limit(30),
                    Tables\Columns\TextColumn::make('institute_head_office')
                    ->label(__('admin/cgo_performance.institute_head_office'))
                    ->visible($this->type == 'cgo'),
                Tables\Columns\TextColumn::make('company_name')
                ->limit(30)
                ->getStateUsing(function ($record) {
                    return $record->company_name;
                })
                    ->label(__('admin/cgo_performance.company'))
                    ->visible($this->type == 'company'),
                Tables\Columns\TextColumn::make('district_name')->label(__('admin/cgo_performance.district')) ->visible($this->type == 'company'),
                Tables\Columns\TextColumn::make('institute_head_office')
                ->label(__('admin/cgo_performance.institute_head_office'))
                ->visible($this->type == 'cgo' || $this->type == 'institute'),
                Tables\Columns\TextColumn::make('question')->label(__('admin/cgo_performance.question'))->alignCenter()
                ,
                Tables\Columns\TextColumn::make('answers')->label(__('admin/cgo_performance.answer'))->alignCenter()
               ,
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5])
            ->heading(
                (string) str(__('admin/cgo_performance.qna_reply.title'))
                    ->title(),
            )
            ->headerActions([
                Tables\Actions\Action::make('jobVacancy')
                ->label(__('admin/cgo_performance.view_more'))
//                    ->url(url('/admin/information/q-as?tableFilters[head_office][value]='. ($this->data['head_office'] ?? '')))
                    ->url(url('/admin/information/q-as'))
                    ->icon('heroicon-o-chevron-right' )
                    ->iconPosition('after')
                    ->extraAttributes([
                        'class' => 'view-more-button',
                    ])
            ])
            // ->recordUrl(
            //     fn (Model $record): string => url(''),
            // )
            ->openRecordUrlInNewTab()
            ->queryStringIdentifier($this->namePage)
            ->emptyStateHeading(__('admin/cgo_performance.qna_reply.qna_found'));
    }
}
