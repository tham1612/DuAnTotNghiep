@php
    $userId = \Auth::id();

    $workspaces = \App\Models\Workspace::query()
        ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
        ->where('workspace_members.user_id', $userId)
        ->where('workspace_members.is_accept_invite', 0)
        ->whereNot('workspace_members.is_active', 1)
        ->where('workspace_members.deleted_at', null)
        ->select('workspaces.*', 'workspace_members.id as workspace_id')  // Giữ cột 'workspace_members.id'
        ->groupBy('workspaces.id', 'workspace_members.id')  // Thêm cả 'workspace_members.id' vào GROUP BY
        ->withCount([
            'workspaceMembers as member_count' => function ($query) {
                $query->whereNull('deleted_at');
            },
        ])
        ->get();

    $workspaceChecked = \App\Models\Workspace::query()
        ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
        ->where('workspace_members.user_id', $userId)
        ->where('workspace_members.is_active', 1)
        ->first();

    if ($workspaceChecked) {
        // Đếm số thành viên trong workspace
        $memberCount = \App\Models\WorkspaceMember::where('workspace_id', $workspaceChecked->workspace_id)->count();
    }

    $workspaceMemberChecked = \App\Models\WorkspaceMember::query()
        ->where('workspace_id', $workspaceChecked->workspace_id)
        ->where('user_id', $userId)
        ->select('user_id', 'authorize', 'is_accept_invite')
        ->first();

     if (\Illuminate\Support\Facades\Auth::user()->hasWorkspace()) {
        if ($workspaceChecked->authorize === 'Owner' || $workspaceChecked->authorize === 'Sub_Owner') {
            $workspaceBoards = \App\Models\Workspace::query()->with('boards')->where('id', $workspaceChecked->id)->first();
        } elseif ($workspaceChecked->authorize == 'Member') {
            $workspaceBoards = \App\Models\Workspace::query()
                ->with([
                    'boards' => function ($query) use ($userId) {
                        $query
                            ->where('access', 'public') // Bảng công khai
                            ->orWhere(function ($q) use ($userId) {
                                $q->where('access', 'private') // Bảng riêng tư
                                    ->whereHas('boardMembers', function ($q) use ($userId) {
                                        $q->where('user_id', $userId); // Kiểm tra người dùng có trong bảng không
                                    });
                            });
                    },
                ])
                ->where('id', $workspaceChecked->workspace_id)
                ->first();
        } else {
            $workspaceBoards = \App\Models\Workspace::query()
                ->with([
                    'boards' => function ($query) use ($userId) {
                        $query->whereHas('boardMembers', function ($q) use ($userId) {
                            $q->where('user_id', $userId); // Kiểm tra người dùng có trong bảng không
                        });
                    },
                ])
                ->where('id', $workspaceChecked->workspace_id)
                ->first();
        }
    }

@endphp
<div class="app-menu navbar-menu" style="padding-top: 0">
    <div class="ms-4 mt-3 mb-2 cursor-pointer d-flex align-items-center justify-content-start "
         data-bs-toggle="dropdown"
         aria-expanded="false" data-bs-offset="0,20">

        @if ($workspaceChecked)
            @if ($workspaceChecked->image)
                <img src="{{ asset('storage/' . $workspaceChecked->image) }}" alt="" class="rounded avatar-sm"
                     style="width: 25px;height: 25px">
            @else
                <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                     style="width: 25px;height: 25px">
                    {{ strtoupper(substr($workspaceChecked->name, 0, 1)) }}
                </div>
            @endif

            <span class="fs-15 ms-2 text-white" id="swicthWs">
                {{ \Str::limit($workspaceChecked->name, 16) }}
                <i class=" ri-arrow-drop-down-line fs-20"></i>
            </span>


            <ul class="dropdown-menu dropdown-menu-md p-3" data-simplebar style="max-height: 600px; width:300px">
                <li class="d-flex">
                    @if ($workspaceChecked->image)
                        <img src="{{ asset('storage/' . $workspaceChecked->image) }}" alt=""
                             class="rounded avatar-sm">
                    @else
                        <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                             style="width: 40px;height: 40px">
                            {{ strtoupper(substr($workspaceChecked->name, 0, 1)) }}
                        </div>
                    @endif
                    <section class=" ms-2">
                        <p class="fs-15 fw-bolder"> {{ \Str::limit($workspaceChecked->name, 25) }}
                        </p>
                        <p class="fs-10" style="margin-top: -10px">
                            <span>
                                @if ($workspaceChecked->access == 'private')
                                    Riêng tư
                                @elseif ($workspaceChecked->access == 'public')
                                    Công khai
                                @endif
                            </span>
                            <i class=" ri-subtract-line"></i>
                            <span>{{ $memberCount }} thành viên</span>
                        </p>
                    </section>
                </li>
                {{-- <li class="d-flex">
                    <a href="#">Thêm thành viên</a>
                </li> --}}
                <li class="d-flex">
                    <a href="{{ route('showFormEditWorkspace') }}"
                       onclick="window.location.href='{{ route('showFormEditWorkspace') }}'">Cài đặt không gian làm
                        việc</a>
                </li>
                <li class="border mb-3"></li>

                @foreach ($workspaces as $workspace)
                    <li class="d-flex">
                        @if ($workspace->image)
                            <img src="{{ asset('storage/' . $workspace->image) }}" alt=""
                                 class="rounded-circle avatar-sm">
                        @else
                            <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                 style="width: 40px;height: 40px">
                                {{ strtoupper(substr($workspace->name, 0, 1)) }}
                            </div>
                        @endif
                        <section class=" ms-2">
                            <p class="fs-15 fw-bolder"
                               onclick="window.location.href='{{ route('workspaces.index', $workspace->workspace_id) }}'">
                                {{ \Str::limit($workspace->name, 25) }}
                            </p>
                            <p class="fs-10" style="margin-top: -10px">
                                <span>
                                    @if ($workspace->access == 'private')
                                        Riêng tư
                                    @elseif ($workspace->access == 'public')
                                        Công khai
                                    @endif
                                </span>

                                <i class=" ri-subtract-line"></i>
                                <span>{{ $workspace->member_count }} thành viên</span>
                            </p>
                        </section>
                    </li>
                @endforeach
                <li class="d-flex fs-15 text-center align-items-center" style="margin-bottom: -20px"
                    data-bs-toggle="modal" data-bs-target="#workspaceModal">
                    <i class="ri-add-line"></i>
                    <p class="mt-3 ms-2"> Tạo không gian làm việc</p>
                </li>
            </ul>
        @endif
    </div>

    <div id="scrollbar" style="border-top: 1px solid #8292a2;">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>

            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item mt-3">

                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('home') }}">
                        <i class="ri-home-3-line"></i> <span data-key="">Trang Chủ</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('inbox') }}">
                        <i class=" ri-notification-3-line"></i> <span data-key="">Thông Báo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('homes.dashboard', $workspaceChecked->id) }}">
                        <i class="ri-dashboard-line"></i> <span data-key="">Bảng Điều Khiển</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('chat') }}">
                        <i class="ri-question-answer-line"></i> <span data-key="">Tin Nhắn</span>
                    </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">My Boards</span></li>
                @if (isset($workspaceBoards))
                    @foreach ($workspaceBoards->boards as $board)
                        <li class="nav-item">
                            <div class="nav-link menu-link d-flex text-center align-items-center"
                                 style="justify-content: space-between;">
                                <a class="" href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}">
                                    <div class="d-flex justify-content-flex-start align-items-center">
                                        @if ($board->image)
                                            <img
                                                    class="bg-info-subtle rounded d-flex justify-content-center align-items-center me-2"
                                                    src="{{ asset('storage/' . $board->image) }}"
                                                    style="width: 30px; height: 30px"
                                                    alt="image"/>
                                        @else
                                            <div
                                                    class="bg-info-subtle rounded d-flex justify-content-center align-items-center me-2"
                                                    style="width: 30px;height: 30px">
                                                {{ strtoupper(substr($board->name, 0, 1)) }}
                                            </div>

                                        @endif
                                        <span id="name-board-{{$board->id}}"
                                                class="text-white fs-16">{{ \Str::limit($board->name, 10) }}</span>
                                    </div>
                                </a>
                                @php
                                    // Load tất cả các user duy nhất của board
                                   $boardMembers = $board->members->unique('id');
                                   $memberIsStar = $boardMembers->where('id', auth()->id())->first()->pivot->is_star ?? null;

                                    // Lưu vào session
                                    session([
                                        'memberIsStar_' . $board->id => $memberIsStar,
                                        'boardMembers_' . $board->id => $boardMembers
                                    ]);
                                @endphp
                                <div class="d-flex justify-content-flex-end align-items-center ms-1">
                                    <button type="button" class="btn avatar-xs mt-n1 p-0 favourite-btn
                                        @if( $memberIsStar == 1) active @endif"
                                            onclick="updateIsStar2({{ $board->id }},{{ auth()->id() }})"
                                            id="2_is_star_{{ $board->id }}">
                                        <span class="avatar-title bg-transparent fs-15">
                                            <i class="ri-star-fill fs-20 mx-2"></i>
                                        </span>
                                    </button>
                                    <a class="text-reset dropdown-btn" data-bs-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <span class="fw-medium text-muted fs-12">
                                            <i class="ri-more-fill fs-20" title=""></i>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-start">
                                        <a class="dropdown-item">
                                            <input type="text" name="name"
                                                   class="form-control border-0 text-center fs-16 fw-medium bg-transparent"
                                                   id="name_board_{{ $board->id }}" value="{{ $board->name }}"
                                                   onchange="updateBoard({{ $board->id }})"/>
                                        </a>
                                        <div class="dropdown-item ms-2 me-2">
                                            <div class="mb-2">
                                                <label for="">Ảnh của bảng</label>

                                                <input type="file" class="form-control" name="image"

                                                       id="image_board_{{ $board->id }}" value="{{ $board->image }}"
                                                       onchange="updateBoard({{ $board->id }})"/>
                                            </div>
                                        </div>

                                        <!-- Đóng bảng -->
                                        <div
                                                class="dropdown-item d-flex mt-3 mb-3 justify-content-center cursor-pointer close-board dropdown">
                                            <div
                                                    class="d-flex align-items-center justify-content-center rounded p-3 text-white w-100"
                                                    style="height: 30px; background-color: #c7c7c7;"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-archive-line"></i>
                                                <p class="ms-2 me-2 mt-3 fs-15">Đóng bảng</p>
                                            </div>
                                            <!-- Dropdown Menu con -->
                                            <ul class="dropdown-menu dropdown-menu-end w-100"
                                                style="left: 100%; top: 0;">
                                                <h5 class="text-center">Đóng bảng?</h5>
                                                <li>
                                                    <p class="dropdown-item-text">
                                                        Bạn có thể tìm và mở lại các bảng đã đóng ở cuối
                                                        <a href="{{ route('homes.dashboard',  $workspaceChecked->id) }}">trang
                                                            các bảng của bạn</a>.
                                                    </p>

                                                </li>
                                                <li class="d-flex justify-content-center">
                                                    <button class="btn btn-danger" type="button">Đóng</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>

    </div>
    @if (!empty($workspaceMemberChecked))
        @if ($workspaceMemberChecked->authorize == 'Viewer' && $workspaceMemberChecked->is_accept_invite == 0)
            <div class="guest-notice" style="position: absolute; bottom: 10px; width: 100%; padding: 15px;">
                <div class="alert alert-info d-flex align-items-center" role="alert"
                     style="background-color: #f0f4ff; border-radius: 8px;">
                    <i class="ri-information-line me-2" style="font-size: 24px;"></i>
                    <div>
                        <strong>Bạn đang là khách</strong> trong không gian làm việc này.
                        Để xem các bảng và thành viên khác, quản trị viên phải thêm bạn làm thành viên.
                    </div>
                </div>

                <a href="{{ route('b.requestToJoinWorkspace') }}" class="btn btn-primary mt-2 "
                   style="width: 100%; text-align: center;">
                    Yêu cầu tham gia
                </a>
            </div>
        @elseif ($workspaceMemberChecked->authorize == 'Viewer' && $workspaceMemberChecked->is_accept_invite == 1)
            <div class="guest-notice" style="position: absolute; bottom: 10px; width: 100%; padding: 15px;">
                <div class="alert alert-info d-flex align-items-center" role="alert"
                     style="background-color: #f0f4ff; border-radius: 8px;">
                    <i class="ri-information-line me-2" style="font-size: 24px;"></i>
                    <div>
                        <strong>Bạn đã gửi yêu cầu</strong><br>tham gia không gian làm việc: <strong>
                            {{ \Str::limit($workspaceChecked->name, 25) }} </strong><br> chờ quản
                        trị viên duyệt
                    </div>
                </div>
            </div>
        @endif
    @endif
    <div class="sidebar-background"></div>
</div>


<style>
    #scrollbar {
        height: calc(100vh - 150px);
        /* Điều chỉnh chiều cao để không chạm vào phần thông báo */
        overflow-y: auto;
    }

    .guest-notice {
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: #8294c6;
        padding: 15px;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
    }

    .guest-notice .btn {
        width: 100%;
        margin-top: 10px;
    }

    .guest-notice .btn {
        background: linear-gradient(135deg, #4A90E2, #007AFF);
        color: white;
        padding: 10px 20px;
        font-size: 12px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        width: 100%;
        text-align: center;
        transition: all 0.3s ease;
        /* Hiệu ứng chuyển đổi mượt */
    }

    .guest-notice .btn:hover {
        background: linear-gradient(135deg, #007AFF, #4A90E2);
        /* Đảo ngược gradient khi hover */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        /* Thêm hiệu ứng đổ bóng khi hover */
        transform: translateY(-2px);
        /* Hiệu ứng nhấn nút */
    }

    .guest-notice .btn:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.4);
        /* Hiệu ứng focus */
    }
</style>


