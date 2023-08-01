importScripts('https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.22.2/firebase-messaging-compat.js');
const firebaseConfig = {
      apiKey: "AIzaSyDs6a-6Wp8G-a5mJEvYThT1v7qHF0IcKx0",
      authDomain: "push-notification-51431.firebaseapp.com",
      projectId: "push-notification-51431",
      storageBucket: "push-notification-51431.appspot.com",
      messagingSenderId: "569866202554",
      appId: "1:569866202554:web:f53cb40ccc18d9b3f88183"
};

// Initialize Firebase
const app = firebase.initializeApp(firebaseConfig)
const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  
  // Customize notification here
  const notificationTitle = payload.data.title;
  const notificationOptions = {
    body: payload.data.body,
    icon: payload.data.icon,
    image: payload.data.image
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
  self.addEventListener('notificationclick', function(event) {
    const clickedNotification = event.notification;
    clickedNotification.close();
    event.waitUntil(
      clients.openWindow(payload.data.click_action)
    );
  });
});