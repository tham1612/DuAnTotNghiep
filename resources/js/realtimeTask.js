import './bootstrap';

Echo.channel('tasks')
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
