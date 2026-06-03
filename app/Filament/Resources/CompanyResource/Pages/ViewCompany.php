<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Models\Company;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use App\Services\Admin\HandelAdminService;
use App\Models\CompanyRecruiter;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\HtmlString;

class ViewCompany extends ViewRecord
{
    protected static string $resource = CompanyResource::class;
    protected static string $view = 'filament.pages.membership.company.company-detail';
    protected HandelAdminService $approvalService;

    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('block')
                ->label('Block Company')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->action(fn () => $this->handleBlock()),
        ];
    }

    public $traineeData;

    public function mount($record): void
    {
        parent::mount($record);
        $this->traineeData = $this->record;
    }

    /**
     * Format file URL to proper asset URL
     */
    private function formatFileUrl($path): string
    {
        if (empty($path)) {
            return '#';
        }

        // Remove leading slash if exists
        $path = ltrim($path, '/');

        // If it's already a full URL (http:// or https://)
        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }

        // If it already has 'storage/' prefix
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // If it starts with 'company/' (relative path from storage)
        if (str_starts_with($path, 'company/')) {
            return asset('storage/' . $path);
        }

        // Default: assume it's a storage path
        return asset('storage/' . $path);
    }

    /**
     * Format logo URL specifically
     */
    private function formatLogoUrl($logo): string
    {
        if (empty($logo)) {
            return asset('images/company-default.png');
        }

        // Remove leading slash
        $logo = ltrim($logo, '/');

        // If it's already a full URL
        if (preg_match('/^https?:\/\//', $logo)) {
            return $logo;
        }

        // If it already has 'storage/' prefix
        if (str_starts_with($logo, 'storage/')) {
            return asset($logo);
        }

        // If it starts with 'company/'
        if (str_starts_with($logo, 'company/')) {
            return asset('storage/' . $logo);
        }

        // If it's just a filename or other path
        return asset('storage/' . $logo);
    }

    /**
     * Get attachment display HTML
     */
    private function getAttachmentHtml($file): string
    {
        if (empty($file) || !isset($file['1']['path'])) {
            return '<div style="text-align: center; font-size: 14px; color: #999;">No attachment available.</div>';
        }

        $path = $this->formatFileUrl($file['1']['path']);
        $extension = pathinfo($file['1']['path'], PATHINFO_EXTENSION);
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

        if (in_array(strtolower($extension), $imageExtensions)) {
            return '
                <div style="text-align: center; margin: 10px 0;">
                    <a href="' . $path . '" download style="text-decoration: none; color: #4984F6;">
                        <img src="' . $path . '" alt="Attachment" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;"
                             onerror="this.onerror=null; this.src=\'' . asset('images/file-placeholder.png') . '\'">
                        <div style="font-size: 14px; font-weight: bold; margin-top: 5px;">Download Attachment</div>
                    </a>
                </div>';
        } else {
            return '
                <div style="text-align: center; margin: 10px 0;">
                    <a href="' . $path . '" download style="text-decoration: none; color: #4984F6;">
                        <div style="font-size: 16px; font-weight: bold; color: #333;">' . ($file['1']['name'] ?? 'Unnamed File') . '</div>
                        <div style="font-size: 14px; color: #888;">File Type: ' . strtoupper($extension) . '</div>
                        <div style="margin-top: 10px; background: #4984F6; color: white; padding: 8px 12px; border-radius: 5px; display: inline-block;">Download File</div>
                    </a>
                </div>';
        }
    }

    /**
     * Get logo HTML
     */
    private function getLogoHtml(): string
    {
        $logoUrl = $this->formatLogoUrl($this->record->logo);

        return '
            <div style="text-align: center; margin: 10px 0;">
                <img src="' . $logoUrl . '" alt="Company Logo"
                     style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 5px; padding: 5px;"
                     onerror="this.onerror=null; this.src=\'' . asset('images/company-default.png') . '\'">
                <div style="margin-top: 10px;">
                    <a href="' . $logoUrl . '" download
                       style="font-size: 12px; color: #4984F6; text-decoration: none;">
                        Download Logo
                    </a>
                </div>
            </div>';
    }

    protected function getFormSchema(): array
    {
        $file = json_decode($this->record->attachment_details, true);
        $company_information = getCodeNameByCodeId('company_information', $this->record->company_information);


        return [
            Section::make('Company Information')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            // Company Information Type
                            Placeholder::make('company_information')
                                ->label('Company Information')
                                ->content($company_information)
                                ->columnSpan('1/2'),
                            // Office Type
                            Placeholder::make('company_information')
                                ->label('Company Information')
                                ->content(getCodeNameByCodeId('office_type', $this->record->office_type))
                                ->columnSpan('1/2'),
                            // For Ministry (type 1)
                            TextInput::make('ministry_name')
                                ->label('Ministry name')
                                ->placeholder(function () {
                                    if ($this->record->company_information == 1) {
                                        return $this->record->name ?? 'N/A';
                                    }
                                    return 'N/A';
                                })
                                ->disabled()
                                ->visible(fn () => $this->record->company_information == 1),

                            TextInput::make('organisation_name')
                                ->label('Organisation under Ministry')
                                ->placeholder(function () {
                                    if ($this->record->company_information == 1) {
                                        return $this->record->co_business ?? 'N/A';
                                    }
                                    return 'N/A';
                                })
                                ->disabled()
                                ->visible(fn () => $this->record->company_information == 1),

                            // Company Name (for non-ministry)
                            TextInput::make('name')
                                ->label('Company name')
                                ->placeholder($this->record->name ?? 'N/A')
                                ->disabled()
                                ->visible(fn () => $this->record->company_information != 1),

                            // Business Registration Number
                            TextInput::make('business_registration_number')
                                ->label('Business Registration Number')
                                ->placeholder($this->record->business_registration_number ?? 'N/A')
                                ->disabled(),

                            // Field of Operations
                            TextInput::make('co_business')
                                ->label('Field of operations')
                                ->placeholder($this->record->co_business ?? 'N/A')
                                ->disabled()
                                ->visible(fn () => in_array($this->record->company_information, [2, 3, 6])),



                            // Headquarter
                            TextInput::make('headquarter')
                                ->label('Headquarter')
                                ->placeholder(function () {
                                    if ($this->record->headquarter_id) {
                                        $headquarter = Company::find($this->record->headquarter_id);
                                        return $headquarter ? $headquarter->name : 'N/A';
                                    }
                                    return 'N/A';
                                })
                                ->disabled(),

                            // Date of Establishment
                            TextInput::make('date_of_establishment')
                                ->label('Date Of Establishment')
                                ->placeholder($this->record->date_of_establishment ?? 'N/A')
                                ->disabled(),

                            // Number of Workers
                            TextInput::make('number_workers')
                                ->label('Number of Workers')
                                ->placeholder($this->record->number_workers ?? '0')
                                ->disabled(),

                            // Email
                            TextInput::make('email')
                                ->label('Email')
                                ->placeholder($this->record->email ?? 'N/A')
                                ->disabled(),

                            // Website
                            TextInput::make('website')
                                ->label('Website')
                                ->placeholder($this->record->website ?? 'N/A')
                                ->disabled(),

                            // District
                            TextInput::make('district')
                                ->label('District')
                                ->placeholder($this->record->district->name ?? 'N/A')
                                ->disabled(),

                            // Address
                            TextInput::make('address')
                                ->label('Address')
                                ->placeholder($this->record->address ?? 'N/A')
                                ->disabled(),
                        ]),
                ]),

            Section::make('Verification Information')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Toggle::make('active')
                                ->label('Active Status')
                                ->default($this->record->active)
                                ->disabled(),
                            Toggle::make('is_belongs_to_naita')
                                ->label('Belongs to NAITA')
                                ->default($this->record->is_belongs_to_naita)
                                ->disabled(),

                            Placeholder::make('verified_by')
                                ->label('Verified By')
                                ->content(function () {
                                    if ($this->record->verified_by) {
                                        $verifier = \App\Models\AdminUser::find($this->record->verified_by);
                                        return $verifier ? $verifier->fullName : 'Unknown';
                                    }
                                    return 'Not verified';
                                })
                                ->disabled(),

                            TextInput::make('verified_at')
                                ->label('Verified At')
                                ->placeholder($this->record->verified_at ? $this->record->verified_at : 'Not verified')
                                ->disabled(),


                        ]),
                ]),

            Section::make('Attachments')
                ->schema([
                    Placeholder::make('attachment_details')
                        ->label('Business License / Certificate')
                        ->content(new HtmlString($this->getAttachmentHtml($file))),

                    Placeholder::make('logo')
                        ->label('Company Logo')
                        ->content(new HtmlString($this->getLogoHtml())),
                ]),

            Section::make('Additional Information')
                ->schema([
                    Textarea::make('reason')
                        ->label('Reason')
                        ->placeholder($this->record->reason ?? 'No reason provided')
                        ->disabled()
                        ->rows(3),
                ])
                ->visible(fn () => !empty($this->record->reason)),
        ];
    }

    // Giữ lại method cũ để tương thích nếu view cần
    protected function getFirstFormSchema(): array
    {
        return $this->getFormSchema();
    }

    protected function getSecondFormSchema(): array
    {
        return [];
    }

    protected function getThirdFormSchema(): array
    {
        return [
            Textarea::make('reason')
                ->label('Reason for reject')
                ->placeholder($this->record->reason ?? 'No reason provided')
                ->rows(4)
                ->visible(fn () => !is_null($this->record->reason))
                ->disabled()
                ->columnSpan('full'),
        ];
    }

    public function handleBlock()
    {
        if (!$this->traineeData) {
            session()->flash('error', 'User ID is required for approval.');
            return redirect()->back();
        }

        $success = $this->approvalService->blockCompany(Company::class, $this->traineeData->id);

        if ($success) {
            session()->flash('success', 'Block operation was successful.');
            return redirect()->route('filament.admin.pages.company-approval-list');
        }

        session()->flash('error', 'User not found.');
        return redirect()->back();
    }
}
