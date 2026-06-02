@extends('schoolkid.auth.layouts.master')

@section('title', 'Sign In')

@section('content')
    <div class="w-full max-w-md mx-auto py-16 md:py-24 px-4">
        <div class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100/80 dark:border-gray-700 rounded-2xl p-8 md:p-10 space-y-8">
            {{-- Back to choose login --}}
            <a href="/choose-login"
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.choose_login_title') }}
            </a>

            {{-- Logo --}}
            <a href="/" class="flex items-center w-fit">
                <img src="/images/TVET.svg" alt="TVET Logo" class="h-10" />
            </a>

            {{-- Heading --}}
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{trans('auth.welcome_back')}}</h2>
                <p class="text-base text-gray-500 dark:text-gray-400 mt-1">{{trans('auth.sign_in_to_continue')}}</p>
            </div>

            {{-- Session messages --}}
            @if (session()->get('message'))
                <span class="block bg-green-50 text-green-700 text-sm font-medium px-4 py-3 rounded-xl border border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800">{{ session()->get('message') }}</span>
            @endif
            @if (session()->get('error'))
                <span class="block bg-red-50 text-red-700 text-sm font-medium px-4 py-3 rounded-xl border border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800">{{ session()->get('error') }}</span>
            @endif

            {{-- Form --}}
            <form class="space-y-5" action="{{ route('schoolkid.auth.postLogin') }}" method="POST" autocomplete="off">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        {{trans('system.form.email')}}<span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                    @if ($errors->has('email'))
                        <p class="mt-1 text-xs text-red-500">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ trans('system.form.password') }}<span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all pr-12 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                            placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                        <button type="button" id="toggle-password"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="eye-icon-show">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden" id="eye-icon-hide">
                                <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                            </svg>
                        </button>
                    </div>
                    @if ($errors->has('password'))
                        <p class="mt-1 text-xs text-red-500">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                {{-- Forgot password --}}
                <div class="flex items-center justify-end">
                    <a href="{{ route('schoolkid.auth.forgotPassword') }}"
                        class="text-sm font-medium text-primary hover:text-primary/80 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">{{trans('system.form.forgot_password')}}</a>
                </div>

                @if ($errors->has('account_deactivated'))
                    <p class="text-sm text-red-500 text-center">{{ $errors->first('account_deactivated') }}</p>
                @endif

                {{-- Submit --}}
                <button type="submit"
                    class="w-full py-3.5 px-6 text-base font-semibold text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:ring-primary/30 rounded-full transition-all duration-200 shadow-lg shadow-primary/20 dark:bg-blue-600 dark:hover:bg-blue-700">
                    {{trans('auth.sign_in')}}
                </button>

                {{-- Sign up link --}}
                <p class="text-sm text-center text-gray-500 dark:text-gray-400">
                    {{trans('auth.dont_have_account')}}
                    <a href="{{ route('schoolkid.auth.register') }}"
                        class="font-semibold text-primary hover:text-primary/80 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">{{trans('auth.sign_up')}}</a>
                </p>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        $(document).ready(function() {
            // $('#password').on('input', function() {
            //     // Remove all spaces from the input value
            //     this.value = this.value.replace(/\s/g, '');
            // });

            $('#toggle-password').click(function(){
                const passwordInput = $('#password');
                const eyeIconShow = $('#eye-icon-show');
                const eyeIconHide = $('#eye-icon-hide');

                // Toggle password visibility
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    eyeIconShow.addClass('hidden');
                    eyeIconHide.removeClass('hidden');
                } else {
                    passwordInput.attr('type', 'password');
                    eyeIconShow.removeClass('hidden');
                    eyeIconHide.addClass('hidden');
                }
            });
        });
    </script>
@endpush
