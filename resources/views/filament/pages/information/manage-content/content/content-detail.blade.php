<x-filament-panels::page>
<div class="mx-auto p-4 w-full">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="{{ url()->previous() }}"
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
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1 ">
                    <div class="flex justify-between items-center">
                        <span class="text-medium  text-gray-600 truncate">
                            Status:
                        </span>
                        <span class="text-base font-semibold text-gray-900 truncate flex items-center">
                            @if ($contenData->status == \App\Enums\StatusEnumsManagement::APPROVED->value)
                                <span
                                    style=' color: #4984F6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <path d='M7 12l5 5l10 -10' />
                                        <path d='M2 12l5 5m5 -5l5 -5' />
                                    </svg>
                                    {{\App\Enums\StatusEnumsManagement::getStatusName($contenData->status)}}
                                </span>
                            @elseif($contenData->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value)
                                <span
                                    style='color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <line x1='18' y1='6' x2='6' y2='18' />
                                        <line x1='6' y1='6' x2='18' y2='18' />
                                    </svg>
                                    {{\App\Enums\StatusEnumsManagement::getStatusName(1)}}
                                </span>
                            @else
                                <span
                                    style='color: #5a5252; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <line x1='18' y1='6' x2='6' y2='18' />
                                        <line x1='6' y1='6' x2='18' y2='18' />
                                    </svg>
                                    {{\App\Enums\StatusEnumsManagement::getStatusName($contenData->status)}}
                                </span>
                            @endif
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


            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form->schema($this->getFirstFormSchema()) }}
                <div class="font-medium text-center text-gray-500 dark:text-gray-300">
                    {{-- {{trans('auth.dont_have_account')}} <a href="/admin/auth/register" class="text-blue-700 hover:underline dark:text-blue-500">Sign up</a> --}}
                </div>
                @if ($contenData->status = \App\Enums\StatusEnumsManagement::APPROVED->value && $contenData->status != \App\Enums\StatusEnumsManagement::NON_APPROVAL->value )
                    <div class="mt-auto flex justify-end space-x-2">
                        <div>
                            <button type="button" wire:loading.attr="disabled" wire:target="handleBlock"
                                wire:click="handleBlock" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold">
                                {{ __('Reject') }}
                                <svg wire:loading wire:target="handleBlock" class="animate-spin h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 000 8v4a8 8 0 01-8-8z"></path>
                                </svg>
                            </button>
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
    </style>
</div>
</x-filament-panels::page>
