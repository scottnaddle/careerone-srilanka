<div class="mx-auto max-w-2xl w-full">
    <div class="space-y-3">
        <div class="flex flex-col gap-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            {{-- Admin accent header --}}
            <div class="bg-gradient-to-r from-slate-700 to-slate-900 px-8 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Administrator</h2>
                        <p class="text-sm text-white/60">TVEC CareerOne — Admin Panel</p>
                    </div>
                </div>
            </div>

            <div class="px-8 pb-6">
            <a href="/choose-login"
               class="text-gray-900 bg-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.choose_login_title') }}
            </a>

            <a href="/" class="flex items-center rtl:space-x-reverse mt-4">
                <img src="{{asset('images/careerone-logo.webp')}}" class="sm:h-8 md:h-10" alt="Careerone Logo" />
            </a>

            @if (session()->get('message'))
                <span class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('message') !!}</span>
            @endif

            @if (session()->get('error'))
                <span class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
            @endif
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form }}
                <x-filament::link
                    :href="filament()->getRequestPasswordResetUrl()" class=" text-gray-500 hover:underline ml-auto dark:text-blue-500">
                    {{ trans('system.form.forgot_password') }}
                </x-filament::link>
                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
                <div class="font-medium text-center text-gray-500 dark:text-gray-300">
                    {{ trans('auth.dont_have_account') }} <a href="/admin/auth/register" class="text-blue-700 hover:underline dark:text-blue-500">{{trans('auth.sign_up')}}</a>
                </div>
            </x-filament-panels::form>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
            </div>
        </div>
    </div>
    <style>
        .fi-ac-btn-action {
            border-radius: 9999px !important;
        }
    </style>
</div>
