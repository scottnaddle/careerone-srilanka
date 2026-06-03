<?php

namespace App\Filament\Resources\Information\QAResource\Pages;

use App\Filament\Resources\Information\QAResource;
use App\Models\QNA;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQA extends ViewRecord
{
    protected static string $resource = QAResource::class;
    protected static string $view = 'filament.pages.information.manage-qna.qna-detail';
    public $qna;
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public function mount($record): void
    {
        parent::mount($record);
        $detailId = request()->route('record');
        $this->qna = QNA::findOrFail($detailId);
    }
}
