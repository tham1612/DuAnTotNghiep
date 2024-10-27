
<h5 class="mb-3" style="text-align: center">Thêm danh sách công việc</h5>
<form class="taskFormAdd formItem" >
    <div class="mt-2">
        <label class="form-label" for="name_checkList_{{ $taskId }}">Tiêu đề</label>
        <input type="text" class="form-control " id="name_checkList_{{ $taskId }}" placeholder="Việc cần làm" required />
    </div>
    <div class="mt-2">
        <button type="button" class="btn btn-primary " onclick="submitAddCheckList({{ $taskId }})" >
            Thêm
        </button>
    </div>
</form>


