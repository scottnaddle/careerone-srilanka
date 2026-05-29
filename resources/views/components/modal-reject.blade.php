<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
        <!-- Header with Title on Left and Close Button on Right -->
        {{--                            <div class="flex justify-between items-center border-b border-gray-300 pb-2 mb-4">--}}
        {{--                                <h2 class="text-medium font-semibold">{{ __('CGO Approval') }}</h2>--}}
        {{--                                <button type="button" wire:click="closeModal"--}}
        {{--                                    class="text-gray-500 hover:text-gray-700">--}}
        {{--                                    &times;--}}
        {{--                                </button>--}}
        {{--                            </div>--}}
        <div class="mb-5 flex items-center justify-center" bis_skin_checked="1">
            <div class="rounded-full fi-color-custom bg-custom-100 dark:bg-custom-500/20 fi-color-primary p-3" style="--c-100:var(--primary-100);--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" bis_skin_checked="1">
                <!--[if BLOCK]><![endif]-->    <svg class="fi-modal-icon h-6 w-6 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
                </svg><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <p class="text-center mb-4">
            {{ __('Please write the reason for non-approval') }}</p>
        {{--                            <span--}}
        {{--                                class="block font-semibold text-center mb-4 text-2xl font-medium">{{ $this->detailid->fullName }}</span>--}}

        <!-- Checkbox options with circular style and dynamic state -->
        {{-- <div class="mt-4 space-y-2">
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
    </div> --}}

        <div class="mt-4">
                                <textarea placeholder="Please provide additional comments" wire:model="additionalComments"
                                          class="w-full h-32 p-2 border border-gray-300 rounded rounded-xl"></textarea>
        </div>
        <div class="mt-4 flex">
            <button type="button" wire:click="closeModal"  wire:loading.attr="disabled" wire:target="closeModal"
                    class="bg-white border text-gray-700 mr-2 px-4 py-2 rounded rounded-xl w-1/2 text-center text-sm font-semibold">
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
