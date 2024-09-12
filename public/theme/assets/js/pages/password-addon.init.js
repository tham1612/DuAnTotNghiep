// Tìm tất cả các phần tử có class "auth-pass-inputgroup" trong form
Array.from(document.querySelectorAll(".auth-pass-inputgroup")).forEach(function(inputGroup) {
    // Tìm nút "password-addon" bên trong inputGroup
    var addonButton = inputGroup.querySelector(".password-addon");
    // Tìm trường mật khẩu (password-input) bên trong inputGroup
    var passwordInput = inputGroup.querySelector(".password-input");

    // Thêm sự kiện "click" cho nút "password-addon"
    addonButton.addEventListener("click", function() {
        // Kiểm tra loại của input là "password" hay "text"
        if (passwordInput.type === "password") {
            passwordInput.type = "text"; // Hiển thị mật khẩu
            addonButton.innerHTML = '<i class="ri-eye-off-fill align-middle"></i>'; // Thay đổi biểu tượng
        } else {
            passwordInput.type = "password"; // Ẩn mật khẩu
            addonButton.innerHTML = '<i class="ri-eye-fill align-middle"></i>'; // Khôi phục biểu tượng
        }
    });
});

