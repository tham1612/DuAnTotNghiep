<h5 class="mb-3" style="text-align: center">
    Thêm danh sách công việc
</h5>
{{--@php--}}
{{--    $checklist = \App\Models\CheckList::where('task_id', $task->id)->first();--}}
{{--@endphp--}}

@if($checklist)
    <form id="taskFormUpdate_{{$checklist->id}}" onsubmit="return submitFormCheckList({{$checklist->id}})">
        <div class="mt-2">
            <label class="form-label" for="name_{{$checklist->id}}">Tiêu đề</label>
            <input type="hidden" name="task_id" id="task_id_{{$checklist->id}}" value="{{$task->id}}">
            <input type="text" class="form-control" name="name" id="name_{{$checklist->id}}" value="{{$checklist->name}}"/>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">Thay đổi</button>
        </div>
    </form>
@else
    <form id="taskFormAdd" onsubmit="return submitAddCheckList({{$task->id}})">
        <div class="mt-2">
            <label class="form-label" for="name_{{$task->id}}">Tiêu đề</label>
            <input type="hidden" name="task_id" id="task_id_{{$task->id}}" value="{{$task->id}}">
            <input type="text" class="form-control" name="name" id="name_{{$task->id}}" placeholder="Việc cần làm"/>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </form>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function submitAddCheckList(taskId) {
        var formData = {
            task_id: $('#task_id_' + taskId).val(),
            name: $('#name_' + taskId).val()
        };
        if (!formData.name.trim()) {
            alert('Tiêu đề không được để trống!');
            return false;
        }
        $.ajax({
            url: `/tasks/checklist/create`,
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('Task đã được thêm thành công!', response);
            },
            error: function(xhr) {
                alert('Đã xảy ra lỗi!');
                console.log(xhr.responseText);
            }
        });

        return false;
    }

    function submitFormCheckList(checklistId) {
        var formData = {
            task_id: $('#task_id_' + checklistId).val(),
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
            success: function(response) {
                console.log('Task đã được cập nhật thành công!', response);
            },
            error: function(xhr) {
                alert('Đã xảy ra lỗi!');
                console.log(xhr.responseText);
            }
        });

        return false;
    }
</script>
