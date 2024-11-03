<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="enable" data-bs-theme="light">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('theme/assets/images/favicon.ico') }}"/>
    <!--Swiper slider css-->
    <link href="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Layout config Js -->
    <script src="{{ asset('theme/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('theme/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('theme/assets/css/app.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{{ asset('theme/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
    @vite('resources/js/app.js')
    <script !src="">
        const PATH_ROOT = "/theme/";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
        body {
            overflow-x: hidden;
        }


        /* Giới hạn chiều cao CKEditor */
        .ck-editor__editable_inline {
            min-height: 100px !important;
            /* Đảm bảo chiều cao giới hạn 150px */
        }

        .comment-section {
            scrollbar-width: none; /* Ẩn thanh cuộn trên Firefox */
        }

        .comment-section::-webkit-scrollbar {
            display: none; /* Ẩn thanh cuộn trên Chrome, Safari và Edge */
        }


    </style>

    @if (request()->is('b/*'))
        <style>
            .dropdown-item p {
                overflow-wrap: break-word;
                /* Cho phép xuống dòng */
                white-space: normal;
                /* Cho phép nội dung xuống dòng */
                width: 200%;
                /* Đảm bảo chiều rộng của thẻ p không vượt quá chiều rộng của li */

            }

            .attachments-container {
                max-height: 400px; /* Đặt chiều cao tối đa để tạo scroll khi cần */
                overflow-y: auto; /* Cho phép cuộn dọc khi vượt quá chiều cao */
            }

            .attachments-container::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }

            .checkList-section {
                max-height: 400px; /* Đặt chiều cao tối đa để tạo scroll khi cần */
                overflow-y: auto; /* Cho phép cuộn dọc khi vượt quá chiều cao */
            }

            .checkList-section::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }

            .selected-tag {
                box-shadow: 0 0 15px #000000; /* Hiệu ứng bóng */
            }
        </style>
    @endif
    @yield('style')
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    {{-- header website --}}
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
                                   colors="primary:#f7b84b,secondary:#f06548"
                                   style="width: 100px; height: 100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">
                                Are you sure you want to remove this Notification ?
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">
                            Yes, Delete It!
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>


        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    @include('layouts.sidebar')

    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content" style="margin-top: -10px">
        <div class="page-content">
            <div class="container-fluid">


                @if (request()->is('b/*'))
                    @php
                        $board = session('board');
                        $memberIsStar = session('memberIsStar');
                        $colors = session('colors');
                    @endphp

                    @include('layouts.navbar')
                    @include('components.setting')
                    @include('components.task')
                    @include('components.member')

                @endif

                {{-- các màn hình hiển thị --}}
                @yield('main')
                @include('components.chatAI')
                @include('components.createBoard')
                @include('components.createTemplateBoard')
                @include('components.workspace')

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')

    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[type="datetime-local"]').forEach(function (input) {
        input.addEventListener('input', function (event) {
            // Ngăn chặn nút xóa (clear button) hoạt động
            if (this.value === "") {
                this.value = this.defaultValue;
            }
        });

    });
</script>
<!-- JAVASCRIPT -->
<script src="{{ asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<!--Swiper slider js-->
<script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- glightbox js -->
{{--<script src="{{ asset('theme/assets/libs/glightbox/js/glightbox.min.js') }}"></script>--}}

<!-- fgEmojiPicker js -->
{{--<script src="{{ asset('theme/assets/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>--}}


<!-- notifications init -->
<script src="{{ asset('theme/assets/js/pages/notifications.init.js') }}"></script>

<!-- prismjs plugin -->
{{--<script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>--}}

<!-- App js -->
<script src="{{ asset('theme/assets/js/app.js') }}"></script>

<!-- Lord Icon -->
<script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>

<!-- Modal Js -->
<script src="{{asset('theme/assets/js/pages/modal.init.js')}}"></script>

@if (request()->is('b/*'))
    <!-- dragula init js -->
    <script src="{{ asset('theme/assets/libs/dragula/dragula.min.js') }}"></script>
    <!-- dom autoscroll -->
    <script src="{{ asset('theme/assets/libs/dom-autoscroller/dom-autoscroller.min.js') }}"></script>
    {{--            <script src="{{ asset('theme/assets/js/pages/flag-input.init.js') }}"></script> --}}
    <script src="{{ asset('theme/assets/js/pages/project-list.init.js') }}"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('theme/assets/js/pages/select2.init.js') }}"></script>
    <script src="{{asset('js/ajax-board.js')}}"></script>
    <script src="{{asset('js/ajax-modal-task.js')}}"></script>
    <script src="{{asset('js/task.js')}}"></script>
    <script src="{{asset('js/catalog.js')}}"></script>
@endif
<script src="{{asset('js/board.js')}}"></script>
<script src="{{asset('js/home.js')}}"></script>
@yield('script')
<script !src="">
    function notificationWeb(action, title) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: action,
            title: title
        });
    }
</script>
</body>

</html>
