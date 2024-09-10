// Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(function(e){Array.from(e.querySelectorAll(".password-addon")).forEach(function(r){r.addEventListener("click",function(r){var o=e.querySelector(".password-input");"password"===o.type?o.type="text":o.type="password"})})});


// Tìm tất cả các phần tử có class "auth-pass-inputgroup" trong form
Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(function(inputGroup) {
    // Tìm tất cả các nút "password-addon" bên trong từng inputGroup
    Array.from(inputGroup.querySelectorAll(".password-addon")).forEach(function(addonButton) {
        // Thêm sự kiện "click" cho nút "password-addon"
        addonButton.addEventListener("click", function() {
            // Tìm trường mật khẩu (password-input) bên trong cùng inputGroup
            var passwordInput = inputGroup.querySelector(".password-input");

            // Kiểm tra loại của input là "password" hay "text"
            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // Chuyển sang hiển thị mật khẩu
            } else {
                passwordInput.type = "password"; // Ẩn mật khẩu
            }
        });
    });
});
