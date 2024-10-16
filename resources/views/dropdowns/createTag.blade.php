<h5 class="text-center">Tạo nhãn mới</h5>
<form>
    <input type="hidden" name="board_id" value="{{ request()->route('id') }}">
    <div class="mt-3">
        <label for="">Tiêu đề</label>
        <input type="text" name="name" class="form-control border-1" placeholder="Nhập tên nhãn"/>
    </div>
    <div class="mt-3">
        <label class="fs-14">Chọn màu</label>
        <input type="color" name="color_code" class="form-control" style="height: 40px">
    </div>
    <div class="mt-3">
        <button class="btn btn-primary create-tag-form" id="">
            Tạo mới
        </button>
    </div>
</form>
