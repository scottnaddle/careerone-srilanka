<div class="mx-auto p-4">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="{{ route('filament.admin.pages.administrator-approval-list') }}"
               class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">Admin Approval</h3>
            </a>


            <div class="col-span-1  ">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-blue-500 truncate">
                        Sign-up information
                    </span>
                    <x-filament::page>
                        @foreach ($this->getHeaderActions() as $action)
                            {{ $action }}
                        @endforeach
                    </x-filament::page>
                </div>
            </div>
            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form->schema($this->getFirstFormSchema()) }}
                <div class="font-medium text-center text-gray-500 dark:text-gray-300">
                    {{-- {{trans('auth.dont_have_account')}} <a href="/admin/auth/register" class="text-blue-700 hover:underline dark:text-blue-500">Sign up</a> --}}
                </div>
            </x-filament-panels::form>

            {{-- Only show the Approve/Reject buttons when not yet approved AND not in edit mode --}}
            @if (empty($detailid->verify_by) && empty($detailid->verify_at) && !$this->isEditing)
                <x-filament-panels::form wire:submit.prevent="authenticate" class="flex flex-col min-h-full">
                    <div class="mt-auto flex justify-end space-x-2" wire:loading.attr="disabled" wire:target="showApprovalModal">
                        <div class="mr-2">
                            <button type="button" wire:loading.attr="disabled" wire:target="showApprovalModal" wire:click="showApprovalModal"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm">
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
                                    wire:click="handleApproval" class="bg-primary text-white px-4 py-2 rounded-xl font-semibold text-sm">
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
                </x-filament-panels::form>
            @endif

            {{-- Show a message when in edit mode --}}
            @if($this->isEditing)
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <p class="text-sm text-yellow-700">
                        ⚠️ You are in edit mode. Please save your changes before approving or rejecting.
                    </p>
                </div>
            @endif

            {{-- Reject modal - unchanged --}}
            @if ($showModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                        <div class="mb-5 flex items-center justify-center" bis_skin_checked="1">
                            <div class="rounded-full fi-color-custom bg-custom-100 dark:bg-custom-500/20 fi-color-primary p-3" style="--c-100:var(--primary-100);--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" bis_skin_checked="1">
                                <svg class="fi-modal-icon h-6 w-6 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-center mb-4">
                            {{ __('Please write the reason for non-approval.') }}
                        </p>
                        <div class="mt-4">
                            <textarea wire:model="additionalComments" placeholder="Please provide additional comments"
                                      class="w-full h-32 p-2 border border-gray-300 rounded rounded-xl"></textarea>
                        </div>
                        <div class="mt-4 flex">
                            <button type="button" wire:click="closeModal" wire:loading.attr="disabled" wire:target="closeModal"
                                    class="bg-white text-gray-700 border border-gray-300 mr-2 px-4 py-2 rounded rounded-xl w-1/2 text-center text-sm font-semibold">
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
                                    class="bg-primary text-white px-4 py-2 rounded rounded-xl w-1/2 text-center text-sm font-semibold">
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

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </div>
    </div>
    <style>
        .fi-ac-btn-action {
            border-radius: 9999px !important;
        }
    </style>
</div>
