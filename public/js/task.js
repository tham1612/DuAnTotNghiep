function archiverTask(taskId) {
    Swal.fire({
        title: "Lưu trữ task?",
        text: "Bạn có chắc muốn lưu trữ task không!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Lưu trữ",
        cancelButtonText: "Đóng",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/tasks/${taskId}`,
                type: 'DELETE',
                success: function (response) {
                    console.log('Lưu trữ task thành công');
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });

}

function restoreTask(taskId) {
    $.ajax({
        url: `/tasks/restoreTask/${taskId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb('success', 'Hoàn tác task thành công')
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

}

function destroyTask(taskId) {
    Swal.fire({
        title: "Xóa vĩnh viễn task",
        text: "Xóa vĩnh viễn task bạn không thể khôi phục lại, bạn có chắc muốn tiếp tục?",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Đóng",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/tasks/destroyTask/${taskId}`,
                type: 'POST',
                success: function (response) {
                    notificationWeb('success', 'Xóa vĩnh viễn task thành công')
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });

}


