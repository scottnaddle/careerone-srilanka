<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{env('APP_NAME', 'TVEC SYSTEM')}}</title>
    <base href="{{asset('/')}}">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-[#F5F7FA]">
@include('admin.partials.menu')
<div class="mr-7 my-10 flex-1">
    @yield('content')
</div>
</body>
</html>
