@extends('homepage.layouts.master')
@section('title', 'Q&A edit')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}" type="text/css" />

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

        .reply-item {
            display: flex;
            gap: 4px;
        }

        .reply-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
        }

        .reply-child-container {
            margin-left: 60px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .reply-content-child-container {
            display: flex;
            gap: 4px;
        }
    </style>
@endpush
@section('content')
    <p class="text-3xl p-4 text-[#464559] font-semibold dark:text-white">{{trans('system.information.qna.title')}}
    <p />
    <div class="flex flex-col gap-2 bg-white dark:bg-[#1E1E1E] rounded-xl p-4 mb-10">
        @if (session()->has('success'))
            <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                {{ session()->get('success') }}
            </div>
        @endif
        @if ($errors->any())
            {!! implode(
                '',
                $errors->all(
                    '<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>',
                ),
            ) !!}
        @endif
        <div class="flex flex-col gap-6">
            <a href="{{ route('informations.qnas.list') }}"
               class="flex items-center gap-2 text-[#464559] text-xl font-bold w-fit dark:text-white break-all"><svg
                    width="24" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5 6L9.5 12L15.5 18" stroke="#354052" stroke-width="2" class="dark:stroke-white"
                          stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                {{ \Str::limit($qna->title,100) }}
            </a>

            <form class="relative bg-white rounded-lg shadow-custom-light dark:shadow-custom-dark dark:bg-[#1E1E1E] w-full" method="POST"
                  enctype="multipart/form-data" id="form-create"
                  action="{{ route('informations.qnas.update', ['qNA' => $qna]) }}">
                @csrf
                @method('PUT')
                <p class="text-lg md:text-xl font-semibold px-4 md:px-5 dark:text-white">{{trans('system.form.edit_qna')}}</p>
                <div class="p-4 md:p-5 space-y-4">
                    <div class="flex flex-col">
                        <label for="title" class="text-sm font-medium text-gray-600 block dark:text-gray-300 mb-2">
                            {{trans('system.information.qna.title')}}<span class="text-red-600 p-1 text-center">*</span></label>
                        <input type="text" name="title" id="title" value="{{ $qna->title }}"
                               oninput="trimSpaces(this)"
                               class="w-full py-2 px-3 pl-4 h-9 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <div class="flex flex-col">
                        <label for="description"
                               class="text-sm font-medium text-gray-600 block dark:text-gray-300 mb-2">
                            {{trans('system.information.qna.content')}}<span class="text-red-600 p-1 text-center">*</span></label>
                        <textarea id="description" oninput="trimSpaces(this)" name="description" rows="10"
                                  class="block p-3 pl-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="">{{ $qna->description }}</textarea>
                    </div>
                    @if ($qna->attachments->count() > 0)
                        <div class="relative">
                            <div class="px-4 py-2 w-full sm:gap-4 sm:px-0 w-full" id="attachment-block">
                                <div class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list" class="divide-y divide-gray-100 border rounded-md border-gray-300">
                                        @foreach ($qna->attachments as $item)
                                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6"
                                                id="attachment-{{ $item->id }}">
                                                <div class="flex w-0 flex-1 items-center">
                                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20"
                                                         fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                              d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                              clip-rule="evenodd" />
                                                    </svg>
                                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                        <a href="{{route('informations.qnas.attachments.preview', ['id' => $item->id])}}" target="_blank" class="hover:text-primary truncate font-medium dark:text-white">{{ $item->file_name }}</a>
                                                        <span
                                                            class="flex-shrink-0 text-gray-400">{{ $item->file_size }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <button type="button" data-id="{{ $item->id }}" data-qna-id={{ $qna->id }}
                                                        class="btn-delete">
                                                        <svg width="20" height="23" viewBox="0 0 20 23"
                                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M14 5.5V4.7C14 3.5799 14 3.01984 13.782 2.59202C13.5903 2.21569 13.2843 1.90973 12.908 1.71799C12.4802 1.5 11.9201 1.5 10.8 1.5H9.2C8.07989 1.5 7.51984 1.5 7.09202 1.71799C6.71569 1.90973 6.40973 2.21569 6.21799 2.59202C6 3.01984 6 3.5799 6 4.7V5.5M8 11V16M12 11V16M1 5.5H19M17 5.5V16.7C17 18.3802 17 19.2202 16.673 19.862C16.3854 20.4265 15.9265 20.8854 15.362 21.173C14.7202 21.5 13.8802 21.5 12.2 21.5H7.8C6.11984 21.5 5.27976 21.5 4.63803 21.173C4.07354 20.8854 3.6146 20.4265 3.32698 19.862C3 19.2202 3 18.3802 3 16.7V5.5"
                                                                stroke="#F34550" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </li>
                                        @endforeach


                                    </ul>
                                </div>
                            </div>
                            <div id="loading" class="flex items-center justify-center w-full h-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 top-0 absolute hidden">
                                <div role="status">
                                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>

                    @endif

                    <div class="bg-white mx-auto w-full dark:bg-[#1E1E1E] rounded-xl">
                        <div x-data="dataFileDnD()"
                             class="relative flex flex-col text-gray-400 border border-gray-200 rounded dark:border-none">
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
                                        <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                             style="padding-top: 100%;" @dragstart="dragstart($event)"
                                             @dragend="fileDragging = null"
                                             :class="{ 'border-blue-600': fileDragging == index }" draggable="true"
                                             :data-index="index">
                                            <button
                                                class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none"
                                                type="button" @click="remove(index)">
                                                <svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    </div>
                    <p class="text-xs flex justify-end mt-2 w-full dark:text-white">{{ trans('system.information.event.form.hint_file') }}
                    </p>
                </div>
                <div
                    class="flex gap-3 items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <a href="{{route('informations.qnas.reply', ['slug' => $qna->slug])}}" class="w-full text-center text-gray-500 bg-gray-100 hover:bg-gray-500 hover:text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{trans('system.form.button.cancel')}}
                    </a>
                    <button type="submit" id="submit-all"
                            class="w-full text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.button.save')}}
                    </button>
                </div>
                <!-- Modal footer -->

            </form>
        </div>


    </div>
    {{-- modal delete attachment  --}}
     <div id="modal-delete-attachment" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between pb-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                            {{trans('system.delete_modal.title')}}
                        </h3>
                        <button type="button"
                            class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="modal-delete-attachment">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="flex flex-col gap-4">
                        <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                            {{trans('system.delete_modal.content')}}</h3>
                        <div class="flex justify-center gap-4">
                            <button type="button"
                                class="delete-attachment-button text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                <svg aria-hidden="true" id="loading-icon" class="hidden w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600 mr-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="white"/></svg>
                                {{trans('system.delete_modal.yes')}}
                            </button>
                            <button data-modal-hide="modal-delete-attachment" type="button" id="button-close-delete-modal"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"> {{trans('system.delete_modal.no')}}</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/datepicker.min.js') }}" type="module"></script>
    <script src="{{ asset('js/ckeditor.js') }}" type="module"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
    <script>
        // $(document).ready(function() {
        const $targetElDeleteAttachment = document.getElementById('modal-delete-attachment');
        // options with default values
        const options = {
            placement: 'top-center',
            backdrop: 'static',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {
            },
            onShow: () => {
            },
            onToggle: () => {
            },
        };


        const instanceDeleteAttachmentOptions = {
            id: 'modal-delete-attachment',
            override: true
        };

        const modalDeleteAttachment = new Modal($targetElDeleteAttachment, options,
            instanceDeleteAttachmentOptions);
        // })
    </script>
    <script>


        $(".btn-delete").click(function() {
            let id = $(this).data('id');
            let qna_id = $(this).data('qna-id');
            modalDeleteAttachment.show();
            let delete_attachment_button = $('.delete-attachment-button');
            let url = 'informations/qnas/attachment/delete/' + id + '/' + qna_id;
            delete_attachment_button.data('id', id);
            delete_attachment_button.data('url', url);
        });

        $('.delete-attachment-button').click(function() {
            let id = $(this).data('id');
            let url = $(this).data('url');
            let item_id = '#attachment-' + id;
            let numberOfAttachments = $('#attachment-block ul').children('li').length;
            $('#loading').removeClass('hidden');
            $('#loading-icon').removeClass('hidden');

            $.ajax({
                url: url,
                type: "GET",
                // dataType: "json",
                success: function(data) {
                    Toastify({
                        text: "{{trans('system.message.deleted')}}",
                        duration: 2000,
                        className: "infor",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                    $(item_id).remove();
                    if (numberOfAttachments === 1) {
                        $('#attachment-block').remove();
                    }
                    modalDeleteAttachment.hide();
                    $('#loading').addClass('hidden');
                    $('#loading-icon').addClass('hidden');
                },
                error: function(xhr, status, error) {
                }
            });


        });

        $('#button-close-delete-modal').click(function() {
            modalDeleteAttachment.hide();
        })
    </script>
    <script>
        function trimSpaces(input) {
            input.value = input.value.replace(/^\s+/, '');
        }
    </script>
    <script type="module">
        $(document).ready(function() {
            function toggleSubmitButton() {
                // Get the values of all input fields
                var titleValue = $('#title').val();
                var descriptionValue = $('#description').val();

                // Check if all input fields are empty or null
                var anyFieldEmptyOrNull = !titleValue || !descriptionValue;

                // Disable or enable the Sign up button based on the condition
                if (anyFieldEmptyOrNull) {
                    $('#submit-all').addClass('disabled-button');
                    $('#submit-all').prop('disabled', true);
                } else {
                    $('#submit-all').removeClass('disabled-button');
                    $('#submit-all').prop('disabled', false);
                }
            }


            toggleSubmitButton();

            $('input, select, textarea').on('input change', function() {
                toggleSubmitButton();
            });


        });
    </script>
    <script>
        function dataFileDnD(){
            return {
                files: [],
                form: null,
                fileDragging: null,
                fileDropping: null,
                humanFileSize(size){
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    return (
                        (size / Math.pow(1024, i)).toFixed(2) * 1 +
                        " " + ["B", "kB", "MB", "GB", "TB"][i]
                    );
                },
                remove(index){
                    let files = [...this.files];
                    files.splice(index, 1);

                    this.files = createFileList(files);
                    this.updateFormData();
                    this.updateFileInput();
                },
                drop(e){
                    // Since we only allow one file, dropping functionality is not needed
                    e.preventDefault();
                },
                dragenter(e){
                    e.preventDefault();
                },
                dragstart(e){
                    // Dragging functionality is not needed since we only allow one file
                },
                loadFile(file){
                    const preview = document.querySelectorAll(".preview");
                    const blobUrl = URL.createObjectURL(file);

                    preview.forEach(elem => {
                        elem.onload = () => {
                            URL.revokeObjectURL(elem.src); // free memory
                        };
                    });

                    return blobUrl;
                },
                addFiles(e){
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
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
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
                updateFormData(){
                    this.files = Array.from(this.files);
                    // Recreate the FormData after files are removed
                    let formData = new FormData(this.form);

                    // Append each remaining file to the form data
                    this.files.forEach((file) => {
                        formData.append('files[]', file);
                    });
                },
                updateFileInput(){
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
@endpush
