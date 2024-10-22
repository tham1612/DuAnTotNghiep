<h5 class="mb-3" style="text-align: center">Thêm danh sách công việc</h5>
<form id="taskFormAdd" class="formItem">
    <div class="mt-2">
        <label class="form-label" for="name_{{ $taskId }}">Tiêu đề</label>
        <input type="text" class="form-control" name="name" id="name_checkList"
               placeholder="Việc cần làm"/>
    </div>
    <div class="mt-2">
        <button type="button" class="btn btn-primary" onclick="submitAddCheckList({{ $taskId }})">
            Thêm
        </button>
    </div>
</form>
