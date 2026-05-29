@extends('auth.layouts.master')

@section('title', 'Sign In')

@section('content')
    <div class="max-w-2xl mx-auto w-screen py-24 flex flex-col h-full justify-start">
        @include('auth.partials.signin-form', ['userType' => 'trainee'], [
            'route' => 'trainee.auth.postLogin',
            'logo' => '/images/TVET.svg',
            'logoDark' => null,
            'darkBg' => 'dark:bg-gray-800',
            'darkBorder' => 'dark:border-gray-700',
            'submitMb' => 'mb-4',
            'forgotRoute' => 'trainee.auth.forgotPassword',
            'registerRoute' => 'trainee.auth.register',
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
