@extends('layouts.masterMain')
@section('main')


    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card">
                <div class="card-body border-bottom border-bottom-dashed p-4">
                    <div class="row">

                        <div class="col-lg-6">
                            <form id="editWorkspaceForm" action="{{ route('editWorkspace') }}" method="POST"
                                enctype="multipart/form-data">
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
                                            <h5 class="m-0">{{ $workspaceChecked->wsp_name }}</h5>
                                            <span class="text-muted small"><i
                                                    class="bi bi-globe"></i>{{ $access }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div><label for="name">Tên không gian làm việc</label></div>
                                    <input type="text" name="name"
                                        class="form-control bg-light @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name', $workspaceChecked->name) }}" />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description">Mô tả</label>
                                </div>
                                <div class="mb-2">
                                    <textarea name="description" class="form-control bg-light" id="description" rows="3" placeholder="Mô tả">{{ $workspaceChecked->description }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary mt-2">Lưu</button>
                            </form>

                            <div id="formResponse" class="mt-3"></div>

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
                                                    <form onsubmit="disableButtonOnSubmit()"
                                                        action="{{ route('invite_workspace', $workspaceChecked->id) }}"
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
                                                                    @if ($workspaceChecked->authorize !== 'Member' && $workspaceChecked->authorize !== 'Viewer')
                                                                        <option value="Sub_Owner">Phó nhóm</option>
                                                                    @endif
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
                                                            <a href="#">
                                                                <i id="copy-icon" class="ri-attachment-2 fs-22"
                                                                    onclick="copyLink()"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-6 d-flex flex-column">
                                                            <section class="fs-12">
                                                                <p style="margin-bottom: -5px;">Bất kỳ ai có thể theo gia
                                                                    với tư cách thành viên</p>
                                                                <span><a href="#" onclick="copyLink()">Sao chép liên
                                                                        kết</a></span>
                                                            </section>
                                                        </div>
                                                        <div class="col-5">
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
                                                                style="border-radius: 100%; width: 20px ;height: 20px;">{{ $wspMemberCount + 2 }}</span>
                                                        </li>
                                                        @if ($workspaceChecked->authorize == 'Owner' || $workspaceChecked->authorize == 'Sub_Owner')
                                                            <li
                                                                class="nav-item d-flex align-items-center justify-content-between">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#profile1"
                                                                    role="tab">
                                                                    Yêu cầu tham gia
                                                                </a>
                                                                <span
                                                                    class="badge bg-dark align-items-center justify-content-center d-flex"
                                                                    style="border-radius: 100%; width: 20px ;height: 20px;">{{ $wspInviteCount }}</span>
                                                            </li>
                                                        @endif
                                                        <li
                                                            class="nav-item d-flex align-items-center justify-content-between">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#profile2"
                                                                role="tab">
                                                                Người xem
                                                            </a>
                                                            <span
                                                                class="badge bg-dark align-items-center justify-content-center d-flex"
                                                                style="border-radius: 100%; width: 20px ;height: 20px;">{{ $wspViewerCount }}</span>
                                                        </li>

                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content text-muted">
                                                        <div class="tab-pane active" id="home1" role="tabpanel">
                                                            {{-- <div class="scrollable-content"
                                                                style="max-height: 400px; overflow-y: auto;"> --}}
                                                            <ul style="margin-left: -32px;">
                                                                <li class="d-flex">
                                                                    <div class="col-1">
                                                                        <a href="javascript: void(0);"
                                                                            class="avatar-group-item"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover"
                                                                            data-bs-placement="top" title="Nancy">
                                                                            @if (!empty($wspOwner))
                                                                                @if ($wspOwner->image)
                                                                                    <img src="{{ Storage::url($wspOwner->image) ? Storage::url($wspOwner->image) : '' }}"
                                                                                        alt=""
                                                                                        class="rounded-circle avatar-xs" />
                                                                                @else
                                                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                                                        style="width: 25px;height: 25px">
                                                                                        {{ strtoupper(substr($wspOwner->name, 0, 1)) }}
                                                                                    </div>
                                                                                    {{-- <span class="fs-15 ms-2 text-white"
                                                                                        id="swicthWs">
                                                                                        {{ \Illuminate\Support\Str::limit($wspOwner->name, 16) }}
                                                                                        <i
                                                                                            class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                    </span> --}}
                                                                                @endif
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-6 d-flex flex-column">
                                                                        @if (!empty($wspOwner))
                                                                            <section class="fs-12">
                                                                                <p style="margin-bottom: 0px;"
                                                                                    class="text-danger fw-bloder">
                                                                                    {{ $wspOwner->name }}
                                                                                    @if ($wspOwner->user_id == $userId)
                                                                                        <span
                                                                                            class="text-danger fw-bloder">(bạn)</span>
                                                                                    @else
                                                                                        <span
                                                                                            class="text-danger fw-bold">(chủ)</span>
                                                                                    @endif
                                                                                </p>
                                                                                <span>@ {{ $wspOwner->name }}</span>
                                                                                <span><i
                                                                                        class="ri-checkbox-blank-circle-fill"></i></span>
                                                                                <span>Quản trị viên không gian làm
                                                                                    việc</span>
                                                                            </section>
                                                                        @endif
                                                                    </div>
                                                                    <div
                                                                        class="col-5 d-flex align-items-center justify-content-end">
                                                                        <button class="btn btn-outline-danger">Quản trị
                                                                            viên</button>
                                                                        <!-- Nút ba chấm -->

                                                                        <div class="dropdown ms-2">

                                                                            <button class="btn btn-link dropdown-toggle"
                                                                                type="button" id="dropdownMenuButton"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                <i class="ri-more-2-fill"></i>
                                                                            </button>
                                                                            {{-- @if (!empty($wspOwner))
                                                                                @if ($wspOwner->user_id == $userId)
                                                                                    <!-- Popup xuất hiện khi nhấn nút ba chấm -->
                                                                                    <ul class="dropdown-menu"
                                                                                        aria-labelledby="dropdownMenuButton">
                                                                                        <li><a class="dropdown-item text-danger"
                                                                                                href="{{ route('activateMember', $wspOwner->wm_id) }}">Rời
                                                                                                khỏi</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                @endif
                                                                            @endif --}}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                {{-- Lặp lại các sub owner --}}
                                                                @foreach ($wspSubOwner as $item)
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
                                                                                    {{-- <span class="fs-15 ms-2 text-white"
                                                                                        id="swicthWs">
                                                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                                                        <i
                                                                                            class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                    </span> --}}
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-6 d-flex flex-column">
                                                                            <section class="fs-12">
                                                                                <p style="margin-bottom: 0px;"
                                                                                    class="text-black">
                                                                                    {{ $item->name }}
                                                                                    @if ($item->user_id == $userId)
                                                                                        <span
                                                                                            class="text-success">(Bạn)</span>
                                                                                    @else
                                                                                        <span class="text-success">(Phó
                                                                                            nhóm)</span>
                                                                                    @endif
                                                                                </p>
                                                                                <span>@ {{ $item->name }}</span>
                                                                                <span><i
                                                                                        class="ri-checkbox-blank-circle-fill"></i></span>
                                                                                <span>Thành viên của không gian làm
                                                                                    việc</span>
                                                                            </section>
                                                                        </div>
                                                                        <div
                                                                            class="col-5 d-flex align-items-center justify-content-end">
                                                                            <button class="btn btn-outline-success">Phó
                                                                                nhóm</button>
                                                                            <!-- Nút ba chấm -->
                                                                            <div class="dropdown ms-2">
                                                                                <button
                                                                                    class="btn btn-link dropdown-toggle"
                                                                                    type="button" id="dropdownMenuButton"
                                                                                    data-bs-toggle="dropdown"
                                                                                    aria-expanded="false">
                                                                                    <i class="ri-more-2-fill"></i>
                                                                                </button>
                                                                                @if ($item->user_id === $userId)
                                                                                    <ul class="dropdown-menu"
                                                                                        aria-labelledby="dropdownMenuButton">
                                                                                        <li><a class="dropdown-item text-danger"
                                                                                                href="{{ route('activateMember', $item->wm_id) }}">Rời
                                                                                                khỏi</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                @elseif($workspaceChecked->authorize == 'Owner')
                                                                                    <ul class="dropdown-menu"
                                                                                        aria-labelledby="dropdownMenuButton">
                                                                                        <li><a class="dropdown-item text-danger"
                                                                                                href="{{ route('activateMember', $item->wm_id) }}">Kích
                                                                                                phó
                                                                                                nhóm</a>
                                                                                        </li>
                                                                                        <li><a class="dropdown-item text-primary"
                                                                                                href="{{ route('managementfranchise', ['owner_id' => $wspOwner, 'user_id' => $item->id]) }}">Nhượng
                                                                                                quyền</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                @endif
                                                                                <!-- Popup xuất hiện khi nhấn nút ba chấm -->
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                                <!-- Lặp lại với các thành viên -->
                                                                @foreach ($wspMember as $item)
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
                                                                                    {{-- <span class="fs-15 ms-2 text-white"
                                                                                        id="swicthWs">
                                                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                                                        <i
                                                                                            class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                    </span> --}}
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-6 d-flex flex-column">
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
                                                                        <div
                                                                            class="col-5 d-flex align-items-center justify-content-end">
                                                                            <button class="btn btn-outline-primary">Thành
                                                                                viên</button>
                                                                            <!-- Nút ba chấm -->
                                                                            <div class="dropdown ms-2">
                                                                                <button
                                                                                    class="btn btn-link dropdown-toggle"
                                                                                    type="button" id="dropdownMenuButton"
                                                                                    data-bs-toggle="dropdown"
                                                                                    aria-expanded="false">
                                                                                    <i class="ri-more-2-fill"></i>
                                                                                </button>
                                                                                <!-- Popup xuất hiện khi nhấn nút ba chấm -->
                                                                                @if ($item->user_id === $userId)
                                                                                    <ul class="dropdown-menu"
                                                                                        aria-labelledby="dropdownMenuButton">
                                                                                        <li><a class="dropdown-item text-danger"
                                                                                                href="{{ route('activateMember', $item->wm_id) }}">Rời
                                                                                                khỏi</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                @elseif($workspaceChecked->authorize == 'Owner')
                                                                                    <ul class="dropdown-menu"
                                                                                        aria-labelledby="dropdownMenuButton">
                                                                                        <li><a class="dropdown-item text-danger"
                                                                                                href="{{ route('activateMember', $item->wm_id) }}">Kích
                                                                                                thành
                                                                                                viên</a></li>
                                                                                        <li><a class="dropdown-item text-primary"
                                                                                                href="{{ route('upgradeMemberShip', $item->wm_id) }}">Thăng
                                                                                                cấp
                                                                                                thành
                                                                                                viên</a></li>
                                                                                    </ul>
                                                                                @elseif ($workspaceChecked->authorize == 'Sub_Owner')
                                                                                    <ul class="dropdown-menu"
                                                                                        aria-labelledby="dropdownMenuButton">
                                                                                        <li><a class="dropdown-item text-danger"
                                                                                                href="{{ route('activateMember', $item->wm_id) }}">Kích
                                                                                                thành
                                                                                                viên</a></li>
                                                                                    </ul>
                                                                                @endif

                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            {{-- </div> --}}
                                                        </div>

                                                        @if ($workspaceChecked->authorize == 'Owner' || $workspaceChecked->authorize == 'Sub_Owner')
                                                            <div class="tab-pane" id="profile1" role="tabpanel">
                                                                {{-- <div class="scrollable-content"
                                                                style="max-height: 400px; overflow-y: auto;"> --}}
                                                                <ul
                                                                    style="margin-left: -32px; max-height: 400px; overflow-y: auto;">
                                                                    @foreach ($wspInvite as $item)
                                                                        <li class="d-flex justify-content-between">
                                                                            <div class="col-1">
                                                                                <a href="javascript: void(0);"
                                                                                    class="avatar-group-item"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-trigger="hover"
                                                                                    data-bs-placement="top"
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
                                                                                    <span>Đã gửi lời mời vào không gian làm
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
                                                            {{-- </div> --}}
                                                            </div>
                                                        @endif

                                                        <div class="tab-pane" id="profile2" role="tabpanel">
                                                            {{-- <div class="scrollable-content"
                                                                style="max-height: 400px; overflow-y: auto;"> --}}
                                                            <ul style="margin-left: -32px;">
                                                                @foreach ($wspViewer as $item)
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
                                                                                    {{-- <span class="fs-15 ms-2 text-white"
                                                                                        id="swicthWs">
                                                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                                                        <i
                                                                                            class=" ri-arrow-drop-down-line fs-20"></i>
                                                                                    </span> --}}
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-7 d-flex flex-column">
                                                                            <section class="fs-12">
                                                                                <p style="margin-bottom: 0px;"
                                                                                    class="text-black">
                                                                                    {{ $item->name }}
                                                                                    <span class="text-black">(Người
                                                                                        xem)</span>
                                                                                </p>
                                                                                <span>@ {{ $item->name }}</span>
                                                                                <span><i
                                                                                        class="ri-checkbox-blank-circle-fill"></i></span>
                                                                                <span>Tham quan không gian làm việc</span>
                                                                            </section>
                                                                        </div>
                                                                        <div class="col-4 d-flex justify-content-end">
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        {{-- </div> --}}
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
                                    <form id="updateAccessForm" action="{{ route('update_ws_access') }}" method="post">
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
                                                    Đây là Không gian làm việc riêng tư. Chỉ những người trong Không gian
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
                                                    Đây là Không gian làm việc công khai. Bất kỳ ai có đường dẫn tới Không
                                                    gian làm việc đều có thể nhìn thấy hoặc tìm thấy Không gian làm việc.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        </div>
                                    </form>

                                    <div id="formResponse" class="mt-2"></div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <a style="margin-left: 15px; padding-bottom:20px"
                    href="{{ route('workspaces.delete', $workspaceChecked->wm_id) }}"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa bỏ không gian làm việc?')" class="text-danger">Xóa
                    Không gian
                    làm việc này?</a> --}}
                <!-- Modal HTML -->
                <a style="margin-left: 15px; padding-bottom:20px" href="#" class="text-danger"
                    data-bs-toggle="modal" data-bs-target="#deleteWorkspaceModal"
                    onclick="setDeleteAction('{{ route('workspaces.delete', $workspaceChecked->wm_id) }}')">
                    Xóa Không gian làm việc này?
                </a>
                <div class="modal fade" id="deleteWorkspaceModal" tabindex="-1"
                    aria-labelledby="deleteWorkspaceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteWorkspaceModalLabel">Xác nhận xóa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn muốn xóa không gian làm việc này? Hành động này không thể hoàn tác.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" id="confirmDeleteButton" class="btn btn-danger">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>

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
    <script>
        function copyLink() {
            const link = '{{ $workspaceChecked->link_invite }}'; // Lấy link từ biến Laravel
            navigator.clipboard.writeText(link).then(function() {
                // Thay đổi icon sau khi sao chép thành công
                const copyIcon = document.getElementById('copy-icon');
                copyIcon.classList.remove('ri-attachment-2'); // Xóa icon hiện tại
                copyIcon.classList.add('ri-check-line'); // Thêm icon dấu kiểm

                // Thay đổi văn bản "Sao chép liên kết"
                const copyText = document.querySelector('span a');
                copyText.textContent = 'Đã sao chép';

                // Đặt thời gian chờ 20 giây trước khi chuyển icon và văn bản về trạng thái ban đầu
                setTimeout(function() {
                    // Khôi phục lại icon và văn bản sau 20 giây
                    copyIcon.classList.remove('ri-check-line');
                    copyIcon.classList.add('ri-attachment-2');
                    copyIcon.textContent = ''; // Xóa nội dung text nếu có

                    copyText.textContent = 'Sao chép liên kết';
                }, 5000); // 20000 milliseconds = 20 giây

            }).catch(function(error) {
                console.error('Error copying text: ', error);
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            });
        }
    </script>
    {{-- update thông tin workspace --}}
    <script>
        $(document).ready(function() {
            $('#editWorkspaceForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi submit mặc định

                $('#loading').show(); // Hiển thị loading
                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'), // URL từ action của form
                    method: $(this).attr('method'), // Phương thức từ form
                    data: formData,
                    processData: false, // Không xử lý dữ liệu
                    contentType: false, // Không đặt kiểu content mặc định
                    success: function(response) {
                        notificationWeb(response.action, response.message);
                        console.log('cật nhật thành công');

                    },
                    error: function(xhr) {
                        $('#loading').hide(); // Ẩn loading

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += '<div class="alert alert-danger">' +
                                    value[0] + '</div>';
                            });
                            $('#formResponse').html(errorMessages);
                        } else {
                            $('#formResponse').html(
                                '<div class="alert alert-danger">Có lỗi xảy ra!</div>');
                        }
                    }
                });
            });
        });
    </script>

    {{-- ajax update access --}}
    <script>
        $(document).ready(function() {
            $('#updateAccessForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi submit mặc định

                $('#loading').show(); // Hiển thị loading
                $('#formResponse').html(''); // Xóa các thông báo cũ

                let formData = $(this).serialize(); // Lấy dữ liệu từ form

                $.ajax({
                    url: $(this).attr('action'), // Lấy URL từ form
                    method: $(this).attr('method'), // Lấy method từ form
                    data: formData,
                    success: function(response) {
                        // $('#formResponse').html('<div class="alert alert-success">' + response.message + '</div>');
                        notificationWeb(response.action, response.message);
                        document.getElementById('access').innerText = "Riêng tư";
                        setTimeout(function() {
                            $('#formResponse').html('');
                        }, 3000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += '<div class="alert alert-danger">' +
                                    value[0] + '</div>';
                            });
                            notificationWeb(response.action, response.message);
                        } else {
                            // $('#formResponse').html('<div class="alert alert-danger">Có lỗi xảy ra: ' + xhr.responseJSON.message + '</div>');
                            notificationWeb(response.action, response.message);
                        }
                    }
                });
            });
        });
    </script>

    {{-- delete workspace --}}
    <script>
        let deleteUrl = ''; // Biến toàn cục để lưu URL xóa

        function setDeleteAction(actionUrl) {
            deleteUrl = actionUrl; // Cập nhật URL xóa khi mở modal
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (!deleteUrl) return;

            fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Gửi CSRF token
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notificationWeb(response.action, response.message); // Thông báo thành công
                        // Cập nhật giao diện hoặc redirect
                    } else {
                        notificationWeb(response.action, response.message); // Thông báo lỗi
                    }
                    // Đóng modal sau khi xử lý
                    $('#deleteWorkspaceModal').modal('hide');
                })
                .catch(error => {
                    console.error('Error:', error);
                    notificationWeb('error', 'Có lỗi xảy ra, vui lòng thử lại.');
                });
        });
    </script>
@endsection
