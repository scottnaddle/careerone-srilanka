<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <style>

    </style>
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
