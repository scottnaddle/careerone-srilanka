<?php

namespace App\Filament\Resources\Information\Content\EventListResource\Pages;

use App\Filament\Resources\Information\Content\EventListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Event;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Validator;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use App\Filament\Forms\Components\CKEditor;
use Illuminate\Support\Facades\Storage;

class EditEventList extends EditRecord
{
    protected static string $resource = EventListResource::class;
    protected static string $view = 'filament.pages.information.manage-event.event.event-edit';
    public $detailid;
    public $details;
    public $contenData;
    public $showModal = false;
    public $additionalComments;
    public function mount($record): void
    {
        parent::mount($record);

        $detailId = request()->route('record');
        $this->contenData = $this->record;
        $this->detailid = Event::findOrFail($detailId);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Custom actions if needed
        ];
    }


    public function approveItem()
    {
        $formData = $this->form->getState();
    
        // Validation
        $validator = Validator::make($formData, [
            'title' => 'required|string|max:200',
            'event_type' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'system' => 'required|string|max:100',
            'details' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Notification::make()
                    ->title($error)
                    ->danger()
                    ->send();
            }
            return;
        }
    
        try {
            $eventList = Event::findOrFail($this->detailid->id);
    
            // Update basic information
            $eventList->fill([
                'title' => $formData['title'],
                'created_at' => now(),
                'event_type' => $formData['event_type'],
                'system' => $formData['system'],
                'details' => $formData['details'],
            ]);
    
            // Process attachments
            if (!empty($formData['attachments'])) {
                $this->handleFile(
                    $formData['attachments'],
                    'storage/cgo/events/attachment_details/' . $this->detailid->id,
                    'attachments'
                );
            }
    
            // Process thumbnail
            if (!empty($formData['thumbnail'])) {
                $this->handleFile(
                    $formData['thumbnail'],
                    'cgo/events/thumbnails/' . $this->detailid->id,
                    'thumbnail'
                );
            }
    
            // Save the event
            $eventList->save();
    
            Notification::make()
                ->title('Event updated successfully!')
                ->success()
                ->send();
    
            return redirect()->route('filament.admin.resources.information.content.event-lists.index');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    /**
     * Handle file processing (attachments and thumbnails).
     */
    private function handleFile(string $filePath, string $destinationDirectory, string $type)
    {
        if (\Storage::disk('public')->exists($filePath)) {
            $fileName = pathinfo($filePath, PATHINFO_BASENAME);
            $newFilePath = $destinationDirectory . '/' . $fileName;
    
            if (!\Storage::disk('public')->exists($destinationDirectory)) {
                \Storage::disk('public')->makeDirectory($destinationDirectory);
            }
    
            \Storage::disk('public')->move($filePath, $newFilePath);
    
            if ($type === 'attachments') {
                // Handle attachments
                $existingAttachment = $this->record->attachments()->first();
                if ($existingAttachment) {
                    if (\Storage::disk('public')->exists($existingAttachment->path)) {
                        \Storage::disk('public')->delete($existingAttachment->path);
                    }
                    $existingAttachment->update([
                        'file_name' => $fileName,
                        'file_type' => \Storage::disk('public')->mimeType($newFilePath),
                        'path' => $newFilePath,
                        'file_size' => \Storage::disk('public')->size($newFilePath),
                    ]);
                } else {
                    $this->record->attachments()->create([
                        'file_name' => $fileName,
                        'file_type' => \Storage::disk('public')->mimeType($newFilePath),
                        'path' => $newFilePath,
                        'file_size' => \Storage::disk('public')->size($newFilePath),
                    ]);
                }
            } elseif ($type === 'thumbnail') {
                // Handle thumbnail
                if (!empty($this->record->thumbnail) && \Storage::disk('public')->exists($this->record->thumbnail)) {
                    \Storage::disk('public')->delete($this->record->thumbnail);
                }
    
                $this->record->update([
                    'thumbnail' =>'storage/'. $newFilePath,
                ]);
            }
        } else {
            \Log::warning('File does not exist in storage: ' . $filePath);
        }
    }
    
    protected function closeModal()
    {
        return redirect()->route('filament.admin.resources.information.content.event-lists.index');
    }
    protected function getFirstFormSchema(): array
    {
        return [

            Select::make('event_type')
                ->label('Event Type')
                ->relationship('categoryModule', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->columnSpan('w-1/2'),

            TextInput::make('title')
                ->label('Title')
                ->required()
                ->rules('required|string|max:255')
                ->columnSpan('w-1/2'),
            DateTimePicker::make('start_time')
                ->label('Start Time')
                ->native(false)
                ->required()
                ->rules('required|date')
                ->columnSpan('w-1/2'),
            DateTimePicker::make('end_time')
                ->label('End Date')
                ->native(false)
                ->required()
                ->rules('required|date')
                ->columnSpan('w-1/2'),


            CKEditor::make('details')
                ->label('Details')
                ->required()
                ->columnSpan('full'),
            FileUpload::make('thumbnail')
                ->directory('storage/cgo/events/thumbnails/' . Auth::id())
                ->imageEditor()
                ->required()
                ->preserveFilenames()
                ->columnSpan('full')
                ->optimize('webp')
                ,
            // TextInput::make('reason_for_refusal')
            //     ->label('Reason for reject')
            //     ->columnSpan('full'),
            FileUpload::make('attachments')
            ->multiple()
            ->directory('events')
            ->preserveFilenames()
            ->downloadable()
            ->openable()
            ->reorderable()
            ->columnSpanFull()
            ->optimize('webp')
    ,
        ];
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeSave(): void
    {
        $event = $this->record;
        \Log::info('Event Updated ID:', ['id' => $event->id]);
    
        // Process thumbnail
        $thumbnailState = $this->getState('thumbnail');
        if (!empty($thumbnailState)) {
            $this->handleFile(
                $thumbnailState,
                'cgo/events/thumbnails/' . $event->id,
                'thumbnail'
            );
        }
    
        // Process attachments if present
        $attachmentState = $this->getState('attachments');
        if (!empty($attachmentState)) {
            $this->handleFile(
                $attachmentState,
                'cgo/events/attachments/' . $event->id,
                'attachments'
            );
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($this->record) {
            $data['attachments'] = $this->record->attachments[0]->path ?? null;
    
            if (!empty($this->record->thumbnail)) {
                $data['thumbnail'] = str_replace('storage/', '', $this->record->thumbnail);
            } else {
                $data['thumbnail'] = null;
            }
        } else {
            $data['attachments'] = null;
            $data['thumbnail'] = null;
        }
    
        return $data;
    }
    

}
