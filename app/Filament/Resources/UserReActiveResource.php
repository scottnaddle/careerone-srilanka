<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserReActiveResource\Pages;
use App\Filament\Resources\UserReActiveResource\RelationManagers;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\ReactiveAccountRequest;
use App\Models\SchoolKid;
use App\Models\TraineeUser;
use App\Models\UserReActive;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Trainee\TraineeCasSyncService;

class UserReActiveResource extends Resource
{
    protected static ?string $model = ReactiveAccountRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected $traineeCasSyncService;
    protected static ?string $breadcrumb = 'Membership';
    public function __construct(TraineeCasSyncService $traineeCasSyncService)
    {
        $this->traineeCasSyncService = $traineeCasSyncService;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->getStateUsing(function ($record) {
                        switch ($record->user_type) {
                            case 'admin':
                                return AdminUser::find($record->user_id)->email ?? '';
                            case 'cgo':
                                return CgoUser::find($record->user_id)->email ?? '';
                            case 'trainee':
                                return TraineeUser::find($record->user_id)->email ?? '';
                            case 'schoolkid':
                                return SchoolKid::find($record->user_id)->email ?? '';
                            case 'company':
                                return CompanyRecruiter::find($record->user_id)->email ?? '';
                            default:
                                return $record->email ?? '';
                        }
                    })->wrap(),

                Tables\Columns\TextColumn::make('user_type')
                ->getStateUsing(function ($record) {
                     return match ($record->user_type) {
                    'cgo' => 'CGO',
                    'company' => 'Company',
                    'admin' => 'Admin',
                    'trainee'=>'Trainee',
                    default => $record->user_type,
                };
                })->label('User Type')->wrap(),
                Tables\Columns\TextColumn::make('requested_at')->sortable()
                    ->label('Rquested At')->wrap(),
                Tables\Columns\TextColumn::make('confirmed_at')->sortable()
                    ->label('Confirmed At')->wrap(),

                Tables\Columns\TextColumn::make('first_name')
                    ->label('Full Name')
                    ->getStateUsing(function ($record) {
                        switch ($record->user_type) {
                            case 'admin':
                                return AdminUser::find($record->user_id)->fullName ?? '';
                            case 'cgo':
                                return CgoUser::find($record->user_id)->fullName ?? '';
                            case 'trainee':
                                return TraineeUser::find($record->user_id)->fullName ?? '';
                            case 'schoolkid':
                                return SchoolKid::find($record->user_id)->fullName ?? '';
                            case 'company':
                                return CompanyRecruiter::find($record->user_id)->fullName ?? '';
                            default:
                                return $record->fullName ?? '';
                        }
                    })->wrap(),
                    Tables\Columns\TextColumn::make('status')
                    ->sortable(['confirmed_at'])
                    ->getStateUsing(function ($record) {
                        return !empty($record->confirmed_at) ? 'Confirmed' : 'Requested';
                    })
                    ->badge()
                    ->color(fn ($state) => $state === 'Confirmed' ? 'success' : 'gray')
                    ->label('Status'),

            ])
            ->defaultSort('created_at', 'desc')
            ->reorderable('updated_at')
            ->paginated([10, 25, 50, 100])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => match ($record->user_type) {
                        'admin' => route('filament.admin.resources.administrators.view', ['record' => $record->user_id]),
                        'trainee' => route('filament.admin.resources.trainees.view', ['record' => $record->user_id]),
                        'company' => route('filament.admin.resources.company-recruiters.view', ['record' => $record->user_id]),
                        'cgo' => route('filament.admin.resources.c-g-o-s.view', ['record' => $record->user_id]),
                        default => '',
                    })
                    ->color('primary')
                    ->openUrlInNewTab(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('user_type')
                    ->label('User Type')
                    ->options([
                        'cgo' => 'CGO',
                        'company' => 'Company',
                        'admin' => 'Admin'
                    ])
                    ->placeholder('All Member')
                    ->column('user_type'),
                Tables\Filters\SelectFilter::make('approval')
                    ->options([
                        'all' => 'All',
                        'confirmed' => 'Confirmed',
                        'requested' => 'Requested'
                    ])
                    ->default('all')
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'requested' => $query
                                ->whereNotNull('requested_at')
                                ->whereNull('confirmed_at'),

                            'confirmed' => $query
                                ->whereNotNull('requested_at')
                                ->whereNotNull('confirmed_at'),

                            default => $query, // 'all'
                        };
                    })
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListUserReActives::route('/'),
            // 'create' => Pages\CreateUserReActive::route('/create'),
            // 'view' => Pages\ViewUserReActive::route('/{record}'),
            // 'edit' => Pages\EditUserReActive::route('/{record}/edit'),
        ];
    }
}
