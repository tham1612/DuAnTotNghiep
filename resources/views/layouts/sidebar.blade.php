@php
    $userId = \Illuminate\Support\Facades\Auth::id();

    $workspaces = \App\Models\Workspace::query()
        ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
        ->where('workspace_members.user_id', $userId)
        ->where('workspace_members.is_accept_invite', null)
        ->whereNot('workspace_members.is_active', 1)
        ->where('workspace_members.deleted_at', null)
        ->get();

    $workspaceChecked = \App\Models\Workspace::query()
        ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
        ->where('workspace_members.user_id', $userId)
        ->where('workspace_members.is_active', 1)
        ->first();
    $workspaceMemberChecked = \App\Models\WorkspaceMember::query()
        ->where('workspace_id', $workspaceChecked->workspace_id)
        ->where('user_id', $userId)
        ->where('authorize', 'Owner', 'Sub_Owner')
        ->pluck('user_id') // Sử dụng pluck thay vì fluck
        ->first(); // Lấy giá trị đầu tiên

    // dd($workspaceMemberChecked);

    if (\Illuminate\Support\Facades\Auth::user()->hasWorkspace()) {
        // $workspaceBoards = \App\Models\Workspace::query()
        //     ->with(['boards'])
        //     ->where('id', $workspaceChecked->workspace_id)
        // ->first();
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
    }
@endphp
<div class="app-menu navbar-menu" style="padding-top: 0">
    <div class="ms-4 mt-3 mb-2 cursor-pointer d-flex align-items-center justify-content-start " data-bs-toggle="dropdown"
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
                {{ \Illuminate\Support\Str::limit($workspaceChecked->name, 16) }}
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
                        <p class="fs-15 fw-bolder"> {{ \Illuminate\Support\Str::limit($workspaceChecked->name, 25) }}
                        </p>
                        <p class="fs-10" style="margin-top: -10px">
                            Công khai
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
                                onclick="window.location.href='{{ route('workspaces.index', $workspace->id) }}'">
                                {{ \Illuminate\Support\Str::limit($workspace->name, 25) }}
                            </p>
                            <p class="fs-10" style="margin-top: -10px">
                                <span>Công khai</span>
                                <i class=" ri-subtract-line"></i>
                                <span>10 thành viên</span>
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
                        <i class="ri-home-3-line"></i> <span data-key="">Home</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('inbox') }}">
                        <i class="ri-inbox-archive-line"></i> <span data-key="">Inbox</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('homes.dashboard', $workspaceChecked->id) }}">
                        <i class="ri-dashboard-line"></i> <span data-key="">Dashboards</span>
                    </a>
                </li>



                <li class="menu-title"><span data-key="t-menu">My Boards</span></li>
                @if (isset($workspaceBoards))
                    @foreach ($workspaceBoards->boards as $board)
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('b.edit', ['id' => $board->id]) }}">
                                @if ($board->image)
                                @else
                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center me-2"
                                        style="width: 30px;height: 30px">
                                        {{ strtoupper(substr($board->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span>{{ \Illuminate\Support\Str::limit($board->name, 30) }}</span>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <!-- Sidebar -->
        </div>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="sidebar-background"></div>
</div>
