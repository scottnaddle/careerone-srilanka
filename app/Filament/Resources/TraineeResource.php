<?php

namespace App\Filament\Resources;

use App\Exports\TraineeExporter;
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
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class TraineeResource extends Resource
{
    protected static ?string $model = TraineeUser::class;

    protected static ?string $navigationLabel = 'Trainee ';
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
        $query = TraineeUser::query();
        $user = auth('admin')->user();

        if (!$user->hasRole('super_admin')) {
            $query->whereHas('institutes', function ($q) use ($user) {
                $q->where('institute_head_office', $user->tvet_type);
            });
        }
        return $table->paginated([10, 25, 50, 100])
            ->query($query)
            ->headerActions([
                Action::make('export')
                    ->label('Export')
                    ->color('success')
                    ->action(function ($livewire) {
                        return static::exportData($livewire->getFilteredTableQuery());
                    })
                    ->button(),
            ])
            ->searchPlaceholder('Email, NIC or Name')
            // ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true))
            ->columns([
                Tables\Columns\TextColumn::make('index')
                ->label(__('admin/dashboard.content.no'))
                ->rowIndex()
                ->alignCenter(),

//                Tables\Columns\TextColumn::make('institutes.name')->limit(50)
//                    ->label(__('admin/dashboard.trainee.institute')),
                Tables\Columns\TextColumn::make('institutes_info')
                    ->label(__('admin/dashboard.trainee.institute'))
                    ->getStateUsing(function ($record) {
                        $user = auth('admin')->user();

                        $traineeInstitutes = $record->traineeInstitutes()
                            ->with('institute')
                            ->when(!$user->hasRole('super_admin'), function ($query) use ($user) {
                                $query->whereHas('institute', function ($q) use ($user) {
                                    $q->where('institute_head_office', $user->tvet_type);
                                });
                            })
                            ->orderBy('start_date', 'desc')
                            ->get();

                        if ($traineeInstitutes->isEmpty()) {
                            return '<span class="text-gray-400">N/A</span>';
                        }

                        $html = '<div class="space-y-1">';
                        foreach ($traineeInstitutes as $item) {
                            $startDate = $item->start_date ? date('d/m/Y', strtotime($item->start_date)) : 'N/A';
                            $endDate = $item->end_date ? date('d/m/Y', strtotime($item->end_date)) : 'Present';
                            $html .= '<div class="whitespace-nowrap">● ' . e($item->institute->name) . ' (' . $startDate . ' - ' . $endDate . ')</div>';
                        }
                        $html .= '</div>';

                        return $html;
                    })
                    ->html()
                    ->extraAttributes(['style' => 'min-width: 300px; white-space: normal;']),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->label(__('admin/dashboard.trainee.name')),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label(__('admin/dashboard.trainee.email')),
                Tables\Columns\TextColumn::make('nic')
                    ->label('NIC')->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nvq_level')
                    ->label('NVQ Level (Latest)')
                    ->getStateUsing(function ($record) {
                        // Get the most recent training history
                        $latestTraining = $record->traineeInformation()
                            ->orderBy('updated_at', 'desc')
                            ->first();

                        if ($latestTraining && $latestTraining->nvq_content) {
                            $nvqData = json_decode($latestTraining->nvq_content, true);
                            if (is_array($nvqData) && !empty($nvqData) && isset($nvqData[0]['QUALIFICATION_LEVEL'])) {
                                return $nvqData[0]['QUALIFICATION_LEVEL'];
                            }
                        }
                        return 'N/A';
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'L1' => 'gray',
                        'L2' => 'info',
                        'L3' => 'primary',
                        'L4' => 'success',
                        'L5' => 'warning',
                        'L6' => 'danger',
                        'L7' => 'purple',
                        'N/A' => 'secondary',
                        default => 'secondary',
                    })
                    ->alignCenter()
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        // Cast JSON to text before comparing
                        return $query->orderBy(function ($subQuery) {
                            $subQuery->selectRaw("
                            CASE
                                WHEN tn.nvq_content::text IS NULL
                                     OR tn.nvq_content::text = ''
                                     OR tn.nvq_content::text = '[]'
                                     OR tn.nvq_content::text = 'null'
                                THEN 'N/A'
                                ELSE tn.nvq_content::json->0->>'QUALIFICATION_LEVEL'
                            END
            ")
                                ->from('trainee_training_histories as tn')
                                ->whereColumn('tn.trainee_id', 'trainee_users.id')
                                ->orderBy('tn.updated_at', 'desc')
                                ->limit(1);
                        }, $direction);
                    }),
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
//                Tables\Actions\EditAction::make()->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
                Tables\Actions\EditAction::make(),
                Action::make('deactivate')
                ->label(__('Deactivate'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['active' => false]);
                })
                ->hidden(fn ($record) => $record->active === false),
//                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            Action::make('activate')
                ->label(__('Activate'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['active' => true]);
                })
                ->hidden(fn ($record) => $record->active === true),
//                ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->filters([
                Tables\Filters\Filter::make('search')
                    ->form([
                        Forms\Components\Select::make('provin')
                            ->label('Province')
                            ->options(function () {
                                $user = auth('admin')->user();
                                if (!$user->hasRole('super_admin')) {
                                    // If not super admin, only get provinces of institutes the user manages
                                    return Province::whereHas('districts.institutes', function($q) use ($user) {
                                        $q->where('institutes.institute_head_office', $user->tvet_type);
                                    })->pluck('name', 'id');
                                }
                                return Province::all()->pluck('name', 'id');
                            })
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
                                $user = auth('admin')->user();
                                $provin = $get('provin');

                                $query = District::query();

                                if (!$user->hasRole('super_admin')) {
                                    $query->whereHas('institutes', function($q) use ($user) {
                                        $q->where('institutes.institute_head_office', $user->tvet_type);
                                    });
                                }

                                if ($provin) {
                                    $query->where('prov_id', $provin);
                                }

                                return $query->pluck('name', 'id');
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
                                $user = auth('admin')->user();
                                $district = $get('district');

                                $query = DivisionalSecretariats::query();

                                if (!$user->hasRole('super_admin')) {
                                    $query->whereHas('institutes', function($q) use ($user) {
                                        $q->where('institutes.institute_head_office', $user->tvet_type);
                                    });
                                }

                                if ($district) {
                                    $query->where('dist_id', $district);
                                }

                                return $query->pluck('ds_name', 'ds_code');
                            })
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('owner_ship', null);
                                $set('active_status', null);
                                $set('institute_select', null);
                            }),

                        Forms\Components\Select::make('owner_ship')
                            ->label('Owner Ship')
                            ->options(function ($get) {
                                $user = auth('admin')->user();
                                $language = app()->getLocale();

                                $ownershipList = getCodeList('ownership', $language)->pluck('code_name', 'code_name');

                                if (!$user->hasRole('super_admin')) {
                                    // Only show ownerships present in the institutes the user manages
                                    $availableOwnerships = Institute::where('institute_head_office', $user->tvet_type)
                                        ->distinct()
                                        ->pluck('ownership')
                                        ->toArray();

                                    return $ownershipList->filter(function($value, $key) use ($availableOwnerships) {
                                        return in_array($key, $availableOwnerships);
                                    });
                                }

                                return $ownershipList;
                            })
                            ->preload()
                            ->searchable(),

                        Forms\Components\Select::make('active_status')
                            ->label('Active Status')
                            ->options(function ($get) {
                                $user = auth('admin')->user();

                                $query = Institute::query();

                                if (!$user->hasRole('super_admin')) {
                                    $query->where('institute_head_office', $user->tvet_type);
                                }

                                return $query->select(\DB::raw('COUNT(*) as count'), 'active_status')
                                    ->groupBy('active_status')
                                    ->pluck('active_status', 'active_status');
                            })
                            ->preload()
                            ->searchable(),

                        Forms\Components\Select::make('institute_select')
                            ->label('Institute')
                            ->options(function ($get) {
                                $user = auth('admin')->user();
                                $divisional = $get('divisional');

                                $query = Institute::query();

                                // Authorization: if not super admin, only get the user's own institutes
                                if (!$user->hasRole('super_admin')) {
                                    $query->where('institute_head_office', $user->tvet_type);
                                }

                                if ($divisional) {
                                    $query->where('ds_id', $divisional);
                                }

                                return $query->pluck('name', 'id');
                            })
                            ->preload()
                            ->searchable(),

                        Forms\Components\Select::make('nvq_level')
                            ->label('NVQ Level')
                            ->options([
                                'L1' => 'Level 1',
                                'L2' => 'Level 2',
                                'L3' => 'Level 3',
                                'L4' => 'Level 4',
                                'L5' => 'Level 5',
                                'L6' => 'Level 6',
                                'L7' => 'Level 7',
                            ])
                            ->preload()
                            ->searchable()
                            ->placeholder('Select NVQ Level'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $user = auth('admin')->user();

                        // Check whether any institute filter is set
                        $hasInstituteFilter = !empty($data['provin'])
                            || !empty($data['district'])
                            || !empty($data['divisional'])
                            || !empty($data['owner_ship'])
                            || !empty($data['active_status'])
                            || !empty($data['institute_select']);

                        if ($hasInstituteFilter) {
                            $query->whereHas('institutes', function (Builder $q) use ($data, $user) {

                                // Authorization condition: required
                                if (!$user->hasRole('super_admin')) {
                                    $q->where('institutes.institute_head_office', $user->tvet_type);
                                }

                                // Combine the filter conditions
                                $q->where(function ($subQuery) use ($data) {
                                    // Filter by institute directly
                                    if (!empty($data['institute_select'])) {
                                        $subQuery->where('institutes.id', $data['institute_select']);
                                    }

                                    // Filter by divisional
                                    if (!empty($data['divisional'])) {
                                        $subQuery->where('institutes.ds_id', $data['divisional']);
                                    }

                                    // Filter by district
                                    if (!empty($data['district'])) {
                                        $subQuery->where('institutes.dist_id', $data['district']);
                                    }

                                    // Filter by province
                                    if (!empty($data['provin'])) {
                                        $subQuery->whereIn('institutes.dist_id', function ($sub) use ($data) {
                                            $sub->select('id')
                                                ->from('districts')
                                                ->where('prov_id', $data['provin']);
                                        });
                                    }

                                    // Filter by ownership
                                    if (!empty($data['owner_ship'])) {
                                        $subQuery->where('institutes.ownership', $data['owner_ship']);
                                    }

                                    // Filter by active_status
                                    if (!empty($data['active_status'])) {
                                        $subQuery->where('institutes.active_status', $data['active_status']);
                                    }
                                });
                            });
                        } else {
                            // If no institute filter is set, authorization must still be applied
                            if (!$user->hasRole('super_admin')) {
                                $query->whereHas('institutes', function (Builder $q) use ($user) {
                                    $q->where('institutes.institute_head_office', $user->tvet_type);
                                });
                            }
                        }

                        // Filter by NVQ Level
                        if (!empty($data['nvq_level'])) {
                            $query->whereHas('traineeInformation', function ($trainingQuery) use ($data) {
                                $trainingQuery->whereNotNull('nvq_content')
                                    ->whereRaw("nvq_content::json->0->>'QUALIFICATION_LEVEL' = ?", [$data['nvq_level']]);
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

    /**
     * Export data to Excel with professional formatting
     */
    public static function exportData($query): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $results = $query->get();

        if ($results->isEmpty()) {
            \Filament\Notifications\Notification::make()
                ->title('No data to export')
                ->warning()
                ->send();
            return redirect()->back();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Trainee List');

        $highestColumn = 'T';

        // Write Title
        $sheet->setCellValue('A1', 'TRAINEE USERS REPORT');
        $sheet->mergeCells("A1:{$highestColumn}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Report Time
        $sheet->setCellValue('A2', 'Report Time: ' . now()->format('Y-m-d H:i:s'));
        $sheet->mergeCells("A2:{$highestColumn}2");

        // Period
        $sheet->setCellValue('A3', 'Period: All Time');
        $sheet->mergeCells("A3:{$highestColumn}3");

        // Description
        $sheet->setCellValue('A4', 'Description: This report displays details and statistics of registered trainee users.');
        $sheet->mergeCells("A4:{$highestColumn}4");

        $sheet->getStyle('A2:A4')->applyFromArray([
            'font' => [
                'size' => 10,
                'color' => ['rgb' => '475569'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->setCellValue('A5', ''); // Spacer row

        // Headers
        $headers = [
            'No.', 'NIC', 'Full Name', 'Email', 'Gender', 'Telephone', 'Mobile', 
            'Permanent Address', 'Contact Address', 'Surname', 'Initials', 'Institute', 
            'NVQ Level (Latest)', 'Recommended By', 'Career Tests', 'Portfolios', 
            'Counseling', 'Job Applications', 'Status', 'Created At'
        ];

        foreach ($headers as $colIndex => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $sheet->setCellValue($colLetter . '6', $header);
        }

        $sheet->getStyle("A6:{$highestColumn}6")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '4984F6'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7EFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        $row = 7;
        $user = auth('admin')->user();
        foreach ($results as $index => $record) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $record->nic);
            $sheet->setCellValue('C' . $row, $record->full_name);
            $sheet->setCellValue('D' . $row, $record->email);
            
            $gender = $record->gender == '1' ? 'Male' : ($record->gender == '2' ? 'Female' : 'N/A');
            $sheet->setCellValue('E' . $row, $gender);
            
            $sheet->setCellValue('F' . $row, $record->telephone);
            $sheet->setCellValue('G' . $row, $record->mobile);
            $sheet->setCellValue('H' . $row, $record->permanant_address);
            $sheet->setCellValue('I' . $row, $record->contact_address);
            $sheet->setCellValue('J' . $row, $record->std_surname);
            $sheet->setCellValue('K' . $row, $record->std_initials);

            // Institute Info
            $traineeInstitutes = $record->traineeInstitutes()
                ->with('institute')
                ->when(!$user->hasRole('super_admin'), function ($q) use ($user) {
                    $q->whereHas('institute', function ($qi) use ($user) {
                        $qi->where('institute_head_office', $user->tvet_type);
                    });
                })
                ->orderBy('start_date', 'desc')
                ->get();

            if ($traineeInstitutes->isEmpty()) {
                $instituteText = 'N/A';
            } else {
                $institutesList = [];
                foreach ($traineeInstitutes as $item) {
                    $startDate = $item->start_date ? date('d/m/Y', strtotime($item->start_date)) : 'N/A';
                    $endDate = $item->end_date ? date('d/m/Y', strtotime($item->end_date)) : 'Present';
                    $institutesList[] = $item->institute->name . ' (' . $startDate . ' - ' . $endDate . ')';
                }
                $instituteText = implode('; ', $institutesList);
            }
            $sheet->setCellValue('L' . $row, $instituteText);

            // NVQ Level
            $latestTraining = $record->traineeInformation()
                ->orderBy('updated_at', 'desc')
                ->first();

            $nvqLevel = 'N/A';
            if ($latestTraining && $latestTraining->nvq_content) {
                $nvqData = json_decode($latestTraining->nvq_content, true);
                if (is_array($nvqData) && !empty($nvqData) && isset($nvqData[0]['QUALIFICATION_LEVEL'])) {
                    $nvqLevel = $nvqData[0]['QUALIFICATION_LEVEL'];
                }
            }
            $sheet->setCellValue('M' . $row, $nvqLevel);

            // Recommended By
            $recommendedBy = '';
            if ($record->recommended_by_user_id != null && $record->recommended_by_user_system != null) {
                if ($record->recommended_by_user_system == 'cgo') {
                    $recUser = \App\Models\CgoUser::where('id', $record->recommended_by_user_id)->first();
                    $headOffice = $recUser->institute?->reg_no ?? 'N/A';
                    $recommendedBy = strtoupper($record->recommended_by_user_system) . ' - ' .
                        ($recUser?->fullName ?? 'Unknown') . ' (' . $headOffice . ')';
                } else {
                    $recUser = \App\Models\AdminUser::where('id', $record->recommended_by_user_id)->first();
                    $headOffice = $recUser->tvet_type ?? 'N/A';
                    $recommendedBy = strtoupper($record->recommended_by_user_system) . ' - ' .
                        ($recUser?->fullName ?? 'Unknown') . ' (' . $headOffice . ')';
                }
            }
            $sheet->setCellValue('N' . $row, $recommendedBy);

            // Counts & Status
            $sheet->setCellValue('O' . $row, $record->careerTest()->count());
            $sheet->setCellValue('P' . $row, $record->portfolio()->count());
            $sheet->setCellValue('Q' . $row, $record->cgoCounseling()->count());
            $sheet->setCellValue('R' . $row, $record->jobApplies()->count());
            $sheet->setCellValue('S' . $row, $record->active ? 'Active' : 'Inactive');
            $sheet->setCellValue('T' . $row, $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : '');

            $row++;
        }

        $lastDataRow = $row - 1;

        // Styles for data rows
        $sheet->getStyle("A7:{$highestColumn}{$lastDataRow}")->applyFromArray([
            'font' => [
                'color' => ['rgb' => '475569'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Left align descriptions
        foreach (['C', 'D', 'H', 'I', 'L', 'N'] as $col) {
            $sheet->getStyle("{$col}7:{$col}{$lastDataRow}")
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }

        // Borders
        $sheet->getStyle("A6:{$highestColumn}{$lastDataRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        // Set Heights
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(15);
        $sheet->getRowDimension(6)->setRowHeight(25);
        for ($r = 7; $r <= $lastDataRow; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(20);
        }

        // Summary Section
        $summaryRow = $lastDataRow + 2;
        $sheet->setCellValue('A' . $summaryRow, 'SUMMARY');
        $sheet->getStyle('A' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1E293B']],
        ]);

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Total Trainees:');
        $sheet->setCellValue('B' . $summaryRow, $results->count());
        
        $maleCount = $results->filter(fn($t) => $t->gender == '1')->count();
        $femaleCount = $results->filter(fn($t) => $t->gender == '2')->count();
        
        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Male Trainees:');
        $sheet->setCellValue('B' . $summaryRow, $maleCount);

        $summaryRow++;
        $sheet->setCellValue('A' . $summaryRow, 'Female Trainees:');
        $sheet->setCellValue('B' . $summaryRow, $femaleCount);

        $sheet->getStyle("A" . ($lastDataRow + 3) . ":B" . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '1E293B']],
        ]);

        // Auto-fit column widths
        for ($col = 1; $col <= 20; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $fileName = 'trainee_export_' . now()->format('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'trainees_');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
