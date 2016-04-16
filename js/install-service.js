if ('serviceWorker' in navigator && navigator.onLine) {

    navigator.serviceWorker.register('push-service.js').then(function(registration) {

        registration.pushManager.subscribe({ userVisibleOnly: true }).then(function(sub) {

            var form = new FormData();
            form.append("register", sub.endpoint.split("send/")[1]);
            fetch("https://castrolol.com/heroes-api/", { method: 'POST', body: form })
                .then(r => console.log("Registrado!"));

            console.log('endpoint:', sub.endpoint);
        });

        console.log('┌(˘⌣˘)ʃ ', registration.scope);

    }).catch(function(err) {

        console.log('ლ(ಠ_ಠლ)', err);

    });
}