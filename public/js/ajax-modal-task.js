//  ============ navbar ========
document.getElementById('dropdownToggle').addEventListener('click', function () {
    let dropdownMenu = document.getElementById('dropdownMenu');
    dropdownMenu.style.display = (dropdownMenu.style.display === 'none') ? 'block' : 'none';
});

document.getElementById('dropdownMenu').addEventListener('click', function (e) {
    e.stopPropagation();
});

document.getElementById('closeDropdown').addEventListener('click', function () {
    document.getElementById('dropdownMenu').style.display = 'none';
});

document.getElementById('saveChanges').addEventListener('click', function () {
    document.getElementById('dropdownMenu').style.display = 'none';
});

document.addEventListener('click', function (event) {
    let dropdownMenu = document.getElementById('dropdownMenu');
    let dropdownToggle = document.getElementById('dropdownToggle');
    if (!dropdownMenu.contains(event.target) && !dropdownToggle.contains(event.target)) {
        dropdownMenu.style.display = 'none';
    }
});

function updateIsStar(boardId, userId,) {

    $.ajax({
        url: `/b/${boardId}/updateBoardMember`,
        method: "PUT",
        data: {
            board_id: boardId,
            user_id: userId,
        },
        success: function (response) {
            console.log('Người dùng đã đánh dấu bảng nối bật:', response);
        },
        error: function (xhr) {
            console.error('An error occurred:', xhr.responseText);
        }
    });
}


//  ============ end navbar ========


// ================ task ==================
// xử lý hiện ảnh ở tệp đính kèm
function initThumbnailModal(thumbnailSelector, modalImageId, imageModalId) {
    // Lấy tất cả các ảnh có class thumbnail
    var thumbnails = document.querySelectorAll(thumbnailSelector);
    var modalImage = document.getElementById(modalImageId);
    var imageModal = new bootstrap.Modal(document.getElementById(imageModalId));

    // Lặp qua tất cả các ảnh thu nhỏ
    thumbnails.forEach(function (thumbnail) {
        thumbnail.addEventListener('click', function () {
            // Lấy src của ảnh thu nhỏ và gán vào modal ảnh
            modalImage.src = thumbnail.src;

            // Hiển thị modal ảnh
            imageModal.show();

            // Lấy id của modal task chính từ thuộc tính data-modal-id của ảnh
            var taskModalId = thumbnail.getAttribute('data-modal-id');
            var taskModal = new bootstrap.Modal(document.getElementById(taskModalId));

            // Hàm xử lý khi modal ảnh đóng
            function handleModalClose() {
                taskModal.show();
                // Gỡ bỏ sự kiện này để tránh gọi lại khi đóng modal ảnh
                document.getElementById(imageModalId).removeEventListener('hidden.bs.modal', handleModalClose);
            }

            // Lắng nghe sự kiện modal ảnh bị đóng và mở lại modal task
            document.getElementById(imageModalId).addEventListener('hidden.bs.modal', handleModalClose);
        });
    });
}

// Gọi hàm với các tham số tùy chỉnh
//gọi modal task ở màn gantt và calender
function openCustomModal(taskId) {
    var modalElement = document.getElementById('detailCardModal');

    if (modalElement) {
        // Tải nội dung task qua AJAX
        $.ajax({
            url: '/tasks/getModalTask/' + taskId,
            type: 'GET',
            success: function(response) {
                $('.modal-task', modalElement).html(response.html); // Cập nhật nội dung modal

                // Khởi tạo modal instance và hiển thị modal
                var modalInstance = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false
                });
                modalInstance.show();

                // Xử lý sự kiện khi modal bị đóng để giải phóng instance và backdrop
                modalElement.addEventListener('hidden.bs.modal', function () {
                    modalInstance.dispose();
                    $('.modal-backdrop').remove(); // Xóa backdrop nếu vẫn còn
                    document.body.classList.remove('modal-open'); // Đảm bảo class modal-open bị xóa
                });
            },
            error: function(xhr) {
                console.error("Không thể tải dữ liệu task:", xhr);
            }
        });
    } else {
        console.error("Modal không tồn tại!");
    }
}


//gọi modal task ở màn board, table, list
function getModalTaskEvents() {
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const taskId = trigger.getAttribute('data-task-id');
            // Gọi AJAX để tải dữ liệu vào modal
            $.ajax({
                url: '/tasks/getModalTask/' + taskId,
                type: 'GET',
                success: function (response) {
                    $('#detailCardModal').modal('show');
                    $('.modal-task').html(response.html);
                    initThumbnailModal('.thumbnail', 'modalImage', 'imageModal');
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.addEventListener('click', event => {
                            event.stopPropagation();
                        });
                    });
                    attachNotificationEvent();
                },
                error: function (xhr) {
                    console.error("Không thể tải dữ liệu task:", xhr);
                }
            });
        });

    });
}

// Khởi tạo sự kiện modal khi trang được tải
document.addEventListener("DOMContentLoaded", function () {
    getModalTaskEvents();
});


function attachNotificationEvent() {
    document.querySelectorAll('[id^="notification_"]').forEach(notificationElement => {
        notificationElement.addEventListener('click', function () {
            // Lấy taskId từ id của phần tử
            const taskId = this.id.split('_')[1];

            // Lấy các phần tử liên quan
            const followElement = document.getElementById(`notification_follow_${taskId}`);
            const contentElement = document.getElementById(`notification_content_${taskId}`);
            const iconElement = document.getElementById(`notification_icon_${taskId}`);

            // Kiểm tra và chuyển đổi trạng thái
            if (followElement) {
                if (followElement.classList.contains('d-none')) {
                    // Đang ở trạng thái "Theo dõi", chuyển sang "Đang theo dõi"
                    followElement.classList.remove('d-none'); // Hiện dấu check
                    contentElement.innerText = 'Đang theo dõi'; // Thay đổi nội dung
                    iconElement.classList.replace('ri-eye-off-line', 'ri-eye-line'); // Thay đổi icon
                } else {
                    // Đang ở trạng thái "Đang theo dõi", chuyển sang "Theo dõi"
                    followElement.classList.add('d-none'); // Ẩn dấu check
                    contentElement.innerText = 'Theo dõi'; // Quay lại nội dung cũ
                    iconElement.classList.replace('ri-eye-line', 'ri-eye-off-line'); // Thay đổi icon về cũ
                }
            }
        });
    });
}


document.addEventListener('DOMContentLoaded', function () {
    // Hàm để cập nhật trạng thái hiển thị của các badge
    function updateBadgeStatus(taskId) {
        const checkbox = document.getElementById(`due_date_checkbox_${taskId}`);
        const successBadge = document.getElementById(`due_date_success_${taskId}`);
        const dueBadge = document.getElementById(`due_date_due_${taskId}`);
        const endDate = new Date(document.getElementById(`task_end_date_${taskId}`).value);
        const now = new Date();

        if (checkbox.checked) {
            // Nếu checkbox được chọn (Hoàn tất)
            successBadge.classList.remove('d-none'); // Hiện "Hoàn tất"
            dueBadge.classList.add('d-none'); // Ẩn "Quá hạn"
        } else {
            // Nếu checkbox chưa được chọn
            if (now > endDate) {
                // Hiện "Quá hạn" nếu đã quá hạn
                dueBadge.classList.remove('d-none');
                successBadge.classList.add('d-none');
            } else {
                // Ẩn cả "Hoàn tất" và "Quá hạn" nếu chưa quá hạn
                dueBadge.classList.add('d-none');
                successBadge.classList.add('d-none');
            }
        }
    }

    // Kiểm tra trạng thái ban đầu của tất cả checkbox khi tải trang
    document.querySelectorAll('input[id^="due_date_checkbox_"]').forEach(function (checkbox) {
        const taskId = checkbox.id.split('due_date_checkbox_')[1];
        updateBadgeStatus(taskId);
    });

    // Lắng nghe sự kiện thay đổi của checkbox
    document.addEventListener('change', function (event) {
        if (event.target.matches('input[id^="due_date_checkbox_"]')) {
            const taskId = event.target.id.split('due_date_checkbox_')[1];
            updateBadgeStatus(taskId);
        }
    });
});

// cập nhật mô tả, ảnh, checkbox
function updateTask2(taskId) {
    let description = editors['description_' + taskId] ? editors['description_' + taskId].getData() : '';
    let checkbox = document.getElementById('due_date_checkbox_' + taskId);
    let image = document.getElementById('image_task_' + taskId);

    let formData = new FormData();
    formData.append('description', description);
    formData.append('text', $('#text_' + taskId).val());
    if (checkbox) {
        formData.append('progress', checkbox.checked ? 100 : 0);
    } else {
        console.log('Checkbox không tồn tại');
    }
    // formData.append('progress', checkbox.checked ? 100 : 0);


    // Kiểm tra và thêm file ảnh nếu có
    if (image.files.length > 0) {
        console.log('xxxx'),
            formData.append('image', image.files[0]);
    }
    formData.append('_method', 'PUT');
    console.log([...formData]);
    console.log(image);
    $.ajax({
        url: `/tasks/` + taskId,
        method: "POST", // Sử dụng POST nhưng với method PUT
        dataType: 'json',
        data: formData,
        processData: false, // Bắt buộc phải false để không xử lý FormData thành chuỗi
        contentType: false, // Bắt buộc phải false để đặt đúng 'multipart/form-data'
        success: function (response) {
            if (response.task.image) {
                $('#detailCardModalLabel').css('background-image', `url('/storage/${response.task.image}')`);
            }
            notificationWeb(response.action, response.msg);
            console.log('Task updated successfully:', response);
        },
        error: function (xhr) {
            console.error('An error occurred:', xhr.responseText);
        }
    });
}

// follow task
function updateTaskMember(taskId, userId) {

    $.ajax({
        url: `/tasks/${taskId}/updateFolow`,
        method: "PUT",
        data: {
            task_id: taskId,
            user_id: userId,
        },
        success: function (response) {
            console.log('Người dùng đã folow Task:', response);

        },
        error: function (xhr) {
            console.error('An error occurred:', xhr.responseText);
        }
    });
}


// ============= tag  ==============
function loadTaskTag(taskId, boardId) {
    $.ajax({
        url: `/tasks/getListTagTaskBoard/${taskId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        data: {board_id: boardId},
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-list-tag-task-board-' + taskId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}


function loadFormCreateTag(taskId) {
    $.ajax({
        url: `/tasks/getFormCreateTag/${taskId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function (response) {
            // Biến lưu trữ mã màu được chọn, khởi tạo là null
            let selectedColor = null;
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-create-tag-' + taskId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

//============ end tag ================


// ============ date ============
function updateReminderOptions2(taskId) {
    let endDateInput = document.getElementById('end_date_task_' + taskId).value;

    // Kiểm tra xem sự kiện có được kích hoạt và giá trị của end_date
    console.log('updateReminderOptions2 called for task:', taskId);
    console.log('end_date value:', endDateInput);

    if (!endDateInput) {
        console.log('No end date provided.');
        return;
    }
    let endDate = new Date(endDateInput);

    let oneDayBefore = new Date(endDate);
    oneDayBefore.setDate(endDate.getDate() - 1); // Lùi lại 1 ngày

    let twoDaysBefore = new Date(endDate);
    twoDaysBefore.setDate(endDate.getDate() - 2); // Lùi lại 2 ngày

    // Định dạng ngày theo kiểu yyyy-mm-ddTHH:MM
    let formatDateTime = (date) => date.toISOString().slice(0, 16);

    // Lấy thẻ select nhắc nhở
    let reminderSelect = document.getElementById('reminder_date_task_' + taskId);

    // Xóa tất cả các option hiện tại
    reminderSelect.innerHTML = '';

    // Thêm các tùy chọn mới
    reminderSelect.innerHTML += `<option value="${formatDateTime(oneDayBefore)}">1 ngày trước</option>`;
    reminderSelect.innerHTML += `<option value="${formatDateTime(twoDaysBefore)}">2 ngày trước</option>`;
}

function loadFormAddDateTask(taskId) {
    $.ajax({
        url: `/tasks/${taskId}/getFormDateTask`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-content-add-date-task-' + taskId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}


function submitUpdateDateTask(taskId, event) {
    event.preventDefault(); // Ngăn hành động mặc định của form
    const startDateInput = document.getElementById('start_date_task_' + taskId).value;
    const endDateInput = document.getElementById('end_date_task_' + taskId).value;

    // Chuyển đổi giá trị sang đối tượng Date để so sánh
    const startDate = new Date(startDateInput);
    const endDate = new Date(endDateInput);

    // Kiểm tra nếu cả ngày bắt đầu và ngày kết thúc đều có giá trị
    if (startDateInput && endDateInput && startDate >= endDate) {
        // Hiển thị thông báo lỗi nếu ngày bắt đầu lớn hơn hoặc bằng ngày kết thúc
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ngày bắt đầu phải nhỏ hơn ngày kết thúc.",
        });
        return; // Dừng thực hiện hàm nếu có lỗi
    }
    // Sử dụng FormData để linh hoạt trong việc thêm dữ liệu
    let formData = new FormData();
    formData.append('text', document.getElementById('text_' + taskId).value);
    formData.append('start_date', document.getElementById('start_date_task_' + taskId).value);
    formData.append('end_date', document.getElementById('end_date_task_' + taskId).value);
    formData.append('reminder_date', document.getElementById('reminder_date_task_' + taskId).value);
    formData.append('_method', 'PUT'); // Để giả lập method PUT với Laravel
    $.ajax({
        url: `/tasks/` + taskId,
        method: "POST", // Sử dụng POST với method spoofing PUT
        dataType: 'json',
        processData: false, // Không xử lý dữ liệu (vì là FormData)
        contentType: false, // Để trình duyệt tự đặt Content-Type (multipart/form-data)
        data: formData,
        success: function (response) {
            let dateSection = document.getElementById(`date-section-` + taskId);
            let date = ''; // Khởi tạo biến date

            const now = new Date();

// Kiểm tra điều kiện cho start_date và end_date
            if (response.task.start_date && !response.task.end_date) {
                // Trường hợp chỉ có ngày bắt đầu
                date = `
                    <strong>Ngày bắt đầu</strong>
                    <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                         style="height: 35px; background-color: #091e420f; color: #172b4d">
                        <p class="ms-2 mt-3">${response.task.start_date}</p>
                    </div>
                `;
            } else if (response.task.end_date) {
                // Trường hợp có ngày hết hạn hoặc có cả ngày bắt đầu và ngày hết hạn
                const endDate = new Date(response.task.end_date);

                date = `
                    <strong>Ngày hết hạn</strong>
                    <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                         style="height: 35px; background-color: #091e420f; color: #172b4d">
                        <input type="checkbox" id="due_date_checkbox_${response.task.id}"
                               class="form-check-input"
                               onchange="updateTask2(${response.task.id})" name="progress"
                               ${response.task.progress == 100 ? 'checked' : ''} />
                        <input type="hidden" id="task_end_date_${response.task.id}"
                               value="${response.task.end_date}">
                        <p class="ms-2 mt-3">
                        ${response.task.start_date ? `  ${response.task.start_date}-` : ''}
                        ${response.task.end_date}</p>

                        ${response.task.progress == 100
                    ? `<span class="badge bg-success ms-2" id="due_date_success_${response.task.id}">Hoàn tất</span>`
                    : `
                            <span class="badge bg-success ms-2 ${now > endDate ? 'd-none' : ''}" id="due_date_success_${response.task.id}">Hoàn tất</span>
                            <span class="badge bg-danger ms-2 ${now > endDate ? '' : 'd-none'}" id="due_date_due_${response.task.id}">Quá hạn</span>
                        `}
                    </div>
                `;
            }
            if (dateSection) {
                if (dateSection.style.display === 'none') {
                    dateSection.style.display = 'block'; // Hiển thị lại phần tử nếu đang bị ẩn
                }
                dateSection.innerHTML = date; // Thay thế toàn bộ nội dung của `dateSection`
            } else {
                console.error(`Không tìm thấy phần tử với id date-section-${taskId}`);
            }
            console.log('Task updated successfully:', response);
        },
        error: function (xhr) {
            console.error('An error occurred:', xhr.responseText);
        }
    });

    return false;
}

// ============ end date ============


//  ========= checklist ==============
// Xử lý sự kiện khi checkbox được chọn
$(document).ready(function () {
    // Đảm bảo sự kiện 'change' chỉ chạy khi DOM đã sẵn sàng
    $(document).on('change', '.form-check-input-tag', function () {
        let data = $(this).val(); // Lấy giá trị tag ID
        console.log(data);

        $.ajax({
            url: '/tasks/tag/update', // Địa chỉ endpoint của bạn
            type: 'POST',
            data: {data: data},
            success: function (response) {
                let tagSection = document.getElementById(`tag-section-${response.task_id}`);
                let tagTask = document.getElementById('tag-task-' + response.task_id);

                // Hiển thị tag nếu được thêm và section hiện đang ẩn
                if (response.action === 'added' && tagSection && tagSection.style.display === 'none') {
                    tagSection.style.display = 'block';
                }

                // Tìm và xử lý tag item dựa trên hành động
                let tagItem = document.querySelector(`[data-tag-id="${response.task_id}-${response.tag_id}"]`);
                if (response.action === 'added') {
                    // Tạo nội dung tag mới
                    let tagTaskAdd = `
                        <div class="tag-item" data-tag-id="${response.task_id}-${response.tag_id}"
                             data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                             title="${response.tagTaskName}">
                            <div class="badge border rounded d-flex align-items-center justify-content-center"
                                 style="background-color: ${response.tagTaskColor}">
                                ${response.tagTaskName}
                            </div>
                        </div>
                    `;
                    if (tagTask) {
                        tagTask.innerHTML += tagTaskAdd;
                    } else {
                        console.error('Element tag-task-' + response.task_id + ' not found.');
                    }
                } else if (response.action === 'removed') {
                    // Xóa tag
                    if (tagItem) {
                        tagItem.remove();
                    }
                    if (tagTask && tagTask.children.length === 0) {
                        tagSection.style.display = 'none';
                    }
                }
                console.log('Checkbox đã được cập nhật:', response);
            },
            error: function (xhr, status, error) {
                console.error('Có lỗi xảy ra:', error);
            }
        });
    });
});


// thêm checklist
function FormCheckListItem(checkListId) {
    let formData = {
        check_list_id: $('#check_list_id_' + checkListId).val(),
        name: $('#name_check_list_item_' + checkListId).val()
    };
    console.log(formData)
    if (!formData.name.trim()) {
        alert('Tiêu đề không được để trống!');
        return false;
    }

    $.ajax({
        url: `/tasks/checklist/checklistItem/create`,
        type: 'POST',
        data: formData,
        success: function (response) {

            let maxDisplay = 2;
            let count = 0;
            let end_date = ``;
            if (response.end_date) {
                end_date = `<span data-bs-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false"
                      id="dropdownToggle_dateChecklistItem_{{ $checklistItem->id }}"
                      onclick="loadTaskFormAddDateCheckListItem(${response.id})">
                               ${response.end_date}
                            </span>`;
            } else {
                end_date = ` <i class="ri-time-line fs-20 " data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"
               onclick="loadTaskFormAddDateCheckListItem(${response.id})"
               id="dropdownToggle_dateChecklistItem_${response.id}"></i>`;
            }

            let checkList = document.getElementById('check-list-' + response.check_list_id);
            let listItem = `
        <tr class="cursor-pointer check-list-item-${response.id}">
            <td class="col-1">
                <div class="form-check">
                    <input class="form-check-input-checkList"
                       type="checkbox" name="is_complete"
                       ${response.is_complete ? 'checked' : ''}
                       value="100"
                       id="is_complete-${response.id}"
                       data-checklist-id="${response.check_list_id}"
                        data-checklist-item-id="${response.check_list_id}"
                       data-task-id="${response.task_id}"/>
                </div>
            </td>
            <td>${response.checkListItem.name}</td>
            <td class="d-flex justify-content-end">
                <div>
                     ${end_date}
                    <div class="dropdown-menu dropdown-menu-md p-3 w-50"
                         id="dropdown-content-add-date-check-list-item-${response.id}"
                         aria-labelledby="dropdownToggle_dateChecklistItem_${response.id}">
                    </div>
                </div>
                <div class="avatar-group d-flex justify-content-center">
                     <div class="d-flex justify-content-center" id="member-add-checkListItem-${response.id}">
                                        </div>
                `;
            if (Array.isArray(response.checkListItem.members)) {
                response.checkListMembers.forEach((checkListItemMember, index) => {
                    if (count < maxDisplay) {
                        listItem += `
                            <a href="javascript: void(0);" class="avatar-group-item"
                               data-bs-toggle="tooltip" data-bs-placement="top"
                               title="${checkListItemMember.user.name}">
                            `;

                        if (checkListItemMember.user.image) {
                            // Nếu người dùng có ảnh đại diện
                            listItem += `<img src="/storage/${checkListItemMember.user.image}" alt=""
                                     class="rounded-circle avatar-xxs object-fit-cover">`;
                        } else {
                            // Nếu người dùng không có ảnh đại diện, hiển thị ký tự đầu của tên
                            listItem += `
                                    <div class="avatar-xxs">
                                        <div class="bg-info-subtle rounded-circle avatar-xxs d-flex justify-content-center align-items-center">
                                            ${checkListItemMember.user.name.charAt(0).toUpperCase()}
                                        </div>
                                    </div>
                                `;
                        }

                        listItem += `</a>`;
                        count++;
                    }
                });

                // Kiểm tra nếu có nhiều hơn `maxDisplay` thành viên, hiển thị số dư
                if (response.checkListMembers.length > maxDisplay) {
                    listItem += `
                        <a href="javascript: void(0);" class="avatar-group-item"
                           data-bs-toggle="tooltip" data-bs-placement="top"
                           title="${response.checkListMembers.length - maxDisplay} more">
                            <div class="avatar-xxs">
                                <div class="avatar-title rounded-circle avatar-xxs bg-info-subtle d-flex justify-content-center align-items-center text-black">
                                    +${response.checkListMembers.length - maxDisplay}
                                </div>
                            </div>
                        </a>
                         `;
                }
            }

            // Thêm biểu tượng để thêm thành viên
            listItem += `
                    <i class="ri-user-add-line fs-20" data-bs-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"
                       onclick="loadChecklistItemFormAddMember(${response.id}, ${response.boardId})"
                       id="dropdownToggle_${response.id}"></i>
                    <div id="dropdown-content-add-member-check-list-${response.id}"
                         class="dropdown-menu dropdown-menu-md p-3 w-50">
                    </div>
                `;

            // Kết thúc chuỗi HTML và đóng các thẻ còn lại
            listItem += `
                        </div>
                        <div>
                        <i class="ri-more-fill fs-20" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false"></i>
                        <div class="dropdown-menu dropdown-menu-md"
                             style="padding: 15px 15px 0 15px">
                            <h5 class="text-center">Thao tác
                                mục</h5>
                            <p class="mt-2">Chuyển sang thẻ</p>
                            <p class="cursor-pointer text-danger"
                               onclick="removeCheckListItem(${response.id},${response.check_list_id})">
                                Xóa</p>

                        </div>
                    </div>
                    </td>
                </tr>
                `;


            if (checkList) {
                // Thêm checklist item mới vào cuối danh sách
                checkList.insertAdjacentHTML('beforeend', listItem);

                // Gọi lại `updateProgressBar` để cập nhật thanh tiến trình cho checklist hiện tại
                updateProgressBar(response.check_list_id);
            } else {
                console.error('Không tìm thấy phần check-list-' + response.check_list_id);
            }

            // Xóa giá trị input sau khi thêm
            $('#name_check_list_item_' + checkListId).val('');
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
            $(this).find('button[type="submit"]').prop('disabled', false);
        }
    });

    return false;
}

$(document).on('change', '.form-check-input-checkList', function () {
    let checkListItemId = $(this).data('checklist-item-id');
    let checkbox = $(this);

    if (!checkbox.length) {
        console.log('Không tìm thấy checkbox với checkListItemId:', checkListItemId);
        return;
    }
    let formData = new FormData();
    formData.append('is_complete', checkbox.is(':checked') ? 1 : 0);
    formData.append('check_list_item_id', checkListItemId);
    formData.append('_method', 'PUT');

    console.log(checkListItemId)
    $.ajax({
        url: `/tasks/checklist/checklistItem/${checkListItemId}/update`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('ChecklistItem đã được cập nhật thành công!', response);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
});


function loadTaskFormAddCheckList(taskId) {
    $.ajax({
        url: `/tasks/getFormCheckList/${taskId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-content-add-checkList-' + taskId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

function submitAddCheckList(taskId) {
    let formData = {
        task_id: taskId,
        name: $('#name_checkList_' + taskId).val(),
        method: 'POST'
    };
    $.ajax({
        url: `/tasks/checklist/create`,
        type: 'POST',
        data: formData,

        success: function (response) {
            let checkList = document.getElementById('checkListCreate-' + taskId);
            let listItem = `
                <div class="row mt-3 list-checklist-${response.checkListId}" >
        <section class="d-flex justify-content-between">
            <section class="d-flex">
                <i class="ri-checkbox-line fs-22"></i>
                <!-- Lặp qua từng checklist -->
                <input type="text" name="name"
                       class="form-control border-0 ms-1 fs-18 fw-medium bg-transparent ps-0"
                       id="name_${response.checkListId}" value="${response.name}"
                       />
            </section>
            <button class="btn btn-outline-dark" style="height: 35px"
                    data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                Xóa
            </button>
            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                <h5 class="text-center">Bạn có muốn xóa Việc cần làm</h5>

                <p>Danh sách sẽ bị xóa vĩnh viễn và không thể khôi phục</p>

                <button class="btn btn-danger w-100" onclick="removeCheckList(${response.checkListId})">Xóa danh sách công việc
                </button>
            </div>
        </section>

        <div class="ps-4">
             <div class="progress animated-progress bg-light-subtle" style="height: 20px"
                     data-checklist-id="${response.checkListId}">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%"
                         id="progress-bar-checklist-${response.checkListId}" aria-valuenow="0" aria-valuemin="0"
                         aria-valuemax="100">
                        0%
                    </div>
                </div>
            <div class="table-responsive table-hover table-card">
                <table class="table table-nowrap mt-4">
                    <tbody id="check-list-${response.checkListId}">
                    <tr class="cursor-pointer addOrUpdate-checklist d-none">
                        <td colspan="2">
                            <form class="formItem">
                                <input type="hidden" name="check_list_id"
                                       id="check_list_id_${response.checkListId}"
                                       value="${response.checkListId}">
                                <input type="text" name="name"
                                       id="name_check_list_item_${response.checkListId}"
                                       class="form-control checklistItem"
                                       placeholder="Thêm mục"/>

                                <div
                                    class="d-flex mt-3 justify-content-between">
                                    <div>
                                        <button type="button"
                                                class="btn btn-primary"
                                                onclick="FormCheckListItem(${response.checkListId})">
                                            Thêm
                                        </button>
                                        <a class="btn btn-outline-dark disable-checklist">Hủy</a>
                                    </div>

                                </div>
                            </form>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-outline-dark ms-3 mt-2 display-checklist"
                    type="button" id="">
                Thêm mục
            </button>
        </div>
    </div>
            `;
            if (checkList) {
                checkList.innerHTML += listItem;
            } else {
                console.error('Không tìm thấy phần tử checkListcreat');
            }
            $('#name_checkList_' + taskId).val('');
            console.log('checklist đã được thêm thành công!', response);

        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
        }
    });

    return false;
}

function submitUpdateCheckList(checklistId, taskId) {
    let formData = {
        task_id: taskId,
        name: $('#name_' + checklistId).val()
    };


    if (!formData.name.trim()) {
        alert('Tiêu đề không được để trống!');
        return false;
    }

    $.ajax({
        url: `/tasks/${checklistId}/checklist`,
        type: 'PUT',
        data: formData,
        success: function (response) {
            console.log('Task đã được cập nhật thành công!', response);
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
        }
    });

    return false;
}

// document.addEventListener('DOMContentLoaded', function () {
document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện click trên tất cả các checkbox trong DOM
    document.addEventListener('click', function (event) {
        const checkbox = event.target;

        // Kiểm tra xem click có phải là checkbox thuộc checklist không
        if (checkbox.classList.contains('form-check-input-checkList')) {
            const checklistId = checkbox.getAttribute('data-checklist-id');
            if (checklistId) {
                updateProgressBar(checklistId); // Cập nhật thanh progress cho checklist cụ thể
            } else {
                console.error('Checklist ID not found on checkbox');
            }
        }
    });

    // Lấy tất cả các checkbox
    const checkboxes = document.querySelectorAll('.form-check-input-checkList');
    checkboxes.forEach(checkbox => {
        checkbox.onclick = function () {
            const checklistId = this.getAttribute('data-checklist-id');
            if (checklistId) {
                updateProgressBar(checklistId);
            } else {
                console.error('Checklist ID not found on checkbox');
            }
        };
    });


    // Cập nhật thanh tiến trình ban đầu cho mỗi checklist
    const checklists = new Set(Array.from(checkboxes).map(checkbox => checkbox.getAttribute('data-checklist-id')));
    checklists.forEach(checklistId => updateProgressBar(checklistId));
});
document.querySelector('table').addEventListener('click', function (event) {
    const checkbox = event.target;

    if (checkbox.classList.contains('form-check-input-checkList')) {
        const checklistId = checkbox.getAttribute('data-checklist-id');
        if (checklistId) {
            updateProgressBar(checklistId);
        } else {
            console.error('Checklist ID not found on checkbox');
        }
    }
});


function updateProgressBar(checklistId) {
    // Lấy tất cả các checkbox thuộc về checklist có checklistId cụ thể
    const checklistCheckboxes = Array.from(document.querySelectorAll(`.form-check-input-checkList[data-checklist-id="${checklistId}"]`));
    const totalCheckboxes = checklistCheckboxes.length;
    const checkedCheckboxes = checklistCheckboxes.filter(checkbox => checkbox.checked).length;

    // Tính phần trăm hoàn thành
    const percentCompleted = (totalCheckboxes > 0) ? (checkedCheckboxes / totalCheckboxes) * 100 : 0;
    $.ajax({
        url: `/tasks/${checklistId}/checklist`,
        type: 'PUT',
        data: {
            progress:percentCompleted
        },
        success: function (response) {
            // Cập nhật thanh tiến trình cho checklist tương ứng
            const progressBar = document.getElementById('progress-bar-checklist-' + checklistId);
            if (progressBar) {
                progressBar.style.width = percentCompleted + '%';
                progressBar.setAttribute('aria-valuenow', percentCompleted);
                progressBar.innerHTML = Math.round(percentCompleted) + '%';
            } else {
                console.error(`Không tìm thấy thanh tiến trình cho checklist ID: ${checklistId}`);
            }
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
        }
    });
}

// Lắng nghe sự kiện thay đổi trên từng checkbox

// });
// ============= end checklist ======================


// ============= checklist item member ===============
function loadChecklistItemFormAddMember(checkListItemId) {
    $.ajax({
        url: `/tasks/checklist/checklistItem/getFormAddMember/${checkListItemId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        data: {},
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-content-add-member-check-list-' + checkListItemId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

function loadTaskFormAddDateCheckListItem(checkListItemId) {
    $.ajax({
        url: `/tasks/checklist/checklistItem/${checkListItemId}/getFormDate`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-content-add-date-check-list-item-' + checkListItemId).html(response.html);

            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

function onclickAddMemberCheckListItem(memberId, memberName, checklistItemId) {
    if (document.getElementById('card-member-' + memberId + '-' + checklistItemId)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: memberName + " đã có trong danh sách thành viên của thẻ.",

        });
        return;
    }
    $.ajax({
        url: `/checklistItem/addMemberChecklist`,
        type: 'POST',
        data: {
            user_id: memberId,
            check_list_item_id: checklistItemId,
        },
        success: function (response) {
            let user = '';
            if (response.userImage) {
                user = `<img src="/storage/${response.userImage}"
                alt="" class="rounded-circle avatar-xxs object-fit-cover">`;
            } else {
                user = ` <div class="avatar-xxs">
                        <div
                            class="bg-info-subtle rounded-circle avatar-xxs d-flex
                            justify-content-center align-items-center">
                           ${response.userName.charAt(0).toUpperCase()}
                        </div>
                    </div>`;
            }

            let cardMembersListItem = document.getElementById('cardMembersListItem-' + checklistItemId);
            let listItem = `
                <li id="card-member-${memberId}-${checklistItemId}" class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" title="${memberName}">
                            <div class="avatar-sm">
                                <div class="avatar-title rounded-circle bg-light text-primary">
                                    ${memberName.charAt(0).toUpperCase()}
                                </div>
                            </div>
                        </a>
                        <p class="ms-3 mt-3">${memberName}</p>
                    </div>
                    <i class="ri-close-line fs-20" onclick="removeMemberFromCard(${memberId}, ${checklistItemId})"></i>
                </li>
            `;
            let memberCheckListItem = document.getElementById('member-add-checkListItem-' + checklistItemId);
            let memberCheckListItemAdd = `
            <a href="javascript: void(0);" class="avatar-group-item"
            id="member-checklist-${memberId}-${checklistItemId}"
               data-bs-toggle="tooltip" data-bs-placement="top"
               title="${response.userName}">
                ${user}
            </a>
            `;
            cardMembersListItem.innerHTML += listItem;
            memberCheckListItem.innerHTML += memberCheckListItemAdd;
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.addEventListener('click', event => {
                    event.stopPropagation();
                });
            });
            console.log('Thành viên đã được thêm vào checkListMember thành công.');
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

function removeMemberFromCard(memberId, checklistItemId) {
    $.ajax({
        url: `/checklistItem/deleteMemberChecklist`,
        type: 'POST',
        data: {
            user_id: memberId,
            check_list_item_id: checklistItemId
        },
        success: function (response) {
            let memberElement = document.getElementById('card-member-' + memberId + '-' + checklistItemId);
            let memberElement1 = document.getElementById('member-checklist-' + memberId + '-' + checklistItemId);
            if (memberElement1) {
                memberElement1.remove();
            }
            if (memberElement) {
                memberElement.remove();
            }
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.addEventListener('click', event => {
                    event.stopPropagation();
                });
            });
            console.log('Thành viên đã được xóa thành công khỏi thẻ.');
        },
        error: function (xhr) {
            alert('Có lỗi xảy ra khi xóa thành viên.');
            console.log(xhr.responseText);
        }
    });
}

function removeCheckList(checklistId) {
    console.log(checklistId);
    $.ajax({
        url: `/tasks/${checklistId}/deleteChecklist`,
        type: 'POST',
        data: {
            id: checklistId
        },
        success: function (response) {
            $('.list-checklist-' + checklistId).hide();
            console.log('checkList đã được xóa thành công .');
        },
        error: function (xhr) {
            alert('Có lỗi xảy ra khi xóa thành viên.');
            console.log(xhr.responseText);
        }
    });
}

function removeCheckListItem(checklistItemId, check_list_id) {
    console.log(checklistItemId);
    console.log(check_list_id);
    $.ajax({
        url: `/tasks/checklist/checklistItem/${checklistItemId}/delete`,
        type: 'POST',
        data: {
            id: checklistItemId
        },
        success: function (response) {


            $('.check-list-item-' + checklistItemId).remove();
            console.log('checklistItem đã được xóa thành công .');
            updateProgressBar(check_list_id);
        },
        error: function (xhr) {
            alert('Có lỗi xảy ra khi xóa thành viên.');
            console.log(xhr.responseText);
        }
    });
}


// ============= end checklist item member ===============


// ============= date checklist item ===============
function updateReminderOptions(checklistItemId) {
    let endDateInput = document.getElementById('end_date_' + checklistItemId).value;

    if (!endDateInput) return;

    let endDate = new Date(endDateInput);

    let oneDayBefore = new Date(endDate);
    oneDayBefore.setDate(endDate.getDate() - 1); // Lùi lại 1 ngày

    let twoDaysBefore = new Date(endDate);
    twoDaysBefore.setDate(endDate.getDate() - 2); // Lùi lại 2 ngày

    // Định dạng ngày theo kiểu yyyy-mm-ddTHH:MM
    let formatDateTime = (date) => date.toISOString().slice(0, 16);

    // Lấy thẻ select nhắc nhở
    let reminderSelect = document.getElementById('reminder_date_' + checklistItemId);

    // Xóa tất cả các option hiện tại
    reminderSelect.innerHTML = '';

    // Thêm các tùy chọn mới
    reminderSelect.innerHTML += `<option value="${formatDateTime(oneDayBefore)}">1 ngày trước </option>`;
    reminderSelect.innerHTML += `<option value="${formatDateTime(twoDaysBefore)}">2 ngày trước </option>`;
}

function submitUpdateDateCheckListItem(checklistItemId) {
    let formData = {
        start_date: $('#start_date_' + checklistItemId).val(),
        end_date: $('#end_date_' + checklistItemId).val(),
        reminder_date: $('#reminder_date_' + checklistItemId).val()
    };
    console.log(formData);
    $.ajax({
        url: `/tasks/checklist/checklistItem/${checklistItemId}/update`,
        type: 'PUT',
        data: formData,
        success: function (response) {
            console.log('checklistItem đã được cập nhật thành công!', response);
            if (formData.end_date) {
                // Định dạng ngày thành yyyy-mm-dd hh:mm:ss
                let formattedDate = new Date(formData.end_date).toLocaleString('sv-SE', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }).replace('T', ' ');

                $('#dropdownToggle_dateChecklistItem_' + checklistItemId).html(formattedDate);
            }
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
        }
    });

    return false;
}

// ============= end date checklist item ===============


// ============= liên kết task ===============
function loadTaskFormAddAttach(taskId) {
    $.ajax({
        url: `/tasks/getFormAttach/${taskId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-content-add-attach-' + taskId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

function uploadTaskAttachments(taskId) {
    let formData = new FormData();
    formData.append('task_id', taskId);
    let fileInput = document.getElementById('file_name_task_' + taskId);
    let files = fileInput.files;

    for (let i = 0; i < files.length; i++) {
        formData.append(`file_name[]`, files[i]);
        formData.append(`name[]`, files[i].name);
    }

    $.ajax({
        url: `/tasks/attachments/create`,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('Tệp đã được thêm vào thành công');

            let attachmentSection = document.getElementById(`attachment-section-` + taskId);
            if (attachmentSection && attachmentSection.style.display === 'none') {
                attachmentSection.style.display = 'block';
            }

            let listAttachments = document.getElementById('list-attachment-task-' + taskId);

            response.attachments.forEach((attachment) => {
                let attachmentRow = `
                <tr class="cursor-pointer attachment_${attachment.id}">
                    <td class="col-1" data-bs-toggle="modal" >
                        <img src="/storage/${attachment.file_name}" alt="Attachment Image" class="thumbnail"
                                data-modal-id="exampleModal"
                             style="width: 100px; height: auto; object-fit: cover; border-radius: 8px;">
                    </td>
                    <td class="text-start name_attachment" id="name_display_${attachment.id}">
                        ${attachment.name.substring(0, 50).toUpperCase()}
                    </td>
                    <td class="text-end">
                        <i class="ri-more-fill fs-20 cursor-pointer" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false"></i>
                        <div class="dropdown-menu dropdown-menu-md" style="padding: 15px 15px 0 15px">
                            <input type="text" name="name" class="form-control border-0 text-center fs-16 fw-medium bg-transparent"
                                   id="name_attachment_${attachment.id}" value="${attachment.name}"
                                   onchange="updateTaskAttachment(${attachment.id})"/>
                            <p id="attachment_id_${attachment.id}" class="cursor-pointer text-danger"
                               onclick="deleteTaskAttachment(${attachment.id})">Xóa</p>
                        </div>
                    </td>
                 </tr>
        `;
                listAttachments.innerHTML += attachmentRow;
            });

            // Kiểm tra nếu không có phần tử con nào thì ẩn attachmentSection
            if (listAttachments && listAttachments.children.length === 0) {
                attachmentSection.style.display = 'none';
            }
            notificationWeb(response.action, response.msg);
        },
        error: function (xhr) {
            console.log('Error occurred:', xhr.responseText);
        }
    });
}


function updateTaskAttachment(attachmentId) {
    let formData = {
        name: $('#name_attachment_' + attachmentId).val(),
    };
    let nameDisplay = document.getElementById('name_display_' + attachmentId);
    if (nameDisplay) {
        nameDisplay.textContent = formData.name;
    }
    $.ajax({
        url: `/tasks/attachments/${attachmentId}/update`, // Lấy URL từ thuộc tính action của form
        method: 'PUT', // Lấy method (POST) từ thuộc tính method của form
        data: formData, // Lấy toàn bộ dữ liệu của form
        success: function (response) {
            // Xử lý khi gửi thành công
            console.log('Form submitted successfully');
            console.log(response); // Dữ liệu phản hồi từ server
        },
        error: function (xhr) {
            // Xử lý khi gửi thất bại
            console.log('Error occurred:', xhr);
        }
    });
}

function deleteTaskAttachment(attachmentId, taskId) {
    $.ajax({
        url: `/tasks/attachments/${attachmentId}/destroy`,
        method: 'DELETE',
        success: function (response) {
            if (response.success) {
                console.log('Tệp đã được xóa thành công');
                document.querySelector(`.attachment_${attachmentId}`).remove();

            } else {
                console.log('Có lỗi xảy ra khi xóa tệp:', response.msg);
            }
        },
        error: function (xhr) {
            console.log('Có lỗi xảy ra khi gọi API:', xhr.responseText);
        }
    });
}

// ========== end liên kết task =========


// ============= add member task ===============
function loadTaskFormAddMember(taskId, boardId) {
    $.ajax({
        url: `/tasks/getFormAddMember/${taskId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        data: {
            boardId: boardId,
            task_id: taskId,
        },
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $('#dropdown-content-add-member-task-' + taskId).html(response.html);
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

function onclickAddMember(user_id, name, task_id) {
    addMemberToTask(user_id, name, task_id);
}

function addMemberToTask(user_id, name, task_id) {
    if (document.getElementById('card-member-task-' + user_id + '-' + task_id)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: name + " đã có trong danh sách thành viên của task.",

        });
        return;
    }
    $.ajax({
        url: `/tasks/addMember`,
        type: 'POST',
        data: {
            user_id: user_id,
            task_id: task_id,
        },
        success: function (response) {
            notificationWeb(response.action, response.msg);
            if (response.action === 'error') return false;
            let memberSection = document.getElementById(`member-section-` + task_id);
            if (memberSection && memberSection.style.display === 'none') {
                memberSection.style.display = 'block';
            }

            let userAvatar = `
        <div class="avatar-title rounded-circle bg-info-subtle text-primary"
             style="width: 35px; height: 35px;">
            ${name.charAt(0).toUpperCase()}
        </div>
    `;
            let listItem = `
        <li id="card-member-task-${user_id}-${task_id}" class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" title="${name}">
                    <div class="avatar-sm">
                        <div class="avatar-title rounded-circle bg-light text-primary">
                            ${name.charAt(0).toUpperCase()}
                        </div>
                    </div>
                </a>
                <p class="ms-3 mt-3">${name}</p>
            </div>
            <i class="ri-close-line fs-20" onclick="removeMemberFromTask(${user_id}, ${task_id})"></i>
        </li>
    `;
            let memberTask = document.getElementById('list-member-task-' + task_id);
            if (memberTask) {
                let memberTaskAdd = `
            <a href="javascript: void(0);" class="avatar-group-item"
               data-bs-toggle="tooltip" data-bs-placement="top"
               id="member-${user_id}-${task_id}"
               title="${name}">
                ${userAvatar}
            </a>
        `;
                memberTask.innerHTML += memberTaskAdd;
            } else {
                console.error('Element list-member-task-' + task_id + ' not found.');
            }

            let cardMembersList = document.getElementById('cardMembersList-' + task_id);
            if (cardMembersList) {
                cardMembersList.innerHTML += listItem;
            } else {
                console.error('Element cardMembersList-' + task_id + ' not found.');
            }

            console.log('Thành viên đã được thêm vào thẻ thành công.');
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

function removeMemberFromTask(user_id, task_id) {
    console.log('User ID:', user_id, 'Task ID:', task_id);
    $.ajax({
        url: `/tasks/deleteTaskMember`,
        type: 'POST',
        data: {
            user_id: user_id,
            task_id: task_id
        },
        success: function (response) {
            notificationWeb(response.action, response.msg);

            if (response.action === 'error') return false;

            let memberElement = document.getElementById('card-member-task-' + user_id + '-' + task_id);
            let memberElement1 = document.getElementById('member-' + user_id + '-' + task_id);
            if (memberElement1) {
                memberElement1.remove();
            }
            if (memberElement) {
                memberElement.remove();
            }


            console.log('Thành viên đã được xóa thành công khỏi thẻ.');
        },
        error: function (xhr) {
            alert('Có lỗi xảy ra khi xóa thành viên.');
            console.log(xhr.responseText);
        }
    });
}

// ============= end member ===============


// ============= comment ===============
function addTaskComment(taskId, user_id) {
    let content = $('#comment_task_' + taskId).val();
    let formData = {
        content: content,
        user_id: user_id,
        task_id: taskId,
        parent_id: ''
    };
    console.log(formData);
    $.ajax({
        url: `/tasks/comments/create`,
        type: 'POST',
        data: formData,
        success: function (response) {
            notificationWeb(response.action, response.msg)

            let taskComment = document.getElementById('task-comment-' + taskId);
            let createdAt = new Date(response.comment.created_at);
            let content = response.comment.content; // Comment content

            // Lấy thời gian hiện tại
            let now = new Date();

            // Tính số giờ chênh lệch giữa hiện tại và thời gian tạo comment
            let diffInHours = Math.abs(now - createdAt) / 36e5;

            // Tính toán "X giờ trước" hoặc định dạng đầy đủ
            let timeAgo;
            if (diffInHours < 24) {
                let diffInMinutes = Math.floor((now - createdAt) / (1000 * 60)); // Tính phút chênh lệch
                if (diffInMinutes < 60) {
                    timeAgo = `${diffInMinutes} phút trước`;
                } else {
                    timeAgo = `${Math.floor(diffInMinutes / 60)} giờ trước`;
                }
            } else {
                timeAgo = `${createdAt.getHours()}:${('0' + createdAt.getMinutes()).slice(-2)} ngày ${createdAt.getDate()} tháng ${createdAt.getMonth() + 1},
                ${createdAt.getFullYear()}`;
            }
            let btnThaoTac = ``;

            if (response.auth === formData.user_id) {
                btnThaoTac = `
                     <span data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false">Chỉnh sửa</span>
                        <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-update-comemnt-${response.comment.id} ">
                            <div class="d-flex text-muted">Chỉnh sửa</div>
                            <form class="flex-column"
                                  id="comment_form_${response.comment.task_id}">
                                  <textarea name="content" class="form-control"
                                    id="update_comment_${response.comment.id}">${response.comment.content}
                                    </textarea>
                                <button type="button"
                                        class="btn btn-primary mt-2"
                                        onclick="updateTaskComment(${response.comment.task_id},${response.auth},${response.comment.id})">
                                    Lưu
                                </button>
                            </form>
                        </div>
                 `;
            } else {
                btnThaoTac = `
                     <span data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false">Trả lời</span>
                        <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-reply-comemnt-${response.comment.id} ">
                            <div class="d-flex text-muted"><i class=" ri-arrow-go-forward-fill"></i><h5 class="text-center text-muted ">${response.userName}</h5></div>
                            <form class="flex-column"
                                  id="comment_form_{{$task->id}}">
                                  <textarea name="content" class="form-control"
                                            id="reply_comment_${response.comment.id}"
                                            placeholder="Trả lời bình luận"></textarea>
                                <button type="button"
                                        class="btn btn-primary mt-2"
                                        onclick="addReplyTaskComment(${response.comment.task_id},${response.auth},${response.comment.id})">
                                    Lưu
                                </button>
                            </form>
                        </div>
                 `;

            }
            let btnXoa = '';
            if (response.userOwnerID === formData.user_id || response.userId === formData.user_id) {
                btnXoa = `
                       <span class="mx-1">-</span>
                        <span data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Xóa</span>
                        <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                            <h5 class="text-center">Bạn có muốn xóa bình luận</h5>
                            <p>Bình luận sẽ bị xóa vĩnh viễn và không thể khôi phục</p>
                            <button class="btn btn-danger w-100" onclick="removeComment(${response.comment.id})">Xóa bình luận</button>
                        </div>
                    `;
            }


            let taskComment2 = `
        <div class="d-flex mt-2 conten-comment-${response.comment.id}">
                <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                     style="width: 40px;height: 40px">
                    ${response.userName.charAt(0).toUpperCase()}
                 </div>
            <section class="ms-2 w-100">
                <strong>${response.userName}</strong>
                <span class="fs-11">${timeAgo}</span>
                <div class="bg-info-subtle p-1 rounded ps-2 " id="1content-coment-${response.comment.id}">${content}</div>
                <div class="fs-11 d-flex">
                   <div class=""> ${btnThaoTac} </div>
                    <div class=""> ${btnXoa}</div>

                </div>
            </section>
          </div>
         `;

            taskComment.innerHTML += taskComment2;
            $(this).find('button[type="submit"]').prop('disabled', false);
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
            $(this).find('button[type="submit"]').prop('disabled', false);
        }
    });

    return false;
}

function addReplyTaskComment(taskId, user_id, commentId) {
    let content = $('#reply_comment_' + commentId).val();
    let formData = {
        content: content,
        user_id: user_id,
        task_id: taskId,
        parent_id: commentId
    };
    console.log(formData);
    $.ajax({
        url: `/tasks/comments/create`,
        type: 'POST',
        data: formData,
        success: function (response) {
            console.log('taskComment đã được thêm thành công!', response);

            let taskComment = document.getElementById('task-comment-' + taskId);
            let createdAt = new Date(response.comment.created_at);
            let content = response.comment.content; // Comment content

            // Lấy thời gian hiện tại
            let now = new Date();

            // Tính số giờ chênh lệch giữa hiện tại và thời gian tạo comment
            let diffInHours = Math.abs(now - createdAt) / 36e5;

            // Tính toán "X giờ trước" hoặc định dạng đầy đủ
            let timeAgo;
            if (diffInHours < 24) {
                let diffInMinutes = Math.floor((now - createdAt) / (1000 * 60)); // Tính phút chênh lệch
                if (diffInMinutes < 60) {
                    timeAgo = `${diffInMinutes} phút trước`;
                } else {
                    timeAgo = `${Math.floor(diffInMinutes / 60)} giờ trước`;
                }
            } else {
                timeAgo = `${createdAt.getHours()}:${('0' + createdAt.getMinutes()).slice(-2)} ngày ${createdAt.getDate()} tháng ${createdAt.getMonth() + 1},
                ${createdAt.getFullYear()}`;
            }
            let btnThaoTac = ``;

            if (response.auth === formData.user_id) {
                btnThaoTac = `
                     <span data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false">Chỉnh sửa</span>
                        <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-update-comemnt-${response.comment.id} ">
                            <div class="d-flex text-muted">Chỉnh sửa</div>
                            <form class="flex-column"
                                  id="comment_form_${response.comment.task_id}">
                                  <textarea name="content" class="form-control"
                                    id="update_comment_${response.comment.id}">${response.comment.content}
                                    </textarea>
                                <button type="button"
                                        class="btn btn-primary mt-2"
                                        onclick="updateTaskComment(${response.comment.task_id},${response.auth},${response.comment.id})">
                                    Lưu
                                </button>
                            </form>
                        </div>
                 `;
            } else {
                btnThaoTac = `
                     <span data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false">Trả lời</span>
                        <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-reply-comemnt-${response.comment.id} ">
                            <div class="d-flex text-muted"><i class=" ri-arrow-go-forward-fill"></i><h5 class="text-center text-muted ">${response.userName}</h5></div>
                            <form class="flex-column"
                                  id="comment_form_{{$task->id}}">
                                  <textarea name="content" class="form-control"
                                            id="reply_comment_${response.comment.id}"
                                            placeholder="Trả lời bình luận"></textarea>
                                <button type="button"
                                        class="btn btn-primary mt-2"
                                        onclick="addReplyTaskComment(${response.comment.task_id},${response.auth},${response.comment.id})">
                                    Lưu
                                </button>
                            </form>
                        </div>
                 `;

            }
            let btnXoa = '';
            if (response.userOwnerID === formData.user_id || response.userId === formData.user_id) {
                btnXoa = `
                       <span class="mx-1">-</span>
                        <span data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Xóa</span>
                        <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                            <h5 class="text-center">Bạn có muốn xóa bình luận</h5>
                            <p>Bình luận sẽ bị xóa vĩnh viễn và không thể khôi phục</p>
                            <button class="btn btn-danger w-100" onclick="removeComment(${response.comment.id})">Xóa bình luận</button>
                        </div>
                    `;
            }


            let taskComment2 = `
        <div class="d-flex mt-2 conten-comment-${response.comment.id}">
                <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                     style="width: 40px;height: 40px">
                    ${response.userName.charAt(0).toUpperCase()}
                 </div>
            <section class="ms-2 w-100">
                <strong>${response.userName}</strong>
                <span class="fs-11">${timeAgo}</span>
                <div class="bg-info-subtle p-1 rounded ps-2 d-flex " id="1content-coment-${response.comment.id}">
                    <div
                        class="badge border rounded  align-items-center "
                        style=" background-color:  #4A90E2">@
                        ${response.replyUser}
                        </div>
                ${content}</div>
                <div class="fs-11 d-flex">
                    <div class=""> ${btnThaoTac}</div>
                    <div class=""> ${btnXoa}</div>
                </div>


                </div>
            </section>
          </div>
         `;

            taskComment.innerHTML += taskComment2;
            $('.dropdown-menu-reply-comemnt-' + commentId).dropdown('hide');
            $(this).find('button[type="submit"]').prop('disabled', false);
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
            $(this).find('button[type="submit"]').prop('disabled', false);
        }
    });

    return false;
}

function updateTaskComment(taskId, user_id, commentId) {
    let content = $('#update_comment_' + commentId).val();
    let formData = {
        content: content,
        user_id: user_id,
        task_id: taskId,
        id: commentId
    };
    console.log(formData);
    $.ajax({
        url: `/tasks/comments/${commentId}/update`,
        type: 'PUT',
        data: formData,
        success: function (response) {
            console.log('taskComment đã được thêm thành công!', response);

            let taskComment = document.getElementById('1content-coment-' + commentId);
            let repon = `
            <div class="bg-info-subtle p-1 rounded ps-2 d-flex " id="1content-coment-${commentId}">
                ${response.replyUser ? `
                    <div class="badge border rounded align-items-center" style="background-color: #4A90E2;">
                        @${response.replyUser}
                    </div>
                ` : ''}
                ${response.comment.content}
            </div>
             `;

            // Thay vì `textContent`, dùng `innerHTML` để thêm HTML vào phần tử
            if (taskComment) {
                taskComment.innerHTML = repon;
            } else {
                console.error("Không tìm thấy phần tử với id:", '1content-coment-' + commentId);
            }

            $('.dropdown-menu-update-comemnt-' + commentId).dropdown('hide');
            $(this).find('button[type="submit"]').prop('disabled', false);
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
            $(this).find('button[type="submit"]').prop('disabled', false);
        }
    });

    return false;
}

function removeComment(commentId) {
    console.log(commentId);
    $.ajax({
        url: `/tasks/comments/${commentId}/destroy`,
        type: 'POST',
        success: function (response) {
            document.querySelector(`.conten-comment-${commentId}`).remove();
            console.log('cmt đã được xóa thành công .');
        },
        error: function (xhr) {
            alert('Có lỗi xảy ra khi xóa cmt.');
            console.log(xhr.responseText);
        }
    });
}

function loadAllTaskComment(taskId) {
    $.ajax({
        url: `/tasks/comments/${taskId}/getAllComment`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        success: function (response) {
            if (response.html) {
                // Chèn HTML đã render vào dropdown
                $(`#activity-${taskId}`).html(response.html).collapse('toggle');
            } else {
                console.log('No HTML returned');
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

// ============= end comment ===============


// ============= end tasks ===============


//  lọc
// $(document).ready(function () {
//     const $form = $('.dropdown-menu');
//
//     // Hàm debounce để chỉ gửi request khi người dùng dừng thao tác trong một khoảng thời gian
//     function debounce(func, delay) {
//         let timeout;
//         return function (...args) {
//             clearTimeout(timeout);
//             timeout = setTimeout(() => func.apply(this, args), delay);
//         };
//     }
//
//     // Hàm xử lý gửi AJAX khi có thay đổi trên form
//     function handleFormChange() {
//         // Thu thập dữ liệu từ form
//         const formData = $form.serialize(); // Chuyển toàn bộ dữ liệu form thành chuỗi URL-encoded
//         const boardId = $('#board_id').val();
//         const viewType = $('#viewType').val();
//         const updatedFormData = formData + '&board_id=' + encodeURIComponent(boardId) + '&viewType=' + encodeURIComponent(viewType);
//         // Gửi AJAX request lên server
//         $.ajax({
//             url: `/b/${boardId}/edit`, // Đường dẫn API bạn muốn gửi request
//             method: 'GET', // Phương thức gửi dữ liệu
//             data: updatedFormData, // Dữ liệu gửi lên server
//
//             success: function (response) {
//                 // Xử lý phản hồi từ server, ví dụ cập nhật giao diện với dữ liệu đã lọc
//                 console.log('Thành công:', response);
//                 // Cập nhật lại giao diện tại đây nếu cần
//             },
//             error: function (xhr, status, error) {
//                 console.error('Lỗi:', error);
//             }
//         });
//     }
//
//     // Sử dụng hàm debounce để tránh gửi nhiều request liên tục
//     const debouncedHandleFormChange = debounce(handleFormChange, 1000); // Gửi request sau 500ms ngừng thao tác
//
//     // Lắng nghe các sự kiện thay đổi trên form (input, checkbox, select,...)
//     $form.on('input change', debouncedHandleFormChange);
// });
