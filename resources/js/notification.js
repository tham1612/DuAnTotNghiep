import "./bootstrap";
import Echo from "laravel-echo";

window.Echo.Channel("notifidations").listen(
    "EventNotification",
    function (event) {
        console.log(event);
    }
);
