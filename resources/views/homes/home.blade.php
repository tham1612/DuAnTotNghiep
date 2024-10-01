@extends('layouts.masterMain')
@section('title')
    Home - TaskFlow
@endsection
@section('main')
    <div class="row" style="padding-top: -2px">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Trang chủ</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Trang chủ</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1">
        <div class="col">
            <div class="card">
                <div class="card-body d-flex">
                    <div class="flex-grow-1">
                        <h4>4751</h4>
                        <h6 class="text-muted fs-13 mb-0">Thành viên</h6>
                    </div>
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-warning-subtle text-warning fs-22 rounded">
                            <i class="ri-upload-2-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="card">
                <div class="card-body d-flex">
                    <div class="flex-grow-1">
                        <h4>3423</h4>
                        <h6 class="text-muted fs-13 mb-0">Tổng Task</h6>
                    </div>
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-success-subtle text-success fs-22 rounded">
                            <i class="ri-remote-control-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="card">
                <div class="card-body d-flex">
                    <div class="flex-grow-1">
                        <h4>354</h4>
                        <h6 class="text-muted fs-13 mb-0">Task hoàn thành</h6>
                    </div>
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-info-subtle text-info fs-22 rounded">
                            <i class="ri-flashlight-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="card">
                <div class="card-body d-flex">
                    <div class="flex-grow-1">
                        <h4>2762</h4>
                        <h6 class="text-muted fs-13 mb-0">Task quá hạn</h6>
                    </div>
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-danger-subtle text-danger fs-22 rounded">
                            <i class="ri-hand-coin-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="card">
                <div class="card-body d-flex">
                    <div class="flex-grow-1">
                        <h4>1585</h4>
                        <h6 class="text-muted fs-13 mb-0">Chưa hoàn thành</h6>
                    </div>
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary fs-22 rounded">
                            <i class="ri-donut-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-xxl-4 col-lg-6">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Search to ICOs...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-3 col-lg-6">
                    <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y"
                        data-range-date="true" placeholder="Select date">
                </div>
                <div class="col-xxl-2 col-lg-4">
                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default2"
                        id="choices-single-default2">
                        <option value="Active">Active</option>
                        <option value="Ended">Ended</option>
                        <option value="Upcoming">Upcoming</option>
                    </select>
                </div>
                <!--end col-->
                <div class="col-xxl-2 col-lg-4">
                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default"
                        id="choices-single-default">
                        <option value="">Select Rating</option>
                        <option value="1">1 star</option>
                        <option value="2">2 star</option>
                        <option value="3">3 star</option>
                        <option value="4">4 star</option>
                        <option value="5">5 star</option>
                    </select>
                </div>
                <!--end col-->
                <div class="col-xxl-1 col-lg-4">
                    <button class="btn btn-primary w-100"><i class="ri-equalizer-line align-bottom me-1"></i>
                        Filters
                    </button>
                </div>
            </div>
            <!--end row-->
        </div>
        <div class="row">
            <div class="col-xxl-5">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Hoạt động sắp tới</h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body pt-0">
                        <ul class="list-group list-group-flush border-dashed">
                            <li class="list-group-item ps-0">
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                            <div class="text-center">
                                                <h5 class="mb-0">25</h5>
                                                <div class="text-muted">Tue</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-muted mt-0 mb-1 fs-13">12:00am -
                                            03:30pm</h5>
                                        <a href="#" class="text-reset fs-14 mb-0">Meeting for
                                            campaign with
                                            sales team</a>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Stine Nielsen">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Jansh Brown">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Dan Gibson">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);">
                                                    <div class="avatar-xxs">
                                                        <span class="avatar-title rounded-circle bg-info text-white">
                                                            5
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </li><!-- end -->
                            <li class="list-group-item ps-0">
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                            <div class="text-center">
                                                <h5 class="mb-0">20</h5>
                                                <div class="text-muted">Wed</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-muted mt-0 mb-1 fs-13">02:00pm -
                                            03:45pm</h5>
                                        <a href="#" class="text-reset fs-14 mb-0">Adding a new
                                            event with
                                            attachments</a>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Frida Bang">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-4.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Malou Silva">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Simon Schmidt">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Tosh Jessen">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-7.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);">
                                                    <div class="avatar-xxs">
                                                        <span class="avatar-title rounded-circle bg-success text-white">
                                                            3
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </li><!-- end -->
                            <li class="list-group-item ps-0">
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                            <div class="text-center">
                                                <h5 class="mb-0">17</h5>
                                                <div class="text-muted">Wed</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-muted mt-0 mb-1 fs-13">04:30pm -
                                            07:15pm</h5>
                                        <a href="#" class="text-reset fs-14 mb-0">Create new
                                            project
                                            Bundling Product</a>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Nina Schmidt">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Stine Nielsen">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Jansh Brown">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                        alt="" class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);">
                                                    <div class="avatar-xxs">
                                                        <span class="avatar-title rounded-circle bg-primary text-white">
                                                            4
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </li><!-- end -->

                        </ul><!-- end -->
                        <div class="align-items-center mt-2 row text-center text-sm-start">
                            <div class="col-sm">
                                <div class="text-muted">Showing<span class="fw-semibold">4</span>
                                    of <span class="fw-semibold">125</span> Results
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <ul
                                    class="pagination pagination-separated pagination-sm justify-content-center justify-content-sm-start mb-0">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link">←</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">→</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div> <!-- end col-->
            <div class="col-xxl-7">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Công việc của tôi</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted"><i
                                                    class="ri-settings-4-line align-middle me-1 fs-15"></i>Settings</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Sửa</a>
                                            <a class="dropdown-item" href="#">Xóa</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body p-0">

                                <div class="align-items-center p-3 justify-content-between d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="text-muted"><span class="fw-semibold">4</span> of <span
                                                class="fw-semibold">10</span> remaining
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success"><i
                                            class="ri-add-line align-middle me-1"></i> Add
                                        Task
                                    </button>
                                </div><!-- end card header -->

                                <div data-simplebar style="max-height: 200px;">
                                    <ul class="list-group list-group-flush border-dashed px-3">
                                        <li class="list-group-item ps-0">
                                            <div class="d-flex align-items-start">
                                                <div class="form-check ps-0 flex-sharink-0">
                                                    <input type="checkbox" class="form-check-input ms-0" id="task_one">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label mb-0 ps-2" for="task_one">Review and
                                                        make
                                                        sure
                                                        nothing slips
                                                        through cracks</label>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <p class="text-muted fs-12 mb-0">15 Sep,
                                                        2021</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item ps-0">
                                            <div class="d-flex align-items-start">
                                                <div class="form-check ps-0 flex-sharink-0">
                                                    <input type="checkbox" class="form-check-input ms-0" id="task_two">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label mb-0 ps-2" for="task_two">Send meeting
                                                        invites
                                                        for sales
                                                        upcampaign</label>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <p class="text-muted fs-12 mb-0">20 Sep,
                                                        2021</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item ps-0">
                                            <div class="d-flex align-items-start">
                                                <div class="form-check flex-sharink-0 ps-0">
                                                    <input type="checkbox" class="form-check-input ms-0" id="task_three">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label mb-0 ps-2" for="task_three">Weekly
                                                        closed
                                                        sales won checking
                                                        with sales team</label>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <p class="text-muted fs-12 mb-0">24 Sep,
                                                        2021</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item ps-0">
                                            <div class="d-flex align-items-start">
                                                <div class="form-check ps-0 flex-sharink-0">
                                                    <input type="checkbox" class="form-check-input ms-0" id="task_four">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label mb-0 ps-2" for="task_four">Add notes
                                                        that
                                                        can
                                                        be viewed from
                                                        the individual view</label>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <p class="text-muted fs-12 mb-0">27 Sep,
                                                        2021</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item ps-0">
                                            <div class="d-flex align-items-start">
                                                <div class="form-check ps-0 flex-sharink-0">
                                                    <input type="checkbox" class="form-check-input ms-0" id="task_five">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label mb-0 ps-2" for="task_five">Move stuff
                                                        to
                                                        another page</label>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <p class="text-muted fs-12 mb-0">27 Sep,
                                                        2021</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item ps-0">
                                            <div class="d-flex align-items-start">
                                                <div class="form-check ps-0 flex-sharink-0">
                                                    <input type="checkbox" class="form-check-input ms-0" id="task_six">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-check-label mb-0 ps-2" for="task_six">Styling
                                                        wireframe
                                                        design and
                                                        documentation for velzon
                                                        admin</label>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <p class="text-muted fs-12 mb-0">27 Sep,
                                                        2021</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul><!-- end ul -->
                                </div>
                                <div class="p-3">
                                    <a href="javascript:void(0);" class="text-muted text-decoration-underline">Show
                                        more...</a>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header border-bottom-dashed align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Hoạt động gần đây</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                        Xem tất cả các hoạt động
                                    </button>
                                </div>
                            </div><!-- end cardheader -->
                            <div class="card-body p-0">
                                <div data-simplebar style="max-height: 260px;" class="p-3">
                                    <div class="acitivity-timeline acitivity-main">
                                        <div class="acitivity-item d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                                    <i class="ri-shopping-cart-2-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Purchase by James Price</h6>
                                                <p class="text-muted mb-1">Product noise
                                                    evolve smartwatch
                                                </p>
                                                <small class="mb-0 text-muted">02:14 PM
                                                    Today</small>
                                            </div>
                                        </div>

                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/users/avatar-2.jpg" alt=""
                                                    class="avatar-xs rounded-circle acitivity-avatar">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Natasha Carey have liked the
                                                    products</h6>
                                                <p class="text-muted mb-1">Allow users to
                                                    like products in
                                                    your WooCommerce store.</p>
                                                <small class="mb-0 text-muted">25 Dec,
                                                    2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-secondary">
                                                        <i class="mdi mdi-sale fs-14"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Today offers by <a
                                                        href="apps-ecommerce-seller-details.html"
                                                        class="link-secondary">Digitech
                                                        Galaxy</a></h6>
                                                <p class="text-muted mb-2">Offer is valid on
                                                    orders of
                                                    Rs.500 Or above for selected products
                                                    only.</p>
                                                <small class="mb-0 text-muted">12 Dec,
                                                    2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-danger-subtle text-danger">
                                                        <i class="ri-bookmark-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Favoried Product</h6>
                                                <p class="text-muted mb-2">Esther James have
                                                    favorited
                                                    product.</p>
                                                <small class="mb-0 text-muted">25 Nov,
                                                    2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-secondary">
                                                        <i class="mdi mdi-sale fs-14"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Flash sale starting <span
                                                        class="text-primary">Tomorrow.</span>
                                                </h6>
                                                <p class="text-muted mb-0">Flash sale by <a href="javascript:void(0);"
                                                        class="link-secondary fw-medium">Zoetic
                                                        Fashion</a>
                                                </p>
                                                <small class="mb-0 text-muted">22 Oct,
                                                    2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-info-subtle text-info">
                                                        <i class="ri-line-chart-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Monthly sales report</h6>
                                                <p class="text-muted mb-2"><span class="text-danger">
                                                        2 days left</span> notification to
                                                    submit the
                                                    monthly sales report. <a href="javascript:void(0);"
                                                        class="link-warning text-decoration-underline">Reports
                                                        Builder</a>
                                                </p>
                                                <small class="mb-0 text-muted">15 Oct</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                                    alt="" class="avatar-xs rounded-circle acitivity-avatar" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Frank Hook Commented</h6>
                                                <p class="text-muted mb-2 fst-italic">" A
                                                    product that has
                                                    reviews is more likable to be sold than
                                                    a product. "</p>
                                                <small class="mb-0 text-muted">26 Aug,
                                                    2021</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->
            </div> <!-- end col-xl-7-->
        </div>
        <!-- end row-->
        <div class="row mb-3">
            <div class="col-xxl-3 col-md-6">
                <div class="card overflow-hidden">
                    <div class="card-body bg-success-subtle">
                        <h5 class="fs-17 text-center mb-0">Gần đến hạn</h5>
                    </div>
                </div>
                <div data-simplebar style="max-height: 500px;">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light rounded">
                                        <img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}"
                                            alt="" class="avatar-xxs" />
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fs-15 mb-1">Tên bảng</h5>
                                    <p class="text-muted mb-2">Tên card</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Xem chi
                                        tiết
                                        <i class="ri-arrow-right-up-line align-bottom"></i></a>
                                </div>
                            </div>
                            <h6 class="text-muted mb-0">Người theo dõi <span
                                    class="badge bg-success-subtle text-secondary"><i class=" ri-eye-line"></i></span>
                            </h6>
                        </div>
                        <div class="card-body border-top border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                    </h6>
                                </div>
                                <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05
                                    ngày
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light rounded">
                                        <img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}"
                                            alt="" class="avatar-xxs" />
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fs-15 mb-1">Tên bảng</h5>
                                    <p class="text-muted mb-2">Tên card</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Xem chi
                                        tiết
                                        <i class="ri-arrow-right-up-line align-bottom"></i></a>
                                </div>
                            </div>
                            <h6 class="text-muted mb-0">Người theo dõi <span
                                    class="badge bg-success-subtle text-secondary"><i class=" ri-eye-line"></i></span>
                            </h6>
                        </div>
                        <div class="card-body border-top border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                    </h6>
                                </div>
                                <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05
                                    ngày
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card overflow-hidden">
                    <div class="card-body bg-danger-subtle">
                        <h5 class="fs-17 text-center mb-0">Quá hạn</h5>
                    </div>
                </div>
                <div data-simplebar style="max-height: 500px;">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light rounded">
                                        <img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}"
                                            alt="" class="avatar-xxs" />
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fs-15 mb-1">Tên bảng</h5>
                                    <p class="text-muted mb-2">Tên card</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Xem chi
                                        tiết
                                        <i class="ri-arrow-right-up-line align-bottom"></i></a>
                                </div>
                            </div>
                            <h6 class="text-muted mb-0">Người theo dõi <span
                                    class="badge bg-success-subtle text-secondary"><i class=" ri-eye-line"></i></span>
                            </h6>
                        </div>
                        <div class="card-body border-top border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                    </h6>
                                </div>
                                <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05
                                    ngày
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card overflow-hidden">
                    <div class="card-body bg-primary-subtle">
                        <h5 class="fs-17 text-center mb-0">Nổi bật</h5>
                    </div>
                </div>
                <div data-simplebar style="max-height: 500px;">
                    @if ($board_star->isEmpty())
                        <p>Không có bảng nào được đánh dấu là nổi bật.</p>
                    @else
                        @foreach ($board_star as $board)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-sm">
                                            <div class="avatar-title bg-light rounded">
                                                @if ($board && $board->image)
                                                    <img src="{{ \Storage::url($board->image) }}" alt=""
                                                        height="32">
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fs-15 mb-1"><a href=""
                                                    class="text-body">{{ \Illuminate\Support\Str::limit($board->name, 30) }}</a>
                                            </h5>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Xem
                                                chi
                                                tiết
                                                <i class="ri-arrow-right-up-line align-bottom"></i></a>
                                        </div>
                                    </div>
                                    <h6 class="text-muted mb-0">Người theo dõi <span
                                            class="badge bg-success-subtle text-secondary">{{ $board->total_followers }}</span>
                                    </h6>
                                </div>
                                <div class="card-body border-top border-top-dashed">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                            </h6>
                                        </div>
                                        <h6 class="flex-shrink-0 text-danger mb-0"><i
                                                class="ri-time-line align-bottom"></i>
                                            05
                                            ngày
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <!--end card-->


            </div>
            <!--end col-->

            <div class="col-xxl-3 col-md-6">
                <div class="card overflow-hidden">
                    <div class="card-body bg-info-subtle">
                        <h5 class="fs-17 text-center mb-0">Các bảng được tạo bởi tôi</h5>
                    </div>
                </div>
                <div data-simplebar style="max-height: 500px;">
                    @if ($boards->isEmpty())
                        <p>Không có bảng nào được đánh dấu là nổi bật.</p>
                    @else
                        @foreach ($boards as $board)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-sm">
                                            <div class="avatar-title bg-light rounded">
                                                @if ($board && $board->image)
                                                    <img src="{{ \Storage::url($board->image) }}" alt=""
                                                        height="32">
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fs-15 mb-1"><a href=""
                                                    class="text-body">{{ \Illuminate\Support\Str::limit($board->name, 30) }}</a>
                                            </h5>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Xem
                                                chi
                                                tiết
                                                <i class="ri-arrow-right-up-line align-bottom"></i></a>
                                        </div>
                                    </div>
                                    <h6 class="text-muted mb-0">Người theo dõi <span
                                            class="badge bg-success-subtle text-secondary">{{ $board->total_followers }}</span>
                                    </h6>
                                </div>
                                <div class="card-body border-top border-top-dashed">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                            </h6>
                                        </div>
                                        <h6 class="flex-shrink-0 text-danger mb-0"><i
                                                class="ri-time-line align-bottom"></i>
                                            05
                                            ngày
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    @endsection
    @section('script')
        <!-- apexcharts -->
        <script src="{{ asset('theme/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Vector map-->
        <script src="{{ asset('theme/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('theme/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

        <!--Swiper slider js-->
        <script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

        <!-- Dashboard init -->
        <script src="{{ asset('theme/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
        <!-- project list init -->
        <script src="{{ asset('theme/assets/js/pages/project-list.init.js') }}"></script>
    @endsection
    @section('styles')
        <!-- jsvectormap css -->
        <link href="{{ asset('theme/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
            type="text/css" />

        <!--Swiper slider css-->
        <link href="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    @endsection
