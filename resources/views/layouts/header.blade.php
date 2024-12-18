<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!--        ẩn hiện side-bar-->
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <!-- Form tìm kiếm -->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="hidden" id="workspace-id" value="{{ $currentWorkspace->workspace_id }}">
                        <input type="text" class="form-control" placeholder="Tìm kiếm" autocomplete="off"
                               id="search-options" value=""/>
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                              id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown" style="width: 50%">
                        <div data-simplebar style="max-height: 400px;">
                            <!-- Kết quả tìm kiếm sẽ được hiển thị ở đây -->
                        </div>
                    </div>
                </form>
                {{--  Bảng hoạt động gần đây              --}}
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary pt-3" style="width: 150px"
                            id="recently-home" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-haspopup="true"
                            aria-expanded="false">
                        <p class="dropdown-item">
                            Gần đây
                            <i class=" ri-arrow-drop-down-line fs-20"></i>
                        </p>

                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                         aria-labelledby="recently-home">
                        <div data-simplebar style="max-height: 270px">
                            <div class="p-2">
                                @foreach ($recentBoards as $board)
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($board->last_activity);
                                                       $now = \Carbon\Carbon::now();
                                                       $diffInHours = $createdAt->diffInHours($now);
                                                       \Carbon\Carbon::setLocale('vi'); @endphp
                                    <div
                                        class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer"
                                        onclick="window.location.href='http://127.0.0.1:8000/b/{{ $board->board_id }}/edit?viewType=board'">
                                        <div class="d-flex align-items-center">
                                            {{-- <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                                class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" /> --}}
                                            @if ($board->board_image)
                                                <img
                                                    class="bg-info-subtle rounded d-flex justify-content-center align-items-center me-2"
                                                    src="{{ asset('storage/' . $board->board_image) }}"
                                                    style="width: 30px; height: 30px" alt="image"/>
                                            @else
                                                <div
                                                    class="bg-info-subtle rounded d-flex justify-content-center align-items-center me-2"
                                                    style="width: 30px;height: 30px">
                                                    {{ strtoupper(substr($board->board_name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    {{ \Illuminate\Support\Str::upper($board->board_name) }}
                                                </h6>
                                                <p class="mb-0 fs-12 w-100 text-muted">
                                                    {{ $board->workspace_name }}
                                                    <i class=" ri-subtract-line"></i>
                                                    @if ($diffInHours < 24)
                                                       {{ $createdAt->diffForHumans() }}

                                                    @else
                                                        {{ $createdAt->format('H:i j \t\h\g m, Y') }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{--  bảng được đánh dấu sao              --}}
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary pt-3" style="width: 150px"
                            id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-haspopup="true" aria-expanded="false">
                        <p>Đã đánh dấu sao <i class=" ri-arrow-drop-down-line fs-20"></i></p>
                    </button>
                    @if ($boardIsStars->isNotEmpty())
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                             aria-labelledby="page-header-cart-dropdown">
                            <div data-simplebar style="max-height: 270px">
                                <div class="p-2">


                                    @foreach ($boardIsStars as $boardIsStar)
                                        <div
                                            class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer"
                                            onclick="window.location.href='http://127.0.0.1:8000/b/{{ $boardIsStar['board_id'] }}/edit?viewType=board'">
                                            <div class="d-flex align-items-center board-star-container">
                                                @if ($boardIsStar['image'])
                                                    <img src="{{ asset('storage/' . $boardIsStar['board_image']) }}"
                                                         class="me-3 rounded-circle avatar-sm p-2 bg-light"
                                                         alt="user-pic"/>
                                                @else
                                                    <div
                                                        class="bg-info-subtle rounded d-flex justify-content-center align-items-center me-2"
                                                        style="width: 30px;height: 30px">

                                                        {{ strtoupper(substr($boardIsStar['board_name'], 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div class="flex-grow-1">
                                                    <h6 class="mt-2 fs-15 ">
                                                        {{ \Illuminate\Support\Str::upper($boardIsStar['board_name']) }}
                                                    </h6>
                                                    <p class="mb-0 fs-12 w-100 text-muted">
                                                        {{ $boardIsStar['workspace_name'] }}
                                                    </p>
                                                </div>
                                                <div class="ps-2">
                                                    <button type="button" data-value="{{ $boardIsStar['board_id'] }}"
                                                            id="board_star_{{ $boardIsStar['board_id'] }}"
                                                            class="btn btn-icon btn-sm btn-ghost-warning "
                                                            onclick="updateIsStar3({{ $boardIsStar['board_id'] }}, {{ Auth::id() }})">
                                                        <i class="ri-star-fill fs-16"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                {{--  Mẫu              --}}
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary pt-3" style="width: 100px"
                            id="template-home" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-haspopup="true"
                            aria-expanded="false">
                        <p class="">Mẫu <i class=" ri-arrow-drop-down-line fs-20"></i></p>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                         aria-labelledby="template-home">
                        <div data-simplebar style="max-height: 270px">
                            <div class="p-2">
                                @foreach ($template_boards as $tplBoard)
                                    <div
                                        class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer"
                                        data-bs-toggle="modal"
                                        data-bs-target="#create-board-template-home-modal{{ $tplBoard->id }}">
                                        <div class="d-flex align-items-center">
                                            @if ($tplBoard->image)
                                                <img class="me-3 rounded-circle avatar-sm p-2 bg-light"
                                                     src="{{ asset('storage/' . $tplBoard->image) }}"
                                                     alt="Avatar"/>
                                            @else
                                                <div
                                                    class="me-3 rounded-circle avatar-sm p-2 bg-light rounded d-flex justify-content-center align-items-center"
                                                    style="width: 50px;height: 50px">
                                                    {{ strtoupper(substr($tplBoard->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    {{ $tplBoard->name }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{--  Tạo bảng              --}}
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn bg-info-subtle btn-icon btn-topbar btn-ghost-secondary pt-3"
                            style="width: 100px" id="create-home" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-haspopup="true" aria-expanded="false">
                        <p class="" style="color: var(--vz-heading-color)">Tạo mới</p>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart cursor-pointer"
                         aria-labelledby="create-home">
                        <div data-simplebar>
                            <div class="p-2">
                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"
                                     data-bs-toggle="modal" data-bs-target="#create-board-home-modal">
                                    <div class="d-flex flex-column ">
                                        <section>
                                            <i class="ri-dashboard-line fs-15"></i>
                                            <strong class="fs-15">Tạo bảng</strong>

                                        </section>
                                        <section>
                                            Một bảng được tọa thành từ các thẻ được sắp xếp trong danh sách. Sử dụng
                                            bảng để quản lý
                                        </section>
                                    </div>
                                </div>
                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"
                                     data-bs-toggle="modal" data-bs-target="#create-board-template-home-modal1">
                                    <div class="d-flex flex-column ">
                                        <section>
                                            <i class="ri-dashboard-fill fs-15"></i>
                                            <strong class="fs-15">Bắt đầu với mẫu</strong>
                                        </section>
                                        <section>
                                            Bắt đầu nhanh với những mẫu có sẵn
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#chatAi" aria-controls="offcanvasRight">
                        {{--                        <i class=" ri-question-answer-line fs-22"></i> --}}
                        <i class="  ri-character-recognition-line fs-22"></i>
                    </button>
                </div>
                {{--                <div class="dropdown d-md-none topbar-head-dropdown header-item"> --}}
                {{--                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" --}}
                {{--                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" --}}
                {{--                            aria-expanded="false"> --}}
                {{--                        <i class="bx bx-search fs-22"></i> --}}
                {{--                    </button> --}}
                {{--                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" --}}
                {{--                         aria-labelledby="page-header-search-dropdown"> --}}
                {{--                        <form class="p-3"> --}}
                {{--                            <div class="form-group m-0"> --}}
                {{--                                <div class="input-group"> --}}
                {{--                                    <input type="text" class="form-control" placeholder="Search ..." --}}
                {{--                                           aria-label="Recipient's username"/> --}}
                {{--                                    <button class="btn btn-primary" type="submit"> --}}
                {{--                                        <i class="mdi mdi-magnify"></i> --}}
                {{--                                    </button> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </form> --}}
                {{--                    </div> --}}
                {{--                </div> --}}

                {{-- giao diện sáng tối --}}
                {{--                <div class="ms-1 header-item d-none d-sm-flex"> --}}
                {{--                    <button type="button" --}}
                {{--                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode"> --}}
                {{--                        <i class="bx bx-moon fs-22"></i> --}}
                {{--                    </button> --}}
                {{--                </div> --}}
                <div class="dropdown ms-sm-3 header-item topbar-user" style="height: 60px">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if (auth()->user()->image)
                                <img class="rounded header-profile-user object-fit-cover"
                                     src="{{ asset('storage/' . auth()->user()->image) }}" alt="Avatar"/>
                            @else
                                <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                     style="width: 40px;height: 40px">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif

                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Xin chào {{ auth()->user()->name }}!</h6>
                        <a class="dropdown-item" href="{{ route('user', auth()->user()->id) }}">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Thông tin</span>
                        </a>

                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#workspaceModal"><i
                                class="ri-group-line text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Tạo không gian làm việc</span></a>

                        <a class="dropdown-item cursor-pointer" data-bs-toggle="modal"
                           data-bs-target="#archiverBoard-member"><i
                                class="ri-archive-line text-muted fs-16 align-middle me-1"></i>

                            <span class="align-middle">Lưu trữ</span></a>

                        <form id="logoutForm" action="{{ route('logout') }}" method="post" class="dropdown-item">
                            @csrf
                            <i class="mdi mdi-logout text-muted fs-16 align-middle"></i>
                            <button type="submit" class="bg-transparent border-0">
                                Đăng xuất
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
{{-- <input type="hidden" id="userId" value="{{ auth()->id() }}">
<script>
    var userId = document.getElementById('userId').value;
</script> --}}
@vite('resources/js/notification.js')

{{-- thông báo web --}}
<div class="bg-light" aria-live="polite" aria-atomic="true"
     style="position: fixed; top: 70px;right: 10px; z-index: 100">
    @if (!empty(session('msg')) && !empty(session('action')))
        {{--        @dd(session('msg'),session('action')) --}}
        {{--        @foreach (session('success') as $notification) --}}
        <div class="toast fade show bg-{{ session('action') }}-subtle" role="alert" aria-live="assertive"
             aria-atomic="true" data-bs-toggle="toast" id="notification-messenger">
            <div class="toast-header">
                <img src="{{ asset('theme/assets/images/logo-sm.png') }}" class="rounded me-2" alt="..."
                     height="20">
                <span class="fw-semibold me-auto">Task Flow.</span>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body fw-bolder text-{{ session('action') }}">
                {{ session('msg') }}
            </div>
        </div>
        {{--        @endforeach --}}
    @endif
</div>

{{-- bảng lưu trữ --}}
<div class="modal fade" id="archiverBoard-member" tabindex="-1" aria-labelledby="addmemberModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header px-3">
                <h5 class="modal-title" id="addmemberModalLabel">
                    Bảng đã đóng
                </h5>
                <button type="button" class="btn-close" id="btn-close-member" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    @if (!empty($workspace))
                        @foreach ($workspace->boards()->onlyTrashed()->get() as $archiverBoard)
                            <div class="d-flex align-items-center justify-content-between  border rounded mt-2"
                                 style="background-color: #091e420f"
                                 id="board-archiver-view-header-{{ $archiverBoard->id }}">

                                <div class="d-flex align-items-center ">
                                    @if ($archiverBoard->image)
                                        <img src="{{ asset('storage/' . $archiverBoard->image) }}" alt=""
                                             class="rounded-circle avatar-sm">
                                    @else
                                        <div
                                            class="bg-info-subtle rounded d-flex justify-content-center align-items-center border rounded"
                                            style="width: 40px;height: 40px">
                                            {{ strtoupper(substr($archiverBoard->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <p class="fs-16 mt-3 ms-2">{{ $archiverBoard->name }}</p>
                                </div>

                                <div>
                                    <button class="btn btn-outline-primary"
                                            onclick="restoreBoard({{ $archiverBoard->id }})">
                                        Khôi phục
                                    </button>
                                    <button class="btn btn-outline-danger"
                                            onclick="destroyBoard({{ $archiverBoard->id }})">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>

                            </div>
                        @endforeach

                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- tìm kiếm --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-options');
        const searchDropdown = document.getElementById('search-dropdown');
        const workspaceId = document.getElementById('workspace-id').value;

        function debounce(func, delay) {
            let timeoutId;
            return function(...args) {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                timeoutId = setTimeout(() => {
                    func.apply(this, args);
                }, delay);
            };
        }

        function handleSearch() {

            const query = searchInput.value;
            if (query.length > 1) {
                fetch(`/api/search?query=${query}&workspace_id=${workspaceId}`)
                    .then(response => response.json())
                    .then(data => {
                        let resultsHtml = '';

                        // Hiển thị kết quả bảng (boards)
                        if (data.boards.length > 0) {
                            resultsHtml += `<div class="dropdown-header">Bảng</div>`;
                            data.boards.forEach(board => {
                                resultsHtml += `
                            <div class="d-flex justify-content-center align-items-center ms-3 me-3">
                                ${board.image ?
                                    `<img src="/storage/${board.image}" alt="" class="rounded avatar-sm" style="width: 20px; height: 20px;">` :
                                    `<div class="bg-info-subtle rounded d-flex justify-content-center align-items-center" style="width: 20px; height: 20px;">
                                        ${board.name.charAt(0).toUpperCase()}
                                    </div>`
                                }
                                <a href="/b/${board.id}/edit" class="dropdown-item notify-item">
                                    <span>${board.name}</span>
                                </a>
                            </div>`;
                            });
                        }
                        // Hiển thị kết quả catalog
                        if (data.catalogs.length > 0) {
                            resultsHtml += `<div class="dropdown-header">Danh sách</div>`;
                            data.catalogs.forEach(catalog => {
                                resultsHtml += `
                                <div class="d-flex justify-content-center align-items-center ms-3 me-3">
                                ${catalog.image ?
                                    `<img src="/storage/${catalog.image}" alt="" class="rounded avatar-sm" style="width: 20px; height: 20px;">` :
                                    `<div class="bg-info-subtle rounded d-flex justify-content-center align-items-center" style="width: 20px; height: 20px;">
                                    ${catalog.name.charAt(0).toUpperCase()}
                                    </div>`
                                }
                                <a href="/b/${catalog.board_id}/edit" class="dropdown-item notify-item">
                                        <span>${catalog.board_name} : ${catalog.name}</span>
                                    </a>
                                </div>
                            `;
                            });
                        }

                        // Hiển thị kết quả task
                        if (data.tasks.length > 0) {
                            resultsHtml += `<div class="dropdown-header">Thẻ</div>`;
                            data.tasks.forEach(task => {
                                resultsHtml += `
                                <div class="d-flex justify-content-center align-items-center ms-3 me-3">
                                ${task.image ?
                                    `<img src="/storage/${task.image}" alt="" class="rounded avatar-sm" style="width: 20px; height: 20px;">` :
                                    `<div class="bg-info-subtle rounded d-flex justify-content-center align-items-center" style="width: 20px; height: 20px;">
                                        ${task.text.charAt(0).toUpperCase()}
                                    </div>`
                                }
                                    <div class="dropdown-item notify-item">
                                        <span class="task-text" data-bs-toggle="modal"
                                                        data-bs-target="#detailCardModal${task.id}">${task.text}</span>
                                        <a href="/b/${task.board_id}/edit"><span class="task-details">${task.board_name} : ${task.catalog_name}</span>
                                    </a>
                                    </div>
                                </div>
                            `;
                            });
                        }

                        // Nếu không có kết quả cho cả bảng và catalog
                        if (resultsHtml === '') {
                            resultsHtml =
                                '<div class="dropdown-item text-muted">Không tìm thấy kết quả</div>';
                        }

                        searchDropdown.innerHTML = resultsHtml;
                        searchDropdown.classList.add('show');

                        // Ngăn không cho nhấn Enter nếu không có kết quả hoặc dropdown đang mở
                        searchInput.addEventListener('keydown', function(event) {
                            const isDropdownOpen = searchDropdown.classList.contains(
                                'show');
                            if ((resultsHtml.includes('Không tìm thấy kết quả') ||
                                    isDropdownOpen) && event.key === 'Enter') {
                                event.preventDefault();
                            }
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                // Hiển thị "Tìm Kiếm" nếu input rỗng
                searchDropdown.innerHTML = '<div class="dropdown-header">Tìm Kiếm</div>';
            }
        }

        // Hiện dropdown với chữ "Tìm Kiếm" khi nhấn vào ô input
        searchInput.addEventListener('focus', function() {
            searchDropdown.classList.add('show');

            // Hiển thị "Tìm Kiếm" khi không có input
            if (searchInput.value === '') {
                searchDropdown.innerHTML =
                    '<div class="dropdown-header">Tìm Kiếm bảng, danh sách, thẻ công việc</div>';
            }
        });

        // Lắng nghe sự kiện input
        searchInput.addEventListener('input', debounce(handleSearch, 1000));
    });
</script>

<style>
    .dropdown-item.notify-item {
        display: block;
        padding: 10px;
        /* border-bottom: 1px solid #ddd; */
    }

    .dropdown-item.notify-item span {
        display: block;
        line-height: 1.5;
    }
</style>
