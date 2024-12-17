<h5 class="text-center">Tạo nhãn mới</h5>
<form id="tag-form" class="tag-form">
    <input type="hidden" name="board_id" value="{{$boardID}}">

    <div class="mt-3">
        <label for="">Tiêu đề</label>
        <input type="text" name="name" class="name-input form-control border-1" placeholder="Nhập tên nhãn"/>
    </div>

    <div class="mt-3">
        <label class="fs-14">Chọn màu</label>
        <div class="d-flex flex-wrap gap-2 select-color" id="color-options">
            @if (isset($colors))
                @foreach ($colors as $color)
                    <div class="color-option" data-color="{{ $color->code }}" data-bs-toggle="tooltip"
                         data-bs-trigger="hover" data-bs-placement="top" title="{{ $color->name }}">
                        <div class="color-box border rounded"
                             style="width: 50px;height: 30px; background-color: {{ $color->code }}"></div>
                    </div>
                @endforeach
            @endif
        </div>
        <input type="hidden" name="task_id" value="{{$taskId}}"/>
    </div>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-primary waves-effect waves-light create-tag-form">
            Tạo mới
        </button>
    </div>
</form>


<script !src="">
    document.querySelectorAll('.color-box').forEach(box => {
        box.addEventListener('click', function() {
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
    $('form').each(function() {
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



    // Gán sự kiện cho phần tử cha
    $('.select-color').on('click', 'div', function(e) {
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
    $('button.create-tag-form').off('click').on('click', function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của button

        // Kiểm tra xem người dùng đã chọn màu chưa
        if (!selectedColor) {
            notificationWeb('error', 'Vui lòng chọn một màu trước khi tạo tag.')
            return; // Ngừng nếu chưa chọn màu
        }

        const formId = $(this).data('form-id'); // Lấy ID của form từ button
        const form = $('#' + formId); // Lấy form theo ID

        // Lấy dữ liệu từ form cụ thể
        const formData = {
            board_id: form.find('input[name="board_id"]').val(),
            task_id: form.find('input[name="task_id"]').val(),
            name: form.find('input[name="name"]').val(),
            color_code: selectedColor // Sử dụng mã màu đã chọn trước đó
        };

        // Gửi dữ liệu qua AJAX
        $.ajax({
            type: 'POST',
            url: '/tasks/tag/create',
            data: formData,
            success: function(response) {
                // Đóng dropdown khi AJAX thành công
                $('input[name="name"]').val('');
                $('.color-box').removeClass('selected-tag');
                let tagSection = document.getElementById(`tag-section-${formData.task_id}`);
                let tagSectionView = document.querySelector(`.tag-task-section-${response.task_id}`);
                let tagTask = document.getElementById('tag-task-' + formData.task_id);
                if (tagSection.style.display === 'none') {
                    tagSection.style.display = 'block';
                }
                if ( tagSectionView && tagSectionView.classList.contains('hidden')) {
                    tagSectionView.classList.remove('hidden');
                }
                let tagTaskView = document.querySelector(`.tag-task-view-${response.task_id}`);
                let tagItemView = document.querySelector(`[data-tag-view-id="${response.task_id}-${response.tag_id}"]`);
                let tagTaskAdd = `
                    <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="top" data-tag-id="${formData.task_id}-${response.tag_id}"
                        title="${response.tagTaskName}">
                        <div
                            class="badge border rounded d-flex align-items-center justify-content-center"
                            style=" background-color: ${response.tagTaskColor}">
                            ${response.tagTaskName}
                        </div>
                    </div>
                    `;
                let tagTaskAddView = `
                    <div data-bs-toggle="tooltip"  data-tag-view-id="${response.task_id}-${response.tag_id}" data-bs-trigger="hover"
                            data-bs-placement="top" title="${response.tagTaskName}">
                        <div
                            class="text-white border rounded d-flex align-items-center justify-content-center"
                            style="width: 40px;height: 15px; background-color: ${response.tagTaskColor}">
                        </div>
                    </div>
                `;
                let tagBoard = document.getElementById('danh-sach-tag-' + formData.board_id);
                let tagBoardAdd = `
                <li class="mt-1 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <input type="checkbox" checked
                               class="form-check-input-tag" value="${formData.task_id}-${response.tag_id}"/>
                        <span class="mx-2 rounded p-2 col-10 text-white"
                              style="background-color: ${response.tagTaskColor}">${response.tagTaskName}</span>
                    </div>
                    <i class="ri-pencil-line fs-20 cursor-pointer" data-bs-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false"></i>
                </li>
            `;
                if (tagTask) {
                    tagTask.innerHTML += tagTaskAdd;
                } else {
                    console.error('Element cardMembersList-' + task_id + ' not found.');
                }
                if (tagTaskView) {
                        tagTaskView.innerHTML += tagTaskAddView;
                    } else {
                        console.error(' not found.');
                    }
                if (tagBoard) {
                    tagBoard.innerHTML += tagBoardAdd;
                } else {
                    console.error(' not found.');
                }
                console.log('Tạo tag thành công:', response);
            },
            error: function(error) {
                console.error('Lỗi:', error);
            }
        });
    });
</script>

