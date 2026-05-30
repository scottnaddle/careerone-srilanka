<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TraineeResource\Pages;
use App\Filament\Resources\TraineeResource\RelationManagers;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\District;
use App\Models\DivisionalSecretariats;
use App\Models\Institute;
use App\Models\Province;
use App\Models\Trainee;
use App\Models\TraineeUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Tables\Columns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;
use Filament\Tables\Actions\Action;

class TraineeResource extends Resource
{
    protected static ?string $model = TraineeUser::class;

    protected static ?string $navigationLabel = 'Trainee';
    protected static ?string $navigationGroup = 'Trainee';
    protected static ?int $navigationSort = 1;
    public static $totalRecords;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nic')
                    ->label('NIC')
                    ->maxLength(12)
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('full_name')
                    ->required(),



                Forms\Components\Textarea::make('permanant_address')
                    ->columnSpan("1/2"),

                Forms\Components\Textarea::make('contact_address')
                    ->columnSpan("1/2"),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(150)
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('gender')
                    ->options([
                        '1' => 'Male',
                        '2' => 'Female',
                        '3' => 'N/A',
                    ])
                    ->nullable()->columnSpan("1/3"),
                Forms\Components\TextInput::make('telephone')
                    ->maxLength(20)->columnSpan("1/3"),

                Forms\Components\TextInput::make('mobile')
                    ->maxLength(20)->columnSpan("1/3"),


                Forms\Components\TextInput::make('std_surname'),

                Forms\Components\TextInput::make('std_initials')
                    ->maxLength(60),

                Forms\Components\Toggle::make('active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->paginated([10, 25, 50, 100])
            ->searchPlaceholder('Email, NIC or Name')
            // ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true))
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),

                Tables\Columns\TextColumn::make('institutes.name')->limit(50)
                    ->label(__('admin/dashboard.trainee.institute')),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->label(__('admin/dashboard.trainee.name')),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label(__('admin/dashboard.trainee.email')),
                Tables\Columns\TextColumn::make('nic')
                    ->label('NIC')->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recommended_by')
                    ->label(trans('general.Recommended by'))
                    ->getStateUsing(function ($record) {
                        $recommendedBy = null;
                        $headOffice = '';
                        if ($record->recommended_by_user_id != null && $record->recommended_by_user_system != null) {
                            if ($record->recommended_by_user_system == 'cgo') {
                                $user = CgoUser::where('id', $record->recommended_by_user_id)->first();
                                $headOffice = $user->institute?->reg_no;
                            }else{
                                $user = AdminUser::where('id', $record->recommended_by_user_id)->first();
                                $headOffice = $user->tvet_type;
                            }
                            $recommendedBy = strtoupper($record->recommended_by_user_system) .' - '. $user?->fullName. ' ('. $headOffice.')';
                        }
                        return $recommendedBy;
                    }),
                Tables\Columns\TextColumn::make('career_test')
                    ->getStateUsing(function ($record) {
                        return $record->careerTest()->count();
                    })
                    ->label(__('admin/dashboard.trainee.career_test'))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('portfolio')
                    ->getStateUsing(function ($record) {
                        return $record->portfolio()->count();
                    })
                    ->label(__('admin/dashboard.trainee.portfolio'))
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('counseling')
                    ->getStateUsing(function ($record) {
                        return $record->cgoCounseling()->count();
                    })
                    ->label(__('admin/dashboard.trainee.guidance'))
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('applied')
                    ->getStateUsing(function ($record) {
                        return $record->jobApplies()->count();
                    })
                    ->label(__('admin/dashboard.trainee.applied'))
                    ->alignCenter(),
                    Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger')
            ])
            ->actions([
                // Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
                Action::make('deactivate')
                ->label(__('Deactivate'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['active' => false]);
                })
                ->hidden(fn ($record) => $record->active === false)->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            Action::make('activate')
                ->label(__('Activate'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['active' => true]);
                })
                ->hidden(fn ($record) => $record->active === true)->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->striped()
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->filters([
                Tables\Filters\Filter::make('search')
                    ->form([
                        Forms\Components\Select::make('provin')
                            ->label('Province')
                            ->options(Province::all()->pluck('name', 'id'))
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('district', null);
                                $set('divisional', null);
                                $set('owner_ship', null);
                                $set('active_status', null);
                                $set('institute_select', null);
                            }),

                        Forms\Components\Select::make('district')
                            ->label('District')
                            ->options(function ($get) {
                                $provin = $get('provin');
                                return $provin
                                    ? District::where('prov_id', $provin)->pluck('name', 'id')
                                    : District::all()->pluck('name', 'id');
                            })
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('divisional', null);
                                $set('owner_ship', null);
                                $set('active_status', null);
                                $set('institute_select', null);
                            }),

                        Forms\Components\Select::make('divisional')
                            ->label('Divisional')
                            ->options(function ($get) {
                                $district = $get('district');
                                return $district
                                    ? DivisionalSecretariats::where('dist_id', $district)->pluck('ds_name', 'ds_code')
                                    : DivisionalSecretariats::all()->pluck('ds_name', 'ds_code');
                            })
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->visible(function ($get) {
                                return true;
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('institute_select', null);
                            }),

                        Forms\Components\Select::make('owner_ship')
                            ->label('Owner Ship')
                            ->options(function ($get) {
                                $language = app()->getLocale();
                                return getCodeList('ownership', $language)->pluck('code_name', 'code_name');
                            })
                            ->preload()
                            ->searchable(),

                        Forms\Components\Select::make('active_status')
                            ->label('Active Status')
                            ->options(function ($get) {
                                return Institute::select(\DB::raw('COUNT(*) as count'), 'active_status')
                                    ->groupBy('active_status')
                                    ->pluck('active_status', 'active_status');
                            })
                            ->preload()
                            ->searchable(),

                        Forms\Components\Select::make('institute_select')
                            ->label('Institute')
                            ->options(function ($get) {
                                $divisional = $get('divisional');
                                return $divisional
                                    ? Institute::where('ds_id', $divisional)->pluck('name', 'id')
                                    : Institute::all()->pluck('name', 'id');
                            })
                            ->preload()
                            ->searchable()
                            ->visible(function ($get) {
                                return true;
                            }),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $instituteIds = [];

                        // Filter by province
                        if (!empty($data['provin'])) {
                            $districtIds = District::where('prov_id', $data['provin'])->pluck('id')->toArray();
                            $provinInstituteIds = Institute::whereIn('dist_id', $districtIds)->pluck('id')->toArray();
                            $instituteIds = $provinInstituteIds;
                        }

                        // Filter by district (narrows down from province if set)
                        if (!empty($data['district'])) {
                            $districtInstituteIds = Institute::where('dist_id', $data['district'])->pluck('id')->toArray();
                            $instituteIds = !empty($instituteIds)
                                ? array_intersect($instituteIds, $districtInstituteIds)
                                : $districtInstituteIds;
                        }

                        // Filter by divisional (narrows down from district if set)
                        if (!empty($data['divisional'])) {
                            $divisionalQuery = Institute::where('ds_id', $data['divisional']);
                            if (!empty($data['active_status'])) {
                                $divisionalQuery->where('active_status', $data['active_status']);
                            }
                            if (!empty($data['owner_ship'])) {
                                $divisionalQuery->where('ownership', $data['owner_ship']);
                            }
                            $divisionalInstituteIds = $divisionalQuery->pluck('id')->toArray();
                            $instituteIds = !empty($instituteIds)
                                ? array_intersect($instituteIds, $divisionalInstituteIds)
                                : $divisionalInstituteIds;
                        }

                        // Apply ownership and active_status independently (not tied to divisional)
                        if (empty($data['divisional']) && (!empty($data['owner_ship']) || !empty($data['active_status']))) {
                            $statusQuery = Institute::query();
                            if (!empty($data['owner_ship'])) {
                                $statusQuery->where('ownership', $data['owner_ship']);
                            }
                            if (!empty($data['active_status'])) {
                                $statusQuery->where('active_status', $data['active_status']);
                            }
                            $statusInstituteIds = $statusQuery->pluck('id')->toArray();
                            $instituteIds = !empty($instituteIds)
                                ? array_intersect($instituteIds, $statusInstituteIds)
                                : $statusInstituteIds;
                        }

                        // Filter by specific institute
                        if (!empty($data['institute_select'])) {
                            $instituteIds = !empty($instituteIds)
                                ? array_intersect($instituteIds, [$data['institute_select']])
                                : [$data['institute_select']];
                        }

                        $instituteIds = array_unique($instituteIds);
                        if (!empty($instituteIds)) {
                            $query->whereHas('institutes', function ($instituteQuery) use ($instituteIds) {
                                $instituteQuery->whereIn('institute_id', $instituteIds);
                            });
                        }
                    })
            ]);
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
            'index' => Pages\ListTrainees::route('/'),
            'create' => Pages\CreateTrainee::route('/create'),
            'view' => Pages\ViewTrainee::route('/{record}'),
            'edit' => Pages\EditTrainee::route('/{record}/edit'),
        ];
    }
}
