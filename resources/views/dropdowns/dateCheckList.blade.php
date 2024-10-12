<h5 class="text-center">Ngày</h5>
<form onsubmit="return submitUpdateDateCheckListItem({{$checklistItem->id}})">

    <!-- ngày bắt đầu -->
    <div>
        <strong class="fs-14">Ngày bắt đầu</strong>
        <input type="datetime-local" name="start_date" id="start_date_{{$checklistItem->id}}"
               value="{{$checklistItem->start_date}}" class="form-control border-0 my-2"/>
    </div>
    <div>
        <strong class="fs-14">Ngày kết thúc</strong>
        <input type="datetime-local" id="end_date_{{$checklistItem->id}}" name="end_date"
               value="{{$checklistItem->end_date}}"
               class="form-control border-0 my-2" onchange="updateReminderOptions({{$checklistItem->id}})"/>
    </div>
    <div class="mt-2">
        <strong class="fs-16">Thiết lập nhắc nhở</strong>
        <select name="reminder_date" id="reminder_date_{{$checklistItem->id}}" class="form-select">
            <option value="">Chọn nhắc nhở</option>
        </select>
    </div>

    <div class="mt-3 card">
        <button type="submit" class="btn bg-primary text-white">Lưu</button>
    </div>
</form>
<script>
    function updateReminderOptions(checklistItemId) {
        var endDateInput = document.getElementById('end_date_' + checklistItemId).value;

        if (!endDateInput) return;

        var endDate = new Date(endDateInput);

        var oneDayBefore = new Date(endDate);
        oneDayBefore.setDate(endDate.getDate() - 1); // Lùi lại 1 ngày

        var twoDaysBefore = new Date(endDate);
        twoDaysBefore.setDate(endDate.getDate() - 2); // Lùi lại 2 ngày

        // Định dạng ngày theo kiểu yyyy-mm-ddTHH:MM
        var formatDateTime = (date) => date.toISOString().slice(0, 16);

        // Lấy thẻ select nhắc nhở
        var reminderSelect = document.getElementById('reminder_date_' + checklistItemId);

        // Xóa tất cả các option hiện tại
        reminderSelect.innerHTML = '';

        // Thêm các tùy chọn mới
        reminderSelect.innerHTML += `<option value="${formatDateTime(oneDayBefore)}">1 ngày trước </option>`;
        reminderSelect.innerHTML += `<option value="${formatDateTime(twoDaysBefore)}">2 ngày trước </option>`;
    }

    function submitUpdateDateCheckListItem(checklistItemId) {
        var formData = {
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
            },
            error: function (xhr) {
                alert('Đã xảy ra lỗi!');
                console.log(xhr.responseText);
            }
        });

        return false;
    }
</script>
