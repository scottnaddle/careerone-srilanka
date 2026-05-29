<?php

namespace App\Filament\Resources\Information\Content;

use App\Filament\Resources\Information\Content\ContentAppovalListResource\Pages;
use App\Filament\Resources\Information\Content\ContentAppovalListResource\RelationManagers;
use App\Models\Content;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;

class ContentAppovalListResource extends Resource
{
    protected static ?string $model = Content::class;
    public $showApprovalModal = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $countEventApprovalList;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );
        $customQuery=$searchService->searchContent([
            'search' => request()->query('search', null),
            'type'=>true,
            'check_approved'=>true,
            'member' => request()->query('member', null),
            'search_time' => request()->query('search-time', null),
        ]);
        self::$countEventApprovalList=$customQuery->count();
        return $table
        ->paginated([10, 25, 50, 100])
        ->query(
            $customQuery
        )
        ->columns([
            Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),
            Tables\Columns\TextColumn::make('created_at')
                ->sortable()
                ->label(__('admin/dashboard.content.date')),
            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->limit(50)
                ->searchable()
                ->label(__('admin/dashboard.content.title_table')),
            Tables\Columns\TextColumn::make('author')
                ->sortable()
                ->label(__('admin/dashboard.content.author')),
            Tables\Columns\TextColumn::make('content_type')
                ->sortable()
                ->getStateUsing(function ($record) {
                    return match ($record->content_type) {
                        'pdf' => 'PDF',
                        'doc'=>'Doc',
                        default => $record->content_type,
                    };
                })
                ->label(__('admin/dashboard.content.type')),
            Tables\Columns\TextColumn::make('system')
                ->sortable()
                ->getStateUsing(function ($record) {
                    return match ($record->system) {
                        'cgo' => 'CGO',
                        'company' => 'Company',
                        'admin' => 'Admin',
                        default => $record->system,
                    };
                })
                ->label(__('admin/dashboard.content.member')),
            Tables\Columns\TextColumn::make('approval')
                ->label(__('admin/dashboard.content.status'))
                ->getStateUsing(function ($record) {
                    if($record->status == \App\Enums\StatusEnumsManagement::APPROVED->value){
                        $result=__('admin/dashboard.content.approval');
                    }else if($record->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value){
                        $result=__('admin/dashboard.content.reject');
                    }else{
                        $result=__('admin/dashboard.content.request');
                    }
                    return $result;
                })
                ->formatStateUsing(function ($state) {
                    if ($state === __('admin/dashboard.content.approval')) {
                        return "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>";
                    }
                    if ($state ===__('admin/dashboard.content.request')) {
                        return "<span style='font-size:12px;color:#5a5252; background-color: #f1f1f1; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>";
                    }
                    return "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>$state</span>";
                })
                ->html(),
        ])->searchPlaceholder('Title')
            ->filters([
                Tables\Filters\SelectFilter::make('system')
                    ->label('Select member')
                    ->options([
                        'cgo' => 'CGO',
                        'company' => 'Company',
                        'admin' => 'Admin'
                    ])
                    ->placeholder('All Member')
                    ->column('system'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(function () {
                        $eventStatus = \App\Enums\StatusEnumsManagement::cases();
                        $option = [];
                        foreach ($eventStatus as $statusEnum) {
                            $option[$statusEnum->value] = \App\Enums\StatusEnumsManagement::getStatusName($statusEnum->value);
                        }
                        return $option;
                    })
                    ->placeholder('All status')
                    ->column('status'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
          ;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContentAppovalLists::route('/'),
            'create' => Pages\CreateContentAppovalList::route('/create'),
            'edit' => Pages\EditContentAppovalList::route('/{record}/edit'),
            'view' => Pages\ViewContentAppovalLists::route('/{record}'),
            'index-video' => Pages\ListContentVideoApprovalList::route('/video/view'),
        ];
    }

}
