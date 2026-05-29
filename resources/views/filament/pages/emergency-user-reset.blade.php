<x-filament-panels::page>
    <form wire:submit.prevent="searchUser">
        {{ $this->form }}

        <div class="mt-4 flex items-center gap-3">
            <x-filament::button
                type="submit"
                color="primary"
                wire:target="searchUser"
                wire:loading.attr="disabled"
            >
                {{-- Dùng d-loading của Filament để gọn code --}}
                <span wire:loading.remove wire:target="searchUser">
                    {{ __('emergency.search_btn') }}
                </span>
                <span wire:loading wire:target="searchUser" class="flex items-center gap-2">
                    {{ __('emergency.searching_btn') }}
                </span>
            </x-filament::button>
            @if($foundUser && !$newlyGeneratedPassword)
                <div>
                    {{ $this->resetPasswordAction }}
                </div>
            @endif
        </div>
    </form>

    <hr class="my-1 border-gray-200 dark:border-gray-800">

    {{-- Hiển thị Mật khẩu mới sau khi Reset thành công --}}
    @if($newlyGeneratedPassword)
        <div class="mb-6 p-4 bg-success-50 border border-success-200 rounded-xl dark:bg-success-900/20 dark:border-success-800 shadow-sm">
            <div class="flex items-center gap-3 text-success-700 dark:text-success-400">
                <x-heroicon-o-check-circle class="h-6 w-6" />
                <h3 class="text-lg font-bold">{{ __('emergency.reset_complete') }}</h3>
            </div>
            <div class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-success-100 dark:border-success-900">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ __('emergency.new_password_display') }}:</p>
                <code class="text-2xl font-mono font-extrabold text-danger-600 dark:text-danger-400 tracking-wider">
                    {{ $newlyGeneratedPassword }}
                </code>
                <p class="mt-2 text-xs text-gray-500 italic">{{ __('emergency.password_warning') }}</p>
            </div>
        </div>
    @endif

    {{-- Hiển thị thông tin User được tìm thấy --}}
    @if($foundUser)
        <div class="p-6 border rounded-xl bg-white dark:bg-gray-900 shadow-sm border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <x-heroicon-o-user class="h-5 w-5" />
                {{ __('emergency.user_info_title') }}
            </h3>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('emergency.fields.email') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 font-semibold">{{ $foundUser->email }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('emergency.fields.status') }}</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold {{ $foundUser->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $foundUser->active ? __('emergency.status.active') : __('emergency.status.inactive') }}
                        </span>
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('emergency.fields.name') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 font-semibold">
                        {{ $userType == 'company_recruiter'
                            ? ($foundUser->first_name . ' ' . $foundUser->last_name)
                            : ($foundUser->full_name ?? $foundUser->name ?? 'N/A') }}
                    </dd>
                </div>

                @if(isset($foundUser->nic))
                    <div>
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('emergency.fields.nic') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-300 font-semibold">{{ $foundUser->nic }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    @endif

    {{-- Cần thiết để hiển thị Modal của Action --}}
    <x-filament-actions::modals />

    {{-- HIDE THE GLOBAL LOADING BAR ONLY FOR THIS PAGE --}}
    <style>
        /* Chỉ ẩn thanh progress bar toàn cục trên trang emergency */
        .livewire-progress-bar {
            display: none !important;
        }

        /* Optional: Ẩn loading indicator của Filament Action nếu muốn chỉ dùng loading của nút */
        .filament-actions-action-button[wire\:loading] {
            pointer-events: none;
            opacity: 0.7;
        }
    </style>
</x-filament-panels::page>
