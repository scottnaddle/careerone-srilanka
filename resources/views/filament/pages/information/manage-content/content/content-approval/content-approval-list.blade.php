<x-filament-panels::page>
<div>
    <div class="flex flex-col gap-9 mt-6">
        <style>
            #search-time {
                background-color: #F9FBFF;
                color: #4984F6;
                border: none;
                width: 7rem;
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

            .custom-width-image {
                width: 4rem;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

        <div
            class="tab-container card mb-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <x-filament::breadcrumbs :breadcrumbs="[
                '/admin/overview' => 'Admin',
                'javascript:void(0)' => 'Information',
                '#' => 'Content',
                '/admin/information/content/content-appoval-lists' => 'Content List',
                'javascript:void(1) ' => 'Document',
            ]" />
                        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                           Content Approval List
                         </h1>
            <div class="tab-wrapper">
                <ul class="flex flex-nowrap text-center text-gray-500 rounded-lg  dark:divide-gray-700 dark:text-gray-400 space-x-2 sm:space-x-4 p-4 sm:p-0">
                    <li class="flex-1 tab-active">
                        <a href="{{ route('filament.admin.resources.information.content.content-appoval-lists.index') }}"
                           class="text-sm sm:text-lg inline-block w-full p-4 rounded-xl focus:ring-4 focus:ring-blue-300 focus:outline-none ">
                           {{ __('admin/dashboard.content.document') }}
                        </a>
                    </li>
                    <li class="flex-1 tab-switch">
                        <a href="{{ route('filament.admin.resources.information.content.content-appoval-lists.index-video') }}"
                           class="text-sm sm:text-lg inline-block w-full p-4 rounded-xl focus:ring-4 focus:ring-blue-300 focus:outline-none  dark:primary " aria-current="page">
                           {{ __('admin/dashboard.content.video') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab_reel">
                <div class="tab_panel_document">
                    <div id="content-request" class="content-page active">

                        <div class="flex items-center justify-between mt-4 mb-4">
                            <div class="flex gap-2">
                                <button id="recent-button" wire:click="openModalContentUploading"
                                    style="background-color: #3B82F6; color:#ffffff"
                                    class="flex items-center rounded-xl border block p-2.5 bg-[#3B82F6] hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    {{ __('admin/content.admin_content_list.content_uploadind') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            {{ $this->table }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if ($showModal)
        <form wire:submit.prevent="submitForm">
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

                    <!-- Content Name -->
                    <div>
                        <label for="content_name" class="block mb-2 text-sm font-medium text-gray-700">
                            {{ __('admin/content.admin_content_list.content_name') }}
                            <span class="text-red-600">*</span> <!-- Red asterisk -->
                        </label>
                        <input type="text" id="content_name" wire:model.defer="content_name"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            placeholder="{{ __('admin/content.admin_content_list.content_name_placeholder') }}"
                            required />
                    </div>

                    <!-- Additional Comments -->
                    <div class="mt-4">
                        <label for="placehoder_content" class="block mb-2 text-sm font-medium text-gray-700">
                            {{ __('admin/content.admin_content_list.content_introduction') }}
                            <span class="text-red-600">*</span> <!-- Red asterisk -->
                        </label>
                        <textarea id="placehoder_content" wire:model.defer="contentIntroduction" required
                            placeholder="{{ __('admin/content.admin_content_list.comments_placeholder') }}"
                            class="w-full h-32 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <!-- Library Tab Content -->
                    <div class="p-4 rounded-b">
                        <div id="library-tab" class="tab-content">

                            <div class="flex overflow-x-hidden max-h-96">
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 w-full max-w-lg mx-auto">


                                    <!-- Display uploaded image (added to the library immediately after uploading) -->
                                    @if ($uploadedImage && $uploadedImage->temporaryUrl())
                                        <div
                                            class="relative group cursor-pointer custom-width-image {{ $selectedImage && $selectedImage['filename'] === $uploadedImage->getClientOriginalName() ? 'border-4 border-blue-500' : '' }}">
                                            <img src="{{ $uploadedImage->temporaryUrl() }}" alt="Uploaded Image"
                                                class="w-full h-40 object-cover rounded-lg transition-transform duration-300 transform group-hover:scale-105">

                                            <p
                                                class="mt-2 text-center text-sm text-gray-700 truncate w-full max-w-full">
                                                {{ $uploadedImage->getClientOriginalName() }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mt-6">
                        <label for="uploadFile1"
                            class="flex bg-blue-600 hover:bg-gray-700 text-white text-base px-5 py-3 outline-none rounded w-max cursor-pointer mx-auto rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 mr-2 fill-white inline text-white"
                                viewBox="0 0 32 32">
                                <path
                                    d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                    data-original="#000000" />
                                <path
                                    d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                    data-original="#000000" />
                            </svg>
                            Upload
                            <svg wire:loading wire:target="uploadedImage" class="animate-spin h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 000 8v4a8 8 0 01-8-8z"></path>
                            </svg>
                            <input type="file" id="uploadFile1" wire:loading.attr="disabled"
                                wire:target="uploadedImage" wire:model="uploadedImage" accept="image/*"
                                class="hidden" />
                        </label>
                        @error('uploadedImage')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Footer with Cancel and Confirm buttons -->
                    <div class="mt-6 flex space-x-4">
                        <button type="button" wire:click="closeModal"
                            class="bg-white text-gray-700 border px-5 py-2 rounded-xl w-full hover:bg-gray-400 text-center text-sm font-semibold">
                            {{ __('admin/content.admin_content_list.cancel') }}
                        </button>
                        <button type="submit"
                            class="bg-blue-600 px-5 py-2 rounded-xl w-full hover:bg-blue-700 text-center text-white text-sm font-semibold">
                            {{ __('admin/content.admin_content_list.confirm') }}
                            <svg wire:loading wire:target="uploadedImage" class="animate-spin h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 000 8v4a8 8 0 01-8-8z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif



</div>

<script></script>
</x-filament-panels::page>
