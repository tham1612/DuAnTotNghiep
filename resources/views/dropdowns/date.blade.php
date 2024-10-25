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