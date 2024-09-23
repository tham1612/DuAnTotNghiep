<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Chat | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href={{ asset('theme/assets/images/favicon.ico') }}>

    <!-- glightbox css -->
    <link rel="stylesheet" href={{ asset('theme/assets/libs/glightbox/css/glightbox.min.css') }}>

    <!-- Layout config Js -->
    <script src={{ asset('theme/assets/js/layout.js') }}></script>
    <!-- Bootstrap Css -->
    <link href={{ asset('theme/assets/css/bootstrap.min.css') }} rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href={{ asset('theme/assets/css/icons.min.css') }} rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href={{ asset('theme/assets/css/app.min.css') }} rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href={{ asset('theme/assets/css/custom.min.css') }} rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('layouts.header')

        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                                It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        @include('layouts.sidebar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                        <!-- sidebar -->
                        <div class="chat-leftsidebar">
                            <div class="px-4 pt-4 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-4">Trò chuyện</h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom"
                                            title="Add Contact">

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-soft-success btn-sm">
                                                <i class="ri-add-line align-bottom"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-box">
                                    <input type="text" class="form-control bg-light border-light"
                                        placeholder="Tìm kiếm">
                                    <i class="ri-search-2-line search-icon"></i>
                                </div>
                            </div> <!-- .p-4 -->

                            <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#chats" role="tab">
                                        Tin nhắn
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab">
                                        Liên hệ
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="chats" role="tabpanel">
                                    <div class="chat-room-list pt-3" data-simplebar>
                                        <div class="d-flex align-items-center px-4 mb-2">
                                            <div class="flex-grow-1">
                                                <h4 class="mb-0 fs-11 text-muted text-uppercase">Tin nhắn</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="bottom" title="New Message">

                                                    <!-- Button trigger modal -->
                                                    <button type="button"
                                                        class="btn btn-soft-success btn-sm shadow-none">
                                                        <i class="ri-add-line align-bottom"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="chat-message-list">
                                            <ul class="list-unstyled chat-list chat-user-list" id="userList">
                                                <li id="contact-id-1" data-name="direct-message" class="active"> <a
                                                        href="javascript: void(0);" id="userList">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs"> <img
                                                                        src="theme/assets/images/users/avatar-2.jpg"
                                                                        class="rounded-circle img-fluid userprofile"
                                                                        alt=""><span class="user-status"></span> </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Nt Thắm</p>
                                                            </div>
                                                            <div class="ms-auto"><span
                                                                    class="badge bg-dark-subtle text-body rounded p-1">đi
                                                                    ngủ</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-2" data-name="direct-message" class=""> <a
                                                        href="javascript: void(0);" class="unread-msg-user">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs"> <img
                                                                        src="theme/assets/images/users/avatar-3.jpg"
                                                                        class="rounded-circle img-fluid userprofile"
                                                                        alt=""><span class="user-status"></span> </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Nam Đỗ</p>
                                                            </div>
                                                            <div class="ms-auto"><span
                                                                    class="badge bg-dark-subtle text-body rounded p-1">99</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-3" data-name="direct-message" class=""> <a
                                                        href="javascript: void(0);">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img away align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs">
                                                                    <div
                                                                        class="avatar-title rounded-circle bg-primary text-white fs-10">
                                                                        CT</div><span class="user-statu"></span>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Nguyệt</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-4" data-name="direct-message" class=""> <a
                                                        href="javascript: void(0);">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs"> <img
                                                                        src="theme/assets/images/users/avatar-4.jpg"
                                                                        class="rounded-circle img-fluid userprofile"
                                                                        alt=""><span class="user-status"></span> </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Vinh</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-5" data-name="direct-message" class=""> <a
                                                        href="javascript: void(0);" class="unread-msg-user">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs"> <img
                                                                        src="theme/assets/images/users/avatar-5.jpg"
                                                                        class="rounded-circle img-fluid userprofile"
                                                                        alt=""><span class="user-status"></span> </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Tuấn</p>
                                                            </div>
                                                            <div class="ms-auto"><span
                                                                    class="badge bg-dark-subtle text-body rounded p-1">5</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-6" data-name="direct-message" class=""> <a
                                                        href="javascript: void(0);" class="unread-msg-user">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img away align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs"> <img
                                                                        src="theme/assets/images/users/avatar-6.jpg"
                                                                        class="rounded-circle img-fluid userprofile"
                                                                        alt=""><span class="user-status"></span> </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Thanh Thanh</p>
                                                            </div>
                                                            <div class="ms-auto"><span
                                                                    class="badge bg-dark-subtle text-body rounded p-1">2</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-7" data-name="direct-message" class=""> <a
                                                        href="javascript: void(0);">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs">
                                                                    <div
                                                                        class="avatar-title rounded-circle bg-primary text-white fs-10">
                                                                        CK</div><span class="user-status"></span>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Đạt Lê</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="d-flex align-items-center px-4 mt-4 pt-2 mb-2">
                                            <div class="flex-grow-1">
                                                <h4 class="mb-0 fs-11 text-muted text-uppercase">Nhóm</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="bottom" title="Create group">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-soft-success btn-sm">
                                                        <i class="ri-add-line align-bottom"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="chat-message-list">

                                            <ul class="list-unstyled chat-list chat-user-list mb-0" id="channelList">
                                                <li id="contact-id-10" data-name="channel"> <a
                                                        href="javascript: void(0);" class="unread-msg-user">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs">
                                                                    <div
                                                                        class="avatar-title bg-light rounded-circle text-body">
                                                                        #</div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">DATN</p>
                                                            </div>
                                                            <div>
                                                                <div class="flex-shrink-0 ms-2"><span
                                                                        class="badge bg-dark-subtle text-body rounded p-1">7</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-10" data-name="channel"> <a
                                                        href="javascript: void(0);" class="unread-msg-user">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs">
                                                                    <div
                                                                        class="avatar-title bg-light rounded-circle text-body">
                                                                        #</div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Chị em chúng mình</p>
                                                            </div>
                                                            <div>
                                                                <div class="flex-shrink-0 ms-2"><span
                                                                        class="badge bg-dark-subtle text-body rounded p-1">7</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li id="contact-id-10" data-name="channel"> <a
                                                        href="javascript: void(0);" class="unread-msg-user">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                                                <div class="avatar-xxs">
                                                                    <div
                                                                        class="avatar-title bg-light rounded-circle text-body">
                                                                        #</div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-truncate mb-0">Off nhóm</p>
                                                            </div>
                                                            <div>
                                                                <div class="flex-shrink-0 ms-2"><span
                                                                        class="badge bg-dark-subtle text-body rounded p-1">7</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End chat-message-list -->
                                    </div>
                                </div>
                                <!-- danh sách liên hệ -->
                                <div class="tab-pane" id="contacts" role="tabpanel">
                                    <div class="chat-room-list pt-3" data-simplebar>
                                        <div class="sort-contact">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab contact -->
                        </div>
                        <!-- end chat leftsidebar -->
                        <!-- Start User chat -->
                        <div class="user-chat w-100 overflow-hidden">

                            <div class="chat-content d-lg-flex">
                                <!-- start chat conversation section -->
                                <div class="w-100 overflow-hidden position-relative">
                                    <!-- conversation user -->
                                    <div class="position-relative">


                                        <div class="position-relative" id="users-chat">
                                            <div class="p-3 user-chat-topbar">
                                                <div class="row align-items-center">
                                                    <!-- avt chat -->
                                                    <div class="col-sm-4 col-8">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                                <a href="javascript: void(0);"
                                                                    class="user-chat-remove fs-18 p-1"><i
                                                                        class="ri-arrow-left-s-line align-bottom"></i></a>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                        <img src="theme/assets/images/users/avatar-2.jpg"
                                                                            class="rounded-circle avatar-xs" alt="">
                                                                        <span class="user-status"></span>
                                                                    </div>
                                                                    <div class="flex-grow-1 overflow-hidden">
                                                                        <h5 class="text-truncate mb-0 fs-16"><a
                                                                                class="text-reset username"
                                                                                data-bs-toggle="offcanvas"
                                                                                href="#userProfileCanvasExample"
                                                                                aria-controls="userProfileCanvasExample">Lisa
                                                                                Parker</a></h5>
                                                                        <p
                                                                            class="text-truncate text-muted fs-14 mb-0 userStatus">
                                                                            <small>Online</small>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- tiện ích ng dùng -->
                                                    <div class="col-sm-8 col-4">
                                                        <ul class="list-inline user-chat-nav text-end mb-0">
                                                            <!-- chấm than -->
                                                            <li class="list-inline-item d-none d-lg-inline-block m-0">
                                                                <button type="button"
                                                                    class="btn btn-ghost-secondary btn-icon"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#userProfileCanvasExample"
                                                                    aria-controls="userProfileCanvasExample">
                                                                    <i data-feather="info" class="icon-sm"></i>
                                                                </button>
                                                            </li>
                                                            <!-- 3 chấm -->
                                                            <li class="list-inline-item m-0">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-ghost-secondary btn-icon"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                        <i data-feather="more-vertical"
                                                                            class="icon-sm"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item d-block d-lg-none user-profile-show"
                                                                            href="#"><i
                                                                                class="ri-user-2-fill align-bottom text-muted me-2"></i>
                                                                            View Profile</a>
                                                                        <!-- <a class="dropdown-item" href="#"><i
                                                                                class="ri-inbox-archive-line align-bottom text-muted me-2"></i>
                                                                            Archive</a> -->
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="ri-mic-off-line align-bottom text-muted me-2"></i>
                                                                            Im lặng</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>
                                                                            Xóa</a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- khung chat cá nhân -->
                                            <div class="chat-conversation p-3 p-lg-4 " id="chat-conversation"
                                                data-simplebar>
                                                <div id="elmLoader">
                                                    <div class="spinner-border text-primary avatar-sm" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                                <ul class="list-unstyled chat-conversation-list"
                                                    id="users-conversation">

                                                </ul>
                                                <!-- end chat-conversation-list -->
                                            </div>
                                            <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show "
                                                id="copyClipBoard" role="alert">
                                                Message copied
                                            </div>
                                        </div>
                                        <!-- khung chat nhóm -->
                                        <div class="position-relative" id="channel-chat">
                                            <div class="p-3 user-chat-topbar">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4 col-8">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                                <a href="javascript: void(0);"
                                                                    class="user-chat-remove fs-18 p-1"><i
                                                                        class="ri-arrow-left-s-line align-bottom"></i></a>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                        <img src="theme/assets/images/users/avatar-2.jpg"
                                                                            class="rounded-circle avatar-xs" alt="">
                                                                    </div>
                                                                    <div class="flex-grow-1 overflow-hidden">
                                                                        <h5 class="text-truncate mb-0 fs-16"><a
                                                                                class="text-reset username"
                                                                                data-bs-toggle="offcanvas"
                                                                                href="#userProfileCanvasExample"
                                                                                aria-controls="userProfileCanvasExample">Lisa
                                                                                Parker</a></h5>
                                                                        <p
                                                                            class="text-truncate text-muted fs-14 mb-0 userStatus">
                                                                            <small>244 Members</small>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 col-4">
                                                        <ul class="list-inline user-chat-nav text-end mb-0">
                                                            <li class="list-inline-item m-0">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-ghost-secondary btn-icon"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                        <i data-feather="search" class="icon-sm"></i>
                                                                    </button>
                                                                    <div
                                                                        class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                                                                        <div class="p-2">
                                                                            <div class="search-box">
                                                                                <input type="text"
                                                                                    class="form-control bg-light border-light"
                                                                                    placeholder="Search here..."
                                                                                    onkeyup="searchMessages()"
                                                                                    id="searchMessage">
                                                                                <i
                                                                                    class="ri-search-2-line search-icon"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li class="list-inline-item d-none d-lg-inline-block m-0">
                                                                <button type="button"
                                                                    class="btn btn-ghost-secondary btn-icon"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#userProfileCanvasExample"
                                                                    aria-controls="userProfileCanvasExample">
                                                                    <i data-feather="info" class="icon-sm"></i>
                                                                </button>
                                                            </li>

                                                            <li class="list-inline-item m-0">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-ghost-secondary btn-icon"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                        <i data-feather="more-vertical"
                                                                            class="icon-sm"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item d-block d-lg-none user-profile-show"
                                                                            href="#"><i
                                                                                class="ri-user-2-fill align-bottom text-muted me-2"></i>
                                                                            View Profile</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="ri-inbox-archive-line align-bottom text-muted me-2"></i>
                                                                            Archive</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="ri-mic-off-line align-bottom text-muted me-2"></i>
                                                                            Muted</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>
                                                                            Delete</a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end chat user head -->
                                            <div class="chat-conversation p-3 p-lg-4" id="chat-conversation"
                                                data-simplebar>
                                                <ul class="list-unstyled chat-conversation-list"
                                                    id="channel-conversation">
                                                </ul>
                                                <!-- end chat-conversation-list -->

                                            </div>
                                            <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show "
                                                id="copyClipBoardChannel" role="alert">
                                                Message copied
                                            </div>
                                        </div>

                                        <!-- end chat-conversation -->
                                        <!-- nhập tin nhắn -->
                                        <div class="chat-input-section p-3 p-lg-4">

                                            <form id="chatinput-form" enctype="multipart/form-data">
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-auto">
                                                        <div class="chat-input-links me-2">
                                                            <div class="links-list-item">
                                                                <button type="button"
                                                                    class="btn btn-link text-decoration-none emoji-btn"
                                                                    id="emoji-btn">
                                                                    <i class="bx bx-smile align-middle"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="chat-input-feedback">
                                                            Please Enter a Message
                                                        </div>
                                                        <input type="text"
                                                            class="form-control chat-input bg-light border-light"
                                                            id="chat-input" placeholder="Nhập tin nhắn"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="chat-input-links ms-2">
                                                            <div class="links-list-item">
                                                                <button type="submit"
                                                                    class="btn btn-success chat-send waves-effect waves-light">
                                                                    <i class="ri-send-plane-2-fill align-bottom"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

                                        <div class="replyCard">
                                            <div class="card mb-0">
                                                <div class="card-body py-3">
                                                    <div class="replymessage-block mb-0 d-flex align-items-start">
                                                        <div class="flex-grow-1">
                                                            <h5 class="conversation-name"></h5>
                                                            <p class="mb-0"></p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <button type="button" id="close_toggle"
                                                                class="btn btn-sm btn-link mt-n2 me-n3 fs-18">
                                                                <i class="bx bx-x align-middle"></i>
                                                            </button>
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
                    <!-- end chat-wrapper -->

                </div>
                <!-- container-fluid -->
            </div>
            <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="userProfileCanvasExample">
                <!--end offcanvas-header-->
                <div class="offcanvas-body profile-offcanvas p-0">
                    <div class="team-cover">
                        <img src="theme/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                    </div>
                    <div class="p-1 pb-4 pt-0">
                        <div class="team-settings">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="btn nav-btn">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="user-chat-nav d-flex">
                                        <button type="button" class="btn nav-btn favourite-btn active">
                                            <i class="ri-star-fill"></i>
                                        </button>

                                        <div class="dropdown">
                                            <a class="btn nav-btn" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <!-- <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-inbox-archive-line align-bottom text-muted me-2"></i>Archive</a>
                                                </li> -->
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-mic-off-line align-bottom text-muted me-2"></i>Im
                                                        lặng</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>Xóa</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <div class="p-3 text-center">
                        <img src="theme/assets/images/users/avatar-2.jpg" alt=""
                            class="avatar-lg img-thumbnail rounded-circle mx-auto profile-img">
                        <div class="mt-3">
                            <h5 class="fs-16 mb-1"><a href="javascript:void(0);" class="link-primary username">Lisa
                                    Parker</a>
                            </h5>
                            <p class="text-muted"><i
                                    class="ri-checkbox-blank-circle-fill me-1 align-bottom text-success"></i>Online</p>
                        </div>


                    </div>
                    <!-- thông tin cá nhân -->
                    <div class="border-top border-top-dashed p-3">
                        <h5 class="fs-15 mb-3">Thông tin người dùng</h5>
                        <div class="mb-3">
                            <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Số điện thoại</p>
                            <h6>+(256) 2451 8974</h6>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Email</p>
                            <h6>lisaparker@gmail.com</h6>
                        </div>
                        <!-- <div>
                            <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Vị trí</p>
                            <h6 class="mb-0">California, USA</h6>
                        </div> -->
                    </div>


                </div>
                <!--end offcanvas-body-->
            </div>
            <!-- modal chấm than -->
            <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="userProfileCanvasExample">
                <!--end offcanvas-header-->
                <div class="offcanvas-body profile-offcanvas p-0">
                    <div class="team-cover">
                        <img src="theme/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                    </div>
                    <div class="p-1 pb-4 pt-0">
                        <div class="team-settings">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="btn nav-btn">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="user-chat-nav d-flex">
                                        <button type="button" class="btn nav-btn favourite-btn active">
                                            <i class="ri-star-fill"></i>
                                        </button>

                                        <div class="dropdown">
                                            <a class="btn nav-btn" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <!-- <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ri-inbox-archive-line align-bottom text-muted me-2"></i>Archive</a>
                                        </li> -->
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-mic-off-line align-bottom text-muted me-2"></i>Im
                                                        lặng</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>Xóa</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <div class="p-3 text-center">
                        <img src="theme/assets/images/users/avatar-2.jpg" alt=""
                            class="avatar-lg img-thumbnail rounded-circle mx-auto profile-img">
                        <div class="mt-3">
                            <h5 class="fs-16 mb-1"><a href="javascript:void(0);" class="link-primary username">Lisa
                                    Parker</a>
                            </h5>
                            <p class="text-muted"><i
                                    class="ri-checkbox-blank-circle-fill me-1 align-bottom text-success"></i>Online</p>
                        </div>


                    </div>
                    <!-- thông tin cá nhân -->
                    <div class="border-top border-top-dashed p-3">
                        <h5 class="fs-15 mb-3">Thông tin người dùng</h5>
                        <div class="mb-3">
                            <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Số điện thoại</p>
                            <h6>+(256) 2451 8974</h6>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Email</p>
                            <h6>lisaparker@gmail.com</h6>
                        </div>
                        <!-- <div>
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Vị trí</p>
                    <h6 class="mb-0">California, USA</h6>
                </div> -->
                    </div>


                </div>
                <!--end offcanvas-body-->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <!-- modal chấm than -->
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="userProfileCanvasExample">
        <!--end offcanvas-header-->
        <div class="offcanvas-body profile-offcanvas p-0">
            <div class="team-cover">
                <img src="theme/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
            </div>
            <div class="p-1 pb-4 pt-0">
                <div class="team-settings">
                    <div class="row g-0">
                        <div class="col">
                            <div class="btn nav-btn">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="user-chat-nav d-flex">
                                <button type="button" class="btn nav-btn favourite-btn active">
                                    <i class="ri-star-fill"></i>
                                </button>

                                <div class="dropdown">
                                    <a class="btn nav-btn" href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <!-- <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ri-inbox-archive-line align-bottom text-muted me-2"></i>Archive</a>
                                        </li> -->
                                        <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ri-mic-off-line align-bottom text-muted me-2"></i>Im lặng</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>Xóa</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="p-3 text-center">
                <img src="theme/assets/images/users/avatar-2.jpg" alt=""
                    class="avatar-lg img-thumbnail rounded-circle mx-auto profile-img">
                <div class="mt-3">
                    <h5 class="fs-16 mb-1"><a href="javascript:void(0);" class="link-primary username">Lisa Parker</a>
                    </h5>
                    <p class="text-muted"><i
                            class="ri-checkbox-blank-circle-fill me-1 align-bottom text-success"></i>Online</p>
                </div>


            </div>
            <!-- thông tin cá nhân -->
            <div class="border-top border-top-dashed p-3">
                <h5 class="fs-15 mb-3">Thông tin người dùng</h5>
                <div class="mb-3">
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Số điện thoại</p>
                    <h6>+(256) 2451 8974</h6>
                </div>
                <div class="mb-3">
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Email</p>
                    <h6>lisaparker@gmail.com</h6>
                </div>
                <!-- <div>
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Vị trí</p>
                    <h6 class="mb-0">California, USA</h6>
                </div> -->
            </div>


        </div>
        <!--end offcanvas-body-->
    </div>
    <!--end offcanvas-->



    <!--start back-to-top-->


    <!-- Theme Settings -->


    <!-- JAVASCRIPT -->
   <!-- JAVASCRIPT -->
   <script src={{ asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}></script>
   <script src={{ asset('theme/assets/libs/simplebar/simplebar.min.js') }}></script>
   <script src={{ asset('theme/assets/libs/node-waves/waves.min.js') }}></script>
   <script src={{ asset('theme/assets/libs/feather-icons/feather.min.js') }}></script>
   <script src={{ asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js') }}></script>
   <script src={{ asset('theme/assets/js/plugins.js') }}></script>

   <!-- glightbox js -->
   <script src={{ asset('theme/assets/libs/glightbox/js/glightbox.min.js') }}></script>

   <!-- fgEmojiPicker js -->
   <script src={{ asset('theme/assets/libs/fg-emoji-picker/fgEmojiPicker.js') }}></script>

   <!-- chat init js -->
   <script src={{ asset('theme/assets/js/pages/chat.init.js') }}></script>

   <!-- App js -->
   <script src={{ asset('theme/assets/js/app.js') }}></script>
</body>

</html>