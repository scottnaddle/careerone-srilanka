@extends('auth.layouts.master')

@section('title', 'CGO Sign In')

@section('content')
    <div class="max-w-2xl mx-auto w-screen py-24 flex flex-col h-full justify-start">
        @include('auth.partials.signin-form', [
            'route' => 'cgo.auth.postLogin',
            'logo' => '/images/TVET.svg',
            'logoDark' => null,
            'darkBg' => 'dark:bg-gray-800',
            'darkBorder' => 'dark:border-gray-700',
            'submitMb' => 'mb-4',
            'forgotRoute' => 'cgo.auth.forgotPassword',
            'registerRoute' => 'cgo.auth.register',
            'userType' => 'cgo',
            'title' => 'CGO Sign In',
            'subtitle' => 'Guide trainees and manage counseling',
            'accentColor' => 'from-purple-600 to-violet-800',
            'accentIcon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197"/></svg>',
        ])
    </div>
@endsection
