<?php

namespace App\Filament\Pages\CompanyApprovalListResource;

use App\Filament\Resources\CgoResource;
use App\Filament\Widgets\CGOApprovalDetail as WidgetsCGOApprovalDetail;
use App\Models\Company;
use App\Services\Cgo\NotificationManager as NotificationManagerCgo;
use Filament\Actions;
use Filament\Resources\Pages\Listdetailids;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Models\CompanyRecruiter;
use App\Services\Admin\HandelAdminService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Placeholder;


use Filament\Forms\Components\FileUpload;

class CompanyApprovalDetail extends Page
{
    protected static ?string $navigationLabel = 'Company Approval List';
    protected static ?string $navigationGroup = 'Company';
    protected static ?int $navigationSort = 1;
    protected ?string $heading = '';
    protected static string $view = 'filament.pages.membership.company.company-approval.detail';
    public $detailid;
    public $selectedReasons = [];
    public $file_upload;
    public $additionalComments = '';
    public $showModal = false;
    public $reasonSelect = [
        'The email invalid',
        'The Telephone (Mobiile) number is invalid',
        'Public Offical ID Number is invalid',
        'The Institute name is invalid',
        'Or write something'
    ];
    protected HandelAdminService $approvalService;
    protected NotificationManagerCgo $notificationManagerCgo;
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
        $this->notificationManagerCgo = app(NotificationManagerCgo::class);
    }

    public function mount()
    {
        $detailid = request()->get('id');
        $this->detailid = Company::findOrFail($detailid);
        if(!empty($this->detailid->attachment_details['1'])){
            $this->file_upload = $this->detailid->attachment_details['1'];
        }

    }
    protected function getFirstFormSchema(): array
    {
        return [
            TextInput::make('company_information')
                ->label(__('auth.Company information'))
                ->columnSpan('full')
                ->placeholder(getCodeNameByCodeId('company_information', $this->detailid->company_information) ?? 'N/A')
                ->disabled(),
            TextInput::make('name')
                ->label(__('company.name'))
                ->placeholder($this->detailid->name ?? '')
                ->columnSpan('full')
                ->disabled(),
            TextInput::make('business_registration_number')
                ->label(__('company.Registration number'))
                ->columnSpan('full')
                ->placeholder($this->detailid->business_registration_number ?? '')
                ->disabled(),

            TextInput::make('office_type')
                ->label('Office Type')
                ->columnSpan('full')
                ->placeholder(getCodeNameByCodeId('office_type', $this->detailid->office_type) ?? 'N/A')
                ->disabled(),

            TextInput::make('email')
                ->label('E-mail')
                ->columnSpan('full')
                ->placeholder($this->detailid->email ?? '')
                ->disabled(),

//            TextInput::make('number_workers')
//                ->label('Number of Workers')
//                ->columnSpan('full')
//                ->placeholder($this->detailid->number_workers)
//                ->disabled(),


            TextInput::make('district_id')
                ->label('District')
                ->columnSpan('full')
                ->placeholder($this->detailid->district->name ?? '')
                ->disabled(),
                TextInput::make('address')
                ->label('Address')
                ->columnSpan('full')
                ->placeholder($this->detailid->address ?? '')
                ->disabled(),

                Placeholder::make('attachment_details')
                ->label('Attachment Details')
                ->content(function () {
                    $file = json_decode($this->detailid->attachment_details, true);

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
    public function showApprovalModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function approveItem()
    {
        if (!$this->detailid) {
            Notification::make()
                ->title('Company not found')
                ->success()
                ->send();
            return;
        } else if (!$this->additionalComments) {
            Notification::make()
                ->title('Reason for rejection is required')
                ->danger()
                ->send();
            return;
        }
        //Reject all company's recruiter
        $company_recruiters = $this->detailid->recruiters;
        foreach ($company_recruiters as $recruiter) {
            $recruiter->update([
                'verify_at' => null,
                'verify_by' => auth()->user()->id,
                'email_verified_at' => null,
                'reason' => $this->additionalComments,
                'active' => false,
            ]);
            //Send email notification
            $this->notificationManagerCgo->sendMembershipRejectEmail($recruiter, $this->additionalComments);
        }
        $success = $this->approvalService->rejectCompany(Company::class, $this->detailid->id, $this->additionalComments);

        if ($success) {
            Notification::make()
                ->title('Action Success!')
                ->success()
                ->send();
            return redirect()->route('filament.admin.pages.company-approval-list');
        } else {
            Notification::make()
                ->title('Something wrong !')
                ->danger()
                ->send();
        }
        $this->closeModal();
    }
    public function toggleReason($reason)
    {
        if (in_array($reason, $this->selectedReasons)) {
            $this->selectedReasons = array_diff($this->selectedReasons, [$reason]);
        } else {
            $this->selectedReasons[] = $reason;
        }
    }
    public function handleApproval()
    {
        if (!$this->detailid) {
            session()->flash('error', 'User ID is required for approval.');
            return;
        }
        $success = $this->approvalService->approveCompany(Company::class, $this->detailid->id);

        if ($success) {
            session()->flash('success', 'User has been approved successfully.');
            return redirect()->route('filament.admin.pages.company-approval-list');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
}
