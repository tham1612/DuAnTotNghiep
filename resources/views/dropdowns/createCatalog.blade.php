
<form >
    <div class="mb-2">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
               id="nameCatalog" value="{{ old('name') }}" placeholder="Nhập tên danh sách..."/>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-2 d-flex align-items-center">
        <button type="button" id="btnSubmitCatalog" class="btn btn-primary"onclick="submitAddCatalog({{ $boardId }})">
            Thêm danh sách
        </button>
        <i class="ri-close-line fs-22 ms-2 cursor-pointer closeDropdown" role="button" tabindex="0"
           aria-label="Close" data-dropdown-id="dropdownMenuOffset3"></i>
    </div>
</form>
