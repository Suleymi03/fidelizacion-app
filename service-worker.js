self.addEventListener('install', event => {
  console.log('Service Worker instalado');
});

self.addEventListener('fetch', event => {
  // Aquí puedes agregar caching si quieres funcionar offline
  event.respondWith(fetch(event.request));
});