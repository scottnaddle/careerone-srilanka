<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
    <base href="{{ asset('/') }}">
    <script src="{{ asset('/firebase-messaging-sw.js') }}"></script>
    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging.js";

        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);
        if (Notification.permission === 'default' || Notification.permission === 'denied') {
            Notification.requestPermission().then((permission) => {

            }).catch((error) => {

            });
        }
        const tokenFCMFirebase = sessionStorage.getItem('fcmToken');


            getToken(messaging, {
                vapidKey: '{{ env('YOUR_PUBLIC_VAPID_KEY_HERE') }}'
            }).then((currentToken) => {
                if (currentToken) {
                    sessionStorage.setItem('fcmToken', currentToken);
                    save_token_firebase_to_session(currentToken);
                } else {
                }
            })
    </script>
</head>

<body class="bg-custom mx-auto max-w-[1440px] flex flex-col justify-center h-auto lg:h-[100vh]">
    <div class="my-6 flex flex-col items-center justify-center mx-4">
            @yield('content')
    </div>
    @stack('js')
</body>
</html>
