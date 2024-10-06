<!-- chia sẻ bảng & thêm thành viên -->
<div class="modal fade" id="addmemberModal" tabindex="-1" aria-labelledby="addmemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="addmemberModalLabel">
                    Chia sẻ bảng
                </h5>
                <button type="button" class="btn-close" id="btn-close-member" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row g-3">
                    <form action="{{ route('b.invite_board') }}" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $board->id }}">
                        <div class=" d-flex justify-content-between">
                            <div class="col-6">
                                <input type="text" class="form-control" id="submissionidInput"
                                    placeholder="Nhập email hoặc tên người dùng" name="email" />
                            </div>
                            <div class="col-4 ms-2">
                                <select name="authorize" id="" class="form-select">
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
                                <p style="margin-bottom: -5px;">Bất kỳ ai có thể theo gia với tư
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
                    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                        <li class="nav-item d-flex align-items-center justify-content-between">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                Thành viên trong không gian làm việc
                            </a>
                            <span class="badge bg-dark align-items-center justify-content-center d-flex"
                                style="border-radius: 100%; width: 20px ;height: 20px;">@if(!empty($data['board_m'])) {{ $data['board_m']->count() }}@endif</span>
                        </li>
                        <li class="nav-item d-flex align-items-center justify-content-between">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                Yêu cầu tham gia
                            </a>
                            <span class="badge bg-dark align-items-center justify-content-center d-flex"
                                style="border-radius: 100%; width: 20px ;height: 20px;">@if(!empty( $data['board_m_invite'])){{ $data['board_m_invite']->count() }}@endif</span>
                        </li>
                        <li class="nav-item d-flex align-items-center justify-content-between">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile2" role="tab">
                                Người xem
                            </a>
                            <span class="badge bg-dark align-items-center justify-content-center d-flex"
                                style="border-radius: 100%; width: 20px ;height: 20px;">@if(!empty($data['board_m_viewer'])  ){{ $data['board_m_viewer']->count() }}@endif</span>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <ul style="margin-left: -32px;">
                                <li class="d-flex">
                                    <div class="col-1">
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                            title="Nancy">
                                            @if(!empty($data['board_owner']))
                                            @if ($data['board_owner']->image)
                                                <img src="{{ Storage::url($data['board_owner']->image) ? Storage::url($data['board_owner']->image) : '' }}"
                                                    alt="" class="rounded-circle avatar-xs" />
                                            @else
                                                <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                    style="width: 25px;height: 25px">
                                                    {{ strtoupper(substr($data['board_owner']->name, 0, 1)) }}
                                                </div>
                                                <span class="fs-15 ms-2 text-white" id="swicthWs">
                                                    {{ \Illuminate\Support\Str::limit($data['board_owner']->name, 16) }}
                                                    <i class=" ri-arrow-drop-down-line fs-20"></i>
                                                </span>
                                            @endif
                                            @endif


                                        </a>
                                    </div>
                                    <div class="col-8 d-flex flex-column">
                                        <section class="fs-12">
                                            @if(!empty($data['board_owner']))
                                            <p style="margin-bottom: 0px;" class="text-danger fw-bloder">
                                                {{ $data['board_owner']->name }}
                                                @if ($data['board_owner']->user_id == $data['user_id'])
                                                    <span class="text-danger fw-bloder">(bạn)</span>
                                                @else
                                                    <span class="text-danger fw-bold">(chủ)</span>
                                                @endif

                                            </p>
                                            <span>@ {{ $data['board_owner']->name }}</span>
                                            <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                            <span>Quản trị viên không gian làm
                                                việc</span>
                                            @endif
                                        </section>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-outline-danger ">Quản
                                            trị viên</button>
                                    </div>
                                </li>
                                @if(!empty($data['board_m']))
                                @foreach ($data['board_m'] as $item)
                                    <li class="d-flex mt-1 mb-1">
                                        <div class="col-1">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-item="top"
                                                title="Nancy">
                                                @if ($item->image)
                                                    <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                        alt="" class="rounded-circle avatar-xs" />
                                                @else
                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                        style="width: 25px;height: 25px">
                                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                                    </div>
                                                    <span class="fs-15 ms-2 text-white" id="swicthWs">
                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                        <i class=" ri-arrow-drop-down-line fs-20"></i>
                                                    </span>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-8 d-flex flex-column">
                                            <section class="fs-12">
                                                <p style="margin-bottom: 0px;" class="text-black">
                                                    {{ $item->name }}
                                                    @if ($item->user_id == $data['user_id'])
                                                        <span class="text-success">(Bạn)</span>
                                                    @elseif($item->authorize === 'Sub_Owner')
                                                        <span class="text-primary">(Phó
                                                            nhóm)</span>
                                                    @else
                                                        <span class="text-black">(Thành
                                                            viên)</span>
                                                    @endif

                                                </p>
                                                <span>@ {{ $item->name }}</span>
                                                <span><i class="ri-checkbox-blank-circle-fill"></i></span>
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
                                @endif
                            </ul>
                        </div>
                        <div class="tab-pane" id="profile1" role="tabpanel">
                            <ul style="margin-left: -32px;">
                                @if(!empty($data['board_m']))
                                @foreach ($data['board_m_invite'] as $item)
                                    <li class="d-flex justify-content-between">
                                        <div class="col-1">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Nancy">
                                                @if ($item->image)
                                                    <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                        alt="" class="rounded-circle avatar-xs" />
                                                @else
                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                        style="width: 25px;height: 25px">
                                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                                    </div>
                                                    <span class="fs-15 ms-2 text-white" id="swicthWs">
                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                        <i class=" ri-arrow-drop-down-line fs-20"></i>
                                                    </span>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-7 d-flex flex-column">
                                            <section class="fs-12">
                                                <p style="margin-bottom: 0px;" class="text-black">
                                                    {{ $item->name }}
                                                    <span class="text-black">(Người
                                                        mới)</span>
                                                </p>
                                                <span>@ {{ $item->name }}</span>
                                                <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                                <span>Đã gửi lời mời vao không gian làm
                                                    việc</span>
                                            </section>
                                        </div>
                                        <div class="col-4 d-flex justify-content-end">
                                            {{-- <form onsubmit="disableButtonOnSubmit()"
                                                action="{{ route('accept_member') }}" method="post">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" value="{{ $item->user_id }}" name="user_id">
                                                <input type="hidden" value="{{ $item->workspace_id }}"
                                                    name="workspace_id">
                                                <input type="hidden" value="NULL" name="type_update">
                                                <button class="btn btn-primary me-2" type="submit">Duyệt</button>
                                            </form>
                                            <form action="{{ route('refuse_member', $item->wm_id) }}"
                                                onsubmit="disableButtonOnSubmit()" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" type="submit">Từ chối</button>
                                            </form> --}}
                                        </div>
                                    </li>
                                    <br>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="tab-pane" id="profile2" role="tabpanel">
                            <ul style="margin-left: -32px;">
                                @if(!empty($data['board_m_viewer']))
                                @foreach ($data['board_m_viewer'] as $item)
                                    <li class="d-flex justify-content-between">
                                        <div class="col-1">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Nancy">
                                                @if ($item->image)
                                                    <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                        alt="" class="rounded-circle avatar-xs" />
                                                @else
                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                        style="width: 25px;height: 25px">
                                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                                    </div>
                                                    <span class="fs-15 ms-2 text-white" id="swicthWs">
                                                        {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                        <i class=" ri-arrow-drop-down-line fs-20"></i>
                                                    </span>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-7 d-flex flex-column">
                                            <section class="fs-12">
                                                <p style="margin-bottom: 0px;" class="text-black">
                                                    {{ $item->name }}
                                                    <span class="text-black">(Người
                                                        xem)</span>
                                                </p>
                                                <span>@ {{ $item->name }}</span>
                                                <span><i class="ri-checkbox-blank-circle-fill"></i></span>
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
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
