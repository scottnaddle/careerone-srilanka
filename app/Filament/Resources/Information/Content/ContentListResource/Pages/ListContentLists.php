<?php

namespace App\Filament\Resources\Information\Content\ContentListResource\Pages;

use App\Filament\Resources\Information\Content\ContentListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Content;

class ListContentLists extends ListRecords
{
    protected static string $view = 'filament.pages.information.manage-content.content.content-list';
    protected static string $resource = ContentListResource::class;
    protected static ?string $title = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTotal()
    {
        return ContentListResource::$countContentList;
    }
    public function mount(): void
    {
        $previousPath = parse_url(url()->previous(), PHP_URL_PATH);
        if (str_contains($previousPath, '/information/content/content-appoval-lists/video/view')) {
            $this->redirectToVideoList();
        }
    }
    public function redirectToVideoList() {
        return redirect()->route('filament.admin.resources.information.content.content-lists.index-video');
    }
}
