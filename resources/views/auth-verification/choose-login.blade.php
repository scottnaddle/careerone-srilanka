@extends('auth.layouts.master')

@section('title', 'Choose login')

@section('content')
    <div class="w-[42rem] px-4 xl:max-w-lg mx-auto py-24 flex justify-center flex-col">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-7 dark:bg-[#1E1E1E]">
            <div class="flex flex-col gap-6">
                <a href="/"
                   class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.homepage') }}
                </a>
                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if(session()->has('success'))
                    <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <p class="text-sm dark:text-white">{{trans('auth.choose_login')}}</p>
                <div class="grid grid-cols-2 gap-6">
{{--                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700">--}}
{{--                        <a href="{{route('trainee.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                            <img src="{{asset('images/trainee.svg')}}" class="w-20 h-20" alt="">--}}
{{--                        </a>--}}
{{--                        <a href="{{route('trainee.auth.login')}}" class="text-sm md:text-xl lg:text-2xl font-semibold hover:text-primary">{{trans('system.trainee')}}</a>--}}
{{--                    </div>--}}
                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
                        <a href="/trainee/cas/login" class="p-6 bg-[#f8faff] rounded-full">
                            <img src="{{asset('images/trainee.webp')}}" class="w-20 h-20" alt="">
                        </a>
                        <a href="/trainee/cas/login" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.trainee')}}</a>
{{--                        <a href="{{route('trainee.auth.login')}}" class="text-sm md:text-xl lg:text-2xl font-semibold hover:text-primary">{{trans('system.trainee')}}</a>--}}
                    </div>
                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
                        <a href="{{route('cgo.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">
                            <img src="{{asset('images/cgo.webp')}}" class="w-20 h-20" alt="">
                        </a>
                        <a href="{{route('cgo.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.cgo')}}</a>
                    </div>
                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
                        <a href="{{route('company.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">
                            <img src="{{asset('images/company.webp')}}" class="w-20 h-20" alt="">
                        </a>
                        <a href="{{route('company.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.company')}}</a>
                    </div>
                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
                        <a href="{{route('filament.admin.auth.login')}}" class="py-6 px-9 bg-[#f8faff] rounded-full">
                            <img src="{{asset('images/admin.png')}}" class="h-20" alt="">
                        </a>
                        <a href="{{route('filament.admin.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.admin')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
