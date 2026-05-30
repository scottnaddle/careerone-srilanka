@extends('auth.layouts.master')

@section('title', 'Sign Up')

@push('css')
<style>
    .rule-icon { display: inline-block; width: 16px; text-align: center; }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-start justify-center py-12 px-4">
    <div class="max-w-md w-full">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="{{asset('/images/careerone-logo.webp')}}" class="h-12 mx-auto block dark:hidden" alt="Careerone Logo">
                <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-12 mx-auto hidden dark:block" alt="Careerone Logo">
            </a>
        </div>

        <div class="bg-white dark:bg-[#1E1E1E] shadow-lg rounded-2xl px-6 py-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-1">
                {{ __('auth.create_account') }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-center text-sm mb-6">
                {{ __('auth.create_account_subtitle') }}
            </p>

            {{-- Flash Messages --}}
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

            <form action="{{ route('trainee.auth.postRegister') }}" method="POST" class="space-y-5" autocomplete="off">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ __('system.form.email') }}
                    </label>
                    <input type="email" name="email" id="email" required
                        value="{{ old('email') }}"
                        placeholder="you@email.com"
                        class="w-full h-12 px-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ __('system.form.password') }}
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            placeholder="••••••••"
                            class="w-full h-12 px-4 pr-12 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors @error('password') border-red-500 @enderror"
                            oninput="updateStrength()">
                        <button type="button" onclick="togglePassword('password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg id="password-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Strength Rules --}}
                    <ul class="mt-2 space-y-0.5 text-xs" id="rules">
                            <li data-rule="length"><span class="rule-icon">○</span> 8-16 characters</li>
                            <li data-rule="upper"><span class="rule-icon">○</span> One uppercase letter</li>
                            <li data-rule="number"><span class="rule-icon">○</span> One number</li>
                            <li data-rule="special"><span class="rule-icon">○</span> One special character</li>
                        </ul>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="repassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ __('system.form.confirm_password') }}
                    </label>
                    <div class="relative">
                        <input type="password" name="repassword" id="repassword" required
                            placeholder="{{ __('system.form.confirm_password') }}"
                            class="w-full h-12 px-4 pr-12 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors @error('repassword') border-red-500 @enderror"
                            oninput="checkMatch()">
                        <button type="button" onclick="togglePassword('repassword', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <p id="match-feedback" class="mt-1 text-xs hidden"></p>
                    @error('repassword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-2">
                    <input type="checkbox" name="agree_terms" id="agree_terms" value="1" required
                        class="mt-1 h-4 w-4 text-[#4984F6] focus:ring-[#4984F6] border-gray-300 rounded">
                    <label for="agree_terms" class="text-sm text-gray-600 dark:text-gray-400">
                        {!! __('system.form.accept_term_message', ['file' => asset('files/T&C for Trainee.pdf')]) !!}
                    </label>
                </div>
                @error('agree_terms')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- Submit --}}
                <button type="submit"
                    class="w-full h-12 bg-[#4984F6] hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors text-lg flex items-center justify-center">
                    {{ __('auth.sign_up') }}
                </button>

                {{-- Login Link --}}
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    {{ __('auth.already_have_account') }}
                    <a href="{{ route('trainee.auth.login') }}" class="text-[#4984F6] hover:underline font-medium">
                        {{ __('auth.sign_in') }}
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function updateStrength() {
        const pwd = document.getElementById('password').value;
        const rules = {
            length: pwd.length >= 8 && pwd.length <= 16,
            upper: /[A-Z]/.test(pwd),
            number: /[0-9]/.test(pwd),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(pwd),
        };
        const passed = Object.values(rules).filter(Boolean).length;
        
        // Update rule icons
        document.querySelectorAll('#rules li').forEach(li => {
            const rule = li.dataset.rule;
            const icon = li.querySelector('.rule-icon');
            if (pwd.length === 0) {
                icon.textContent = '○';
                li.style.color = '#9ca3af';
            } else if (rules[rule]) {
                icon.textContent = '✓';
                li.style.color = '#16a34a';
            } else {
                icon.textContent = '○';
                li.style.color = '#9ca3af';
            }
        });
    }

    function checkMatch() {
        const pwd = document.getElementById('password').value;
        const repwd = document.getElementById('repassword').value;
        const fb = document.getElementById('match-feedback');
        
        if (repwd.length === 0) {
            fb.classList.add('hidden');
        } else if (pwd === repwd) {
            fb.textContent = '✓ Passwords match';
            fb.className = 'mt-1 text-xs text-green-600';
            fb.classList.remove('hidden');
        } else {
            fb.textContent = '✗ Passwords do not match';
            fb.className = 'mt-1 text-xs text-red-600';
            fb.classList.remove('hidden');
        }
    }

    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush
