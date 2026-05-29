<div class="mx-auto p-4">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="/admin/cgo-approval-list"
                class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{ __('admin/company.company_approval') }}</h3>
            </a>


            <div class="col-span-1  ">
                <div class="flex justify-between">
                    <span class="text-lg font-semibold text-blue-500 leading-6 truncate">
                        {{ __('admin/company.sign_up_information') }}
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

            </x-filament-panels::form>

            <x-filament-panels::form wire:submit.prevent="authenticate" class="flex flex-col min-h-full">
                @if (is_null($this->detailid->verified_by)&&is_null($this->detailid->verified_at))
                     <div class="mt-auto flex justify-end space-x-2">
                        <div class="mr-2">
                            <button type="button" wire:loading.attr="disabled" wire:target="showApprovalModal" wire:click="showApprovalModal"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm ">
                                {{ __('Reject') }}
                                <svg wire:loading wire:target="showApprovalModal" class="animate-spin h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 000 8v4a8 8 0 01-8-8z"></path>
                            </svg>
                            </button>
                        </div>
                        <div>
                            <button type="button" wire:loading.attr="disabled" wire:target="handleApproval"
                                wire:click="handleApproval" class="bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold text-sm">
                                {{ __('system.form.button.approve') }}
                                <svg wire:loading wire:target="handleApproval" class="animate-spin h-5 w-5"
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

                @if ($showModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                        <!-- Header with Title on Left and Close Button on Right -->
{{--                        <div class="flex justify-between items-center border-b border-gray-300 pb-2 mb-4">--}}
{{--                            <h2 class="text-medium font-semibold">{{ __('admin/company.company_approval') }}</h2>--}}
{{--                            <button type="button" wire:click="closeModal" class="text-gray-500 hover:text-gray-700">--}}
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
{{--                        <span class="block font-semibold text-center mb-4 text-2xl font-medium">{{$this->detailid->fullName}}</span>--}}

                        <!-- Checkbox options with circular style and dynamic state -->

                        <div class="mt-4">
                            <textarea wire:model="additionalComments" placeholder="Please provide additional comments (optional)"
                                class="w-full h-32 p-2 border border-gray-300 rounded rounded-xl"></textarea>
                        </div>
                        <div class="mt-4 flex">
                            <button type="button" wire:click="closeModal"  wire:loading.attr="disabled" wire:target="closeModal"
                            class="bg-white text-gray-700 border mr-2 px-4 py-2 rounded rounded-xl w-1/2 text-center text-sm font-semibold">
                            {{ __('Cancel') }}
                            <svg wire:loading wire:target="closeModal" class="animate-spin h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 000 8v4a8 8 0 01-8-8z"></path>
                        </svg>
                        </button>
                        <button type="button" wire:click="approveItem" wire:loading.attr="disabled" wire:target="approveItem"
                            class="bg-blue-500 text-white px-4 py-2 rounded rounded-xl w-1/2 text-center text-sm font-semibold">
                            {{ __('Confirm') }}
                            <svg wire:loading wire:target="approveItem" class="animate-spin h-5 w-5"
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
