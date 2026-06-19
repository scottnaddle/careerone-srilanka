<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Imports\CompaniesImport;
use App\Models\Company;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Str;
class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationLabel = 'Company ';
    protected static ?string $navigationGroup = 'Company';
    protected static ?int $navigationSort = 1;
    public static $totalCompany;

    public static function form(Form $form): Form
    {
        $isSuperAdmin = auth('admin')->user()?->hasRole('super_admin');

        return $form
            ->schema([
                Section::make('Company Registration')
                    ->schema([
                        // Company Information Type
                        Select::make('company_information')
                            ->label('Company Information')
                            ->options(collect(getCodeList('company_information'))
                                ->mapWithKeys(fn ($item) => [$item['code_id'] => $item['code_name']])
                                ->toArray()
                            )
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('name', null))
                            ->required()
                            ->columnSpanFull(),

                        // Ministry Fields (for company_information = 1)
                        Grid::make(1)
                            ->schema([
                                TextInput::make('ministry_name')
                                    ->label('Ministry name')
                                    ->placeholder('Ministry of Education, Higher Education and Vocational Education')
                                    ->visible(fn (callable $get) => $get('company_information') == 1)
                                    ->required(fn (callable $get) => $get('company_information') == 1)
                                    ->default(function ($record) {
                                        // When editing, get the name if company_information == 1
                                        if ($record && $record->company_information == 1) {
                                            return $record->name;
                                        }
                                        return null;
                                    }),

                                TextInput::make('organisation_name')
                                    ->label('Name of organisation under the Ministry (if applicable)')
                                    ->placeholder('Tertiary and Vocational Education Commission (TVEC)')
                                    ->visible(fn (callable $get) => $get('company_information') == 1)
                                    ->default(function ($record) {
                                        if ($record && $record->company_information == 1) {
                                            return $record->co_business;
                                        }
                                        return null;
                                    }),
                            ]),

                        // Company Name (for non-ministry)
                        TextInput::make('name')
                            ->label('Company name')
                            ->placeholder('Type the company name')
                            ->visible(fn (callable $get) => $get('company_information') != 1 && !empty($get('company_information')))
                            ->required(fn (callable $get) => $get('company_information') != 1 && !empty($get('company_information'))),

                        Hidden::make('slug'),

                        // Business Registration Number (for types 4,5,7)
                        TextInput::make('business_registration_number')
                            ->label('Business Registration Number')
                            ->placeholder('XXXX XXXX XXXX')
                            ->visible(fn (callable $get) => in_array($get('company_information'), ['', 4, 5, 7]))
                            ->required(fn (callable $get) => in_array($get('company_information'), ['', 4, 5, 7])),

                        // Business Registration Number 1 (for types 2,3,6)
                        TextInput::make('business_registration_number_1')
                            ->label('Registration number (if applicable)')
                            ->placeholder('Type the registration number if applicable')
                            ->visible(fn (callable $get) => in_array($get('company_information'), [2, 3, 6]))
                            ->default(function ($record) {
                                if ($record && in_array($record->company_information, [2, 3, 6])) {
                                    return $record->business_registration_number;
                                }
                                return null;
                            }),

                        // Field of Operations (for types 2,3,6)
                        TextInput::make('co_business')
                            ->label('Field of operations')
                            ->placeholder('Environment conservation')
                            ->visible(fn (callable $get) => in_array($get('company_information'), [2, 3, 6]))
                            ->required(fn (callable $get) => in_array($get('company_information'), [2, 3, 6])),

                        // Office Type
                        Radio::make('office_type')
                            ->label('Office Type')
                            ->options(collect(getCodeList('office_type'))->pluck('code_name', 'code_id')->toArray())
                            ->inline()
                            ->inlineLabel(false)
                            ->visible(fn (callable $get) => !empty($get('company_information')) && $get('company_information') != 1)
                            ->required(fn (callable $get) => !empty($get('company_information')) && $get('company_information') != 1)
                            ->reactive(),

                        // Headquarter (for office_type = 2)
                        Select::make('headquarter_id')
                            ->label('Headquarter')
                            ->options(function (callable $get) {
                                return Company::query()
                                    ->whereNotNull('verified_at')
                                    ->whereNotNull('verified_by')
                                    ->where('active', true)
                                    ->where('office_type', 1)
                                    ->when($get('company_information'), function ($query, $info) {
                                        if (in_array($info, [2, 3, 4, 5, 6, 7])) {
                                            return $query;
                                        }
                                        return $query;
                                    })
                                    ->orderBy('name', 'asc')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->visible(fn (callable $get) => $get('office_type') == 2 && !empty($get('company_information')) && $get('company_information') != 1)
                            ->required(fn (callable $get) => $get('office_type') == 2),

                        // Date of Establishment (for types 4,5,7)
                        DatePicker::make('date_of_establishment')
                            ->label('Date Of Establishment')
                            ->maxDate(now())
                            ->visible(fn (callable $get) => in_array($get('company_information'), ['', 4, 5, 7]))
                            ->required(fn (callable $get) => in_array($get('company_information'), ['', 4, 5, 7])),

                        // Number of Workers (for types 4,5,7)
                        TextInput::make('number_workers')
                            ->label('The number of workers')
                            ->numeric()
                            ->default(0)
                            ->visible(fn (callable $get) => in_array($get('company_information'), ['', 4, 5, 7]))
                            ->required(fn (callable $get) => in_array($get('company_information'), ['', 4, 5, 7])),

                        // Email
                        TextInput::make('email')
                            ->label(function (callable $get) {
                                $info = $get('company_information');
                                if ($info == 1) {
                                    return 'E-mail (official email for recruitment)';
                                } elseif (in_array($info, [2, 3, 6])) {
                                    return 'E-mail (your organisation’s email)';
                                }
                                return 'E-mail';
                            })
                            ->email()
                            ->placeholder('organisation@email.com')
                            ->required(),

                        // Website
                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->placeholder('https://example.com'),

                        // District
                        Select::make('district_id')
                            ->label('District')
                            ->relationship('district', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        // Address
                        TextInput::make('address')
                            ->label('Address')
                            ->required(),

                        // Attached File (Business License/Certificate)
                        FileUpload::make('attachment_details')
                            ->label(function (callable $get) {
                                $info = $get('company_information');
                                if (in_array($info, [2, 3, 6])) {
                                    return 'Attached file (Certificate)';
                                }
                                return 'Attached file (Business License)';
                            })
                            ->multiple()
                            ->directory(fn ($get) => 'company/business_licenses/' . Str::slug($get('name') ?? $get('ministry_name') ?? 'company', '-', 'ta'))
                            ->preserveFilenames()
                            ->maxFiles(5)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
                            ->visible(fn (callable $get) => !empty($get('company_information')) && $get('company_information') != 1),

                        // Logo
                        FileUpload::make('logo')
                            ->label('Company Logo')
                            ->directory(fn ($get) => 'company/logos/' . Str::slug($get('name') ?? $get('ministry_name') ?? 'company', '-', 'ta'))
                            ->image()
                            ->maxSize(50048)
                            ->avatar(),

                        // Naita Company Checkbox - Only visible for Super Admin
                        Checkbox::make('is_belongs_to_naita')
                            ->label('Belongs to NAITA')
                            ->helperText('Check this box if the company belongs to NAITA')
                            ->default(false)
                            ->visible($isSuperAdmin)
                            ->columnSpanFull(),

                        // Active Checkbox - Only shown when editing
                        Checkbox::make('active')
                            ->label('Active')
                            ->helperText('Activate/Deactivate this company')
                            ->default(false)
                            ->visible(fn ($record) => $record !== null && ($isSuperAdmin || auth('admin')->user()->hasRole('naita_admin')))
                            ->columnSpanFull(),

                        // Hidden fields
                        Hidden::make('verified_by')
                            ->default(null),

                        Hidden::make('verified_at')
                            ->default(null),

                        Hidden::make('name_of_representation')
                            ->default(null),

                        Hidden::make('enterprise_id')
                            ->default(null),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder(trans('admin/cgo_performance.company'))
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label(__('admin/dashboard.content.no'))
                    ->rowIndex()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin/dashboard.company.name'))
                    ->searchable('companies.name')
                    ->limit(50)
                    ->url(fn($record) => route('filament.admin.resources.comapny-user-lists.index', ['company_id' => $record->id]), true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('district.name')
                    ->label(__('admin/dashboard.company.district'))
                    ->sortable(),

                Tables\Columns\CheckboxColumn::make('is_belongs_to_naita')
                    ->label('NAITA')
                    ->disabled(fn () => !auth('admin')->user()->hasRole('naita_admin'))->alignCenter()
                    ->afterStateUpdated(function ($record, $state) {
                        \Log::info("Company {$record->id} NAITA status changed to: " . ($state ? 'Yes' : 'No'));

                        Notification::make()
                            ->title('NAITA status updated')
                            ->body('Company ' . $record->name . ' NAITA status changed to ' . ($state ? 'Yes' : 'No'))
                            ->success()
                            ->send();
                    }),

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
                    ->formatStateUsing(fn($state) => $state ? 'Active' : trans('admin/status.inactive'))
                    ->color(fn($state) => $state ? 'success' : 'danger')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('district_id')
                    ->options(District::all()->pluck('name', 'id'))
                    ->preload()
                    ->searchable(),

                Tables\Filters\SelectFilter::make('is_belongs_to_naita')
                    ->label('NAITA Company')
                    ->options([
                        '1' => 'Yes',
                        '0' => 'No',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('date')
                            ->label(trans('admin/dashboard.institute.created_at'))
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['date'])) {
                            $query->whereDate('created_at', $data['date']);
                        }
                    }),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth('admin')->user();
                if ($user?->hasRole('naita_admin')) {
                    $query->where('is_belongs_to_naita', true);
                }
            })
            ->actions([
                Tables\Actions\ViewAction::make()->label('View more')->color('primary'),
                Tables\Actions\EditAction::make()->visible(fn () => auth('admin')->user()->hasRole('super_admin') || auth('admin')->user()->hasRole('naita_admin')),
                Tables\Actions\Action::make('deactivate')
                    ->label(__('Deactivate'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => false, 'verified_by' => auth()->guard('admin')->user()->id, 'verified_at' => null]);
                    })
                    ->hidden(fn($record) => $record->active === false)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')|| auth('admin')->user()->hasRole('naita_admin')),

                Tables\Actions\Action::make('activate')
                    ->label(__('Activate'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => true, 'verified_by' => auth()->guard('admin')->user()->id, 'verified_at' => now()]);
                    })
                    ->hidden(fn($record) => $record->active === true)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')|| auth('admin')->user()->hasRole('naita_admin')),
            ])
            ->headerActions([
                // Import Action
                Tables\Actions\Action::make('import_companies')
                    ->label('Import Companies')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->modalHeading('Import Companies')
                    ->modalSubheading('Upload an Excel or CSV file to import companies')
                    ->form([
                        \Filament\Forms\Components\FileUpload::make('import_file')
                            ->label('Excel File')
                            ->required()
                            ->acceptedFileTypes([
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'text/csv',
                            ])
                            ->maxSize(10240)
                            ->helperText('Supported formats: .xlsx, .xls, .csv (Max: 10MB)')
                            ->directory('imports/companies')
                            ->preserveFilenames(),

                        \Filament\Forms\Components\Placeholder::make('instructions')
                            ->content(new \Illuminate\Support\HtmlString('
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Click the button below to download the sample template</li>
                            <li>Fill in the required fields (Company Name, District, Address)</li>
                            <li>District name must match exactly with existing districts</li>
                            <li>Upload the completed file</li>
                        </ul>
                    </div>
                ')),

                        // Download Template Button inside modal
                        \Filament\Forms\Components\Actions::make([
                            \Filament\Forms\Components\Actions\Action::make('download_template_modal')
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

                            $import = new CompaniesImport();
                            Excel::import($import, $filePath);

                            Storage::disk('public')->delete($data['import_file']);

                            $importedCount = $import->getImportedCount();
                            $failedCount = $import->getFailedCount();
                            if ($importedCount > 0 && $failedCount == 0) {
                                $message = "Successfully imported {$importedCount} companies.";
                                Notification::make()
                                    ->title('Import Completed')
                                    ->body($message)
                                    ->success()
                                    ->send();
                            }

                            if ($failedCount > 0) {
                                $failures = $import->getFailures();
                                $failureMessages = array_map(fn($f) => "Row {$f['row']}: " . $f['error'], $failures);

                                Notification::make()
                                    ->title('Import Failures')
                                    ->body(implode("\n", array_slice($failureMessages, 0, 5)))
                                    ->warning()
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
            ->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        $user = auth('admin')->user();
        return $user?->hasRole('super_admin') || $user?->hasRole('naita_admin');
    }

    protected static function generateTemplate()
    {
        // Remove the * directly from the header to avoid key detection errors in Laravel-Excel
        $headers = [
            'company_name',
            'business_registration_number',
            'email',
            'office_type',
            'company_information',
            'district',
            'address',
        ];

        $sampleData = [
            [
                'Sample Company Ltd',
                'BRN-2024-001',
                'info@samplecompany.com',
                'Head Office',
                'Private Limited Company',
                'Colombo',
                '123 Sample Street, Colombo 1',
            ],
        ];

        $districts = District::select('name')->orderBy('name')->get()->pluck('name')->toArray();
        $districtsList = implode(', ', array_slice($districts, 0, 10)) . (count($districts) > 10 ? '...' : '');

        $officeTypes = collect(getCodeList('office_type'))->pluck('code_name')->toArray();
        $officeTypesList = implode(', ', $officeTypes);

        $companyInfoTypes = collect(getCodeList('company_information'))->pluck('code_name')->toArray();
        $companyInfoList = implode(', ', $companyInfoTypes);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // 1. Create the Instructions sheet
        $instructionSheet = $spreadsheet->getActiveSheet();
        $instructionSheet->setTitle('Instructions');

        $instructionSheet->setCellValue('A1', 'IMPORT INSTRUCTIONS');
        $instructionSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $instructionSheet->setCellValue('A3', 'Required Fields:');
        $instructionSheet->setCellValue('A4', '• company_name');
        $instructionSheet->setCellValue('A5', '• district');
        $instructionSheet->setCellValue('A6', '• address');

        $instructionSheet->setCellValue('A8', 'Optional Fields:');
        $instructionSheet->setCellValue('A9', '• business_registration_number');
        $instructionSheet->setCellValue('A10', '• email');
        $instructionSheet->setCellValue('A11', '• office_type');
        $instructionSheet->setCellValue('A12', '• company_information');

        $instructionSheet->setCellValue('A14', 'Available Districts:');
        $instructionSheet->setCellValue('A15', $districtsList);
        $instructionSheet->getStyle('A15')->getAlignment()->setWrapText(true);

        $instructionSheet->setCellValue('A17', 'Available Office Types:');
        $instructionSheet->setCellValue('A18', $officeTypesList);
        $instructionSheet->getStyle('A18')->getAlignment()->setWrapText(true);

        $instructionSheet->setCellValue('A20', 'Available Company Information Types:');
        $instructionSheet->setCellValue('A21', $companyInfoList);
        $instructionSheet->getStyle('A21')->getAlignment()->setWrapText(true);

        $instructionSheet->getColumnDimension('A')->setWidth(70);
        foreach (['A3', 'A8', 'A14', 'A17', 'A20'] as $cell) {
            $instructionSheet->getStyle($cell)->getFont()->setBold(true);
        }

        // 2. Create the Data entry sheet
        $dataSheet = $spreadsheet->createSheet();
        $dataSheet->setTitle('Data');

        // Add Headers
        foreach (range('A', 'G') as $index => $column) {
            $dataSheet->setCellValue($column . '1', $headers[$index]);
            $dataSheet->getStyle($column . '1')->getFont()->setBold(true);
            $dataSheet->getStyle($column . '1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('4F81BD');
            $dataSheet->getStyle($column . '1')->getFont()->getColor()->setRGB('FFFFFF');
        }

        // Add sample data
        foreach ($sampleData as $rowIndex => $row) {
            foreach (range('A', 'G') as $colIndex => $column) {
                $dataSheet->setCellValue($column . ($rowIndex + 2), $row[$colIndex]);
            }
        }

        foreach (range('A', 'G') as $column) {
            $dataSheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Safely configure Data Validation for the District column (Column F)
        if (!empty($districts)) {
            $lastRow = 1000;
            $districtValidation = $dataSheet->getCell('F2')->getDataValidation();
            $districtValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $districtValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $districtValidation->setAllowBlank(false);
            $districtValidation->setShowInputMessage(true);
            $districtValidation->setShowErrorMessage(true);
            $districtValidation->setShowDropDown(true);
            $districtValidation->setErrorTitle('Input error');
            $districtValidation->setError('Please select district.');
            $districtValidation->setPromptTitle('Select District');
            $districtValidation->setPrompt('Select a  valid.');

            // Limit the validation string length to avoid an Excel crash when the district list is too long (>255 characters)
            $formulaString = '"' . implode(',', array_slice($districts, 0, 20)) . '"';
            $districtValidation->setFormula1($formulaString);

            for ($i = 2; $i <= $lastRow; $i++) {
                $dataSheet->getCell('F'.$i)->setDataValidation(clone $districtValidation);
            }
        }

        $dataSheet->getStyle('A1:G1')->getProtection()->setLocked(true);

        $tempFile = tempnam(sys_get_temp_dir(), 'company_import_template_') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        return $tempFile;
    }
}
