{{--
-- Variables:
--   $route        (string) POST route name for form action
--   $logo         (string) path to primary logo (with or without asset())
--   $darkBg       (string) dark mode background class(es), e.g. 'dark:bg-gray-800'
--   $darkBorder   (string) dark mode border class(es), e.g. 'dark:border-gray-700'
--   $submitMb     (string) bottom margin class on submit button, e.g. 'mb-4'
--   $logoDark     (string|null) optional path to dark-mode logo variant
--   $forgotRoute  (string) route name for \"forgot password\" link
--   $registerRoute(string) route name for registration link
--   $title        (string|null) optional override for \"Sign In\" section title
--   $userType     (string) user type for social login: trainee|company|cgo
--}}
<div class=\"bg-white shadow-md border space-y-6 border-gray-200 rounded-xl px-10 py-5 {{ $darkBg }} {{ $darkBorder }}\">
    <div class=\"flex flex-col gap-6\">
        <a href=\"/choose-login\"
           class=\"text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary\">
            <svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" class=\"size-5\">
                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15.75 19.5 8.25 12l7.5-7.5\" />
            </svg>
            {{ trans('auth.choose_login_title') }}
        </a>

        <a href=\"/\" class=\"flex items-center rtl:space-x-reverse w-fit\">
            @if (!empty($logoDark))
                <img src=\"{{ asset($logo) }}\" class=\"h-8 md:h-12 block dark:hidden\" alt=\"Logo\" />
                <img src=\"{{ asset($logoDark) }}\" class=\"h-8 md:h-12 hidden dark:block\" alt=\"Logo\" />
            @else
                <img src=\"{{ $logo }}\" alt=\"Logo\" />
            @endif
        </a>

        <div>
            <h1 class=\"text-2xl font-semibold text-gray-900 dark:text-white leading-9\">
                {{ $title ?? trans('auth.welcome_back') }}
            </h1>
            <p class=\"text-base font-normal text-gray-400 dark:text-white leading-6\">{{ trans('auth.sign_in_to_continue') }}</p>
        </div>

        @if (session()->get('message'))
            <span class=\"bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400\">{!! session()->get('message') !!}</span>
        @endif

        @if (session()->get('error'))
            <span class=\"bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400\">{!! session()->get('error') !!}</span>
        @endif

        <form class=\"leading-5\" action=\"{{ route($route) }}\" method=\"POST\" autocomplete=\"off\">
            @csrf

            {{-- Google Login --}}
            <a href=\"{{ route('social.redirect', ['user_type' => $userType ?? 'trainee']) }}\"
                class=\"w-full flex items-center justify-center gap-3 h-12 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors mb-6 font-medium text-gray-700 dark:text-gray-300\">
                <svg class=\"w-5 h-5\" viewBox=\"0 0 24 24\">
                    <path fill=\"#4285F4\" d=\"M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z\"/>
                    <path fill=\"#34A853\" d=\"M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z\"/>
                    <path fill=\"#FBBC05\" d=\"M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z\"/>
                    <path fill=\"#EA4335\" d=\"M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z\"/>
                </svg>
                {{ __('auth.continue_with_google') }}
            </a>

            <div class=\"relative mb-6\">
                <div class=\"absolute inset-0 flex items-center\"><div class=\"w-full border-t border-gray-200 dark:border-gray-600\"></div></div>
                <div class=\"relative flex justify-center text-sm\"><span class=\"px-3 bg-white dark:bg-[#1E1E1E] text-gray-500\">{{ __('auth.or_continue_with_email') }}</span></div>
            </div>

            <div class=\"mb-6\">
                <label for=\"email\"
                    class=\"text-normal font-medium text-[#706F81] block mb-1.5 dark:text-gray-300 leading-6\">
                    {{ trans('system.form.email') }}<span class=\"text-red-600 p-1 text-center\">*</span>
                </label>
                <input type=\"text\" name=\"email\" id=\"email\" autocomplete=\"email\"
                    class=\"bg-gray-50 border border-gray-300 py-2 px-4 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full {{ $darkBg }} {{ $darkBorder }} dark:placeholder-gray-400 dark:text-white\">
                @if ($errors->has('email'))
                    <span class=\"text-red-600 text-xs p-0 m-0\">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class=\"mb-3\">
                <label for=\"password\"
                    class=\"text-normal font-medium text-gray-500 block mb-1.5 dark:text-gray-300 leading-6\">
                    {{ trans('system.form.password') }}<span class=\"text-red-600 p-1 text-center\">*</span>
                </label>
                <div class=\"relative\">
                    <input type=\"password\" name=\"password\" id=\"password\" autocomplete=\"current-password\"
                        class=\"bg-gray-50 border border-gray-300 py-2 px-4 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-1 {{ $darkBg }} {{ $darkBorder }} dark:placeholder-gray-400 dark:text-white\">
                    <button type=\"button\" id=\"toggle-password\" class=\"absolute inset-y-0 right-0 flex items-center pr-3 dark:text-white\" aria-label=\"Show password\">
                        <svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" class=\"w-5 h-5\" id=\"eye-icon-show\">
                            <path d=\"M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z\"></path>
                            <path fill-rule=\"evenodd\" d=\"M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z\" clip-rule=\"evenodd\"></path>
                        </svg>
                        <svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" class=\"w-5 h-5 hidden\" id=\"eye-icon-hide\">
                            <path fill-rule=\"evenodd\" d=\"M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z\" clip-rule=\"evenodd\"></path>
                            <path d=\"m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z\"></path>
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <span class=\"text-red-600 text-xs p-0 m-0\">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class=\"flex items-start mb-6\">
                <a href=\"{{ route($forgotRoute) }}\"
                    class=\"text-sm text-primary hover:underline ml-auto dark:text-blue-500\">{{ trans('system.form.forgot_password') }}</a>
            </div>

            @if ($errors->has('account_deactivated'))
                <span class=\"text-red-600 p-0 m-0 text-center\">{{ $errors->first('account_deactivated') }}</span>
            @endif

            <button type=\"submit\"
                class=\"w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 {{ $submitMb }}\">{{ trans('auth.sign_in') }}
            </button>

            <div class=\"text-center mt-3\">
                <a href=\"{{ route('magic-link.form') }}\"
                    class=\"text-sm text-gray-500 hover:text-[#4984F6] dark:text-gray-400 dark:hover:text-blue-400 underline underline-offset-4 transition-colors\">
                    {{ __('auth.login_with_magic_link') }}
                </a>
            </div>

            <div class=\"text-sm font-medium text-center text-gray-500 dark:text-gray-300 mt-4\">
                {{ trans('auth.dont_have_account') }} <a href=\"{{ route($registerRoute) }}\"
                    class=\"text-primary hover:underline dark:text-blue-500\">{{ trans('auth.sign_up') }}</a>
            </div>
        </form>
    </div>
</div>
