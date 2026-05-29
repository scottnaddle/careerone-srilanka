@extends('homepage.layouts.master')
@section('title', 'Create new event')
@push('css')

    <style>
        .dz-preview .dz-image img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        .dropzone {
            background: white;
            border-width: 1px;
            border-radius: 0.5rem;
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / var(--tw-border-opacity));
        }

        .dropzone:hover {
            background-color: aliceblue !important;
        }

        .ck-editor__editable_inline {
            min-height: 200px;
        }

        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            min-height: 200px;
        }

        .ck-content .image {
            /* Block images */
            max-width: 80%;
            margin: 20px auto;
        }
        /* Thumbnail preview styles */
        #thumbnail-preview-container {
            position: relative;
            margin-bottom: 0.75rem;
        }

        #thumbnail-preview {
            width: 100%;
            height: 8rem;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }

        #remove-thumbnail {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            background-color: #ef4444;
            color: white;
            border-radius: 9999px;
            padding: 0.25rem;
            transition: background-color 0.2s;
        }

        #remove-thumbnail:hover {
            background-color: #dc2626;
        }

        .dark #thumbnail-preview {
            border-color: #374151;
        }
    </style>
@endpush
@section('content')
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('system.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.information.root'), 'url' => '#'],
            ['label' => trans('system.information.event.title'), 'url' => route('informations.events.event')],
            ['label' => trans('system.information.event.new_event'), 'url' => '#'],
        ]" />
    </div>
    <div class="flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl p-6 mb-10">
{{--        <a href="{{ route('informations.events.event') }}"--}}
{{--            class="flex items-center gap-2 text-[#464559] dark:text-white text-xl font-semibold w-fit">--}}
{{--            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                <path d="M15.5 6L9.5 12L15.5 18" stroke="#354052" stroke-width="2" class="dark:stroke-white"--}}
{{--                    stroke-linecap="round" stroke-linejoin="round" />--}}
{{--            </svg>--}}
{{--            {{ trans('system.information.event.new_event') }}</a>--}}
        <div>
            <form class="flex flex-col gap-5" method="POST" action="{{ route('informations.events.create') }}"
                id="form-create" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-4 xl:col-span-1">
                        <label for="type"
                            class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{ trans('system.information.event.type.title') }}<span
                                class="text-red-700">*</span>
                        </label>
                        <select id="event_type" name="event_type"
                            class=" border h-10 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach (getCodeList('event_type') as $item)
                                <option value="{{ $item->code_id }}">{{ $item->code_name }} </option>
                            @endforeach

                        </select>
                        @if ($errors->has('event_type'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('event_type') }}</span>
                        @endif
                    </div>
                    <div class="col-span-4 xl:col-span-3 xl:col-start-2 xl:col-end-5">
                        <div>
                            <label for="title"
                                class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{ trans('system.information.event.form.title') }}
                                <span class="text-red-700">*</span></label>
                            <input type="text" name="title" id="title"
                                placeholder="{{ __('system.information.event.form.title_placeholder') }}"
                                value="{{ old('title') }}"
                                class=" border p-3 pl-4 h-10 w-full border-gray-300 text-gray-900 sm:text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white">
                            @if ($errors->has('title'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <label for="date_range"
                        class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{trans('system.information.event.form.date')}}
                        <span class="text-red-700">*</span></label>
                    <div class="row grid grid-cols-4 gap-4 ">
                        <div class="relative col-start-1 col-end-3">

                            <div class="relative">
                                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                    </svg>
                                </div>
                                <input datepicker datepicker-buttons datepicker-autoselect-today
                                    data-date-format="YYYY MMMM DD"
                                    value="{{ \Carbon\Carbon::parse(old('start_time'))->format('M d Y') }}"
                                    datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('M d Y') }}"
                                    type="text" name="start_time"
                                    class="bg-white border border-gray-300 p-2.5 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Start time">

                            </div>


                            @if ($errors->has('start_time'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('start_time') }}</span>
                            @endif
                        </div>

                        <div class="relative col-start-3 col-end-5">

                            <div class="relative">
                                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                    </svg>
                                </div>
                                <input datepicker datepicker-buttons datepicker-autoselect-today
                                    data-date-format="YYYY MMMM DD"
                                    value="{{ \Carbon\Carbon::parse(old('end_time'))->format('M d Y') }}"
                                    datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('M d Y') }}"
                                    type="text" name="end_time"
                                    class="bg-white border border-gray-300 p-2.5 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="End time">

                            </div>
                            @if ($errors->has('end_time'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('end_time') }}</span>
                            @endif
                        </div>
                        <div class="relative col-span-4 xl:col-span-1 ">
                            <label for="date_range"
                                   class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{ trans('system.information.event.form.thumbnail') }}
                                <span class="text-red-700">*</span></label>

                            <!-- Thumbnail preview container -->
                            <div id="thumbnail-preview-container" class="relative mb-3 hidden">
                                <img id="thumbnail-preview" class="w-full h-32 object-cover rounded-lg border border-gray-300"
                                     alt="Thumbnail preview">
                                <button type="button" id="remove-thumbnail"
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <input
                                class="relative bg-gray-50 m-0 block w-full min-w-0 flex-auto cursor-pointer rounded-lg border border-gray-300 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none dark:border-white/70 dark:text-white file:dark:text-white"
                                id="thumbnail" type="file" name="thumbnail" accept="image/*" />
                            <span class="text-red-600 text-xs p-0 m-0"
                                  id="attached_file_error">{{ $errors->first('thumbnail') }}</span>
                        </div>
                        <div class="relative col-span-4 xl:col-span-3 xl:col-start-2 xl:col-end-5">
                            <label for="place"
                                   class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{trans('system.information.event.form.place')}}
                                </label>
                            <input type="text" name="place" id="place"
                                   placeholder="Place"
                                   value="{{ old('place') }}"
                                   class=" border p-3 pl-4 h-10 w-full border-gray-300 text-gray-900 sm:text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white">
                            @if ($errors->has('place'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('place') }}</span>
                            @endif
                        </div>

                    </div>
                </div>
                <div>
                    <label for="details"
                        class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{ trans('system.information.event.form.details') }}
                        <span class="text-red-700">*</span></label>
                    <textarea id="editor" name="details" class="border border-gray-300 rounded-lg">{{ old('details') }}</textarea>
                    @if ($errors->has('details'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('details') }}</span>
                    @endif
                </div>
                <div class="bg-white mx-auto w-full dark:bg-[#1E1E1E] rounded-xl">
                    <div x-data="dataFileDnD()" class="relative flex flex-col text-gray-400 border border-gray-300">
                        <div x-ref="dnd" class="relative flex flex-col text-gray-400 rounded cursor-pointer">
                            <input accept=".doc,.docx,.pdf,.png,.jpg,.jpeg,.gif" type="file" multiple
                                name="attachment_details[]"
                                class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                                @change="addFiles($event)"
                                @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                                @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                title="" />

                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-base text-[#464559] dark:text-white">{!! trans('system.information.event.form.choose_file') !!}</p>
                            </div>
                        </div>

                        <template x-if="files.length > 0">
                            <div class="grid grid-cols-4 gap-4 mt-4 md:grid-cols-6" @drop.prevent="drop($event)"
                                @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                                <template x-for="(_, index) in Array.from({ length: files.length })">
                                    <div class="relative flex flex-col items-center overflow-hidden text-center border bg-gray-300 rounded-lg cursor-move select-none"
                                        style="padding-top: 100%;" @dragstart="dragstart($event)"
                                        @dragend="fileDragging = null"
                                        :class="{ 'border-blue-600': fileDragging == index }" draggable="true"
                                        :data-index="index">
                                        <button
                                            class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none"
                                            type="button" @click="remove(index)">
                                            <svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <template x-if="files[index].type.includes('audio/')">
                                            <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                        </template>
                                        <template
                                            x-if="files[index].type.includes('application/') || files[index].type === ''">
                                            <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </template>
                                        <template x-if="files[index].type.includes('image/')">
                                            <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                                x-bind:src="loadFile(files[index])" />
                                        </template>
                                        <template x-if="files[index].type.includes('video/')">
                                            <video
                                                class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
                                                <fileDragging x-bind:src="loadFile(files[index])" type="video/mp4">
                                            </video>
                                        </template>

                                        <div
                                            class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
                                            <span class="w-full font-bold text-gray-900 truncate"
                                                x-text="files[index].name">Loading</span>
                                            <span class="text-xs text-gray-900"
                                                x-text="humanFileSize(files[index].size)">...</span>
                                        </div>

                                        <div class="absolute inset-0 z-40 transition-colors duration-300"
                                            @dragenter="dragenter($event)" @dragleave="fileDropping = null"
                                            :class="{
                                                'bg-blue-200 bg-opacity-80': fileDropping == index &&
                                                    fileDragging != index
                                            }">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                    <p class="text-xs text-right flex justify-end mt-2 w-full dark:text-white">
                        {{trans('system.information.content_management.document.hint_file')}}
                    </p>
                </div>
                @if ($errors->has('attachment_details'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('attachment_details') }}</span>
                @endif

                <div class="flex gap-3 justify-end">
                    <a href="{{ route('informations.events.event') }}"
                        class="w-fit text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{ trans('system.form.button.cancel') }}
                    </a>
                    <button type="submit" id="submit-all"
                        class="w-fit text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('system.form.button.create') }}
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection
@push('js')
    {{-- <script src="{{ asset('js/datepicker.min.js') }}" type="module"></script> --}}
    {{-- <script src="{{ asset('js/datepicker.min.js') }}" type="module"></script> --}}

    <script src="{{ asset('js/ckeditor.js') }}" type="module"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
    <script>
        function dataFileDnD() {
            return {
                files: [],
                form: null,
                fileDragging: null,
                fileDropping: null,
                humanFileSize(size) {
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    return (
                        (size / Math.pow(1024, i)).toFixed(2) * 1 +
                        " " + ["B", "kB", "MB", "GB", "TB"][i]
                    );
                },
                remove(index) {
                    let files = [...this.files];
                    files.splice(index, 1);

                    this.files = createFileList(files);
                    this.updateFormData();
                    this.updateFileInput();
                },
                drop(e) {
                    // Since we only allow one file, dropping functionality is not needed
                    e.preventDefault();
                },
                dragenter(e) {
                    e.preventDefault();
                },
                dragstart(e) {
                    // Dragging functionality is not needed since we only allow one file
                },
                loadFile(file) {
                    const preview = document.querySelectorAll(".preview");
                    const blobUrl = URL.createObjectURL(file);

                    preview.forEach(elem => {
                        elem.onload = () => {
                            URL.revokeObjectURL(elem.src); // free memory
                        };
                    });

                    return blobUrl;
                },
                addFiles(e) {
                    this.form = document.getElementById('form-create');
                    // this.files = [];
                    const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'
                    ];

                    // Convert FileList to Array
                    const fileList = Array.from(e.target.files);

                    // Filter files that are allowed
                    const validFiles = fileList.filter(file => allowedTypes.includes(file.type));

                    // Show error message if any files are not allowed
                    if (validFiles.length !== fileList.length) {
                        Toastify({
                            text: "{{ trans('system.event.allowed_files') }}",
                            className: "info",
                            style: {
                                background:  "#e74c3c",
                            }
                        }).showToast();
                        return;
                    }

                    // Update this.files and this.form.formData.files with valid files
                    this.files = createFileList([...this.files], validFiles);
                    // this.form.formData.files = [...this.files];
                    this.updateFormData();
                    this.updateFileInput();
                },
                updateFormData() {
                    this.files = Array.from(this.files);
                    // Recreate the FormData after files are removed
                    let formData = new FormData(this.form);

                    // Append each remaining file to the form data
                    this.files.forEach((file) => {
                        formData.append('files[]', file);
                    });
                },
                updateFileInput() {
                    // Create a new DataTransfer object
                    const dataTransfer = new DataTransfer();

                    // Add the files from the current array to the DataTransfer object
                    this.files.forEach((file) => {
                        dataTransfer.items.add(file);
                    });

                    // Update the file input element
                    const fileInput = this.form.querySelector('input[type="file"][name="attachment_details[]"]');
                    fileInput.files = dataTransfer.files; // Assign new FileList to the input
                },
            }
        }
    </script>
    <script type="module">
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
            ckfinder: {
                uploadUrl: "{{ route('upload.images', ['_token' => csrf_token()]) }}",
            },
            toolbar: {
                items: [
                    'bold', 'italic', 'underline','|',
                    'heading', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'blockQuote','|',


                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor','insertTable', 'fontBackgroundColor', 'highlight', '|',

                    'link', 'uploadImage',
                    '|',
                ],
                shouldNotGroupWhenFull: true
            },
            // Changing the language of the interface requires loading the language file using the <script> tag.
            // language: 'es',
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
            placeholder: 'Enter details for event!',
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
            // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            // Be careful with enabling previews
            // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
            htmlEmbed: {
                showPreviews: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
            mention: {
                feeds: [{
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                        '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                        '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                        '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }]
            },
            // The "superbuild" contains more premium features that require additional configuration, disable them below.
            // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'AIAssistant',
                'CKBox',
                'CKFinder',
                'EasyImage',
                // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                // Storing images as Base64 is usually a very bad idea.
                // Replace it on production website with other solutions:
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                // 'Base64UploadAdapter',
                'MultiLevelList',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                'MathType',
                // The following features are part of the Productivity Pack and require additional license.
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents',
                'PasteFromOfficeEnhanced',
                'CaseChange'
            ]
        });
        // Thumbnail preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnailInput = document.getElementById('thumbnail');
            const previewContainer = document.getElementById('thumbnail-preview-container');
            const previewImage = document.getElementById('thumbnail-preview');
            const removeThumbnailBtn = document.getElementById('remove-thumbnail');

            // Hàm hiển thị preview
            function previewThumbnail(file) {
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }

            // Xử lý khi chọn file
            thumbnailInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Kiểm tra định dạng file
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                    if (!allowedTypes.includes(file.type)) {
                        Toastify({
                            text: "{{ trans('system.event.invalid_image_format') }}",
                            className: "info",
                            style: {
                                background: "#e74c3c",
                            }
                        }).showToast();
                        thumbnailInput.value = '';
                        previewContainer.classList.add('hidden');
                        return;
                    }

                    // Kiểm tra kích thước file (ví dụ: giới hạn 5MB)
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    if (file.size > maxSize) {
                        Toastify({
                            text: "{{ trans('system.event.image_too_large') }}",
                            className: "info",
                            style: {
                                background: "#e74c3c",
                            }
                        }).showToast();
                        thumbnailInput.value = '';
                        previewContainer.classList.add('hidden');
                        return;
                    }

                    previewThumbnail(file);
                } else {
                    previewContainer.classList.add('hidden');
                    previewImage.src = '';
                }
            });

            // Xử lý khi nhấn nút xóa preview
            removeThumbnailBtn.addEventListener('click', function() {
                thumbnailInput.value = '';
                previewContainer.classList.add('hidden');
                previewImage.src = '';

                // Trigger change event để clear error messages
                const event = new Event('change', { bubbles: true });
                thumbnailInput.dispatchEvent(event);
            });

            // Nếu có thumbnail cũ từ validation error (edit mode)
            const oldThumbnail = "{{ old('thumbnail') }}";
            if (oldThumbnail && oldThumbnail !== '') {
                // Chỉ áp dụng nếu đang ở chế độ edit (nếu có)
                previewContainer.classList.add('hidden');
            }
        });
    </script>
@endpush
