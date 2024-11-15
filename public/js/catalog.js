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
                    let catalogViewBoard = document.getElementById(`catalog_view_board_${response.catalog.id}`)
                    if (catalogViewBoard) {
                        catalogViewBoard.remove();
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
        cancelButtonText: "Đóng",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/catalogs/archiverAllTasks/${catalogId}`,
                type: 'POST',
                success: function (response) {
                    console.log(response.task)
                    response.task.forEach(item => {
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
            notificationWeb(response.action, response.msg)
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
            // xóa phần tử trong cài đặt
            let catalogArchiver = document.getElementById(`catalog_id_archiver_${catalogId}`);
            if (catalogArchiver) {
                catalogArchiver.remove();
            }
            notificationWeb(response.action, response.msg)

            //     hiển thị ra board

        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });
}


function destroyCatalog(catalogId) {
    $.ajax({
        url: `/catalogs/destroyCatalog/${catalogId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg)
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
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
