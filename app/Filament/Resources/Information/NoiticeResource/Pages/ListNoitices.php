<?php

namespace App\Filament\Resources\Information\NoiticeResource\Pages;

use App\Filament\Resources\Information\NoiticeResource;
use App\Models\Content;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNoitices extends ListRecords
{
    protected static string $resource = NoiticeResource::class;
    protected static string $view = 'filament.pages.information.manage-noitice.noitice.noitice-list';
    protected static ?string $title = '';
    public $showModal = false;
    protected function getContentVideo()
    {
        return Content::where('type', 'video')
        ->where('status', 0)
        ->paginate(9);
    }
    public function openModalContentUploading(){
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    protected function getTotal()
    {
        return NoiticeResource::$countNotice;
    }
}
