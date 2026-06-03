<?php

namespace App\Filament\Resources\Information\QAResource\Pages;

use App\Filament\Resources\Information\QAResource;
use App\Models\QNA;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQA extends EditRecord
{
    protected static string $resource = QAResource::class;
    protected static string $view = 'filament.pages.information.manage-qna.qna-edit';
    public $qna;
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mount($record): void
    {
        parent::mount($record);
        $detailId = request()->route('record');
        $this->qna = QNA::findOrFail($detailId);
    }
}
