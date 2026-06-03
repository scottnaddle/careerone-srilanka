@extends('auth.layouts.master')

@section('title', 'Change Password')

@section('content')
    <div class="max-w-md mx-auto w-full leading-9 py-24 px-7">
        <div class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 rounded-lg px-10 py-5">
            <a href="{{ route('company.my-page.my-page') }}"
               class="text-gray-900 dark:text-white font-medium gap-2 rounded-lg text-xl font-semibold inline-flex items-center hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                </svg>
                {{ __('system.form.button.back') }}
            </a>

            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('auth.change_password') }}</h1>

            @if (session('message'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded border border-green-400">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ route('company.my-page.change-password.update') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="current_password" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('auth.current_password') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="password" name="current_password" id="current_password" required
                        class="bg-gray-50 border border-gray-300 py-2 px-4 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white"
                        autocomplete="current-password">
                    @error('current_password')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="new_password" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('auth.new_password') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="password" name="new_password" id="new_password" required
                        class="bg-gray-50 border border-gray-300 py-2 px-4 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white"
                        autocomplete="new-password">
                    <small class="text-xs text-gray-500 dark:text-gray-400">
                        {{ __('auth.password_requirements') }}
                    </small>
                    @error('new_password')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="new_password_confirmation" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('auth.confirm_new_password') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                        class="bg-gray-50 border border-gray-300 py-2 px-4 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white"
                        autocomplete="new-password">
                </div>

                <button type="submit"
                    class="w-full text-white bg-[#4984F6] hover:bg-blue-800 font-medium rounded-full px-5 py-3 text-center">
                    {{ __('auth.change_password') }}
                </button>
            </form>
        </div>
    </div>
@endsection
