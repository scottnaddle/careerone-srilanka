<div class="max-w-xl mx-auto px-4 md:px-8 bg-white dark:bg-[#1E1E1E] py-6 rounded-xl my-6">

    <div class="flex flex-col gap-2.5 w-full">
        <!-- Logo -->
        <a href="/" class="flex w-full justify-start">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <!-- Nút Back -->
            <a href="/choose-login"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.choose_login_title') }}
            </a>

            <div class="flex flex-col gap-6 mt-4">
                <!-- Cột trái: Icon và lời chào -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/admin.svg" alt="Admin Icon">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">{{trans('auth.welcome_back')}}</h2>
                    <p class="text-primary dark:text-white font-semibold text-center text-base">{{trans('auth.sign_in_to_continue')}}</p>
                </div>

                <!-- Cột phải: Form Filament -->
                <div class="w-full flex flex-col items-center justify-center gap-6 md:col-span-2">

                    <div class="w-full flex flex-col gap-4 leading-5">

                        <!-- Thông báo Session -->
                        @if (session()->get('message'))
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-3 rounded-xl dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">
                                {!! session()->get('message') !!}
                            </span>
                        @endif

                        @if (session()->get('error'))
                            <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-3 rounded-xl dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">
                                {!! session()->get('error') !!}
                            </span>
                        @endif

                        <!-- Filament Form Hooks Before -->
                        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                        <!-- Form Chính -->
                        <x-filament-panels::form wire:submit="authenticate" class="flex flex-col gap-4">

                            {{ $this->form }}

                            <!-- Quên mật khẩu -->
                            <div class="flex justify-end mt-1">
                                <x-filament::link
                                    :href="filament()->getRequestPasswordResetUrl()"
                                    class="text-sm font-normal text-primary hover:underline ml-auto dark:text-blue-500">
                                    {{ trans('system.form.forgot_password') }}
                                </x-filament::link>
                            </div>

                            <!-- Button Đăng nhập -->
                            <div class="pt-2">
                                <x-filament-panels::form.actions
                                    :actions="$this->getCachedFormActions()"
                                    :full-width="$this->hasFullWidthFormActions()"
                                />
                            </div>

                            <!-- Link Đăng ký -->
                            <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-300 mt-2">
                                {{ trans('auth.dont_have_account') }}
                                <a href="/admin/auth/register" class="text-primary hover:underline dark:text-blue-500">{{trans('auth.sign_up')}}</a>
                            </div>

                        </x-filament-panels::form>

                        <!-- Filament Form Hooks After -->
                        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cấu hình CSS ghi đè nút mặc định của Filament -->
    <style>
        .fi-ac-btn-action {
            border-radius: 0.75rem !important; /* Tailwind: rounded-xl */
            padding-top: 0.75rem !important; /* Tailwind: py-3 */
            padding-bottom: 0.75rem !important;
            font-size: 1.25rem !important; /* Tailwind: text-xl */
            background-color: #4984F6 !important; /* Màu xanh chủ đạo của hệ thống */
            box-shadow: none !important;
            border: none !important;
        }

        .fi-ac-btn-action:hover {
            background-color: #1e40af !important; /* Tailwind: hover:bg-blue-800 */
        }

        .dark .fi-ac-btn-action {
            background-color: #2563eb !important; /* Tailwind: dark:bg-blue-600 */
        }

        .dark .fi-ac-btn-action:hover {
            background-color: #1d4ed8 !important; /* Tailwind: dark:hover:bg-blue-700 */
        }

        .fi-ac-btn-action span {
            font-weight: 500 !important;
            color: white !important;
        }
        .fi-simple-main {
            margin: 0px auto !important;
            max-width: unset !important;
            border-radius: 0 !important;
            border: 0 !important;
            box-shadow: unset !important;
            background: unset !important;
        }
        .fi-simple-main-ctn {
            align-items: start !important;
        }
        .fi-input {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        a.fi-link > span{
            font-weight: 400 !important;
        }
        .fi-simple-layout {
            background-image: url(/images/bg-auth.webp);
            background-size: cover;
        }
    </style>

</div>
