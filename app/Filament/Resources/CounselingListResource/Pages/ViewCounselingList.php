<?php

namespace App\Filament\Resources\CounselingListResource\Pages;

use App\Filament\Resources\CounselingListResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCounselingList extends ViewRecord
{
    protected static string $resource = CounselingListResource::class;
    protected static string $view = 'filament.pages.career-guidance.counseling.counseling-detail';
    /**
     * Customize header actions
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    /**
     * Mount the page with the given record.
     *
     * @param mixed $record
     */
    public function mount($record): void
    {
        parent::mount($record); // Call parent method to ensure base functionality
    }

    /**
     * Pass record data to the custom Blade view.
     *
     * @return array
     */
    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }
}
