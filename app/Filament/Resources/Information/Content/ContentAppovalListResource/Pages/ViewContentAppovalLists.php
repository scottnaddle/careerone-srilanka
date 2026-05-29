<?php

namespace App\Filament\Resources\Information\Content\ContentAppovalListResource\Pages;


use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\Information\Content\ContentListResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use App\Services\Admin\HandelAdminService;
use App\Models\CompanyRecruiter;
use App\Filament\Resources\Information\Content\ContentAppovalListResource;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\Content;
use Filament\Notifications\Notification;
use App\Services\Cgo\NotificationManager as NotificationManagerCgo;
class ViewContentAppovalLists extends ViewRecord
{
    protected static string $resource = ContentAppovalListResource::class;
    protected static string $view = 'filament.pages.information.manage-content.content.content-approval.content-approval-detail';
    protected HandelAdminService $approvalService;
    public $showModal = false;
    public $detailid;
    public $additionalComments;
    public $intro;
    protected NotificationManagerCgo $notificationManagerCgo;
     public function __construct()
    {
        $this->approvalService = new HandelAdminService();
        $this->notificationManagerCgo = app(NotificationManagerCgo::class);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public $contenData;
    public function mount($record): void
    {
        parent::mount($record);
        $this->contenData = $this->record;
        $detailId = request()->route('record');
        $this->detailid = Content::findOrFail($detailId);
    }
    protected function getFirstFormSchema(): array
    {
        $schema = [
            TextInput::make('created_at')
                ->label('Date')
                ->disabled()
                ->columnSpan(1),

            TextInput::make('author')
                ->label('Author/Member')
                ->disabled()
                ->columnSpan(1),

            TextInput::make('title')
                ->label('Title')
                ->disabled()
                ->columnSpan('full'),

            Textarea::make('intro')
                ->label('Detail')
                ->autosize()
                ->columnSpan('full'),
        ];
        if (!empty($this->record->reason)) {
            $schema[] = TextInput::make('reason')
                ->label('Reason for reject')
                ->disabled()
                ->columnSpan('full');
        }

        return $schema;
    }

    public function handleApproval()
    {
        if (!$this->detailid) {
            session()->flash('error', ' ID content is required for approval.');
            return;
        }

        $success = $this->approvalService->approveContent(Content::class, $this->detailid->id);

        if ($success) {
            session()->flash('success', 'User has been approved successfully.');
            if ($this->detailid->content_type  == 'video') {
                return redirect()->route('filament.admin.resources.information.content.content-appoval-lists.index-video');
            }else {
                return redirect()->route('filament.admin.resources.information.content.content-appoval-lists.index');
            }
        } else {
            session()->flash('error', 'User not found.');
        }
    }
    public function showApprovalModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'additionalComments']);
    }

    public function approveItem()
    {
        if (empty($this->additionalComments)) {
            Notification::make()
                ->title('Reason is required !')
                ->danger()
                ->send();

            return;
        }elseif (strlen($this->additionalComments) > 250) {
            Notification::make()
                ->title('Reason cannot exceed 255 characters!')
                ->danger()
                ->send();
        
            return;
        }

        try {
            $content = Content::findOrFail($this->detailid->id);
            $content->status =\App\Enums\StatusEnumsManagement::NON_APPROVAL->value;
            $content->reason = $this->additionalComments;
            if($content->system=='cgo'){
                $user=CgoUser::find($content->created_by);
            }else if($content->system=='company'){
                $user=CompanyRecruiter::find($content->created_by);
            }else if($content->system=='admin'){
                $user=AdminUser::find($content->created_by);
            }
            $this->notificationManagerCgo->rejectContentSendToCgo( $user,$content);
            $content->save();

            Notification::make()
                ->title('Content updated successfully!')
                ->success()
                ->send();

            $this->closeModal();
            if ($content->content_type  == 'video') {
                return redirect()->route('filament.admin.resources.information.content.content-appoval-lists.index-video');
            }else {
                return redirect()->route('filament.admin.resources.information.content.content-appoval-lists.index');
            }

        } catch (\Exception $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }
    }

}
