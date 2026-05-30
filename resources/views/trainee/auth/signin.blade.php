@extends('auth.layouts.master')

@section('title', 'Trainee Sign In')

@section('content')
    <div class="max-w-2xl mx-auto w-screen py-24 flex flex-col h-full justify-start">
        @include('auth.partials.signin-form', [
            'route' => 'trainee.auth.postLogin',
            'logo' => '/images/TVET.svg',
            'logoDark' => null,
            'darkBg' => 'dark:bg-gray-800',
            'darkBorder' => 'dark:border-gray-700',
            'submitMb' => 'mb-4',
            'forgotRoute' => 'trainee.auth.forgotPassword',
            'registerRoute' => 'trainee.auth.register',
            'userType' => 'trainee',
            'title' => 'Trainee Sign In',
            'subtitle' => 'Find courses, jobs, and career guidance',
            'accentColor' => 'from-blue-500 to-blue-700',
            'accentIcon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489"/></svg>',
        ])
    </div>
@endsection
