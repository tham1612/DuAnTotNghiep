<h5 class="text-center">Ngày</h5>
<form onsubmit="return submitUpdateDateCheckListItem({{$checklistItem->id}})">

    <!-- ngày bắt đầu -->
    <div>
        <strong class="fs-14">Ngày bắt đầu</strong>
        <input type="datetime-local" name="start_date" id="start_date_{{$checklistItem->id}}" min="{{$task->start_date}}" max="{{$task->end_date}}"
               value="{{$checklistItem->start_date}}" class="form-control border-0 my-2"/>
    </div>
    <div>
        <strong class="fs-14">Ngày kết thúc</strong>
        <input type="datetime-local" id="end_date_{{$checklistItem->id}}" name="end_date" min="{{$task->start_date}}" max="{{$task->end_date}}"
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

</script>
