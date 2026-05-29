/**
 * Service Worker - PWA Support
 * Babarida Dive Center
 */

const CACHE_NAME = 'bdc-v1';
const OFFLINE_URL = '/';

const PRECACHE_URLS = [
  '/',
  '/wp-content/themes/babarida-dive-theme/style.css',
  '/wp-content/themes/babarida-dive-theme/assets/js/main.js',
  '/wp-content/themes/babarida-dive-theme/assets/js/clocks.js',
];

// Install
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      return cache.addAll(PRECACHE_URLS);
    }).then(function() {
      return self.skipWaiting();
    })
  );
});

// Activate
self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then(function(keys) {
      return Promise.all(
        keys.filter(function(key) {
          return key !== CACHE_NAME;
        }).map(function(key) {
          return caches.delete(key);
        })
      );
    }).then(function() {
      return self.clients.claim();
    })
  );
});

// Fetch - Network First, Cache Fallback
self.addEventListener('fetch', function(event) {
  // Skip non-GET requests
  if (event.request.method !== 'GET') return;

  // Skip admin and AJAX requests
  var url = new URL(event.request.url);
  if (url.pathname.indexOf('/wp-admin/') !== -1) return;
  if (url.pathname.indexOf('/wp-login') !== -1) return;
  if (url.searchParams.get('action')) return;

  event.respondWith(
    fetch(event.request).then(function(response) {
      // Clone and cache successful responses
      if (response.status === 200) {
        var clone = response.clone();
        caches.open(CACHE_NAME).then(function(cache) {
          cache.put(event.request, clone);
        });
      }
      return response;
    }).catch(function() {
      // Return cached version if network fails
      return caches.match(event.request).then(function(cached) {
        return cached || caches.match(OFFLINE_URL);
      });
    })
  );
});

// Push Notification Handler
self.addEventListener('push', function(event) {
  var data = event.data ? event.data.json() : {};
  var title = data.title || 'Babarida Dive Center';
  var options = {
    body: data.body || 'Check out our latest diving adventures!',
    icon: '/wp-content/themes/babarida-dive-theme/assets/images/icon-192.png',
    badge: '/wp-content/themes/babarida-dive-theme/assets/images/icon-192.png',
    vibrate: [100, 50, 100],
    data: {
      url: data.url || '/'
    }
  };
  event.waitUntil(
    self.registration.showNotification(title, options)
  );
});

// Notification Click
self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  var url = event.notification.data.url || '/';
  event.waitUntil(
    clients.openWindow(url)
  );
});
