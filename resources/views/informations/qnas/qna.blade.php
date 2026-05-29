@extends('homepage.layouts.master')
@section('title', 'Q&A')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}" type="text/css" />

    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray;
        }

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

        .title-column {
            width: 1%;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('system.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.information.root'), 'url' => '#'],
            ['label' => trans('system.menu.information.qna'), 'url' => ''],
        ]" />
    </div>
    <div class="flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-7 mb-10">
        <div class="flex gap-4 justify-center items-center">
            <form action="{{ route('informations.qnas.list') }}" method="GET"
                class="mx-auto flex gap-4 justify-center items-center w-full">
                {{-- @csrf --}}
                {{-- <div>
                    <button type="button" data-dropdown-toggle="event-type"
                        class="inline-flex text-lg items-center font-medium justify-center px-4 py-2 text-[#706F81] rounded-lg cursor-pointer bg-[#F8F8F8] ">
                        All <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-[#1E1E1E]"
                        id="event-type">
                        <ul class="py-2.5 font-medium" role="none">
                            <li>
                                <span
                                    data-value="type"
                                    class="dropdown-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">
                                        Type
                                </span>
                            </li>
                            <li>
                                <span
                                    data-value="status"
                                    class="dropdown-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">
                                        Status
                                </span>
                            </li>
                            <li>
                                <span
                                    data-value="title"
                                    class="dropdown-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">
                                        Title
                                </span>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="default-search" name="title" value="{{ request('title') }}" placeholder="{{ __('general.Title') }}"
                        class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                {{-- <input type="hidden" id="dropdown-value" name="searchType"> --}}

                <div>
                    <button type="submit"
                        class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 text-base focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                     px-15 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('system.form.button.search') }}
                    </button>
                </div>
            </form>

        </div>

        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-6">

                <div class="flex justify-between items-center">
                    @if (request()->has('title') && request()->query('title') != '')
                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $qnas->total() }} Results</p>
                    @else
                        <p></p>
                    @endif

                    <select id="qna_type"
                        class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="recently" {{ request()->input('qna_type') == 'recently' ? 'selected' : '' }}>
                            {{ trans('system.filter.recently') }}</option>
                        <option value="oldest" @selected(request()->input('qna_type') == 'oldest')>{{ trans('system.filter.oldest') }}</option>
                    </select>
                </div>
            </div>
            @if (session()->has('success'))
                <div
                    class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
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
            <!-- Modal toggle -->
            @if (Auth::guard(activeGuard())->check())
                <button id="open-modal-button" data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="inline-flex w-fit items-center text-xs leading-4 justify-center font-medium px-4 py-2.5 text-white rounded-full cursor-pointer bg-primary"
                    type="button">
                    {{ trans('system.information.qna.new_question') }} <svg class="w-4 h-4 text-white dark:text-white ms-2"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                </button>
            @endif

            <!-- Main modal -->
            <div id="default-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed transform z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative py-4 px-5 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <form class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] border border-gray-700"
                        method="POST" enctype="multipart/form-data" id="form-create"
                        action="{{ route('informations.qnas.create') }}">
                        @csrf
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between px-4 pt-4 pb-2 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ trans('system.information.qna.form.form_title') }}
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="flex flex-col">
                                <label for="title"
                                    class="font-medium text-[#706F81] block dark:text-gray-300 mb-2 dark:text-white">
                                    {{ trans('system.information.qna.form.title') }} <span
                                        class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    oninput="trimSpaces(this)"
                                    class="w-full p-3 pl-4 h-9 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">

                            </div>
                            <div class="flex flex-col">
                                <label for="description"
                                    class="font-medium text-[#706F81] block dark:text-gray-300 mb-2 dark:text-white">
                                    {{ trans('system.information.qna.form.content') }} <span
                                        class="text-red-600 p-1 text-center">*</span></label>
                                <textarea id="description" oninput="trimSpaces(this)" name="description" rows="4"
                                    class="block p-3 pl-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>


                            </div>
                            <div class="bg-white w-full">
                                <div x-data="dataFileDnD()"
                                    class="relative flex flex-col text-gray-400 border border-gray-200 rounded-lg dark:border-none">
                                    <div x-ref="dnd" class="relative flex flex-col text-gray-400 cursor-pointer">
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
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-base text-[#464559] dark:text-white">
                                                {!! trans('system.information.event.form.choose_file') !!}</p>
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
                                <p class="text-xs flex justify-end mt-2 w-full dark:text-white">
                                    {{trans('system.information.qna.form.hint_file')}}
                                </p>
                            </div>


                        </div>
                        <div
                            class="flex gap-3 items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="button" data-modal-hide="default-modal"
                                class="w-full text-center text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
            text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{ trans('system.form.button.cancel') }}
                            </button>
                            <button type="submit" id="submit-all"
                                class="w-full text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('system.form.button.save') }}
                            </button>
                        </div>
                        <!-- Modal footer -->

                    </form>
                </div>

            </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.no') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base  whitespace-nowrap">
                                    {{ trans('system.table.heading.title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.owner') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.registration_date') }}
                                </th>
                                @if (Auth::guard(activeGuard())->check())
                                    <th scope="col"
                                        class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                        {{ trans('system.table.heading.action') }}
                                    </th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($qnas as $index => $item)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center  hover:bg-blue-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $qnas->firstItem() + $index }}
                                    </td>
                                    <td
                                        class="px-4 py-6 text-sm text-[#201F36] dark:text-white text-left whitespace-nowrap">
                                        <a href="{{ route('informations.qnas.reply', ['slug' => $item->slug]) }}"
                                            class="dark:text-white font-semibold text-left hover:text-primary dark:hover:text-primary">
                                            {!! Str::limit($item->title, 50, '...') !!}
                                            {{ $item->numberOfReplies ? '(' . $item->numberOfReplies . ')' : '(0)' }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white
                                    {{ $item->system == activeGuard() && optional($item->author)->id == optional(Auth::guard(activeGuard())->user())->id ? 'font-bold' : '' }} whitespace-nowrap">
                                    @if (!empty($item->author))
                                        {{ $item->author->fullName }}
                                    @else
                                        Admin
                                    @endif
                                </td>

                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white  whitespace-nowrap">
                                        {{ $item->created_at->format('Y-m-d') }}
                                    </td>
                                    @if (Auth::guard(activeGuard())->check())
                                        <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white  whitespace-nowrap">
                                            <div class="flex gap-3 justify-center">
                                                {{-- <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                                class="block text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                type="button">
                                                Toggle modal
                                            </button> --}}

                                                <a href="{{ route('informations.qnas.reply', ['slug' => $item->slug]) }}"
                                                    class="inline-flex w-fit items-center text-sm leading-4 justify-center font-medium px-6 py-2 text-white rounded-full cursor-pointer bg-primary">
                                                    {{ trans('system.information.qna.reply') }}
                                                </a>


                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                            <p class="dark:text-white">No record!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                    <div class="mt-3">
                        {{ $qnas->onEachSide(1)->links() }}
                    </div>
                </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('js/datepicker.min.js') }}" type="module"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js" type="module"></script> --}}
    <script src="{{ asset('js/ckeditor.js') }}" type="module"></script>
    {{-- <script src="{{ asset('js/dropzone.min.js') }}" type="module"></script> --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
    <script>
        function trimSpaces(input) {
            input.value = input.value.replace(/^\s+/, '');
        }
    </script>

    <script>
        let url = new URL(window.location.href);
        $('#qna_type').on('change', function() {
            if (url.searchParams.has('qna_type')) {
                url.searchParams.set('qna_type', this.value);
            } else {
                url.searchParams.append('qna_type', this.value);
            }


            window.location.href = url.href;
        });
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

        // Utility function to create a FileList from an array of files
        // function createFileList(files) {
        //     const dataTransfer = new DataTransfer();
        //     files.forEach(file => dataTransfer.items.add(file));
        //     return dataTransfer.files;
        // }
    </script>
@endpush
