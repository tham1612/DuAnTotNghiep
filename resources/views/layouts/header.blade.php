@php
//    $boardIsStars = \App\Models\Board::query()
//        ->distinct()
//        ->select(
//            'boards.name AS board_name',
//            'workspaces.name AS workspace_name',
//            'boards.id AS board_id',
//            'boards.image AS board_image',
//        )
//        ->join('workspaces', 'boards.workspace_id', '=', 'workspaces.id')
//        ->join('workspace_members', 'workspace_members.workspace_id', '=', 'workspaces.id')
//        ->join('board_members', 'board_members.board_id', '=', 'boards.id')
//        ->where('workspace_members.is_active', 1)
//        ->where('board_members.user_id', \Illuminate\Support\Facades\Auth::id())
//        ->where('board_members.is_star', 1)
//        ->get();
      $boardIsStars = session('boardIsStars');
    //dd(\Illuminate\Support\Facades\Auth::id(),$boardIsStars);
@endphp
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

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Tìm kiếm" autocomplete="off"
                               id="search-options" value=""/>
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                              id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">
                                    Recent Searches
                                </h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">how to setup <i
                                        class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">buttons <i
                                        class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">
                                    Pages
                                </h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">
                                    Members
                                </h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                             class="me-3 rounded-circle avatar-xs" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                             class="me-3 rounded-circle avatar-xs" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                             class="me-3 rounded-circle avatar-xs" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i
                                    class="ri-arrow-right-line ms-1"></i></a>
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
                                <div
                                    class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                             class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1 fs-14">
                                                {{--    Liên kết đến bảng                                            --}}
                                                <a href="{{ route('b.edit', ['viewType' => 'list', 'id' => 1]) }}"
                                                   class="text-reset">Dự án
                                                    tốt nghiệp</a>
                                            </h6>
                                            <p class="mb-0 fs-12 w-100 text-muted">
                                                FPT Polytechnic workspace
                                                <i class=" ri-subtract-line"></i>
                                                20 giờ trước
                                            </p>
                                        </div>
                                        <div class="ps-2">
                                            <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-warning remove-item-btn">
                                                <i class="ri-star-fill fs-16"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                             class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1 fs-14">
                                                {{--    Liên kết đến bảng                                            --}}
                                                <a href="apps-ecommerce-product-details.html" class="text-reset">Dự án
                                                    tốt nghiệp</a>
                                            </h6>
                                            <p class="mb-0 fs-12 w-100 text-muted">
                                                FPT Polytechnic workspace
                                            </p>
                                        </div>
                                        <div class="ps-2">
                                            <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-warning remove-item-btn">
                                                <i class="ri-star-fill fs-16"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer">
                                    <div class="d-flex align-items-center">

                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                             class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"/>

                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1 fs-14">
                                                {{--    Liên kết đến bảng                                            --}}
                                                <a href="apps-ecommerce-product-details.html" class="text-reset">Dự án
                                                    tốt nghiệp</a>
                                            </h6>
                                            <p class="mb-0 fs-12 w-100 text-muted">
                                                FPT Polytechnic workspace
                                            </p>
                                        </div>
                                        <div class="ps-2">
                                            <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-warning remove-item-btn">
                                                <i class="ri-star-fill fs-16"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  bảng được đánh dấu sao              --}}
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary pt-3"
                            style="width: 150px" id="page-header-cart-dropdown" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <p>Đã đánh dấu sao <i class=" ri-arrow-drop-down-line fs-20"></i></p>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                         aria-labelledby="page-header-cart-dropdown">
                        <div data-simplebar style="max-height: 270px">
                            <div class="p-2">
                                @if(!empty($boardIsStars))
                                @foreach ($boardIsStars as $boardIsStar)
                                    <div
                                        class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer">
                                        <div class="d-flex align-items-center">

                                            <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                                 class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"/>

                                            <div class="flex-grow-1">
                                                <h6 class="mt-0 mb-1 fs-14">
                                                    {{--    Liên kết đến bảng                                            --}}
                                                    <a href="{{ route('b.edit', ['viewType' => 'list', 'id' => $boardIsStar['board_id']]) }}"
                                                       class="text-reset">
                                                        {{ $boardIsStar['board_name'] }}
                                                    </a>
                                                </h6>
                                                <p class="mb-0 fs-12 w-100 text-muted">
                                                    {{ $boardIsStar['workspace_name'] }}
                                                </p>
                                            </div>
                                            <div class="ps-2">
                                                <button type="button" data-value="{{ $boardIsStar['board_id'] }}"
                                                        id="board_star_{{ $boardIsStar['board_id'] }}"
                                                        class="btn btn-icon btn-sm btn-ghost-warning remove-item-btn">
                                                    <i class="ri-star-fill fs-16"></i>
                                                </button>
                                                <input type="hidden" id="user_id"
                                                       value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{--  Mẫu              --}}
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary pt-3"
                            style="width: 100px" id="template-home" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <p class="">Mẫu <i class=" ri-arrow-drop-down-line fs-20"></i></p>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                         aria-labelledby="template-home">
                        <div data-simplebar style="max-height: 270px">
                            <div class="p-2">
                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer"
                                     data-bs-toggle="modal" data-bs-target="#create-board-home-modal">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                             class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1 fs-14">
                                                {{--    Liên kết đến bảng                                            --}}
                                                Dự án tốt nghiệp
                                            </h6>
                                            <p class="mb-0 fs-12 w-100 text-muted">
                                                FPT Polytechnic workspace
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer"
                                     data-bs-toggle="modal" data-bs-target="#create-board-home-modal">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                             class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1 fs-14">
                                                {{--    Liên kết đến bảng                                            --}}
                                                Dự án tốt nghiệp
                                            </h6>
                                            <p class="mb-0 fs-12 w-100 text-muted">
                                                FPT Polytechnic workspace
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer"
                                     data-bs-toggle="modal" data-bs-target="#create-board-home-modal">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                             class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"/>
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1 fs-14">
                                                {{--    Liên kết đến bảng                                            --}}
                                                Dự án tốt nghiệp
                                            </h6>
                                            <p class="mb-0 fs-12 w-100 text-muted">
                                                FPT Polytechnic workspace
                                            </p>
                                        </div>

                                    </div>
                                </div>
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
                                     data-bs-toggle="modal" data-bs-target="#create-board-template-home-modal">
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
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class="bx bx-moon fs-22"></i>
                    </button>
                </div>


                <div class="dropdown ms-sm-3 header-item topbar-user" style="height: 60px">

                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if (auth()->user()->image)
                                <img class="rounded header-profile-user object-fit-cover"
                                     src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->image) }}"
                                     alt="Avatar"/>
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
                        <a class="dropdown-item" href="{{ route('chat') }}"><i
                                class="ri-archive-line text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Lưu trữ</span></a>
                        <form id="logoutForm" action="{{ route('logout') }}" method="post" class="dropdown-item">
                            @csrf
                            <i class="mdi mdi-logout text-muted fs-16 align-middle"></i>
                            <button type="button" class="bg-transparent border-0" data-bs-toggle="modal"
                                    data-bs-target="#topmodal">Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@if (!empty(session('msg')) && !empty(session('action')))
    <div class="bg-light" aria-live="polite" aria-atomic="true"
         style="position: fixed; top: 70px;right: 10px; z-index: 100">
        <div class="toast fade show bg-{{session('action')}}-subtle" role="alert" aria-live="assertive"
             aria-atomic="true" data-bs-toggle="toast" id="notification-messenger">
            <div class="toast-header">
                <img src="{{ asset('theme/assets/images/logo-sm.png') }}" class="rounded me-2" alt="..."
                     height="20">
                <span class="fw-semibold me-auto">Task Flow.</span>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body fw-bolder text-{{session('action')}}">
                {{ session('msg') }}
            </div>
        </div>
    </div>

@endif
@if(!empty($boardIsStars))
@foreach ($boardIsStars as $boardIsStar)
    <script>
        var user_id = document.getElementById('user_id');
        var board_star = document.getElementById("board_star_{{ $boardIsStar['board_id'] }}");
        board_star.addEventListener('click', function () {
            var board_id = this.getAttribute('data-value');
            $.ajax({
                url: `/b/${board_id}/updateBoardMember`,
                method: "PUT",
                data: {
                    board_id: board_id,
                    user_id: user_id.value,
                },
                success: function (response) {

                },
                error: function (xhr) {

                }
            });
        })
    </script>
@endforeach
@endif

<div id="topmodal" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon src="https://cdn.lordicon.com/pithnlch.json" trigger="loop"
                           colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                </lord-icon>
                <div class="mt-4">
                    <h4 class="mb-3">Bạn có muốn đăng xuất không?</h4>
                    <div class="hstack gap-2 justify-content-center">
                        <button type="button" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i> Hủy
                        </button>
                        <button type="submit" class="btn btn-success" form="logoutForm">Đăng xuất</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


