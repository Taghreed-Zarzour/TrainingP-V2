importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyC1DOHyKG2922iRHqaT5t6ZrBAdzZ2hQr0",
    authDomain: "trainingp0.firebaseapp.com",
    projectId: "trainingp0",
    storageBucket: "trainingp0.firebasestorage.app",
    messagingSenderId: "57053343136",
    appId: "1:57053343136:web:fedf6b3b1689c9700bc8c5",
    measurementId: "G-FF7SM0VLEJ"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log('[FCM SW] Message received in background:', payload);
});
