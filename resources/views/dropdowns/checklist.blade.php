<h5 class="mb-3" style="text-align: center">
    Thêm danh sách công việc
</h5>
@if(!empty($task->checkList))

    <form id="taskFormUpdate_{{$task->checkList->id}}" class="formItem">
        <div class="mt-2">
            <label class="form-label" for="name_{{$task->checkList->id}}">Tiêu đề</label>
            <input type="hidden" name="task_id" id="task_id_{{$task->checkList->id}}"
                   value="{{$task->id}}">
            <input type="text" class="form-control" name="name" id="name_{{$task->checkList->id}}"
                   value="{{$task->checkList->name}}"/>
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-primary"
                    onclick="submitFormCheckList({{$task->checkList->id}})">
                Thay đổi
            </button>
        </div>
    </form>
@else
    <form id="taskFormAdd" class="formItem">
        <div class="mt-2">
            <label class="form-label" for="name_{{$task->id}}">Tiêu đề</label>
            <input type="hidden" name="task_id" id="task_id_{{$task->id}}" value="{{$task->id}}">
            <input type="text" class="form-control" name="name" id="name_{{$task->id}}"
                   placeholder="Việc cần làm"/>
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-primary" onclick=" submitAddCheckList({{$task->id}})">
                Thêm
            </button>
        </div>
    </form>
@endif


