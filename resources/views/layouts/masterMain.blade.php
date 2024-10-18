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
                        $member_Is_star = session('member_Is_star');
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
    const PATH_ROOT = "/theme/";
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
<script src="{{ asset('theme/assets/libs/glightbox/js/glightbox.min.js') }}"></script>

<!-- fgEmojiPicker js -->
<script src="{{ asset('theme/assets/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>


<!-- notifications init -->
<script src="{{ asset('theme/assets/js/pages/notifications.init.js') }}"></script>

<!-- prismjs plugin -->
<script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>

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
    {{-- xử lý tag   --}}
    <script>
        document.querySelectorAll('.color-box').forEach(box => {
            box.addEventListener('click', function () {
                console.log(123)
                // Xóa lớp 'selected' khỏi tất cả các ô màu
                document.querySelectorAll('.color-box').forEach(b => b.classList.remove('selected-tag'));
                // Thêm lớp 'selected' vào ô màu đang được click
                this.classList.add('selected-tag');
            });
        });

        // Hàm tạo ra ID ngẫu nhiên với độ dài tùy chỉnh
        function generateRandomId(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return result;
        }

        // Gán ID ngẫu nhiên cho mỗi form và thêm thuộc tính data-form-id cho các button
        $('form').each(function () {
            const randomId = generateRandomId(10);
            $(this).attr('id', randomId); // Gán ID cho form
            $(this).find('button').attr('data-form-id', randomId); // Gán data-form-id cho button
        });

        // Hàm chuyển đổi từ RGB sang HEX
        function rgbToHex(rgb) {
            const rgbValues = rgb.match(/\d+/g); // Tách chuỗi RGB thành r, g, b
            const r = parseInt(rgbValues[0]).toString(16).padStart(2, '0');
            const g = parseInt(rgbValues[1]).toString(16).padStart(2, '0');
            const b = parseInt(rgbValues[2]).toString(16).padStart(2, '0');
            return `#${r}${g}${b}`.toUpperCase(); // Trả về mã màu HEX
        }

        // Biến lưu trữ mã màu được chọn, khởi tạo là null
        let selectedColor = null;

        // Gán sự kiện cho phần tử cha
        $('.select-color').on('click', 'div', function (e) {
            e.stopPropagation(); // Ngăn chặn sự kiện nổi bọt
            console.log("Đã click vào ô màu."); // Log để kiểm tra
            // Đảm bảo lấy đúng element chứa màu
            const rgb = $(this).css('background-color'); // Lấy giá trị background-color của div được click

            // Kiểm tra nếu giá trị thực sự là dạng rgb trước khi chuyển sang hex
            if (rgb && rgb.startsWith('rgb')) {
                selectedColor = rgbToHex(rgb); // Chuyển đổi sang mã màu HEX
                console.log('Màu đã chọn (HEX):', selectedColor); // Hiển thị mã màu đã chọn
            } else {
                console.log('Không có màu hợp lệ được chọn.');
            }
        });

        // Sự kiện click cho button tạo thẻ tag
        $('button.create-tag-form').off('click').on('click', function (e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của button

            // Kiểm tra xem người dùng đã chọn màu chưa
            if (!selectedColor) {
                alert('Vui lòng chọn một màu trước khi tạo tag.');
                return; // Ngừng nếu chưa chọn màu
            }

            const formId = $(this).data('form-id'); // Lấy ID của form từ button
            const form = $('#' + formId); // Lấy form theo ID

            // Lấy dữ liệu từ form cụ thể
            const formData = {
                board_id: form.find('input[name="board_id"]').val(),
                name: form.find('input[name="name"]').val(),
                color_code: selectedColor // Sử dụng mã màu đã chọn trước đó
            };

            // Gửi dữ liệu qua AJAX
            $.ajax({
                type: 'POST',
                url: '/tasks/tag/create',
                data: formData,
                success: function (response) {
                    // Đóng dropdown khi AJAX thành công
                    // $('.dropdown-menu').hide();
                    console.log('Tạo tag thành công:', response);
                },
                error: function (error) {
                    console.error('Lỗi:', error);
                }
            });
        });

        // Xử lý sự kiện khi checkbox được chọn
        $('.form-check-input').on('change', function () {
            var data = $(this).val(); // Lấy giá trị tag ID

            $.ajax({
                url: '/tasks/tag/update', // Địa chỉ endpoint của bạn
                type: 'POST',
                data: {
                    data: data,
                },
                success: function (response) {
                    console.log('Checkbox đã được cập nhật:', response);
                    // Xử lý thêm nếu cần
                },
                error: function (xhr, status, error) {
                    console.error('Có lỗi xảy ra:', error);
                }
            });
        });

    </script>

    <script>
        function submitAddCheckList(taskId) {
            var formData = {
                task_id: $('#task_id_' + taskId).val(),
                name: $('#name_' + taskId).val(),
                method: 'POST'
            };
            if (!formData.name.trim()) {
                alert('Tiêu đề không được để trống!');
                return false;
            }
            $.ajax({
                url: `/tasks/checklist/create`,
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log('Task đã được thêm thành công!', response);
                },
                error: function (xhr) {
                    alert('Đã xảy ra lỗi!');
                    console.log(xhr.responseText);
                }
            });

            return false;
        }

        function submitFormCheckList(checklistId) {
            var formData = {
                task_id: $('#task_id_' + checklistId).val(),
                name: $('#name_' + checklistId).val()
            };


            if (!formData.name.trim()) {
                alert('Tiêu đề không được để trống!');
                return false;
            }

            $.ajax({
                url: `/tasks/${checklistId}/checklist`,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    console.log('Task đã được cập nhật thành công!', response);
                },
                error: function (xhr) {
                    alert('Đã xảy ra lỗi!');
                    console.log(xhr.responseText);
                }
            });

            return false;
        }
    </script>

    {{--    call ajax lọc--}}
    <script>
        {{--        $(document).ready(function () {--}}
        {{--            const $form = $('.dropdown-menu');--}}

        {{--            // Hàm debounce để chỉ gửi request khi người dùng dừng thao tác trong một khoảng thời gian--}}
        {{--            function debounce(func, delay) {--}}
        {{--                let timeout;--}}
        {{--                return function (...args) {--}}
        {{--                    clearTimeout(timeout);--}}
        {{--                    timeout = setTimeout(() => func.apply(this, args), delay);--}}
        {{--                };--}}
        {{--            }--}}

        {{--            // Hàm xử lý gửi AJAX khi có thay đổi trên form--}}
        {{--            function handleFormChange() {--}}
        {{--                // Thu thập dữ liệu từ form--}}
        {{--                const formData = $form.serialize(); // Chuyển toàn bộ dữ liệu form thành chuỗi URL-encoded--}}
        {{--                const boardId = $('#board_id').val();--}}
        {{--                const viewType = $('#viewType').val();--}}
        {{--                const updatedFormData = formData + '&board_id=' + encodeURIComponent(boardId) + '&viewType=' + encodeURIComponent(viewType);--}}
        {{--                // Gửi AJAX request lên server--}}
        {{--                $.ajax({--}}
        {{--                    url: `/b/${boardId}/edit`, // Đường dẫn API bạn muốn gửi request--}}
        {{--                    method: 'GET', // Phương thức gửi dữ liệu--}}
        {{--                    data: updatedFormData, // Dữ liệu gửi lên server--}}

        {{--                    success: function (response) {--}}
        {{--                        // Xử lý phản hồi từ server, ví dụ cập nhật giao diện với dữ liệu đã lọc--}}
        {{--                        console.log('Thành công:', response);--}}
        {{--                        // Cập nhật lại giao diện tại đây nếu cần--}}
        {{--                    },--}}
        {{--                    error: function (xhr, status, error) {--}}
        {{--                        console.error('Lỗi:', error);--}}
        {{--                    }--}}
        {{--                });--}}
        {{--            }--}}

        {{--            // Sử dụng hàm debounce để tránh gửi nhiều request liên tục--}}
        {{--            const debouncedHandleFormChange = debounce(handleFormChange, 1000); // Gửi request sau 500ms ngừng thao tác--}}

        {{--            // Lắng nghe các sự kiện thay đổi trên form (input, checkbox, select,...)--}}
        {{--            $form.on('input change', debouncedHandleFormChange);--}}
        {{--        });--}}
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

    // xóa thông báo sau 5s
    setTimeout(function () {
        var alertElement = document.getElementById('notification-messenger');
        if (alertElement) {
            alertElement.style.display = 'none';
            fetch("/forget-session", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        }

    }, 5000);

    $(document).ready(function () {
        // Vô hiệu hóa nút gửi
        $('#sendBtn').prop('disabled', true);

        // Lắng nghe sự thay đổi trong ô nhập liệu
        $('#prompt').on('input', function () {
            $('#sendBtn').prop('disabled', $(this).val().trim() === '');
        });

        $('#chatinput-form').on('submit', function (event) {
            event.preventDefault(); // Ngăn chặn hành động gửi biểu mẫu mặc định

            // Lấy giá trị từ ô nhập liệu
            let prompt = $('#prompt').val();
            // Disable nút "Gửi" và ô nhập
            $('#sendBtn').prop('disabled', true);
            $('#prompt').prop('disabled', true);
            $('#loadingSpinner').show(); // Hiển thị thanh tải

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
                success: function (response) {
                    const responseText = response.chat.response; // Lấy phản hồi từ JSON

                    // Thay thế các dấu ** bằng chữ in đậm và các ký tự xuống dòng bằng <br>
                    let formattedResponse = responseText.replace(/\*\*(.*?)\*\*/g,
                        '<strong>$1</strong>');
                    formattedResponse = formattedResponse.replace(/\n/g, '<br>');
                    $('#loadingSpinner').hide();

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
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                },
                complete: function () {
                    // Re-enable nút "Gửi" và ô nhập sau khi yêu cầu hoàn tất
                    $('#sendBtn').prop('disabled', false);
                    $('#prompt').prop('disabled', false);
                }
            });
        });
        // Thêm sự kiện cho nút xác nhận xóa
        $('#confirmDelete').on('click', function () {
            $.ajax({
                url: '{{ route('chat.history.destroy') }}', // Đường dẫn tới route xóa
                type: 'DELETE',
                success: function (response) {
                    $('#successModal').modal('show'); // Hiển thị modal thành công
                    $('#responseBox').empty(); // Xóa nội dung hiển thị chat
                    $('.default-message').show(); // Hiển thị lại thông điệp mặc định
                    $('#confirmDeleteModal').modal('hide'); // Ẩn modal xác nhận
                },
                error: function (xhr) {
                    const errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                        xhr.responseJSON.error :
                        'Có lỗi xảy ra, vui lòng thử lại.';
                    $('#errorMessage').text(errorMessage); // Cập nhật thông báo lỗi
                    $('#errorModal').modal('show'); // Hiển thị modal lỗi
                }
            });
        });
    });

    // // validate form
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.formItem');

        forms.forEach((form) => {
            const textInput = form.querySelector('input[type="text"]');
            const submitButton = form.querySelector('button[type="submit"]');

            if (textInput && submitButton) {
                // Kiểm tra trạng thái của input để enable/disable button
                textInput.addEventListener('input', function () {
                    const isFilled = textInput.value.trim() !== '';
                    // console.log(`Input value: "${textInput.value}", Is filled: ${isFilled}`);
                    submitButton.disabled = !isFilled;
                });

                // Xử lý khi button được nhấn
                submitButton.addEventListener('click', function (event) {
                    disableButtonOnSubmit(event, textInput, submitButton);
                });
            }
        });

        function disableButtonOnSubmit(event, input, button) {
            event.preventDefault();
            if (button.disabled) return;

            button.disabled = true;
            event.target.closest('form').submit();
            input.value = '';

            setTimeout(() => {
                button.disabled = false;
            }, 3000);
        }
    });


</script>


@yield('script')

</body>

</html>
