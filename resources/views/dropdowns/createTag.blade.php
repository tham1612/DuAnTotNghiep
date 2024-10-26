<h5 class="text-center">Tạo nhãn mới</h5>
<form id="tag-form" class="tag-form">
    <input type="hidden" name="board_id" value="{{ request()->route('id') }}">

    <div class="mt-3">
        <label for="">Tiêu đề</label>
        <input type="text" name="name" class="name-input form-control border-1" placeholder="Nhập tên nhãn" />
    </div>

    <div class="mt-3">
        <label class="fs-14">Chọn màu</label>
        <div class="d-flex flex-wrap gap-2 select-color" id="color-options">
            @if (isset($colors))
                @foreach ($colors as $color)
                    <div class="color-option" data-color="{{ $color->code }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $color->name }}">
                        <div class="color-box border rounded" style="width: 50px;height: 30px; background-color: {{ $color->code }}"></div>
                    </div>
                @endforeach
            @endif
        </div>
        <input type="hidden" name="color" class="selected-color" value="" />
    </div>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-primary waves-effect waves-light create-tag-form">
            Tạo mới
        </button>
    </div>
</form>

