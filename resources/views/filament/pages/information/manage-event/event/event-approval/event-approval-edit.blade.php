<x-filament-panels::page>
<div class="mx-auto p-4 w-full">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="{{ route('filament.admin.resources.information.content.event-lists.index') }}"
                class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{ $contenData->title }}</h3>
            </a>

            {{-- <a href="/" class="flex items-center rtl:space-x-reverse">
                <img src="{{asset('images/careerone-logo.png')}}" class="sm:h-8 md:h-12" alt="TVET Logo" />
            </a> --}}
            {{-- <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1 ">
                    <div class="flex justify-between">
                        <span class="text-medium  text-gray-600 truncate">
                            Status:
                        </span>
                        <span class="text-base font-semibold text-gray-900 truncate flex items-center">
                            {!! $contenData->status==2 ?
                            "<span style='font-size:12px; color: #4984F6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                <svg class='h-4 w-4 inline-block mr-1' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z'/>
                                    <path d='M7 12l5 5l10 -10'/>
                                    <path d='M2 12l5 5m5 -5l5 -5'/>
                                </svg>
                                Approved
                            </span>" :
                            ($record->status == 1 ?
                            "<span style='font-size:12px; color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                <svg class='h-4 w-4 inline-block mr-1' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z'/>
                                    <line x1='18' y1='6' x2='6' y2='18'/>
                                    <line x1='6' y1='6' x2='18' y2='18'/>
                                </svg>
                                Non-Approved
                            </span>"
                            :
                            "<span style='font-size:12px; color: #a5a5a5; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                Waiting Approval
                            </span>"
                            )

                            !!}
                        </span>



                    </div>
                </div>
            </div> --}}
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
            <div class="flex flex-col gap-6 bg-white dark:bg-[#1E1E1E] p-6 rounded-lg  custom-width mb-8">
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $event->title }}</p>
                <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                    <p>{{ $event->created_at->format('d M, Y') }}</p>
                    <p>{{ __('By') }} {{ $event->author->fullName }}</p>
                </div>

                <div class="ck-content dark:text-white bg-white dark:bg-gray-700 p-6 rounded-xl border border-gray-300">
                    <div class="min-h-72">{!! $event->details !!}</div>
                </div>

                @if ($event->attachments->count() > 0)
                    <div class="py-4">
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">{{ __('Attachments') }}</h4>
                        <ul role="list" class="divide-y divide-gray-200 border border-gray-200 rounded-md">
                            @foreach ($event->attachments as $item)
                                <li class="flex items-center justify-between py-4 px-4">
                                    <div class="flex items-center space-x-4">
                                        <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex-1 min-w-0">
                                            <a target="_blank" href="{{ route('informations.events.attachments.preview', ['id' => $item->id]) }}" class="text-blue-600 hover:underline dark:text-white truncate">{{ $item->file_name }}</a>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $item->file_size }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('informations.events.download', ['id' => $item->id]) }}" class="text-primary hover:underline">{{ __('Download') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="mt-auto flex justify-end space-x-2">
                @if ($contenData->status == \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value ||
                 $contenData->status == \App\Enums\StatusEnumsManagement::APPROVED->value)
                    <div class="mr-2">
                        <button type="button" wire:click="showApprovalModal"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm ">
                            {{ __('Reject') }}
                        </button>
                    </div>
                @endif
                @if ($contenData->status == \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value
                || $contenData->status ==\App\Enums\StatusEnumsManagement::NON_APPROVAL->value)
                    <div>
                        <button type="button" wire:click="handleApproval"
                            class="bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold text-sm">
                            {{ __('system.form.button.approve') }}
                        </button>
                    </div>
                @endif


            </div>
            @if ($showModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                        <!-- Header with Title on Left and Close Button on Right -->
{{--                        <div class="flex justify-between items-center border-b border-gray-300 pb-2 mb-4">--}}
{{--                            <h2 class="text-medium font-semibold">{{ __('Event Approval') }}</h2>--}}
{{--                            <button type="button" wire:click="closeModal"--}}
{{--                                class="text-gray-500 hover:text-gray-700">--}}
{{--                                &times;--}}
{{--                            </button>--}}
{{--                        </div>--}}
                        <div class="mb-5 flex items-center justify-center" bis_skin_checked="1">
                            <div class="rounded-full fi-color-custom bg-custom-100 dark:bg-custom-500/20 fi-color-primary p-3" style="--c-100:var(--primary-100);--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" bis_skin_checked="1">
                                <!--[if BLOCK]><![endif]-->    <svg class="fi-modal-icon h-6 w-6 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
                                </svg><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <p class="text-center mb-4">
                            {{ __('Please write the reason for non-approval') }}</p>
{{--                        <span--}}
{{--                            class="block font-semibold text-center mb-4 text-2xl font-medium">{{ $this->detailid->fullName }}</span>--}}

                        <div class="mt-4">
                            <textarea wire:model="additionalComments" placeholder="Comment"
                                class="w-full h-32 p-2 border border-gray-300 rounded rounded-xl"></textarea>
                        </div>
                        <div class="mt-4 flex">
                            <button type="button" wire:click="closeModal"
                                class="bg-white text-gray-700 border mr-2 px-4 py-2 rounded rounded-xl w-1/2 font-semibold text-center text-sm">
                                {{ __('Cancel') }}
                            </button>
                            <button type="button" wire:click="approveItem"
                                class="bg-primary text-white px-4 py-2 rounded rounded-xl w-1/2 font-semibold text-center text-sm">
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
</x-filament-panels::page>
