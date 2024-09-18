@extends('layouts.masterMain')
@section('title')
    Board - TaskFlow
@endsection
@section('main')
    <div class="tasks-board mb-3" id="kanbanboard">
        <div class="tasks-list rounded-3 p-2 border" data-value="catalog1">

            <div class="d-flex mb-3 d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        Catalog 1
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}" alt=""
                                                 class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}" alt=""
                                                 class="rounded-circle avatar-xxs"/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Michael">
                                            <img src="{{ asset('theme/assets/images/users/avatar-7.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Anna">
                                            <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                   placeholder="Nhập tên thẻ..."/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                            <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                            <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Herbert">
                                            <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Donald">
                                            <img src="{{ asset('theme/assets/images/users/avatar-9.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Thomas">
                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                   placeholder="Nhập tên thẻ..."/>
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
                        Catalog 2
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Michael">
                                            <img src="{{ asset('theme/assets/images/users/avatar-7.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                            <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Donald">
                                            <img src="{{ asset('theme/assets/images/users/avatar-9.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Anna">
                                            <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Alexis">
                                            <img src="{{ asset('theme/assets/images/users/avatar-4.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Thomas">
                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Herbert">
                                            <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Anna">
                                            <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                            <img src="{{ asset('theme/assets/images/users/avatar-7.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                            <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                 alt="" class="rounded-circle avatar-xxs"/>
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

        <div class="rounded-3 p-2 bg-info-subtle" style="height: 40px;">
            <div class="d-flex align-items-center cursor-pointer" id="addCatalog"
                 data-bs-toggle="dropdown"
                 aria-expanded="false" data-bs-offset="-7,-30" style="width: 280px">
                <i class="ri-add-line fs-15"></i>
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                    Thêm danh sách
                </h6>
            </div>
            <div class="dropdown-menu p-3" style="width: 300px" aria-labelledby="addCatalog">
                <form>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                               placeholder="Nhập tên thẻ..."/>
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
@endsection

@section('style')
    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dragula/dragula.min.css') }}"/>
@endsection
@section('script')

    <!--taks-kanban-->
    <script src="{{ asset('theme/assets/js/pages/tasks-kanban.init.js') }}"></script>
@endsection
