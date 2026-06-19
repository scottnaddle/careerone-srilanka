<?php

namespace App\Filament\Resources\Content\VideoResource\Pages;

use App\Enums\StatusEnumsManagement;
use App\Filament\Resources\Content\VideoResource;
use App\Models\AdminUser;
use App\Models\CareerGuidanceCategory;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\SchoolKid;
use App\Models\TraineeUser;
use App\Services\Cgo\NotificationManager as NotificationManagerCgo;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;
use Filament\Actions;

class ViewVideo extends ViewRecord
{
    protected static string $resource = VideoResource::class;
    protected static string $view = 'filament.resources.content.resource.content-detail';

    public $content;
    public $type;
    public $categories;
    public $showModal = false;
    public $additionalComments;
    public $filter = '';
    protected NotificationManagerCgo $notificationManagerCgo;
    public function __construct()
    {
        $this->notificationManagerCgo = app(NotificationManagerCgo::class);
        $this->categories = CareerGuidanceCategory::all();
    }
    public function mount($record): void
    {
        parent::mount($record);
        $previousUrl = url()->previous();
        if (str_contains($previousUrl, 'tableFilters')) {
            $this->filter = '?tableFilters[status][value]=0';
        }
        $content = Content::find($this->record->id);
        if($content) {
            $user = $this->getAuthorContent($content->system, $content->created_by);
            $content->author = $user;
            foreach ($content->comments as $item) {
                $user = $this->getAuthorContent($item->system, $item->answer_by);
                $item->user = $user;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorContent($child->system, $child->answer_by);
                    $child->user = $childUser;
                }
            }
        }
        $this->content = $content;
        $this->type = 'content';
    }

    protected function getHeaderActions(): array
    {
        if ($this->content->status == StatusEnumsManagement::APPROVED_BY_ADMIN->value) {
            return [
                // Approve by expert Action
                Actions\Action::make('approve')
                    ->label(trans('admin/status.approved_by_association'))
                    ->color('primary') // Green color for approve
                    ->action(function () {
                        $this->approveDocumentByExpert();
                    }),
                // Reject Action
                Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger') // Red color for reject
                    ->action(function () {
                        $this->rejectDocument();
                    }),
            ];
        }elseif ($this->content->status == StatusEnumsManagement::REJECTED_BY_ADMIN->value) {
            return [
                // Approve Action
                Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('primary') // Green color for approve
                    ->action(function () {
                        $this->approveDocument();
                    }),
            ];
        }else {
            return [
                // Approve Action
                Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('primary') // Green color for approve
                    ->action(function () {
                        $this->approveDocument();
                    }),
                // Reject Action
                Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger') // Red color for reject
                    ->action(function () {
                        $this->rejectDocument();
                    }),
            ];
        }

    }

    // Method to handle approving the document
    public function approveContent()
    {
        // Update the document's status to "approved"
        $this->content->update([
            'status' => StatusEnumsManagement::APPROVED_BY_ADMIN->value, // Assuming status field is "approved"
        ]);

        Notification::make()
            ->title('Content has been approved.')
            ->success()
            ->send();

        // Redirect or take any additional action
        if ($this->content->content_type == 'video') {
            return redirect('/admin/content/videos'.$this->filter);
        }else{
            return redirect('/admin/content/documents'.$this->filter);
        }

    }

    // Method to handle rejecting the document

    public function rejectContent()
    {
        if (empty($this->additionalComments)) {
            Notification::make()
                ->title('Reason is required !')
                ->danger()
                ->send();

            return;
        }
        if (strlen($this->additionalComments) > 255) {
            Notification::make()
                ->title('Reason is too long! Maximum allowed length is 255 characters.')
                ->danger()
                ->send();

            return;
        }
        // Update the document's status to "rejected"
        $this->content->update([
            'status' => StatusEnumsManagement::REJECTED_BY_ADMIN->value, // Assuming status field is "rejected"
            'reason' => $this->additionalComments,
        ]);

        $content = Content::findOrFail($this->content->id);
        if($content->system=='cgo'){
            $user=CgoUser::find($content->created_by);
        }else if($content->system=='company'){
            $user=CompanyRecruiter::find($content->created_by);
        }else if($content->system=='admin'){
            $user=AdminUser::find($content->created_by);
        }
        $this->notificationManagerCgo->rejectContentSendToCgo($user, $content);
        Notification::make()
            ->title('Content has been rejected.')
            ->success()
            ->send();

        // Redirect or take any additional action
        if ($this->content->content_type == 'video') {
            return redirect('/admin/content/videos'.$this->filter);
        }else {
            return redirect('/admin/content/documents'.$this->filter);
        }
    }

    public function getAuthorContent($system, $id)
    {
        $user = null;
        switch ($system) {
            case 'cgo':
                $user = CgoUser::where(['id' => $id])->first();
                break;
            case 'company':
                $user = CompanyRecruiter::where(['id' => $id])->first();
                break;
            case 'admin':
                $user = AdminUser::where(['id' => $id])->first();
                break;
            case 'trainee':
                $user = TraineeUser::where(['id' => $id])->first();
                break;
            case 'schoolkid':
                $user = SchoolKid::where(['id' => $id])->first();
                break;
        }
        return $user;
    }

    public function approveContentByExpert()
    {
        // Update the document's status to "approved"
        $this->content->update([
            'status' => StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value, // Assuming status field is "approved"
        ]);

        Notification::make()
            ->title('Content has been approved by Expert.')
            ->success()
            ->send();

        // Redirect or take any additional action
        if ($this->content->content_type == 'video') {
            return redirect('/admin/content/videos'.$this->filter);
        }else{
            return redirect('/admin/content/documents'.$this->filter);
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
}
