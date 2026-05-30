<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CGOResource\Pages;
use App\Filament\Resources\CGOResource\RelationManagers;
use App\Models\CGO;
use App\Models\CgoUser;
use App\Models\Institute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Models\TvetType;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;
use Filament\Tables\Actions\Action;
class CGOResource extends Resource
{
    protected static ?string $model = CgoUser::class;

    protected static ?string $navigationLabel = 'CGO';
    protected static ?string $navigationGroup = 'CGO';
    protected static ?int $navigationSort = 1;

    public static $totalCgo;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Define your form schema here
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('date')
                            ->label('Created Date')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['date'])) {
                            $query->whereDate('created_at', $data['date']);
                        }
                    }),
                Tables\Filters\Filter::make('updated_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('date')
                            ->label('Updated Date')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['date'])) {
                            $query->whereDate('updated_at', $data['date']);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder('Name or Email')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('institute.name')
                    ->label(__('admin/dashboard.cgo.institute'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('district.name')->label(trans('trainee.job_support.company.table.label.district')) ->sortable(),
                Tables\Columns\TextColumn::make('fullName')
                    ->label(__('admin/dashboard.cgo.name'))
                    ->getStateUsing(fn($record) => $record->fullName ?? 'N/A')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('email')->searchable(),
//                Tables\Columns\TextColumn::make('counseling')
//                    ->getStateUsing(fn($record) => $record->counselings->count())
//                    ->label(__('admin/dashboard.cgo.guidance'))
//                    ->alignCenter(),
//
//                Tables\Columns\TextColumn::make('cancel')->label(__('admin/dashboard.cgo.cancel'))
//                    ->getStateUsing(fn($record) => $record->countCancelCounseling->count() ?? 'N/A') ->alignCenter(),
//                Tables\Columns\TextColumn::make('event')->label(__('admin/dashboard.cgo.event'))
//                    ->getStateUsing(fn($record) => $record->events->count() ?? 'N/A') ->alignCenter(),
//                Tables\Columns\TextColumn::make('content')->label(__('admin/dashboard.cgo.content'))
//                    ->getStateUsing(fn($record) => $record->contents->count() ?? 'N/A') ->alignCenter(),
//                Tables\Columns\TextColumn::make('reply')->label(__('admin/dashboard.cgo.reply'))
//                    ->getStateUsing(fn($record) => $record->qnaAnswes->count() ?? 'N/A') ->alignCenter(),
                Tables\Columns\TextColumn::make('approval')
                    ->label(__('admin/dashboard.cgo.approval'))
                    ->getStateUsing(function ($record) {
                        return $record->statusCgouser();
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Verified' => "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>",
                        'Request' => "<span style='font-size:12px;color: #a1a1a1; background-color: #dfdada; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Request</span>",
                        default => "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>Rejected</span>",
                    })
                    ->html(),
                    Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger')
            ])->paginated([10, 25, 50, 100])
            ->actions([
                Action::make('deactivate')
                ->label(__('Deactivate'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['active' => false, 'verify_at' => null, 'verify_by' => auth()->guard('admin')->id()]);
                })
                ->hidden(fn ($record) => $record->active === false)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            Action::make('activate')
                ->label(__('Activate'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['active' => true, 'verify_at' => now(), 'verify_by' => auth()->guard('admin')->id()]);
                })
                ->hidden(fn ($record) => $record->active === true)
                ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->filters([
                Tables\Filters\Filter::make('tvet_type')
                    ->form([
                        Forms\Components\Select::make('tvet_type')
                            ->label('TVET')
                            ->options(TvetType::all()->pluck('head_office_name', 'head_office_code'))
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('institute_select', null);
                            }),

                        Forms\Components\Select::make('institute_select')
                            ->label('Institute')
                            ->options(function ($get) {
                                $tvetCode = $get('tvet_type');
                                if ($tvetCode) {
                                    return Institute::where('institute_head_office', $tvetCode)->orderBy('name', 'asc')
                                        ->pluck('name', 'id');
                                }
                                return [];
                            })
                            ->preload()
                            ->searchable()
                            ->visible(function ($get) {
                                return !empty($get('tvet_type'));
                            }),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['tvet_type'])) {
                            $instituteIds = Institute::where('institute_head_office', $data['tvet_type'])->orderBy('name', 'asc')
                                                     ->pluck('id')
                                                     ->toArray();
                            $query->whereIn('institute_id', $instituteIds);
                        }
                        if (!empty($data['institute_select'])) {
                            $query->where('institute_id', $data['institute_select']);
                        }
                    }),
            ])
            ->striped()
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // Example of user-based query modification
                // $user = auth('admin')->user();
                // if (!$user->hasRole('SuperAdmin')) {
                //     $query->where('institute_id', $user->institute_id);
                // }
            });
    }



    public static function getRelations(): array
    {
        return [
            // Define relationships if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCGOS::route('/'),
            'create' => Pages\CreateCGO::route('/create'),
            'view' => Pages\ViewCGO::route('/{record}'),
            'edit' => Pages\EditCGO::route('/{record}/edit'),
        ];
    }
}
