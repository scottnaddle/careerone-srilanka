@extends('auth.layouts.master')

@section('title', 'Verify your account')

@section('content')
    <div class="max-w-lg mx-auto w-screen py-24">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md border space-y-6 border-gray-200 rounded-xl px-10 py-5">
            <div class="flex flex-col gap-6">
                <a href="{{ route($u_type.'.auth.logout') }}"
                    class="text-gray-900 bg-white border-gray-200 font-medium rounded-xl sm:text-sm w-fit text-center inline-flex items-center">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m15 19-7-7 7-7" />
                    </svg>
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('auth.sign_out')}}</span>
                </a>
                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
{{--                <p class="text-center">{{trans('auth.not_active')}}</p>--}}
                <p class="text-center">Your account is not verified</p>
                <form action="{{ route('resend_verification') }}" method="get">
                    <input type="text" name="u_type" value="{{$u_type}}" class="hidden">
                    <input type="text" name="token" value="{{$token}}" class="hidden">
                    <div class="flex mb-4 justify-center flex-col items-center">
                        <label for="verify_method"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('auth.choose_verification_method')}}<span class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="flex gap-6">
                            <div class="flex items-center justify-center">
                                <input type="radio" name="verification_method" value="email"
                                       class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                       id="hs-radio-group-1" required />
                                <label for="hs-radio-group-1"
                                       class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{trans('system.form.email')}}</label>
                            </div>
                            <div class="flex items-center justify-center">
                                <input type="radio" name="verification_method" value="sms"
                                       class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                       id="hs-radio-group-2" required />
                                <label for="hs-radio-group-2"
                                       class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{trans('system.form.sms')}}</label>
                            </div>
                        </div>

                        @if ($errors->has('verification_type'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('verification_type') }}</span>
                        @endif
                    </div>
                    <button type="submit"
                       class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('auth.active')}}
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
