@extends('auth.layouts.master')

@section('title', 'Magic Link Login')

@section('content')
<div class="min-h-screen flex items-start justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="{{asset('/images/careerone-logo.webp')}}" class="h-12 mx-auto block dark:hidden" alt="Careerone Logo">
                <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-12 mx-auto hidden dark:block" alt="Careerone Logo">
            </a>
        </div>

        <div class="bg-white dark:bg-[#1E1E1E] shadow-lg rounded-2xl px-6 py-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-1">
                {{ __('auth.magic_link_title') }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-center text-sm mb-6">
                {{ __('auth.magic_link_subtitle') }}
            </p>

            @if (session('message'))
                <div class="mb-4 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl text-sm border border-green-200 dark:border-green-800">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl text-sm border border-red-200 dark:border-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('magic-link.send') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ __('system.form.email') }}
                    </label>
                    <input type="email" name="email" id="email" required
                        value="{{ old('email') }}"
                        placeholder="you@email.com"
                        class="w-full h-12 px-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors">
                </div>

                <div>
                    <label for="user_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ __('auth.i_am_a') }}
                    </label>
                    <select name="user_type" id="user_type" required
                        class="w-full h-12 px-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors">
                        <option value="trainee">NVQ Trainee / Student</option>
                        <option value="company">Company / Organisation</option>
                        <option value="cgo">Career Guidance Officer</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full h-12 bg-[#4984F6] hover:bg-blue-700 text-white font-semibold rounded-full transition-colors text-lg">
                    {{ __('auth.send_magic_link') }}
                </button>

                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    <a href="/choose-login" class="text-[#4984F6] hover:underline font-medium">
                        {{ __('auth.back_to_login') }}
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
