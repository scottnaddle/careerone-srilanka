<div class="mx-auto max-w-2xl w-full">
    <div class="space-y-3">
        <div class="flex flex-col gap-6">
            <a href="/choose-login"
               class="text-gray-900 bg-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.choose_login_title') }}
            </a>

            <a href="/" class="flex items-center rtl:space-x-reverse">
                <img src="{{asset('images/careerone-logo.webp')}}" class="sm:h-8 md:h-12" alt="TVET Logo" />
            </a>
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white leading-9">{{trans('auth.welcome_back')}}</h2>
                <p class="text-base font-normal text-gray-400 dark:text-white leading-6">{{trans('auth.sign_in_to_continue')}}</p>
            </div>
            @if (session()->get('message'))
                <span
                    class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('message') !!}</span>
            @endif

            @if (session()->get('error'))
                <span
                    class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
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
    <style>
        .fi-ac-btn-action {
            border-radius: 9999px !important;
        }
    </style>
</div>
