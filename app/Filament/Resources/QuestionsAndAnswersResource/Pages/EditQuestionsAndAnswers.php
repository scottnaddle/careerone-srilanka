<?php

namespace App\Filament\Resources\QuestionsAndAnswersResource\Pages;

use App\Filament\Resources\QuestionsAndAnswersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestionsAndAnswers extends EditRecord
{
    protected static string $resource = QuestionsAndAnswersResource::class;

    protected static string $view = 'filament.pages.information.manage-qna.qna-edit';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
