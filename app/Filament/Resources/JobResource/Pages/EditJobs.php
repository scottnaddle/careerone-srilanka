<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use App\Models\District;
use App\Models\Sector;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EditJobs extends EditRecord
{
    protected static string $resource = JobResource::class;

    // protected static string $view = 'filament.pages.job-support.edit-job';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    public static function canEdit($record): bool
    {
        $canEdit = auth('admin')->user()->hasRole('SuperAdmin');
        return $canEdit;
    }

    public function mount($record): void
    {
        parent::mount($record);

        if (!static::canEdit($record)) {
            Notification::make()
                ->title('Permission Denied')
                ->body('You do not have permission to edit this record.')
                ->danger()
                ->send();

            Redirect::route('filament.admin.resources.jobs.index');
        }
    }

    protected function getSectors()
    {
        return Sector::get();
    }
    protected function getDistricts()
    {
        return District::get();
    }
}
