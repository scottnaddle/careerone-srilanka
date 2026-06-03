<x-filament-panels::page>
<div>

    <style>
        table thead tr th span {
            color: blue;
        }

        #search-time {
            background-color: #F9FBFF;
            color: #4984F6;
            border: none;
        }
    </style>

    <div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
        <div class="flex items-center">
            <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            'javascript:void(0)' => 'Information',
            'javascript:void(1)' => 'Q&A',
            'javascript:void(2)' => 'Q&A List',
        ]" />
        </div>
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
            Q&A List
         </h1>
        <div class="flex items-center justify-between mt-4 mb-4">
            <div class="flex gap-2">
                @if(auth('admin')->user()->hasRole('super_admin'))
                <button id="recent-button" wire:click="openModalContentUploading"
                    style="background-color: #3B82F6; color:#ffffff"
                    class="flex items-center rounded-xl border block p-2.5 bg-[#3B82F6] hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('Q&A Upload') }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
                @endif
            </div>
        </div>
        @if ($showModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl max-w-lg w-full mx-4 md:mx-8 relative">
                    <!-- Header with Title on Left and Close Button on Right -->
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                        <h2 class="text-lg font-semibold">
                            {{ __('admin/content.admin_content_list.document_content') }}
                        </h2>
                        <button type="button" wire:click="closeModal"
                            class="text-gray-500 hover:text-gray-700 text-2xl">
                            &times;
                        </button>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid gap-6 mb-6">
                        <!-- Content Name Field -->
                        <div>
                            <label for="content_name" class="block mb-2 text-sm font-medium text-gray-700">
                                {{ __('Title') }} <span class="text-red-600">*</span> <!-- Red asterisk for required field -->
                            </label>
                            <input type="text" id="content_name" wire:model.defer="content_name"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                                placeholder="{{ __('admin/content.admin_content_list.content_name_placeholder') }}" required />
                        </div>
                    </div>

                    <!-- Content Field -->
                    <div class="mt-4">
                        <label for="placehoder_content" class="block mb-2 text-sm font-medium text-gray-700">
                            {{ __('Content') }} <span class="text-red-600">*</span> <!-- Red asterisk for required field -->
                        </label>
                        <textarea id="placehoder_content" wire:model.defer="additionalComments"
                            placeholder="{{ __('admin/content.admin_content_list.comments_placeholder') }}"
                            class="w-full h-32 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="flex items-center justify-center w-full mt-6">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" id="dropzone-preview">
                                <!-- Default Icon (when no files selected) -->
                                @if (empty($files))
                                    <svg class="w-10 h-10 mb-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        {{ __('admin/content.admin_content_list.choose_file') }}
                                        <span
                                            class="font-semibold">{{ __('admin/content.admin_content_list.drag_file') }}</span>
                                    </p>
                                @endif

                                <!-- Display selected files -->
                                @if (!empty($files))
                                    <ul class="text-sm text-gray-500">
                                        @foreach ($files as $file)
                                            <li>{{ $file->getClientOriginalName() }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" wire:model="files" multiple />
                        </label>
                    </div>

                    <!-- File Removal and Information -->
                    {{-- @if (!empty($files))
                        <div id="file-info" class="mt-4">
                            <button id="delete-file-btn" wire:click="removeFiles"
                                class="mt-2 px-4 py-2 bg-red-500 text-white rounded-lg">
                                {{ __('admin/content.admin_content_list.remove_file') }}
                            </button>
                        </div>
                    @endif --}}

                    <!-- Upload and Cancel Buttons -->
                    <div class="mt-6 flex space-x-4">
                        <button type="button" wire:click="closeModal"
                            class="bg-white border text-gray-700 px-5 py-2 rounded-xl w-full hover:bg-gray-400 text-center text-sm font-semibold">
                            {{ __('admin/content.admin_content_list.cancel') }}
                        </button>
                        <button type="button" wire:click="saveContent"
                            class="bg-primary px-5 py-2 rounded-xl text-white w-full hover:bg-blue-600 text-center text-sm font-semibold">
                            {{ __('Upload') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
        <div class="mb-4"> <label for="option" class="text-lg font-semibold text-[#706F81]">
                @if (!empty(request()->query()))
                    {{ $this->getTotal() }} {{ __('admin/company.result') }}
                @endif
            </label></div>
        <div>
            {{ $this->table }}
        </div>
    </div>
</div>
<script>
    function handleFileUpload(event) {
        const fileInput = event.target;
        const previewContainer = document.getElementById('dropzone-preview');
        const fileNameContainer = document.getElementById('file-name');

        previewContainer.innerHTML = '';
        fileNameContainer.innerHTML = '';

        const file = fileInput.files[0];

        if (file) {
            const fileName = document.createElement('p');
            fileName.textContent = `Selected file: ${file.name}`;
            fileName.classList.add('text-gray-500', 'text-sm', 'mr-2');
            fileNameContainer.appendChild(fileName);
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-600');
            deleteButton.onclick = () => clearFile(fileInput);
            fileNameContainer.appendChild(deleteButton);
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.classList.add('w-32', 'h-32', 'object-cover', 'mt-3', 'rounded-lg');
                previewContainer.appendChild(img);
            }
        }
    }

    function clearFile(fileInput) {
        fileInput.value = '';
        document.getElementById('dropzone-preview').innerHTML = `
    <svg class="w-10 h-10 mb-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
    </svg>
    <p class="mb-2 text-sm text-gray-500">{{ __('admin/content.admin_content_list.choose_file') }}
        <span class="font-semibold">{{ __('admin/content.admin_content_list.drag_file') }}</span>
    </p>`;
        document.getElementById('file-name').innerHTML = '';
    }

    function previewFile(selectElement) {
        const selectedFile = JSON.parse(selectElement.value);
        const filePath = selectedFile.path;
        const fileExtension = filePath.split('.').pop().toLowerCase();
        let content = '';
        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
            content = `<img src="${'/' + filePath}" alt="Preview" class="max-w-full h-auto" />`;
        } else if (fileExtension === 'pdf') {
            content = `<iframe src="${'/' + filePath}" width="100%" height="500px"></iframe>`;
        } else if (['doc', 'docx'].includes(fileExtension)) {
            content =
                `<iframe src="https://docs.google.com/gview?url=${encodeURIComponent('http://your-domain.com/' + filePath)}&embedded=true" width="100%" height="500px"></iframe>`;
        } else {
            content = `<p>Preview not available for this file type.</p>`;
        }
        document.getElementById('preview-content').innerHTML = content;
        document.getElementById('preview-modal').classList.remove('hidden');
    }
</script>
    </x-filament-panels::page>
