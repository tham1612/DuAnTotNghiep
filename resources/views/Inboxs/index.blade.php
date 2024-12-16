@extends('layouts.masterMain')

@section('main')
    @if (session('error'))
        <div class="alert alert-danger custom-alert">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .custom-alert {
            border-radius: 0.5rem;
            padding: 1rem;
            position: relative;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .notification-item {
            display: flex;
            flex-wrap: nowrap;
            padding: 0;
        }

        .col-mail-1 {
            width: auto;
            /* Mở rộng chiều rộng tự động */
            white-space: nowrap;
            /* Đảm bảo nội dung không bị cắt khi vượt quá chiều rộng của div */
            overflow: hidden;
            /* Ẩn nội dung nếu nó vượt quá chiều rộng */
            text-overflow: ellipsis;
            /* Hiển thị dấu ba chấm nếu có nội dung bị che */
        }

        .col-mail-2 {
            margin-left: 20px;
            /* Thay đổi giá trị này nếu cần để tạo khoảng cách giữa các cột */
        }
    </style>
    <div class="email-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <!-- end email-menu-sidebar -->

        <div class="email-content">
            <div class="p-4 pb-0">
                <div class="border-bottom border-bottom-dashed">
                    <div class="row align-items-end mt-3">
                        <div class="col">
                            <div id="mail-filter-navlist">
                                <ul class="nav nav-tabs nav-tabs-custom nav-success gap-1 text-center border-bottom-0"
                                    role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link fw-semibold active" id="pills-primary-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-primary" type="button"
                                            role="tab" aria-controls="pills-primary" aria-selected="true">
                                            <i class="ri-inbox-fill align-bottom d-inline-block"></i>
                                            <span class="ms-1 d-none d-sm-inline-block">Thông báo</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        @php
                            $allNotifications = Auth()
                                ->user()
                                ->notifications()
                                ->get()
                                ->filter(function ($notification) {
                                    // Truy cập trực tiếp đến mảng data, vì Laravel sẽ tự động chuyển đổi JSON thành mảng
                                    $data = $notification->data;

                                    // Kiểm tra xem trường `readed` có tồn tại và giá trị là false
                                    return isset($data['readed']) && $data['readed'] == false;
                                });
                        @endphp
                        <div class="col-auto">
                            <div class="text-muted mb-2">
                                <span
                                    class="notification-index-count-{{ auth()->id() }}">{{ $allNotifications->count() }}</span>
                                thông báo chưa đọc
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-primary" role="tabpanel"
                        aria-labelledby="pills-primary-tab">
                        <div class="message-list-content mx-n4 px-4 message-list-scroll">
                            <div id="elmLoader">
                                <div class="spinner-border text-primary avatar-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <ul class="message-list" id="mail-list"></ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-social" role="tabpanel" aria-labelledby="pills-social-tab">
                        <div class="message-list-content mx-n4 px-4 message-list-scroll">
                            <ul class="message-list" id="social-mail-list"></ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-promotions" role="tabpanel" aria-labelledby="pills-promotions-tab">
                        <div class="message-list-content mx-n4 px-4 message-list-scroll">
                            <ul class="message-list" id="promotions-mail-list"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end email-content -->
    </div>
    <!-- end email wrapper -->
@endsection


@section('script')
    <!-- ckeditor js -->
    <script src="{{ asset('theme/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script>
        var userIdmain = {{ Auth::user()->id }}; // Lấy ID người dùng hiện tại
    </script>
    <!-- mailbox init -->
    <script src="{{ asset('theme/assets/js/pages/mailbox.init.js') }}"></script>
@endsection

@section('title')
    Thông báo - TaskFlow
@endsection
