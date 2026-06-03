<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Portfolio Builder</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/vue/main.js'])
</head>
<body>
<div id="app" data-portfolio='@json($portfolioData)' data-lang="{{ app()->getLocale() }}"></div>
</body>
</html>
