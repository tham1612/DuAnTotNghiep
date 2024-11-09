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
    </style>
    <div class="email-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <!-- end email-menu-sidebar -->

        <div class="email-content">
            <div class="p-4 pb-0">
                <div class="border-bottom border-bottom-dashed">
                    <div class="row mt-n2 mb-3 mb-sm-0">
                        <div class="col col-sm-auto order-1 d-block d-lg-none">
                            <button type="button" class="btn btn-soft-success btn-icon btn-sm fs-16 email-menu-btn">
                                <i class="ri-menu-2-fill align-bottom"></i>
                            </button>
                        </div>
                        <div class="col-sm order-3 order-sm-2">
                            <div class="hstack gap-sm-1 align-items-center flex-wrap email-topbar-link">
                                <div class="form-check fs-14 m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="checkall">
                                    <label class="form-check-label" for="checkall"></label>
                                </div>
                                <div id="email-topbar-actions">
                                    <div class="hstack gap-sm-1 align-items-center flex-wrap">
                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm fs-16"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                            title="Archive">
                                            <i class="ri-inbox-archive-fill align-bottom"></i>
                                        </button>
                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm fs-16"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                            title="Report Spam">
                                            <i class="ri-error-warning-fill align-bottom"></i>
                                        </button>
                                        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                            title="Trash">
                                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm fs-16"
                                                data-bs-toggle="modal" data-bs-target="#removeItemModal">
                                                <i class="ri-delete-bin-5-fill align-bottom"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="vr align-self-center mx-2"></div>
                                <div class="dropdown">
                                    <button class="btn btn-ghost-secondary btn-icon btn-sm fs-16" type="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-price-tag-3-fill align-bottom"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Support</a>
                                        <a class="dropdown-item" href="#">Freelance</a>
                                        <a class="dropdown-item" href="#">Social</a>
                                        <a class="dropdown-item" href="#">Friends</a>
                                        <a class="dropdown-item" href="#">Family</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-ghost-secondary btn-icon btn-sm fs-16" type="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-more-2-fill align-bottom"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#" id="mark-all-read">Mark all as Read</a>
                                    </div>
                                </div>
                                <div class="alert alert-warning alert-dismissible unreadConversations-alert px-4 fade show "
                                    id="unreadConversations" role="alert">
                                    No Unread Conversations
                                </div>
                            </div>
                        </div>
                        <div class="col-auto order-2 order-sm-3">
                            <div class="d-flex gap-sm-1 email-topbar-link">
                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm fs-16">
                                    <i class="ri-refresh-line align-bottom"></i>
                                </button>
                                <div class="dropdown">
                                    <button class="btn btn-ghost-secondary btn-icon btn-sm fs-16" type="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-more-2-fill align-bottom"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Mark as Unread</a>
                                        <a class="dropdown-item" href="#">Mark as Important</a>
                                        <a class="dropdown-item" href="#">Add to Tasks</a>
                                        <a class="dropdown-item" href="#">Add Star</a>
                                        <a class="dropdown-item" href="#">Mute</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                            $allNotifications = Auth()->user()
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
                            <div class="text-muted mb-2">{{ $allNotifications->count() }} thông báo hiện tại</div>
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
                    <div class="tab-pane fade" id="pills-promotions" role="tabpanel"
                        aria-labelledby="pills-promotions-tab">
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
        var userId = {{ Auth::user()->id }}; // Lấy ID người dùng hiện tại
    </script>
    <!-- mailbox init -->
    <script src="{{ asset('theme/assets/js/pages/mailbox.init.js') }}"></script>
@endsection
