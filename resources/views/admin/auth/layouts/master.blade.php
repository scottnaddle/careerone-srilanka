<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <style>
        .bg-custom {
            background-image: url('/images/bg-auth.webp');
        }
        .fi-fo-field-wrp-label>span, .fi-link >span {
            color: #706F81;
        }
    </style>
    <base href="{{ asset('/') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
</head>

<body class="bg-custom flex justify-center items-center bg-cover">
    <div class="max-w-[1440px] mx-auto">
        <div class="mx-auto content-center">
            @yield('content')
        </div>
    </div>
</body>
<script src="{{asset('/js/jquery-3.7.1.min.js')}}"></script>
@yield('js')
</html>
