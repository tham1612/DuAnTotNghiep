<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="enable" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('theme/assets/images/favicon.ico') }}" />
    <!--Swiper slider css-->
    <link href="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Layout config Js -->
    <script src="{{ asset('theme/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('theme/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('theme/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('theme/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            overflow-x: hidden;
        }


        /* Giới hạn chiều cao CKEditor */
        .ck-editor__editable_inline {
            min-height: 100px !important;
            /* Đảm bảo chiều cao giới hạn 150px */


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

    <script>
        const PATH_ROOT = "/theme/";
        document.querySelectorAll('input[type="datetime-local"]').forEach(function(input) {
            input.addEventListener('input', function(event) {
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

    <!-- Lord Icon -->
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>

    <!-- Modal Js -->
    <script src="assets/js/pages/modal.init.js"></script>

    @if (request()->is('b/*'))
        <!-- dragula init js -->
        <script src="{{ asset('theme/assets/libs/dragula/dragula.min.js') }}"></script>
        <!-- dom autoscroll -->
        <script src="{{ asset('theme/assets/libs/dom-autoscroller/dom-autoscroller.min.js') }}"></script>
        {{--            <script src="{{ asset('theme/assets/js/pages/flag-input.init.js') }}"></script> --}}
        <script src="{{ asset('theme/assets/js/pages/project-list.init.js') }}"></script>
        <script src="{{ asset('theme/assets/js/pages/select2.init.js') }}"></script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // hàm ngăn chặn bị tắt khi người dùng tác động lên dropdown
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.addEventListener('click', event => {
                    event.stopPropagation();
                });
            });
        });
        $(document).ready(function() {
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
        setTimeout(function() {
            var alertElement = document.getElementById('notification-messenger');
            if (alertElement) {
                alertElement.style.display = 'none';
            }
        }, 5000);

        $(document).ready(function() {
            // Disable the send button initially
            $('#sendBtn').prop('disabled', true);

            // Lắng nghe sự thay đổi trong ô nhập liệu
            $('#prompt').on('input', function() {
                $('#sendBtn').prop('disabled', $(this).val().trim() === '');
            });

            $('#chatinput-form').on('submit', function(event) {
                event.preventDefault(); // Ngăn chặn hành động gửi biểu mẫu mặc định

                // Lấy giá trị từ ô nhập liệu
                let prompt = $('#prompt').val();


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
                    url: $(this).attr('action'), // URL từ thuộc tính action của form
                    type: 'POST',
                    data: {
                        prompt: prompt,
                        _token: $('input[name="_token"]').val() // Gửi token CSRF
                    },
                    success: function(response) {
                        const responseText = response.chat.response; // Lấy phản hồi từ JSON

                        // Thay thế các dấu ** bằng chữ in đậm và các ký tự xuống dòng bằng <br>
                        let formattedResponse = responseText.replace(/\*\*(.*?)\*\*/g,
                            '<strong>$1</strong>');
                        formattedResponse = formattedResponse.replace(/\n/g, '<br>');

                        // Hiển thị phản hồi từ hệ thống
                        $('#responseBox').append(
                            `<div class="ai-response" style="margin: 10px 0; padding: 10px; background: #f1f1f1; border-radius: 8px;">${formattedResponse}</div>`
                        );

                        // Kiểm tra nếu có tin nhắn người dùng thì ẩn thông điệp mặc định
                        if ($('#responseBox').children('.user-message').length > 0 || $(
                                '#responseBox').children('.ai-response').length > 0) {
                            $('.default-message').hide(); // Ẩn thông điệp
                        }

                        // Cuộn xuống dưới khi có tin nhắn mới
                        $('#chat-conversation').scrollTop($('#chat-conversation')[0]
                            .scrollHeight);

                        // Xóa giá trị input sau khi gửi
                        $('#prompt').val('');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    },
                    complete: function() {
                        // Re-enable nút "Gửi" và ô nhập sau khi yêu cầu hoàn tất
                        $('#sendBtn').prop('disabled', false);
                        $('#prompt').prop('disabled', false);
                    }
                });
            });
            // Thêm sự kiện cho nút xác nhận xóa
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '{{ route('chat.history.destroy') }}', // Đường dẫn tới route xóa
                    type: 'DELETE',
                    success: function(response) {
                        $('#successModal').modal('show'); // Hiển thị modal thành công
                        $('#responseBox').empty(); // Xóa nội dung hiển thị chat
                        $('.default-message').show(); // Hiển thị lại thông điệp mặc định
                        $('#confirmDeleteModal').modal('hide'); // Ẩn modal xác nhận
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                            xhr.responseJSON.error :
                            'Có lỗi xảy ra, vui lòng thử lại.';
                        $('#errorMessage').text(errorMessage); // Cập nhật thông báo lỗi
                        $('#errorModal').modal('show'); // Hiển thị modal lỗi
                    }
                });
            });
        });

        // validate Catalog
        document.addEventListener('DOMContentLoaded', function() {
            const nameCatalogInput = document.getElementById('nameCatalog');
            const btnSubmitCatalog = document.getElementById('btnSubmitCatalog');

            // Kiểm tra trạng thái của input
            function validateCatalogForm() {
                const isNameFilled = nameCatalogInput.value.trim() !== '';
                btnSubmitCatalog.disabled = !isNameFilled; // Vô hiệu hóa nút nếu input trống
            }

            // Lắng nghe sự kiện khi người dùng nhập dữ liệu vào input
            nameCatalogInput.addEventListener('input', validateCatalogForm);


        // Kiểm tra form khi người dùng submit
        function disableButtonOnSubmit(event) {
           // Ngăn gửi biểu mẫu ngay lập tức
            event.preventDefault();
            // Kiểm tra xem nút đã bị vô hiệu hóa chưa
            if (btnSubmitCatalog.disabled) return;
            // Vô hiệu hóa nút
            btnSubmitCatalog.disabled = true;
            // Gửi biểu mẫu ngay lập tức
            event.target.closest('form').submit();
        }
        btnSubmitCatalog.addEventListener('click', disableButtonOnSubmit);
    });
    // validate task
    document.addEventListener('DOMContentLoaded', function() {
        const taskNameInputs = document.querySelectorAll('.taskNameInput');
        const btnSubmitTasks = document.querySelectorAll('.btnSubmitTask');

        taskNameInputs.forEach((input, index) => {
            const btnSubmit = btnSubmitTasks[index];
            
            input.addEventListener('input', function() {
                const isTaskNameFilled = input.value.trim() !== '';
                btnSubmit.disabled = !isTaskNameFilled;
            });

            btnSubmit.addEventListener('click', function(event) {
                disableButtonOnSubmitTask(input.closest('form'), event);
            });
        });

        window.disableButtonOnSubmitTask = function(form, event) {
            const input = form.querySelector('.taskNameInput');
            const btnSubmit = form.querySelector('.btnSubmitTask');
            event.preventDefault();

            if (btnSubmit.disabled) return;

            btnSubmit.disabled = true; 
            form.submit();
        };

    });
</script>

    @yield('script')

</body>

</html>
