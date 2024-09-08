@extends('layouts.masterhome')
@section('title')
    dashbroad
@endsection
@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Trang chủ</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Trang
                                chủ</a>
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1">
        <div class="col">
            <div class="card">
                <div class="card-body d-flex">
                    <div class="flex-grow-1">
                        <h4>21</h4>
                        <h6 class="text-muted fs-13 mb-0">Thành viên</h6>
                    </div>
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-warning-subtle text-warning fs-22 rounded">
                            <i class=" ri-user-line"></i>
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
                        <h4>34</h4>
                        <h6 class="text-muted fs-13 mb-0">Tổng Task</h6>
                    </div>
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-success-subtle text-success fs-22 rounded">
                            <i class=" ri-checkbox-multiple-blank-line"></i>
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
                            <i class=" ri-check-line"></i>
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
                            <i class=" ri-error-warning-line"></i>
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
                            <i class=" ri-close-line"></i>
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
                        Filters</button>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <div class="row mb-4">

        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h6 class="card-title mb-0 flex-grow-1">Công việc của tôi</h6>

                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <div data-simplebar style="max-height: 200px;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
<img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
<div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
<li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                            <p class="mb-0 text-muted">Tên task</p>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h6 class="card-title mb-0 flex-grow-1">Bảng tạo bởi tôi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <div data-simplebar style="max-height: 200px;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
<a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
</div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}" alt=""
                                            class="avatar-xs object-fit-cover rounded-circle">
                                        <div class="ms-3 flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="fs-14 mb-1">Tên bảng</h6>
                                            </a>
                                        </div>
                                        <div>
                                            <h6>29/10/2024</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row mb-3">
        <div class="col-xxl-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body bg-success-subtle">
                    <h5 class="fs-17 text-center mb-0">Gần đến hạn</h5>
                </div>
            </div>
            <div data-simplebar style="height: 200px;">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light rounded">
<img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}" alt=""
                                        class="avatar-xxs" />
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
                        <h6 class="text-muted mb-0">Người theo dõi <span class="badge bg-success-subtle text-secondary"><i
                                    class=" ri-eye-line"></i></span></h6>
                    </div>
                    <div class="card-body border-top border-top-dashed">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                </h6>
                            </div>
                            <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05 ngày
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->

        </div>
        <!--end col-->

        <div class="col-xxl-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body bg-danger-subtle">
                    <h5 class="fs-17 text-center mb-0">Quá hạn</h5>
                </div>
            </div>
            <div data-simplebar style="height: 200px;">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light rounded">
                                    <img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}" alt=""
                                        class="avatar-xxs" />
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
                        <h6 class="text-muted mb-0">Người theo dõi <span class="badge bg-success-subtle text-secondary"><i
                                    class=" ri-eye-line"></i></span></h6>
                    </div>
                    <div class="card-body border-top border-top-dashed">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                </h6>
                            </div>
                            <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05 ngày
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->

        </div>
        <!--end col-->

        <div class="col-xxl-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body bg-primary-subtle">
                    <h5 class="fs-17 text-center mb-0">Nổi bật</h5>
                </div>
            </div>
            <div data-simplebar style="height: 200px;">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light rounded">
                                    <img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}" alt=""
                                        class="avatar-xxs" />
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
                        <h6 class="text-muted mb-0">Người theo dõi <span class="badge bg-success-subtle text-secondary"><i
                                    class=" ri-eye-line"></i></span></h6>
                    </div>
                    <div class="card-body border-top border-top-dashed">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                </h6>
</div>
                            <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05 ngày
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light rounded">
                                    <img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}" alt=""
                                        class="avatar-xxs" />
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
                        <h6 class="text-muted mb-0">Người theo dõi <span class="badge bg-success-subtle text-secondary"><i
                                    class=" ri-eye-line"></i></span></h6>
                    </div>
                    <div class="card-body border-top border-top-dashed">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                </h6>
                            </div>
                            <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05 ngày
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light rounded">
                                    <img src="{{ asset('theme/assets/images/svg/crypto-icons/btc.svg') }}" alt=""
                                        class="avatar-xxs" />
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
                        <h6 class="text-muted mb-0">Người theo dõi <span class="badge bg-success-subtle text-secondary"><i
                                    class=" ri-eye-line"></i></span></h6>
                    </div>
                    <div class="card-body border-top border-top-dashed">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><i class="ri-star-fill align-bottom text-warning"></i>
                                </h6>
                            </div>
                            <h6 class="flex-shrink-0 text-danger mb-0"><i class="ri-time-line align-bottom"></i> 05 ngày
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->


        </div>
        <!--end col-->

        <div class="col-xxl-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body bg-info-subtle">
                    <h5 class="fs-17 text-center mb-0">Hoạt động gần đây</h5>
                </div>
            </div>
            <div class="card">
                <div class="card-body" data-simplebar style="height: 300px;">
                    <div class="upcoming-scheduled">
                        <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y"
                            data-deafult-date="today" data-inline-date="true">
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                09
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Development planning</h6>
                            <p class="text-muted mb-0">iTest Factory </p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span></p>
                        </div>
                    </div><!-- end -->
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                12
                            </span>
</div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Design new UI and check sales</h6>
                            <p class="text-muted mb-0">Meta4Systems</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">11:30 <span class="text-uppercase">am</span></p>
                        </div>
                    </div><!-- end -->
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                25
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Weekly catch-up </h6>
                            <p class="text-muted mb-0">Nesta Technologies</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">02:00 <span class="text-uppercase">pm</span></p>
                        </div>
                    </div><!-- end -->
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                27
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">James Bangs (Client) Meeting</h6>
                            <p class="text-muted mb-0">Nesta Technologies</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">03:45 <span class="text-uppercase">pm</span></p>
                        </div>
                    </div><!-- end -->

                    <div class="mt-3 text-center">
                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">View
                            all Events</a>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
            <!--end card-->

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
