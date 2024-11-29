import './bootstrap';

// Echo.channel(`tasks`)
Echo.channel(`tasks.${boardId}`)
    .listen('RealtimeCreateTask', (e) => {
        console.log("Nhận sự kiện TaskCreated:", e);

        const catalogId = e.task.catalog_id; // ID của catalog mà task thuộc về

        // Tìm catalog dựa trên data-value
        const catalogElement = document.querySelector(`.tasks-list[data-value="${catalogId}"] .tasks`);

        if (catalogElement) {
            addTaskToCatalogViewBoard(catalogElement, e.task, e.catalog_name); // Thêm task vào catalog nếu tìm thấy
        } else {
            console.error(`Không tìm thấy catalog với data-value: ${catalogId}`);
        }
    })
    .listen('RealtimeTaskKanban', (e) => {
        console.log("Nhận sự kiện RealtimeTaskKanban:", e);

// Lấy thông tin task và danh sách
        let taskElement = $(`#task_id_view_${e.task.id}`); // Tìm task cũ theo ID
        let listTask = document.getElementById(`${e.task.catalog.name}-${e.task.catalog_id}`); // Tìm danh sách chứa task


        if (taskElement.length) {
            taskElement.remove();
        }

// html của màn board
        let taskHTML = `
<div class="card tasks-box cursor-pointer" id="task_id_view_${e.task.id}" data-value="${e.task.id}">
    <div class="card-body">
        <div class="d-flex mb-2">
            <h6 class="fs-15 mb-0 flex-grow-1" data-bs-toggle="modal"
                data-bs-target="#detailCardModal" data-task-id="${e.task.id}">
                ${e.task.text}
            </h6>
        </div>
        <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
            <!-- Nội dung bổ sung -->
        </div>
    </div>
    <div class="card-footer border-top-dashed">
        <div class="d-flex justify-content-end">
            <div class="flex-shrink-0"></div>
        </div>
    </div>
</div>
`;

// Kiểm tra danh sách có tồn tại
        if (listTask) {
            let newTaskElement = $(taskHTML); // Tạo phần tử từ chuỗi HTML
            let tasks = $(listTask).find('.tasks-box'); // Tìm tất cả các task trong danh sách

            let inserted = false;
            tasks.each(function (index) {
                // Kiểm tra nếu vị trí mới bằng index + 1
                if (e.task.position === index + 1) {
                    $(this).before(newTaskElement); // Chèn trước phần tử có index lớn hơn
                    inserted = true;
                    return false; // Dừng lặp
                }
            });

            // Nếu không có vị trí phù hợp, chèn task vào cuối danh sách
            if (!inserted) {
                $(listTask).append(newTaskElement);
            }
        } else {
            console.error('Không tìm thấy danh sách tương ứng cho catalog');
        }

    })
    .listen('RealtimeTaskArchiver', (e) => {
        console.log("Nhận sự kiện RealtimeTaskArchiver:", e);
        let task = document.getElementById(`task_id_view_${e.task.id}`);
        let countCatalogViewBoard = document.querySelector(`.totaltask-catalog-${e.task.catalog_id}`);
        if (countCatalogViewBoard) countCatalogViewBoard.innerHTML = e.countCatalog
        if (task) {
            task.remove();
        }
        notificationWeb('', `Thẻ ${e.task.text} đã bị quản trị viên lưu trữ.`)
    });

function addTaskToCatalogViewBoard(catalogElement, task, catalog_name) {
    let listTask = document.getElementById(`${catalog_name}-${task.catalog_id}`);
    let tasks = `
            <div class="card tasks-box cursor-pointer" data-value="${task.id}">
                <div class="card-body">
                    <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 " data-bs-toggle="modal"
                                data-bs-target="#detailCardModal" data-task-id="${task.id}">
                             ${task.text}
                        </h6>

                    </div>
                    <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                        <!-- Ảnh bìa -->

                        <!-- giao việc cho thành viên-->

                        <!-- ngày bắt đầu & kết thúc -->

                        <!-- nhãn -->

                    </div>
                </div>
                <div class="card-footer border-top-dashed">
                    <div class="d-flex justify-content-end">
                        <div class="flex-shrink-0">

                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            `;
    if (listTask) {
        listTask.innerHTML += tasks;
    } else {
        console.error('Không tìm thấy phần tử này ở màn board');
    }
}
