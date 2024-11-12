// Variable to store the removed task element and its original parent
let removedTask = null;
let originalParent = null;

function archiverTask(taskId) {
    $.ajax({
        url: `/tasks/${taskId}`,
        type: 'DELETE',
        success: function (response) {
            notificationWeb(response.action, response.msg);
            // Find and remove the task element
            let task = document.getElementById(`task_id_view_${taskId}`);
            if (task) {
                // Store the task element and its parent for restoration
                removedTask = task;
                originalParent = task.parentElement;
                task.remove();
            }
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg);
        }
    });
}

function restoreTask(taskId) {
    $.ajax({
        url: `/tasks/restoreTask/${taskId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg);

            // xóa phần tử trong cài đặt
            let taskArchiver = document.getElementById(`task_id_archiver_${taskId}`);
            if (taskArchiver) {
                taskArchiver.remove();
            }

            // khôi phục phần tử ở view board
            if (removedTask && originalParent) {
                originalParent.appendChild(removedTask);
                removedTask = null; // Clear the stored task
                originalParent = null; // Clear the parent reference
            }

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
                    notificationWeb(response.action, response.msg)
                    let taskArchiver = document.getElementById(`task_id_archiver_${taskId}`);

                    if (taskArchiver) {
                        taskArchiver.remove();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });

}

// copy task
$(document).on('submit', '.submitFormCopyTask', function (e) {
    e.preventDefault();

    var name = $(this).find('.nameCopyTask').val().trim();
    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề')
        return false;
    }

    $.ajax({
        url: '/tasks/copyTask',
        type: 'POST',
        data: $(this).serialize(),       // Lấy dữ liệu từ form
        success: function (response) {
            notificationWeb(response.action, response.msg)
            // if (response.action === 'success') window.location.href = `http://127.0.0.1:8000/b/${response.board_id}/edit?viewType=board`;
        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!')
        }
    });
});
