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
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer">
                    <i class="ri-eye-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3">Theo dõi</p>
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
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer">
                    <i class=" ri-share-line fs-22"></i>
                    <p class="ms-3 fs-14 mt-3">In, xuất và chia sẻ</p>
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
                @if(!empty($board_owner))
                    @if ($board_owner->image)
                        <img src="{{ Storage::url($board_owner->image) ? Storage::url($board_owner->image) : '' }}"
                             alt="" class="rounded-circle avatar-xs object-fit-cover" style="width: 60px;height: 60px"/>
                    @else
                        <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                             style="width: 40px;height: 40px">
                            {{ strtoupper(substr($board_owner->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="fs-15 ms-2 d-flex flex-column">
                          {{ \Illuminate\Support\Str::limit($board_owner->name, 16) }}
                         <a href="{{route('user',Auth::id())}}">Sửa thông tin cá nhân</a>
                    </span>
                @endif
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
                    <span class="badge bg-dark align-items-center justify-content-center d-flex"
                          style="border-radius: 100%; width: 20px ;height: 20px;">@if(!empty( $board_m_invite))
                            {{ $board_m_invite->count() }}
                        @endif</span>
                </li>
                <li class="nav-item d-flex align-items-center justify-content-between">
                    <a class="nav-link" data-bs-toggle="tab" href="#storageTask" role="tab">
                        Thẻ đã lưu trữ
                    </a>
                    <span class="badge bg-dark align-items-center justify-content-center d-flex"
                          style="border-radius: 100%; width: 20px ;height: 20px;">@if(!empty( $board_m_invite))
                            {{ $board_m_invite->count() }}
                        @endif</span>
                </li>
            </ul>

            <div class="tab-content text-muted">
                <div class="tab-pane active" id="storageCatalog" role="tabpanel">

                    <input type="text" class="form-control" placeholder="Tìm kiếm danh sách lưu trữ">

                    <div class="row p-3 ">
                        @foreach($board->catalogs()->onlyTrashed()->get() as $archiverCatalog)
                            <div
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

                    <input type="text" class="form-control" placeholder="Tìm kiếm thẻ lưu trữ">

                    <div class="row p-3 ">
                        @foreach($board->catalogs as $catalog)
                            @foreach($catalog->tasks()->onlyTrashed()->get() as $archiverTask)
                                <div class="bg-warning-subtle border rounded mt-2">
                                    <p class="fs-16 mt-2 text-danger">{{$archiverTask->text}}</p>
                                    <ul class="link-inline" style="margin-left: -32px">
                                        <!-- theo dõi -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted">
                                                <i class="ri-eye-line align-bottom"></i>
                                                04</a>
                                        </li>
                                        <!-- bình luận -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted">
                                                <i class="ri-question-answer-line align-bottom"></i>
                                                19</a>
                                        </li>
                                        <!-- tệp đính kèm -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted">
                                                <i class="ri-attachment-2 align-bottom"></i>
                                                02</a>
                                        </li>
                                        <!-- checklist -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted">
                                                <i class="ri-checkbox-line align-bottom"></i>
                                                2/4</a>
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
                <p class="fw-bold fs-15">Quyền</p>

                <div class="row mt-2">
                    <label for="">Nhận xét</label>
                    <select class="form-select border-0" id="">
                        <option value="">Thành viên</option>
                        <option value="">Chỉ có quản trị viên</option>
                        <option value="">Tất cả mọi người trong không gian làm việc</option>
                    </select>
                </div>
                <div class="row mt-2">
                    <label for="">Thêm và xóa thành viên</label>
                    <select class="form-select border-0" id="">
                        <option value="">Thành viên</option>
                        <option value="">Chỉ có quản trị viên</option>
                    </select>
                </div>
                <div class="row mt-2">
                    <label for="">Chỉnh sửa Không gian làm việc</label>
                    <select class="form-select border-0" id="">
                        <option value="">Mọi người trong không gian</option>
                        <option value="">Chỉ có thành viên trong bảng</option>
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
                <input type="text" name="" id=""
                       class="form-control border-1" placeholder="Tìm nhãn..."/>
                <div class="mt-3">
                    <ul class="" style="list-style: none; margin-left: -32px">
                        @foreach($board->tags as $tag)
                            <li class="mt-1 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center w-100">
                                    {{--                                    <input type="checkbox" name="" id="danger_tags"--}}
                                    {{--                                           class="form-check-input"/>--}}
                                    <span class=" mx-2 rounded p-2 col-11 text-white"
                                          style="background-color: {{$tag->color_code}}">{{$tag->name}}  </span>
                                </div>
                                <i class="ri-pencil-line fs-20 cursor-pointer" data-bs-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false"></i>
                                <div class="dropdown-menu dropdown-menu-md p-3 border-2" style="width: 100%">
                                    <h5 class="text-center">Cập nhật</h5>
                                    <form>
                                        <input type="hidden" name="board_id" value="{{$tag->board_id}}">
                                        <div class="mt-3">
                                            <label for="">Tiêu đề</label>
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
                                                            class="color-box border rounded @if($color->code == $tag->color_code) selected-tag @endif"
                                                            style="width: 50px;height: 30px; background-color: {{$color->code}}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-primary" id="update-tag-form">
                                                Cập nhật
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
                           aria-expanded="false" data-bs-offset="50,-250">
                            Tạo nhãn mới
                        </p>
                        <!--dropdown nhãn-->
                        <div class="dropdown-menu dropdown-menu-md p-3 border-2" style="width: 100%">
                            {{--                            @include('dropdowns.createTag')--}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
