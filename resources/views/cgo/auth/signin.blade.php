@extends('auth.layouts.master')

@section('title', 'Sign In')

@section('content')
    <div class="max-w-2xl mx-auto w-screen py-24 flex flex-col h-full justify-start">
        @include('auth.partials.signin-form', [
            'route' => 'cgo.auth.postLogin',
            'logo' => 'images/logo/careerone-logo.svg',
            'logoDark' => 'images/logo/careerone-logo-dark.svg',
            'darkBg' => 'dark:bg-[#1E1E1E]',
            'darkBorder' => 'dark:border-white',
            'submitMb' => 'mb-8',
            'forgotRoute' => 'cgo.auth.forgotPassword',
            'registerRoute' => 'cgo.auth.register',
        ])
    </div>
    <script>
        document.getElementById('toggle-password')?.addEventListener('click', function() {
            const pwd = document.getElementById('password');
            const showIcon = document.getElementById('eye-icon-show');
            const hideIcon = document.getElementById('eye-icon-hide');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
                this.setAttribute('aria-label', 'Hide password');
            } else {
                pwd.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
                this.setAttribute('aria-label', 'Show password');
            }
        });
    </script>
@endsection
