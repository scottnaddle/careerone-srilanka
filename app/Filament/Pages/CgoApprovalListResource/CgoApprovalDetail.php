<?php

namespace App\Filament\Pages\CgoApprovalListResource;

use App\Filament\Resources\CgoResource;
use App\Filament\Widgets\CGOApprovalDetail as WidgetsCGOApprovalDetail;
use Filament\Actions;
use Filament\Resources\Pages\Listdetailids;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Models\CgoUser;
use App\Services\Admin\HandelAdminService;
use Filament\Notifications\Notification;

class CgoApprovalDetail extends Page
{
    protected static ?string $navigationLabel = 'CGO Approval List';
    protected static ?string $navigationGroup = 'CGO';
    protected static ?int $navigationSort = 1;
    protected ?string $heading = '';
    protected static string $view = 'filament.pages.membership.cgo.cgo-approval.detail';
    public $detailid;
    // public $selectedReasons = [];
    public $additionalComments ;
    public $showModal = false;
    // public $reasonSelect=['The email invalid',
    //                       'The Telephone (Mobiile) number is invalid',
    //                       'Public Offical ID Number is invalid',
    //                       'The Institute name is invalid',
    //                       'Or write something'
    //                     ];
     protected HandelAdminService $approvalService;
    public function __construct()
    {
        $this->approvalService = new HandelAdminService();
    }
    public function mount()
    {
        $detailid= request()->get('id');
        $this->detailid = CgoUser::findOrFail($detailid);
    }

    protected function getFirstFormSchema(): array
    {
        return [
//            TextInput::make('institute_name')
//                ->label('Institute')
//                ->placeholder(fn() => $this->detailid->institute->name ?? '')
//                ->disabled()
//                ->columnSpan('full'),
            TextInput::make('full_name')
                ->label(__('system.form.full_name'))
                ->placeholder(fn() => $this->detailid->fullName ?? '')
                ->disabled()
                ->columnSpan('full'),
            TextInput::make('nic')
                ->label(__('admin/dashboard.administrator.nic'))
                ->placeholder(fn() => $this->detailid->nic ?? '')
                ->disabled()
                ->columnSpan('full'),
            TextInput::make('mobile')
                ->label(__('system.form.mobile'))
                ->placeholder(fn() => $this->detailid->telephone ?? '')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('email')
                ->label(__('system.form.email'))
                ->placeholder(fn() => $this->detailid->email ?? '')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('p_institute')
                ->label(__('admin/dashboard.cgo.institute_registration_number'))
                ->placeholder(fn() => $this->detailid->institute->reg_no ?? '')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('institute_name')
                ->label(__('admin/dashboard.cgo.institute_name'))
                ->placeholder(fn() => $this->detailid->institute->name ?? '')
                ->disabled()
                ->columnSpan('full'),

            TextInput::make('district_name')
                ->label('District')
                ->placeholder(fn() => $this->detailid->district->name ?? '')
                ->disabled()
                ->columnSpan('full'),
        ];
    }


    protected function getSecondFormSchema(): array
    {
        return [
            TextInput::make('tvet_type')
                ->label(__('admin/dashboard.cgo.tvet_type'))
                ->placeholder(fn() => $this->detailid->institute->tvetType->head_office_name ?? '')
                ->disabled()
                ->columnSpan('full'),

            DateTimePicker::make('created_at')
                ->label(__('admin/dashboard.cgo.created_at'))
                ->native(false)
                ->placeholder(fn() => $this->detailid->created_at ?? '')
                ->disabled()
                ->columnSpan('full'),
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
            ->title('User ID not found')
            ->success()
            ->send();
            return;
        }else if(!$this->additionalComments){
            Notification::make()
            ->title('Reason for rejection is required')
            ->danger()
            ->send();
            return;
        }

        $success = $this->approvalService->rejectCgo(CgoUser::class, $this->detailid->id,$this->additionalComments);

        if ($success) {
            Notification::make()
            ->title('Action Success!')
            ->success()
            ->send();
            return redirect()->route('filament.admin.pages.cgo-approval-list');
        } else {
            Notification::make()
            ->title('Something wrong !')
            ->danger()
            ->send();
        }
        $this->closeModal();
    }
    // public function toggleReason($reason)
    // {
    //     if (in_array($reason, $this->selectedReasons)) {
    //         $this->selectedReasons = array_diff($this->selectedReasons, [$reason]);
    //     } else {
    //         $this->selectedReasons[] = $reason;
    //     }
    // }
    public function handleApproval()
    {
        if (!$this->detailid) {
            session()->flash('error', 'User ID is required for approval.');
            return;
        }

        $success = $this->approvalService->approve(CgoUser::class, $this->detailid->id);

        if ($success) {
            session()->flash('success', 'User has been approved successfully.');
            return redirect()->route('filament.admin.pages.cgo-approval-list');
        } else {
            session()->flash('error', 'User not found.');
        }
    }

}
