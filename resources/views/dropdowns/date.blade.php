<h5 class="text-center">Ngày</h5>
<form onsubmit="return submitUpdateDateTask( {{$task->id}},event)">
    <input type="hidden" name="text" id="text_{{$task->id}}"
           value="{{$task->text}}" />
    <!-- ngày bắt đầu -->
    <div>
        <strong class="fs-14">Ngày bắt đầu</strong>
        <input type="datetime-local" name="start_date" id="start_date_task_{{$task->id}}"
               value="{{$task->start_date}}" class="form-control border-0 my-2"/>
    </div>
    <div>
        <strong class="fs-14">Ngày kết thúc</strong>
        <input type="datetime-local" id="end_date_task_{{$task->id}}" name="end_date"
               value="{{$task->end_date}}"
               class="form-control border-0 my-2" onchange="updateReminderOptions2({{$task->id}})"/>
    </div>
    <div class="mt-2">
        <strong class="fs-16">Thiết lập nhắc nhở</strong>
        <select name="reminder_date" id="reminder_date_task_{{$task->id}}" class="form-select">
            <option value="">Chọn nhắc nhở</option>
        </select>
    </div>

    <div class="mt-3 card">
        <button type="submit" class="btn bg-primary text-white">Lưu</button>
    </div>
</form>

<script>
    function updateReminderOptions2(taskId) {
        var endDateInput = document.getElementById('end_date_task_' + taskId).value;

        // Kiểm tra xem sự kiện có được kích hoạt và giá trị của end_date
        console.log('updateReminderOptions2 called for task:', taskId);
        console.log('end_date value:', endDateInput);

        if (!endDateInput) {
            console.log('No end date provided.');
            return;
        }
    var endDate = new Date(endDateInput);

    var oneDayBefore = new Date(endDate);
    oneDayBefore.setDate(endDate.getDate() - 1); // Lùi lại 1 ngày

    var twoDaysBefore = new Date(endDate);
    twoDaysBefore.setDate(endDate.getDate() - 2); // Lùi lại 2 ngày

    // Định dạng ngày theo kiểu yyyy-mm-ddTHH:MM
    var formatDateTime = (date) => date.toISOString().slice(0, 16);

    // Lấy thẻ select nhắc nhở
    var reminderSelect = document.getElementById('reminder_date_task_' + taskId);

    // Xóa tất cả các option hiện tại
    reminderSelect.innerHTML = '';

    // Thêm các tùy chọn mới
    reminderSelect.innerHTML += `<option value="${formatDateTime(oneDayBefore)}">1 ngày trước</option>`;
    reminderSelect.innerHTML += `<option value="${formatDateTime(twoDaysBefore)}">2 ngày trước</option>`;
    }

    function submitUpdateDateTask(taskId,event) {
        event.preventDefault(); // Ngăn hành động mặc định của form

        // Sử dụng FormData để linh hoạt trong việc thêm dữ liệu
        var formData = new FormData();
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
</script>
