importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyDBzHsmDxK5OL1fGqID0RQtSBlteyaoiJA",
    authDomain: "trainingp-190fa.firebaseapp.com",
    projectId: "trainingp-190fa",
    storageBucket: "trainingp-190fa.appspot.com",
    messagingSenderId: "174784582529",
    appId: "1:174784582529:web:097f676af977bffd7d8e80",
    measurementId: "G-SSR1W8ZFBN"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log('[FCM SW] Message received in background:', payload);
});
