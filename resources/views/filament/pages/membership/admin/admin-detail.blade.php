<div class="mx-auto p-4">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="{{route('filament.admin.resources.administrators.index')}}"
                class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">Administrator Detail</h3>
            </a>

            {{-- <a href="/" class="flex items-center rtl:space-x-reverse">
                <img src="{{asset('images/careerone-logo.png')}}" class="sm:h-8 md:h-12" alt="TVET Logo" />
            </a> --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1 max-w-xs">
                    <div class="flex items-center">
                        <span class="text-medium  text-gray-600 truncate">
                            Status:
                        </span>
                         <span class="text-base font-semibold text-gray-900 truncate flex items-center">
                            @if (!empty($dataResource->verify_by) && !empty($dataResource->verify_at) && !empty($dataResource->email_verified_at))
                                <span
                                    style='font-size:12px; color: #4984F6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <path d='M7 12l5 5l10 -10' />
                                        <path d='M2 12l5 5m5 -5l5 -5' />
                                    </svg>
                                    {{ __('admin/status.approved') }}
                                </span>
                            @elseif(empty($dataResource->verify_by) && empty($dataResource->verify_at)  && !empty($dataResource->email_verified_at))
                                <span
                                    style='font-size:12px; color: #a3a3a3; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <line x1='18' y1='6' x2='6' y2='18' />
                                        <line x1='6' y1='6' x2='18' y2='18' />
                                    </svg>
                                    {{ __('admin/status.requested') }}
                                </span>
{{--                             @elseif($dataResource->active == false)--}}
{{--                                 <span--}}
{{--                                     style='font-size:12px; color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>--}}
{{--                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'--}}
{{--                                         viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'--}}
{{--                                         stroke-linecap='round' stroke-linejoin='round'>--}}
{{--                                        <path stroke='none' d='M0 0h24v24H0z' />--}}
{{--                                        <line x1='18' y1='6' x2='6' y2='18' />--}}
{{--                                        <line x1='6' y1='6' x2='18' y2='18' />--}}
{{--                                    </svg>--}}
{{--                                    {{ __('admin/status.inactive') }}--}}
{{--                                </span>--}}
                            @else
                                <span
                                    style='font-size:12px; color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;'>
                                    <svg class='h-4 w-4 inline-block mr-1' width='24' height='24'
                                        viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none'
                                        stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' />
                                        <line x1='18' y1='6' x2='6' y2='18' />
                                        <line x1='6' y1='6' x2='18' y2='18' />
                                    </svg>
                                    {{ __('admin/status.rejected') }}
                                </span>
                            @endif
                        </span>

                    </div>
                </div>
            </div>

            {{ $this->form->schema($this->getThirdFormSchema()) }}
            <div class="col-span-1  ">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-blue-500 leading-6 truncate">
                        Sign-up information
                    </span>
{{--                    <svg class="h-5 w-5 text-[#C9CCD4]" viewBox="0 0 24 24" fill="none" stroke="currentColor"--}}
{{--                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">--}}
{{--                        <circle cx="12" cy="12" r="3" />--}}
{{--                        <path--}}
{{--                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />--}}
{{--                    </svg>--}}
{{--                    <x-filament::page>--}}
{{--                        @foreach ($this->getHeaderActions() as $action)--}}
{{--                            {{ $action }}--}}
{{--                        @endforeach--}}
{{--                    </x-filament::page>--}}
                    @if(auth('admin')->user()->hasRole('super_admin'))
                    <a href="{{route('filament.admin.resources.administrators.edit', ['record' => $this->dataResource->id])}}" class="fi-btn relative bg-primary grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm text-white hover:bg-blue-800 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">
                        <svg wire:loading.remove.delay.default="1" wire:target="toggleEditMode" class="fi-btn-icon transition duration-75 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"></path>
                        </svg>
                        <span class="fi-btn-label">
                            Edit
                        </span>
                    </a>
                    @endif
                </div>
            </div>
            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form->schema($this->getFirstFormSchema()) }}
                @if ($dataResource->isFullyVerified())
                    <div class="mt-auto flex justify-end space-x-2">
                        @if(auth('admin')->user()->hasRole('super_admin'))
                            <div>
{{--                                <button type="button" wire:click="handleBlock"--}}
{{--                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm">--}}
{{--                                    {{ __('Withdrawal') }}--}}
{{--                                </button>--}}
                                <button onclick="confirmBlock(event, this)" wire:loading.attr="disabled" type="button" wire:click="handleBlock"
                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold">
                                    {{ __('Withdrawal') }}
                                </button>
                            </div>
                        @endif
                        @if ($dataResource->UserReActive()->whereNull('reactive_account_requests.confirmed_at')->first())
                        <button type="button" onclick="confirmApprovalActive(event)" wire:click="handleApprovalActive"
                            wire:loading.attr="disabled"
                            class="bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold text-sm">
                            <span wire:loading.remove>{{ __('Approval Active') }}</span>
                            <span class="text-white" wire:loading class="animate-pulse">Processing...</span>
                        </button>
                    @endif
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
    <script>
        function toggleLoadingOverlay() {
            const loadingOverlay = document.getElementById('loading-overlay');
            loadingOverlay.classList.toggle('hidden');
        }

        function confirmBlock(event, button) {
            event.preventDefault(); // Prevent default click action

            if (confirm('Are you sure you want to block this user?')) {
                toggleLoadingOverlay();
                // Manually trigger Livewire action
                button.dispatchEvent(new Event('click', { bubbles: true }));
            }
        }
    </script>
</div>
