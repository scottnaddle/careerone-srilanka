@extends('auth.layouts.master')

@section('title', 'Company Sign In')

@section('content')
    <div class="max-w-2xl mx-auto w-screen py-24 flex flex-col h-full justify-start">
        @include('auth.partials.signin-form', [
            'route' => 'company.auth.postLogin',
            'logo' => '/images/TVET.svg',
            'logoDark' => null,
            'darkBg' => 'dark:bg-gray-800',
            'darkBorder' => 'dark:border-gray-700',
            'submitMb' => 'mb-4',
            'forgotRoute' => 'company.auth.forgotPassword',
            'registerRoute' => 'company.auth.register',
            'userType' => 'company',
            'title' => 'Company Sign In',
            'subtitle' => 'Post jobs and find skilled talent',
            'accentColor' => 'from-green-600 to-emerald-800',
            'accentIcon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>',
        ])
    </div>
@endsection
