import './bootstrap';


Echo.channel(`catalogs.${boardId}`)
    .listen('RealtimeCreateCatalog', (e) => {
        console.log("Nhận sự kiện CatalogCreated:", e);
        addCatalogToCurrentView(e); // Gọi hàm chính để thêm catalog vào view hiện tại
    })
    .listen('RealtimeCatalogArchiver', (e) => {
        console.log("Nhận sự kiện RealtimeCatalogArchiver:", e);
        let catalogViewBoard = document.getElementById(`catalog_view_board_${e.catalog.id}`)
        if (catalogViewBoard) {
            catalogViewBoard.remove();
        }
        notificationWeb('', `Quản trị viên đã lưu trữ danh sách "${e.catalog.name}"`)
    })
    .listen('RealtimeCatalogRestore', (response) => {
        console.log("Nhận sự kiện RealtimeCatalogRestore:", response);
        notificationWeb('', response.msg)
        // Xóa catalog khỏi danh sách lưu trữ
        let catalogArchiver = document.getElementById(`catalog_id_archiver_${response.catalog.id}`);
        if (catalogArchiver) {
            catalogArchiver.remove();
        }
        let taskHTML = response.tasks.map(task => {
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
                colorPriority= 'text-danger';
            } else if (task.priority == 'Medium') {
                colorPriority= 'text-warning';
            } else if (task.priority == 'Low') {
                colorPriority= 'text-info';
            }
            let colorRisk = '';
            if (task.risk == 'High') {
                colorRisk= 'text-danger';
            } else if (task.risk == 'Medium') {
                colorRisk= 'text-warning';
            } else if (task.risk == 'Low') {
                colorRisk= 'text-info';
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
                                style="width: 40px;height: 15px; background-color: ${ tag.color_code }">
                            </div>
                        </div>
                        </div>
                `).join('');
            let checkListTask = task.checklists.map(checklist => `
                     ${checklist.totalChecklistComplete}/${checklist.totalChecklist}
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
                                ${task.totalTag >= 1 ? `
                                 <div class="flex-grow-1 d-flex align-items-center" style="height: 30px">
                                    <i class="ri-account-circle-line fs-20 me-2"></i>
                                    ${memberTaskHTML}
                                </div>
                                `:''}
                                ${dateTask}
                                ${task.totalTag >= 1 ? `
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="ri-price-tag-3-line fs-20 me-2"></i>
                                    ${tagTaskHTML}
                                </div>
                                `:''}

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
                                  ${task.totalComment >=1 ?
                `<li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted"><i
                                                class="ri-question-answer-line align-bottom"></i>
                                            ${task.totalComment}
                                        </a>
                                    </li>` : ''}
                                  ${task.totalAttachment >=1 ?
                `<li class="list-inline-item">
                                        <a href="javascript:void(0)" class="text-muted"><i
                                                class="ri-attachment-2 align-bottom"></i>
                                           ${task.totalAttachment}</a>
                                    </li>` : ''}
                                  ${task.totalChecklist >=1 ?
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

        //  catalog màn board
        let catalogHTML = `
            <div class="tasks-list rounded-3 p-2 border position-${response.catalog.position}" id="catalog_view_board_${response.catalog.id}" data-value="${response.catalog.id}">
                <div class="d-flex mb-3 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="fs-14 text-uppercase fw-semibold mb-0" id="title-catalog-view-board-${response.catalog.id}">
                            ${response.catalog.name}
                            <small class="badge bg-success align-bottom ms-1 totaltask-badge totaltask-catalog-${response.catalog.id}">${response.task_count}</small>
                        </h6>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                           <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="${response.catalog.id}">
                                <span class="fw-medium text-muted fs-12">
                                    <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                    <div id="${response.catalog.name}-${response.catalog.id}" class="tasks">
                        ${taskHTML}
                    </div>
                </div>
                <div class="my-3">
                    <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50" onclick="loadFormAddTask(${response.catalog.id})">
                        Thêm thẻ
                    </button>
                    <div class="dropdown-menu p-3 dropdown-content-add-task-${response.catalog.id}" style="width: 285px" aria-labelledby="dropdownMenuOffset2"></div>
                </div>
            </div>
            `;

        // Tìm danh sách catalog hiện tại
        let catalogs = Array.from(document.querySelectorAll('.tasks-list'));

        // Xác định vị trí chèn dựa trên position
        let inserted = false;
        for (let catalog of catalogs) {
            let currentPosition = parseInt(catalog.className.match(/position-(\d+)/)?.[1] || 0, 10);
            if (response.catalog.position < currentPosition) {
                // Chèn catalog trước catalog hiện tại
                catalog.insertAdjacentHTML('beforebegin', catalogHTML);
                inserted = true;
                break;
            }
        }

        // Nếu không có catalog nào có position lớn hơn, chèn vào cuối
        if (!inserted) {
            document.querySelector('.board-' + response.catalog.board_id).insertAdjacentHTML('beforebegin', catalogHTML);
        }
        window.tasks_list.push(document.getElementById(`${response.catalog.name}-${response.catalog.id}`));
    })
    .listen('RealtimeCatalogDetail', (e) => {
        console.log("Nhận sự kiện RealtimeCatalogDetail:", e);
        let titleCatalogViewBoard = document.getElementById(`title-catalog-view-board-${e.catalog.id}`);
        // Cập nhật tên ở màn hình board
        if (titleCatalogViewBoard) {
            titleCatalogViewBoard.innerHTML = e.catalog.name;
        }
    });

function addCatalogToCurrentView(catalog) {
    const currentView = getCurrentView(); // Xác định view hiện tại
    console.log("Current View:", currentView); // Log để xem view hiện tại
    switch (currentView) {
        case 'view1':
            addCatalogToKanbanBoard(document.getElementById("kanbanboard"), catalog);
            break;
        case 'view2':
            addCatalogToView2(catalog);
            break;
        // Thêm các view khác nếu cần
        default:
            console.error("Không xác định được view hiện tại.");
    }
}

// Hàm xác định màn hình hiện tại
function getCurrentView() {
    // Kiểm tra id hoặc class để xác định màn hình hiện tại
    if (document.getElementById("kanbanboard")) {
        console.log("Detected view1");
        return 'view1';
    } else if (document.getElementById("realtime-view-list")) {
        console.log("Detected view2");
        return 'view2';
    }
    return null; // Không xác định được view
}

// Hàm thêm catalog vào Kanban Board (view1)
function addCatalogToKanbanBoard(kanbanBoard, catalog) {
    let listCatalog = $('.board-' + catalog.board_id);
    const newCatalogDiv = document.createElement("div");
    newCatalogDiv.classList.add("tasks-list", "rounded-3", "p-2", "border",`position-${catalog.position}`);
    newCatalogDiv.setAttribute("data-value", catalog.id);
    newCatalogDiv.setAttribute("id", `catalog_view_board_${catalog.id}`);

    newCatalogDiv.innerHTML = `
        <div class="d-flex mb-3 align-items-center">
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0"  id="title-catalog-view-board-${catalog.id}">
                    ${catalog.name}
                   <small class="badge bg-success align-bottom ms-1 totaltask-badge
                                totaltask-catalog-${catalog.id}">0</small>
                </h6>
            </div>
             <div class="flex-shrink-0">
                <div class="dropdown card-header-dropdown">
                   <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                       data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="${catalog.id}">
                        <span class="fw-medium text-muted fs-12">
                            <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div data-simplebar class="tasks-wrapper px-3 mx-n3">
            <div id="${catalog.name}-${catalog.id}" class="tasks">
                <!-- task item -->
            </div>
        </div>
        <div class="my-3">
            <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50">
                Thêm thẻ
            </button>
            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
                <form>
                    <div class="mb-2">
                        <input type="text" id="add-task-catalog-${catalog.id}" class="form-control" name="text" placeholder="Nhập tên thẻ..."/>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <button type="button" class="btn btn-primary" onclick="submitAddTask(${catalog.id}, '${catalog.name}')">Thêm thẻ</button>
                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                    </div>
                </form>
            </div>
        </div>
    `;
    listCatalog.before(newCatalogDiv)

}

// Hàm thêm catalog vào View2 với giao diện đơn giản hơn
function addCatalogToView2(catalog) {
    let listMenuList = $('.menu-catalog-' + catalog.board_id);
    let menuList = `
                <a class="list-group-item list-group-item-action"
                   href="#${catalog.id}">${catalog.name} </a>
            `;
    if (listMenuList.length) {
        listMenuList.append(menuList);
    } else {
        console.error(`Không tìm thấy phần tử với class menu-catalog-${catalog.board_id}`);
    }
    let listCatalogList = $('.list-catalog-' + catalog.board_id);
    let catalogList = `
             <div class="card" id="catalog_view_list_${catalog.id}">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1">
                            <h6 class="fs-14 fw-semibold mb-0" value="${catalog.id}">${catalog.name}
                                  <small
                                    class="badge bg-warning align-bottom ms-1 totaltask-badge
                                     totaltask-catalog-${catalog.id}">
                                    0</small>
                            </h6>
                            <div class="d-flex ms-4">
                               <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                                   data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="${catalog.id}">
                                    <i class="ri-more-fill"></i>
                                </a>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-3" id="dropdownMenuOffset${catalog.id}"
                                         data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50"
                                        onclick="loadFormAddTask(${catalog.id})">
                                    <i class="ri-add-line align-bottom me-1"></i>Thêm thẻ
                                </button>
                                <div class="dropdown-menu p-3 dropdown-content-add-task-${catalog.id}" style="width: 285px"
                                     aria-labelledby="dropdownMenuOffset3">
<!--                                    // dropdown.createTask-->
                                </div>
                        </div>
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-3">
                        <table id="catalog-table-${catalog.id}" style="width:100%"
                               class="table table-bordered dt-responsive nowrap table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Thẻ</th>
                                <th>Thành viên</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Độ ưu tiên</th>
                                <th>Danh sách</th>

                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody id="body-catalog-${catalog.id}">
<!--                           // nội dung của task-->
                            </tbody>
                        </table>
                    </div>

                </div>
                <!--end card-body-->
            </div>
            `;
    if (listCatalogList) {
        listCatalogList.append(catalogList);
    } else {
        console.error(`Không tìm thấy phần tử với class '.list-catalog-${catalog.board_id}' `);
    }
}
