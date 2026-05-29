@extends('homepage.layouts.master')
@section('content')
    <div class="flex flex-col gap-4 md:gap-6 my-10">
        <a href="{{route('trainee.career-guidance.portfolio.get-resume')}}" class="font-semibold text-xl hover:underline flex gap-2 items-center hover:text-primary dark:text-white dark:hover:text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
                <path d="M7 1L1 7L7 13" stroke="#354052" class="dark:stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back to list</a>
        <form action="{{route('trainee.career-guidance.portfolio.upload-resume')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" class="hidden" name="action" value="{{isset($id) ? 'edit' : 'add'}}">
            <input type="text" class="hidden" name="id" value="{{isset($id) ? $id : ''}}">
            <div class="bg-white dark:bg-[#1E1E1E] w-full p-4 md:p-6 rounded-xl shadow-custom-light dark:shadow-custom-dark">
                <p class="font-semibold text-xl text-[#464559] dark:text-white mb-4">Upload</p>
                @if(isset($resume) && $resume->attachment != '')
                    <p class="dark:text-white">Current attachment:</p>
                    <div class="flex w-full lg:w-1/2 justify-between border border-gray-300 px-4 py-2 rounded-xl mb-3">
                        <a class="font-medium hover:text-primary dark:text-white" target="_blank" href="{{route('trainee.career-guidance.portfolio.preview-resume', ['cid' => base64_encode($resume->id)])}}">{{ basename(asset($resume->attachment)) }}</a>
                    </div>
                    <p class="dark:text-white">Choose a new attachment:</p>
                @endif
                <div x-data="dataFileDnD()"
                     class="relative flex flex-col text-gray-400 border border-gray-200 rounded-lg">
                    <div x-ref="dnd"
                         class="relative flex flex-col text-gray-400 cursor-pointer">
                        <input accept=".doc,.docx,.pdf,.png,.jpg,.jpeg" type="file"
                               name="attachment"
                               class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                               @change="addFiles($event)"
                               @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                               @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                               @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                               title="" required />

                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-width="2"
                                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-base text-[#464559] dark:text-white">{!! trans('system.information.event.form.choose_file') !!}</p>
                        </div>
                    </div>

                    <template x-if="files.length > 0">
                        <div class="grid grid-cols-4 gap-4 mt-4 md:grid-cols-6"
                             @drop.prevent="drop($event)"
                             @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                            <template x-for="(_, index) in Array.from({ length: files.length })">
                                <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                     style="padding-top: 100%;" @dragstart="dragstart($event)"
                                     @dragend="fileDragging = null"
                                     :class="{ 'border-blue-600': fileDragging == index }" draggable="true"
                                     :data-index="index">
                                    <button
                                        class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none"
                                        type="button" @click="remove(index)">
                                        <svg class="w-4 h-4 text-gray-700"
                                             xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <template x-if="files[index].type.includes('audio/')">
                                        <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                             xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                    </template>
                                    <template
                                        x-if="files[index].type.includes('application/') || files[index].type === ''">
                                        <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                             xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
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
                                            <fileDragging x-bind:src="loadFile(files[index])"
                                                          type="video/mp4" />
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
                <div class="flex gap-3 items-center p-4 md:p-5 border-gray-200 rounded-b dark:border-gray-600">
                    <a href="{{route('trainee.career-guidance.portfolio.get-resume')}}" data-modal-hide="default-modal"
                       class="w-full text-center text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
            text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{trans('system.form.button.cancel')}}
                    </a>
                    <button type="submit"
                            class="w-full text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.button.upload')}}
                    </button>
                </div>
            </div>
        </form>
    </div>



@stop
@push('js')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>

    <script>
        function dataFileDnD() {
            return {
                files: [],  // Array to hold the files
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
                    // Create a new array without the removed file
                    let files = [...this.files];
                    files.splice(index, 1);

                    this.files = createFileList(files);
                },
                drop(e) {
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
                    this.files = [];

                    const allowedTypes = [
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/pdf'
                    ];

                    // Convert FileList to Array
                    const fileList = Array.from(e.target.files);

                    // Filter files that are allowed
                    const validFiles = fileList.filter(file => allowedTypes.includes(file.type));

                    // Show error message if any files are not allowed
                    if (validFiles.length !== fileList.length) {
                        Toastify({
                            text: "Only DOC, DOCX, IMAGES, and PDF files are allowed.",
                            className: "info",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            }
                        }).showToast();
                    }

                    // Append valid files to this.files
                    this.files = createFileList([...this.files, ...validFiles]);

                    // Update the form data with the selected files
                    this.form.formData.files = this.files;
                }
            };
        }

        // Utility function to create a FileList from an array of files
        function createFileList(files) {
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            return dataTransfer.files;
        }

    </script>
@endpush
