document.addEventListener("DOMContentLoaded", function () {
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })

    // hàm ngăn chặn bị tắt khi người dùng tác động lên dropdown
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.addEventListener('click', event => {
            event.stopPropagation();
        });
    });

    //    validate form
    const forms = document.querySelectorAll('.formItem');

    forms.forEach((form) => {
        const textInput = form.querySelector('input[type="text"]');
        const submitButton = form.querySelector('button[type="submit"]');

        if (textInput && submitButton) {
            // Kiểm tra trạng thái của input để enable/disable button
            textInput.addEventListener('input', function () {
                const isFilled = textInput.value.trim() !== '';
                // console.log(`Input value: "${textInput.value}", Is filled: ${isFilled}`);
                submitButton.disabled = !isFilled;
            });

            // Xử lý khi button được nhấn
            submitButton.addEventListener('click', function (event) {
                disableButtonOnSubmit(event, textInput, submitButton);
            });
        }
    });

    function disableButtonOnSubmit(event, input, button) {
        event.preventDefault();
        if (button.disabled) return;

        button.disabled = true;
        event.target.closest('form').submit();
        input.value = '';

        setTimeout(() => {
            button.disabled = false;
        }, 3000);
    }

    // xóa thông báo sau 5s
    setTimeout(function () {
        var alertElement = document.getElementById('notification-messenger');
        if (alertElement) {
            alertElement.style.display = 'none';
            fetch("/forget-session", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                }
            });
        }

    }, 5000);

    function disableButtonOnSubmit() {
        continueButton.disabled = true;
        return true; // Vẫn cho phép submit form
    }

    // Vô hiệu hóa nút gửi
    $('#sendBtn').prop('disabled', true);

    // Lắng nghe sự thay đổi trong ô nhập liệu
    $('#prompt').on('input', function () {
        $('#sendBtn').prop('disabled', $(this).val().trim() === '');
    });

    $('#chatinput-form').on('submit', function (event) {
        event.preventDefault(); // Ngăn chặn hành động gửi biểu mẫu mặc định

        // Lấy giá trị từ ô nhập liệu
        let prompt = $('#prompt').val();
        // Disable nút "Gửi" và ô nhập
        $('#sendBtn').prop('disabled', true);
        $('#prompt').prop('disabled', true);
        $('#loadingSpinner').show(); // Hiển thị thanh tải

        // Hiển thị tin nhắn của người dùng
        $('#responseBox').append(
            '<div class="user-message" style="text-align: right; margin-bottom: 10px;"><span style="background-color: #d1e7dd; padding: 8px 12px; border-radius: 15px; display: inline-block;">' +
            prompt + '</span></div>'
        );

        // Xóa nội dung trong ô nhập liệu
        $('#prompt').val('');

        // Gửi yêu cầu AJAX đến server
        $.ajax({
            url: $(this).attr('action'), // URL từ thuộc tính action của form
            type: 'POST',
            data: {
                prompt: prompt,
                _token: $('input[name="_token"]').val() // Gửi token CSRF
            },
            success: function (response) {
                const responseText = response.chat.response; // Lấy phản hồi từ JSON

                // Thay thế các dấu ** bằng chữ in đậm và các ký tự xuống dòng bằng <br>
                let formattedResponse = responseText.replace(/\*\*(.*?)\*\*/g,
                    '<strong>$1</strong>');
                formattedResponse = formattedResponse.replace(/\n/g, '<br>');
                $('#loadingSpinner').hide();

                // Hiển thị phản hồi từ hệ thống
                $('#responseBox').append(
                    `<div class="ai-response" style="margin: 10px 0; padding: 10px; background: #f1f1f1; border-radius: 8px;">${formattedResponse}</div>`
                );

                // Kiểm tra nếu có tin nhắn người dùng thì ẩn thông điệp mặc định
                if ($('#responseBox').children('.user-message').length > 0 || $(
                    '#responseBox').children('.ai-response').length > 0) {
                    $('.default-message').hide(); // Ẩn thông điệp
                }

                // Cuộn xuống dưới khi có tin nhắn mới
                $('#chat-conversation').scrollTop($('#chat-conversation')[0]
                    .scrollHeight);

                // Xóa giá trị input sau khi gửi
                $('#prompt').val('');
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            },
            complete: function () {
                // Re-enable nút "Gửi" và ô nhập sau khi yêu cầu hoàn tất
                $('#sendBtn').prop('disabled', false);
                $('#prompt').prop('disabled', false);
            }
        });
    });
    // Thêm sự kiện cho nút xác nhận xóa
    $('#confirmDelete').on('click', function () {
        $.ajax({
            url: 'chat/history', // Đường dẫn tới route xóa
            type: 'DELETE',
            success: function (response) {
                $('#successModal').modal('show'); // Hiển thị modal thành công
                $('#responseBox').empty(); // Xóa nội dung hiển thị chat
                $('.default-message').show(); // Hiển thị lại thông điệp mặc định
                $('#confirmDeleteModal').modal('hide'); // Ẩn modal xác nhận
            },
            error: function (xhr) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                    xhr.responseJSON.error :
                    'Có lỗi xảy ra, vui lòng thử lại.';
                $('#errorMessage').text(errorMessage); // Cập nhật thông báo lỗi
                $('#errorModal').modal('show'); // Hiển thị modal lỗi
            }
        });
    });
});


// ============== sidebar =================






function updateBoard(boardId) {
    var formData = new FormData();
    var boardName = $('#name_board_' + boardId).val();
    formData.append('name', boardName);
    var image = document.getElementById('image_board_' + boardId);
    if (image.files.length > 0) {
        formData.append('image', image.files[0]);
    }
    formData.append('id', boardId);
    formData.append('_method', 'PUT');
    console.log(image.files[0]);
    $.ajax({
        url: `/b/${boardId}/update`,
        method: "POST",  // Đổi sang POST để gửi file
        data: formData,
        processData: false,  // Bắt buộc phải false để không xử lý FormData
        contentType: false,  // Bắt buộc phải false để đặt đúng 'multipart/form-data'
        success: function (response) {
            var nameboard2 = document.getElementById('2-name-board-' + boardId);
            var nameboard = document.getElementById('name-board-' + boardId);
            if (nameboard && response.board.name && nameboard2 ) {
                // Giới hạn tên mới theo 10 ký tự như trong Blade
                var limitedName = response.board.name.length > 10 ? response.board.name.substring(0, 10) + '...' : response.board.name;
                nameboard.textContent =nameboard2.textContent= limitedName;  // Cập nhật tên mới vào thẻ span
            }
            console.log('Đã cập nhật bảng:', response);
        },
        error: function (xhr) {
            console.error('An error occurred:', xhr.responseText);
        }
    });
}

function updateIsStar2(boardId, userId,) {

    $.ajax({
        url: `/b/${boardId}/updateBoardMember`,
        method: "PUT",
        data: {
            board_id: boardId,
            user_id: userId,
        },
        success: function (response) {

            console.log('Người dùng đã đánh dấu bảng nối bật:', response);
        },
        error: function (xhr) {
            console.error('An error occurred:', xhr.responseText);
        }
    });
}
function updateIsStar3(boardId, userId) {

    $.ajax({
        url: `/b/${boardId}/updateBoardMember`,
        method: "PUT",
        data: {
            board_id: boardId,
            user_id: userId,
        },
        success: function (response) {
            console.log('Người dùng đã đánh dấu bảng nối bật:', response);
            $(`#board_star_${boardId}`).closest('.board-star-container').remove();
        },
        error: function (xhr) {
            console.error('An error occurred:', xhr.responseText);
        }
    });
}

// ============== end sidebar =================
