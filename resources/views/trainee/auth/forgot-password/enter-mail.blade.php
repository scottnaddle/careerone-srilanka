@extends('auth.layouts.master')

@section('title', 'Reset password')

@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-lg mx-auto w-screen py-24">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-5">
            <div class="flex flex-col gap-6">
                <a href="{{ route('trainee.auth.login') }}"
                    class="text-gray-900 dark:text-white border-gray-200 font-medium rounded-xl text-sm w-fit text-center inline-flex items-center">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m15 19-7-7 7-7" />
                    </svg>
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('auth.trainee_sign_in')}}</span>
                </a>

                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.png')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.png')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if (session()->get('message'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium me-2 px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('message') !!}</span>
                @endif
                @if (session()->get('error'))
                    <span
                        class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
                @endif

                <form action="{{ route('trainee.auth.postForgotPassword') }}" class="leading-5" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="email"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.enter_your_email')}}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="bg-gray-50 border py-2 px-3 pl-4 h-9 w-full border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('email'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <span id="countdown" class="text-sm text-gray-500"></span>
                    <button type="submit" id="resend-button"
                        class="w-full text-white bg-[#4984F6] mt-2 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.send_reset_password_link')}}
                    </button>
                </form>
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
            var $resendButton = $('#resend-button');
            var countdownInterval;

            function updateCountdown() {
                $countdownElement.text('Resend link after ' + countdownTime + ' seconds');
                countdownTime--;

                if (countdownTime < 0) {
                    clearInterval(countdownInterval);
                    $resendButton.removeClass('disabled-button');
                    $countdownElement.text('');
                    $resendButton.prop('disabled', false); // re-enable the button
                }
            }

            @if (session()->get('message') || session()->get('error'))
                $resendButton.addClass('disabled-button');
                $resendButton.prop('disabled', true); // disable the button
                updateCountdown();
                countdownInterval = setInterval(updateCountdown, 1000);
            @endif
        });
    </script>
@endpush
