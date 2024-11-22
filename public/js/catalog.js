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
                    notificationWeb(response.action, response.msg);
                    $('#detailCardModalCatalog').modal('hide');
                    let catalogViewBoard = document.getElementById(`catalog_view_board_${response.catalog.id}`)
                    if (catalogViewBoard) {
                        catalogViewBoard.remove();
                    }
                    let catalogViewList = document.getElementById(`catalog_view_list_${response.catalog.id}`)
                    if (catalogViewList) {
                        catalogViewList.remove();
                    }
                    createCatalogViewSettingBoard(response.catalog.id, response.catalog.name);
                },
                error: function (xhr) {
                    notificationWeb('error', 'Đã có lỗi!!!')
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
        cancelButtonText: "Hủy",
    }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                        url: `/catalogs/archiverAllTasks/${catalogId}`,
                        type: 'POST',
                        success: function (response) {
                            notificationWeb(response.action, response.msg)
                            response.task.forEach(item => {
                                $('.task-of-catalog-' + catalogId).hide()
                                let taskViewBoard = document.getElementById(`task_id_view_${item.id}`)
                                if (taskViewBoard) {
                                    taskViewBoard.remove();
                                }
                                // Tạo cấu trúc HTML cho task mới
                                let taskHtml = `
            <div id="task_id_archiver_${item.id}">
                <div class="bg-warning-subtle border rounded ps-2">
                    <p class="fs-16 mt-2 text-danger">${item.text}</p>
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
                    <span class="text-primary cursor-pointer" onclick="restoreTask(${item.id})">Khôi phục</span> -
                    <span class="text-danger cursor-pointer" onclick="destroyTask(${item.id})">Xóa</span>
                </div>
            </div>`;

                                // Thêm vào DOM ở vị trí phù hợp
                                let container = document.getElementById('task-container-setting-board'); // Chỉnh sửa ID của container theo nhu cầu
                                container.insertAdjacentHTML('beforeend', taskHtml);
                            });
                            // })

                        },
                        error: function (xhr) {
                            notificationWeb(response.action, response.msg)
                        }
                    }
                )
                ;
            }
        }
    )
    ;
}

function restoreCatalog(catalogId) {
    $.ajax({
        url: `/catalogs/restoreCatalog/${catalogId}`,
        type: 'POST',
        success: function (response) {
            // Xóa catalog khỏi danh sách lưu trữ
            let catalogArchiver = document.getElementById(`catalog_id_archiver_${catalogId}`);
            if (catalogArchiver) {
                catalogArchiver.remove();
            }
            // nội dung trong của catalog màn board
            let taskHTML = response.tasks.map(task => `
                <div class="card tasks-box cursor-pointer task-of-catalog-${catalogId}" data-value="${task.id}" id="task_id_view_${task.id}">
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
                                    background-image: url('${task.image}');
                                    background-size: cover;
                                    background-position: center;
                                    width: 100%; height: 150px;">
                                </div>
                            ` : ''}
                            <!-- giao việc cho thành viên -->

                            <!-- ngày bắt đầu & kết thúc -->

                            <!-- nhãn -->
                        </div>
                    </div>
                    <div class="card-footer border-top-dashed">
                        <div class="d-flex justify-content-end">
                            <div class="flex-shrink-0">
                                <!-- Nút hoặc thông tin khác -->
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');

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
            // Thông báo thành công
            notificationWeb(response.action, response.msg);
        },
        error: function (xhr) {
            // Thông báo lỗi
            notificationWeb(response.action, response.msg);
        }
    });
}


function destroyCatalog(catalogId) {
    Swal.fire({
        title: "Xóa vĩnh viễn danh sách",
        text: "Xóa vĩnh viễn danh sách bạn không thể khôi phục lại, bạn có chắc muốn tiếp tục?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Đồng ý",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/catalogs/destroyCatalog/${catalogId}`,
                type: 'POST',
                success: function (response) {
                    notificationWeb(response.action, response.msg)
                    // Xóa catalog khỏi danh sách lưu trữ
                    let catalogArchiver = document.getElementById(`catalog_id_archiver_${catalogId}`);
                    if (catalogArchiver) {
                        catalogArchiver.remove();
                    }
                },
                error: function (xhr) {
                    notificationWeb(response.action, response.msg)
                }
            });
        }
    });

}

// cập nhật danh sách
$(document).on('submit', '.submitFormUpdateCatalog', function (e) {
    e.preventDefault(); // Ngăn chặn hành vi mặc định của form

    var name = $(this).find('.nameUpdateTask').val().trim();
    var id = $(this).find('.id').val();

    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề');
        return;
    }

    $.ajax({
        url: `/catalogs/${id}`,
        type: 'PUT',
        data: $(this).serialize(), // Lấy dữ liệu từ form
        success: function (response) {
            let titleCatalogViewBoard = document.getElementById(`title-catalog-view-board-${response.catalog.id}`);
            notificationWeb(response.action, response.msg);

            // Cập nhật tên ở màn hình board
            if (titleCatalogViewBoard) {
                titleCatalogViewBoard.innerHTML = response.catalog.name;
            }
        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!');
        }
    });
});


//  sao chép danh sách
$(document).on('submit', '.submitFormCopyCatalog', function (e) {
    e.preventDefault(); // Ngăn chặn hành vi mặc định của form

    var name = $(this).find('.nameCopyTask').val().trim();
    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề');
        return;
    }

    $.ajax({
        url: `/catalogs/copyCatalog`,
        type: 'POST',
        data: $(this).serialize(), // Lấy dữ liệu từ form
        success: function (response) {
            notificationWeb(response.action, response.msg);

            // Hiển thị ra board

        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!');
        }
    });
});


// di chuyển danh sách
$(document).on('submit', '.submitFormMoveCatalog', function (e) {
    e.preventDefault();

    var name = $(this).find('.nameMoveTask').val().trim();
    if (name === '') {
        notificationWeb('error', 'Vui lòng nhập tiêu đề');
        return;
    }

    // Vô hiệu hóa nút submit để ngăn người dùng submit nhiều lần
    var submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true);

    $.ajax({
        url: `/catalogs/moveCatalog`,
        type: 'POST',
        data: $(this).serialize(),       // Lấy dữ liệu từ form
        success: function (response) {
            notificationWeb(response.action, response.msg);
            if (response.action === 'success') {
                // URL chuyển hướng động hơn
                window.location.href = `${window.location.origin}/b/${response.boardId}/edit?viewType=board`;
            }
        },
        error: function (xhr, status, error) {
            notificationWeb('error', 'Có lỗi xảy ra!!');
        },
        complete: function () {
            // Kích hoạt lại nút submit khi quá trình AJAX hoàn tất
            submitButton.prop('disabled', false);
        }
    });
});


// tạo view
function createCatalogViewSettingBoard(id, name) {
    console.log("ID:", id, "Name:", name); // Kiểm tra xem giá trị có được truyền không

    // Tạo phần tử div cha
    let catalogDiv = document.createElement('div');
    catalogDiv.id = `catalog_id_archiver_${id}`;
    catalogDiv.className = 'd-flex align-items-center justify-content-between border rounded bg-warning-subtle mt-2';

    // Tạo phần tử p để hiển thị tên
    let catalogName = document.createElement('p');
    catalogName.className = 'fs-16 text-danger mt-3';
    catalogName.textContent = name;

    // Tạo phần tử div để chứa các nút
    let buttonDiv = document.createElement('div');

    // Tạo nút "Khôi phục"
    let restoreButton = document.createElement('button');
    restoreButton.className = 'btn btn-outline-dark';
    restoreButton.textContent = 'Khôi phục';
    restoreButton.setAttribute('onclick', `restoreCatalog(${id})`);

    // Tạo nút "Xóa"
    let deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-outline-dark';
    deleteButton.setAttribute('onclick', `destroyCatalog(${id})`);
    let deleteIcon = document.createElement('i');
    deleteIcon.className = 'ri-delete-bin-line';
    deleteButton.appendChild(deleteIcon);

    // Thêm các nút vào div chứa nút
    buttonDiv.appendChild(restoreButton);
    buttonDiv.appendChild(deleteButton);

    // Thêm p và div chứa nút vào div cha
    catalogDiv.appendChild(catalogName);
    catalogDiv.appendChild(buttonDiv);

    // Thêm div cha vào một phần tử nào đó trên trang
    let catalogContainer = document.getElementById('catalog-container-setting-board');
    if (catalogContainer) {
        catalogContainer.appendChild(catalogDiv);
    } else {
        console.error("catalogContainer không tồn tại!");
    }
}
