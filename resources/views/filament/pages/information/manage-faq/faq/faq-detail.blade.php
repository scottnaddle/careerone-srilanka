<div class="mx-auto p-4">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="{{ url()->previous() }}"
                class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{$contenData->title}}</h3>
            </a>

            {{-- <a href="/" class="flex items-center rtl:space-x-reverse">
                <img src="{{asset('images/careerone-logo.png')}}" class="sm:h-8 md:h-12" alt="TVET Logo" />
            </a> --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1 ">
                    <div class="flex items-center">
                        <span class="text-medium  text-gray-600 truncate">
                            Status:
                        </span>

                        <span class="text-base font-semibold text-gray-900 truncate flex items-center">
                            {!! $contenData->status==1 ?
                            "<span style='font-size:12px; color: #4984F6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                <svg class='h-4 w-4 inline-block mr-1' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z'/>
                                    <path d='M7 12l5 5l10 -10'/>
                                    <path d='M2 12l5 5m5 -5l5 -5'/>
                                </svg>
                                Approved
                            </span>" :
                            "<span style='font-size:12px; color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                <svg class='h-4 w-4 inline-block mr-1' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z'/>
                                    <line x1='18' y1='6' x2='6' y2='18'/>
                                    <line x1='6' y1='6' x2='18' y2='18'/>
                                </svg>
                                Non-Approved
                            </span>"
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
                    $matches
                );
                $videoId = $matches[1] ?? null;
                $embedUrl = $videoId ? "https://www.youtube.com/embed/$videoId" : null;
            @endphp

            @if($embedUrl)
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
                @if ($contenData->status==0)
                     <div class="mt-auto flex justify-end space-x-2">
                    <div class="mr-2">
                        <button type="button" wire:click="showApprovalModal"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm ">
                            {{ __('Non-approve') }}
                        </button>
                    </div>
                    <div>
                        <button type="button" wire:click="handleApproval"
                            class="bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold text-sm">
                            {{ __('system.form.button.approve') }}
                        </button>
                    </div>
                </div>
                @endif

                @if ($showModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                        <!-- Header with Title on Left and Close Button on Right -->
                        <div class="flex justify-between items-center border-b border-gray-300 pb-2 mb-4">
                            <h2 class="text-medium font-semibold">{{ __('CGO Approval') }}</h2>
                            <button type="button" wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                                &times;
                            </button>
                        </div>

                        <p class="text-center mb-4">
                            {{ __('Please write the reason for non-approving the following CGO:') }}</p>
                        <span class="block font-semibold text-center mb-4 text-2xl font-medium">{{$this->detailid->fullName}}</span>

                        <!-- Checkbox options with circular style and dynamic state -->
                        <div class="mt-4 space-y-2">
                            @foreach ($reasonSelect as $reason)
                                <label class="flex items-center">
                                    <input type="checkbox"
                                           wire:click="toggleReason('{{ $reason }}')"
                                           class="mr-2 appearance-none w-4 h-4 rounded-full border-2
                                                  {{ in_array($reason, $selectedReasons) ? 'bg-blue-500 border-blue-500' : 'border-gray-300' }}
                                                  transition-all"
                                           {{ in_array($reason, $selectedReasons) ? 'checked' : '' }}>
                                    <input type="text" value="{{ $reason }}" disabled
                                           class="w-full border border-gray-300 rounded-xl text-gray-300
                                                  {{ in_array($reason, $selectedReasons) ? 'font-medium text-[#464559] bg-[#F5F7FA]' : 'text-gray-400' }}">
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <textarea wire:model="additionalComments" placeholder="Please provide additional comments (optional)"
                                class="w-full h-32 p-2 border border-gray-300 rounded rounded-xl"></textarea>
                        </div>
                        <div class="mt-4 flex">
                            <button type="button" wire:click="closeModal"
                                class="bg-gray-300 text-gray-700 mr-2 px-4 py-2 rounded rounded-full w-1/2">
                                {{ __('Cancel') }}
                            </button>
                            <button type="button" wire:click="approveItem"
                                class="bg-blue-500 text-white px-4 py-2 rounded rounded-full w-1/2">
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
    </style>
</div>
