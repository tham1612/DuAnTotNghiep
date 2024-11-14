
@foreach($template_boards as $tplBoard)
    <div
        class="modal fade"
        id="create-board-template-home-modal{{$tplBoard->id}}"
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
                    <form class="p-3 submitFormBoardTemplate">

                        <div class="mt-3">
                            <label for="" class="form-label">Mẫu bảng</label>
                            <select name="board_template_id" id="" class="form-select">
                                @foreach($template_boards as $tplBoardChild)
                                    <option
                                        value="{{$tplBoardChild->id}}"
                                        @selected($tplBoardChild->id === $tplBoard->id)>{{$tplBoardChild->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="" class="form-label">Tiêu đề bảng<span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control titleBoardTemplate"
                                id=""
                                placeholder="Nhập tiêu đề bảng"
                                name="name"
                                value="{{$tplBoard->name}}"
                                autofocus
                            />
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Không gian làm việc</label>
                            <input type="text" readonly value="{{$workspace->name}}" class="form-control">
                            <input type="hidden" value="{{$workspace->id}}" class="form-control"
                                   name="workspace_id">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Quyền xem</label>
                            <select name="access" id="" class="form-select">
                                <option value="public" selected>Công khai</option>
                                <option value="private">Riêng tư</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <div class=" d-flex">
                                <input type="checkbox" name="isTask" value="true" class="form-check-input" checked>
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
@endforeach
