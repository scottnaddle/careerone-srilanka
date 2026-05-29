<!-- In `resources/views/components/layouts/app.blade.php` -->
<!DOCTYPE html>
<html>
<head>
    <title>App Layout</title>
    @livewireStyles
</head>
<body>
{{ $slot }}
@livewireScripts
</body>
</html>
