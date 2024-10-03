<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

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

    @yield('style')
</head>
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
    </style>
@endif


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

                    @endphp

                    @include('layouts.navbar')
                    @include('components.setting')
                    @include('components.task')
                    @include('components.member')
                @endif

                {{-- các màn hình hiển thị --}}
                @yield('main')

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
    const PATH_ROOT = "/theme/";

    document.addEventListener('DOMContentLoaded', function () {

        // var dropdownElement = document.getElementById('swicthWs');
        // var dropdown = new bootstrap.Dropdown(dropdownElement);
        // hàm ngăn chặn bị tắt khi người dùng tác động lên dropdown
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', event => {
                event.stopPropagation();
            });
        });
    });
</script>
<!-- JAVASCRIPT -->
<script src="{{ asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('theme/assets/js/plugins.js') }}"></script>

@if (request()->is('b/*'))
    <!-- dragula init js -->
    <script src="{{ asset('theme/assets/libs/dragula/dragula.min.js') }}"></script>

    <!-- dom autoscroll -->
    <script src="{{ asset('theme/assets/libs/dom-autoscroller/dom-autoscroller.min.js') }}"></script>


    <!-- prismjs plugin -->
    <script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>

    {{--        <script src="{{ asset('theme/assets/js/pages/flag-input.init.js') }}"></script> --}}

    <script src="{{ asset('theme/assets/js/pages/project-list.init.js') }}"></script>

    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('theme/assets/js/pages/select2.init.js') }}"></script>
    <script>
        // xử lý checklist card
        const displayChecklistBtn = document.querySelector('.display-checklist');
        const disableChecklistBtn = document.querySelector('.disable-checklist');
        const checklistForm = document.querySelector('.addOrUpdate-checklist');
        const checklistItem = document.querySelector('.checklistItem');


        displayChecklistBtn.addEventListener('click', () => {

            checklistForm.classList.toggle('d-none'); // Hiện hoặc ẩn form
            displayChecklistBtn.classList.add('d-none'); // Hiện hoặc ẩn form
        });

        disableChecklistBtn.addEventListener('click', () => {
            checklistItem.value = "";
            checklistForm.classList.add('d-none'); // Hiện hoặc ẩn form
            displayChecklistBtn.classList.toggle('d-none'); // Hiện hoặc ẩn form
        });


        //     xử lý lưu trữ cảu card
        const archiver = document.querySelector('.archiver');
        const restoreArchiver = document.querySelector('.restore-archiver');
        const deleteArchiver = document.querySelector('.delete-archiver');
        archiver.addEventListener('click', () => {

            restoreArchiver.classList.toggle('d-none');
            deleteArchiver.classList.toggle('d-none');
            archiver.classList.add('d-none');
        });

        restoreArchiver.addEventListener('click', () => {

            deleteArchiver.classList.add('d-none');
            restoreArchiver.classList.add('d-none');
            archiver.classList.toggle('d-none');
        });

        deleteArchiver.addEventListener('click', () => {
            window.location.reload();
        });

        //     xử lý theo dõi + ngày hết hạn của card
        const notification = document.querySelector('#notification');
        const notification_follow = document.querySelector('#notification_follow');
        const notification_icon = document.querySelector('#notification_icon');
        const notification_content = document.querySelector('#notification_content');
        notification.addEventListener('click', () => {
            notification_follow.classList.toggle('d-none');
            notification_icon.classList.contains("ri-eye-line") ?
                notification_icon.className = "ri-eye-off-line fs-22" :
                notification_icon.className = "ri-eye-line fs-22";
            notification_content.textContent === "Theo dõi" ?
                notification_content.innerHTML = "Đang theo dõi" :
                notification_content.innerHTML = "Theo dõi";
        });

        const due_date_checkbox = document.querySelector('#due_date_checkbox');
        const due_date_success = document.querySelector('#due_date_success');
        const due_date_due = document.querySelector('#due_date_due');
        due_date_checkbox.addEventListener('click', () => {
            due_date_due.classList.toggle('d-none');
            due_date_success.classList.toggle('d-none');
        });


    </script>
@endif


<!-- notifications init -->
<script src="{{asset('theme/assets/js/pages/notifications.init.js')}}"></script>

<!-- App js -->
<script src="{{ asset('theme/assets/js/app.js') }}"></script>


<script >
    function disableButtonOnSubmit() {
        continueButton.disabled = true;
        return true; // Vẫn cho phép submit form
    }

    // Đoạn script này sẽ làm thông báo biến mất sau 3 giây
    setTimeout(function () {
        var alertElement = document.getElementById('notification-messenger');
        if (alertElement) {
            alertElement.style.display = 'none';
        }
    }, 5000);

    $(document).ready(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
</script>


@yield('script')

</body>

</html>
