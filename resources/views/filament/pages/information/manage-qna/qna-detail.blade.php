<div>
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}" type="text/css" />
    <div id="loading-overlay"
        class=" hidden fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
        <h2 class="text-center text-white text-xl font-semibold">{{ __('main.loading_overlay_title') }}</h2>
        <p class="w-1/3 text-center text-white">{{ __('main.loading_overlay_description') }}</p>
    </div>
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

        .reply-child-container-style {
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
    <p class="text-3xl p-4 text-[#464559] font-semibold dark:text-white">{{ trans('system.information.qna.title') }}
        <p />
    <div class="flex flex-col gap-2 bg-white dark:bg-[#1E1E1E] rounded-xl p-4 mb-10">
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
        <div class="flex justify-between">
            <a href="{{ route('filament.admin.resources.information.q-as.index') }}"
                class="flex items-center gap-2 text-[#464559] text-xl font-bold w-fit dark:text-white break-all"><svg
                    width="24" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5 6L9.5 12L15.5 18" stroke="#354052" stroke-width="2" class="dark:stroke-white"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                {{ \Str::limit($qna->title, 100) }}
            </a>

            <!-- Dropdown for delete or edit QNA -->
            @if (
                Auth::guard('admin')->check() && 
                optional($qna->author)->id == optional(Auth::guard('admin')->user())->id && 
                $qna->system == 'admin'
            )
                <div class="relative inline-block">
                    <button title="Action" type="button" data-dropdown-toggle="action-dropdown-menu-edit"
                        class="block font-semibold px-2 py-1 md:px-4 md:py-2 text-primary cursor-pointer bg-white dark:bg-[#1E1E1E] dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                            fill="none">
                            <path
                                d="M12.5 15C14.1569 15 15.5 13.6569 15.5 12C15.5 10.3431 14.1569 9 12.5 9C10.8431 9 9.5 10.3431 9.5 12C9.5 13.6569 10.8431 15 12.5 15Z"
                                stroke="#C9CCD4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M19.2273 14.7273C19.1063 15.0015 19.0702 15.3056 19.1236 15.6005C19.1771 15.8954 19.3177 16.1676 19.5273 16.3818L19.5818 16.4364C19.7509 16.6052 19.885 16.8057 19.9765 17.0265C20.068 17.2472 20.1151 17.4838 20.1151 17.7227C20.1151 17.9617 20.068 18.1983 19.9765 18.419C19.885 18.6397 19.7509 18.8402 19.5818 19.0091C19.413 19.1781 19.2124 19.3122 18.9917 19.4037C18.771 19.4952 18.5344 19.5423 18.2955 19.5423C18.0565 19.5423 17.8199 19.4952 17.5992 19.4037C17.3785 19.3122 17.178 19.1781 17.0091 19.0091L16.9545 18.9545C16.7403 18.745 16.4682 18.6044 16.1733 18.5509C15.8784 18.4974 15.5742 18.5335 15.3 18.6545C15.0311 18.7698 14.8018 18.9611 14.6403 19.205C14.4788 19.4489 14.3921 19.7347 14.3909 20.0273V20.1818C14.3909 20.664 14.1994 21.1265 13.8584 21.4675C13.5174 21.8084 13.0549 22 12.5727 22C12.0905 22 11.6281 21.8084 11.2871 21.4675C10.9461 21.1265 10.7545 20.664 10.7545 20.1818V20.1C10.7475 19.7991 10.6501 19.5073 10.475 19.2625C10.2999 19.0176 10.0552 18.8312 9.77273 18.7273C9.49853 18.6063 9.19437 18.5702 8.89947 18.6236C8.60456 18.6771 8.33244 18.8177 8.11818 19.0273L8.06364 19.0818C7.89478 19.2509 7.69425 19.385 7.47353 19.4765C7.2528 19.568 7.01621 19.6151 6.77727 19.6151C6.53834 19.6151 6.30174 19.568 6.08102 19.4765C5.86029 19.385 5.65977 19.2509 5.49091 19.0818C5.32186 18.913 5.18775 18.7124 5.09626 18.4917C5.00476 18.271 4.95766 18.0344 4.95766 17.7955C4.95766 17.5565 5.00476 17.3199 5.09626 17.0992C5.18775 16.8785 5.32186 16.678 5.49091 16.5091L5.54545 16.4545C5.75503 16.2403 5.89562 15.9682 5.9491 15.6733C6.00257 15.3784 5.96647 15.0742 5.84545 14.8C5.73022 14.5311 5.53887 14.3018 5.29497 14.1403C5.05107 13.9788 4.76526 13.8921 4.47273 13.8909H4.31818C3.83597 13.8909 3.37351 13.6994 3.03253 13.3584C2.69156 13.0174 2.5 12.5549 2.5 12.0727C2.5 11.5905 2.69156 11.1281 3.03253 10.7871C3.37351 10.4461 3.83597 10.2545 4.31818 10.2545H4.4C4.7009 10.2475 4.99273 10.1501 5.23754 9.97501C5.48236 9.79991 5.66883 9.55521 5.77273 9.27273C5.89374 8.99853 5.92984 8.69437 5.87637 8.39947C5.8229 8.10456 5.68231 7.83244 5.47273 7.61818L5.41818 7.56364C5.24913 7.39478 5.11503 7.19425 5.02353 6.97353C4.93203 6.7528 4.88493 6.51621 4.88493 6.27727C4.88493 6.03834 4.93203 5.80174 5.02353 5.58102C5.11503 5.36029 5.24913 5.15977 5.41818 4.99091C5.58704 4.82186 5.78757 4.68775 6.00829 4.59626C6.22901 4.50476 6.46561 4.45766 6.70455 4.45766C6.94348 4.45766 7.18008 4.50476 7.4008 4.59626C7.62152 4.68775 7.82205 4.82186 7.99091 4.99091L8.04545 5.04545C8.25971 5.25503 8.53183 5.39562 8.82674 5.4491C9.12164 5.50257 9.4258 5.46647 9.7 5.34545H9.77273C10.0416 5.23022 10.2709 5.03887 10.4324 4.79497C10.594 4.55107 10.6807 4.26526 10.6818 3.97273V3.81818C10.6818 3.33597 10.8734 2.87351 11.2144 2.53253C11.5553 2.19156 12.0178 2 12.5 2C12.9822 2 13.4447 2.19156 13.7856 2.53253C14.1266 2.87351 14.3182 3.33597 14.3182 3.81818V3.9C14.3193 4.19253 14.406 4.47834 14.5676 4.72224C14.7291 4.96614 14.9584 5.15749 15.2273 5.27273C15.5015 5.39374 15.8056 5.42984 16.1005 5.37637C16.3954 5.3229 16.6676 5.18231 16.8818 4.97273L16.9364 4.91818C17.1052 4.74913 17.3057 4.61503 17.5265 4.52353C17.7472 4.43203 17.9838 4.38493 18.2227 4.38493C18.4617 4.38493 18.6983 4.43203 18.919 4.52353C19.1397 4.61503 19.3402 4.74913 19.5091 4.91818C19.6781 5.08704 19.8122 5.28757 19.9037 5.50829C19.9952 5.72901 20.0423 5.96561 20.0423 6.20455C20.0423 6.44348 19.9952 6.68008 19.9037 6.9008C19.8122 7.12152 19.6781 7.32205 19.5091 7.49091L19.4545 7.54545C19.245 7.75971 19.1044 8.03183 19.0509 8.32674C18.9974 8.62164 19.0335 8.9258 19.1545 9.2V9.27273C19.2698 9.54161 19.4611 9.77093 19.705 9.93245C19.9489 10.094 20.2347 10.1807 20.5273 10.1818H20.6818C21.164 10.1818 21.6265 10.3734 21.9675 10.7144C22.3084 11.0553 22.5 11.5178 22.5 12C22.5 12.4822 22.3084 12.9447 21.9675 13.2856C21.6265 13.6266 21.164 13.8182 20.6818 13.8182H20.6C20.3075 13.8193 20.0217 13.906 19.7778 14.0676C19.5339 14.2291 19.3425 14.4584 19.2273 14.7273Z"
                                stroke="#C9CCD4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </button>
                    <div class="w-fit z-50 hidden absolute my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl dark:bg-[#1E1E1E] border shadow-lg"
                        id="action-dropdown-menu-edit">
                        <ul class="font-medium" role="none">
                            <li>
                                <a href="{{ route('filament.admin.resources.information.q-as.edit', ['record' => $qna]) }}"
                                    class="w-full block px-6 py-2 text-sm text-gray-900 hover:bg-[#3B82F6] dark:text-gray-400 dark:hover:bg-[#383838] hover:rounded-t-xl {{ count($qna->replies) !== 0 ? 'hover:rounded-b-xl' : '' }} hover:text-white"
                                    role="menuitem"> {{ trans('system.form.button.edit') }}</a>

                            </li>
                            <li>
                                {{-- click to open delete qna modal  --}}
                                @if (count($qna->replies) === 0)
                                    <button id="open-delete-modal" type="button" data-modal-target="delete-qna-modal"
                                        data-modal-toggle="delete-qna-modal" data-id={{ $qna->id }}
                                        class="btn-delete-qna w-full block px-6 py-2 text-sm text-gray-900 hover:bg-[#3B82F6] hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white hover:rounded-b-xl"
                                        role="menuitem" onclick="closeDropdown()">
                                        <div class="inline-flex items-center">
                                            {{ trans('system.form.button.delete') }}
                                        </div>
                                    </button>
                                @endif


                            </li>

                        </ul>
                    </div>
                </div>
            @endif

        </div>

        {{-- Delete qna modal --}}
        <div id="delete-qna-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur"></div>
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between pb-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                            {{ trans('system.delete_modal.title') }}
                        </h3>
                        <button type="button"
                            class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="delete-qna-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                            {{ trans('system.delete_modal.content') }}</h3>
                        <div class="flex justify-center gap-4">
                            <a href=""
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                {{ trans('system.delete_modal.yes') }}
                            </a>
                            <button data-modal-hide="delete-qna-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{ trans('system.delete_modal.no') }}</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        {{-- Main content  --}}
        <div class="border rounded-lg px-3 py-4 flex flex-col gap-4 break-all">
            <p class="text-primary text-2xl font-semibold dark:text-white">{{ $qna->title }}</p>
            <div class="flex gap-10">
                <p class="text-xs font-semibold text-primary flex gap-1 justify-center items-center dark:text-white">
                    <span><svg width="16" height="16" viewBox="0 0 17 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.5 6.66634H2.5M11.1667 1.33301 V3.99967M5.83333 1.33301V3.99967M5.7 14.6663H11.3C12.4201 14.6663 12.9802 14.6663 13.408 14.4484C13.7843 14.2566 14.0903 13.9506 14.282 13.5743C14.5 13.1465 14.5 12.5864 14.5 11.4663V5.86634C14.5 4.74624 14.5 4.18618 14.282 3.75836C14.0903 3.38204 13.7843 3.07607 13.408 2.88433C12.9802 2.66634 12.4201 2.66634 11.3 2.66634H5.7C4.5799 2.66634 4.01984 2.66634 3.59202 2.88433C3.21569 3.07607 2.90973 3.38204 2.71799 3.75836C2.5 4.18618 2.5 4.74624 2.5 5.86634V11.4663C2.5 12.5864 2.5 13.1465 2.71799 13.5743C2.90973 13.9506 3.21569 14.2566 3.59202 14.4484C4.01984 14.6663 4.5799 14.6663 5.7 14.6663Z"
                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                stroke-linejoin="round" />
                        </svg>
                    </span>{{ $qna->created_at }}
                </p>

                <p class="text-xs font-semibold text-primary flex gap-2 justify-center items-center  dark:text-white">
                        <svg width="16" height="16" viewBox="0 0 15 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.4987 9.33333H4.4987C3.56832 9.33333 3.10313 9.33333 2.7246 9.44816C1.87233 9.70669 1.20539 10.3736 0.946858 11.2259C0.832031 11.6044 0.832031 12.0696 0.832031 13M9.16536 4C9.16536 5.65685 7.82222 7 6.16536 7C4.50851 7 3.16536 5.65685 3.16536 4C3.16536 2.34315 4.50851 1 6.16536 1C7.82222 1 9.16536 2.34315 9.16536 4ZM6.83203 13L8.8996 12.4093C8.99861 12.381 9.04812 12.3668 9.09429 12.3456C9.13529 12.3268 9.17427 12.3039 9.21064 12.2772C9.25159 12.2471 9.288 12.2107 9.36081 12.1379L13.6654 7.83336C14.1256 7.37311 14.1256 6.62689 13.6654 6.16665C13.2051 5.70642 12.4589 5.70642 11.9987 6.16666L7.69414 10.4712C7.62133 10.544 7.58492 10.5804 7.55486 10.6214C7.52816 10.6578 7.50522 10.6967 7.4864 10.7377C7.4652 10.7839 7.45105 10.8334 7.42276 10.9324L6.83203 13Z"
                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                stroke-linejoin="round" />
                        </svg>
                        <span>{{ optional($qna->author)->fullName ?? '' }}</span>
                </p>
            </div>

            <p class="dark:text-white">{{ $qna->description }}</p>
            @if ($qna->attachments->count() > 0)
                <div class="px-4 py-2 w-full sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                            @foreach ($qna->attachments as $item)
                                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <span
                                                class="truncate font-medium dark:text-white">{{ $item->file_name }}</span>
                                            <span class="flex-shrink-0 text-gray-400">{{ $item->file_size }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="{{ route('informations.qnas.download', ['id' => $item->id]) }}"
                                            class="font-medium text-primary hover:text-blue-600">{{ trans('system.information.qna.download') }}</a>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </dd>
                </div>
            @endif

        </div>


        {{-- Reply block  --}}
        <div class="reply mt-3 flex-col gap-9">
            <div class="reply-container reply-container-append">
                @foreach ($qna->replies as $item)
                    <div class="flex gap-3 flex-col reply-remove-{{ $item->id }}">
                        <div class="reply-item-container">
                            <div class="reply-item">
                                @if (isset($item->author->profile_image))
                                    <img class="w-12 h-12 rounded-full object-fit"
                                        src="{{ asset($item->author->profile_image) }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                @endif
                                <div class="flex flex-col w-full pr-2 pl-2">
                                    <div class="flex justify-between font-semibold text-base items-center">
                                        <p class="dark:text-white">{{ $item->author->fullName }}</p>
                                        @if (Auth::guard('admin')->check() && $item->answer_by == Auth::guard('admin')->user()->id && $item->system == 'admin')
                                            <div class="relative inline-block">
                                                <button type="button"
                                                    data-dropdown-toggle="action-dropdown-menu-{{ $item->id }}"
                                                    class="inline-block font-semibold justify-center text-primary cursor-pointer bg-white dark:bg-[#1E1E1E] dark:text-white">
                                                    <div>
                                                        <p
                                                            class="text-xl tracking-wider font-semibold text-gray-700 dark:text-white heading-6">
                                                            ...</p>
                                                    </div>
                                                </button>
                                                <div class="dropdown-menu w-fit z-50 hidden absolute my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl dark:bg-[#1E1E1E] border shadow-lg"
                                                    id="action-dropdown-menu-{{ $item->id }}">
                                                    <ul class="font-medium" role="none">
                                                        <li>
                                                            <form class="delete-reply-form"
                                                                data-id="{{ $item->id }}"
                                                                data-element=".reply-remove-{{ $item->id }}"
                                                                action="{{ route('admin.qnas.delete-reply', ['qNAAnswer' => $item]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="w-full block px-6 py-2 text-sm text-gray-900 hover:bg-[#3B82F6] dark:text-gray-400 dark:hover:bg-[#383838] hover:rounded-xl hover:text-white"
                                                                    role="menuitem"
                                                                    onclick="closeDropdownDeleteReply({{ $item->id }})">
                                                                    <div class="inline-flex items-center">
                                                                        {{ trans('system.form.button.delete') }}
                                                                    </div>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mr-3">
                                        <p id="article-answer-{{ $item->id }}"
                                            class="text-sm text-gray-700 dark:text-white"
                                            style="word-break: break-word; overflow-wrap: break-word;">
                                            {{ \Illuminate\Support\Str::limit($item->answer, 150) }}
                                        </p>
                                        @if (strlen($item->answer) > 150)
                                            <button class="btn btn-primary btn-readmore text-sm text-primary underline"
                                                data-id="{{ $item->id }}"
                                                data-answer="{{ $item->answer }}">{{ trans('system.information.qna.read_more') }}</button>
                                        @endif
                                        <button
                                            class="btn btn-primary btn-showless hidden text-sm text-primary underline "
                                            data-id="{{ $item->id }}"
                                            data-summary="{{ \Illuminate\Support\Str::limit($item->answer, 150) }}"
                                            data-answer="{{ $item->answer }}">{{ trans('system.information.qna.show_less') }}</button>
                                    </div>

                                </div>

                            </div>

                            <div class="flex justify-between px-5">
                                <p class="text-xs text-[#91919A] mt-3">{{ $item->created_at }}</p>
                            </div>
                        </div>
                        <div class=" reply-child-container-style" id="reply-child-container-{{ $item->id }}">
                            @foreach ($item->children as $reply)
                                <div class="reply-item reply-item-{{ $reply->id }}">
                                    @if (isset($reply->author->profile_image))
                                        <img class="w-8 h-8 me-2 rounded-full object-cover"
                                            src="{{ asset($reply->author->profile_image) }}">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    @endif

                                    <div class="w-full flex flex-col pr-2">
                                        <div class="flex justify-between font-semibold text-base dark:text-white">
                                            @if ($reply->author)
                                                <p class="dark:text-white">
                                                    {{ \Str::limit($reply->author->fullName) }}
                                                </p>
                                            @else
                                                Admin
                                            @endif
                                        </div>
                                        {{-- <p class="font-medium text-[#706F81] text-base">{{ $reply->answer }}</p> --}}
                                        <div class="">
                                            <p id="article-answer-{{ $reply->id }}"
                                                class="text-sm text-gray-700 dark:text-white"
                                                style="word-break: break-word; overflow-wrap: break-word;">
                                                {{ \Illuminate\Support\Str::limit($reply->answer, 150) }}
                                            </p>
                                            @if (strlen($reply->answer) > 150)
                                                <button
                                                    class="btn btn-primary btn-readmore text-sm text-primary underline"
                                                    data-id="{{ $reply->id }}"
                                                    data-answer="{{ $reply->answer }}">{{ trans('system.information.qna.read_more') }}</button>
                                            @endif
                                            <button
                                                class="btn btn-primary btn-showless hidden text-sm text-primary underline"
                                                data-id="{{ $reply->id }}"
                                                data-summary="{{ \Illuminate\Support\Str::limit($reply->answer, 150) }}"
                                                data-answer="{{ $reply->answer }}">{{ trans('system.information.qna.show_less') }}</button>
                                        </div>


                                        <p class=" text-xs text-[#91919A] mt-3">{{ $reply->created_at }}
                                        </p>
                                    </div>

                                </div>
                            @endforeach
                            @if (Auth::guard('admin')->check())
                                <form id="qnaFormParent" class="flex flex-col gap-2">
                                    @csrf
                                    <input type="text" value="{{ $qna->id }}" name="qna_id" hidden>
                                    <input type="text" value="{{ $item->id }}" name="parent_id" hidden>
                                    <input type="text" value="admin" name="system" hidden>
                                    <div class="relative reply-content-child-container">
                                        @if (isset(Auth::guard('admin')->user()->profile_image))
                                            <img class="w-8 h-8 rounded-full object-cover"
                                                src="{{ asset(Auth::guard('admin')->user()->profile_image) }}">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        @endif
                                        <input type="text" name="answer"
                                            class="w-full p-2 border border-gray-300 rounded-lg dark:bg-[#1E1E1E]"
                                            placeholder="Write Reply..." required>
                                            <button type="submit" class="absolute bottom-0 right-0 me-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path class="stroke-primary" stroke-linecap="round" stroke-linejoin="round"
                                                          d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                                </svg>
                                            </button>
{{--                                        <button type="submit"--}}
{{--                                            class="px-3 py-2 bg-primary text-gray-700 dark:text-white rounded-lg text-white">Send</button>--}}
                                    </div>

                                </form>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="w-full mt-3" >
            <div class="reply-new">
                @if (Auth::guard('admin')->check())
                    <form method="POST" action="{{ route('informations.qnas.qnaanswer.create') }}"
                        class="flex items-start gap-3 mt-3" id="qnaForm">
                        @csrf
                        <input type="text" value="{{ $qna->id }}" name="qna_id" hidden>
                        <input type="hidden" name="system" value="admin">

                        @if (isset(Auth::guard('admin')->user()->profile_image))
                            <img class="w-12 h-12 rounded-full object-cover"
                                src="{{ asset(Auth::guard('admin')->user()->profile_image) }}">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        @endif

                        <div class="relative w-full h-16">
                            <span
                                class="absolute font-semibold z-10 p-2 dark:text-white">{{ \Str::limit(Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name, 20) }}</span>
                            <input type="text" name="answer"
                                class="pr-8 absolute align-bottom text-base placeholder-[#C9CCD4] text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 pt-9 pb-1 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="{{__('system.write_something')}}..." required />
                            <button type="submit" class="absolute bottom-0 right-0 me-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path class="stroke-primary" stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                            </button>

                        </div>

                    </form>
                @endif
            </div>
        </div>


    </div>


</div>

<script src="{{ asset('js/jquery.js') }}"></script>

<script>
    $(document).on('click', '.btn-readmore', function() {
        let answer = $(this).data('answer');
        let id = $(this).data('id');
        $("#article-answer-" + id).html(answer);
        $(this).addClass('hidden');
        $('.btn-showless[data-id="' + id + '"]').removeClass('hidden');
    });

    $(document).on('click', '.btn-showless', function() {
        let id = $(this).data('id');
        let summary = $(this).data('summary');
        $("#article-answer-" + id).html(summary + '...');
        $(this).addClass('hidden');
        $('.btn-readmore[data-id="' + id + '"]').removeClass('hidden');
    });

    $(document).on('click', '.dropdown-toggle', function() {
        let dropdownId = $(this).data('dropdown-target');
        let dropdownMenu = $('#' + dropdownId);

        $('.dropdown-menu').not(dropdownMenu).addClass('hidden');

        dropdownMenu.toggleClass('hidden');
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.dropdown-toggle, .dropdown-menu').length) {
            $('.dropdown-menu').addClass('hidden');
        }
    });


    function closeDropdown() {
        document.getElementById('action-dropdown-menu-edit').classList.add('hidden');
    }

    function closeDropdownDeleteReply(id) {
        document.getElementById('action-dropdown-menu-' + id).classList.add('hidden');
    }

    $(".btn-delete-qna").click(function() {
        $("#delete-qna-modal a").attr('href', '');
        $("#delete-qna-modal a").attr('href', '/admin/qnas/delete-qna/' + $(this).data(
            'id'));
    });
</script>
<script>
    function trimSpaces(input) {
        input.value = input.value.replace(/^\s+/, '');
    }

    function toggleLoadingOverlay() {
        const loadingOverlay = document.getElementById('loading-overlay');
        if (loadingOverlay.classList.contains('hidden')) {
            loadingOverlay.classList.remove('hidden');
        } else {
            loadingOverlay.classList.add('hidden');
        }
    }
</script>

<script>
    $(document).on("submit", "#qnaForm", function(event) {
        event.preventDefault();
        let form = this;
        submitForm(form);
    });

    $(document).on("submit", "#qnaFormParent", function(event) {
        event.preventDefault();
        let form = this;
        submitForm(form);
    });



    function submitForm(form) {
        if (typeof toggleLoadingOverlay === 'function') {
            toggleLoadingOverlay();
        } else {
            console.error('toggleLoadingOverlay is not defined');
        }
        let formData = new FormData(form);

        $.ajax({
            url: '{{ route('informations.qnas.qnaanswer.create', ['qNA' => $qna]) }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    $(form).remove();
                    if (response.data.parent_id) {
                        appendChildReply(response.data);
                        addNewChildrenForm(response.data);
                    } else {
                        appendReply(response.data);
                        addNewForm(response.data.qna_id);
                    }
                } else {
                    console.error('Error:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            },
            complete: function(response) {
                if (typeof toggleLoadingOverlay === 'function') {
                    toggleLoadingOverlay();
                }
            }

        });
    }

    function addNewForm(qnaId) {
        let newForm = `
            @if (Auth::guard('admin')->check())
                <form method="POST" action="{{ route('informations.qnas.qnaanswer.create') }}"
                    class="flex items-start gap-3 mt-3" id="qnaForm">
                    @csrf
                    <input type="text" value="${qnaId}" name="qna_id" hidden>
                    <input type="hidden" name="system" value="admin">

                    @if (isset(Auth::guard('admin')->user()->profile_image))
                        <img class="w-8 h-8 rounded-full object-cover"
                            src="{{ asset(Auth::guard('admin')->user()->profile_image) }}">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    @endif

                    <div class="relative w-full h-16">
                        <span
                            class="absolute font-semibold z-10 p-2 dark:text-white">{{ \Str::limit(Auth::guard('admin')->user()->fullName, 20) }}</span>
                        <input type="text" name="answer"
                            class="pr-8 absolute align-bottom text-base placeholder-[#C9CCD4] text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 pt-9 pb-1 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="{{__('system.write_something')}}..." required />
                        <button type="submit" class="absolute bottom-0 right-0 me-2 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path class="stroke-primary" stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </button>

                    </div>
                </form>
            @endif
        `;

        // Thêm form mới vào DOM
        $(".reply-new").append(newForm);
    }

    function addNewChildrenForm(data) {
        let html = `
            @if (Auth::guard('admin')->check())
                <form method="POST" action="{{ route('informations.qnas.qnaanswer.create') }}"
                    id="qnaFormParent" class="flex items-center gap-3 mt-3 relative">
                    @csrf
                    <input type="text" value="${data.parent_id}" name="parent_id" hidden>
                    <input type="hidden" name="system" value="admin">

                    @if (isset(Auth::guard('admin')->user()->profile_image))
                        <img class="w-8 h-8 rounded-full object-cover"
                            src="{{ asset(Auth::guard('admin')->user()->profile_image) }}">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    @endif
                    <input type="text" name="answer"
                        class="w-full p-2 border border-gray-300 rounded-lg dark:bg-[#1E1E1E]"
                        placeholder="Write Reply..." required>
                        <button type="submit" class="absolute bottom-0 right-0 me-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path class="stroke-primary" stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </button>
                </form>
            @endif
            `;
        $(`#reply-child-container-${data.parent_id}`).append(html);
    }

    function appendReply(data) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const baseUrl = "{{ url('/') }}"; // Laravel's base URL
        const actionUrl = `${baseUrl}/admin/qnas/delete-reply/${data.id}`;
        let replyHtml = `
            <div class="flex gap-3 flex-col reply-remove-${data.id}">
                <div class="reply-item-container">
                    <div class="reply-item">
                        ${data.author.profile_image !== null ? `
                            <img class="w-12 h-12 rounded-full object-cover"
                                        src="${data.author.profile_image}">
                                ` : `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        `}

                        <div class="flex flex-col w-full pr-2 pl-2">
                            <div class="flex justify-between font-semibold text-base items-center">
                                <p class="dark:text-white">${data.author.fullName}</p>
                                ${data.canEdit ? `
                                    <div class="relative inline-block text-left">
                                        <button type="button" class="dropdown-toggle inline-flex items-center font-semibold justify-center text-primary cursor-pointer bg-white dark:bg-[#1E1E1E] dark:text-white hover:rounded-lg"
                                            data-dropdown-target="action-dropdown-menu-${data.id}">
                                            <div>
                                                <p class="text-xl tracking-wider font-semibold text-gray-700 dark:text-white heading-6">...</p>
                                            </div>
                                        </button>

                                        <div class="dropdown-menu absolute w-fit z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl border shadow-lg  dark:bg-[#1E1E1E]"
                                            id="action-dropdown-menu-${data.id}">
                                            <ul class="font-medium" role="none">
                                                <li>
                                                    <form
                                                        class="delete-reply-form" data-id="${data.id}" data-element=".reply-remove-${data.id}"
                                                        action="${actionUrl}"
                                                        method="post">
                                                        <input class="hidden" name="_token" value="${csrfToken}" />
                                                        <input class="hidden" name="_method" value="DELETE" />
                                                        <button type="submit"
                                                            class="w-full block px-6 py-2 text-sm text-gray-900 hover:bg-[#3B82F6] dark:text-gray-400 dark:hover:bg-[#383838] hover:rounded-xl hover:text-white"
                                                            role="menuitem"
                                                            onclick="closeDropdownDeleteReply(${data.id})">
                                                            <div class="inline-flex items-center">
                                                                {{ trans('system.form.button.delete') }}
                                                            </div>
                                                        </button>
                                                    </form>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                ` : ''}
                            </div>
                            <div class="w-fit mr-3 mt-1">
                                <p id="article-answer-${data.id}" class="text-sm text-gray-700 dark:text-white"
                                style="word-break: break-word; overflow-wrap: break-word;">
                                    ${data.answer.length > 150 ? data.answer.substring(0, 150) + '...' : data.answer}
                                </p>
                                ${data.answer.length > 150 ? `
                                    <button class="btn btn-primary btn-readmore text-sm text-primary underline"
                                        data-id="${data.id}" data-answer="${data.answer}">
                                        Read more
                                    </button>
                                    <button class="btn btn-primary btn-showless hidden text-sm text-primary underline"
                                        data-id="${data.id}" data-summary="${data.answer.substring(0, 150)}" data-answer="${data.answer}">
                                        Show less
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between px-5 mt-3">
                        <p class="text-xs text-gray-500">${data.created_at}</p>
                    </div>
                </div>
                <div class=" reply-child-container-style" id="reply-child-container-${data.id}">
                    @if (Auth::guard('admin')->check())
                        <form method="POST" action="{{ route('informations.qnas.qnaanswer.create') }}"
                            id="qnaFormParent" class="flex items-center gap-3 relative">
                            @csrf
                            <input type="text" value="${data.id}" name="parent_id" hidden>
                            <input type="hidden" name="system" value="admin">

                            @if (isset(Auth::guard('admin')->user()->profile_image))
                                <img class="w-8 h-8 rounded-full object-cover"
                                    src="{{ asset(Auth::guard('admin')->user()->profile_image) }}">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            @endif
                            <input type="text" name="answer"
                                class="w-full p-2 border border-gray-300 rounded-lg dark:bg-[#1E1E1E]"
                                placeholder="Write Reply..." required>
                                <button type="submit" class="absolute bottom-0 right-0 me-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path class="stroke-primary" stroke-linecap="round" stroke-linejoin="round"
                                              d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>
                        </form>
                    @endif
                </div>
            </div>
        `;

        $(".reply-container-append").append(replyHtml);
    }

    function appendChildReply(data) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let html = `
            <div class="flex items-start gap-3 reply-item reply-item-${data.id}">
                ${data.author.profile_image ? `
                    <img class="w-8 h-8 rounded-full object-cover"
                        src="${data.author.profile_image}">
                ` : `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                `}

                <div class="flex flex-col w-full items-start">
                    <p class="font-semibold text-base dark:text-white">
                        ${data.author.fullName}</p>
                    <p class="mt-1 text-sm text-gray-700 dark:text-white" id="article-answer-${data.id}">
                        ${data.answer.length > 150 ? data.answer.substring(0, 150) + '...' : data.answer}</p>

                    ${data.answer.length > 150 ? `
                        <button class="btn btn-primary btn-readmore text-sm text-primary underline"
                            data-id="${data.id}" data-answer="${data.answer}">
                            Read more
                        </button>
                        <button class="btn btn-primary btn-showless hidden text-sm text-primary underline"
                            data-id="${data.id}" data-summary="${data.answer.substring(0, 150)}" data-answer="${data.answer}">
                            Show less
                        </button>
                    ` : ''}

                    <p class="text-xs text-gray-500 mt-2">${data.created_at}</p>
                </div>


            </div>
        `;

        $(`#reply-child-container-${data.parent_id}`).append(html);
    }
</script>

<script src="https://unpkg.com/flowbite@latest/dist/flowbite.js"></script>

<script type="module">
    $(document).ready(function() {
        function toggleSubmitButton() {
            var titleValue = $('#title').val();
            var descriptionValue = $('#description').val();
            var anyFieldEmptyOrNull = !titleValue || !descriptionValue;
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
    document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();

            const dropdownId = button.getAttribute('data-dropdown-toggle');
            const dropdownMenu = document.getElementById(dropdownId);

            document.querySelectorAll('[id^="action-dropdown-menu-"]').forEach(menu => {
                if (menu !== dropdownMenu) {
                    menu.classList.add('hidden');
                }
            });

            dropdownMenu.classList.toggle('hidden');
        });
    });

    // document.addEventListener('click', function() {
    //     document.querySelectorAll('[id^="action-dropdown-menu-"]').forEach(menu => {
    //         menu.classList.add('hidden');
    //     });
    // });
</script>

<script>
    $(document).ready(function() {

        $(document).on('submit', '.delete-reply-form', function(event) {
            event.preventDefault();
            if (typeof toggleLoadingOverlay === 'function') {
                toggleLoadingOverlay();
            } else {
                console.error('toggleLoadingOverlay is not defined');
            }


            var form = $(this);
            var replyId = form.data('id');
            var element = form.data('element')
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: {
                    _token: csrfToken,
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.success) {
                        form.closest(element).remove();
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                },
                complete: function(response) {
                    if (typeof toggleLoadingOverlay === 'function') {
                        toggleLoadingOverlay();
                    }
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('answer-input');
        const warningMessage = document.getElementById('warning-message');
        const maxChars = 255;

        input.addEventListener('input', function() {
            if (input.value.length > maxChars) {
                input.value = input.value.slice(0, maxChars);
                warningMessage.classList.remove('hidden');
            } else {
                warningMessage.classList.add('hidden');
            }
        });
    });
</script>
