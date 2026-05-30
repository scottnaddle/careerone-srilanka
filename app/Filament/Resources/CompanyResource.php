<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Imports\CompaniesImport;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\Admin\SearchComponentAdminService;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Maatwebsite\Excel\Facades\Excel;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationLabel = 'Company';
    protected static ?string $navigationGroup = 'Company';
    protected static ?int $navigationSort = 1;
    public static $totalCompany;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('company_information')
                ->label(__('auth.Company information'))
                ->columnSpan('full')
                    ->options(fn () => collect(getCodeList('company_information'))
                        ->mapWithKeys(fn ($item) => [$item['code_id'] => $item['code_name']])
                        ->toArray()
                    )

                ->required(),

                TextInput::make('name')
                    ->label(__('company.name'))
                    ->columnSpan('full')
                    ->required(),
                TextInput::make('business_registration_number')
                    ->label(__('company.Registration number'))
                    ->columnSpan('full'),
                TextInput::make('email')
                    ->label('Email')
                    ->columnSpan('full'),
                Select::make('office_type')
                    ->label('Office Type')
                    ->columnSpan('full')
                    ->options(fn () => collect(getCodeList('office_type'))->pluck('code_name', 'code_id')->toArray()),

                Select::make('district_id')
                    ->label('District')
                    ->relationship('district', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpan('full')
                    ->placeholder('Select a district'),
                TextInput::make('address')
                    ->label('Address')
                    ->columnSpan('full')
                    ->required(),
                Placeholder::make('attachment_details')
                    ->label('Attachment Details')
                    ->content(function ($record) {
                        if (!$record || empty($record->attachment_details)) {
                            return new HtmlString(
                                '<div style=" font-size: 14px; color: #999;">No attachment available.</div>'
                            );
                        }

                        $file = json_decode($record->attachment_details, true);

                        if (empty($file) || !isset($file['1']['path'])) {
                            return new HtmlString(
                                '<div style=" font-size: 14px; color: #999;">No attachment available.</div>'
                            );
                        }

                        $path = asset($file['1']['path']);
                        $extension = pathinfo($file['1']['path'], PATHINFO_EXTENSION);
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

                        if (in_array(strtolower($extension), $imageExtensions)) {
                            return new HtmlString(
                                '<div style="text-align: center; margin: 10px 0;">
                                    <a href="' . e($path) . '" download style="text-decoration: none; color: #4984F6;">
                                        <img src="' . e($path) . '" alt="Attachment" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;">
                                        <div style="font-size: 14px; font-weight: bold; margin-top: 5px;">Download Attachment</div>
                                    </a>
                                 </div>'
                            );
                        }

                        return new HtmlString(
                            '<div style="text-align: center; margin: 10px 0;">
                                <a href="' . e($path) . '" download style="text-decoration: none; color: #4984F6;">
                                    <div style="font-size: 16px; font-weight: bold; color: #333;">' . e($file['1']['name'] ?? 'Unnamed File') . '</div>
                                    <div style="font-size: 14px; color: #888;">File Type: ' . e(strtoupper($extension)) . '</div>
                                    <div style="margin-top: 10px; background: #4984F6; color: white; padding: 8px 12px; border-radius: 5px; display: inline-block;">Download File</div>
                                </a>
                             </div>'
                        );
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->searchPlaceholder('Company name')
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
                Tables\Columns\TextColumn::make('approval')
                    ->label(__('admin/dashboard.company.approval'))
                    ->getStateUsing(function ($record) {
                        return $record->statusCompanyList();
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Verified' => "<span style='font-size:12px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>$state</span>",
                        'Request' => "<span style='font-size:12px;color: #5a5252; background-color: #dfdada; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;'>Request</span>",
                        default => "<span style='font-size:12px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;'>Rejected</span>",
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn($state) => $state ? 'success' : 'danger')

            ])->searchPlaceholder(__('admin/dashboard.company.search_title'))
            ->filters([
                Tables\Filters\SelectFilter::make('district_id')
                    //            ->relationship('district', 'name')
                    ->options(District::all()->pluck('name', 'id'))
                    ->preload()
                    ->searchable(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('date')
                            ->label('Created At')
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['date'])) {
                            $query->whereDate('created_at', $data['date']);
                        }
                    }),
                Tables\Filters\Filter::make('approval')
                    ->form([
                        Forms\Components\Select::make('approval')
                            ->options([
                                '1' => 'Verified',
                                '2' => 'Pending',
                                '3' => 'Rejected'
                            ])
                            ->preload()
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['approval'])) {
                            if ($data['approval'] === '1') {
                                $query->whereNotNull('companies.verified_by')
                                    ->whereNotNull('companies.verified_at');
                            } elseif ($data['approval'] === '3') {
                                $query->whereNull('companies.verified_by')
                                    ->whereNull('companies.verified_at');
                            } else {
                                $query->whereNull('companies.verified_by')
                                    ->whereNotNull('companies.verified_at');
                            }
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('View more')->color('primary'),
                Tables\Actions\EditAction::make()->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
                Action::make('deactivate')
                    ->label(__('Deactivate'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => false]);
                    })
                    ->hidden(fn($record) => $record->active === false)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
                Action::make('activate')
                    ->label(__('Activate'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['active' => true]);
                    })
                    ->hidden(fn($record) => $record->active === true)
                    ->visible(fn () => auth('admin')->user()->hasRole('super_admin')),
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
            ->striped()
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    protected static function generateTemplate()
    {
        // Remove asterisks from headers to avoid Excel key recognition issues
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

        // 1. Tạo Sheet chỉ dẫn (Instructions)
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

        // 2. Tạo Sheet nhập liệu (Data)
        $dataSheet = $spreadsheet->createSheet();
        $dataSheet->setTitle('Data');

        // Thêm Headers
        foreach (range('A', 'G') as $index => $column) {
            $dataSheet->setCellValue($column . '1', $headers[$index]);
            $dataSheet->getStyle($column . '1')->getFont()->setBold(true);
            $dataSheet->getStyle($column . '1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('4F81BD');
            $dataSheet->getStyle($column . '1')->getFont()->getColor()->setRGB('FFFFFF');
        }

        // Thêm dữ liệu mẫu
        foreach ($sampleData as $rowIndex => $row) {
            foreach (range('A', 'G') as $colIndex => $column) {
                $dataSheet->setCellValue($column . ($rowIndex + 2), $row[$colIndex]);
            }
        }

        foreach (range('A', 'G') as $column) {
            $dataSheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Cấu hình Data Validation cho cột District (Cột F) an toàn
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

            // Limit validation string length to avoid Excel crash when district list is too long (>255 chars)
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
