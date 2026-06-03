<?php

namespace App\Filament\Resources\Information\Content\EventListResource\Pages;

use App\Filament\Resources\Information\Content\EventListResource;
use App\Models\EventAttachment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;
use Filament\Notifications\Notification;

class CreateEventList extends CreateRecord
{
    use WithFileUploads;

    protected static string $resource = EventListResource::class;
    protected static bool $canCreateAnother = false;
    public $details;
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $event = parent::handleRecordCreation($data);
        if (!empty($data['attachments'])) {
            $filePath = $data['attachments'];
            $fileName = pathinfo($filePath, PATHINFO_BASENAME);
            if (\Storage::disk('public')->exists($filePath)) {
                $fileType = \Storage::disk('public')->mimeType($filePath);
                $fileSize = \Storage::disk('public')->size($filePath);
                $newDirectory = 'cgo/events/attachment_details/' . $event->id;
                $newFilePath = $newDirectory . '/' . $fileName;
                if (!\Storage::disk('public')->exists($newDirectory)) {
                    \Storage::disk('public')->makeDirectory($newDirectory);
                }
                \Storage::disk('public')->move($filePath, $newFilePath);
                $event->attachments()->create([
                    'file_name' => $fileName,
                    'file_type' => $fileType,
                    'path' => $newFilePath,
                    'file_size' => $fileSize,
                    'event_id' => $event->id,
                ]);
            } else {
                \Log::warning('File does not exist in storage: ' . $filePath);
            }
        }

        return $event;
    }

    protected function afterCreate(): void
    {
        $event = $this->record;
        \Log::info('Event ID:', ['id' => $event->id]);

        $oldDirectory = 'cgo/events/thumbnails/temp';
        $newDirectory = 'cgo/events/thumbnails/' . $event->id;

        if (\Storage::disk('public')->exists($oldDirectory)) {
            \Storage::disk('public')->makeDirectory($newDirectory);
            $files = \Storage::disk('public')->files($oldDirectory);
            foreach ($files as $file) {
                $filename = basename($file);
                \Storage::disk('public')->move($file, $newDirectory . '/' . $filename);
            }
            $event->thumbnail = 'storage/cgo/events/thumbnails/' . $event->id .'/' .basename($files[0]);
            $event->save();
            // \Storage::disk('public')->deleteDirectory($oldDirectory);
        }
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['details'])) {
            Notification::make()
                ->title('Detail is required!')
                ->danger()
                ->send();

            return [];
        }

        return $data;
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }




}
