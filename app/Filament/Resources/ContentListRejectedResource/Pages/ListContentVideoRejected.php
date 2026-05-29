<?php

namespace App\Filament\Resources\ContentListRejectedResource\Pages;
use App\Filament\Resources\ContentListRejectedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Content;

class ListContentVideoRejected extends ListRecords
{
    protected static string $resource = ContentListRejectedResource::class;
    protected static string $view = 'filament.pages.information.manage-content.content-list-rejected.list-video.content-list-video';
    public $showModal = false;
    protected function getContentVideo()
    {
        $searchQuery = request()->query('search');
        $searchTime = request()->query('search-time-video');
        $query = Content::where('type', 'video')
        ->where('status', \App\Enums\StatusEnumsManagement::NON_APPROVAL->value);
        if (!empty($searchQuery)) {
            $query->where('title', 'ilike', '%' . $searchQuery . '%');
        }
        if (!empty($searchTime)) {
            if ($searchTime === 'recently') {
                $query->orderBy('created_at', 'desc');
            } elseif ($searchTime === 'oldset') {
                $query->orderBy('created_at', 'asc');
            }
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
}
