<?php

namespace App\Filament\Resources\Information\Content\ContentAppovalListResource\Pages;

use App\Filament\Resources\Information\Content\ContentAppovalListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
class ListContentVideoApprovalList extends ListRecords
{
    protected static string $resource = ContentAppovalListResource::class;
    protected static string $view = 'filament.pages.information.manage-content.content.content-approval.content-approval-list-video';
    protected static ?string $title = '';
    public $showModal = false;
    public $link_url;
    public $intro;
    public $content_name;

    protected function getContentVideo()
    {
        $searchQuery = request()->query('search');
        $searchTime = request()->query('search-time');
        $query = Content::where('content_type', 'video')
        ->where('status', \App\Enums\StatusEnumsManagement::PENDING_APPROVAL);
        if (!empty($searchQuery)) {
            $query->where('title', 'ilike', '%' . $searchQuery . '%');
        }
        if (!empty($searchTime)) {
            if ($searchTime === 'all') {
                $query->orderBy('created_at', 'desc');
            } elseif ($searchTime === 'old') {
                $query->orderBy('created_at', 'asc');
            }
        }else{
            $query->orderBy('created_at', 'desc');
        }
        $count = $query->count();
        $paginatedResults = $query->paginate(9);
        return [
            'results' => $paginatedResults,
            'count' => $count,
        ];
    }
    public function openModalContentUploading(){
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    public function submitForm()
    {
        try {
            $data = $this->validate([
                'content_name' => 'required|string|max:255',
                'intro' => 'required|string',
                'link_url' => 'required|url',
            ]);

            $newContent = new Content();
            $newContent->title = $data['content_name'];
            $newContent->slug = Str::slug($data['content_name'], '-', 'ta');
            $newContent->intro = $data['intro'];
            $newContent->status = \App\Enums\StatusEnumsManagement::APPROVED;
            $newContent->content_type = 'video';
            $newContent->system = 'admin';
            $newContent->video_url = $data['link_url'];
            $newContent->created_by = Auth::id();
            $newContent->author = '';
            $newContent->attachment_details = json_encode([]);
            $newContent->save();
            Notification::make()
                ->title('Upload Content Success!')
                ->success()
                ->send();
            $this->closeModal();
            return redirect()->route('filament.admin.resources.information.content.content-lists.index');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $errors = $e->validator->errors();
            foreach ($errors->keys() as $field) {
                Notification::make()
                    ->title($errors->first($field))
                    ->danger()
                    ->send();
                return;
            }

        } catch (\Exception $e) {
            // Handle general errors
            Notification::make()
                ->title('Upload Failed: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

}
