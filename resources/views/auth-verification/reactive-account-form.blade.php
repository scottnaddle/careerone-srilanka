@extends('auth.layouts.master')

@section('title', 'Reactive account form')

@section('content')
    <div class="max-w-lg mx-auto w-screen py-24">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-5">
            <div class="flex flex-col gap-6">

                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if(isset($success_message))
                    <p class="text-center dark:text-white">{{ $success_message }}</p>
                    <a href="/"
                            class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Go to homepage
                    </a>
                @else
                <p class="text-center">{{trans('auth.not_active')}}</p>
                <form action="{{ route('send-reactive-account-request') }}" method="post">
                    @csrf
                    <input type="text" name="u_type" value="{{$u_type}}" class="hidden">
                    <input type="text" name="token" value="{{$token}}" class="hidden">

                    <button type="submit"
                            class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send reactive request
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>
@endsection
