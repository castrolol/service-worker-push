if ('serviceWorker' in navigator && navigator.onLine) {

    navigator.serviceWorker.register('push-service.js').then(function(registration) {

        registration.pushManager.subscribe({ userVisibleOnly: true }).then(function(sub) {
            console.log('endpoint:', sub.endpoint);
        });

        console.log('┌(˘⌣˘)ʃ ', registration.scope);

    }).catch(function(err) {

        console.log('ლ(ಠ_ಠლ)', err);

    });
}