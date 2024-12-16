import Echo from "laravel-echo";
import "./bootstrap";

window.Echo.private(`notifications.${userId}`).listen(
    "EventNotification",
    (event) => {
        console.log(event);
        if (event.userId == userId) {
            notificationWeb(event.action, event.message);
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    }
);
