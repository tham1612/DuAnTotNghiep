let isSubmittingCatalog = false;
let isSubmittingTask = false;
function submitAddCatalog( boardId) {
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
            let listCatalog = $('.board-' + boardId);
            let catalog = `
            <div class="tasks-list rounded-3 p-2 border" data-value="${response.catalog.id}">
                <div class="d-flex mb-3 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                            ${response.catalog.name}
                            <small
                                class="badge bg-success align-bottom ms-1 totaltask-badge">${response.task_count}</small>
                        </h6>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <span class="fw-medium text-muted fs-12">
                                    <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                                </span>
                            </a>
                            <!--                    setting list-->
                            <div class="dropdown-menu dropdown-menu-end">
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog(${response.catalog.id})">Thêm thẻ</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog(${response.catalog.id})">Sao chép danh sách</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog(${response.catalog.id})">Di chuyển danh sách</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog(${response.catalog.id})">Theo dõi</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="archiverCatalog(${response.catalog.id})">Lưu Trữ danh sách</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="archiverAllTasks(${response.catalog.id})">Lưu trữ tất cả thẻ trong danh sách</span>
                            </div>
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
                            aria-expanded="false" data-bs-offset="0,-50">
                        Thêm thẻ
                    </button>
                    <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
                        <form>
                            <div class="mb-2">
                                <input type="text" id="add-task-catalog-${response.catalog.id}" class="form-control " name="text"
                                       placeholder="Nhập tên thẻ..."/>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <button type="button" class="btn btn-primary " onclick="submitAddTask(${response.catalog.id},'${response.catalog.name}')">
                                    Thêm thẻ
                                </button>
                                <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            `;
            if (listCatalog) {
                listCatalog.before(catalog)
            } else {
                console.error('Không tìm thấy phần tử checkListcreat');
            }
             $('#nameCatalog').val('');
            notificationWeb(response.action, response.msg);
            $('.dropdown-menu').dropdown('hide');
            console.log('Catalog đã được thêm thành công!', response);
        },
        error: function(xhr) {
            notificationWeb(false,'thêm mới không thành công!')
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


function submitAddTask( catalogId,catalogName) {
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
            notificationWeb(response.action, response.msg)
            let listTask  = document.getElementById(catalogName +'-' + catalogId);
            let task = `
            <div class="card tasks-box cursor-pointer" data-value="${response.task.id}">
                <div class="card-body">
                    <div class="d-flex mb-2">
                        <h6 class="fs-15 mb-0 flex-grow-1  task-title" data-bs-toggle="modal"
                            data-bs-target="#detailCardModal${response.task.id}">
                           ${response.task.text}
                        </h6>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                               data-bs-toggle="dropdown" aria-expanded="false"><i
                                    class="ri-more-fill"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                <li>
                                    <span class="dropdown-item" href="#"><i
                                            class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                        Mở thẻ</span>
                                </li>
                                <li>
                                    <span class="dropdown-item" href="#"><i
                                            class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                        Chỉnh sửa nhãn</span>
                                </li>
                                <li>
                                    <span class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                        Thay đổi thành viên</span>
                                </li>
                                <li>
                                    <span class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                        Chỉnh sửa ngày</span>
                                </li>
                                <li>
                                    <span class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                        Sao chép</span>
                                </li>
                                <li>
                                    <span class="dropdown-item" data-bs-toggle="modal"
                                          onclick="archiverTask(${response.task.id})"><i
                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                        Lưu trữ</span>
                                </li>
                            </ul>
                        </div>
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
                            <ul class="link-inline mb-0">
                                <!-- theo dõi -->
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" class="text-muted"><i
                                            class="ri-eye-line align-bottom"></i>
                                        04</a>
                                </li>
                                <!-- bình luận -->
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" class="text-muted"><i
                                            class="ri-question-answer-line align-bottom"></i>
                                        19</a>
                                </li>
                                <!-- tệp đính kèm -->
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" class="text-muted"><i
                                            class="ri-attachment-2 align-bottom"></i>
                                        02</a>
                                </li>
                                <!-- checklist -->
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" class="text-muted"><i
                                            class="ri-checkbox-line align-bottom"></i>
                                        2/4</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            `;
            if (listTask) {
                listTask.innerHTML += task;
            } else {
                console.error('Không tìm thấy phần tử checkListcreat');
            }
            $('#add-task-catalog-' + catalogId).val('');
            notificationWeb(response.action, response.msg);
            $('.dropdown-menu').dropdown('hide');
            console.log('task đã được thêm thành công!', response);
        },
        error: function(xhr) {
            notificationWeb(false,'thêm mới không thành công!')
            console.log(xhr.responseText);
        },
        complete: function() {
            // Đặt lại cờ sau 3 giây để cho phép gửi lại
            setTimeout(() => {
                isSubmittingTask = false;
            }, 2000);
        }
    });
    return false;
}

$(document).on('click', '.task-title', function() {
    var targetModal = $(this).data('bs-target'); // Lấy ID của modal từ data-bs-target

    // Kiểm tra xem modal có tồn tại không
    if ($(targetModal).length) {
        var modalElement = document.getElementById(targetModal.replace('#', ''));
        var modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show(); // Hiển thị modal
    } else {
        console.error("Modal không tồn tại.");
    }
});
