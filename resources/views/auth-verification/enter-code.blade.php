@extends('auth.layouts.master')

@section('title', 'Verify Account')

@push('css')
    <style>
        .disabled-link {
            pointer-events: none;
            color: gray;
        }

        .disabled-button {
            pointer-events: none;
            background-color: gray;
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
            <!-- Sign Out button (styled like the Back button) -->
            <a href="{{ route($u_type.'.auth.logout') }}"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.sign_out') }}
            </a>

            <div class="grid grid-cols-1 gap-6 mt-4">
                <!-- Left column: Icon and greeting -->
                <div class="flex flex-col items-center justify-center gap-4">
{{--                    <img src="/images/cgo-icon.svg" alt="CGO Icon">--}}
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">{{trans('auth.verify_your_account')}}</h2>
                    <p class="text-primary dark:text-white font-semibold text-center text-base">Enter the verification code.</p>
                </div>

                <!-- Right column: Code entry form -->
                <div class="w-full flex flex-col items-center justify-center gap-6 md:col-span-2">

                    <form class="w-full flex flex-col gap-4 leading-5" action="{{ route('verification') }}" method="POST" autocomplete="off">
                        @csrf
                        <!-- Hidden inputs -->
                        <input class="sr-only hidden" name="u_type" value="{{ $u_type }}" />
                        <input class="sr-only hidden" name="token" value="{{ $token }}" />
                        <input class="sr-only hidden" name="verification_method" value="{{ $verification_method }}" />

                        <!-- Session message (Optional) -->
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

                        <!-- Input: Enter Code -->
                        <div>
                            <label for="code"
                                   class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                {{trans('auth.enter_code_message')}}<span class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <input type="text" name="code" id="code" required
                                   class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                            @if ($errors->has('code'))
                                <span class="text-red-600 text-xs mt-1">{{ $errors->first('code') }}</span>
                            @endif
                        </div>

                        <!-- Countdown and Resend code -->
                        <div class="flex items-center">
                            <a href="#" id="resend-link"
                               class="text-sm text-primary hover:underline dark:text-blue-500">{{trans('auth.resend_code')}}</a>
                            <span id="countdown" class="ml-2 text-sm text-gray-500"></span>
                        </div>

                        <!-- Verify button -->
                        <div class="pt-4">
                            <button type="submit" id="disabled-button"
                                    class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                {{trans('auth.active')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script >
        $(document).ready(function() {
            let countdownTime = 30;
            let $countdownElement = $('#countdown');
            let $resendLink = $('#resend-link');
            let countdownInterval;

            function updateCountdown() {
                $countdownElement.text('(' + countdownTime + 's)');
                countdownTime--;

                if (countdownTime < 0) {
                    clearInterval(countdownInterval);
                    $resendLink.removeClass('disabled-link');
                    $countdownElement.text('');
                }
            }

            // Initial disable
            $resendLink.addClass('disabled-link');
            countdownInterval = setInterval(updateCountdown, 1000);

            $('#resend-link').on('click', function(e) {
                e.preventDefault();

                if (countdownTime > 0) {
                    return; // Prevent resending if countdown is still active
                }

                $('#resend-link').addClass('disabled-link');
                countdownTime = 30; // Reset countdown time
                countdownInterval = setInterval(updateCountdown, 1000);

                let u_type = $('input[name="u_type"]').val();
                let token = $('input[name="token"]').val();
                let verification_method = $('input[name="verification_method"]').val();

                // Send Ajax request
                $.ajax({
                    url: '{{route('resend_verification')}}',
                    method: 'GET',
                    'data': {
                        'u_type' : u_type,
                        'token' : token,
                        'verification_method' : verification_method,
                    },
                    success: function(response) {
                        Toastify({
                            text: "{{trans('auth.resend_code_success_message')}}",
                            duration: 2000,
                            className: "infor",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            }
                        }).showToast();
                        // Handle response if necessary
                    },
                    error: function(xhr) {
                        Toastify({
                            text: "{{trans('auth.resend_code_fail_message')}}, "+xhr.statusText,
                            duration: 2000,
                            className: "error",
                            style: {
                                background: "#e74c3c",
                            }
                        }).showToast();
                        // Handle error if necessary
                    }
                });
            });
        });
    </script>
@endpush
