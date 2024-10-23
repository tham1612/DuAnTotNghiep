<h5 class="mb-3" style="text-align: center">Thêm danh sách công việc</h5>
<form id="taskFormAdd" class="formItem">
    <div class="mt-2">
        <label class="form-label" for="name_{{ $taskId }}">Tiêu đề</label>
        <input type="text" class="form-control" name="name" id="name_checkList"
               placeholder="Việc cần làm"/>
    </div>
    <div class="mt-2">
        <button type="button" id="create_checkList" class="btn btn-primary" onclick="submitAddCheckList({{ $taskId }})">
            Thêm
        </button>
    </div>
</form>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameCheckList = document.getElementById('name_checkList');
        const createCheckList = document.getElementById('create_checkList');

        // Kiểm tra sự kiện khi người dùng nhập vào ô input
        nameCheckList.addEventListener('input', function() {
            console.log('Input value:', nameCheckList.value);  // Kiểm tra giá trị ô input trong console
            createCheckList.disabled = !nameCheckList.value.trim();  // Bật/tắt nút dựa trên việc ô input có giá trị hay không
        });
    });
</script> --}}
