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
