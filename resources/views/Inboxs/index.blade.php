@extends('layouts.masterHome')

@section('main')
    <div class="email-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
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
                                        <a class="dropdown-item" href="#" id="mark-all-read">Mark all as
                                            Read</a>
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
                                            <span class="ms-1 d-none d-sm-inline-block">Important</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link fw-semibold" id="pills-social-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-social" type="button" role="tab"
                                            aria-controls="pills-social" aria-selected="false">
                                            <i class="ri-group-fill align-bottom d-inline-block"></i>
                                            <span class="ms-1 d-none d-sm-inline-block">Orther</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link fw-semibold" id="pills-promotions-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-promotions" type="button"
                                            role="tab" aria-controls="pills-promotions" aria-selected="false">
                                            <i class="ri-price-tag-3-fill align-bottom d-inline-block"></i>
                                            <span class="ms-1 d-none d-sm-inline-block">Cleard</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-auto">
                            <div class="text-muted mb-2">1-50 of 154</div>
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

        <div class="email-detail-content">
            <div class="p-4 d-flex flex-column h-100">
                <div class="pb-4 border-bottom border-bottom-dashed">
                    <div class="row">
                        <div class="col">
                            <div class="">
                                <button type="button" class="btn btn-soft-danger btn-icon btn-sm fs-16 close-btn-email"
                                    id="close-btn-email">
                                    <i class="ri-close-fill align-bottom"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="hstack gap-sm-1 align-items-center flex-wrap email-topbar-link">
                                <button type="button"
                                    class="btn btn-ghost-secondary btn-icon btn-sm fs-16 favourite-btn active">
                                    <i class="ri-star-fill align-bottom"></i>
                                </button>
                                <button class="btn btn-ghost-secondary btn-icon btn-sm fs-16">
                                    <i class="ri-printer-fill align-bottom"></i>
                                </button>
                                <button class="btn btn-ghost-secondary btn-icon btn-sm fs-16 remove-mail"
                                    data-remove-id="" data-bs-toggle="modal" data-bs-target="#removeItemModal">
                                    <i class="ri-delete-bin-5-fill align-bottom"></i>
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
                </div>

                <div class="mx-n4 px-4 email-detail-content-scroll" data-simplebar>
                    <div class="mt-4 mb-3">
                        <h5 class="fw-bold email-subject-title">New updates for Skote Theme</h5>
                    </div>

                    <div class="accordion accordion-flush">
                        <!-- end accordion-item -->
                        <div class="accordion-item border-dashed left">
                            <div class="accordion-header">
                                <a role="button" class="btn w-100 text-start px-0 bg-transparent shadow-none"
                                    data-bs-toggle="collapse" href="#email-collapseThree" aria-expanded="true"
                                    aria-controls="email-collapseThree">
                                    <div class="d-flex align-items-center text-muted">
                                        <div class="card-body">
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-4"><i class="bi bi-circle detail-icon"></i>Status
                                                </div>
                                                <div class="col-8 text-end">
                                                    <button class="btn btn-light btn-sm">
                                                        <span class="status_task">TO DO</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-6 detail-label">Assignees</div>
                                                <div class="col-6 text-end">
                                                    <div class="d-flex align-items-center justify-content-end assign">
                                                        <div class="avatar-xxs me-2">
                                                            <img src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                                                alt="" class="img-fluid rounded-circle assign">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-4"><i class="bi bi-calendar detail-icon"></i>Dates
                                                </div>
                                                <div class="col-8 text-end ">
                                                    <span class="date_task">Aug 5 - Aug 6</span>
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-4"><i class="bi bi-flag detail-icon"></i>Priority
                                                </div>
                                                <div class="col-8 text-end text-danger">
                                                    <span class="priority"><i class="bi bi-flag-fill"></i> Urgent</span>
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-4"><i class="bi bi-clock detail-icon"></i>Time
                                                    Estimate</div>
                                                <div class="col-8 text-end text-muted">
                                                    <span class="time_estimate">Empty</span>
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-4"><i class="bi bi-stopwatch detail-icon"></i>Track
                                                    Time</div>
                                                <div class="col-8 text-end">
                                                    <button class="btn btn-link btn-sm p-0 btn-add-time">
                                                        <span class="track_time"><i class="bi bi-play-fill"></i> Add
                                                            time</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-4"><i class="bi bi-tags detail-icon"></i>Tags</div>
                                                <div class="col-8 text-end">
                                                    <span class="tag_task"><i class="bi bi-heart-fill me-1">
                                                        </i>chua lam
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-4"><i
                                                        class="bi bi-diagram-3 detail-icon"></i>Relationships
                                                </div>
                                                <div class="col-8 text-end text-muted relationship">Empty</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div id="email-collapseThree" class="accordion-collapse collapse show">
                                <div class="accordion-body text-body px-0">
                                </div>
                            </div>
                        </div>
                        <!-- end accordion-item -->
                    </div>
                    <!-- end accordion -->
                </div>

                <div class="mt-auto">
                    <form class="mt-2">
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">Reply :</label>
                            <textarea class="form-control border-bottom-0 rounded-top rounded-0 border" id="exampleFormControlTextarea1"
                                rows="3" placeholder="Enter message"></textarea>
                            <div class="bg-light px-2 py-1 rouned-bottom border">
                                <div class="row">
                                    <div class="col">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm py-0 fs-15 btn-light"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Bold"><i
                                                    class="ri-bold align-bottom"></i></button>
                                            <button type="button" class="btn btn-sm py-0 fs-15 btn-light"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Italic"><i
                                                    class="ri-italic align-bottom"></i></button>
                                            <button type="button" class="btn btn-sm py-0 fs-15 btn-light"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Link"><i
                                                    class="ri-link align-bottom"></i></button>
                                            <button type="button" class="btn btn-sm py-0 fs-15 btn-light"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Image"><i
                                                    class="ri-image-2-line align-bottom"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-success"><i
                                                    class="ri-send-plane-2-fill align-bottom"></i></button>
                                            <button type="button"
                                                class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="ri-timer-line text-muted me-1 align-bottom"></i>
                                                        Schedule Send</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end email-detail-content -->
    </div>
    <!-- end email wrapper -->
@endsection


@section('script')
    <!-- ckeditor js -->
    <script src="{{ asset('theme/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <!-- mailbox init -->
    <script src="{{ asset('theme/assets/js/pages/mailbox.init.js') }}"></script>
@endsection
