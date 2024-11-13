function archiverCatalog(catalogId) {
    Swal.fire({
        title: "Lưu trữ danh sách?",
        text: "Bạn có chắc muốn lưu trữ danh sách không!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Lưu trữ",
        cancelButtonText: "Đóng",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/catalogs/${catalogId}`,
                type: 'DELETE',
                success: function (response) {
                    notificationWeb(response.action, response.msg)
                },
                error: function (xhr) {
                    notificationWeb(response.action, response.msg)
                }
            });
        }
    });


}

function archiverAllTasks(catalogId) {
    Swal.fire({
        title: "Lưu trữ tất cả task?",
        text: "Bạn có chắc muốn lưu trữ toàn bộ task trong danh sách không!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Lưu trữ",
        cancelButtonText: "Đóng",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/catalogs/archiverAllTasks/${catalogId}`,
                type: 'POST',
                success: function (response) {
                    notificationWeb(response.action, response.msg)
                },
                error: function (xhr) {
                    notificationWeb(response.action, response.msg)
                }
            });
        }
    });
}

function restoreCatalog(catalogId) {
    $.ajax({
        url: `/catalogs/restoreCatalog/${catalogId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg)
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });
}

function destroyCatalog(catalogId) {
    $.ajax({
        url: `/catalogs/destroyCatalog/${catalogId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg)
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });
}

// cập nhật danh sách
$('.submitFormUpdateCatalog').on('submit', function (e) {
    e.preventDefault();

    var name = $(this).find('.nameUpdateTask').val().trim();
    var id = $(this).find('.id').val();
    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề')
        return;
    }
    $.ajax({
        url: `/catalogs/${id}`,
        type: 'PUT',
        data: $(this).serialize(),       // Lấy dữ liệu từ form
        success: function (response) {
            let titleCatalogViewBoard = document.getElementById(`title-catalog-view-board-${response.catalog.id}`)
            notificationWeb(response.action, response.msg);

            titleCatalogViewBoard.innerHTML = response.catalog.name; // thay đổi tên ở màn board
        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!')
        }
    });
});

//  sao chép danh sách
$('.submitFormCopyCatalog').on('submit', function (e) {
    e.preventDefault();

    var name = $(this).find('.nameCopyTask').val().trim();
    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề')
        return;
    }
    $.ajax({
        url: `/catalogs/copyCatalog`,
        type: 'POST',
        data: $(this).serialize(),       // Lấy dữ liệu từ form
        success: function (response) {
            notificationWeb(response.action, response.msg)
        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!')
        }
    });
});

// di chuyển danh sách
$('.submitFormMoveCatalog').on('submit', function (e) {
    e.preventDefault();
    var name = $(this).find('.nameMoveTask').val().trim();
    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề')
        return;
    }
    $.ajax({
        url: `/catalogs/moveCatalog`,
        type: 'POST',
        data: $(this).serialize(),       // Lấy dữ liệu từ form
        success: function (response) {
            notificationWeb(response.action, response.msg)
            if (response.action === 'success') window.location.href = `http://127.0.0.1:8000/b/${response.boardId}/edit?viewType=board`;
        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!')
        }
    });
});
