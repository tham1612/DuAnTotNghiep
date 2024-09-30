@extends('layouts.masterMain')
@section('main')
    <div class="row justify-content-center">
        <div class="col-xxl-9">
            @if (session('msg'))
                <div class="alert alert-success">
                    {{ session('msg') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body border-bottom border-bottom-dashed p-4">
                    <div class="row">

                        <div class="col-lg-6">
                            <form action="{{ route('editWorkspace') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="profile-user mx-auto mb-3">
                                    <label for="profile-img-file-input" class="d-block" tabindex="0">
                                        <span
                                            class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded"
                                            style="height: 60px; width: 256px;">
                                            <img src="{{ asset('theme/assets/images/logo-dark.png') }}"
                                                class="card-logo card-logo-dark user-profile-image img-fluid"
                                                alt="logo dark">
                                            <img src="{{ asset('theme/assets/images/logo-light.png') }}"
                                                class="card-logo card-logo-light user-profile-image img-fluid"
                                                alt="logo light">
                                        </span>
                                    </label>

                                    <div class="d-flex align-items-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                            @if ($workspaceChecked->image)
                                                <img class="rounded avatar-xl img-thumbnail user-profile-imager"
                                                    src="{{ \Illuminate\Support\Facades\Storage::url($workspaceChecked->image) }}"
                                                    alt="Avatar" />
                                            @else
                                                <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center fs-20"
                                                    style="width: 80px;height: 80px">
                                                    {{ strtoupper(substr($workspaceChecked->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                <input type="file" name="image"
                                                    class="profile-img-file-input @error('image') is-invalid @enderror"
                                                    id="image" placeholder="Image">
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <label for="image" class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="m-0">không gian làm việc của {{ $workspaceChecked->wsp_name }}</h5>
                                            <span class="text-muted small"><i
                                                    class="bi bi-globe"></i>{{ $access }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div>
                                        <label for="name">Tên*</label>
                                    </div>
                                    <input type="text" name="name" class="form-control bg-light border-0"
                                        id="name" minlength="5" maxlength="100" value="{{ $workspaceChecked->name }}"
                                        required />
                                    <div class="invalid-feedback">Tên là bắt buộc và phải chứa ít nhất 5 ký tự.</div>
                                </div>
                                <div>
                                    <label for="description">Mô tả</label>
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <textarea name="description" class="form-control bg-light border-0" id="description" rows="3" placeholder="Mô tả"
                                            required>{{ $workspaceChecked->description }}</textarea>
                                        <div class="invalid-feedback">Vui lòng nhập mô tả.</div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Lưu</button>
                            </form>
                        </div>

                        <!--end col-->
                        <div class="col-lg-5 ms-auto">
                            <div class="mt-5">
                                <div class="bg-primary p-2 rounded text-center">
                                    <i class="ri-user-add-line text-white"></i>
                                    <a href="#addmemberModal" data-bs-toggle="modal" class="avatar-group-item">
                                        <span class="text-white">Mời thành viên vào Không gian làm việc</span>
                                    </a>
                                </div>
                                {{-- @include('components.invitemember') --}}

                                <div class="modal fade" id="addmemberModal" tabindex="-1"
                                    aria-labelledby="addmemberModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border-0" style="width: 125%;">
                                            <div class="modal-header p-3">
                                                <h5 class="modal-title" id="addmemberModalLabel">
                                                    Chia sẻ không gian làm việc
                                                </h5>
                                                <button type="button" class="btn-close" id="btn-close-member"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row g-3">
                                                    <form action="{{ route('invite_workspace', $workspaceChecked->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class=" d-flex justify-content-between">
                                                            <div class="col-6">
                                                                <input type="email" class="form-control"
                                                                    id="submissionidInput"
                                                                    placeholder="Nhập email hoặc tên người dùng"
                                                                    name="email" />
                                                            </div>
                                                            <div class="col-4 ms-2">
                                                                <select name="authorize" id=""
                                                                    class="form-select">
                                                                    <option value="Member">Thành Viên</option>
                                                                    <option value="Sub_Owner">Phó nhóm</option>
                                                                    <option value="Viewer">Người Xem</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-2 d-flex justify-content-center">
                                                                <button type="submit" class="btn btn-primary">
                                                                    Chia sẻ
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!--end col-->
                                                    <div class="d-flex justify-content-between">
                                                        <div class="col-1">
                                                            <i class="ri-attachment-2 fs-22"></i>
                                                        </div>
                                                        <div class="col-7 d-flex flex-column">
                                                            <section class="fs-12">
                                                                <p style="margin-bottom: -5px;">Bất kỳ ai có thể theo
                                                                    gia với tư
                                                                    cách thành viên</p>
                                                                <span><a href="">Sao chép liên kết</a></span>
                                                                <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                                                <span><a href="">Xóa liên kết</a></span>
                                                            </section>
                                                        </div>
                                                        <div class="col-4">
                                                            <select name="" id="" class="form-select">
                                                                <option value="">Thay đổi quyền</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3"
                                                        role="tablist">
                                                        <li
                                                            class="nav-item d-flex align-items-center justify-content-between">
                                                            <a class="nav-link active" data-bs-toggle="tab"
                                                                href="#home1" role="tab">
                                                                Thành viên trong không gian làm việc
                                                            </a>
                                                            <span
                                                                class="badge bg-dark align-items-center justify-content-center d-flex"
                                                                style="border-radius: 100%; width: 20px ;height: 20px;">{{ $wsp_member_count + 1 }}</span>
                                                        </li>
                                                        <li
                                                            class="nav-item d-flex align-items-center justify-content-between">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#profile1"
                                                                role="tab">
                                                                Yêu cầu tham gia
                                                            </a>
                                                            <span
                                                                class="badge bg-dark align-items-center justify-content-center d-flex"
                                                                style="border-radius: 100%; width: 20px ;height: 20px;">{{ $wsp_invite_count }}</span>
                                                        </li>
                                                        <li
                                                            class="nav-item d-flex align-items-center justify-content-between">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#profile2"
                                                                role="tab">
                                                                Người xem
                                                            </a>
                                                            <span
                                                                class="badge bg-dark align-items-center justify-content-center d-flex"
                                                                style="border-radius: 100%; width: 20px ;height: 20px;">{{ $wsp_viewer_count }}</span>
                                                        </li>

                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content text-muted">
                                                        <div class="tab-pane active" id="home1" role="tabpanel">
                                                            <ul style="margin-left: -32px;">
                                                                <li class="d-flex">
                                                                    <div class="col-1">
                                                                        <a href="javascript: void(0);"
                                                                            class="avatar-group-item"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover"
                                                                            data-bs-placement="top" title="Nancy">
                                                                            @if ($wsp_owner->image)
                                                                                <img src="{{ Storage::url($wsp_owner->image) ? Storage::url($wsp_owner->image) : '' }}"
                                                                                    alt=""
                                                                                    class="rounded-circle avatar-xs" />
                                                                            @else
                                                                                <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                                                    style="width: 25px;height: 25px">
                                                                                    {{ strtoupper(substr($wsp_owner->name, 0, 1)) }}
                                                                                </div>
                                                                                <span class="fs-15 ms-2 text-white"
                                                                                    id="swicthWs">
                                                                                    {{ \Illuminate\Support\Str::limit($wsp_owner->name, 16) }}
                                                                                    <i
                                                                                        class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                </span>
                                                                            @endif


                                                                        </a>
                                                                    </div>
                                                                    <div class="col-8 d-flex flex-column">
                                                                        <section class="fs-12">
                                                                            <p style="margin-bottom: 0px;"
                                                                                class="text-danger fw-bloder">
                                                                                {{ $wsp_owner->name }}
                                                                                @if ($wsp_owner->user_id == $userId)
                                                                                    <span
                                                                                        class="text-danger fw-bloder">(bạn)</span>
                                                                                @else
                                                                                    <span
                                                                                        class="text-danger fw-bold">(chủ)</span>
                                                                                @endif

                                                                            </p>
                                                                            <span>@ {{ $wsp_owner->name }}</span>
                                                                            <span><i
                                                                                    class="ri-checkbox-blank-circle-fill"></i></span>
                                                                            <span>Quản trị viên không gian làm
                                                                                việc</span>
                                                                        </section>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <button class="btn btn-outline-danger ">Quản
                                                                            trị viên</button>
                                                                    </div>
                                                                </li>
                                                                @foreach ($wsp_member as $item)
                                                                    <li class="d-flex mt-1 mb-1">
                                                                        <div class="col-1">
                                                                            <a href="javascript: void(0);"
                                                                                class="avatar-group-item"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-trigger="hover" data-bs-item="top"
                                                                                title="Nancy">
                                                                                @if ($item->image)
                                                                                    <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                                                        alt=""
                                                                                        class="rounded-circle avatar-xs" />
                                                                                @else
                                                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                                                        style="width: 25px;height: 25px">
                                                                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                                                                    </div>
                                                                                    <span class="fs-15 ms-2 text-white"
                                                                                        id="swicthWs">
                                                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                                                        <i
                                                                                            class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                    </span>
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-8 d-flex flex-column">
                                                                            <section class="fs-12">
                                                                                <p style="margin-bottom: 0px;"
                                                                                    class="text-black">
                                                                                    {{ $item->name }}
                                                                                    @if ($item->user_id == $userId)
                                                                                        <span
                                                                                            class="text-success">(Bạn)</span>
                                                                                    @elseif($item->authorize === 'Sub_Owner')
                                                                                        <span class="text-primary">(Phó
                                                                                            nhóm)</span>
                                                                                    @else
                                                                                        <span class="text-black">(Thành
                                                                                            viên)</span>
                                                                                    @endif

                                                                                </p>
                                                                                <span>@ {{ $item->name }}</span>
                                                                                <span><i
                                                                                        class="ri-checkbox-blank-circle-fill"></i></span>
                                                                                <span>Thành viên của không gian làm
                                                                                    việc</span>
                                                                            </section>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            {{-- <select name="" id=""
                                                                                    class="form-select">
                                                                                    <option value="">Thành Viên
                                                                                    </option>
                                                                                </select> --}}
                                                                            <button class="btn btn-outline-primary">Thành
                                                                                viên</button>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="tab-pane" id="profile1" role="tabpanel">
                                                            <ul style="margin-left: -32px;">
                                                                @foreach ($wsp_invite as $item)
                                                                    <li class="d-flex justify-content-between">
                                                                        <div class="col-1">
                                                                            <a href="javascript: void(0);"
                                                                                class="avatar-group-item"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-trigger="hover"
                                                                                data-bs-placement="top" title="Nancy">
                                                                                @if ($item->image)
                                                                                    <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                                                        alt=""
                                                                                        class="rounded-circle avatar-xs" />
                                                                                @else
                                                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                                                        style="width: 25px;height: 25px">
                                                                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                                                                    </div>
                                                                                    <span class="fs-15 ms-2 text-white"
                                                                                        id="swicthWs">
                                                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                                                        <i
                                                                                            class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                    </span>
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-7 d-flex flex-column">
                                                                            <section class="fs-12">
                                                                                <p style="margin-bottom: 0px;"
                                                                                    class="text-black">
                                                                                    {{ $item->name }}
                                                                                    <span class="text-black">(Người
                                                                                        mới)</span>
                                                                                </p>
                                                                                <span>@ {{ $item->name }}</span>
                                                                                <span><i
                                                                                        class="ri-checkbox-blank-circle-fill"></i></span>
                                                                                <span>Đã gửi lời mời vao không gian làm
                                                                                    việc</span>
                                                                            </section>
                                                                        </div>
                                                                        <div class="col-4 d-flex justify-content-end">
                                                                            <form onsubmit="disableButtonOnSubmit()"
                                                                                action="{{ route('accept_member') }}"
                                                                                method="post">
                                                                                @method('PUT')
                                                                                @csrf
                                                                                <input type="hidden"
                                                                                    value="{{ $item->user_id }}"
                                                                                    name="user_id">
                                                                                <input type="hidden"
                                                                                    value="{{ $item->workspace_id }}"
                                                                                    name="workspace_id">
                                                                                <input type="hidden" value="NULL"
                                                                                    name="type_update">
                                                                                <button class="btn btn-primary me-2"
                                                                                    type="submit">Duyệt</button>
                                                                            </form>
                                                                            <form
                                                                                action="{{ route('refuse_member', $item->wm_id) }}"
                                                                                onsubmit="disableButtonOnSubmit()"
                                                                                method="post">
                                                                                @method('DELETE')
                                                                                @csrf
                                                                                <button class="btn btn-danger"
                                                                                    type="submit">Từ chối</button>
                                                                            </form>
                                                                        </div>
                                                                    </li>
                                                                    <br>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="tab-pane" id="profile2" role="tabpanel">
                                                            <ul style="margin-left: -32px;">
                                                                @foreach ($wsp_viewer as $item)
                                                                    <li class="d-flex justify-content-between">
                                                                        <div class="col-1">
                                                                            <a href="javascript: void(0);"
                                                                                class="avatar-group-item"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-trigger="hover"
                                                                                data-bs-placement="top" title="Nancy">
                                                                                @if ($item->image)
                                                                                    <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                                                        alt=""
                                                                                        class="rounded-circle avatar-xs" />
                                                                                @else
                                                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                                                        style="width: 25px;height: 25px">
                                                                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                                                                    </div>
                                                                                    <span class="fs-15 ms-2 text-white"
                                                                                        id="swicthWs">
                                                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                                                        <i
                                                                                            class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                    </span>
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-7 d-flex flex-column">
                                                                            <section class="fs-12">
                                                                                <p style="margin-bottom: 0px;"
                                                                                    class="text-black">
                                                                                    {{ $item->name }}
                                                                                    <span class="text-black">(Người xem)</span>
                                                                                </p>
                                                                                <span>@ {{ $item->name }}</span>
                                                                                <span><i
                                                                                        class="ri-checkbox-blank-circle-fill"></i></span>
                                                                                <span>Tham quan không gian làm việc</span>
                                                                            </section>
                                                                        </div>
                                                                        <div class="col-4 d-flex justify-content-end">
                                                                            {{-- <form onsubmit="disableButtonOnSubmit()"
                                                                                action="{{ route('accept_member') }}"
                                                                                method="post">
                                                                                @method('PUT')
                                                                                @csrf
                                                                                <input type="hidden"
                                                                                    value="{{ $item->user_id }}"
                                                                                    name="user_id">
                                                                                <input type="hidden"
                                                                                    value="{{ $item->workspace_id }}"
                                                                                    name="workspace_id">
                                                                                <input type="hidden" value="NULL"
                                                                                    name="type_update">
                                                                                <button class="btn btn-primary me-2"
                                                                                    type="submit">Thêm thành viên</button>
                                                                            </form> --}}
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
                <div class="card-body py-4">
                    <div class="mt-3">
                        <h2>Các cài đặt không gian làm việc</h2>
                        <div class="form-switch mt-3" style="margin-left: -30px">
                            <label class="form-check-label">Khả năng hiển thị trong không gian
                                làm việc</label>
                            <hr>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p><i class="{{ $icon }}"></i> {{ $access }} - {{ $ws_desrip }}</p>
                        {{-- <button class="btn btn-primary">Thay đổi</button> --}}

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#customModal">
                            Mở cài đặt
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form onsubmit="disableButtonOnSubmit()" action="{{ route('update_ws_access') }}"
                                        method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="customModalLabel">Chọn khả năng hiển thị trong
                                                Không gian làm việc</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Privacy Options -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="access"
                                                    id="privateOption" value="private"
                                                    {{ $workspaceChecked->access == 'private' ? 'checked' : '' }}>
                                                <label class="form-check-label option-label" for="privateOption">
                                                    <i class="ri-lock-2-line fs-20 text-danger"></i>Riêng tư
                                                </label>
                                                <p class="option-description">
                                                    Đây là Không gian làm việc riêng tư. Chỉ những người trong Không
                                                    gian
                                                    làm việc có thể truy cập hoặc nhìn thấy Không gian làm việc.
                                                </p>
                                            </div>
                                            <hr>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="access"
                                                    id="publicOption" value="public"
                                                    {{ $workspaceChecked->access == 'public' ? 'checked' : '' }}>
                                                <label class="form-check-label option-label" for="publicOption">
                                                    <i class="ri-earth-line fs-20 text-success"></i>Công khai
                                                </label>
                                                <p class="option-description">
                                                    Đây là Không gian làm việc công khai. Bất kỳ ai có đường dẫn tới
                                                    Không
                                                    gian làm việc đều có thể nhìn thấy hoặc tìm thấy Không gian làm
                                                    việc.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{--  --}}
                    </div>
                </div>
                <a style="margin-left: 15px; padding-bottom:20px"
                    href="{{ route('workspaces.delete', $workspaceChecked->wm_id) }}"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa bỏ không gian làm việc?')" class="text-danger">Xóa
                    Không gian
                    làm việc này?</a>
            </div>
        </div>
        <!--end col-->
    </div>

    </div>
@endsection

@section('title')
    Chỉnh sửa không gian làm việc
@endsection

@section('script')
    <!-- dropzone min -->
    <script src="assets/libs/dropzone/dropzone-min.js"></script>

    <!-- cleave.js -->
    <script src="assets/libs/cleave.js/cleave.min.js"></script>

    <!--Invoice create init js-->
    <script src="assets/js/pages/invoicecreate.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
@endsection
@section('style')
    <style></style>
@endsection
