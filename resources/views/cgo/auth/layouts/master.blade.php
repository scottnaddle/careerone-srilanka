<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<body class="bg-custom flex justify-center items-center bg-cover bg-center bg-fixed">
    <div class="max-w-[1440px] mx-auto h-[100vh]">
        <div class="mx-auto content-center flex items-start h-full">
            @yield('content')
        </div>
    </div>
    @stack('js')
</body>
</html>
