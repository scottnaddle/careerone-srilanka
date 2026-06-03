@extends('cgo.auth.layouts.master')

@section('title', 'Verify your account')

@section('content')
    <div class="flex flex-col gap-2.5 w-full max-w-xl bg-white px-4 md:px-8 py-6 rounded-xl dark:bg-[#1E1E1E]">
        <!-- Logo -->
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <!-- Nút Sign Out (Style giống nút Back) -->
            <a href="{{ route($u_type.'.auth.logout') }}"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.sign_out') }}
            </a>

            <div class="grid grid-cols-1 gap-6 mt-4">
                <!-- Cột trái: Icon và lời chào -->
                <div class="flex flex-col items-center justify-center gap-4">
{{--                    <img src="/images/cgo-icon.svg" alt="CGO Icon">--}}
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">Verify your account</h2>
                    <p class="text-primary dark:text-white font-semibold text-center text-base">Your account is not verified.</p>
                </div>

                <!-- Cột phải: Form Xác thực -->
                <div class="w-full flex flex-col items-center justify-center gap-6 md:col-span-2">

                    <form class="w-3/4 lg:w-1/2 flex flex-col gap-4 leading-5" action="{{ route('resend_verification') }}" method="GET" autocomplete="off">
                        <!-- Inputs Ẩn -->
                        <input type="text" name="u_type" value="{{$u_type}}" class="hidden">
                        <input type="text" name="token" value="{{$token}}" class="hidden">

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

                        <!-- Input: Radio Group -->
                        <div class="flex flex-col items-center">
                            <label for="verify_method"
                                   class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                {{trans('auth.choose_verification_method')}}<span class="text-red-600 p-1 text-center">*</span>
                            </label>

                            <div class="flex gap-6 mt-2">
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="verification_method" value="email"
                                           class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-[#1E1E1E] dark:border-gray-500 dark:checked:bg-blue-500 dark:checked:border-blue-500"
                                           id="hs-radio-group-1" required />
                                    <label for="hs-radio-group-1"
                                           class="text-sm text-gray-900 ms-3 dark:text-gray-300">{{trans('system.form.email')}}</label>
                                </div>
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="verification_method" value="sms"
                                           class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-[#1E1E1E] dark:border-gray-500 dark:checked:bg-blue-500 dark:checked:border-blue-500"
                                           id="hs-radio-group-2" required />
                                    <label for="hs-radio-group-2"
                                           class="text-sm text-gray-900 ms-3 dark:text-gray-300">{{trans('system.form.sms')}}</label>
                                </div>
                            </div>

                            @if ($errors->has('verification_type'))
                                <span class="text-red-600 text-xs mt-2">{{ $errors->first('verification_type') }}</span>
                            @endif
                        </div>

                        <!-- Button Gửi -->
                        <div class="pt-4 w-full flex justify-center">
                            <button type="submit"
                                    class="w-1/2 text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                {{trans('auth.active')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
