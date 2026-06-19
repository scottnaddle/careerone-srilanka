<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyRecruiterApprovalResource\Pages;
use App\Filament\Resources\CompanyRecruiterApprovalResource\RelationManagers;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;


class CompanyRecruiterApprovalResource extends Resource
{
    protected static ?string $model = CompanyRecruiter::class;
    protected static ?string $modelLabel = null;
    public static function getModelLabel(): string
    {
        return trans('admin/performance.Company Recruiters Approval List');
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $totalCompany;
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If naita_admin, only get company users of companies where is_belongs_naita = true
        if (auth('admin')->user()?->hasRole('naita_admin')) {
            $query->whereHas('company', function (Builder $q) {
                $q->where('is_belongs_to_naita', true);
            });
        }

        return $query;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('company_id')
                    ->label(__('company.name'))
                    ->options(Company::whereNotNull('verified_by')
                    ->whereNotNull('verified_at')
                    ->where('active', true)->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->columnSpan('full')
                    ->placeholder('Select a company'),
                Forms\Components\TextInput::make('first_name')
                    ->label(trans('cgo.first_name'))
                    ->columnSpan('full')
                    ->required(),
//                Forms\Components\TextInput::make('username')
//                    ->label('User Name')
//                    ->columnSpan('full')
//                    ->required(),

                Forms\Components\TextInput::make('last_name')
                    ->label(trans('cgo.last_name'))
                    ->columnSpan('full')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique()
                    ->columnSpan('full')
                    ->required(),

                    Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->columnSpan('full')
                    ->visible(fn ($record) => $record === null)
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                Forms\Components\TextInput::make('telephone')
                    ->label(trans('system.form.telephone'))
                    ->tel()
                    ->columnSpan('full')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $searchService = new SearchComponentAdminService(
            new \App\Models\Company(),
            new \App\Models\District(),
            new \App\Models\Sector()
        );
        $query = $searchService->searchCompanyUser([
            'company_id' => request()->query('company_id', null),
            'check_approval'=>true
        ]);
        if (auth('admin')->user()?->hasRole('naita_admin')) {
            $query->whereHas('company', function (Builder $q) {
                $q->where('is_belongs_to_naita', true);
            });
        }
        self::$totalCompany = $query->count();

        return $table
            ->query(
                $query
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin/dashboard.company_recruiter_user.name'))
                    ->limit(50)
                    ->getStateUsing(function ($record) {
                        return $record->first_name . ' ' . $record->last_name ?? 'N/A';
                    })
                    ->sortable(['first_name', 'last_name'])
                    ->searchable(['first_name', 'last_name']),

                Tables\Columns\TextColumn::make('district_name')
                    ->label(__('admin/dashboard.company_recruiter_user.district'))
                    ->sortable(['first_name', 'last_name'])
                    ->getStateUsing(function ($record) {
                        return $record->company->district->name ?? 'N/A';
                    }),
                    Tables\Columns\TextColumn::make('company.name')
                    ->label(__('admin/dashboard.company_recruiter_user.company'))
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
//                    Tables\Columns\TextColumn::make('approval')
//                    ->label(__('admin/dashboard.company_recruiter_user.approval'))
//                    ->getStateUsing(function ($record) {
//                        return $record->statusCompanyUser();
//                    })
//                    ->formatStateUsing(fn($state) => match($state) {
//                        'Verified' => "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>",
//                        'Request' => "<span style='font-size:12px;color: #a1a1a1; background-color: #dfdada; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>".__('admin/dashboard.company_recruiter_user.request')."</span>",
//                        default => "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>".__('admin/dashboard.company_recruiter_user.rejected')."</span>",
//                    })
//                    ->html(),

            ])->searchPlaceholder(__('admin/dashboard.company_recruiter_user.name'))
            ->filters([
                Tables\Filters\SelectFilter::make('company_id')
                    ->label(__('admin/dashboard.company_recruiter_user.company'))
                    ->options(function () {
                        $query = Company::whereNotNull('verified_by')
                            ->whereNotNull('verified_at')
                            ->where('active', true);

                        if (auth('admin')->user()?->hasRole('naita_admin')) {
                            $query->where('is_belongs_to_naita', true);
                        }

                        return $query->pluck('name', 'id');
                    })
                    ->preload()
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['value']) && !empty($data['value'])) {
                            $query->where('company_id', $data['value']);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(__('admin/dashboard.view_more'))->color('primary'),
            ])
            ->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCompanyRecruiterApprovals::route('/'),
            'create' => Pages\CreateCompanyRecruiterApproval::route('/create'),
            'view' => Pages\ViewCompanyRecruiterApproval::route('/{record}'),
            'edit' => Pages\EditCompanyRecruiterApproval::route('/{record}/edit'),
        ];
    }
}
