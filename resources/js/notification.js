import Echo from "laravel-echo";
import "./bootstrap";

var userId = 3;
window.Echo.private(`notifications.${userId}`)
.listen("EventNotification", (event) => {
        console.log(event);
        notificationWeb(event.action, event.message);
    }
);
