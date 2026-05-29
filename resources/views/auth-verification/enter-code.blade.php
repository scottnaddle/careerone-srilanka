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
    <div class="max-w-lg mx-auto w-screen py-24">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md  space-y-6 border-gray-200 rounded-xl px-10 py-5">
            <div class="flex flex-col gap-6">
{{--                @if (Auth::guard('admin'))--}}
                    <a href="{{ route($u_type.'.auth.logout') }}"
                        class="text-gray-900 dark:text-white border-gray-200 font-medium rounded-xl sm:text-sm w-fit text-center inline-flex items-center">
                        <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m15 19-7-7 7-7" />
                        </svg>
                        <span class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('auth.sign_out')}}</span>
                    </a>
{{--                @elseif(Auth::guard('cgo'))--}}
{{--                    <a href="{{ route('cgo.auth.logout') }}"--}}
{{--                        class="text-gray-900 bg-white border-gray-200 font-medium rounded-xl sm:text-sm w-fit text-center inline-flex items-center">--}}
{{--                        <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"--}}
{{--                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"--}}
{{--                            viewBox="0 0 24 24">--}}
{{--                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                d="m15 19-7-7 7-7" />--}}
{{--                        </svg>--}}
{{--                        <span class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('auth.sign_out')}}</span>--}}
{{--                    </a>--}}
{{--                @elseif(Auth::guard('company'))--}}
{{--                    <a href="{{ route('company.auth.logout') }}"--}}
{{--                       class="text-gray-900 bg-white border-gray-200 font-medium rounded-xl sm:text-sm w-fit text-center inline-flex items-center">--}}
{{--                        <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"--}}
{{--                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"--}}
{{--                             viewBox="0 0 24 24">--}}
{{--                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                  d="m15 19-7-7 7-7" />--}}
{{--                        </svg>--}}
{{--                        <span class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('auth.sign_out')}}</span>--}}
{{--                    </a>--}}
{{--                @endif--}}
                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="/images/careerone-logo.webp" class="sm:h-8 md:h-12" alt="CareerOne Logo" />
                </a>
                <p class="text-xl font-semibold text-gray-900 dark:text-white text-center">{{trans('auth.verify_your_account')}}</p>
                {{-- @if (session()->get('message'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium me-2 px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('message') !!}</span>
                @endif

                @if (session()->get('error'))
                    <span
                        class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
                @endif --}}

                <form action="{{ route('verification') }}" class="leading-5" method="POST">
                    @csrf
                    <input class="sr-only hidden" name="u_type" value="{{ $u_type }}" />
                    <input class="sr-only hidden" name="token" value="{{ $token }}" />
                    <input class="sr-only hidden" name="verification_method" value="{{ $verification_method }}" />
                    <div class="mb-6">
                        <label for="code"
                            class="sm:text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('auth.enter_code_message')}}<span class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="code" id="code"
                            class="bg-gray-50 border p-3 pl-4 h-9 w-full border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" required>
                        @if ($errors->has('code'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                    <div class="flex items-start mb-6">
                        <a href="#" id="resend-link"
                            class="text-sm text-primary hover:underline ml-auto dark:text-blue-500">{{trans('auth.resend_code')}}</a>
                        <span id="countdown" class="ml-2 text-sm text-primary text-gray-500"></span>

                    </div>
                    <button type="submit" id="disabled-button"
                        class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('auth.active')}}
                    </button>
                </form>
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
