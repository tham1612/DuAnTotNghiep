<!-- chia sẻ bảng & thêm thành viên -->
<div
    class="modal fade"
    id="create-board-template-home-modal"
    tabindex="-1"
    aria-labelledby="create-board-template-home-modal-label"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header p-3 d-grid" style="grid-template-columns: 1fr auto 1fr;">
                <span></span> <!-- Khoảng trống để đẩy tiêu đề ra giữa -->
                <h5 class="modal-title text-center" id="create-board-template-home-modal-label">
                    Tạo bảng với mẫu
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    id="btn-close-member"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body" style="margin-top: -50px">
                <form class="p-3">

                    <div class="mt-3">
                        <label for="" class="form-label">Mẫu bảng</label>
                        <select name="" id="" class="form-select">
                            <option value="">FPT Polytechnic</option>
                            <option value="">FPT Polytechnic</option>
                            <option value="">FPT Polytechnic</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label for="" class="form-label">Tiêu đề bảng<span class="text-danger">*</span></label>
                        <input
                            type="number"
                            class="form-control"
                            id="title-board"
                            placeholder="Nhập tiêu đề bảng"
                            autofocus
                        />
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Không gian làm việc</label>
                        <select name="" id="" class="form-select">
                            <option value="">FPT Polytechnic</option>
                            <option value="">FPT Polytechnic</option>
                            <option value="">FPT Polytechnic</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Quyền xem</label>
                        <select name="" id="" class="form-select">
                            <option value="">Không gian làm việc</option>
                            <option value="">Công khai</option>
                            <option value="">Riêng tư</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <div class=" d-flex">
                            <input type="checkbox" name="" value="1" class="form-check-input" checked>
                            <label for="" class="ms-2">Giữ thẻ</label>
                        </div>
                       <p>Hoạt động, nhận xét và các thành viên sẽ không được sao chép sang bảng thông tin</p>

                    </div>
                    <div class="mt-3 card">
                        <button class="btn btn-primary">Tạo Mới</button>
                    </div>
                    <!--end col-->
                </form>
            </div>
        </div>
    </div>
</div>

