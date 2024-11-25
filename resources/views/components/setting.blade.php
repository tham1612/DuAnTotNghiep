<div class="offcanvas offcanvas-end" tabindex="-1" id="settingBoard" aria-labelledby="offcanvasRightLabel"
     style="width: 350px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-center" id="offcanvasRightLabel">
            Cài đặt
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)">
            <ul style="list-style: none;" class="p-3">
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                    style="margin-top: -20px;"
                    data-bs-toggle="offcanvas" data-bs-target="#detailBoard">
                    <i class=" ri-error-warning-line fs-22"></i>
                    <div class="ms-3 fs-14 mt-3">
                        <p style="margin-bottom: 0px; margin-top: 15px;">Chi tiết bảng</p>
                        <p class="fs-10 " style="margin-top: 0">Thêm mô tả vào bảng</p>
                    </div>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#activityBoard">
                    <i class="ri-line-chart-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3">Hoạt động</p>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#storageBoard">
                    <i class="ri-archive-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3">Mục đã lưu trữ</p>
                </li>
                <hr>
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#generalSettingBoard">
                    <i class="ri-settings-3-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3">Cài đặt</p>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#tagBoard">
                    <i class=" ri-price-tag-3-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3">Nhãn</p>
                </li>
                {{--                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer">--}}
                {{--                    <i class="ri-eye-line fs-22"></i>--}}
                {{--                    <p class="ms-3 fs-14 mt-3">Theo dõi</p>--}}
                {{--                </li>--}}
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer">
                    <i class=" ri-share-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3">In, xuất và chia sẻ</p>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                >
                    <i class=" ri-file-copy-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       data-bs-offset="-40,10">
                        Sao chép bảng</p>
                    <div class="dropdown-menu dropdown-menu-md p-3 border-2" style="width: 90%">
                        @include('dropdowns.copyBoard')
                    </div>
                </li>

                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                >
                    <i class="ri-subtract-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       data-bs-offset="-40,10">
                        Đóng bảng thông tin</p>
                    <div class="dropdown-menu dropdown-menu-md p-3 border-2" style="width: 90%">
                        <h5 class="text-center">Đóng bảng?</h5>
                        <p>Bạn có thể tìm và mở lại các bảng đã đóng ở cài đặt tài khoản</p>
                        <button class="btn btn-danger w-100"
                                onclick="archiverBoard({{request()->route('id')}})">Đóng
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="detailBoard" aria-labelledby="detailBoardLabel"
     style="width: 350px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-center" id="detailBoardLabel">
            Chi tiết
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)" class="p-2">
            <div class="d-flex align-items-center">
                <i class="ri-user-settings-line fs-24"></i>
                <p class="fs-16 mt-3 ms-1">Quản trị viên của bảng</p>
            </div>
            <div class="d-flex flex-row">
                @if(!empty($boardOwner))
                    @if ($boardOwner->image)
                        <img src="{{ Storage::url($boardOwner->image) ? Storage::url($boardOwner->image) : '' }}"
                             alt="" class="rounded-circle avatar-xs object-fit-cover" style="width: 60px;height: 60px"/>
                    @else
                        <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                             style="width: 40px;height: 40px">
                            {{ strtoupper(substr($boardOwner->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="fs-15 ms-2 d-flex flex-column">
                        <p> {{ \Illuminate\Support\Str::limit($boardOwner->name, 16) }}</p>
                        <p style="margin-top: -15px">  {{  $boardOwner->fullName
                              ? '@' . $boardOwner->fullName
                              : '@' . $boardOwner->name
                              }}</p>
                    </div>
                @endif
            </div>
            <div>
                <section class="d-flex mt-3 fs-20">
                    <i class="ri-menu-2-line"></i>
                    <p class="ms-2">Ảnh của bảng</p>
                </section>
                <input type="file" class="form-control" name="image"
                       id="image_board_{{ $board->id }}"
                       value="{{ $board->image }}"
                       onchange="updateBoard({{ $board->id }})"/>
            </div>

            <div>
                <section class="d-flex mt-3 fs-20">
                    <i class="ri-menu-2-line"></i>
                    <p class="ms-2">Mô tả</p>
                </section>
                <form action="#" method="post">
                    <textarea class="form-control" id="" cols="30" rows="10"></textarea>
                </form>
            </div>

            <hr>

            <p>Các thành viên có thể...</p>

            <p class="fs-15 fw-bold">
                <i class="ri-chat-1-line fs-20"></i>
                <span>Bình luận trên các thẻ</span>
            </p>

            <button class="btn btn-outline-dark">Thay đổi quyền</button>
        </div>
    </div>

</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="activityBoard" aria-labelledby="activityCanvasLabel"
     style="width: 350px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="activityCanvasLabel">Hoạt động</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)">
            <ul style="list-style: none;" class="p-3">
                @if (!empty($activities))
                    @foreach ($activities as $activity)
                        <li class="d-flex align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if (!empty($activity->causer) && !empty($activity->causer->avatar))
                                        <img src="{{ asset('path_to_avatar/' . $activity->causer->avatar) }}"
                                             alt="avatar" class="rounded-circle" width="40" height="40">
                                    @else
                                        <div
                                            class="bg-info-subtle rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($activity->causer->name ?? 'Hệ thống', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="mb-1">
                                    <strong>{{ $activity->causer->name ?? 'Hệ thống' }}:</strong>
                                    {{ $activity->description ?? 'Không có mô tả' }}
                                </p>
                                <small class="text-muted">
                                    {{ $activity && $activity->created_at ? $activity->created_at->diffForHumans() : 'Không xác định thời gian' }}
                                </small>
                            </div>
                        </li>
                    @endforeach
                @endif

            </ul>
        </div>
    </div>
</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="storageBoard" aria-labelledby="storageBoardLabel"
     style="width: 350px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-center" id="detailBoardLabel">
            Lưu trữ
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)" class="p-2">
            <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                <li class="nav-item d-flex align-items-center justify-content-between">
                    <a class="nav-link active" data-bs-toggle="tab" href="#storageCatalog" role="tab">
                        Danh sách lưu trữ
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center justify-content-between">
                    <a class="nav-link" data-bs-toggle="tab" href="#storageTask" role="tab">
                        Thẻ đã lưu trữ
                    </a>
                </li>
            </ul>

            <div class="tab-content text-muted">
                <div class="tab-pane active" id="storageCatalog" role="tabpanel">

{{--                    <input type="text" class="form-control" placeholder="Tìm kiếm danh sách lưu trữ">--}}

                    <div class="row p-3 " id="catalog-container-setting-board">
                        @foreach($board->catalogs()->onlyTrashed()->get() as $archiverCatalog)
                            <div id="catalog_id_archiver_{{$archiverCatalog->id}}"
                                 class="d-flex align-items-center justify-content-between  border rounded bg-warning-subtle mt-2">
                                <p class="fs-16 text-danger mt-3">{{$archiverCatalog->name}}</p>
                                <div>
                                    <button class="btn btn-outline-dark"
                                            onclick="restoreCatalog({{ $archiverCatalog->id }})">
                                        Khôi phục
                                    </button>
                                    <button class="btn btn-outline-dark"
                                            onclick="destroyCatalog({{ $archiverCatalog->id }})">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="tab-pane" id="storageTask" role="tabpanel">

{{--                    <input type="text" class="form-control" placeholder="Tìm kiếm thẻ lưu trữ">--}}

                    <div class="row p-3 " id="task-container-setting-board">
                        @php $board->load(['catalogs.tasks' => function ($query) {
                                $query->onlyTrashed(); // Chỉ lấy tasks đã xóa mềm
                            }]);
                        @endphp
                        @foreach($board->catalogs as $catalog)
                            @foreach($catalog->tasks as $archiverTask)
                                <div id="task_id_archiver_{{$archiverTask->id}}">
                                    <div class="bg-warning-subtle border rounded ps-2"
                                    >
                                        <p class="fs-16 mt-2 text-danger">{{$archiverTask->text}}</p>
                                        <ul class="link-inline" style="margin-left: -32px">
                                            <!-- theo dõi -->
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted">
                                                    <i class="ri-eye-line align-bottom"></i>
                                                </a>
                                            </li>
                                            <!-- bình luận -->
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted">
                                                    <i class="ri-question-answer-line align-bottom"></i>
                                                </a>
                                            </li>
                                            <!-- tệp đính kèm -->
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted">
                                                    <i class="ri-attachment-2 align-bottom"></i>
                                                </a>
                                            </li>
                                            <!-- checklist -->
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted">
                                                    <i class="ri-checkbox-line align-bottom"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fs-13 fw-bold d-flex">
                                         <span class="text-primary cursor-pointer"
                                               onclick="restoreTask({{$archiverTask->id}})">Khôi phục</span>
                                        -
                                        <span class="text-danger cursor-pointer"
                                              onclick="destroyTask({{$archiverTask->id}})">Xóa</span>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="generalSettingBoard" aria-labelledby="storageBoardLabel"
     style="width: 350px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-center" id="detailBoardLabel">
            Thiết lập
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)" class="p-2">
            <div class="p-2">
                <p class="fw-bold fs-16">Tên bảng</p>
                <div class="row">
                    <input type="text" name="" id="" class="border-0 form-control fs-18" value="{{$board->name}}"
                           style="margin-top: -15px" onchange="updatePermission('name', this.value,{{$board->id}})">
                </div>
                <p class="fw-bold fs-16 mt-3">Chế độ</p>
                <div class="row" style="margin-top: -15px">
                    <select class="form-select border-0 cursor-pointer fs-14" id="commentPermission"
                            onchange="updatePermission('access', this.value,{{$board->id}})">
                        <option value="public" @selected($board->access == 'public')>Công khai</option>
                        <option value="private" @selected($board->access == 'private')>Riêng tư</option>
                    </select>
                </div>
                <hr>
                <p class="fw-bold fs-16 mt-3">Quyền</p>
                <div class="row my-2">
                    <label class="fs-16">Nhận xét</label>
                    <select class="form-select border-0 cursor-pointer fs-14" id="commentPermission"
                            onchange="updatePermission('commentPermission', this.value,{{$board->id}})">
                        <option value="owner" @selected($board->comment_permission === 'owner')>Chỉ có quản trị viên
                        </option>
                        <option value="board" @selected($board->comment_permission === 'board')>Tất cả thành viên trong
                            bảng
                        </option>
                        <option value="workspace" @selected($board->comment_permission === 'workspace')>Tất cả mọi người
                            trong không
                            gian làm
                            việc
                        </option>
                    </select>
                </div>
                <div class="row my-2">
                    <label class="fs-16">Thêm và xóa thành viên</label>
                    <select class="form-select border-0 cursor-pointer fs-14" id="memberPermission"
                            onchange="updatePermission('memberPermission', this.value,{{$board->id}})">
                        <option value="board" @selected($board->member_permission === 'board')>Tất cả thành viên trong
                            bảng
                        </option>
                        <option value="owner" @selected($board->member_permission === 'owner')>Chỉ có quản trị viên
                        </option>
                    </select>
                </div>
                <div class="row my-2">
                    <label class="fs-16">Chỉnh sửa bảng</label>
                    <select class="form-select border-0 cursor-pointer fs-14" id="workspaceEditPermission"
                            onchange="updatePermission('boardEditPermission', this.value,{{$board->id}})">
                        <option value="owner" @selected($board->edit_board === 'owner')>Chỉ có quản trị viên</option>
                        <option value="board" @selected($board->edit_board === 'board')>Chỉ có thành viên trong bảng
                        </option>
                        <option value="workspace" @selected($board->edit_board === 'workspace')>Mọi người trong không
                            gian
                        </option>
                    </select>
                </div>
                <div class="row my-2">
                    <label class="fs-16">Lưu trữ</label>
                    <select class="form-select border-0 cursor-pointer fs-14" id="archivePermission"
                            onchange="updatePermission('archivePermission', this.value,{{$board->id}})">
                        <option value="owner" @selected($board->archiver_permission === 'owner')>Chỉ có quản trị viên
                        </option>
                        <option value="board" @selected($board->archiver_permission === 'board')>Tất cả thành viên trong
                            bảng
                        </option>
                    </select>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="tagBoard" aria-labelledby="storageBoardLabel"
     style="width: 350px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-center" id="detailBoardLabel">
            Nhãn
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh)" class="p-2">
            <form action="">
                {{--                <input type="text" name="" id=""--}}
                {{--                       class="form-control border-1" placeholder="Tìm nhãn..."/>--}}
                <div class="mt-3">
                    <ul class="ul-tag-board" style="list-style: none; margin-left: -32px">
                        @foreach($board->tags as $tag)
                            <li class="mt-1 d-flex justify-content-between align-items-center"
                                id="tag-board-item-{{$tag->id}}">
                                <div class="d-flex align-items-center w-100">
                                    <span class=" mx-2 rounded p-2 col-11 text-white"
                                          id="tag-board-{{$tag->id}}"
                                          style="background-color: {{$tag->color_code}}">{{$tag->name}}  </span>
                                </div>
                                <i class="ri-pencil-line fs-20 cursor-pointer" data-bs-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false"></i>
                                <div class="dropdown-menu dropdown-menu-md p-3 border-2" style="width: 100%">
                                    <h5 class="text-center">Cập nhật</h5>
                                    <form>
                                        <input type="hidden" name="id" value="{{$tag->id}}">
                                        <input type="hidden" name="board_id" value="{{$tag->board_id}}">
                                        <div class="mt-3">
                                            <label class="fs-16">Tiêu đề</label>
                                            <input type="text" name="name" class="form-control border-1"
                                                   placeholder="Nhập tên nhãn" value="{{$tag->name}}"/>
                                        </div>
                                        <div class="mt-3">
                                            <label class="fs-14">Chọn màu</label>
                                            <div class="d-flex flex-wrap gap-2 select-color">
                                                @foreach($colors as $color)
                                                    <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                         data-bs-placement="top"
                                                         title="{{$color->name}}">
                                                        <div
                                                            class="color-box border rounded
                                                            @if($color->code == $tag->color_code) selected-tag @endif"
                                                            style="width: 50px;height: 30px; background-color: {{$color->code}}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-outline-primary update-tag-form">
                                                Cập nhật
                                            </button>
                                            <button class="btn btn-outline-danger delete-tag-form">
                                                Xóa
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card">
                    <div
                        class="d-flex align-items-center justify-content-center rounded p-3 w-100 cursor-pointer"
                        style=" height: 30px; background-color: #e4e6ea">
                        <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" data-bs-offset="0,0">
                            Tạo nhãn mới
                        </p>
                        <!--dropdown nhãn-->
                        <div class="dropdown-menu dropdown-menu-md p-3 border-2" style="width: 100%">
                            <h5 class="text-center">Tạo nhãn mới</h5>
                            <form>
                                <input type="hidden" name="board_id" value="{{request()->route('id')}}">
                                <div class="mt-3">
                                    <label for="">Tiêu đề</label>
                                    <input type="text" name="name" class="name-input form-control border-1"
                                           placeholder="Nhập tên nhãn"/>
                                </div>

                                <div class="mt-3">
                                    <label class="fs-14">Chọn màu</label>
                                    <div class="d-flex flex-wrap gap-2 select-color" id="color-options">
                                        @if (isset($colors))
                                            @foreach ($colors as $color)
                                                <div class="color-option" data-color="{{ $color->code }}"
                                                     data-bs-toggle="tooltip"
                                                     data-bs-trigger="hover" data-bs-placement="top"
                                                     title="{{ $color->name }}">
                                                    <div class="color-box border rounded"
                                                         style="width: 50px;height: 30px; background-color: {{ $color->code }}"></div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="button"
                                            class="btn btn-outline-primary waves-effect waves-light create-board-tag-form">
                                        Tạo mới
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    let selectedColor;
    document.querySelectorAll('.color-box').forEach(box => {
        box.addEventListener('click', function () {
            // Xóa lớp 'selected' khỏi tất cả các ô màu
            document.querySelectorAll('.color-box').forEach(b => b.classList.remove('selected-tag'));
            // Thêm lớp 'selected' vào ô màu đang được click
            this.classList.add('selected-tag');
        });
    });

    // Hàm tạo ra ID ngẫu nhiên với độ dài tùy chỉnh
    function generateRandomId(length) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return result;
    }

    // Gán ID ngẫu nhiên cho mỗi form và thêm thuộc tính data-form-id cho các button
    $('form').each(function () {
        const randomId = generateRandomId(10);
        $(this).attr('id', randomId); // Gán ID cho form
        $(this).find('button').attr('data-form-id', randomId); // Gán data-form-id cho button
    });

    // Hàm chuyển đổi từ RGB sang HEX
    function rgbToHex(rgb) {
        const rgbValues = rgb.match(/\d+/g); // Tách chuỗi RGB thành r, g, b
        const r = parseInt(rgbValues[0]).toString(16).padStart(2, '0');
        const g = parseInt(rgbValues[1]).toString(16).padStart(2, '0');
        const b = parseInt(rgbValues[2]).toString(16).padStart(2, '0');
        return `#${r}${g}${b}`.toUpperCase(); // Trả về mã màu HEX
    }


    // Gán sự kiện cho phần tử cha
    $('.select-color').on('click', 'div', function (e) {
        e.stopPropagation(); // Ngăn chặn sự kiện nổi bọt
        console.log("Đã click vào ô màu."); // Log để kiểm tra
        // Đảm bảo lấy đúng element chứa màu
        const rgb = $(this).css('background-color'); // Lấy giá trị background-color của div được click

        // Kiểm tra nếu giá trị thực sự là dạng rgb trước khi chuyển sang hex
        if (rgb && rgb.startsWith('rgb')) {
            selectedColor = rgbToHex(rgb); // Chuyển đổi sang mã màu HEX
            console.log('Màu đã chọn (HEX):', selectedColor); // Hiển thị mã màu đã chọn
        } else {
            console.log('Không có màu hợp lệ được chọn.');
        }
    });
    // Sự kiện click cho button tạo thẻ tag
    $('button.update-tag-form').off('click').on('click', function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của button
        const formId = $(this).data('form-id'); // Lấy ID của form từ button
        const form = $('#' + formId); // Lấy form theo ID

        // Lấy dữ liệu từ form cụ thể
        const formData = {
            id: form.find('input[name="id"]').val(),
            board_id: form.find('input[name="board_id"]').val(),
            task_id: form.find('input[name="task_id"]').val(),
            name: form.find('input[name="name"]').val(),
            color_code: selectedColor // Sử dụng mã màu đã chọn trước đó
        };

        // Gửi dữ liệu qua AJAX
        $.ajax({
            type: 'POST',
            url: '/tasks/tag/update',
            data: formData,
            success: function (response) {
                const tagBoard = $(`#tag-board-${response.tag.id}`);
                if (tagBoard) {
                    tagBoard.css('background-color', response.tag.color_code);

                    // Cập nhật nội dung
                    tagBoard.text(response.tag.name);
                }
            },
            error: function (error) {
                console.error('Lỗi:', error);
            }
        });
    });

    $('button.delete-tag-form').off('click').on('click', function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của button
        const formId = $(this).data('form-id'); // Lấy ID của form từ button
        const form = $('#' + formId); // Lấy form theo ID

        // Lấy dữ liệu từ form cụ thể
        const formData = {
            id: form.find('input[name="id"]').val(),
        };

        // Gửi dữ liệu qua AJAX
        $.ajax({
            type: 'DELETE',
            url: '/tasks/tag/delete',
            data: formData,
            success: function (response) {
                const tagBoard = $(`#tag-board-item-${response.tag.id}`);
                tagBoard.remove();
            },
            error: function (error) {
                console.error('Lỗi:', error);
            }
        });
    });

    $('button.create-board-tag-form').off('click').on('click', function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của button
        const formId = $(this).data('form-id'); // Lấy ID của form từ button
        const form = $('#' + formId); // Lấy form theo ID

        // Lấy dữ liệu từ form cụ thể
        const formData = {
            board_id: form.find('input[name="board_id"]').val(),
            name: form.find('input[name="name"]').val(),
            color_code: selectedColor // Sử dụng mã màu đã chọn trước đó
        };

        // Gửi dữ liệu qua AJAX
        $.ajax({
            type: 'POST',
            url: '/b/tag/create',
            data: formData,
            success: function (response) {
                notificationWeb(response.action, response.msg);
                appendTagBoard(response.tag);
                $('.dropdown-menu').dropdown('hide');

            },
            error: function (error) {
                console.error('Lỗi:', error);
            }
        });
    });

    function appendTagBoard(tag) {
        // Tạo phần tử <li> mới
        const newLi = document.createElement("li");
        newLi.className = "mt-1 d-flex justify-content-between align-items-center";

        // Nội dung HTML bên trong thẻ <li>
        newLi.innerHTML = `
        <div class="d-flex align-items-center w-100">
            <span class="mx-2 rounded p-2 col-11 text-white"
                  style="background-color: ${tag.color_code}">${tag.name}</span>
        </div>
        <i class="ri-pencil-line fs-20 cursor-pointer" data-bs-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false"></i>
    `;

        // Chèn <li> mới vào cuối <ul>
        const ulElement = document.querySelector(".ul-tag-board"); // Lấy thẻ ul theo selector
        if (ulElement) {
            ulElement.appendChild(newLi);
        }
    }
</script>
