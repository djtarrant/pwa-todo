
/*
==================
register service worker
==================
*/

var pwaSupport = false;

if('serviceWorker' in navigator){
    pwaSupport = true;
    //register the service worker
    navigator.serviceWorker.register('/selwynfreshers/sw.js.php').then(function(result){
        console.log('Service Worker Registered');
        console.log('Scope: ' + result.scope);
        subscribeToPush(); //prompt to subscribe to push notifications if possible
        
    }, function(error){
        console.log('Service Worker Registration Failed');
        console.log(error);
    });
}else{
    console.log('Ooops. Service Workers Not Supported');
}



/*
==================
install PWA on homescreen 
==================
beforeinstallprompt will fire if:
The PWA must not already be installed
Meets a user engagement heuristic (the user must have at least 30s interaction with your web app.
Your web app must include a web app manifest.
Your web app must be served over a secure HTTPS connection.
Has registered a service worker with a fetch event handler.
*/

var deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    console.log('Before Install Prompt.');
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    // Update UI notify the user they can add to home screen
    document.getElementById('addToHomeScreen').style.display = 'block';
});

console.log('Deferred Prompt: '+deferredPrompt);

window.addEventListener('appinstalled', function(evt){
    console.log('App Installed Event');
});


// Add to home screen button in the header
function installApp(){
    console.log('App to be installed...');
    hidePrompt();
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then(function(result){
        if(result.outcome === 'accepted')
            console.log('App Installed');
        else
            console.log('App Not Installed');
    });
}
// Add to home screen link in the header
function hidePrompt(){
    console.log('Hide Prompt');
    document.getElementById('addToHomeScreen').style.display = 'none';
}



/*
==================
push notifications
==================
*/
function notify(title, options){
    if(Notification.permission === 'granted'){
        navigator.serviceWorker.ready.then(function(reg){
            reg.showNotification(title, options);
        });
    }
}

function subscribeToPush(){
    navigator.serviceWorker.ready.then(function(reg){
        reg.pushManager.subscribe({userVisibleOnly:true}).then(function(sub){
            console.log(JSON.stringify(sub));
            console.log("Endpoint: " + sub.endpoint);
            console.log('User Subscribed');
        }).catch(function(err) {
            if (Notification.permission === "granted") {
                console.log('Push Allowed');
            } else if (Notification.permission === "blocked" || Notification.permission === "denied") {
                /* the user has previously denied push, can't reprompt. */
                console.log('Push Blocked');
            } else {
                /* fallback, we have a permission that we haven't accounted for */
                console.log('Push registration failed: ', err, Notification.permission);
            }
        });
    });
}

// send a notification
function sendNotification(body, loc){
    if('Notification' in window){
        console.log('Notifications Supported');

        if(body!=''){
            bodyText = body;
        }else{
            bodyText = 'New update'
        }
        
        if(loc!=''){
            locText = loc;
        }else{
            locText = 'index.php';
        }
        var options = {
            body: bodyText,
            icon: 'android-chrome-192x192.png',
            vibrate: [100, 50, 100],
            data: {
                timestamp: Date.now(),
                loc: locText
            },
            actions: [
                {action: 'go', title: 'Go Now'}
            ]
        };
        Notification.requestPermission(function(status){
            console.log('Notification Status: ', status);
            if(status=='granted'){
                console.log('Granted. Notification about to get sent...');
                notify('TODO Notification', options);
            }
        });
        
    }
}
