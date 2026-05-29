<?php

namespace App\Filament\Resources\Information\QAResource\Pages;

use App\Filament\Resources\Information\QAResource;
use App\Models\QNA;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Filament\Notifications\Notification;
class ListQAS extends ListRecords
{
    use WithFileUploads;
    protected static string $resource = QAResource::class;
    protected static string $view = 'filament.pages.information.manage-qna.qna-list';
    protected static ?string $title = '';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public $showModal = false;
    public $content_name;


    public $files = [];
    public $additionalComments;
    public function openModalContentUploading()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    public function saveContent()
    {
        try {
            $this->validate([
                'content_name' => 'required|string|max:255',
                'additionalComments' => 'required|string|max:1000',
                'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',
            ]);

            $slug = $this->createSlug($this->content_name);

            $qna = QNA::create([
                'title' => $this->content_name,
                'description' => $this->additionalComments,
                'slug' => $slug,
                'status' => '0',
                'system' => 'admin',
                'created_by' => Auth::id(),
            ]);
            if (!empty($this->files)) {
                foreach ($this->files as $file) {
                    $originalFileName = $file->getClientOriginalName();
                    $filePath = $file->storeAs('admin/qnas/attachment_details/' . Auth::id(), $originalFileName, 'public');
                    $fileType = $file->getClientMimeType();
                    $fileSize = $file->getSize();
                    $qna->attachments()->create([
                        'file_name' => $originalFileName,
                        'path' => 'storage/' . $filePath,
                        'file_type' => $fileType,
                        'file_size' => $fileSize,
                    ]);
                }
            }
            Notification::make()
                ->title('Upload Q&A Success!')
                ->success()
                ->send();

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            foreach ($errors as $error) {
                Notification::make()
                    ->title($error)
                    ->danger()
                    ->send();
            }
            return;

        } catch (\Exception $e) {
            Notification::make()
                ->title('Upload Q&A Fail: ' . $e->getMessage())
                ->danger()
                ->send();
        }
        $this->closeModal();
    }



    protected function createSlug($title)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
    protected function getTotal()
    {
        return QAResource::$countQNA;
    }
}
