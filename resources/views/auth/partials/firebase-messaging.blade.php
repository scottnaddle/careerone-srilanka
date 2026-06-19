{{-- Firebase Cloud Messaging: captures an FCM token on login and stores it in the session.
     Opt-in only — include from a page via @push('head'). Relies on a global `firebaseConfig`
     and `save_token_firebase_to_session()` defined elsewhere in the app bundle. --}}
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
