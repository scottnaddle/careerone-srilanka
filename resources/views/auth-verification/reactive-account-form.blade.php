@extends('auth.layouts.master')

@section('title', 'Reactive account form')

@section('content')
    <div class="flex flex-col gap-2.5 w-full max-w-xl bg-white px-4 md:px-8 py-6 rounded-xl dark:bg-[#1E1E1E]">
        <!-- Logo -->
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-6 mt-4">
                <!-- Left column: Icon and Title -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/reactive.png" class="w-1/3 md:w-1/5" alt="CGO Icon">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">Reactive Account</h2>

                    @if(isset($success_message))
                        <p class="text-green-600 dark:text-green-400 font-semibold text-center text-base text-center">{{ $success_message }}</p>
                    @else
                        <p class="text-primary dark:text-white font-semibold text-center text-base">{{trans('auth.not_active')}}</p>
                    @endif
                </div>

                <!-- Right column: Form or Action button -->
                <div class="w-full flex flex-col items-center justify-center gap-6 md:col-span-2">

                    @if(isset($success_message))
                        <div class="w-full flex flex-col gap-4 leading-5 pt-4">
                            <a href="/"
                               class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 block">
                                Go to homepage
                            </a>
                        </div>
                    @else
                        <form class="w-full flex flex-col gap-4 leading-5" action="{{ route('send-reactive-account-request') }}" method="POST">
                            @csrf

                            <!-- Hidden inputs -->
                            <input type="text" name="u_type" value="{{$u_type}}" class="hidden">
                            <input type="text" name="token" value="{{$token}}" class="hidden">

                            <!-- Send request button -->
                            <div class="pt-4">
                                <button type="submit"
                                        class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                    Send reactive request
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
