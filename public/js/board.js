function archiverBoard(boardId) {
    console.log(boardId)
    $.ajax({
        url: `/b/${boardId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg)
            window.location.href = 'http://127.0.0.1:8000/home';
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });

}

function restoreBoard(boardId) {
    console.log(boardId)
    $.ajax({
        url: `/b/restoreBoard/${boardId}`,
        type: 'POST',
        success: function (response) {
            console.log(response)
            notificationWeb(response.action, response.msg)
            window.location.href = `http://127.0.0.1:8000/b/${response.board}/edit?viewType=dashboard`;
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });

}

function destroyBoard(boardId) {
    console.log(boardId)
    $.ajax({
        url: `/b/destroyBoard/${boardId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg)
            window.location.href = 'http://127.0.0.1:8000/home';
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });

}

// sao chép bảng
$('.submitFormCopyBoard').on('submit', function (e) {
    e.preventDefault();

    var name = $('#nameCopyBoard').val().trim();
    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề')
        return;
    }
    console.log(name)
    $.ajax({
        url: '/b/copyBoard',
        type: 'POST',
        data: $(this).serialize(),       // Lấy dữ liệu từ form
        success: function (response) {
            notificationWeb('success', 'Sao chép bảng thành công');
            window.location.href = `http://127.0.0.1:8000/b/${response.board_id}/edit?viewType=dashboard`;
        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!')
        }
    });
});

//xử lý chọn board + catalog
// Khi chọn Board, lấy các Catalog tương ứng
$('.toBoard').change(function () {
    var boardId = $(this).val();
    var toCatalogSelect = $(this).closest('.mt-2').next('.row').find('.toCatalog');
    var toPositionSelect = $(this).closest('.mt-2').next('.row').find('.toPosition');

    console.log("Selected Board ID:", boardId); // Kiểm tra ID của Board được chọn

    $.ajax({
        url: "/b/getDataBoard",
        method: "POST",
        data: {board_id: boardId},
        success: function (data) {
            console.log("Catalog data received:", data); // Kiểm tra dữ liệu nhận được từ server

            // Xóa các option hiện tại trong Catalog và Position
            toCatalogSelect.empty();
            toPositionSelect.empty();

            // Thêm các option mới cho Catalog
            $.each(data.catalogs, function (index, catalog) {
                toCatalogSelect.append(`<option value="${catalog.id}" data-task-count="${catalog.task_count}">${catalog.name}</option>`);
            });

            // Cập nhật Position cho catalog đầu tiên của Board đã chọn
            if (data.catalogs.length > 0) {
                for (var i = 1; i <= data.catalogs[0].task_count; i++) {
                    toPositionSelect.append('<option value="' + i + '">' + i + '</option>');
                }
            }
        },
        error: function (xhr) {
            console.error("AJAX error:", xhr.responseText); // Ghi lại lỗi nếu có
        }
    });
});

// Khi chọn Catalog, cập nhật Position dựa trên số lượng Task
$('.toCatalog').change(function () {
    var taskCount = $(this).find(':selected').data('task-count');
    var toPositionSelect = $(this).closest('.row').find('.toPosition');

    console.log("Task count for selected Catalog:", taskCount); // Kiểm tra số lượng task

    toPositionSelect.empty();
    for (var i = 1; i <= taskCount + 1; i++) {
        toPositionSelect.append('<option value="' + i + '">' + i + '</option>');
    }
});
