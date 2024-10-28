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

// Lắng nghe sự kiện click cho các phần tử có class 'task-title'
// document.addEventListener('click', function(event) {
//     if (event.target.classList.contains('task-title')) {
//         // Lấy task ID từ thuộc tính data-task-id
//         let taskId = event.target.getAttribute('data-task-id');
//
//         // Gọi AJAX để lấy nội dung modal
//         $.ajax({
//             url: `/tasks/${taskId}/detail`,  // API để lấy thông tin chi tiết task
//             type: 'GET',
//             success: function(response) {
//                 // Giả sử máy chủ trả về dữ liệu modal dưới dạng HTML
//                 $('#modal-content').html(response); // Gắn nội dung modal vào phần tử chứa modal
//
//                 // Hiển thị modal
//                 $('#detailCardModal' + taskId ).modal('show');
//             },
//             error: function(xhr) {
//                 alert('Có lỗi xảy ra khi tải nội dung.');
//                 console.log(xhr.responseText);
//             }
//         });
//     }
// });


document.addEventListener('DOMContentLoaded', function () {
    // thông báo
    const notificationElements = document.querySelectorAll('[id^="notification_"]');

    // Duyệt qua từng phần tử để thêm sự kiện click
    notificationElements.forEach(notification => {
        notification.addEventListener('click', function () {
            // Lấy taskId từ id của phần tử
            const taskId = this.id.split('_')[1];

            // Lấy các phần tử liên quan
            const followElement = document.getElementById(`notification_follow_${taskId}`);
            const contentElement = document.getElementById(`notification_content_${taskId}`);
            const iconElement = document.getElementById(`notification_icon_${taskId}`);

            // Kiểm tra trạng thái hiện tại
            if (followElement.classList.contains('d-none')) {
                // Nếu đang ẩn (chưa theo dõi), bật theo dõi
                followElement.classList.remove('d-none'); // Hiện icon dấu check
                contentElement.innerText = 'Đang theo dõi'; // Thay đổi nội dung
                iconElement.classList.replace('ri-eye-off-line', 'ri-eye-line');// Thay đổi icon
            } else {
                // Nếu đang hiển thị (đang theo dõi), bỏ theo dõi
                followElement.classList.add('d-none'); // Ẩn icon dấu check
                contentElement.innerText = 'Theo dõi'; // Quay lại nội dung cũ

                iconElement.classList.replace('ri-eye-line', 'ri-eye-off-line');// Thay đổi icon về cũ
            }

            // In ra taskId để kiểm tra
            console.log('Bạn đã click vào thông báo của task với ID:', taskId);
        });
    });

    // check ngày hết hạn
    document.querySelectorAll('input[id^="due_date_checkbox_"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const taskId = this.id.split('due_date_checkbox_')[1];  // Lấy taskId từ id của checkbox

            const successBadge = document.getElementById(`due_date_success_${taskId}`);
            const dueBadge = document.getElementById(`due_date_due_${taskId}`);
            const endDate = new Date(document.getElementById(`task_end_date_${taskId}`).value); // Lấy endDate từ input hidden
            const now = new Date(); // Lấy thời gian hiện tại từ client

            if (this.checked) {
                console.log('Chuyển sang "Hoàn tất" cho task:', taskId);
                successBadge.classList.remove('d-none'); // Hiện "Hoàn tất"
                dueBadge.classList.add('d-none'); // Ẩn "Quá hạn"
            } else {
                console.log('Chuyển sang "Quá hạn" cho task:', taskId);

                // Thêm kiểm tra nếu hiện tại đã quá hạn
                if (now > endDate) {
                    dueBadge.classList.remove('d-none'); // Hiện "Quá hạn" nếu đã hết hạn
                    successBadge.classList.add('d-none'); // Ẩn "Hoàn tất"
                } else {
                    dueBadge.classList.add('d-none'); // Ẩn "Quá hạn" nếu chưa quá hạn
                    successBadge.classList.remove('d-none'); // Hiện "Hoàn tất"
                }
            }
        });
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
        method: "POST",  // Sử dụng POST nhưng với method PUT
        dataType: 'json',
        data: formData,
        processData: false,  // Bắt buộc phải false để không xử lý FormData thành chuỗi
        contentType: false,  // Bắt buộc phải false để đặt đúng 'multipart/form-data'
        success: function (response) {
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
document.querySelectorAll('.color-box').forEach(box => {
    box.addEventListener('click', function () {
        console.log(123)
        // Xóa lớp 'selected' khỏi tất cả các ô màu
        document.querySelectorAll('.color-box').forEach(b => b.classList.remove('selected-tag'));
        // Thêm lớp 'selected' vào ô màu đang được click
        this.classList.add('selected-tag');
    });
});

// Hàm tạo ra ID ngẫu nhiên với độ dài tùy chỉnh
function generateRandomId(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}

// Gán ID ngẫu nhiên cho mỗi form và thêm thuộc tính data-form-id cho các button
$('form').each(function () {
    const randomId = generateRandomId(10);
    $(this).attr('id', randomId); // Gán ID cho form
    $(this).find('button').attr('data-form-id', randomId); // Gán data-form-id cho button
});

// Hàm chuyển đổi từ RGB sang HEX
function rgbToHex(rgb) {
    const rgbValues = rgb.match(/\d+/g); // Tách chuỗi RGB thành r, g, b
    const r = parseInt(rgbValues[0]).toString(16).padStart(2, '0');
    const g = parseInt(rgbValues[1]).toString(16).padStart(2, '0');
    const b = parseInt(rgbValues[2]).toString(16).padStart(2, '0');
    return `#${r}${g}${b}`.toUpperCase(); // Trả về mã màu HEX
}

// Biến lưu trữ mã màu được chọn, khởi tạo là null
let selectedColor = null;

// Gán sự kiện cho phần tử cha
$('.select-color').on('click', 'div', function (e) {
    e.stopPropagation(); // Ngăn chặn sự kiện nổi bọt
    console.log("Đã click vào ô màu."); // Log để kiểm tra
    // Đảm bảo lấy đúng element chứa màu
    const rgb = $(this).css('background-color'); // Lấy giá trị background-color của div được click

    // Kiểm tra nếu giá trị thực sự là dạng rgb trước khi chuyển sang hex
    if (rgb && rgb.startsWith('rgb')) {
        selectedColor = rgbToHex(rgb); // Chuyển đổi sang mã màu HEX
        console.log('Màu đã chọn (HEX):', selectedColor); // Hiển thị mã màu đã chọn
    } else {
        console.log('Không có màu hợp lệ được chọn.');
    }
});

// Sự kiện click cho button tạo thẻ tag
$('button.create-tag-form').off('click').on('click', function (e) {
    e.preventDefault(); // Ngăn chặn hành động mặc định của button

    // Kiểm tra xem người dùng đã chọn màu chưa
    if (!selectedColor) {
        alert('Vui lòng chọn một màu trước khi tạo tag.');
        return; // Ngừng nếu chưa chọn màu
    }

    const formId = $(this).data('form-id'); // Lấy ID của form từ button
    const form = $('#' + formId); // Lấy form theo ID

    // Lấy dữ liệu từ form cụ thể
    const formData = {
        board_id: form.find('input[name="board_id"]').val(),
        name: form.find('input[name="name"]').val(),
        color_code: selectedColor // Sử dụng mã màu đã chọn trước đó
    };

    // Gửi dữ liệu qua AJAX
    $.ajax({
        type: 'POST',
        url: '/tasks/tag/create',
        data: formData,
        success: function (response) {
            // Đóng dropdown khi AJAX thành công
            $('.dropdown-menu-creat-tag').hide();
            console.log('Tạo tag thành công:', response);
        },
        error: function (error) {
            console.error('Lỗi:', error);
        }
    });
});
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

    // Sử dụng FormData để linh hoạt trong việc thêm dữ liệu
    let formData = new FormData();
    formData.append('text', document.getElementById('text_' + taskId).value);
    formData.append('start_date', document.getElementById('start_date_task_' + taskId).value);
    formData.append('end_date', document.getElementById('end_date_task_' + taskId).value);
    formData.append('reminder_date', document.getElementById('reminder_date_task_' + taskId).value);
    formData.append('_method', 'PUT');  // Để giả lập method PUT với Laravel

    $.ajax({
        url: `/tasks/` + taskId,
        method: "POST",  // Sử dụng POST với method spoofing PUT
        dataType: 'json',
        processData: false,  // Không xử lý dữ liệu (vì là FormData)
        contentType: false,  // Để trình duyệt tự đặt Content-Type (multipart/form-data)
        data: formData,
        success: function (response) {
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
$('.form-check-input-tag').on('change', function () {
    let data = $(this).val(); // Lấy giá trị tag ID
    console.log(data);

    $.ajax({
        url: '/tasks/tag/update', // Địa chỉ endpoint của bạn
        type: 'POST',
        data: {
            data: data,
        },
        success: function (response) {
            // let checkList = document.getElementById('check-list-' + response.check_list_id);

            console.log('Checkbox đã được cập nhật:', response);
            // Xử lý thêm nếu cần
        },
        error: function (xhr, status, error) {
            console.error('Có lỗi xảy ra:', error);
        }
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

            console.log('CheckListItem đã được thêm thành công!', response);
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
                                           data-task-id="${response.task_id}"/>
                                </div>
                            </td>
                            <td>
                                <p>${response.checkListItem.name}</p>
                            </td>
                            <td class=" d-flex justify-content-end">
                                <div>
                                    <i class="ri-more-fill fs-20"
                                       data-bs-toggle="dropdown"
                                       aria-haspopup="true"
                                       aria-expanded="false"></i>
                                    <div class="dropdown-menu dropdown-menu-md"
                                         style="padding: 15px 15px 0 15px">
                                        <h5 class="text-center">Thao tác
                                            mục</h5>
                                        <p class="mt-2">Chuyển sang thẻ</p>
                                        <p class="cursor-pointer text-danger"
                                        onclick="removeCheckListItem(${response.id})">
                                        Xóa</p>

                                    </div>
                                </div>
                            </td>
                        </tr>
            `;
            if (checkList) {
                checkList.insertAdjacentHTML('beforeend', listItem);
            } else {
                console.error('Không tìm thấy phần check-list-' + response.check_list_id);
            }
            $('#name_check_list_item_' + checkListId).val('');
            updateProgressBar(response.check_list_id);

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
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
        }
    });
});


function loadTaskFormAddCheckList(taskId) {
    $.ajax({
        url: `/tasks/getFormChekList/${taskId}`, // Đường dẫn API hoặc route để lấy form
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
            let checkList = document.getElementById('checkListCreate');
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

document.addEventListener('DOMContentLoaded', function () {
    // Lấy tất cả các checkbox
    const checkboxes = document.querySelectorAll('.form-check-input-checkList');

    function updateProgressBar(checklistId) {
        // Lọc các checkbox thuộc về checklist có checklistId cụ thể
        const checklistCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.getAttribute('data-checklist-id') === checklistId);
        const totalCheckboxes = checklistCheckboxes.length;
        const checkedCheckboxes = checklistCheckboxes.filter(checkbox => checkbox.checked).length;

        console.log(`Checklist ID: ${checklistId}, Total: ${totalCheckboxes}, Checked: ${checkedCheckboxes.length}`);

        // Tính phần trăm hoàn thành
        const percentCompleted = (totalCheckboxes > 0) ? (checkedCheckboxes / totalCheckboxes) * 100 : 0;

        // Cập nhật thanh tiến trình cho checklist tương ứng
        const progressBar = document.getElementById('progress-bar-checklist-' + checklistId);
        if (progressBar) {  // Kiểm tra thanh progress có tồn tại
            progressBar.style.width = percentCompleted + '%';
            progressBar.setAttribute('aria-valuenow', percentCompleted);
            progressBar.innerHTML = Math.round(percentCompleted) + '%'; // Làm tròn phần trăm
        } else {
            console.error(`Progress bar not found for checklist ID: ${checklistId}`);
        }
    }

    // Lắng nghe sự kiện thay đổi trên từng checkbox
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
// ============= end checklist ======================


// ============= checklist item member ===============
function loadChecklistItemFormAddMember(checkListItemId, boardId) {
    $.ajax({
        url: `/tasks/checklist/checklistItem/getFormAddMember/${checkListItemId}`, // Đường dẫn API hoặc route để lấy form
        method: 'GET',
        data: {
            boardId: boardId,
        },
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

function onclickAddMemberCheckListItem(memberId, memberName, check_list_item_id) {
    addMemberToCheckListItem(memberId, memberName, check_list_item_id);
}

function addMemberToCheckListItem(memberId, memberName, checklistItemId) {
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
            cardMembersListItem.innerHTML += listItem;
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

function removeCheckListItem(checklistItemId) {
    console.log(checklistItemId);
    $.ajax({
        url: `/tasks/checklist/checklistItem/${checklistItemId}/delete`,
        type: 'POST',
        data: {
            id: checklistItemId
        },
        success: function (response) {
            $('.check-list-item-' + checklistItemId).remove();
            console.log('checklistItem đã được xóa thành công .');
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
    console.log(files)
    console.log(formData)

    $.ajax({
        url: `/tasks/attachments/create`,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('tệp đã được thêm vào thành công');
            console.log(response);
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

function deleteTaskAttachment(attachmentId) {
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
            let cardMembersList = document.getElementById('cardMembersList-' + task_id);
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

            if (cardMembersList) {
                cardMembersList.innerHTML += listItem;
            } else {
                console.error('Element cardMembersList-' + task_id + ' not found.');
            }

            // if (cardMembersTask) {
            //     cardMembersTask.innerHTML += listTaskItem;
            // } else {
            //     console.error('Element list-member-task' + ' not found.');
            // }
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
            let memberElement = document.getElementById('card-member-task-' + user_id + '-' + task_id);
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
        url: `/tasks/comments/{commentId}/destroy`,
        type: 'POST',
        data: {
            id: commentId
        },
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





