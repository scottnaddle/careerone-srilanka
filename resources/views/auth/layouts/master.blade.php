<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
    <base href="{{ asset('/') }}">
</head>

<body class="bg-custom flex justify-center items-center bg-cover bg-center bg-fixed">
    <div class="max-w-[1440px] mx-auto h-[100vh]">
        <div class="mx-auto content-center flex items-start h-full">
            @yield('content')
        </div>
    </div>
    @stack('js')
</body>
</html>
