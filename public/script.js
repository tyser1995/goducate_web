const checkPermission = () => {
    if (!('serviceWorker' in navigator)) {
        throw new Error("No support for service worker!")
    }

    if (!('Notification' in window)) {
        throw new Error("No support for notification API");
    }

    if (!('PushManager' in window)) {
        throw new Error("No support for Push API")
    }
}

const registerSW = async () => {
    const registration = await navigator.serviceWorker.register('sw.js');
    return registration;
}

const requestNotificationPermission = async () => {
    const permission = await Notification.requestPermission();

    if (permission !== 'granted') {
        throw new Error("Notification permission not granted")
    }

    // if (permission === 'granted') {
            
    //     // get service worker
    //     navigator.serviceWorker.ready.then((sw) =>{
            
    //         // subscribe
    //         sw.pushManager.subscribe({
    //             userVisibleOnly: true,
    //             applicationServerKey:"BC5zel9JoqeOY2yVTJjDhiE1IisJTVHq-_p4rxC3zd60gQSqXzra_7_m7B12axwI42tZIUXYGXhIJ-t5MolKjNY"
    //         }).then((subscription) => {

    //             // subscription successful
    //             fetch("/api/push-subscribe", {
    //                 method: "post",
    //                 body:JSON.stringify(subscription)
    //             }).then( 
    //                 alert("Notification granted")
    //             );
    //         });
    //     });
    // }

}

const main = async () => {
    checkPermission()
    await requestNotificationPermission()
    await registerSW()
}


main()
