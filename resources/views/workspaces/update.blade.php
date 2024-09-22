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
                                                <img class="rounded-circle avatar-xl img-thumbnail user-profile-imager"
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
                                            <h5 class="m-0">không gian làm việc của {{ $userName }}</h5>
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
                                        id="name" minlength="5" maxlength="100"
                                        placeholder="{{ $workspaceChecked->name }}" required />
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
                                {{-- <button class="btn btn-primary ms-3 mt-4" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-offset="0,-50">
                                    <i class="ri-add-line align-bottom me-1"></i>Mời thành viên vào Không gian làm việc
                                </button>
                                <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                    <form action="{{ route('invite_workspace', $workspaceChecked->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                                placeholder="Nhập email người dùng ..." name="email" />
                                        </div>
                                        <div class="mb-2 d-flex align-items-center">
                                            <button type="submit" class="btn btn-primary">
                                                Thêm thành viên
                                            </button>
                                            <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                        </div>
                                    </form>
                                </div> --}}

                                <div class="bg-primary p-2 rounded text-center">
                                    <i class="ri-user-add-line text-white"></i>
                                    <a href="#addmemberModal" data-bs-toggle="modal" class="avatar-group-item">
                                        <span class="text-white">Mời thành viên vào Không gian làm việc</span>
                                    </a>
                                </div>
                                @include('components.invitemember')

                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
                <div class="card-body py-4" style="margin-left: -15px">
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

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customModal">
                            Open Settings
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('update_ws_access') }}" method="post">
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
                                                    <span class="option-icon">🔒</span> Riêng tư
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
                                                    <span class="option-icon">🟢</span> Công khai
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
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{--  --}}
                    </div>
                </div>
                <a href="{{ route('workspaces.delete', $workspaceChecked->wm_id) }}"
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
