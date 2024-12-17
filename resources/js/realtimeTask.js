import './bootstrap';

// Echo.channel(`tasks`)
Echo.channel(`tasks.${boardId}`)
    .listen('RealtimeCreateTask', (e) => {
        console.log("Nhận sự kiện TaskCreated:", e);

        const catalogId = e.task.catalog_id; // ID của catalog mà task thuộc về

        // Tìm catalog dựa trên data-value
        const catalogElement = document.querySelector(`.tasks-list[data-value="${catalogId}"] .tasks`);

        if (catalogElement) {
            addTaskToCatalogViewBoard(catalogElement, e.task, e.catalog_name, e.tag_count); // Thêm task vào catalog nếu tìm thấy
        } else {
            console.error(`Không tìm thấy catalog với data-value: ${catalogId}`);
        }
    })
    .listen('RealtimeTaskKanban', (e) => {
        notificationWeb('', e.msg)
        console.log(e)
        // Lấy thông tin task và danh sách
        let taskElement = $(`#task_id_view_${e.task.id}`); // Tìm task cũ theo ID
        let listTask = document.getElementById(`${e.task.catalog.name}-${e.task.catalog_id}`); // Tìm danh sách chứa task
        let catalogNew = document.querySelector(`.totaltask-catalog-${e.task.catalog.id}`); // Tìm danh sách chứa task
        let catalogOld = document.querySelector(`.totaltask-catalog-${e.catalogIdOld}`); // Tìm danh sách chứa task

        if (catalogNew !== catalogOld) {
            catalogNew.innerHTML = Number(catalogNew.textContent) + 1;
            catalogOld.innerHTML = Number(catalogOld.textContent) - 1;
        }
        if (taskElement.length) {
            taskElement.remove();
        }

        // html của màn board
        let taskHTML = e.tasks.map(task => {
            let now = new Date();
            let endDate = new Date(task.end_date);
            let startDate = new Date(task.start_date);

            let colorbg = '';
            if (task.progress === 100) {
                colorbg = 'bg-success';
            } else if (now > endDate) {
                colorbg = 'bg-danger';
            } else if (now > startDate) {
                colorbg = 'bg-warning';
            } else {
                colorbg = 'bg-primary'; // Mặc định cho trạng thái không phù hợp các điều kiện trên
            }

            // Định dạng ngày tháng
            let formatendDate = endDate.toLocaleString('sv-SE', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            let formatstartDate = startDate.toLocaleString('sv-SE', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            // Xây dựng chuỗi HTML
            let dateTask = '';
            if (task.end_date && !task.start_date) {
                dateTask = `
                        <div class="flex-grow-1 d-flex align-items-center">
                            <i class="ri-calendar-event-line fs-20 me-2"></i>
                            <span class="badge ${colorbg}" id="date-view-board-${task.id}">
                                ${formatendDate}
                            </span>
                        </div>`;
            } else if (task.start_date && !task.end_date) {
                dateTask = `
                        <div class="flex-grow-1 d-flex align-items-center">
                            <i class="ri-calendar-event-line fs-20 me-2"></i>
                            <span class="badge ${colorbg}" id="date-view-board-${task.id}">
                                ${formatstartDate}
                            </span>
                        </div>`;
            } else if (task.start_date && task.end_date) {
                dateTask = `
                        <div class="flex-grow-1 d-flex align-items-center">
                            <i class="ri-calendar-event-line fs-20 me-2"></i>
                            <span class="badge ${colorbg}" id="date-view-board-${task.id}">
                                ${formatstartDate} - ${formatendDate}
                            </span>
                        </div>`;
            }
            let colorPriority = '';
            if (task.priority == 'High') {
                colorPriority = 'text-danger';
            } else if (task.priority == 'Medium') {
                colorPriority = 'text-warning';
            } else if (task.priority == 'Low') {
                colorPriority = 'text-info';
            }
            let colorRisk = '';
            if (task.risk == 'High') {
                colorRisk = 'text-danger';
            } else if (task.risk == 'Medium') {
                colorRisk = 'text-warning';
            } else if (task.risk == 'Low') {
                colorRisk = 'text-info';
            }

            let memberTaskHTML = task.members.map(member => `
                    <div class="avatar-group">
                        <a href="javascript: void(0);"
                           class="avatar-group-item border-0"
                           data-bs-toggle="tooltip" data-bs-placement="top"
                           title="${member.name}">
                            ${member.image ? `
                                <img
                                    src="/storage/${member.image}"
                                    alt=""
                                    class="rounded-circle avatar-xs"
                                    style="width: 30px; height: 30px">
                            ` : `
                                <div class="avatar-xs" style="width: 30px; height: 30px">
                                    <div class="avatar-title rounded-circle bg-info-subtle text-primary" style="width: 30px; height: 30px">
                                        ${member.name.substring(0, 1)}
                                    </div>
                                </div>
                            `}
                        </a>
                    </div>
                `).join('');
            let tagTaskHTML = task.tags.map(tag => `
                     <div class="d-flex flex-wrap gap-2">
                        <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                             data-bs-placement="top" title="${tag.name}">
                            <div
                                class="text-white border rounded d-flex align-items-center justify-content-center"
                                style="width: 40px;height: 15px; background-color: ${tag.color_code}">
                            </div>
                        </div>
                        </div>
                `).join('');
            let checkListTask = task.checklists.map(checklist => `
                     ${task.totalChecklistComplete}/${checklist.totalChecklist}
                `).join('');

            return `
                    <div class="card tasks-box cursor-pointer task-of-catalog-${task.catalog_id}" data-value="${task.id}" id="task_id_view_${task.id}">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <h6 class="fs-15 mb-0 flex-grow-1" data-bs-toggle="modal" data-bs-target="#detailCardModal" data-task-id="${task.id}">
                                    ${task.text}
                                </h6>
                            </div>
                            <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                                <!-- Ảnh bìa -->
                                ${task.image ? `
                                    <div class="tasks-img rounded" style="
                                        background-image: url('/storage/${task.image}');
                                        background-size: cover;
                                        background-position: center;
                                        width: 100%; height: 150px;">
                                    </div>
                                ` : ''}
                                <!-- giao việc cho thành viên -->
                                ${task.totalMember >= 1 ? `
                                 <div class="flex-grow-1 d-flex align-items-center" style="height: 30px">
                                    <i class="ri-account-circle-line fs-20 me-2"></i>
                                    ${memberTaskHTML}
                                </div>
                                ` : ''}
                                ${dateTask}
                                ${task.totalTag >= 1 ? `
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="ri-price-tag-3-line fs-20 me-2"></i>
                                    ${tagTaskHTML}
                                </div>
                                ` : ''}

                            </div>
                        </div>
                          <div class="card-footer border-top-dashed">
                        <div class="d-flex justify-content-end">
                            <div class="flex-shrink-0">
                                <ul class="link-inline mb-0">
                                   <li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted"
                                           title="Độ ưu tiên">
                                            <i id="task-priority-view-board-${task.id}" class="ri-flag-fill align-bottom
                                              ${colorPriority}"></i>
                                        </a>
                                    </li>
                                   <li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted" title="Rủi do">
                                            <i id="task-risk-view-board-{{$task->id}}" class=" ri-spam-fill align-bottom
                                             ${colorRisk}"></i>
                                        </a>
                                   </li>
                                  ${task.authFlow ?
                `<li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted"><i
                                                class="ri-eye-line align-bottom"></i>
                                        </a>
                                    </li>` : ''}
                                  ${task.totalComment >= 1 ?
                `<li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted"><i
                                                class="ri-question-answer-line align-bottom"></i>
                                            ${task.totalComment}
                                        </a>
                                    </li>` : ''}
                                  ${task.totalAttachment >= 1 ?
                `<li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted"><i
                                                class="ri-attachment-2 align-bottom"></i>
                                           ${task.totalAttachment}</a>
                                    </li>` : ''}
                                  ${task.totalChecklist >= 1 ?
                `<li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted"><i
                                                class="ri-checkbox-line align-bottom"></i>
                                        ${checkListTask}
                                    </li>` : ''}

                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                      `;
        }).join('');

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

function addTaskToCatalogViewBoard(catalogElement, task, catalog_name, tag_count) {
    let currentTaskCountElement = $('.totaltask-catalog-' + task.catalog_id);
    if (currentTaskCountElement.length) {
        let currentTaskCount = parseInt(currentTaskCountElement.text());
        // Kiểm tra xem currentTaskCount có phải là số hợp lệ không, nếu có thì tăng lên 1
        if (!isNaN(currentTaskCount)) {
            currentTaskCountElement.text(currentTaskCount + 1);
        } else {
            // Nếu không phải là số hợp lệ, đặt về 1
            currentTaskCountElement.text(1);
        }
    }
    let colorPriority = '';
    if (task.priority == 'High') {
        colorPriority = 'text-danger';
    } else if (task.priority == 'Medium') {
        colorPriority = 'text-warning';
    } else if (task.priority == 'Low') {
        colorPriority = 'text-info';
    }
    let colorRisk = '';
    if (task.risk == 'High') {
        colorRisk = 'text-danger';
    } else if (task.risk == 'Medium') {
        colorRisk = 'text-warning';
    } else if (task.risk == 'Low') {
        colorRisk = 'text-info';
    }
    let listTask = document.getElementById(`${catalog_name}-${task.catalog_id}`);
    let tasks = `
            <div class="card tasks-box cursor-pointer" data-value="${task.id}">
                <div class="card-body">
                    <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-task-view-board-${task.id}" data-bs-toggle="modal"
                                data-bs-target="#detailCardModal" data-task-id="${task.id}">
                             ${task.text}
                        </h6>

                    </div>
                    <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                        <!-- Ảnh bìa -->

                        <!-- giao việc cho thành viên-->

                        <!-- ngày bắt đầu & kết thúc -->

                        <!-- nhãn -->
                         <div class="flex-grow-1 d-flex align-items-center tag-task-section-${task.id}
                            ${tag_count ? '' : 'hidden'}">
                                <i class="ri-price-tag-3-line fs-20 me-2 ${tag_count ? '' : 'd-none'}
                                 tag-task-section-${task.id}"></i>
                                <div class="d-flex flex-wrap gap-2 tag-task-view-${task.id}">

                                </div>
                         </div>

                    </div>
                </div>
                <div class="card-footer border-top-dashed">
                    <div class="d-flex justify-content-end">
                        <div class="flex-shrink-0">
                            <li class="list-inline-item">
                                <a href="javascript:void(0)" class="text-muted"
                                   title="Độ ưu tiên">
                                    <i id="task-priority-view-board-${task.id}" class="ri-flag-fill align-bottom
                                      ${colorPriority}"></i>
                                </a>
                            </li>
                           <li class="list-inline-item">
                                <a href="javascript:void(0)" class="text-muted" title="Rủi do">
                                    <i id="task-risk-view-board-${task.id}" class=" ri-spam-fill align-bottom
                                     ${colorRisk}"></i>
                                </a>
                           </li>
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
