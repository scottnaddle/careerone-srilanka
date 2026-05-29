<?php

namespace App\Filament\Resources\Information\FAQResource\Pages;

use App\Filament\Resources\Information\FAQResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Faq as ModelsFaq;
class ListFAQS extends ListRecords
{
    protected static string $resource = FAQResource::class;
    protected static string $view = 'filament.pages.information.manage-faq.faq.faq-list';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public $showModal = false;
    protected function getContentVideo()
    {
        return ModelsFaq::where('type', 'video')
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
        return FAQResource::$countFAQ;
    }
    
}
