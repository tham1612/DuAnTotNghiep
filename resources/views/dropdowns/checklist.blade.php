<h5 class="mb-3" style="text-align: center">
    Thêm danh sách công việc
</h5>
@php
    $checklist = \App\Models\CheckList::where('task_id', $task->id)
    ->first();

@endphp
@if($checklist )
    <form id="taskFormUpdate({{$checklist->id}})" onsubmit="return submitFormCheckList({{$checklist->id }})">
        <div class="mt-2">
            <label class="form-label" for="name">Tiêu đề</label>
            <input type="hidden" name="task_id" id="task_id_{{$checklist->id}}" value="{{$task->id}}">
            <input type="text" class="form-control" name="name" id="name_{{$checklist->id}}" value="{{$checklist->name}}"/>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">Thay đổi</button>
        </div>
    </form>
@else
    <form id="taskForm" onsubmit=" return submit()">
        <div class="mt-2">
            <label class="form-label" for="name">Tiêu đề</label>
            <input type="hidden" name="task_id" id="task_id" value="{{$task->id}}">
            <input type="text" class="form-control" name="name" id="name" placeholder="Việc cần làm"/>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </form>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

    $(document).ready(function() {

        $('#taskForm').on('submit', function(e) {
            e.preventDefault();
            $(this).find('button[type="submit"]').prop('disabled', true);
            var formData = {
                task_id: $('#task_id').val(),
                name: $('#name').val(),
            };
            console.log(formData);
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
        });

    });
    function submitFormCheckList(checklistId) {

            var formData = {
                task_id: $('#task_id_' + checklistId).val(),
                name: $('#name_'+ checklistId).val(),
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
    };
</script>

