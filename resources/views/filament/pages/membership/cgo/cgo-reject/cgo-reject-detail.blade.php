<x-filament-panels::page>
<div class="mx-auto p-4 w-full">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="{{ route('filament.admin.pages.cgo-approval-list')}}"
                class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">Cgo Detail</h3>
            </a>

            {{-- <a href="/" class="flex items-center rtl:space-x-reverse">
                <img src="{{asset('images/careerone-logo.png')}}" class="sm:h-8 md:h-12" alt="TVET Logo" />
            </a> --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1  max-w-xs">
                    <div class="flex justify-between">
                        <span class="text-medium  text-gray-600 truncate">
                            Status:
                        </span>
                        <span class="text-base font-semibold text-gray-900 truncate flex items-center">
                            @if (!empty($traineeData->verify_by) && !empty($traineeData->verify_at))
                                <span
                                    style='font-size:12px; color: #4984F6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <path d='M7 12l5 5l10 -10' />
                                        <path d='M2 12l5 5m5 -5l5 -5' />
                                    </svg>
                                    Approved
                                </span>
                            @elseif(empty($traineeData->verify_by) && empty($traineeData->verify_at))
                                <span
                                    style='font-size:12px; color: #a3a3a3; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <line x1='18' y1='6' x2='6' y2='18' />
                                        <line x1='6' y1='6' x2='18' y2='18' />
                                    </svg>
                                    Requested
                                </span>
                            @elseif(!empty($traineeData->verify_by) && empty($traineeData->verify_at))
                                <span
                                    style='font-size:12px; color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <line x1='18' y1='6' x2='6' y2='18' />
                                        <line x1='6' y1='6' x2='18' y2='18' />
                                    </svg>
                                    Rejected
                                </span>
                            @endif
                            {!! $traineeData->isFullyVerified() ? '' : '' !!}
                        </span>



                    </div>
                </div>
            </div>

            {{ $this->form->schema($this->getThirdFormSchema()) }}
            <div class="col-span-1  ">
                <div class="flex justify-between">
                    <span class="text-lg font-semibold text-blue-500 leading-6 truncate">
                        Sign-up information
                    </span>
                    <svg class="h-5 w-5 text-[#C9CCD4]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                </div>
            </div>
            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form->schema($this->getFirstFormSchema()) }}

                <div class="col-span-1 ">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-blue-500 leading-6 truncate">
                            Basic information
                        </span>
                        <svg class="h-5 w-5 text-[#C9CCD4]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                    </div>
                </div>

                {{ $this->form->schema($this->getSecondFormSchema()) }}


                <div class="font-medium text-center text-gray-500 dark:text-gray-300">
                    {{-- {{trans('auth.dont_have_account')}} <a href="/admin/auth/register" class="text-blue-700 hover:underline dark:text-blue-500">Sign up</a> --}}
                </div>

                <div class="mt-auto flex justify-end space-x-2">
                    <div>
                        <button type="button" wire:click="handleApproval"
                            class="bg-blue-500 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                            {{ __('system.form.button.approve') }}
                        </button>
                    </div>

                </div>
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
