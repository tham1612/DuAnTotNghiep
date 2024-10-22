<h5 class="text-center">Tạo nhãn mới</h5>
<form>
    <input type="hidden" name="board_id" value="{{ request()->route('id') }}">

    <div class="mt-3">
        <label for="">Tiêu đề</label>
        <input type="text" name="name" id="name" class="form-control border-1" placeholder="Nhập tên nhãn"/>
    </div>

    <div class="mt-3">
        <label class="fs-14">Chọn màu</label>
        <div class="d-flex flex-wrap gap-2 select-color">
            @if(isset($colors))
                @foreach($colors as $color)
                    <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                         title="{{$color->name}}">
                        <div class="color-box border rounded"
                             style="width: 50px;height: 30px; background-color: {{$color->code}}">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="mt-3">
        <button type="button" id="create-btn" class="btn btn-outline-primary waves-effect waves-light create-tag-form" disabled>
            Tạo mới
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const createBtn = document.getElementById('create-btn');

        // Kiểm tra sự kiện khi người dùng nhập vào ô input
        nameInput.addEventListener('input', function() {
            console.log('Input value:', nameInput.value);  // Kiểm tra giá trị ô input trong console
            createBtn.disabled = !nameInput.value.trim();  // Bật/tắt nút dựa trên việc ô input có giá trị hay không
        });
    });
</script>
