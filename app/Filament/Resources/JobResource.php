<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Models\Company;
use App\Models\District;
use App\Models\DivisionalSecretariats;
use App\Models\Institute;
use App\Models\Job;
use App\Models\Province;
use App\Models\Sector;
use App\Services\Admin\JobService;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Enums\JobStatusEnum;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected $jobService = JobService::class;
    public static $totalResults;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Select::make('job_type')
                    ->label('Job type')
                    ->options([
                        'Permanent' => 'Permanent',
                        'Contract base' => 'Contract-based',
                    ])
                    ->nullable(),

                Select::make('sector_id')
                    ->label('Job catagory')
                    ->options(function () {
                        return \App\Models\Sector::all()->pluck('name', 'id')->toArray();
                    })
                    ->required(),

                Select::make('company_id')
                    ->label('Company')
                    ->options(function () {
                        return \App\Models\Company::whereNotNull('verified_by')
                        ->whereNotNull('verified_at')
                        ->where('active', true)->pluck('name', 'id')->toArray();
                    })
                    ->disabled(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),


                DateTimePicker::make('working_day')
                    ->required(),
                DateTimePicker::make('start_date')
                    ->nullable(),

                TimePicker::make('start_time')
                    ->nullable(),
                // ->maxLength(255),

                TimePicker::make('end_time')
                    ->label('End time')
                    ->nullable(),


                TextInput::make('min_salary')
                    ->label('Min salary')
                    ->nullable(),

                TextInput::make('max_salary')
                    ->label('Max salary')
                    ->nullable(),

                Radio::make('discussion_salary')
                    ->options([
                        '1' => 'Discussion available',
                    ]),


                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        '0' => 'Male',
                        '1' => 'Female',
                        '2' => 'N/A',
                    ])
                    ->nullable()
                    ->columnSpan('full'),
                TextInput::make('min_age')
                    ->label('Min age')
                    ->numeric()
                    ->nullable(),
                TextInput::make('max_age')
                    ->label('Max age')
                    ->numeric()
                    ->nullable(),
                Radio::make('not_limit_age')
                    ->options([
                        '1' => 'Discussion available',
                    ]),
                TextInput::make('min_work_experience')
                    ->label('Min work experience')
                    ->nullable(),
                TextInput::make('max_work_experience')
                    ->label('Max work experience')
                    ->nullable(),
                Radio::make('not_limit_experience')
                    ->options([
                        '1' => 'Discussion available',
                    ]),
                TextInput::make('required_skills')
                    ->label('Required skills')
                    ->nullable(),
                DateTimePicker::make('application_starttime')
                    ->required(),
                DateTimePicker::make('application_endtime')
                    ->required(),

                TextInput::make('hr_name')
                    ->label('HR name')
                    ->nullable(),
                TextInput::make('hr_email')
                    ->label('HR email')
                    ->nullable(),
                TextInput::make('hr_contact_info')
                    ->label('HR contact information')
                    ->nullable(),
                TextInput::make('roles')
                    ->label('Roles')
                    ->nullable(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        '1' => 'Progress',
                        '0' => 'Close',
                    ])
                    ->nullable()
                // ->default(fn($record) => $record->gender),

            ]);
    }
    public static function table(Table $table): Table
    {
        $user = auth('admin')->user();
        $jobService = new JobService(new Job());
        self::$totalResults = $jobService->getAllJob([
            'sector' => request()->query('sector', null),
            'district' => request()->query('district', null),
            'start' => request()->query('start', null),
            'end' => request()->query('end', null),
            'status' => request()->query('status', null)
        ])->count();
        return $table
            // ->query(
            //     $jobService->getAllJob([
            //         'sector' => request()->query('sector', null),
            //         'district' => request()->query('district', null),
            //         'start' => request()->query('start', null),
            //         'end' => request()->query('end', null),
            //         'status' => request()->query('status', null)
            //     ])
            // )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('company.name')
                    ->label(__('admin/dashboard.compnay_job.company_name'))
                    ->sortable()->wrap(),
                Tables\Columns\TextColumn::make('title')->label(__('admin/dashboard.job.job_title'))->sortable()->searchable()->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin/dashboard.ojt.registration_date'))
                    ->date('Y-m-d')
                    ->sortable()->alignCenter(),
                //                Tables\Columns\TextColumn::make('application_starttime')
                //                    ->label(__('Start Date'))
                //                    ->date('Y-m-d')->sortable(),
                //
                //                Tables\Columns\TextColumn::make('application_endtime')
                //                    ->label(__('admin/dashboard.job.close_date'))
                //                    ->sortable()
                //                    ->formatStateUsing(function ($state) {
                //                        return $state != '' ? date('Y-m-d', strtotime($state)) : 'N/G';
                //                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('admin/dashboard.job.status'))
                    ->getStateUsing(function ($record) {
                        return match ($record->status) {
                            JobStatusEnum::CANCEL->value =>  getCodeNameByCodeId('job_status', JobStatusEnum::CANCEL->value),
                            JobStatusEnum::PROGRESS->value =>getCodeNameByCodeId('job_status', JobStatusEnum::PROGRESS->value),
                            JobStatusEnum::COMPLETED->value =>getCodeNameByCodeId('job_status', JobStatusEnum::COMPLETED->value ),
                            default => __('admin/dashboard.job.unknown'),
                        };
                    })
                    ->badge()
                    ->icon('entypo-dot-single')
                    ->color(function (string $state): string {
                        return match ($state) {
                            getCodeNameByCodeId('job_status', JobStatusEnum::CANCEL->value) => 'danger',
                            getCodeNameByCodeId('job_status', JobStatusEnum::PROGRESS->value) => 'info',
                            getCodeNameByCodeId('job_status', JobStatusEnum::COMPLETED->value ) => 'success',
                            default => 'secondary',
                        };
                    })
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('appliesTypeApply')
                    ->label(__('admin/dashboard.job.applied'))
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->appliesTypeApply()->count()),

                Tables\Columns\TextColumn::make('appliesTypeMatch')
                    ->label(__('admin/dashboard.job.matched'))
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->appliesTypeMatch()->count()),

                Tables\Columns\TextColumn::make('unread')
                    ->label(__('admin/dashboard.job.unread'))
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->unread()->count()),

                Tables\Columns\TextColumn::make('shortlist')
                    ->label(__('admin/dashboard.job.shortlistee'))
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->shortlist()->count()),
            ])->searchPlaceholder('Job Title')
            ->filters([
                Tables\Filters\Filter::make('advanced')
                    ->form([
                        Forms\Components\Select::make('district')
                            ->label('District')
                            ->options(District::pluck('name', 'id'))
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('company_id', null)),

                        Forms\Components\Select::make('company_id')
                            ->label('Company name')
                            ->options(function (callable $get) {
                                $district = $get('district');
                                return $district
                                    ? Company::where('district_id', $district)->pluck('name', 'id')
                                    : Company::pluck('name', 'id');
                            })
                            ->preload()
                            ->searchable()
                            ->reactive(),
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data) {
                        if (!empty($data['district'])) {
                            $query->whereHas('company', fn($q) => $q->where('district_id', $data['district']));
                        }

                        if (!empty($data['company_id'])) {
                            $query->where('company_id', $data['company_id']);
                        }
                    }),


                Tables\Filters\SelectFilter::make('sector_id')
                    ->label(__('admin/dashboard.job.sector'))
                    ->options(Sector::pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\SelectFilter::make('status')
                    ->label(__('admin/dashboard.ojt.status'))
                    ->options(
                        collect(JobStatusEnum::getAllStatus())->mapWithKeys(function ($label, $status) {
                            return [$status => $label];
                        })
                    )
                    ->query(function ($query, array $data) {
                        if (isset($data['value']) && $data['value'] !== '') {
                            return $query->where('status', $data['value']);
                        }
                        return $query;
                    })
                    ,
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_at')
                            ->label(__('admin/dashboard.ojt.registration_date')),
                    ])
                    ->query(
                        fn($query, array $data) =>
                        isset($data['created_at'])
                            ? $query->whereDate('created_at', $data['created_at'])
                            : $query
                    ),
            ])

            ->paginated([10, 25, 50, 100])
            ->actions([

                ViewAction::make()->label(__('admin/dashboard.job.view_more'))
                    ->iconPosition('after')
                    ->icon('heroicon-o-chevron-right')
                    ->url(fn($record) => url('admin/jobs/' . $record->id . '/' . 'view-candidate/'))
                    ->color('info'),
            ])
            ->recordUrl(
                fn(Job $record): string => Pages\ViewJobs::getUrl([$record->id]),
            )
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListJobs::route('/'),
            // 'edit' => Pages\EditJobs::route('/{record}/edit'),
            'view' => Pages\ViewJobs::route('/{record}/view'),
            'view-candidate' => Pages\ViewCandidateJobs::route('/{record}/view-candidate')
        ];
    }
}
