@extends('auth.layouts.master')

@section('title', 'Reset Password')

@section('content')
    <div class="flex flex-col gap-2.5 w-full max-w-xl bg-white px-4 md:px-8 py-6 rounded-xl">
        <!-- Logo -->
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <!-- Back button -->
            <a href="{{ route('cgo.auth.forgotPassword') }}"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.forgot_password') }}
            </a>

            <div class="flex flex-col gap-6 mt-4">
                <!-- Left column: Icon and greeting -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/cgo-icon.svg" alt="CGO Icon">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">{{trans('auth.reset_password')}}</h2>
                    <p class="text-primary dark:text-white font-semibold text-center text-base">{{trans('auth.Create a new password for your CGO account.')}}</p>
                </div>

                <!-- Right column: Reset Password form -->
                <div class="w-full flex flex-col items-center justify-center gap-6 md:col-span-2">
                    <form class="w-full flex flex-col gap-4 leading-5" action="{{ route('cgo.auth.postResetPassword') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Session message -->
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

                        <!-- Input: Email (re-confirm email) -->
                        <div>
                            <label for="email" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                {{trans('system.form.enter_your_email_again')}}<span class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                            @if ($errors->has('email'))
                                <span class="text-red-600 text-xs">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <!-- Input: New Password -->
                        <div>
                            <label for="password" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                {{trans('system.form.enter_new_password')}}<span class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                       class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                    <svg id="eye-icon-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg id="eye-icon-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden">
                                        <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                        <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                                    </svg>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-red-600 text-xs">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <!-- Button Reset Password -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                {{trans('system.form.reset_password')}}
                            </button>
                        </div>

                        <!-- Back to login link -->
                        <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-300 mt-2">
                            <a href="{{ route('cgo.auth.login') }}" class="text-primary hover:underline dark:text-blue-500">{{trans('auth.sign_in')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Script for show/hide password
            $('#toggle-password').click(function() {
                const passwordInput = $('#password');
                const eyeIconShow = $('#eye-icon-show');
                const eyeIconHide = $('#eye-icon-hide');

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

            // Script to strip whitespace when typing the password (keeps old logic)
            $('#password').on('input', function() {
                this.value = this.value.replace(/\s/g, '');
            });
        });
    </script>
@endpush
