<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyJobResource\Pages;
use App\Filament\Resources\CompanyJobResource\RelationManagers;
use App\Models\Company;
use App\Models\CompanyJob;
use App\Models\District;
use App\Models\Sector;
use App\Services\Admin\CompanyJobService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyJobResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected $companyJobService = CompanyJobService::class;
    public static $totalResults;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $companyJobService = new CompanyJobService(new Company());
        self::$totalResults = $companyJobService->getAllCompany([
            'sector' => request()->query('sector', null),
            'district' => request()->query('district', null),
            'status' => request()->query('status', null)
        ])->count();

        return $table
            ->query(
                $companyJobService->getAllCompany([
                    'sector' => request()->query('sector', null),
                    'district' => request()->query('district', null),
                    'status' => request()->query('status', null)
                ])
            )
            ->modifyQueryUsing(function ($query) {
                $admin = auth('admin')->user();
                if ($admin && $admin->hasRole('naita_admin')) {
                    $query->where('is_belongs_to_naita', true);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.compnay_job.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->limit(50)
                    ->label(__('admin/dashboard.compnay_job.company_name'))
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('district.name')
                    ->label(__('admin/dashboard.compnay_job.district'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('jobs')
                    ->label(__('admin/dashboard.compnay_job.job_posting'))
                    ->getStateUsing(fn($record) => $record->jobs()->count())->alignCenter(),

                Tables\Columns\TextColumn::make('applies')
                    ->label(__('admin/dashboard.compnay_job.applied'))
                    ->getStateUsing(fn($record) => $record->applies()->count())->alignCenter(),

                Tables\Columns\TextColumn::make('matches')
                    ->label(__('admin/dashboard.compnay_job.matched'))
                    ->getStateUsing(fn($record) => $record->matches()->count())->alignCenter(),
                    Tables\Columns\TextColumn::make('approval')
                    ->label(__('admin/dashboard.company.approval'))
                    ->getStateUsing(function ($record) {
                        return $record->statusCompanyList();
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Verified' => "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>".trans('admin/performance.Verified')."</span>",
                        'Request' => "<span style='font-size:12px;color: #5a5252; background-color: #dfdada; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>".trans('admin/performance.Request')."</span>",
                        default => "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>".trans('admin/performance.Rejected')."</span>",
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? trans('auth.active') : trans('admin/status.inactive'))
                    ->color(fn($state) => $state ? 'success' : 'danger')
            ])
            ->searchPlaceholder(__('admin/dashboard.compnay_job.search_placeholder'))
            ->paginated([10, 25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('district_id')
                    ->label('District')
                    ->options(function () {
                        $admin = auth('admin')->user();
                        $districtQuery = District::query();

                        if ($admin && $admin->hasRole('naita_admin')) {
                            // Chỉ lấy các district có chứa company thuộc Naita
                            $districtQuery->whereHas('companies', function ($q) {
                                $q->where('is_belongs_to_naita', true);
                            });
                        }

                        return $districtQuery->pluck('name', 'id');
                    })
                    ->searchable(),

                Tables\Filters\SelectFilter::make('sector')
                    ->label(__('admin/dashboard.compnay_job.job_category'))
                    ->options(function () {
                        $admin = auth('admin')->user();
                        $sectorQuery = Sector::query();

                        if ($admin && $admin->hasRole('naita_admin')) {
                            // Chỉ lấy các sector có job thuộc company Naita
                            $sectorQuery->whereHas('jobCompanies.company', function ($q) {
                                $q->where('is_belongs_to_naita', true);
                            });
                        }

                        return $sectorQuery->pluck('name', 'id');
                    })
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data) {
                        if (isset($data['value']) && !empty($data['value'])) {
                            $query->whereHas('jobs', function ($query) use ($data) {
                                $query->where('jobs.sector_id', $data['value']);
                            });
                        }
                    })
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make()
                    ->label(__('admin/dashboard.compnay_job.view_more'))
                    ->color('primary')
                    ->icon('heroicon-o-eye'),
            ])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
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
            'index' => Pages\ListCompanyJobs::route('/'),
            // 'create' => Pages\CreateCompanyJob::route('/create'),
            // 'edit' => Pages\EditCompanyJob::route('/{record}/edit'),
            'view' => Pages\ViewCompanyJob::route('{record}/view'),
            'view-job-details' => Pages\ViewJobDetail::route('{record}/{job}/details'),
            'view-job-candidate' => Pages\ViewJobCandidate::route('{record}/{job}/view-candidate')
        ];
    }
}
