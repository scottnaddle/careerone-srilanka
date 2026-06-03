<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <base href="{{ asset('/') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}
{{--    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>--}}
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/grapesjs-builder.js'])

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }
    </style>
    @stack('css')
</head>

<body>
    @if (true)
    @yield('content')
    @stack('js')

    @else
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f8f8;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                color: #333;
            }
            .container {
                text-align: center;
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .countdown {
                font-size: 24px;
                margin-top: 10px;
            }
        </style>
        <div class="flex flex-col items-center">
            <h1>Your browser is not support</h1>
            <p>Please use Desktop Web Browser to edit Portfolio</p>
            <p>You will be redirected to the homepage in <span class="countdown" id="countdown">10</span> seconds.</p></p>
        </div>

        <script>
            // Set the countdown time in seconds
            let countdownTime = 10;

            // Get the countdown element
            const countdownElement = document.getElementById('countdown');

            // Update the countdown every second
            const countdownInterval = setInterval(() => {
                // Decrease the countdown time
                countdownTime--;

                // Update the displayed countdown time
                countdownElement.textContent = countdownTime;

                // If the countdown reaches 0, redirect to the homepage
                if (countdownTime === 0) {
                    clearInterval(countdownInterval);
                    window.location.href = '/'; // Redirect to homepage
                }
            }, 1000);
        </script>
    @endif
</body>

</html>
