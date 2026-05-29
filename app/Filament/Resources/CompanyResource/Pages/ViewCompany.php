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
        ];
    }
    public $traineeData;

    public function mount($record): void
    {
        parent::mount($record);
        $this->traineeData = $this->record;
    }


    protected function getFirstFormSchema(): array
    {
        return [

        TextInput::make('enterprise_id')
            ->label(__('auth.Company information'))
            ->columnSpan('full')
            ->placeholder(getCodeNameByCodeId('company_information', $this->record->company_information) ?? 'N/A')
            ->disabled(),

        TextInput::make('name')
            ->label(__('company.name'))
            ->placeholder($this->record->name ?? '')
            ->columnSpan('full')
            ->disabled(),
        TextInput::make('business_registration_number')
            ->label(__('company.Registration number'))
            ->columnSpan('full')
            ->placeholder($this->record->business_registration_number ?? '')
            ->disabled(),
        Select::make('office_type')
            ->label('Office Type')
            ->columnSpan('full')
            ->options(collect(getCodeList('office_type'))->pluck('code_name', 'code_id')->toArray())
            ->required(),

//        TextInput::make('headquarter_id')
//            ->label('Headquarter')
//            ->columnSpan('full')
//            ->placeholder($this->record->headquarter_id ?? '')
//            ->disabled(),
//
//        TextInput::make('number_workers')
//            ->label('Number of Workers')
//            ->columnSpan('full')
//            ->placeholder($this->record->number_workers)
//            ->disabled(),
//
//        TextInput::make('enterprise_id')
//            ->label('Company Information')
//            ->columnSpan('full')
//            ->placeholder(getCodeNameByCodeId('Enterprise_Type', $this->record->enterprise_id) ?? 'N/A')
//            ->disabled(),
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
        ->placeholder($this->record->address ?? '')
        ->disabled(),

            Placeholder::make('attachment_details')
            ->label('Attachment Details')
            ->content(function () {
                $file = json_decode($this->record->attachment_details, true);

                if (!empty($file) && isset($file['1']['path'])) {
                    $path = asset($file['1']['path']);
                    $extension = pathinfo($file['1']['path'], PATHINFO_EXTENSION);
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

                    if (in_array(strtolower($extension), $imageExtensions)) {
                        return new \Illuminate\Support\HtmlString(
                            '<div style="text-align: center; margin: 10px 0;">
                                <a href="' . $path . '" download style="text-decoration: none; color: #4984F6;">
                                    <img src="' . $path . '" alt="Attachment" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;">
                                    <div style="font-size: 14px; font-weight: bold; margin-top: 5px;">Download Attachment</div>
                                </a>
                             </div>'
                        );
                    } else {
                        return new \Illuminate\Support\HtmlString(
                            '<div style="text-align: center; margin: 10px 0;">
                                <a href="' . $path . '" download style="text-decoration: none; color: #4984F6;">
                                    <div style="font-size: 16px; font-weight: bold; color: #333;">' . ($file['1']['name'] ?? 'Unnamed File') . '</div>
                                    <div style="font-size: 14px; color: #888;">File Type: ' . strtoupper($extension) . '</div>
                                    <div style="margin-top: 10px; background: #4984F6; color: white; padding: 8px 12px; border-radius: 5px; display: inline-block;">Download File</div>
                                </a>
                             </div>'
                        );
                    }
                }
                return new \Illuminate\Support\HtmlString(
                    '<div style="text-align: center; font-size: 14px; color: #999;">No attachment available.</div>'
                );
            })
        ];
    }

    protected function getSecondFormSchema(): array
    {
        return [
            TextInput::make('institute_name')
            ->label(__('admin/dashboard.company.institute_name'))
            ->placeholder(fn () => $this->record->institute->name ?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('district_name')
            ->label(__('admin/dashboard.company.district_name'))
            ->placeholder(fn () => $this->record->district->name ?? '')
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('tvet_type')
            ->label(__('admin/dashboard.company.tvet_type'))
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('sector')
            ->label(__('admin/dashboard.company.sector'))
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('course')
            ->label(__('admin/dashboard.company.course'))
            ->disabled()
            ->columnSpan('full'),

        TextInput::make('nvq')
            ->label(__('admin/dashboard.company.nvq'))
            ->placeholder(fn () => $this->record->nvq->name ?? 'N/A')
            ->disabled()
            ->columnSpan('full'),

        ];
    }

 protected function getThirdFormSchema(): array
{
    return [
        Textarea::make('description')
            ->label('Reason for reject')
            ->placeholder('Enter your description here...')
            ->rows(4)
            ->visible(fn ($record) => !is_null($record->description))
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
