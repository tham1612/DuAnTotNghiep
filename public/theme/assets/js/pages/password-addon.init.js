// Tìm tất cả các phần tử có class "auth-pass-inputgroup" trong form
Array.from(document.querySelectorAll(".auth-pass-inputgroup")).forEach(function (inputGroup) {
    // Tìm nút "password-addon" bên trong inputGroup
    var addonButton = inputGroup.querySelector(".password-addon");
    // Tìm trường mật khẩu (password-input) bên trong inputGroup
    var passwordInput = inputGroup.querySelector(".password-input");
    document.getElementById('password-addon-1').addEventListener('click', function () {
        var passwordInput = document.getElementById('password-input');
        var addonButton = this;
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            addonButton.innerHTML = '<i class="ri-eye-off-fill align-middle"></i>';
        } else {
            passwordInput.type = 'password';
            addonButton.innerHTML = '<i class="ri-eye-fill align-middle"></i>';
        }
    });

    document.getElementById('password-addon-2').addEventListener('click', function () {
        var confirmPasswordInput = document.getElementById('confirm-password-input');
        var addonButton = this;
        if (confirmPasswordInput.type === 'password') {
            confirmPasswordInput.type = 'text';
            addonButton.innerHTML = '<i class="ri-eye-off-fill align-middle"></i>';
        } else {
            confirmPasswordInput.type = 'password';
            addonButton.innerHTML = '<i class="ri-eye-fill align-middle"></i>';
        }
    });
    // Thêm sự kiện "click" cho nút "password-addon"
    addonButton.addEventListener("click", function () {
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

