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
            // thêm cấu trúc view vào trong setting bảng
            let taskHtml = `
            <div id="task_id_archiver_${response.task.id}">
                <div class="bg-warning-subtle border rounded ps-2">
                    <p class="fs-16 mt-2 text-danger">${response.task.text}</p>
                    <ul class="link-inline" style="margin-left: -32px">
                        <!-- theo dõi -->
                        <li class="list-inline-item">
                            <a href="javascript:void(0)" class="text-muted">
                                <i class="ri-eye-line align-bottom"></i> </a>
                        </li>
                        <!-- bình luận -->
                        <li class="list-inline-item">
                            <a href="javascript:void(0)" class="text-muted">
                                <i class="ri-question-answer-line align-bottom"></i> </a>
                        </li>
                        <!-- tệp đính kèm -->
                        <li class="list-inline-item">
                            <a href="javascript:void(0)" class="text-muted">
                                <i class="ri-attachment-2 align-bottom"></i> </a>
                        </li>
                        <!-- checklist -->
                        <li class="list-inline-item">
                            <a href="javascript:void(0)" class="text-muted">
                                <i class="ri-checkbox-line align-bottom"></i> </a>
                        </li>
                    </ul>
                </div>
                <div class="fs-13 fw-bold d-flex">
                    <span class="text-primary cursor-pointer" onclick="restoreTask(${response.task.id})">Khôi phục</span> -
                    <span class="text-danger cursor-pointer" onclick="destroyTask(${response.task.id})">Xóa</span>
                </div>
            </div>`;
            // Thêm vào DOM ở vị trí phù hợp
            let container = document.getElementById('task-container-setting-board'); // Chỉnh sửa ID của container theo nhu cầu
            container.insertAdjacentHTML('beforeend', taskHtml);

        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg);
        }
    });
}

function restoreTask(taskId) {
    let element = event.currentTarget;
    let dataValue = element.getAttribute('data-value');
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
            if (removedTask && originalParent && dataValue) {
                originalParent.appendChild(removedTask);
                removedTask = null; // Clear the stored task
                originalParent = null; // Clear the parent reference
            }

            //     hiển thị ra board

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


// quyền của bảng
function updatePriorityOrRisk(type, value, taskId) {
    $.ajax({
        url: `/tasks/updatePriorityOrRisk/${taskId}`,
        type: 'POST',
        data: {
            type: type,
            value: value,
        },
        success: function (response) {

            let taskRiskViewBoard = document.getElementById(`task-risk-view-board-${response.task.id}`)
            let taskPriorityViewBoard = document.getElementById(`task-priority-view-board-${response.task.id}`)


            if (taskRiskViewBoard) {
                taskRiskViewBoard.classList.add = '';
                const paragraph = taskRiskViewBoard.querySelector('p');
                if (paragraph) {
                    paragraph.innerHTML = `Rủi do: ${response.task.risk}`; // Thay thế "Nội dung mới của bạn" bằng nội dung mong muốn
                }
            }
            if (taskPriorityViewBoard) {
                const paragraph = taskPriorityViewBoard.querySelector('p');
                if (paragraph) {
                    paragraph.innerHTML = `Rủi do: ${response.task.risk}`; // Thay thế "Nội dung mới của bạn" bằng nội dung mong muốn
                }
            }
            // titleBoardNavbar.innerHTML = response.board.name
            // titleBoardSidebar.innerHTML = response.board.name
            //
            // if (response.board.access === 'private') {
            //     iconAccessBoardNavbar.classList.add('ri-lock-2-line')
            //     iconAccessBoardNavbar.classList.add('text-danger')
            //     iconAccessBoardNavbar.classList.remove('ri-shield-user-fill')
            //     iconAccessBoardNavbar.classList.remove('text-primary')
            //     textAccessBoardNavbar.innerHTML = 'Riêng tư'
            // }
            //
            // if (response.board.access === 'public') {
            //     iconAccessBoardNavbar.classList.add('ri-shield-user-fill')
            //     iconAccessBoardNavbar.classList.add('text-primary')
            //     iconAccessBoardNavbar.classList.remove('ri-lock-2-line')
            //     iconAccessBoardNavbar.classList.remove('text-danger')
            //
            //     textAccessBoardNavbar.innerHTML = 'Công khai'
            // }
        },
        error: function (error) {
            notificationWeb(response.action, response.msg)
        }
    });
}
