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
                            id="search-options" value="" />
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
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic" />
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
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic" />
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
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic" />
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
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary pt-3"
                        style="width: 150px" id="recently-home" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <p class="dropdown-item">Gần đây <i class=" ri-arrow-drop-down-line fs-20"></i></p>
                        {{--                        <span --}}
                        {{--                            class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-info">5</span> --}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                        aria-labelledby="recently-home">
                        <div data-simplebar style="max-height: 270px">
                            <div class="p-2">
                                <div
                                    class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1 fs-14">
                                                {{--    Liên kết đến bảng                                            --}}
                                                <a href="apps-ecommerce-product-details.html" class="text-reset">Dự án
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
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />
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
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />

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
                                <div class="text-center empty-cart" id="empty-cart">
                                    <div class="avatar-md mx-auto my-3">
                                        <div class="avatar-title bg-info-subtle fs-36 rounded-circle"
                                            style=" color: yellow">
                                            <i class="ri-star-fill"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-3">Bạn chưa có bảng nào đánh dấu sao</h5>
                                    {{--                                    <a href="apps-ecommerce-products.html" class="btn btn-success w-md mb-3">Shop --}}
                                    {{--                                        Now</a> --}}
                                </div>
                                <div
                                    class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2 cursor-pointer">
                                    <div class="d-flex align-items-center">

                                        <img src="{{ asset('theme/assets/images/products/img-1.png') }}"
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />

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
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />

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
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />

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
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />
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
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />
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
                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic" />
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

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-bell fs-22"></i>
                        <span
                            class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span
                                class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">
                                            Notifications
                                        </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge bg-light-subtle text-body fs-13">
                                            4 New</span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                    id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                            role="tab" aria-selected="true">
                                            All (4)
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab"
                                            aria-selected="false">
                                            Messages
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab"
                                            aria-selected="false">
                                            Alerts
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px" class="pe-2">
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <span
                                                    class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 lh-base">
                                                        Your <b>Elite</b> author Graphic Optimization
                                                        <span class="text-secondary">reward</span> is
                                                        ready!
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> Just 30
                                                        sec ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check01" />
                                                    <label class="form-check-label"
                                                        for="all-notification-check01"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">

                                            class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic"/>

                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Angela Bernier
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        Answered to your comment on the cash flow
                                                        forecast's graph 🔔.
                                                    </p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 48 min
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check02" />
                                                    <label class="form-check-label"
                                                        for="all-notification-check02"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <span
                                                    class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">
                                                    <i class="bx bx-message-square-dots"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 fs-13 lh-base">
                                                        You have received
                                                        <b class="text-success">20</b> new messages in
                                                        the conversation
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 2 hrs
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check03" />
                                                    <label class="form-check-label"
                                                        for="all-notification-check03"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">

                                            class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic"/>

                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Maureen Gibson
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        We talked about a project on linkedin.
                                                    </p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 4 hrs
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check04" />
                                                    <label class="form-check-label"
                                                        for="all-notification-check04"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center view-all">
                                        <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                            View All Notifications
                                            <i class="ri-arrow-right-line align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel"
                                aria-labelledby="messages-tab">
                                <div data-simplebar style="max-height: 300px" class="pe-2">
                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">

                                            class="me-3 rounded-circle avatar-xs" alt="user-pic"/>

                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        James Lemire
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        We talked about a project on linkedin.
                                                    </p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 30 min
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="messages-notification-check01" />
                                                    <label class="form-check-label"
                                                        for="messages-notification-check01"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">

                                            class="me-3 rounded-circle avatar-xs" alt="user-pic"/>

                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Angela Bernier
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        Answered to your comment on the cash flow
                                                        forecast's graph 🔔.
                                                    </p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 2 hrs
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="messages-notification-check02" />
                                                    <label class="form-check-label"
                                                        for="messages-notification-check02"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">

                                            class="me-3 rounded-circle avatar-xs" alt="user-pic"/>

                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Kenneth Brown
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        Mentionned you in his comment on 📃 invoice
                                                        #12501.
                                                    </p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 10 hrs
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="messages-notification-check03" />
                                                    <label class="form-check-label"
                                                        for="messages-notification-check03"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">

                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic" />

                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                        Maureen Gibson
                                                    </h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">
                                                        We talked about a project on linkedin.
                                                    </p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 3 days
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="messages-notification-check04" />
                                                    <label class="form-check-label"
                                                        for="messages-notification-check04"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center view-all">
                                        <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                            View All Messages
                                            <i class="ri-arrow-right-line align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel"
                                aria-labelledby="alerts-tab"></div>

                            <div class="notification-actions" id="notification-actions">
                                <div class="d-flex text-muted justify-content-center">
                                    Select
                                    <div id="select-content" class="text-body fw-semibold px-1">
                                        0
                                    </div>
                                    Result
                                    <button type="button" class="btn btn-link link-danger p-0 ms-3"
                                        data-bs-toggle="modal" data-bs-target="#removeNotificationModal">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user" style="height: 60px">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                 src="{{ asset('storage/' . auth()->user()->image) }}"
                                 alt="Avatar"/>
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                        <a class="dropdown-item" href="{{ route('user', auth()->user()->id) }}">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Profile</span>
                        </a>
                        <a class="dropdown-item" href=""><i
                                class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href=""><i
                            class=" ri-group-line text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Tạo không gian làm việc</span></a>
                        <form action="{{ route('logout') }}" method="post" class="dropdown-item">
                            @csrf
                            <i class="mdi mdi-logout text-muted fs-16 align-middle"></i>
                            <button type="submit" class="bg-transparent border-0">Logout</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>

    </div>
</header>
