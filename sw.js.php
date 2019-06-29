<?php
header('Content-Type: application/javascript');
?>
var cacheName = 'TODOCachev1';

var cachedFiles = [
    <?php 
    foreach($pagesArray as $pageUrl=>$pageTitle){
        if($pageTitle!=''){
            echo "'".$pageUrl."',";
        }
    } 
    ?>
    '/manifest.json',
    '/js/main.js',
    '/css/main.css',
    '/apple-touch-icon.png',
    '/android-chrome-192x192.png'
];

self.addEventListener('install', function(evt){
    console.log('Service Worker Install Event');
    //Add the file to the cache
    evt.waitUntil(
        caches.open(cacheName).then(function(cache){
            console.log('Caching Files');
            return cache.addAll(cachedFiles);
        }).then(function(){
            return self.skipWaiting();
        }).catch(function(err){
            console.log('Cache Failed', err);
        })    
    );
});

self.addEventListener('activate', function(evt){
    console.log('Service Worker Activated');
    evt.waitUntil(
       caches.keys().then(function(keyList){
           return Promise.all(keyList.map(function(key){
               if(key !== cacheName){
                   console.log('Removing Old Cache', key);
                   return caches.delete(key)
               }
           }));
       })
    );
    return self.clients.claim();
});

self.addEventListener('fetch', function(evt){
    console.log('Fetch Event: ' + evt.request.url);
    /*evt.respondWith(
       caches.match(evt.request).then(function(response){
           return fetch(evt.request) || response; // switch these to get a network(fetch(evt.request)) | cache(response) first response
       })
    );*/
    evt.respondWith(fromNetwork(evt.request, 400).catch(function () {
        return fromCache(evt.request);
    }));
});

/*
==================
cache functions
==================
*/
function fromNetwork(request, timeout) {
    return new Promise(function (fulfill, reject) {

      var timeoutId = setTimeout(reject, timeout);  
   
      fetch(request).then(function (response) {
        clearTimeout(timeoutId);
        fulfill(response);
   
      }, reject);
    });
}

function fromCache(request) {
    return caches.open(cacheName).then(function (cache) {
      return cache.match(request).then(function (matching) {
        return matching || Promise.reject('no-match');
      });
    });
}
//////////////////


/*
==================
notifications
==================
*/
self.addEventListener('notificationclick', function(event) {
    console.log('[Service Worker] Notification click Received.');  
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.loc)
    );
});
