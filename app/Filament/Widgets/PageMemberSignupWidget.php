<?php

namespace App\Filament\Widgets;

use App\Models\CgoUser;
use App\Services\Admin\MemberSignupService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\View\View;

class PageMemberSignupWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.custom-table-widget';
    public ?string $titleHeader = '';
    public ?string $namePage = 'member-signup-table';
    public array $data;

    protected MemberSignupService $memberSignupService;
    public function __construct()
    {
        $this->memberSignupService = new MemberSignupService(
            new \App\Models\CgoUser(),
            new \App\Models\Company(),
            new \App\Models\TraineeUser()
        );
    }
    protected function getTableHeading(): ?string
    {
        return '';
    }
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected function getTableQuery(): Builder|Relation|null
    {
        return $this->memberSignupService->getMemberSignupTableData($this->data);
    }
    public function getTableRecordKey(\Illuminate\Database\Eloquent\Model $record): string
    {
        return 'id'; // Ensure this key exists in your query results
    }
    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('No.')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->sortable()
                    ->color('red'),
                Tables\Columns\TextColumn::make('cgo_total')
                    ->label('CGO')
                    ->alignCenter()
                    ->url(fn ($record) => route('filament.admin.resources.c-g-o-s.index', ['tableFilters' => ['created_at' => ['date' => $record->date]]]), true),
                Tables\Columns\TextColumn::make('trainee_total')
                    ->label('Trainee')
                    ->alignCenter()
                    ->url(fn ($record) => route('filament.admin.resources.trainees.index', ['tableFilters' => ['created_at' => ['date' => $record->date]]]), true),
                Tables\Columns\TextColumn::make('company_total')
                    ->label('Company')
                    ->alignCenter()
                    ->url(fn ($record) => route('filament.admin.resources.companies.index', ['tableFilters' => ['created_at' => ['date' => $record->date]]]), true),
                Tables\Columns\TextColumn::make('admin_total')
                    ->label('Admin')
                    ->alignCenter()
                    ->url(fn ($record) => route('filament.admin.resources.administrators.index', ['tableFilters' => ['created_at' => ['date' => $record->date]]]), true),
                Tables\Columns\TextColumn::make('total_users')
                    ->alignCenter()
                    ->label('Total'),
            ])
            ->heading(
                (string) str($this->titleHeader)->title()
            )
            ->defaultPaginationPageOption(5)
            ->openRecordUrlInNewTab()
            ->queryStringIdentifier($this->namePage)
            ->defaultSort('date', 'desc')
            ->emptyStateHeading('No Member found');
    }
    
}
