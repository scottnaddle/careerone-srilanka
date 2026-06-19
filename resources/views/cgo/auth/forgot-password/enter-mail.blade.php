@extends('auth.layouts.master')

@section('title', 'Forgot Password')

@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
@endpush

@section('content')
    <div class="flex flex-col gap-2.5 w-full max-w-xl bg-white px-4 md:px-8 py-6 rounded-xl dark:bg-[#1E1E1E]">
        <!-- Logo -->
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <!-- Back button -->
            <a href="{{ route('cgo.auth.login') }}"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.cgo_sign_in') }}
            </a>

            <div class="flex flex-col gap-6 mt-4">
                <!-- Left column: Icon and greeting -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/cgo-icon.svg" alt="CGO Icon">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">{{ trans('auth.forgot_password') }}</h2>
                    <p class="text-white dark:text-white font-semibold text-center text-base">{{trans('auth.Reset your CGO account password.')}}</p>
                </div>

                <!-- Right column: Forgot Password form -->
                <div class="w-full flex flex-col items-center justify-center gap-6 md:col-span-2">
                    <form class="w-full flex flex-col gap-4 leading-5" action="{{ route('cgo.auth.postForgotPassword') }}" method="POST" autocomplete="off">
                        @csrf

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

                        <!-- Input: Email -->
                        <div>
                            <label for="email" class="text-sm font-medium text-[#404040] dark:text-white block mb-1">
                                {{ trans('system.form.enter_your_email') }}<span class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                            @if ($errors->has('email'))
                                <span class="text-red-600 text-xs">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <!-- Countdown Timer -->
                        <div id="countdown" class="text-sm text-gray-500 dark:text-gray-400"></div>

                        <!-- Button Send Reset Link -->
                        <div class="pt-4">
                            <button type="submit" id="send-button"
                                    class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                {{ trans('system.form.send_reset_password_link') }}
                            </button>
                        </div>

                        <!-- Back to login link -->
                        <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-300 mt-2">
                            <a href="{{ route('cgo.auth.login') }}" class="text-primary hover:underline dark:text-blue-500">{{ trans('auth.sign_in') }}</a>
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
            var countdownTime = 60; // seconds
            var $countdownElement = $('#countdown');
            var $sendButton = $('#send-button');
            var countdownInterval;

            function startCountdown() {
                $sendButton.addClass('disabled-button');
                $sendButton.prop('disabled', true);

                function updateCountdown() {
                    if (countdownTime >= 0) {
                        $countdownElement.text('Resend link after ' + countdownTime + ' seconds');
                        countdownTime--;
                    } else {
                        clearInterval(countdownInterval);
                        $sendButton.removeClass('disabled-button');
                        $countdownElement.text('');
                        $sendButton.prop('disabled', false);
                        countdownTime = 60; // Reset for next time
                    }
                }

                updateCountdown();
                countdownInterval = setInterval(updateCountdown, 1000);
            }

            @if (session()->get('message') || session()->get('error'))
            startCountdown();
            @endif
        });
    </script>
@endpush
