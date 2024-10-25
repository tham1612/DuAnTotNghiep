<h5 class="text-center">Tạo nhãn mới</h5>
<form id="tag-form" class="tag-form">
    <input type="hidden" name="board_id" value="{{ request()->route('id') }}">

    <div class="mt-3">
        <label for="">Tiêu đề</label>
        <input type="text" name="name" class="name-input form-control border-1" placeholder="Nhập tên nhãn" />
    </div>

    <div class="mt-3">
        <label class="fs-14">Chọn màu</label>
        <div class="d-flex flex-wrap gap-2 select-color" id="color-options">
            @if (isset($colors))
                @foreach ($colors as $color)
                    <div class="color-option" data-color="{{ $color->code }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $color->name }}">
                        <div class="color-box border rounded" style="width: 50px;height: 30px; background-color: {{ $color->code }}"></div>
                    </div>
                @endforeach
            @endif
        </div>
        <input type="hidden" name="color" class="selected-color" value="" />
    </div>

    <div class="mt-3">
        <button type="button" class="create-btn btn btn-outline-primary waves-effect waves-light create-tag-form" disabled>
            Tạo mới
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sử dụng class để chọn tất cả các form trên toàn trang
        const forms = document.querySelectorAll('.tag-form');

        // Hàm bật/tắt nút "Tạo mới"
        function toggleCreateButton(nameInput, selectedColor, createBtn) {
            createBtn.disabled = !(nameInput.value.trim() && selectedColor);
        }

        // Lặp qua tất cả các form trên trang web
        forms.forEach(function(form) {
            const nameInput = form.querySelector('.name-input');
            const createBtn = form.querySelector('.create-btn');
            const colorOptions = form.querySelectorAll('.color-option');
            const selectedColorInput = form.querySelector('.selected-color');

            let selectedColor = ''; // Để lưu màu đã chọn

            // Xử lý sự kiện nhập tên nhãn
            nameInput.addEventListener('input', function() {
                toggleCreateButton(nameInput, selectedColor, createBtn);
            });

            // Xử lý sự kiện chọn màu
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Xóa chọn màu từ tất cả các ô
                    colorOptions.forEach(opt => opt.classList.remove('selected-tag'));

                    // Đánh dấu ô màu được chọn
                    this.classList.add('selected-tag');

                    // Lưu màu đã chọn và gán cho input ẩn
                    selectedColor = this.getAttribute('data-color');
                    selectedColorInput.value = selectedColor;

                    // Kiểm tra xem cả tên và màu đều đã được cung cấp
                    toggleCreateButton(nameInput, selectedColor, createBtn);
                });
            });

            // Ngăn gửi form nhiều lần
            createBtn.addEventListener('click', function() {
                if (!createBtn.disabled) {
                    createBtn.disabled = true; // Disable nút sau lần click đầu tiên
                    form.submit(); // Gửi form
                }
            });
        });
    });
</script>

<style>
    .color-option.selected-tag .color-box {
        border: 2px solid black; /* Thêm viền để làm nổi bật màu đã chọn */
    }
</style>
