<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
    <base href="{{ asset('/') }}">
    {{-- Opt-in head scripts (e.g. Firebase messaging on the CGO/company login pages).
         Push to this stack from a page: @push('head') @include('auth.partials.firebase-messaging') @endpush --}}
    @stack('head')
</head>

<body class="bg-custom mx-auto max-w-[1440px] flex flex-col justify-center h-auto lg:h-[100vh]">
    <div class="my-6 flex flex-col items-center justify-center mx-4">
        @yield('content')
    </div>
    @stack('js')
</body>
</html>
