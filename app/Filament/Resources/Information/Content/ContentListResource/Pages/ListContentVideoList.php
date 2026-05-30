<?php

namespace App\Filament\Resources\Information\Content\ContentListResource\Pages;

use App\Filament\Resources\Information\Content\ContentAppovalListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Content;

class ListContentVideoList extends ListRecords
{
    protected static string $resource = ContentAppovalListResource::class;
    protected static string $view = 'filament.pages.information.manage-content.content.content-list-video';
    protected static ?string $title = '';
    public $showModal = false;
    protected function getContentVideo()
    {
        $searchQuery = request()->query('search');
        $searchTime = request()->query('search-time');
        $query = Content::where('content_type', 'video');
        // $query->where('status',\App\Enums\StatusEnumsManagement::APPROVED->value);
        if (!empty($searchQuery)) {
            $query->where('title', 'like', '%' . $searchQuery . '%');
        }
        if (!empty($searchTime)) {
            if ($searchTime === 'recently') {
                $query->orderBy('created_at', 'desc');
            } elseif ($searchTime === 'oldset') {
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
}
