// call forrm thêm catalog màn board, list
function loadFormAddCatalog(boardId) {
    $.ajax({
        url: `/catalogs/getFormCreateCatalog/${boardId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function(response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('.dropdown-content-add-catalog-' + boardId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

let isSubmittingCatalog = false;
let isSubmittingTask = false;
let isSubmittingTaskViewTable = false;

function submitAddCatalog(boardId) {
    if (isSubmittingCatalog) return; // Nếu đang xử lý, không cho phép submit
    isSubmittingCatalog = true;
    let formData = {
        board_id: boardId,
        name: $('#nameCatalog').val(),
    };
    $.ajax({
        url: `/catalogs`,
        type: 'POST',
        data: formData,
        success: function(response) {
            notificationWeb(response.action, response.msg);
            setTimeout(() => {
                isSubmittingCatalog = false;
            }, 2000);
            // màn board
            let listCatalog = $('.board-' + boardId);
            let catalog = `
            <div class="tasks-list rounded-3 p-2 border"id="catalog_view_board_${response.catalog.id}" data-value="${response.catalog.id}">
                <div class="d-flex mb-3 align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="fs-14 text-uppercase fw-semibold mb-0"
                         id="title-catalog-view-board-${response.catalog.id}">
                            ${response.catalog.name}
                            <small
                                class="badge bg-success align-bottom ms-1 totaltask-badge
                                totaltask-catalog-${response.catalog.id}">${response.task_count}</small>
                        </h6>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                           <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                               data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="${response.catalog.id}">
                                <span class="fw-medium text-muted fs-12">
                                    <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                    <div id="${response.catalog.name}-${response.catalog.id}" class="tasks">
                        <!-- task item -->

                    </div>
                </div>
                <div class="my-3">
                    <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown"
                            aria-expanded="false" data-bs-offset="0,-50" onclick="loadFormAddTask(${response.catalog.id})">
                        Thêm thẻ
                    </button>
                    <div class="dropdown-menu p-3 dropdown-content-add-task-${response.catalog.id}" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
<!--                    //    dropdown.createTask-->
                    </div>
                </div>
            </div>
            `;
            if (listCatalog) {
                listCatalog.before(catalog);
                const elementId = `${response.catalog.name}-${response.catalog.id}`;
                const element = document.getElementById(elementId);

                if (element) {
                    window.tasks_list.push(element);
                }
            } else {
                console.error('Không tìm thấy phần tử checkListcreat');
            }
            // màn list
            let listMenuList = $('.menu-catalog-' + boardId);
            let menuList = `
                <a class="list-group-item list-group-item-action"
                   href="#${response.catalog.id}">${response.catalog.name} </a>
            `;
            if (listMenuList.length) {
                listMenuList.append(menuList);
            } else {
                console.error(`Không tìm thấy phần tử với class menu-catalog-${boardId}`);
            }
            let listCatalogList = $('.list-catalog-' + boardId);
            let catalogList = `
             <div class="card" id="catalog_view_list_${response.catalog.id}">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1">
                            <h6 class="fs-14 fw-semibold mb-0" value="${response.catalog.id}">${response.catalog.name}
                                <small
                                    class="badge bg-warning align-bottom ms-1 totaltask-badge
                                     totaltask-catalog-${response.catalog.id}">
                                    ${response.task_count}</small>
                            </h6>
                            <div class="d-flex ms-4">
                               <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                                           data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="${response.catalog.id}">
                                            <i class="ri-more-fill"></i>
                                        </a>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-3" id="dropdownMenuOffset${response.catalog.id}"
                                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50"
                                        onclick="loadFormAddTask(${response.catalog.id})">
                                    <i class="ri-add-line align-bottom me-1"></i>Thêm thẻ
                                </button>
                                <div class="dropdown-menu p-3 dropdown-content-add-task-${response.catalog.id}" style="width: 285px"
                                     aria-labelledby="dropdownMenuOffset3">
<!--                                    // dropdown.createTask-->
                                </div>
                        </div>
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-3">
                        <table id="catalog-table-${response.catalog.id}" style="width:100%"
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
                            <tbody id="body-catalog-${response.catalog.id}">
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
                console.error(`Không tìm thấy phần tử với class '.list-catalog-${boardId}' `);
            }

            $('#nameCatalog').val('');

            $('.dropdown-menu').dropdown('hide');
            console.log('Catalog đã được thêm thành công!', response);
        },
        error: function(xhr) {
            notificationWeb(false, 'Thêm mới không thành công!')
            console.log(xhr.responseText);
        },
        complete: function() {
            // Đặt lại cờ sau 3 giây để cho phép gửi lại
            setTimeout(() => {
                isSubmittingCatalog = false;
            }, 2000);
        }
    });
    return false;
}

// call forrm thêm task màn board, list
function loadFormAddTask(catalogId) {
    $.ajax({
        url: `/tasks/getFormCreateTask/${catalogId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function(response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('.dropdown-content-add-task-' + catalogId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}
// call forrm thêm task màn table
function loadFormAddTaskViewTable(boardId) {
    $.ajax({
        url: `/tasks/getFormCreateTaskViewTable/${boardId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function(response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('.dropdown-add-task-view-table-' + boardId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}


function submitAddTask(catalogId, catalogName) {
    if (isSubmittingTask) return; // Nếu đang xử lý, không cho phép submit
    isSubmittingTask = true;
    let name = $('#add-task-catalog-' + catalogId).val();
    let formData = {
        catalog_id: catalogId,
        text: name,
    };
    console.log(formData.text)
    $.ajax({
        url: `/tasks`,
        type: 'POST',
        data: formData,
        success: function(response) {
            $('#add-task-catalog-' + catalogId).val('');
            notificationWeb(response.action, response.msg);
            $('.dropdown-menu').dropdown('hide');
            setTimeout(() => {
                isSubmittingTask = false;
            }, 2000);
            let currentTaskCountElement = $('.totaltask-catalog-' + catalogId);
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
            if (response.task.priority == 'High') {
                colorPriority = 'text-danger';
            } else if (response.task.priority == 'Medium') {
                colorPriority = 'text-warning';
            } else if (response.task.priority == 'Low') {
                colorPriority = 'text-info';
            }
            let colorRisk = '';
            if (response.task.risk == 'High') {
                colorRisk = 'text-danger';
            } else if (response.task.risk == 'Medium') {
                colorRisk = 'text-warning';
            } else if (response.task.risk == 'Low') {
                colorRisk = 'text-info';
            }
            let listTask = document.getElementById(catalogName + '-' + catalogId);
            let task = `
            <div class="card tasks-box cursor-pointer task-of-catalog-${catalogId}" data-value="${response.task.id}" id="task_id_view_${response.task.id}">
                <div class="card-body">
                    <div class="d-flex mb-2">
                            <h6 class="fs-15 mb-0 flex-grow-1 text-task-view-board-${response.task.id} " data-bs-toggle="modal"
                                data-bs-target="#detailCardModal" data-task-id="${response.task.id}">
                             ${response.task.text}
                        </h6>

                    </div>
                    <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                        <!-- Ảnh bìa -->

                        <!-- giao việc cho thành viên-->

                        <!-- ngày bắt đầu & kết thúc -->

                        <!-- nhãn -->
                         <div class="flex-grow-1 d-flex align-items-center tag-task-section-${response.task.id}
                            ${response.tag_count ? '' : 'hidden' }">
                                <i class="ri-price-tag-3-line fs-20 me-2 ${response.tag_count ? '' : 'd-none' }
                                 tag-task-section-${response.task.id}"></i>
                                <div class="d-flex flex-wrap gap-2 tag-task-view-${response.task.id}">

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
                                    <i id="task-priority-view-board-${response.task.id}" class="ri-flag-fill align-bottom
                                      ${colorPriority}"></i>
                                </a>
                            </li>
                           <li class="list-inline-item">
                                <a href="javascript:void(0)" class="text-muted" title="Rủi do">
                                    <i id="task-risk-view-board-${response.task.id}" class=" ri-spam-fill align-bottom
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
                listTask.innerHTML += task;
            } else {
                console.error('Không tìm thấy phần tử này ở màn board');
            }
            //  thêm task màn list
            let listTaskList = document.getElementById('body-catalog-' + catalogId);

            let taskList = `
            <input type="hidden" id="text_${response.task.id}" value="${response.task.text}">
            <tr draggable="true" class="task-of-catalog-${catalogId}">
                <td class="col-2">
                    <div class="d-flex">
                        <div class="flex-grow-1 text-task-view-board-${response.task.id}" data-bs-toggle="modal" data-bs-target="#detailCardModal" data-task-id="${response.task.id}">
                            ${response.task.text.substring(0, 20).toUpperCase()}
                        </div>
                    </div>
                </td>
                <td class="">
                    <div id="member1" class="cursor-pointer">
                        <div class="avatar-group d-flex justify-content-center" id="newMembar">
                            <span>
                                <i class="bx fs-20 bxs-user-plus cursor-pointer" data-bs-toggle="tooltip" title="Thêm thành viên"></i>
                            </span>
                        </div>
                    </div>
                </td>
                <form id="updatelistTaskForm_${response.task.id}">
                    <td class="col-2">
                        <input type="datetime-local" name="start_date" id="start_date_${response.task.id}" value="${response.task.start_date || ''}" class="form-control no-arrow" onchange="updateTaskList(${response.task.id})">
                    </td>

                    <td class="col-2">
                        <input type="datetime-local" name="end_date" id="end_date_${response.task.id}" value="${response.task.end_date || ''}" class="form-control no-arrow" onchange="updateTaskList(${response.task.id})">
                    </td>
                    <td class="">
                        <span class="badge ${getPriorityBadgeClass(response.task.priority)}" onclick="toggleSelect(${response.task.id});">
                            ${response.task.priority}
                        </span>
                        <select name="priority" id="priority_${response.task.id}" class="form-select no-arrow" style="display: none;" onchange="updateTaskList(${response.task.id})">
                            ${generatePriorityOptions(response.task.priority)}
                        </select>
                    </td>
                    <td>
                        <select name="catalog_id" id="catalog_id_${response.task.id}" class="form-select no-arrow" onchange="updateTaskList(${response.task.id});">
                            ${generateCatalogOptions(response.catalogs, response.task.catalog_id)}
                        </select>
                    </td>
                </form>
                <td class="">
                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                        <li><a class="dropdown-item" href="#"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Mở thẻ</a></li>
                        <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Chỉnh sửa nhãn</a></li>
                        <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Thay đổi thành viên</a></li>
                        <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Chỉnh sửa ngày</a></li>
                        <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Sao chép</a></li>
                        <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Lưu trữ</a></li>
                    </ul>
                </td>
            </tr>
            `;

            // Chèn taskList vào trong danh sách nếu tồn tại
            if (listTaskList) {
                listTaskList.innerHTML += taskList;
            } else {
                console.error('Không tìm thấy phần tử body-catalog-' + catalogId);
            }

            // Hàm để lấy lớp CSS cho priority
            function getPriorityBadgeClass(priority) {
                switch (priority) {
                    case 'High':
                        return 'bg-danger-subtle text-danger';
                    case 'Medium':
                        return 'bg-warning-subtle text-warning';
                    case 'Low':
                        return 'bg-success-subtle text-success';
                    default:
                        return 'bg-info-subtle text-info';
                }
            }

            // Hàm để tạo các option cho priority
            function generatePriorityOptions(selectedPriority) {
                const priorities = ['High', 'Medium', 'Low', 'Info'];
                return priorities.map(priority => `
                <option value="${priority}" ${selectedPriority === priority ? 'selected' : ''}>
                    ${priority}
                </option>
            `).join('');
            }

            // Hàm để tạo các option cho catalog_id
            function generateCatalogOptions(catalogs, selectedCatalogId) {
                // Kiểm tra nếu catalogs là mảng, nếu không thì chuyển nó thành một mảng rỗng
                if (!Array.isArray(catalogs)) {
                    console.error("Catalogs is not an array:", catalogs);
                    catalogs = []; // Gán giá trị mặc định để tránh lỗi
                }

                // Duyệt qua từng catalog và tạo các option
                return catalogs.map(catalog => {
                    // So sánh catalog.id và selectedCatalogId dưới dạng chuỗi để đảm bảo chính xác
                    const isSelected = String(selectedCatalogId) === String(catalog.id) ? 'selected' : '';

                    return `
            <option value="${catalog.id}" ${isSelected}>
                ${catalog.name}
            </option>
        `;
                }).join('');

            }

            getModalTaskEvents();
            console.log('task đã được thêm thành công!', response);
        },
        error: function(xhr) {
            notificationWeb('error', 'Có lỗi xảy ra!!')
            console.log(xhr.responseText);
        },

    });
    return false;
}

function submitAddTaskViewTable(catalogId, boarId) {
    if (isSubmittingTaskViewTable) return; // Nếu đang xử lý, không cho phép submit
    isSubmittingTaskViewTable = true;
    let name = $('.add-task-all-view').val();
    let formData = {
        catalog_id: catalogId,
        text: name,
    };
    console.log(formData.text)
    $.ajax({
        url: `/tasks`,
        type: 'POST',
        data: formData,
        success: function(response) {
            $('.add-task-all-view').val('');
            notificationWeb(response.action, response.msg);
            $('.dropdown-menu').dropdown('hide');
            setTimeout(() => {
                isSubmittingTaskViewTable = false;
            }, 2000);
            //  thêm task màn table
            let listTaskTable = document.getElementById('list-task-table-' + boarId);

            let taskTable = `
            <input type="hidden" id="text_${response.task.id}" value="${response.task.text}">
            <tr>
                <td>${response.task.id}</td>
                <td data-bs-toggle="modal" data-bs-target="#detailCardModal"
                    data-task-id="{{ $task->id }}">
                   ${response.task.text.substring(0, 30)}
                </td>
                <td  id="tag-view-table-task-${response.task.id}">
                                <!--     nhãn của task-->
                </td>
                <td class="col-1">
                    <div id="member1"
                         class="member cursor-pointer">
                        <div class="avatar-group d-flex justify-content-center" id="newMembar">
                            <span>
                                <i class="bx fs-20 bxs-user-plus cursor-pointer"
                                   data-bs-toggle="tooltip" title="Thêm thành viên"></i>
                            </span>
                        </div>
                    </div>
                </td>
                <form id="updateTaskForm${response.task.id}">
                    <td>
                        <select name="catalog_id" id="catalog_id_{{ $task->id }}"
                                class="form-select no-arrow"
                                onchange="updateTask(${response.task.id})">
                             ${generateCatalogOptionsViewTable(response.catalogs, response.task.catalog_id)}
                        </select>
                    </td>

                    <td class="col-2">
                        <input type="datetime-local" name="start_date"
                               id="start_date_${response.task.id}" value="${response.task.start_date || ''}"
                               class="form-control no-arrow"
                               onchange="updateTask(${response.task.id})">
                    </td>

                    <td class="col-2">
                        <input type="datetime-local" name="end_date"
                               value="${response.task.end_date || ''}"
                               id="end_date_${response.task.id}" class="form-control no-arrow"
                               onchange="updateTask(${response.task.id})">
                    </td>
                </form>

            </tr>
            `;
            if (listTaskTable) {
                listTaskTable.innerHTML += taskTable;
            } else {
                console.error('Không tìm thấy phần tử body-catalog-' + catalogId);
            }
            // Hàm để tạo các option cho catalog_id
            function generateCatalogOptionsViewTable(catalogs, selectedCatalogId) {
                // Kiểm tra nếu catalogs là mảng, nếu không thì chuyển nó thành một mảng rỗng
                if (!Array.isArray(catalogs)) {
                    console.error("Catalogs is not an array:", catalogs);
                    catalogs = []; // Gán giá trị mặc định để tránh lỗi
                }

                // Duyệt qua từng catalog và tạo các option
                return catalogs.map(catalog => {
                    // So sánh catalog.id và selectedCatalogId dưới dạng chuỗi để đảm bảo chính xác
                    const isSelected = String(selectedCatalogId) === String(catalog.id) ? 'selected' : '';

                    return `
            <option value="${catalog.id}" ${isSelected}>
                ${catalog.name}
            </option>
        `;
                }).join('');

            }
            getModalTaskEvents();
            console.log('task đã được thêm thành công!', response);
        },
        error: function(xhr) {
            notificationWeb('error', 'Có lỗi xảy ra!!')
            console.log(xhr.responseText);
        },

    });
    return false;
}

// load modal cài đặt catalog
$(document).on('click', '[data-bs-toggle="modal"][data-setting-catalog-id]', function() {
    const catalogId = $(this).data('setting-catalog-id');

    $.ajax({
        url: `/catalogs/getModalSettingCatalog/${catalogId}`,
        type: 'GET',
        success: function(response) {
            $('#detailCardModalCatalog').modal('show');
            $('.modal-setting-catalog').html(response.html);
        },
        error: function(xhr) {
            // console.error("Không thể tải dữ liệu catalog:", xhr);
        }
    });
});
