<form>
    <h5 class="text-center">Thêm thẻ</h5>
    <div class="mb-2">
        <input type="text" class="form-control add-task-all-view" name="text"
               value="{{ old('text') }}" placeholder="Nhập tên thẻ..."/>
        @error('text')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-2">
        <select name="catalog_id" class="form-select ">
            <option value="">---Lựa chọn---</option>
            @foreach ($catalogs as $catalog)
                <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2 d-grid">
        <button type="button" class="btn btn-primary"
                onclick="submitAddTask({{$catalog->id}},'{{$catalog->name}}')">
            Thêm thẻ
        </button>
    </div>
</form>



