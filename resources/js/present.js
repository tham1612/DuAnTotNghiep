import "./bootstrap";
// window.Echo.join(`chat`)
//     .here((users) => {
//         console.log("Users currently in the chat:", users);
//     })
//     .joining((user) => {
//         console.log("User joined:", user);
//     })
//     .leaving((user) => {
//         console.log("User left:", user);
//     });
// console.log(1);
window.Echo.join(`chat.${roomId}`)
    .here((users) => {
        console.log("==============here============");
        console.table(users);

        // Kiểm tra xem người nhận có online không
        let isReceiverOnline = users.some((user) => user.id === receiverId);

        // Cập nhật trạng thái "Online" hoặc "Offline"
        const userStatusElement = document.getElementById("user-status");
        userStatusElement.textContent = isReceiverOnline ? "Online" : "Offline";

        // Thêm hoặc xóa class "user-status" vào phần tử có id "check" dựa trên trạng thái
        const checkElement = document.getElementById("check");
        if (isReceiverOnline) {
            checkElement.classList.add("user-status"); // Thêm class nếu online
        } else {
            checkElement.classList.remove("user-status"); // Xóa class nếu offline
        }
    })
    .joining((user) => {
        console.log("==============joining============");
        console.log(user);
        if (user.id === receiverId) {
            document.getElementById("user-status").textContent = "Online";
        }
    })
    .leaving((user) => {
        console.log("==============leaving============");
        if (user.id === receiverId) {
            document.getElementById("user-status").textContent = "Offline";
        }
    });

// Gửi tin nhắn khi người dùng nhấn nút "Gửi"
document
    .getElementById("send-message-btn")
    .addEventListener("click", function () {
        const messageInput = document.getElementById("message-input");
        const message = messageInput.value.trim();
        // document.getElementById('mat').style.display = 'none';

        if (message === "") {
            notificationWeb('warning',"Vui lòng nhập tin nhắn")
            return;
        }

        // Hiển thị tin nhắn ngay lập tức cho người gửi
        appendMessage(message, userId);

        // Gửi tin nhắn lên server qua axios
        axios
            .post("/messages/send", {
                message: message,
                receiver_id: receiverId,
                room_id: roomId,
            })
            .then((response) => {
                // Tin nhắn đã được gửi thành công, xử lý thêm nếu cần
                console.log("Tin nhắn đã được gửi");
            })
            .catch((error) => {
                console.error("Đã xảy ra lỗi khi gửi tin nhắn:", error);
            });

        // Xóa nội dung sau khi gửi
        messageInput.value = "";
    });

window.Echo.join("chat." + roomId).listen("MessageSent", (event) => {
    console.log("Tin nhắn nhận được:", event.message);
    appendMessage(event.message, event.senderId);
});

// Hàm thêm tin nhắn vào khung hiển thị
function appendMessage(message, senderId) {
    const messageBox = document.getElementById("message-box");
    const messageElement = document.createElement("div");

    if (senderId === userId) {
        // Thêm thẻ div với CSS trực tiếp vào
        messageElement.innerHTML += `
        <div style="display: flex; align-items: flex-start; margin-bottom: 10px; max-width: 300px;">
            <div class="mb-2" style="background-color: #5F93ED; padding: 10px; border-radius: 5px; color: #ffffff; margin-top: -10px; line-height: 1.2;">
                ${message}
            </div>
        </div>
        <div style="font-size: 12px; color: #555; text-align: right; margin-top: -15px;">${currentTime}</div> `;
    } else {
        messageElement.innerHTML += `
        <div style="display: flex; align-items: flex-start; margin-bottom: 10px; max-width: 300px;">
            <div class="bg-info-subtle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; margin-right: 10px; border-radius: 50%;">
               A
            </div>
            <div style="background-color: #E6E4D5; padding: 10px; border-radius: 5px; color: #333; margin-top: -10px; line-height: 1.2;">
                ${message}
            </div>
        </div>
        <div style="font-size: 12px; color: #555; text-align: right; margin-top: -15px;">${currentTime}</div> <!-- Thời gian -->
    `;
    }

    // Thêm class CSS để căn chỉnh tin nhắn
    messageElement.classList.add("message"); // Thêm class 'message' chung cho tất cả tin nhắn
    if (senderId === userId) {
        messageElement.classList.add("right"); // Hiển thị bên phải cho người gửi
    } else {
        messageElement.classList.add("left"); // Hiển thị bên trái cho người nhận
    }

    // Thêm tin nhắn vào khung hiển thị
    messageBox.appendChild(messageElement);

    // Cuộn xuống cuối khung chat để thấy tin nhắn mới
    messageBox.scrollTop = messageBox.scrollHeight;
}
// Hàm để định dạng thời gian
function formatTime(date) {
    let hours = date.getHours().toString().padStart(2, "0");
    let minutes = date.getMinutes().toString().padStart(2, "0");
    return `${hours}:${minutes}`;
}

// Lấy thời gian hiện tại
const now = new Date();
const currentTime = formatTime(now);