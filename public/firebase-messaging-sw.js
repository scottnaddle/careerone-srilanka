 const firebaseConfig = {
  apiKey: "AIzaSyAjpAPTCukpT05d1N4BbbeQKqk54ZZ_DWE",
  authDomain: "careerone-pilot.firebaseapp.com",
  projectId: "careerone-pilot",
  storageBucket: "careerone-pilot.firebasestorage.app",
  messagingSenderId: "356919713226",
  appId: "1:356919713226:web:953c592056d987d520c333",
  measurementId: "G-GE4JF3LDS0"
  };
  function save_token_firebase_to_session(currentToken){
    fetch('/fcm/save-fcm-token', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
        body: JSON.stringify({ token: currentToken })
    })
  }