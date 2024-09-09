@extends('layouts.master')
@section('main')
    <div class="tasks-board mb-3" id="kanbanboard">

        <div class="tasks-list rounded-3 p-2 border" data-value="catalog1">

            <div class="d-flex mb-3 d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        Tên catalog
                        <small class="badge bg-success align-bottom ms-1 totaltask-badge">2</small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">
                                <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                            </span>
                        </a>
                        <!--                    setting list-->
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Thêm thẻ</a>
                            <a class="dropdown-item" href="#">Sao chép danh sách</a>
                            <a class="dropdown-item" href="#">Di chuyển danh sách</a>
                            <a class="dropdown-item" href="#">Theo dõi</a>
                            <a class="dropdown-item" href="#">Lưu Trữ danh sách</a>
                            <a class="dropdown-item" href="#">Lưu trữ tất cả thẻ trong danh sách</a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">

                <div id="unassigned-task" class="tasks">

                    <!-- task item -->
                    <div class="card tasks-box cursor-pointer" data-value="task1">

                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title" data-bs-toggle="modal"
                                    data-bs-target="#detailCardModal">
                                    Tên task
                                </h6>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                Mở thẻ</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Chỉnh sửa nhãn</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Thay đổi thành viên</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Chỉnh sửa ngày</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Lưu trữ</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                                <!-- Ảnh bìa -->
                                <div class="tasks-img rounded"
                                    style="
                              background-image: url('{{ asset('theme/assets/images/small/img-7.jpg') }}');
                            ">
                                </div>
                                <!-- giao việc -->
                                <div class="flex-shrink-0 d-flex align-items-center">
                                    <i class="ri-account-circle-line fs-20 me-2"></i>
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}" alt=""
                                                class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}" alt=""
                                                class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                                <!-- ngày bắt đầu & kết thúc -->
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="ri-calendar-event-line fs-20 me-2"></i>
                                    <span class="badge bg-success text-whites-12">
                                        07 Jan - 30 Jan
                                    </span>
                                </div>
                                <!-- nhãn -->
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <i class="ri-price-tag-3-line fs-20 me-2"></i>
                                    <span class="badge bg-success text-whites-12">
                                        làm nhanh
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex justify-content-end">
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <!-- theo dõi -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                04</a>
                                        </li>
                                        <!-- bình luận -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                19</a>
                                        </li>
                                        <!-- tệp đính kèm -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                02</a>
                                        </li>
                                        <!-- checklist -->
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-checkbox-line align-bottom"></i>
                                                2/4</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!-- end task -->
                    <!--end card-->

                    <div class="card tasks-box" data-value="task2">

                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="fs-15 mb-0 text-truncate task-title">
                                        <a href="apps-tasks-details.html" class="d-block">Velzon - Admin Layout
                                            Design</a>
                                    </h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink12"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink12">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-muted">
                                The dashboard is the front page of the Administration
                                UI.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Layout</span>
                                    <span class="badge bg-primary-subtle text-primary">Admin</span>
                                    <span class="badge bg-primary-subtle text-primary">Dashboard</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Michael">
                                            <img src="{{ asset('theme/assets/images/users/avatar-7.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Anna">
                                            <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 07 Jan,
                                        2022</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                14</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                32</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                05</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end tasks-->
            </div>
            <div class="my-3">
                <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown"
                    aria-expanded="false" data-bs-offset="0,-50">
                    Thêm thẻ
                </button>
                <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
                    <form>
                        <div class="mb-2">
                            <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                placeholder="Nhập tên thẻ..." />
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary">
                                Thêm thẻ
                            </button>
                            <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end tasks-list-->

        <div class="tasks-list rounded-3 p-2 border" data-value="catalog2">

            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        To Do
                        <small class="badge bg-secondary align-bottom ms-1 totaltask-badge">2</small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">Priority<i
                                    class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Priority</a>
                            <a class="dropdown-item" href="#">Date Added</a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                <div id="todo-task" class="tasks">
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="fs-15 mb-0 text-truncate task-title">
                                        <a href="apps-tasks-details.html" class="d-block">Admin Layout Design</a>
                                    </h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink3"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink3">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-muted">
                                Landing page template with clean, minimal and modern
                                design.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Design</span>
                                    <span class="badge bg-primary-subtle text-primary">Website</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                            <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                            <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Herbert">
                                            <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 07 Jan,
                                        2022</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                13</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                52</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                17</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="fs-15 mb-0 text-truncate task-title">
                                        <a href="apps-tasks-details.html" class="d-block">Marketing & Sales</a>
                                    </h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink4"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink4">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-muted">
                                Sales and marketing are two business functions within
                                an organization.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Marketing</span>
                                    <span class="badge bg-primary-subtle text-primary">Business</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Donald">
                                            <img src="{{ asset('theme/assets/images/users/avatar-9.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Thomas">
                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 27 Dec,
                                        2021</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                24</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                10</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                10</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
            </div>
            <div class="my-3">
                <button class="btn btn-soft-info w-100" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                    aria-expanded="false" data-bs-offset="0,-50">
                    Thêm thẻ
                </button>
                <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                    <form>
                        <div class="mb-2">
                            <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                placeholder="Nhập tên thẻ..." />
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary">
                                Thêm thẻ
                            </button>
                            <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end tasks-list-->
        <div class="tasks-list rounded-3 p-2 border">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        Inprogress
                        <small class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">Priority<i
                                    class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Priority</a>
                            <a class="dropdown-item" href="#">Date Added</a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                <div id="inprogress-task" class="tasks">
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <a href="javascript:void(0)" class="text-muted fw-medium fs-14 flex-grow-1">#VL2457</a>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink5"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <h6 class="fs-15 text-truncate task-title">
                                <a href="apps-tasks-details.html" class="text-body d-block">Brand Logo Design</a>
                            </h6>
                            <p class="text-muted">
                                BrandCrowd's brand logo maker allows you to generate
                                and customize stand-out brand logos in minutes.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Logo</span>
                                    <span class="badge bg-primary-subtle text-primary">Design</span>
                                    <span class="badge bg-primary-subtle text-primary">UI/UX</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Michael">
                                            <img src="{{ asset('theme/assets/images/users/avatar-7.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 22 Dec,
                                        2021</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                24</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                10</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                10</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 55%"
                                aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <a href="javascript:void(0)" class="text-muted fw-medium fs-14 flex-grow-1">#VL2743</a>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink6"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink6">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <h6 class="fs-15 text-truncate task-title">
                                <a href="apps-tasks-details.html" class="d-block">Change Old App Icon</a>
                            </h6>
                            <p class="text-muted">
                                Change app icons on Android: How do you change the
                                look of your apps.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Design</span>
                                    <span class="badge bg-primary-subtle text-primary">Website</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                            <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Donald">
                                            <img src="{{ asset('theme/assets/images/users/avatar-9.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 24 Oct,
                                        2021</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                64</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                35</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                23</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
            </div>
            <div class="my-3">
                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                    Add More
                </button>
            </div>
        </div>
        <!--end tasks-list-->
        <div class="tasks-list rounded-3 p-2 border">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        In Reviews
                        <small class="badge bg-info align-bottom ms-1 totaltask-badge">3</small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">Priority<i
                                    class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Priority</a>
                            <a class="dropdown-item" href="#">Date Added</a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                <div id="reviews-task" class="tasks">
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <a href="javascript:void(0)" class="text-muted fw-medium fs-14 flex-grow-1">#VL2453</a>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink7"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink7">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <h6 class="fs-15 text-truncate task-title">
                                <a href="apps-tasks-details.html" class="d-block">Create Product Animations</a>
                            </h6>
                            <div class="tasks-img rounded"
                                style="
                            background-image: url('{{ asset('theme/assets/images/small/img-7.jpg') }}');
                          ">
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Ecommerce</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Anna">
                                            <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 16 Nov,
                                        2021</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                08</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                54</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                28</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <a href="javascript:void(0)" class="text-muted fw-medium fs-14 flex-grow-1">#VL2340</a>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink8"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink8">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <h6 class="fs-15 text-truncate task-title">
                                <a href="apps-tasks-details.html" class="d-block">Product Features Analysis</a>
                            </h6>
                            <p class="text-muted">
                                An essential part of strategic planning is running a
                                product feature analysis.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Product</span>
                                    <span class="badge bg-primary-subtle text-primary">Analysis</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 05 Jan,
                                        2022</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                14</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                31</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                07</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 67%"
                                aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <a href="javascript:void(0)" class="text-muted fw-medium fs-14 flex-grow-1">#VL2462</a>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink9"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink9">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <h6 class="fs-15 text-truncate task-title">
                                <a href="apps-tasks-details.html" class="d-block">Create a Graph of Sketch</a>
                            </h6>
                            <p class="text-muted">
                                To make a pie chart with equal slices create a perfect
                                circle by selecting an Oval Tool.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Sketch</span>
                                    <span class="badge bg-primary-subtle text-primary">Marketing</span>
                                    <span class="badge bg-primary-subtle text-primary">Design</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-4.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Thomas">
                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Herbert">
                                            <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Anna">
                                            <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> 05 Nov,
                                        2021</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                12</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                74</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                37</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
            </div>
            <div class="my-3">
                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                    Add More
                </button>
            </div>
        </div>
        <!--end tasks-list-->
        <div class="tasks-list rounded-3 p-2 border">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        Completed
                        <small class="badge bg-success align-bottom ms-1 totaltask-badge">1</small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">Priority<i
                                    class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Priority</a>
                            <a class="dropdown-item" href="#">Date Added</a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                <div id="completed-task" class="tasks">
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title">
                                    <a href="apps-tasks-details.html" class="d-block">Create a Blog Template UI</a>
                                </h6>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink10"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink10">
                                        <li>
                                            <a class="dropdown-item" href="apps-tasks-details.html"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-muted">
                                Landing page template with clean, minimal and modern
                                design.
                            </p>
                            <div class="mb-3">
                                <div class="d-flex mb-1">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-0">
                                            <span class="text-info">35%</span> of 100%
                                        </h6>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="text-muted fw-medium">3 Day</span>
                                    </div>
                                </div>
                                <div class="progress rounded-3 progress-sm">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 35%"
                                        aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary-subtle text-primary">Design</span>
                                    <span class="badge bg-primary-subtle text-primary">Website</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                            <img src="{{ asset('theme/assets/images/users/avatar-7.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                alt="" class="rounded-circle avatar-xxs" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-0">#VL2451</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="link-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-eye-line align-bottom"></i>
                                                24</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-question-answer-line align-bottom"></i>
                                                10</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted"><i
                                                    class="ri-attachment-2 align-bottom"></i>
                                                10</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
            </div>
            <div class="my-3">
                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                    Add More
                </button>
            </div>
        </div>
        <!--end tasks-list-->

    </div>
    <!--end task-board-->
@endsection

@section('style')
    <style>


        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

        .wrapper {
            width: 100%;
            margin-left: -20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* box-shadow: 0 15px 100px rgba(0, 0, 0, 0.12); */
        }

        .wrapper header {
            /*display: flex;*/
            /*align-items: center;*/
            padding: 25px 30px 10px;
            /*justify-content: space-between;*/
        }

        header .icons {
            display: flex;
        }

        header .icons span {
            height: 38px;
            width: 38px;
            margin: 0 1px;
            cursor: pointer;
            color: #878787;
            text-align: center;
            line-height: 38px;
            font-size: 1.9rem;
            user-select: none;
            border-radius: 50%;
        }

        .icons span:last-child {
            margin-right: -10px;
        }

        header .icons span:hover {
            background: #f2f2f2;
        }

        header .current-date {
            font-size: 1rem;
            font-weight: 500;
            margin-top: 10px;
        }

        .calendar {
            padding: auto;
        }

        .calendar ul {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            text-align: center;
        }

        .calendar .days {
            margin-bottom: 50px;
        }

        .calendar li {
            color: #333;
            width: calc(100% / 7);
            font-size: 15px;
        }

        .calendar .weeks li {
            font-weight: 500;
            cursor: default;
        }

        .calendar .days li {
            z-index: 1;
            cursor: pointer;
            position: relative;
            margin-top: 30px;
        }

        .days li.inactive {
            color: #aaa;
        }

        .days li.active {
            color: #fff;
        }

        .days li::before {
            position: absolute;
            content: "";
            left: 50%;
            top: 50%;
            height: 40px;
            width: 40px;
            z-index: -1;
            border-radius: 5%;
            transform: translate(-50%, -50%);
        }

        .days li.active::before {
            background: #2d50af;
        }

        .days li:not(.active):hover::before {
            background: #f2f2f2;
        }
    </style>
    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dragula/dragula.min.css') }}" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection
@section('script')
    <!-- dragula init js -->
    <script src="{{ asset('theme/assets/libs/dragula/dragula.min.js') }}"></script>

    <!-- dom autoscroll -->
    <script src="{{ asset('theme/assets/libs/dom-autoscroller/dom-autoscroller.min.js') }}"></script>

    <!--taks-kanban-->
    <script src="{{ asset('theme/assets/js/pages/tasks-kanban.init.js') }}"></script>

    <!-- prismjs plugin -->
    <script src="{{ asset('theme/assets/libs/prismjs/prism.js') }}"></script>

    <script src="{{ asset('theme/assets/js/pages/flag-input.init.js') }}"></script>

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

    <script>
        const daysTag = document.querySelector(".days"),
            currentDate = document.querySelector(".current-date"),
            prevNextIcon = document.querySelectorAll(".icons span");

        // getting new date, current year and month
        let date = new Date(),
            currYear = date.getFullYear(),
            currMonth = date.getMonth();

        // storing full name of all months in array
        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];

        const renderCalendar = () => {
            let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
                lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
                lastDayofMonth = new Date(
                    currYear,
                    currMonth,
                    lastDateofMonth
                ).getDay(), // getting last day of month
                lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
            let liTag = "";

            for (let i = firstDayofMonth; i > 0; i--) {
                // creating li of previous month last days
                liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
            }

            for (let i = 1; i <= lastDateofMonth; i++) {
                // creating li of all days of current month
                // adding active class to li if the current day, month, and year matched
                let isToday =
                    i === date.getDate() &&
                    currMonth === new Date().getMonth() &&
                    currYear === new Date().getFullYear() ?
                    "active" :
                    "";
                liTag += `<li class="${isToday}">${i}</li>`;
            }

            for (let i = lastDayofMonth; i < 6; i++) {
                // creating li of next month first days
                liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
            }
            currentDate.innerText =
                `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
            daysTag.innerHTML = liTag;
        };
        renderCalendar();

        prevNextIcon.forEach((icon) => {
            // getting prev and next icons
            icon.addEventListener("click", () => {
                // adding click event on both icons
                // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
                currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

                if (currMonth < 0 || currMonth > 11) {
                    // if current month is less than 0 or greater than 11
                    // creating a new date of current year & month and pass it as date value
                    date = new Date(currYear, currMonth, new Date().getDate());
                    currYear = date.getFullYear(); // updating current year with new date year
                    currMonth = date.getMonth(); // updating current month with new date month
                } else {
                    date = new Date(); // pass the current date as date value
                }
                renderCalendar(); // calling renderCalendar function
            });
        });
    </script>
@endsection
