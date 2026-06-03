<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
    <base href="{{ asset('/') }}">
    <script src="{{ asset('/firebase-messaging-sw.js') }}"></script>
    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging.js";

        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);
        if (Notification.permission === 'default' || Notification.permission === 'denied') {
            Notification.requestPermission().then((permission) => {

            }).catch((error) => {

            });
        }
        const tokenFCMFirebase = sessionStorage.getItem('fcmToken');


        getToken(messaging, {
            vapidKey: '{{ env('YOUR_PUBLIC_VAPID_KEY_HERE') }}'
        }).then((currentToken) => {
            if (currentToken) {
                sessionStorage.setItem('fcmToken', currentToken);
                save_token_firebase_to_session(currentToken);
            } else {
            }
        })
    </script>
</head>

<body class="bg-custom flex justify-center items-center bg-cover bg-center bg-fixed relative px-4">
<div class=" flex flex-col justify-center items-center gap-6 lg:gap-12 my-12 w-full max-w-xl bg-white dark:bg-[#1E1E1E] px-4 md:px-8 py-6 rounded-xl ">
    <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
        <img src="{{asset('/images/careerone-logo.webp')}}" class="h-10 md:h-12 block dark:hidden" alt="Careerone Logo" />
        <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-10 md:h-12 hidden dark:block" alt="Careerone Logo" />
    </a>
    <div class="flex flex-col gap-3 text-center">
        <p class="text-3xl text-gray-900 font-semibold dark:text-white">{{trans('auth.Welcome')}}</p>
        <p class="text-lg text-primary dark:text-white ">{{trans('auth.Select your role to get started')}}</p>
    </div>
    <div class="grid grid-cols-2 gap-4 md:gap-6">
        <div class="bg-gray-50 flex flex-col items-center px-2 py-4 lg:px-4 lg:py-6 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
            <a href="{{ route('trainee.auth.login') }}" class="p-6 bg-[#f8faff] rounded-full">
                <img src="{{asset('images/trainee.webp')}}" class="w-20 h-20" alt="">
            </a>
            <a href="{{ route('trainee.auth.login') }}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px] dark:hover:text-primary">{{trans('system.trainee')}}</a>
            {{--                        <a href="{{route('trainee.auth.login')}}" class="text-sm md:text-xl lg:text-2xl font-semibold hover:text-primary">{{trans('system.trainee')}}</a>--}}
        </div>
        <div class="bg-white flex flex-col items-center px-2 py-4 lg:px-5 lg:py-8 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
            <a href="{{route('cgo.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">
                <img src="{{asset('images/cgo.webp')}}" class="w-20 h-20" alt="">
            </a>
            <a href="{{route('cgo.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px] dark:hover:text-primary">{{trans('system.cgo')}}</a>
        </div>
        <div class="bg-white flex flex-col items-center px-2 py-4 lg:px-5 lg:py-8 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
            <a href="{{route('company.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">
                <img src="{{asset('images/company.webp')}}" class="w-20 h-20" alt="">
            </a>
            <a href="{{route('company.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px] dark:hover:text-primary">{{trans('system.company')}}</a>
        </div>
        <div class="bg-white flex flex-col items-center px-2 py-4 lg:px-5 lg:py-8 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">
            <a href="{{route('filament.admin.auth.login')}}" class="py-6 px-4 bg-[#f8faff] rounded-full">
                <img src="{{asset('images/admin.svg')}}" class="h-20" alt="">
            </a>
            <a href="{{route('filament.admin.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px] dark:hover:text-primary">{{trans('system.admin')}}</a>
        </div>
    </div>
</div>
</body>
</html>
{{--    <div class="max-w-[1440px] mx-auto h-[100vh]">--}}
{{--        <div class="mx-auto content-center flex items-start h-full">--}}
{{--        <div class="w-[42rem] px-4 xl:max-w-lg mx-auto py-24 flex justify-center flex-col">--}}
{{--            <div--}}
{{--                class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-7 dark:bg-[#1E1E1E]">--}}
{{--                <div class="flex flex-col gap-6">--}}
{{--                    <a href="/"--}}
{{--                       class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />--}}
{{--                        </svg>--}}
{{--                        {{ trans('auth.homepage') }}--}}
{{--                    </a>--}}
{{--                    <a href="/" class="flex items-center rtl:space-x-reverse w-fit">--}}
{{--                        <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />--}}
{{--                        <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />--}}
{{--                    </a>--}}
{{--                    @if(session()->has('success'))--}}
{{--                        <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">--}}
{{--                            {{ session()->get('success') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <p class="text-sm dark:text-white">{{trans('auth.choose_login')}}</p>--}}
{{--                    <div class="grid grid-cols-2 gap-6">--}}
{{--                        <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                            <a href="/trainee/cas/login" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                                <img src="{{asset('images/trainee.webp')}}" class="w-20 h-20" alt="">--}}
{{--                            </a>--}}
{{--                            <a href="/trainee/cas/login" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.trainee')}}</a>--}}
{{--    --}}{{--                        <a href="{{route('trainee.auth.login')}}" class="text-sm md:text-xl lg:text-2xl font-semibold hover:text-primary">{{trans('system.trainee')}}</a>--}}
{{--                        </div>--}}
{{--                        <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                            <a href="{{route('cgo.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                                <img src="{{asset('images/cgo.webp')}}" class="w-20 h-20" alt="">--}}
{{--                            </a>--}}
{{--                            <a href="{{route('cgo.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.cgo')}}</a>--}}
{{--                        </div>--}}
{{--                        <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                            <a href="{{route('company.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                                <img src="{{asset('images/company.webp')}}" class="w-20 h-20" alt="">--}}
{{--                            </a>--}}
{{--                            <a href="{{route('company.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.company')}}</a>--}}
{{--                        </div>--}}
{{--                        <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                            <a href="{{route('filament.admin.auth.login')}}" class="py-6 px-9 bg-[#f8faff] rounded-full">--}}
{{--                                <img src="{{asset('images/admin.png')}}" class="h-20" alt="">--}}
{{--                            </a>--}}
{{--                            <a href="{{route('filament.admin.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.admin')}}</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--@extends('cgo.auth.layouts.master')--}}

{{--@section('title', 'Choose login')--}}

{{--@section('content')--}}
{{--    <div class="w-[42rem] px-4 xl:max-w-lg mx-auto py-24 flex justify-center flex-col">--}}
{{--        <div--}}
{{--            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-7 dark:bg-[#1E1E1E]">--}}
{{--            <div class="flex flex-col gap-6">--}}
{{--                <a href="/"--}}
{{--                   class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />--}}
{{--                    </svg>--}}
{{--                    {{ trans('auth.homepage') }}--}}
{{--                </a>--}}
{{--                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">--}}
{{--                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />--}}
{{--                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />--}}
{{--                </a>--}}
{{--                @if(session()->has('success'))--}}
{{--                    <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">--}}
{{--                        {{ session()->get('success') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <p class="text-sm dark:text-white">{{trans('auth.choose_login')}}</p>--}}
{{--                <div class="grid grid-cols-2 gap-6">--}}
{{--                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700">--}}
{{--                        <a href="{{route('trainee.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                            <img src="{{asset('images/trainee.svg')}}" class="w-20 h-20" alt="">--}}
{{--                        </a>--}}
{{--                        <a href="{{route('trainee.auth.login')}}" class="text-sm md:text-xl lg:text-2xl font-semibold hover:text-primary">{{trans('system.trainee')}}</a>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                        <a href="/trainee/cas/login" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                            <img src="{{asset('images/trainee.webp')}}" class="w-20 h-20" alt="">--}}
{{--                        </a>--}}
{{--                        <a href="/trainee/cas/login" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.trainee')}}</a>--}}
{{--                        <a href="{{route('trainee.auth.login')}}" class="text-sm md:text-xl lg:text-2xl font-semibold hover:text-primary">{{trans('system.trainee')}}</a>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                        <a href="{{route('cgo.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                            <img src="{{asset('images/cgo.webp')}}" class="w-20 h-20" alt="">--}}
{{--                        </a>--}}
{{--                        <a href="{{route('cgo.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.cgo')}}</a>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                        <a href="{{route('company.auth.login')}}" class="p-6 bg-[#f8faff] rounded-full">--}}
{{--                            <img src="{{asset('images/company.webp')}}" class="w-20 h-20" alt="">--}}
{{--                        </a>--}}
{{--                        <a href="{{route('company.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.company')}}</a>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col items-center px-6 py-3 gap-5 rounded-2xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700 dark:bg-gray-800">--}}
{{--                        <a href="{{route('filament.admin.auth.login')}}" class="py-6 px-9 bg-[#f8faff] rounded-full">--}}
{{--                            <img src="{{asset('images/admin.png')}}" class="h-20" alt="">--}}
{{--                        </a>--}}
{{--                        <a href="{{route('filament.admin.auth.login')}}" class="text-sm dark:text-white md:text-xl lg:text-2xl font-semibold hover:text-primary break-words text-center max-w-[200px]">{{trans('system.admin')}}</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
