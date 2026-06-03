<div class="mx-auto p-4">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <div class="flex justify-between items-center">
{{--                <a href="{{ route('filament.admin.resources.information.event-list-rejecteds.index') }}"--}}
                <a href="{{ url()->previous() }}"
                    class="text-gray-900 dark:bg-gray-950 dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m15 19-7-7 7-7" />
                    </svg>
                    <h3 class="text-lg font-semibold text-[#464559] dark:text-white">
                        {{-- {{ $contenData->title }} --}}
                        {{ __('Back to List') }}
                    </h3>
                </a>
                <div class="mt-auto flex justify-end space-x-2">
                    @if ($contenData->status == 1)
                        <div>
                            <button type="button" wire:click="handleApproval"
                                class="bg-blue-500 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                                {{ __('system.form.button.approve') }}
                            </button>
                        </div>
                    @endif


                </div>
            </div>

            {{-- <a href="/" class="flex items-center rtl:space-x-reverse">
                <img src="{{asset('images/careerone-logo.png')}}" class="sm:h-8 md:h-12" alt="TVET Logo" />
            </a> --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1 ">
                    <div class="flex  items-center">
                        <span class="text-medium  text-gray-600 truncate">
                            Status:
                        </span>
                        <span class="text-base font-semibold text-gray-900 truncate flex items-center">

                            {!!
                                $contenData->status == \App\Enums\StatusEnumsManagement::APPROVED->value
                                ? "<span style='font-size:12px; color: #4984F6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z'/>
                                        <path d='M7 12l5 5l10 -10'/>
                                        <path d='M2 12l5 5m5 -5l5 -5'/>
                                    </svg>
                                    ".__('admin/status.approved')."
                                </span>"
                                : ($contenData->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value
                                    ? "<span style='font-size:12px; color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                        <svg class='h-4 w-4 inline-block mr-1' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                            <path stroke='none' d='M0 0h24v24H0z'/>
                                            <line x1='18' y1='6' x2='6' y2='18'/>
                                            <line x1='6' y1='6' x2='18' y2='18'/>
                                        </svg>
                                        ".__('admin/status.non_approval')."
                                    </span>"
                                    : "<span style='font-size:12px; color: #a5a5a5; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                        ".__('admin/status.pending_approval')."
                                    </span>")
                            !!}

                        </span>




                    </div>
                </div>
            </div>
            @if (!empty($contenData->video_url))
                @php
                    preg_match(
                        '/(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|.*[?&]v=))([^&?]+)/',
                        $contenData->video_url,
                        $matches,
                    );
                    $videoId = $matches[1] ?? null;
                    $embedUrl = $videoId ? "https://www.youtube.com/embed/$videoId" : null;
                @endphp

                @if ($embedUrl)
                    <div class="mt-4">
                        <iframe width="100%" height="400" class="rounded-xl" src="{{ $embedUrl }}"
                            title="YouTube video player"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                @endif
            @endif

            @php
                $event = $this->detailid;
            @endphp
            <x-filament-panels::form wire:submit="authenticate">
                <div class="flex flex-col gap-6 bg-white rounded-lg p-6 mb-12 shadow-lg dark:bg-[#1E1E1E]">

                    <div class="border rounded-lg px-4 py-5 flex flex-col gap-4 bg-gray-50 dark:bg-gray-800">
                        <p class="text-primary text-3xl font-bold dark:text-white">{{ $event->title }}</p>

                        <div class="flex gap-6 items-center">
                            <p class="text-sm font-semibold text-primary flex gap-1 items-center dark:text-gray-300">
                                <span><svg width="16" height="16" viewBox="0 0 17 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.5 6.66634H2.5M11.1667 1.33301 V3.99967M5.83333 1.33301V3.99967M5.7 14.6663H11.3C12.4201 14.6663 12.9802 14.6663 13.408 14.4484C13.7843 14.2566 14.0903 13.9506 14.282 13.5743C14.5 13.1465 14.5 12.5864 14.5 11.4663V5.86634C14.5 4.74624 14.5 4.18618 14.282 3.75836C14.0903 3.38204 13.7843 3.07607 13.408 2.88433C12.9802 2.66634 12.4201 2.66634 11.3 2.66634H5.7C4.5799 2.66634 4.01984 2.66634 3.59202 2.88433C3.21569 3.07607 2.90973 3.38204 2.71799 3.75836C2.5 4.18618 2.5 4.74624 2.5 5.86634V11.4663C2.5 12.5864 2.5 13.1465 2.71799 13.5743C2.90973 13.9506 3.21569 14.2566 3.59202 14.4484C4.01984 14.6663 4.5799 14.6663 5.7 14.6663Z"
                                            stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round"
                                            class="dark:stroke-white" stroke-linejoin="round" />
                                    </svg>
                                </span>{{ date("Y-m-d", strtotime($event->created_at)) }}
                            </p>

                            <p class="text-sm font-semibold text-primary flex gap-1 items-center dark:text-gray-300">
                                <span><svg width="16" height="16" viewBox="0 0 15 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.4987 9.33333H4.4987C3.56832 9.33333 3.10313 9.33333 2.7246 9.44816C1.87233 9.70669 1.20539 10.3736 0.946858 11.2259C0.832031 11.6044 0.832031 12.0696 0.832031 13M9.16536 4C9.16536 5.65685 7.82222 7 6.16536 7C4.50851 7 3.16536 5.65685 3.16536 4C3.16536 2.34315 4.50851 1 6.16536 1C7.82222 1 9.16536 2.34315 9.16536 4ZM6.83203 13L8.8996 12.4093C8.99861 12.381 9.04812 12.3668 9.09429 12.3456C9.13529 12.3268 9.17427 12.3039 9.21064 12.2772C9.25159 12.2471 9.288 12.2107 9.36081 12.1379L13.6654 7.83336C14.1256 7.37311 14.1256 6.62689 13.6654 6.16665C13.2051 5.70642 12.4589 5.70642 11.9987 6.16666L7.69414 10.4712C7.62133 10.544 7.58492 10.5804 7.55486 10.6214C7.52816 10.6578 7.50522 10.6967 7.4864 10.7377C7.4652 10.7839 7.45105 10.8334 7.42276 10.9324L6.83203 13Z"
                                            stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round"
                                            class="dark:stroke-white" stroke-linejoin="round" />
                                    </svg>
                                </span>{{ $event->author->fullName }}
                            </p>
                        </div>
                        <span
                            class="bg-blue-100 text-base w-fit font-medium px-3 py-1 rounded dark:bg-blue-900 dark:text-blue-300">
                            From {{ date('Y-m-d', strtotime($event->start_time)) }} to
                            {{ date('Y-m-d', strtotime($event->end_time)) }}
                        </span>
                        @if ($event->place)
                            <span class="dark:text-white">Place: <span
                                    class="font-semibold">{{ $event->place }}</span></span>
                        @endif
                        <figure class="custom-width-image">
                            <img src="{{ asset($event->thumbnail) }}" alt="Event image"  class="w-72 rounded-xl  click-zoom">

                        </figure>

                        <div class="text-sm dark:text-gray-300 bg-white dark:bg-gray-700 rounded-lg p-4 shadow-inner ">
                            <div class="whitespace-normal">{!! $event->details !!}</div>
                        </div>

                    </div>

                    @if ($event->attachments->count() > 0)
                    <div class="mt-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <ul role="list"
                                class="divide-y">
                                @foreach ($event->attachments as $item)
                                    <li
                                        class="flex items-center justify-between py-4 pl-4 pr-5 text-sm ">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-300"
                                                fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" />
                                            </svg>
                                            <div class="ml-4 truncate">
                                                <a target="_blank"
                                                    href="{{ route('informations.events.attachments.preview', ['id' => $item->id]) }}"
                                                    class="font-medium text-primary hover:underline dark:text-white">{{ $item->file_name }}</a>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <a target="_blank"
                                                href="{{ route('informations.events.download', ['id' => $item->id]) }}"
                                                class="font-medium text-primary hover:underline dark:text-white">Download</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                </div>


                @if ($showModal)
                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                            <!-- Header with Title on Left and Close Button on Right -->
                            <div class="flex justify-between items-center border-b border-gray-300 pb-2 mb-4">
                                <h2 class="text-medium font-semibold">{{ __('Event Approval') }}</h2>
                                <button type="button" wire:click="closeModal"
                                    class="text-gray-500 hover:text-gray-700">
                                    &times;
                                </button>
                            </div>

                            <p class="text-center mb-4">
                                {{ __('Please write the reason for non-approving the following Event:') }}</p>
                            <span
                                class="block font-semibold text-center mb-4 text-2xl font-medium">{{ $this->detailid->fullName }}</span>

                            <div class="mt-4">
                                <textarea wire:model="additionalComments" placeholder="Comment"
                                    class="w-full h-32 p-2 border border-gray-300 rounded rounded-xl"></textarea>
                            </div>
                            <div class="mt-4 flex">
                                <button type="button" wire:click="closeModal"
                                    class="bg-white border text-gray-700 mr-2 px-4 py-2 rounded rounded-xl w-1/2 text-center text-sm font-semibold">
                                    {{ __('Cancel') }}
                                </button>
                                <button type="button" wire:click="approveItem"
                                    class="bg-primary text-white px-4 py-2 rounded rounded-xl w-1/2 text-sm text-center font-semibold">
                                    {{ __('Confirm') }}
                                </button>
                            </div>


                        </div>
                    </div>
                @endif
            </x-filament-panels::form>
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </div>
    </div>
    <style>
        .fi-ac-btn-action {
            border-radius: 9999px !important;
        }

        .ck-content {
            height: 18rem;
        }
    </style>

</div>
