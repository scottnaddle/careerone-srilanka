<x-filament-panels::page>
<div>
    <div class="flex flex-col gap-9 mt-6">
        <style>
            #search-time {
                background-color: #F9FBFF;
                color: #4984F6;
                border: none;
            }

            #show-video-modal {
                display: none;
                background-color: rgba(0, 0, 0, 0.5);
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            #show-video-modal.active {
                display: flex;
            }

            .truncate-2-lines {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }


            .tab-container {
                display: flex;
                padding: 20px 16px 48px 16px;
                flex-direction: column;
                gap: 24px;
                border-radius: 8px;
                background: #FFF;
                overflow: hidden;
            }

            /* css for tab switcher */



            .tab-active {
                content: "";
                width: 50%;
                top: 0;
                transition: left cubic-bezier(0.18, 1.14, 0.5, 1.18) 0.5s;
                border-radius: 10px;
                box-shadow: 0 2px 15px 0 rgba(0, 0, 0, .1);
                background-color: #4984F6;
                height: 100%;
                z-index: 0;
            }

            .tab-active a {
                color: #ffffff;
                font-weight: 700;
                font-size: 20px;
            }

            .tab-switch {
                content: "";
                width: 50%;
                top: 0;
                transition: left cubic-bezier(0.18, 1.14, 0.5, 1.18) 0.5s;
                border-radius: 10px;
                box-shadow: 0 2px 15px 0 rgba(0, 0, 0, .1);
                background-color: #F5F7FA;
                height: 100%;
                z-index: 0;
            }

            .tab-switch a {
                color: #91919A;
                font-weight: 400;
                font-size: 20px;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        @php
            $contentVideoData = $this->getContentVideo();
            $results = $contentVideoData['results'];
            $count = $contentVideoData['count'];
        @endphp
        <div
            class="tab-container card mb-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <x-filament::breadcrumbs :breadcrumbs="[
                '/admin/overview' => 'Admin',
                'javascript:void(0)' => 'Information',
                '#' => 'Content',
                '/admin/information/content/content-lists' => 'Content List',
                'javascript:void(1) ' => 'Video',
            ]" />
             <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                Video List
             </h1>
            <div class="tab-wrapper">
                <ul class="flex flex-nowrap text-center text-gray-500 rounded-lg  dark:divide-gray-700 dark:text-gray-400 space-x-2 sm:space-x-4 p-4 sm:p-0">
                    <li class="flex-1 tab-switch">
                        <a href="{{ route('filament.admin.resources.information.content.content-lists.index') }}"
                           class="text-sm sm:text-lg inline-block w-full p-4 rounded-xl focus:ring-4 focus:ring-blue-300 focus:outline-none ">
                           {{ __('admin/dashboard.content.document') }}
                        </a>
                    </li>
                    <li class="flex-1  tab-active">
                        <a href="{{ route('filament.admin.resources.information.content.content-lists.index-video') }}"
                           class="text-sm sm:text-lg inline-block w-full p-4 rounded-xl focus:ring-4 focus:ring-blue-300 focus:outline-none  dark:primary " aria-current="page">
                           {{ __('admin/dashboard.content.video') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab_reel">
                <div class="tab_panel_video">
                    <form method="get"action="{{ route('filament.admin.resources.information.content.content-lists.index-video') }}">
                        <div class="flex gap-4">
                            <input type="text" name="search"
                                class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium"
                                value="{{ request()->query('search') }}" placeholder=" {{ __('admin/dashboard.content.search') }}">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-full button-search"> {{ __('admin/dashboard.content.search') }}</button>
                        </div>

                        <div class="flex items-center justify-between mt-4 mb-4">
                            <label for="search-time"
                                class="text-lg font-semibold text-[#706F81]">
                                @if (request()->query())
                                {{$count}} {{ __('admin/dashboard.content.search') }}
                                @endif

                            </label>
                            <select id="search-time" name="search-time" class="font-semibold border text-base rounded-xl block">
                                <option @selected(request()->query('search-time')=='all') value="all">{{ __('admin/content.admin_content_list.recently') }}</option>
                                <option @selected(request()->query('search-time')=='old') value="old">{{ __('admin/content.admin_content_list.oldset') }}</option>
                            </select>
                        </div>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 justify-center">
                        @foreach ($results as $item)
                            <div class="relative flex flex-col gap-4 pb-2 dark:border dark:border-white rounded-xl justify-center w-full shadow">

                                <div
                                    class="absolute top-1 left-1 bg-gray-700 bg-opacity-75 text-white text-xs font-bold px-2 py-1 rounded-t-md z-10">
                                    {{ $item->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value
                                     ?  __('admin/dashboard.content.reject') :($item->status == \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value
                                     ? __('admin/dashboard.content.request') : __('admin/dashboard.content.approval') )}}
                                </div>
                                @php
                                    preg_match(
                                        '/(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|.*[?&]v=))([^&?]+)/',
                                        $item->video_url,
                                        $matches,
                                    );
                                    $videoId = $matches[1] ?? null;
                                    $thumbnailUrl = $videoId
                                        ? "https://img.youtube.com/vi/$videoId/hqdefault.jpg"
                                        : asset('default_image.jpg');
                                @endphp
{{--                                <a--}}
{{--                                    href="{{ route('filament.admin.resources.information.content.content-lists.view', $item->id) }}">--}}
{{--                                    <button type="button" data-modal-target="show-video-modal"--}}
{{--                                        data-modal-toggle="show-video-modal" data-title="{{ $item->title }}"--}}
{{--                                        data-intro="{{ $item->intro }}" data-source="{{ $videoId }}"--}}
{{--                                        data-slug="{{ $item->slug }}" class="open-video">--}}

{{--                                        <img src="{{ $thumbnailUrl }}" alt="{{ $item->title }}" class="rounded-xl">--}}
{{--                                    </button>--}}
{{--                                </a>--}}
                                <iframe src="{{getYoutubeEmbedUrl($item->video_url)}}" class="w-full h-64 rounded-t-xl" allowfullscreen frameborder="0"></iframe>

                                <div class="flex flex-col gap-2 px-4">
                                    <a
                                        href="{{ route('filament.admin.resources.information.content.content-lists.view', $item->id) }}">
                                    <p class="text-[#201F36] dark:text-white font-semibold text-lg truncate-2-lines">
                                        {{ $item->title }}</p></a>
                                    <p class="flex gap-4 text-[#464559] dark:text-white text-sm justify-between">
                                        <span>{{ $item->created_at }}</span> <span>{{$item->getAuthor($item->system, $item->created_by)->fullName}}</span>
                                    </p>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    @if ($count>0)
                         <div class="flex justify-end mt-4">
                        <div class="flex space-x-2">
                            {{ $results->links('vendor.pagination.custom-pagination-admin') }}
                        </div>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl max-w-lg w-full mx-4 md:mx-8 relative">
                <!-- Header with Title on Left and Close Button on Right -->
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-lg font-semibold">
                        {{ __('admin/content.admin_content_list.video_content') }}
                    </h2>
                    <button type="button" wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                        &times;
                    </button>
                </div>

                <!-- Form Fields -->
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="content_name"
                            class="block mb-2 text-sm font-medium text-gray-700">{{ __('admin/content.admin_content_list.content_name') }}</label>
                        <input type="text" id="content_name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            placeholder="{{ __('admin/content.admin_content_list.content_name_placeholder') }}"
                            required />
                    </div>
                    <div>
                        <label for="countries"
                            class="block mb-2 text-sm font-medium text-gray-700">{{ __('admin/content.admin_content_list.last_name') }}</label>
                        <select id="countries"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            <option selected>Choose a country</option>
                        </select>
                    </div>
                </div>

                <!-- Content Introduction -->
                <div class="mt-4">
                    <label for="placeholder_content"
                        class="block mb-2 text-sm font-medium text-gray-700">{{ __('admin/content.admin_content_list.content_introduction') }}</label>
                    <textarea wire:model="additionalComments" id="placeholder_content"
                        placeholder="{{ __('admin/content.admin_content_list.comments_placeholder') }}"
                        class="w-full h-32 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>

                <!-- File Upload Section -->
                <div class="flex items-center justify-center w-full mt-6">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="dropzone-preview">
                            <svg class="w-10 h-10 mb-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500">
                                {{ __('admin/content.admin_content_list.choose_file') }}
                                <span
                                    class="font-semibold">{{ __('admin/content.admin_content_list.drag_file') }}</span>
                            </p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden"
                            onchange="handleFileUpload(event)" />
                    </label>
                </div>

                <p class="mt-2 text-sm text-gray-500 text-center">
                    {{ __('admin/content.admin_content_list.max_file_size') }}</p>
                <div id="file-name" class="text-sm text-gray-500 mt-2 flex items-center">
                    <!-- File name and delete button will appear here -->
                </div>

                <!-- File Information and Delete Button -->
                <div id="file-info" class="mt-4">
                    <p id="file-name" class="text-sm text-gray-500"></p>
                    <button id="delete-file-btn" onclick="removeFile()"
                        class="mt-2 px-4 py-2 bg-red-500 text-white rounded-lg hidden">
                        {{ __('admin/content.admin_content_list.remove_file') }}
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex space-x-4">
                    <button type="button" wire:click="closeModal"
                        class="bg-gray-300 text-gray-700 px-5 py-2 rounded-full w-full hover:bg-gray-400 text-center">
                        {{ __('admin/content.admin_content_list.cancel') }}
                    </button>
                    <button type="button" wire:click="approveItem"
                        class="bg-primary px-5 py-2 rounded-full w-full hover:bg-blue-700 text-center">
                        {{ __('admin/content.admin_content_list.confirm') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

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
</script>
</x-filament-panels::page>
