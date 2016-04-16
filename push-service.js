
'use strict';

console.log('Started', self);

self.addEventListener('install', function(event) {
    self.skipWaiting();
    console.log('Installed', event);
});

self.addEventListener('activate', function(event) {
    console.log('Activated', event);
});

function atualizarJanelasAbertas(itens) {

    return clients.matchAll({
        type: "window"
    })
    .then(function(clientList) {
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url.match(/results.html$/))
                return client.postMessage(JSON.stringify(itens));
        } 
    })

}


function mostrarNotificacoes(itens, reg) {

    return Promise.all(
        itens.map(title => reg.showNotification(title, {
                'body': 'Voto para ' + title,
                'icon': 'imgs/' + title.toLowerCase() + '.png',
                'heroi': title
            })
        ).concat(atualizarJanelasAbertas(itens))
    );

}


self.addEventListener("notificationclick", function(event) {


    event.notification.close();

    // This looks to see if the current is already open and  
    // focuses if it is  
    event.waitUntil(
        clients.matchAll({
            type: "window"
        })
            .then(function(clientList) {
                for (var i = 0; i < clientList.length; i++) {
                    var client = clientList[i];
                    if (client.url.match(/results.html$/) && 'focus' in client)
                        return client.focus();
                }
                if (clients.openWindow) {
                    return clients.openWindow('/heroes/results.html');
                }
            })
    );


});


self.addEventListener('push', function(event) {
    console.log('Push message', event);

    console.log(arguments);

    event.waitUntil(
        fetch("https://castrolol.com/heroes-api/?push=true")
            .then(function(r) {
                return r.json();
            })
            .then(function(itens) {
                return mostrarNotificacoes(itens, self.registration);
            })

    );
});