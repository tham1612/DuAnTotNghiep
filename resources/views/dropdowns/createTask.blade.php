<form>
    <div class="mb-2">
        <input type="text" id="add-task-catalog-{{$catalog->id}}" class="form-control"
               name="text" placeholder="Nhập tên thẻ..."/>
    </div>
    <div class="mb-2 d-flex align-items-center">
        <button type="button" class="btn btn-primary"
                onclick="submitAddTask({{$catalog->id}},'{{$catalog->name}}')">
            Thêm thẻ
        </button>
        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
    </div>
</form>
