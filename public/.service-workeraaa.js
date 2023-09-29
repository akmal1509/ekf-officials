self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('cache-name').then((cache) => {
            return cache.addAll([
                '/',
                '/css/app.css',
                '/js/app.js',
                // Tambahkan sumber daya lain yang ingin Anda cache di sini
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
