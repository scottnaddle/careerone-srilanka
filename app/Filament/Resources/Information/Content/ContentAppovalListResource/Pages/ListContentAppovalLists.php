<?php

namespace App\Filament\Resources\Information\Content\ContentAppovalListResource\Pages;

use App\Filament\Resources\Information\Content\ContentAppovalListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
class ListContentAppovalLists extends ListRecords
{
    use WithFileUploads;

    protected static string $resource = ContentAppovalListResource::class;
    protected static ?string $title = '';
    public $tableRecordsPerPage = 25;
    public $showModal = false;
    public $content_name;

    public $selectedFile = [];
    public $contentIntroduction;
    public $selectedImage = null;
    public $uploadedImage;

    public ?string $activeTab = null;

    protected static string $view = 'filament.pages.information.manage-content.content.content-approval.content-approval-list';
    public function mount(): void
    {
        $previousPath = parse_url(url()->previous(), PHP_URL_PATH);
        if (str_contains($previousPath, '/information/content/content-lists/video/view')) {
            $this->redirectToVideoList();
        }
    }
    public function redirectToVideoList() {
        return redirect()->route('filament.admin.resources.information.content.content-appoval-lists.index-video');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getContentVideo()
    {
        return Content::where('type', 'video')
            ->where('status', \App\Enums\StatusEnumsManagement::PENDING_APPROVAL)
            ->paginate(9);
    }

    public function openModalContentUploading()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->content_name = '';
        $this->contentIntroduction = '';
        $this->selectedImage = null;
        $this->uploadedImage = null;
    }

    public function showFile()
    {
        $files = Content::select('attachment_details')
            ->where('content_type', '!=', 'video')
            ->get()
            ->map(function ($item) {
                $attachmentDetails = json_decode($item->attachment_details, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'filename' => $attachmentDetails['filename'] ?? '',
                        'size' => $attachmentDetails['file_size'] ?? '',
                        'path' => $attachmentDetails['path'] ?? '',
                    ];
                }
                return null;
            });

        $validFiles = $files->filter();

        $finalFiles = $validFiles->filter(function ($file) {
            return file_exists(public_path($file['path']));
        });

        $uniqueFiles = $finalFiles->unique(function ($file) {
            return $file['path'];
        });
        return $uniqueFiles;
    }

    protected function getTotal()
    {
        return ContentAppovalListResource::$countEventApprovalList;
    }

    public function selectImage($filename, $path)
    {
        $this->selectedImage = [
            'filename' => $filename,
            'path' => $path,
        ];
    }

    public function submitForm()
    {
        try {
            $data = $this->validate([
                'content_name' => 'required|string|max:255',
                'contentIntroduction' => 'required|string',
                'uploadedImage' => 'nullable|file|mimes:jpg,jpeg,png,doc,pdf|max:5120',
            ]);

            $attachmentDetails = $this->getAttachmentDetails();

            $newContent = new Content();
            $newContent->title = $data['content_name'];
            $newContent->slug = Str::slug($data['content_name'], '-', 'ta');
            $newContent->intro = $data['contentIntroduction'];
            $newContent->status = \App\Enums\StatusEnumsManagement::APPROVED;
            $newContent->content_type = 'doc';
            $newContent->system = 'admin';
            $newContent->created_by = Auth::id();
            $newContent->attachment_details = $attachmentDetails ? json_encode($attachmentDetails) : null;
            $newContent->save();

            $this->notify('Upload Content Success!', 'success');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();

            foreach ($errors->keys() as $field) {
                $this->notify($errors->first($field), 'danger');
            }

        } catch (\Exception $e) {
            $this->notify('Upload Failed: ' . $e->getMessage(), 'danger');
        }

        $this->closeModal();
    }

    private function getAttachmentDetails()
    {
        if ($this->uploadedImage) {
            $originalFileName = $this->uploadedImage->getClientOriginalName();
            $imagePath = $this->uploadedImage->storeAs(
                'admin/content-management/document/' . Auth::id(),
                $originalFileName,
                'public'
            );
            $storagePath = 'storage/' . $imagePath;
            $fileDetails = [
                'filename' => $originalFileName,
                'path' => $storagePath,
                'size' => number_format($this->uploadedImage->getSize() / 1024 / 1024, 2),
            ];
            $this->uploadedImage = null;
            return $fileDetails;
        }
        if ($this->selectedImage) {
            if (is_array($this->selectedImage)) {
                return [
                    'filename' => $this->selectedImage['filename'] ?? 'Unknown',
                    'path' => $this->selectedImage['path'] ?? 'Unknown',
                    'size' => $this->selectedImage['size'] ?? 'Unknown',
                ];
            } elseif (is_object($this->selectedImage)) {
                return [
                    'filename' => $this->selectedImage->filename ?? 'Unknown',
                    'path' => $this->selectedImage->path ?? 'Unknown',
                    'size' => $this->selectedImage->size ?? 'Unknown',
                ];
            }
        }

        return null;
    }

    public function uploadImage()
    {
        if ($this->uploadedImage) {
            $path = $this->uploadedImage->store('admin/content-management/images/' . Auth::id(), 'public');
            $this->saveImageDetails($path);
        }
    }

    public function removeSelectedImage()
    {
        $this->selectedImage = null;
    }

    public function changeImage()
    {
        $this->activeTab = 'upload';
    }

    private function notify($title, $type = 'success')
    {
        Notification::make()
            ->title($title)
            ->{$type}()
            ->send();
    }
}
