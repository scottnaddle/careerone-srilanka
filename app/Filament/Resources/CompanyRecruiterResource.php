<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyRecruiterResource\Pages;
use App\Filament\Resources\CompanyRecruiterResource\RelationManagers;
use App\Imports\CompanyRecruitersImport;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;
use App\Models\Company;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CompanyRecruiterResource extends Resource
{
    protected static ?string $model = CompanyRecruiter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $totalCompany;
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('company_id')
                ->label(__('company.name'))
                ->options(function () {
                    return Company::whereNotNull('verified_by')
                        ->whereNotNull('verified_at')
                        ->where('active', true)
                        ->pluck('name', 'id')
                        ->toArray();
                })
                ->searchable()
                ->getSearchResultsUsing(fn (string $search): array =>
                Company::where('name', 'like', "%{$search}%")
                    ->whereNotNull('verified_by')
                    ->whereNotNull('verified_at')
                    ->where('active', true)
                    ->limit(50)
                    ->pluck('name', 'id')
                    ->toArray()
                )
                ->getOptionLabelUsing(fn ($value): ?string =>
                Company::find($value)?->name
                )
                ->required()
                ->columnSpan('full')
                ->placeholder(__('admin/dashboard.company_recruiter_user.select_company')),

            Forms\Components\TextInput::make('first_name')
                ->label(__('admin/dashboard.company_recruiter_user.first_name'))
                ->columnSpan('full')
                ->required(),

            Forms\Components\TextInput::make('last_name')
            ->columnSpan('full')
                ->label(__('admin/dashboard.company_recruiter_user.last_name'))
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label(__('admin/dashboard.company_recruiter_user.email'))
                ->columnSpan('full')
                ->required(),

            Forms\Components\TextInput::make('password')
                ->columnSpan('full')
                ->label(__('admin/dashboard.company_recruiter_user.password'))
                ->password()
                ->required()
                ->visible(fn ($record) => $record === null)
                ->dehydrateStateUsing(fn($state) => Hash::make($state)),

            Forms\Components\TextInput::make('telephone')
                ->label(__('admin/dashboard.company_recruiter_user.telephone'))
                ->columnSpan('full')
                ->tel()
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
        ]);
        self::$totalCompany = $query->count();

        return $table
        ->searchPlaceholder('Name')
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
                    ->searchable(['first_name', 'last_name'])
                    ->wrap(),

               Tables\Columns\TextColumn::make('district_name')
                   ->label(__('admin/dashboard.member_signup.company'))
                   ->sortable()
                   ->getStateUsing(function ($record) {
                       return $record->company->name ?? 'N/A';
                   })
                   ->wrap(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin/dashboard.company_recruiter_user.email'))->sortable()->wrap(),
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
                    })
                    ->wrap(),
                     Tables\Columns\TextColumn::make('approval')
                     ->getStateUsing(function ($record) {
                         return $record->statusCompanyUser();
                     })
                     ->formatStateUsing(fn($state) => match($state) {
                         'Verified' => "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>",
                         'Request' => "<span style='font-size:12px;color: #5a5252; background-color: #dfdada; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>".__('admin/dashboard.company_recruiter_user.request')."</span>",
                         default => "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>".__('admin/dashboard.company_recruiter_user.rejected')."</span>",
                     })
                     ->html(),
                    Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger')

            ])
            ->paginated([10, 25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('district')
                    ->options(function () {
                        return \App\Models\District::pluck('name', 'id');
                    })
                    ->preload()
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['value']) && !empty($data['value'])) {
                            $query->whereHas('company', function ($query) use ($data) {
                                $query->where('companies.district_id', $data['value']);
                            });
                        }
                    }),

                Tables\Filters\Filter::make('approval')
                    ->form([
                        Forms\Components\Select::make('approval')
                            ->options([
                                '1' => 'Approved',
                                '2' => 'Request',
                                '3' => 'Rejected'
                            ])
                            ->preload()
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['approval']) && !empty($data['approval'])) {
                            if ($data['approval'] === '1') {
                                $query->whereNotNull('verify_by')
                                      ->whereNotNull('verify_at')
                                      ->whereNotNull('email_verified_at');
                            } elseif ($data['approval'] === '2') {
                                $query->whereNull('verify_by')
                                      ->whereNotNull('email_verified_at')
                                      ->whereNull('verify_at');
                            } else {
                                $query->whereNull('verify_by')
                                      ->whereNull('email_verified_at')
                                      ->whereNull('verify_at');
                            }
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->iconButton()
                    ->tooltip('View'),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit')
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),

                Action::make('approve')
                    ->label(__('Approve'))
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->iconButton()
                    ->tooltip('Approve')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Recruiter')
                    ->action(function ($record) {
                        $record->update([
                            'verify_at' => now(),
                            'verify_by' => auth('admin')->id(),
                            'active' => true,
                        ]);
                        \Filament\Notifications\Notification::make()
                            ->title('Recruiter Approved')
                            ->success()
                            ->send();
                    })
                    ->hidden(fn($record) => $record->verify_at !== null)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),

                Action::make('reject')
                    ->label(__('Reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color('gray')
                    ->iconButton()
                    ->tooltip('Reject')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Recruiter')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('reason')
                            ->label('Rejection Reason')
                            ->required()
                            ->maxLength(500),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'verify_at' => null,
                            'verify_by' => auth('admin')->id(),
                            'active' => false,
                            'reason' => $data['reason'],
                        ]);
                    })
                    ->hidden(fn($record) => $record->verify_at === null)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),

                Action::make('deactivate')
                    ->label(__('Deactivate'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->iconButton()
                    ->tooltip('Deactivate')
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
                    ->iconButton()
                    ->tooltip('Activate')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => true, 'verify_at' => now(), 'verify_by' => auth()->guard('admin')->id()]);
                    })
                    ->hidden(fn ($record) => $record->active === true)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),

                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete')
                    ->requiresConfirmation()
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
            ])
            ->striped()
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->headerActions([
                // Import Action
                Tables\Actions\Action::make('import_recruiters')
                    ->label('Import Recruiters')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->modalHeading('Import Company Recruiters')
                    ->modalSubheading('Upload an Excel file to import recruiters. Make sure the file follows the correct format.')
                    ->form([
                        Forms\Components\FileUpload::make('import_file')
                            ->label('Excel File')
                            ->required()
                            ->acceptedFileTypes([
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'text/csv',
                            ])
                            ->maxSize(10240)
                            ->helperText('Supported formats: .xlsx, .xls, .csv (Max: 10MB)')
                            ->directory('imports/recruiters')
                            ->preserveFilenames(),

                        Forms\Components\Placeholder::make('instructions')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <ul class="list-disc pl-4 space-y-1">
                                        <li>Click the button below to download the sample template</li>
                                        <li>Fill in the required fields (Company Name, Email, First Name, Last Name, Telephone)</li>
                                        <li>Company name must match exactly with existing verified companies</li>
                                        <li>Email must be unique - duplicates will be handled based on your selection</li>
                                        <li>Upload the completed file</li>
                                    </ul>
                                </div>
                            ')),

                        Forms\Components\Select::make('duplicate_action')
                            ->label('Handle Duplicate Emails')
                            ->options([
                                'skip' => 'Skip duplicate entries',
                                'update' => 'Update existing entries',
                            ])
                            ->default('skip')
                            ->required()
                            ->helperText('Choose how to handle recruiters with existing email addresses in the system.'),

                        Forms\Components\Toggle::make('send_welcome_email')
                            ->label('Send welcome email to new recruiters')
                            ->default(false)
                            ->helperText('If enabled, new recruiters will receive a welcome email with their login credentials.'),

                        // Download Template Button inside modal
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('download_template_modal')
                                ->label('Download Sample Template')
                                ->icon('heroicon-o-document-arrow-down')
                                ->color('gray')
                                ->action(function () {
                                    return response()->download(static::generateTemplate());
                                })
                                ->extraAttributes([
                                    'class' => 'w-full justify-center'
                                ]),
                        ]),
                    ])
                    ->action(function (array $data) {
                        try {
                            $filePath = Storage::disk('public')->path($data['import_file']);
                            $skipDuplicates = ($data['duplicate_action'] === 'skip');
                            $sendWelcomeEmail = $data['send_welcome_email'] ?? false;

                            $import = new CompanyRecruitersImport($skipDuplicates, false, $sendWelcomeEmail);

                            Excel::import($import, $filePath);

                            $import->sendWelcomeEmails();
                            // Clean up temp file
                            Storage::disk('public')->delete($data['import_file']);

                            $results = $import->getResults();

                            if (!empty($results['errors'])) {
                                $errorMessages = array_map(function($error) {
                                    return "Row: " . json_encode($error['row']) . " - Error: " . $error['error'];
                                }, array_slice($results['errors'], 0, 5));

                                Notification::make()
                                    ->title('Import Completed with Issues')
                                    ->body(sprintf(
                                        "✓ Successfully imported: %d\n⚠ Skipped: %d\n✗ Errors: %d\n\nFirst few errors:\n%s",
                                        $results['success'],
                                        $results['skipped'],
                                        count($results['errors']),
                                        implode("\n", $errorMessages)
                                    ))
                                    ->warning()
                                    ->persistent()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Import Successful')
                                    ->body(sprintf("Successfully imported %d recruiters.", $results['success']))
                                    ->success()
                                    ->send();
                            }

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Import Failed')
                                ->body('Error: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->filters([
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyRecruiters::route('/'),
            'create' => Pages\CreateCompanyRecruiter::route('/create'),
            'view' => Pages\ViewCompanyRecruiter::route('/{record}'),
            'edit' => Pages\EditCompanyRecruiter::route('/{record}/edit'),
        ];
    }

    protected static function generateTemplate()
    {
        // Headers for recruiter import
        $headers = [
            'company_name',
            'email',
            'first_name',
            'last_name',
            'telephone',
        ];

        $sampleData = [
            [
                'Sample Company Ltd',
                'recruiter@samplecompany.com',
                'John',
                'Doe',
                '+855****5678',
            ],
            [
                'Another Company Corp',
                'jane.smith@anothercompany.com',
                'Jane',
                'Smith',
                '+855****5432',
            ],
        ];

        // Get verified companies for dropdown list
        $companies = Company::whereNotNull('verified_by')
            ->whereNotNull('verified_at')
            ->where('active', true)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        $companiesList = implode(', ', array_slice($companies, 0, 20)) . (count($companies) > 20 ? '...' : '');

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // 1. Create Instructions Sheet
        $instructionSheet = $spreadsheet->getActiveSheet();
        $instructionSheet->setTitle('Instructions');

        $instructionSheet->setCellValue('A1', 'IMPORT INSTRUCTIONS - COMPANY RECRUITERS');
        $instructionSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $instructionSheet->setCellValue('A3', 'Required Fields:');
        $instructionSheet->setCellValue('A4', '• company_name');
        $instructionSheet->setCellValue('A5', '• email');
        $instructionSheet->setCellValue('A6', '• first_name');
        $instructionSheet->setCellValue('A7', '• last_name');
        $instructionSheet->setCellValue('A8', '• telephone');

        $instructionSheet->setCellValue('A10', 'Notes:');
        $instructionSheet->setCellValue('A11', '1. Company name must match EXACTLY with existing verified companies in the system');
        $instructionSheet->setCellValue('A12', '2. Email must be unique. Duplicates will be skipped or updated based on your selection');
        $instructionSheet->setCellValue('A13', '3. Telephone should include country code (e.g., +855 for Cambodia)');
        $instructionSheet->setCellValue('A14', '4. All fields are required');
        $instructionSheet->setCellValue('A15', '5. Do not modify the header row (first row)');

        $instructionSheet->setCellValue('A17', 'Available Verified Companies:');
        $instructionSheet->setCellValue('A18', $companiesList);
        $instructionSheet->getStyle('A18')->getAlignment()->setWrapText(true);

        $instructionSheet->getColumnDimension('A')->setWidth(80);
        foreach (['A3', 'A10', 'A17'] as $cell) {
            $instructionSheet->getStyle($cell)->getFont()->setBold(true);
        }

        // 2. Create Data Entry Sheet
        $dataSheet = $spreadsheet->createSheet();
        $dataSheet->setTitle('Data');

        // Add Headers
        foreach (range('A', 'E') as $index => $column) {
            $dataSheet->setCellValue($column . '1', $headers[$index]);
            $dataSheet->getStyle($column . '1')->getFont()->setBold(true);
            $dataSheet->getStyle($column . '1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('4F81BD');
            $dataSheet->getStyle($column . '1')->getFont()->getColor()->setRGB('FFFFFF');
        }

        // Add sample data
        foreach ($sampleData as $rowIndex => $row) {
            foreach (range('A', 'E') as $colIndex => $column) {
                $dataSheet->setCellValue($column . ($rowIndex + 2), $row[$colIndex]);
            }
        }

        // Auto-size columns
        foreach (range('A', 'E') as $column) {
            $dataSheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Save the spreadsheet to a temporary file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'recruiter_template_') . '.xlsx';
        $writer->save($tempFile);

        return $tempFile;
    }
}
