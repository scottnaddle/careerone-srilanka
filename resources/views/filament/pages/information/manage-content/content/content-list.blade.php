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
        </style>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

        <div
            class="tab-container card mb-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <x-filament::breadcrumbs :breadcrumbs="[
                '/admin/overview' => 'Admin',
                'javascript:void(0)' => 'Information',
                '#' => 'Content',
                '/admin/information/content/content-lists' => 'Content List',
                'javascript:void(1) ' => 'Document',
            ]" />
             <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                Content List
             </h1>

            <div class="tab-wrapper">
                <ul
                    class="flex flex-nowrap text-center text-gray-500 rounded-lg  dark:divide-gray-700 dark:text-gray-400 space-x-2 sm:space-x-4 p-4 sm:p-0">
                    <li class="flex-1 tab-active">
                        <a href="{{ url()->current() }}"
                            class="text-sm sm:text-lg inline-block w-full p-4 rounded-xl focus:ring-4 focus:ring-blue-300 focus:outline-none ">
                            {{ __('admin/dashboard.content.document') }}
                        </a>
                    </li>
                    <li class="flex-1 tab-switch">
                        <a href="{{ route('filament.admin.resources.information.content.content-lists.index-video') }}"
                            class="text-sm sm:text-lg inline-block w-full p-4 rounded-xl focus:ring-4 focus:ring-blue-300 focus:outline-none  dark:primary "
                            aria-current="page">
                            {{ __('admin/dashboard.content.video') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab_reel">
                <div class="tab_panel_document">
                    <div id="content-request" class="content-page active">
                        <div>
                            {{ $this->table }}
                        </div>
                    </div>

                </div>
            </div>
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
</script>
</x-filament-panels::page>
