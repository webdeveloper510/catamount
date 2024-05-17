importScripts('https://www.gstatic.com/firebasejs/10.11.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.11.1/firebase-messaging-compat.js');

try {
    firebase.initializeApp({
        apiKey: "AIzaSyB3y7uzZSAP39LOIvZwOjJOdFD2myDnvQk",
      authDomain: "notify-71d80.firebaseapp.com",
      projectId: "notify-71d80",
      storageBucket: "notify-71d80.appspot.com",
      messagingSenderId: "684664764020",
      appId: "1:684664764020:web:71f82128ffc0e20e3fc321",
      measurementId: "G-FTD60E8WG9"
    });

    const messaging = firebase.messaging();
    // console.log('hy');
    // Add Firebase messaging event listeners
    messaging.onBackgroundMessage((payload) => {
        console.log('Received background message:', payload);

        const notificationTitle = payload.notification.title;
        const notificationOptions = {
            body: payload.notification.body,
            icon: '/assets/icon/notification-icon.png'
        };

        self.registration.showNotification(notificationTitle, notificationOptions);
    });
    self.addEventListener('notificationclick', function(event) {
        let url = 'https://thesectoreight.com';
        event.notification.close(); // Android needs explicit close.
        event.waitUntil(
            clients.matchAll({type: 'window'}).then( windowClients => {
                // Check if there is already a window/tab open with the target URL
                for (var i = 0; i < windowClients.length; i++) {
                    var client = windowClients[i];
                    // If so, just focus it.
                    if (client.url === url && 'focus' in client) {
                        return client.focus();
                    }
                }
                // If not, then open the target URL in a new window/tab.
                if (clients.openWindow) {
                    return clients.openWindow(url);
                }
            })
        );
    });

} catch (error) {
    console.error('Error initializing Firebase:', error);
}
