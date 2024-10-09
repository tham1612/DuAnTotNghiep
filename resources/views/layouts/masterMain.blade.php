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
    <!--Swiper slider css-->
    <link
        href="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.css') }}"
        rel="stylesheet"
        type="text/css"
    />
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

<div class="customizer-setting d-none d-md-block">
    <div
        class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2"
        data-bs-toggle="offcanvas"
        data-bs-target="#theme-settings-offcanvas"
        aria-controls="theme-settings-offcanvas"
    >
        <i class="mdi mdi-spin mdi-cog-outline fs-22"></i>
    </div>
</div>

<!-- Theme Settings -->
<div
    class="offcanvas offcanvas-end border-0"
    tabindex="-1"
    id="theme-settings-offcanvas"
>
    <div
        class="d-flex align-items-center bg-primary bg-gradient p-3 offcanvas-header"
    >
        <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

        <button
            type="button"
            class="btn-close btn-close-white ms-auto"
            id="customizerclose-btn"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body p-0">
        <div data-simplebar class="h-100">
            <div class="p-4">
                <h6 class="mb-0 fw-semibold text-uppercase">Layout</h6>
                <p class="text-muted">Choose your layout</p>


                <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Color Scheme</h6>
                <p class="text-muted">Choose Light or Dark Scheme.</p>


                <div id="sidebar-visibility">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                        Sidebar Visibility
                    </h6>
                    <p class="text-muted">Choose show or Hidden sidebar.</p>


                </div>

                <div id="layout-width">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Layout Width</h6>
                    <p class="text-muted">Choose Fluid or Boxed layout.</p>


                </div>

                <div id="layout-position">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                        Layout Position
                    </h6>
                    <p class="text-muted">
                        Choose Fixed or Scrollable Layout Position.
                    </p>


                </div>
                <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Topbar Color</h6>
                <p class="text-muted">Choose Light or Dark Topbar Color.</p>


                <div id="sidebar-size">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar Size</h6>
                    <p class="text-muted">Choose a size of Sidebar.</p>


                </div>

                <div id="sidebar-view">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar View</h6>
                    <p class="text-muted">Choose Default or Detached Sidebar view.</p>


                </div>
                <div id="sidebar-color">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                        Sidebar Color
                    </h6>
                    <p class="text-muted">Choose a color of Sidebar.</p>


                </div>

                <div id="sidebar-img">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                        Sidebar Images
                    </h6>

                </div>

                <div id="preloader-menu">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Preloader</h6>
                    <p class="text-muted">Choose a preloader.</p>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="data-preloader"
                                    id="preloader-view-custom"
                                    value="enable"
                                />
                                <label
                                    class="form-check-label p-0 avatar-md w-100"
                                    for="preloader-view-custom"
                                >
                      <span class="d-flex gap-1 h-100">
                        <span class="flex-shrink-0">
                          <span
                              class="bg-light d-flex h-100 flex-column gap-1 p-1"
                          >
                            <span
                                class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"
                            ></span>
                            <span
                                class="d-block p-1 px-2 pb-0 bg-primary-subtle"
                            ></span>
                            <span
                                class="d-block p-1 px-2 pb-0 bg-primary-subtle"
                            ></span>
                            <span
                                class="d-block p-1 px-2 pb-0 bg-primary-subtle"
                            ></span>
                          </span>
                        </span>
                        <span class="flex-grow-1">
                          <span class="d-flex h-100 flex-column">
                            <span class="bg-light d-block p-1"></span>
                            <span class="bg-light d-block p-1 mt-auto"></span>
                          </span>
                        </span>
                      </span>
                                    <!-- <div id="preloader"> -->
                                    <div
                                        id="status"
                                        class="d-flex align-items-center justify-content-center"
                                    >
                                        <div
                                            class="spinner-border text-primary avatar-xxs m-auto"
                                            role="status"
                                        >
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Enable</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="data-preloader"
                                    id="preloader-view-none"
                                    value="disable"
                                />
                                <label
                                    class="form-check-label p-0 avatar-md w-100"
                                    for="preloader-view-none"
                                >
                      <span class="d-flex gap-1 h-100">
                        <span class="flex-shrink-0">
                          <span
                              class="bg-light d-flex h-100 flex-column gap-1 p-1"
                          >
                            <span
                                class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"
                            ></span>
                            <span
                                class="d-block p-1 px-2 pb-0 bg-primary-subtle"
                            ></span>
                            <span
                                class="d-block p-1 px-2 pb-0 bg-primary-subtle"
                            ></span>
                            <span
                                class="d-block p-1 px-2 pb-0 bg-primary-subtle"
                            ></span>
                          </span>
                        </span>
                        <span class="flex-grow-1">
                          <span class="d-flex h-100 flex-column">
                            <span class="bg-light d-block p-1"></span>
                            <span class="bg-light d-block p-1 mt-auto"></span>
                          </span>
                        </span>
                      </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Disable</h5>
                        </div>
                    </div>
                </div>
                <!-- end preloader-menu -->
            </div>
        </div>
    </div>

</div>
<script>
    const PATH_ROOT = "/theme/";

</script>
<!-- JAVASCRIPT -->
<script src="{{ asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('theme/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<!--Swiper slider js-->
<script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<script src=""></script>
<!-- glightbox js -->
<script src="{{ asset('theme/assets/libs/glightbox/js/glightbox.min.js') }}"></script>

<!-- fgEmojiPicker js -->
<script src="{{ asset('theme/assets/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>
<!--jquery cdn-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- notifications init -->
<script src="{{ asset('theme/assets/js/pages/notifications.init.js') }}"></script>
<!-- prismjs plugin -->
<script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>
<!-- App js -->
<script src="{{ asset('theme/assets/js/app.js') }}"></script>

@if (request()->is('b/*'))
    <!-- dragula init js -->
    <script src="{{ asset('theme/assets/libs/dragula/dragula.min.js') }}"></script>

    <!-- dom autoscroll -->
    <script src="{{ asset('theme/assets/libs/dom-autoscroller/dom-autoscroller.min.js') }}"></script>




    {{--            <script src="{{ asset('theme/assets/js/pages/flag-input.init.js') }}"></script> --}}

    <script src="{{ asset('theme/assets/js/pages/project-list.init.js') }}"></script>




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

        // //     xử lý theo dõi + ngày hết hạn của card
        // const notification = document.querySelector('#notification');
        // const notification_follow = document.querySelector('#notification_follow');
        // const notification_icon = document.querySelector('#notification_icon');
        // const notification_content = document.querySelector('#notification_content');
        // notification.addEventListener('click', () => {
        //     notification_follow.classList.toggle('d-none');
        //     notification_icon.classList.contains("ri-eye-line") ?
        //         notification_icon.className = "ri-eye-off-line fs-22" :
        //         notification_icon.className = "ri-eye-line fs-22";
        //     notification_content.textContent === "Theo dõi" ?
        //         notification_content.innerHTML = "Đang theo dõi" :
        //         notification_content.innerHTML = "Theo dõi";
        // });
        //
        // const due_date_checkbox = document.querySelector('#due_date_checkbox');
        // const due_date_success = document.querySelector('#due_date_success');
        // const due_date_due = document.querySelector('#due_date_due');
        // due_date_checkbox.addEventListener('click', () => {
        //     due_date_due.classList.toggle('d-none');
        //     due_date_success.classList.toggle('d-none');
        // });
    </script>
@endif


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // hàm ngăn chặn bị tắt khi người dùng tác động lên dropdown
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', event => {
                event.stopPropagation();
            });
        });
    });
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })


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

</script>

<script>
    $(document).ready(function() {
        // Tắt nút "Gửi" khi trang tải
        $('#sendBtn').prop('disabled', true);

        // Kiểm tra khi người dùng nhập vào ô nhập liệu
        $('#prompt').on('input', function() {
            // Nếu ô nhập không trống, bật nút "Gửi", ngược lại tắt nút
            $('#sendBtn').prop('disabled', $(this).val().trim() === '');
        });

        // Bắt sự kiện khi form được submit
        $('#chatinput-form').on('submit', function(e) {
            e.preventDefault(); // Ngăn chặn form submit mặc định

            // Lấy giá trị từ ô nhập liệu
            let prompt = $('#prompt').val();

            // Nếu ô nhập trống, không làm gì cả
            if (prompt.trim() === '') {
                return; // Không hiển thị alert
            }

            // Disable nút "Gửi" và ô nhập
            $('#sendBtn').prop('disabled', true);
            $('#prompt').prop('disabled', true);

            // Hiển thị tin nhắn của người dùng
            $('#responseBox').append(
                '<div class="user-message" style="text-align: right; margin-bottom: 10px;"><span style="background-color: #d1e7dd; padding: 8px 12px; border-radius: 15px; display: inline-block;">' +
                prompt + '</span></div>'
            );
            // Xóa nội dung trong ô nhập liệu
            $('#prompt').val('');

            // Gửi yêu cầu AJAX đến server
            $.ajax({
                url: '/ai-chat', // Route để xử lý yêu cầu
                type: 'GET',
                data: {
                    prompt: prompt
                },
                success: function(response) {
                    // Format response text
                    let formattedResponse = response.response.replace(/\*\*(.*?)\*\*/g,
                        '<strong>$1</strong>');
                    formattedResponse = formattedResponse.replace(/\n/g, '<br>');

                    // Hiển thị phản hồi từ hệ thống
                    $('#responseBox').append(
                        '<div class="system-response" style="text-align: left; margin-bottom: 10px;"><span style="background-color: #ffffff; padding: 8px 12px; border-radius: 15px; display: inline-block;">' +
                        formattedResponse + '</span></div>'
                    );

                    // Cuộn xuống cuối khung chat
                    $('#chat-conversation').scrollTop($('#chat-conversation')[0]
                        .scrollHeight);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Đã có lỗi xảy ra!');
                },
                complete: function() {
                    // Re-enable nút "Gửi" và ô nhập sau khi yêu cầu hoàn tất
                    $('#sendBtn').prop('disabled', false);
                    $('#prompt').prop('disabled', false);
                }
            });
        });
    });
</script>

@yield('script')

</body>

</html>
