<!-- chi tiết thẻ -->
<div class="modal fade" id="detailCardModal" tabindex="-1" aria-labelledby="detailCardModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-3">

            <div class="modal-header p-3"
                style="
                      height: 150px;
                      object-fit: cover;
                      background-image: url('{{ asset('theme/assets/images/small/img-7.jpg') }}');
                    "
                id="detailCardModalLabel">
                <div></div>
                <button type="button" class="btn-close bg-white" style="margin: -100px -5px 0px 0px"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="row">
                        <div class="col-9 p-2">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Input Border Style -->
                                    <div>
                                        <section class="d-flex mb-2">
                                            <i class="ri-artboard-line fs-22"></i>
                                            <input type="text"
                                                class="form-control border-0 ms-1 fs-18 fw-medium bg-transparent"
                                                id="borderInput" placeholder="Enter your name" />
                                        </section>
                                        <span class="ms-5">trong danh sách ...</span>
                                    </div>
                                </div>
                                <div class="col-12 d-flex mt-3">
                                    <div class="p-3 col-3">
                                        <strong>Thành viên</strong>
                                        <section class="d-flex">
                                            <!-- thêm thành viên & chia sẻ link bảng -->
                                            <div
                                                class="d-flex justify-content-center align-items-center cursor-pointer ">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="Nancy">
                                                            <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs" />
                                                        </a>
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="Frank">
                                                            <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs" />
                                                        </a>
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="Tonya">
                                                            <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs" />
                                                        </a>
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="Thomas">
                                                            <img src="{{ asset('theme/assets/images/users/avatar-8.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs" />
                                                        </a>
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="Herbert">
                                                            <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs" />
                                                        </a>

                                                        <button type="button" class="border-0 bg-transparent"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">

                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="p-3 ">
                                        <strong>Thông báo</strong>
                                        <div class="d-flex align-items-center justify-content-between rounded p-3 text-white cursor-pointer"
                                            style="height: 35px; background-color: #c7c7c7" id="notification">
                                            <i class="ri-eye-line fs-22" id="notification_icon"></i>
                                            <p class="ms-2 mt-3" id="notification_content">Theo dõi</p>
                                            <div class="d-none" id="notification_follow">
                                                <i class="ri-check-line fs-22 bg-light ms-2 rounded "
                                                    style="color: black"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 ">
                                        <strong>Ngày hết hạn</strong>
                                        <div class="d-flex align-items-center justify-content-between rounded p-3 text-white cursor-pointer"
                                            style="height: 35px; background-color: #c7c7c7">
                                            <input type="checkbox" id="due_date_checkbox" class="form-check-input" />
                                            <p class="ms-2 mt-3">20:00 28 thg 8</p>

                                            <span class="badge bg-success ms-2 d-none" id="due_date_success">Hoàn
                                                tất</span>
                                            <span class="badge bg-danger ms-2" id="due_date_due">Quá hạn</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- mô tả -->
                            <div class="row mt-3">
                                <section class="d-flex">
                                    <i class="ri-menu-2-line fs-22"></i>
                                    <p class="fs-18 ms-2 mt-1">Mô tả</p>
                                </section>
                                <div class="ps-4">
                                    <textarea name="" cols="25" rows="5" class="form-control bg-light"
                                        placeholder="Thêm mô tả chi tiết"></textarea>
                                </div>
                            </div>
                            <!-- tệp -->
                            <div class="row mt-3">
                                <section class="d-flex">
                                    <i class="ri-link-m fs-22"></i>
                                    <p class="fs-18 ms-2 mt-1">Tệp đính kèm</p>
                                </section>
                                <div class="ps-4">
                                    <strong>Thẻ tên dự án</strong>
                                    <div class="d-flex flex-wrap row mt-2" style="align-items: start">
                                        <!-- start card -->
                                        <div class="col-6">
                                            <div class="card card-height-100">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column h-100">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted"></p>
                                                            </div>
                                                            <!--                                                            cài đặt thẻ link-->
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-1 align-items-center">
                                                                    <i class="ri-more-fill fs-20 cursor-pointer"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false"></i>
                                                                    <div class="dropdown-menu dropdown-menu-md"
                                                                        style="padding: 15px 15px 0 15px">
                                                                        <h5 class="text-center">Thao tác mục</h5>
                                                                        <p class="mt-2">Chuyển sang thẻ</p>
                                                                        <p>Xóa</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex mb-2 rounded bg-info-subtle p-2">
                                                            <div class="flex-grow-1">
                                                                <h5>Tên thẻ</h5>
                                                                <div class="d-flex">
                                                                    <span class="badge bg-success me-1">giao
                                                                        diện</span>
                                                                    <span class="badge bg-danger">code khó</span>
                                                                </div>
                                                                <div class="mt-3 d-flex justify-content-between">
                                                                    <div class="avatar-group">
                                                                        <a href="javascript: void(0);"
                                                                            class="avatar-group-item border-0"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover"
                                                                            data-bs-placement="top"
                                                                            title="Darline Williams">
                                                                            <div class="avatar-xxs">
                                                                                <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                                                    alt=""
                                                                                    class="rounded-circle img-fluid" />
                                                                            </div>
                                                                        </a>

                                                                    </div>
                                                                    <ul class="link-inline mb-0">
                                                                        <!-- theo dõi -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-eye-line align-bottom"></i>
                                                                                04</a>
                                                                        </li>
                                                                        <!-- bình luận -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-question-answer-line align-bottom"></i>
                                                                                19</a>
                                                                        </li>
                                                                        <!-- tệp đính kèm -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-attachment-2 align-bottom"></i>
                                                                                02</a>
                                                                        </li>
                                                                        <!-- checklist -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-checkbox-line align-bottom"></i>
                                                                                2/4</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                                <div class="card-footer bg-transparent border-top-dashed py-2">
                                                    <div class="flex-grow-1">Tên bảng : Tên list</div>
                                                </div>
                                                <!-- end card footer -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- start card -->
                                        <div class="col-6">
                                            <div class="card card-height-100">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column h-100">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-4"></p>
                                                            </div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-1 align-items-center">
                                                                    menu
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex mb-2 rounded bg-info-subtle p-2">
                                                            <div class="flex-grow-1">
                                                                <h5>Tên thẻ</h5>
                                                                <div class="d-flex">
                                                                    <span class="badge bg-success me-1">giao
                                                                        diện</span>
                                                                    <span class="badge bg-danger">code khó</span>
                                                                </div>
                                                                <div class="mt-3 d-flex justify-content-between">
                                                                    <div class="avatar-group">
                                                                        <a href="javascript: void(0);"
                                                                            class="avatar-group-item"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover"
                                                                            data-bs-placement="top"
                                                                            title="Darline Williams">
                                                                            <div class="avatar-xxs">
                                                                                <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                                                    alt=""
                                                                                    class="rounded-circle img-fluid" />
                                                                            </div>
                                                                        </a>
                                                                        <a href="javascript: void(0);"
                                                                            class="avatar-group-item"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover"
                                                                            data-bs-placement="top"
                                                                            title="Add Members">
                                                                            <div class="avatar-xxs">
                                                                                <div
                                                                                    class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                                                    +
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    <ul class="link-inline mb-0">
                                                                        <!-- theo dõi -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-eye-line align-bottom"></i>
                                                                                04</a>
                                                                        </li>
                                                                        <!-- bình luận -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-question-answer-line align-bottom"></i>
                                                                                19</a>
                                                                        </li>
                                                                        <!-- tệp đính kèm -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-attachment-2 align-bottom"></i>
                                                                                02</a>
                                                                        </li>
                                                                        <!-- checklist -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-checkbox-line align-bottom"></i>
                                                                                2/4</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                                <div class="card-footer bg-transparent border-top-dashed py-2">
                                                    <div class="flex-grow-1">Tên bảng : Tên list</div>
                                                </div>
                                                <!-- end card footer -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- start card -->
                                        <div class="col-6">
                                            <div class="card card-height-100">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column h-100">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-4"></p>
                                                            </div>
                                                            <div class="flex-shrink-0">
                                                                <div class="d-flex gap-1 align-items-center">
                                                                    menu
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex mb-2 rounded bg-info-subtle p-2">
                                                            <div class="flex-grow-1">
                                                                <h5>Tên thẻ</h5>
                                                                <div class="d-flex">
                                                                    <span class="badge bg-success me-1">giao
                                                                        diện</span>
                                                                    <span class="badge bg-danger">code khó</span>
                                                                </div>
                                                                <div class="mt-3 d-flex justify-content-between">
                                                                    <div class="avatar-group">
                                                                        <a href="javascript: void(0);"
                                                                            class="avatar-group-item"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover"
                                                                            data-bs-placement="top"
                                                                            title="Darline Williams">
                                                                            <div class="avatar-xxs">
                                                                                <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                                                    alt=""
                                                                                    class="rounded-circle img-fluid" />
                                                                            </div>
                                                                        </a>
                                                                        <a href="javascript: void(0);"
                                                                            class="avatar-group-item"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-trigger="hover"
                                                                            data-bs-placement="top"
                                                                            title="Add Members">
                                                                            <div class="avatar-xxs">
                                                                                <div
                                                                                    class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                                                    +
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    <ul class="link-inline mb-0">
                                                                        <!-- theo dõi -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-eye-line align-bottom"></i>
                                                                                04</a>
                                                                        </li>
                                                                        <!-- bình luận -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-question-answer-line align-bottom"></i>
                                                                                19</a>
                                                                        </li>
                                                                        <!-- tệp đính kèm -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-attachment-2 align-bottom"></i>
                                                                                02</a>
                                                                        </li>
                                                                        <!-- checklist -->
                                                                        <li class="list-inline-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-muted"><i
                                                                                    class="ri-checkbox-line align-bottom"></i>
                                                                                2/4</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                                <div class="card-footer bg-transparent border-top-dashed py-2">
                                                    <div class="flex-grow-1">Tên bảng : Tên list</div>
                                                </div>
                                                <!-- end card footer -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                    </div>
                                    <div class="ps-4">
                                        <strong>Tệp</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- việc cần làm -->
                            <div class="row mt-3">
                                <section class="d-flex justify-content-between">
                                    <section class="d-flex">
                                        <i class="ri-checkbox-line fs-22"></i>
                                        <p class="fs-18 ms-2 mt-1">Việc cần làm</p>
                                    </section>
                                    <button class="btn btn-outline-dark" style="height: 35px"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Xóa
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                        <h5 class="text-center">Bạn có muốn xóa Việc cần làm</h5>

                                        <p>Danh sách sẽ bị xóa vĩnh viễn và không thể khôi phục</p>

                                        <button class="btn btn-danger w-100">Xóa danh sách công việc</button>
                                    </div>
                                </section>

                                <div class="ps-4">
                                    <div class="progress animated-progress bg-light-subtle" style="height: 20px">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            50%
                                        </div>
                                    </div>
                                    <div class="table-responsive table-hover table-card">
                                        <table class="table table-nowrap mt-4">
                                            <tbody>
                                                <tr class="cursor-pointer">
                                                    <td class="col-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="cardtableCheck01" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p>checklist1</p>
                                                    </td>
                                                    <td class=" d-flex justify-content-end">
                                                        <div>
                                                            <i class="ri-time-line fs-20 ms-2"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false" data-bs-offset="-10,-500"></i>
                                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                <h5 class="text-center">Ngày</h5>
                                                                <form action="">

                                                                    <!-- ngày bắt đầu -->
                                                                    <div>
                                                                        <strong class="fs-14">Ngày bắt đầu</strong>
                                                                        <input type="datetime-local" name=""
                                                                            id=""
                                                                            class="form-control border-0 my-2" />
                                                                    </div>
                                                                    <div>
                                                                        <strong class="fs-14">Ngày kết thúc</strong>
                                                                        <input type="datetime-local" name=""
                                                                            id=""
                                                                            class="form-control border-0 my-2" />
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <strong class="fs-16">Thiết lập nhắc
                                                                            nhỏ</strong>
                                                                        <select name="" id=""
                                                                            class="form-select">
                                                                            <option value="">1 ngày trước
                                                                            </option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mt-3 card">
                                                                        <button class="btn bg-primary text-white">Lưu
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <i class="ri-user-add-line fs-20 ms-2"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"></i>
                                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                <h5 class="text-center">Thành viên</h5>
                                                                <form action="">
                                                                    <input type="text" name=""
                                                                        id="" class="form-control border-1"
                                                                        placeholder="Tìm kiếm thành viên" />

                                                                    <!-- thành viên của thẻ -->
                                                                    <div class="mt-3">
                                                                        <strong class="fs-14">Thành viên của
                                                                            thẻ</strong>
                                                                        <ul class=""
                                                                            style="list-style: none; margin-left: -32px">
                                                                            <li
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="javascript: void(0);"
                                                                                        class="avatar-group-item"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-trigger="hover"
                                                                                        data-bs-placement="top"
                                                                                        title="Nancy">
                                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                                            alt=""
                                                                                            class="rounded-circle avatar-xs" />
                                                                                    </a>
                                                                                    <p class="ms-3 mt-3">vinhpq</p>
                                                                                </div>

                                                                                <i class="ri-close-line fs-20"></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <!-- thành viên của bảng -->
                                                                    <div class="mt-3">
                                                                        <strong class="fs-14">Thành viên của
                                                                            bảng</strong>
                                                                        <ul class=""
                                                                            style="list-style: none; margin-left: -32px">
                                                                            <li
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="javascript: void(0);"
                                                                                        class="avatar-group-item"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-trigger="hover"
                                                                                        data-bs-placement="top"
                                                                                        title="Nancy">
                                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                                            alt=""
                                                                                            class="rounded-circle avatar-xs" />
                                                                                    </a>
                                                                                    <p class="ms-3 mt-3">vinhpq</p>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <!-- Thành viên Không gian làm việc -->
                                                                    <div class="mt-3">
                                                                        <strong class="fs-14">Thành viên Không gian
                                                                            làm
                                                                            việc</strong>
                                                                        <ul class=""
                                                                            style="list-style: none; margin-left: -32px">
                                                                            <li
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="javascript: void(0);"
                                                                                        class="avatar-group-item"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-trigger="hover"
                                                                                        data-bs-placement="top"
                                                                                        title="Nancy">
                                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                                            alt=""
                                                                                            class="rounded-circle avatar-xs" />
                                                                                    </a>
                                                                                    <p class="ms-3 mt-3">vinhpq</p>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <i class="ri-more-fill fs-20 ms-2"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"></i>
                                                            <div class="dropdown-menu dropdown-menu-md"
                                                                style="padding: 15px 15px 0 15px">
                                                                <h5 class="text-center">Thao tác mục</h5>
                                                                <p class="mt-2">Chuyển sang thẻ</p>
                                                                <p>Xóa</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="cursor-pointer addOrUpdate-checklist d-none">
                                                    <td class="col-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" />
                                                        </div>
                                                    </td>
                                                    <td colspan="2">
                                                        <form action="" class="w-100 " aria-labelledby="">
                                                            <input type="text" name=""
                                                                class="form-control checklistItem"
                                                                placeholder="Thêm mục" />
                                                            <div class="d-flex mt-3 justify-content-between">
                                                                <div>
                                                                    <button class="btn btn-primary">Thêm
                                                                    </button>
                                                                    <button
                                                                        class="btn btn-outline-dark disable-checklist">
                                                                        Hủy
                                                                    </button>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div>
                                                                        <i class="ri-time-line fs-20 ms-2"></i>
                                                                        <span data-bs-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">Ngày hết hạn
                                                                        </span>
                                                                        <div
                                                                            class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                            <h5 class="text-center">Ngày</h5>
                                                                            <form action="">
                                                                                <!-- ngày bắt đầu -->
                                                                                <div>
                                                                                    <strong class="fs-14">Ngày bắt
                                                                                        đầu</strong>
                                                                                    <input type="datetime-local"
                                                                                        name="" id=""
                                                                                        class="form-control border-0 my-2" />
                                                                                </div>
                                                                                <div>
                                                                                    <strong class="fs-14">Ngày kết
                                                                                        thúc</strong>
                                                                                    <input type="datetime-local"
                                                                                        name="" id=""
                                                                                        class="form-control border-0 my-2" />
                                                                                </div>
                                                                                <div class="mt-2">
                                                                                    <strong class="fs-16">Thiết lập
                                                                                        nhắc
                                                                                        nhỏ</strong>
                                                                                    <select name=""
                                                                                        id=""
                                                                                        class="form-select">
                                                                                        <option value="">1 ngày
                                                                                            trước
                                                                                        </option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="mt-3 card">
                                                                                    <button
                                                                                        class="btn bg-primary text-white">
                                                                                        Lưu
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>

                                                                    <div>
                                                                        <i class="ri-user-add-line fs-20 ms-2"></i>
                                                                        <span data-bs-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">Chỉ định
                                                                        </span>
                                                                        <div
                                                                            class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                            <h5 class="text-center">Thành viên</h5>
                                                                            <form action="">
                                                                                <input type="text" name=""
                                                                                    id=""
                                                                                    class="form-control border-0"
                                                                                    placeholder="Tìm kiếm thành viên" />

                                                                                <!-- thành viên của thẻ -->
                                                                                <div class="mt-3">
                                                                                    <strong class="fs-14">Thành viên
                                                                                        của
                                                                                        thẻ</strong>
                                                                                    <ul class=""
                                                                                        style="list-style: none; margin-left: -32px">
                                                                                        <li
                                                                                            class="d-flex justify-content-between align-items-center">
                                                                                            <div
                                                                                                class="d-flex align-items-center">
                                                                                                <a href="javascript: void(0);"
                                                                                                    class="avatar-group-item"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-trigger="hover"
                                                                                                    data-bs-placement="top"
                                                                                                    title="Nancy">
                                                                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                                                        alt=""
                                                                                                        class="rounded-circle avatar-xs" />
                                                                                                </a>
                                                                                                <p class="ms-3 mt-3">
                                                                                                    vinhpq</p>
                                                                                            </div>

                                                                                            <i
                                                                                                class="ri-close-line fs-20"></i>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                                <!-- thành viên của bảng -->
                                                                                <div class="mt-3">
                                                                                    <strong class="fs-14">Thành viên
                                                                                        của
                                                                                        bảng</strong>
                                                                                    <ul class=""
                                                                                        style="list-style: none; margin-left: -32px">
                                                                                        <li
                                                                                            class="d-flex justify-content-between align-items-center">
                                                                                            <div
                                                                                                class="d-flex align-items-center">
                                                                                                <a href="javascript: void(0);"
                                                                                                    class="avatar-group-item"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-trigger="hover"
                                                                                                    data-bs-placement="top"
                                                                                                    title="Nancy">
                                                                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                                                        alt=""
                                                                                                        class="rounded-circle avatar-xs" />
                                                                                                </a>
                                                                                                <p class="ms-3 mt-3">
                                                                                                    vinhpq</p>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                                <!-- Thành viên Không gian làm việc -->
                                                                                <div class="mt-3">
                                                                                    <strong class="fs-14">Thành viên
                                                                                        Không
                                                                                        gian làm việc</strong>
                                                                                    <ul class=""
                                                                                        style="list-style: none; margin-left: -32px">
                                                                                        <li
                                                                                            class="d-flex justify-content-between align-items-center">
                                                                                            <div
                                                                                                class="d-flex align-items-center">
                                                                                                <a href="javascript: void(0);"
                                                                                                    class="avatar-group-item"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-trigger="hover"
                                                                                                    data-bs-placement="top"
                                                                                                    title="Nancy">
                                                                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                                                        alt=""
                                                                                                        class="rounded-circle avatar-xs" />
                                                                                                </a>
                                                                                                <p class="ms-3 mt-3">
                                                                                                    vinhpq</p>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-outline-dark ms-3 display-checklist" type="button">
                                        Thêm mục
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <section class="d-flex">
                                    <i class="ri-line-chart-line fs-22"></i>
                                    <p class="fs-18 ms-2 mt-1">Hoạt động</p>
                                </section>
                                <div class="ps-4">
                                    <textarea name="" cols="25" rows="5" class="form-control bg-light"
                                        placeholder="Viết bình luận..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <h5 class="mt-3 mb-3"><strong>Thêm vào thẻ</strong></h5>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-user"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Thành viên
                                    </p>
                                    <!--dropdown thành viên-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">

                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                class="form-control border-1" placeholder="Tìm kiếm thành viên" />

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                data-bs-placement="top" title="Nancy">
                                                                <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt="" class="rounded-circle avatar-xs" />
                                                            </a>
                                                            <p class="ms-3 mt-3">vinhpq</p>
                                                        </div>

                                                        <i class="ri-close-line fs-20"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- thành viên của bảng -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của bảng</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                data-bs-placement="top" title="Nancy">
                                                                <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt="" class="rounded-circle avatar-xs" />
                                                            </a>
                                                            <p class="ms-3 mt-3">vinhpq</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- Thành viên Không gian làm việc -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên Không gian làm việc</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                data-bs-placement="top" title="Nancy">
                                                                <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt="" class="rounded-circle avatar-xs" />
                                                            </a>
                                                            <p class="ms-3 mt-3">vinhpq</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-tag"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Nhãn
                                    </p>
                                    <!--dropdown nhãn-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                        <h5 class="text-center">Nhãn</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                class="form-control border-1" placeholder="Tìm nhãn..." />
                                            <div class="mt-3">
                                                <strong class="fs-14">Nhãn</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="mt-1 d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center w-100">
                                                            <input type="checkbox" name="" id="danger_tags"
                                                                class="form-check-input" />
                                                            <span class="bg bg-danger mx-2 rounded p-3 col-10"> </span>
                                                        </div>
                                                        <i class="ri-pencil-line fs-20"></i>
                                                    </li>
                                                    <li class="mt-1 d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center w-100">
                                                            <input type="checkbox" name="" id="danger_tags"
                                                                class="form-check-input" />
                                                            <span class="bg bg-info mx-2 rounded p-3 col-10"> </span>
                                                        </div>
                                                        <i class="ri-pencil-line fs-20"></i>
                                                    </li>
                                                    <li class="mt-1 d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center w-100">
                                                            <input type="checkbox" name="" id="danger_tags"
                                                                class="form-check-input" />
                                                            <span class="bg bg-success mx-2 rounded p-3 col-10">
                                                            </span>
                                                        </div>
                                                        <i class="ri-pencil-line fs-20"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card">
                                                <button class="btn text-white" style="background-color: #c7c7c7">Tạo
                                                    nhãn
                                                    mới
                                                </button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-check-square"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Việc cần làm
                                    </p>
                                    <!-- dropdown việc cần làm-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                        <form>
                                            <h5 class="mb-3" style="text-align: center">
                                                Thêm danh sách công việc
                                            </h5>
                                            <div class="mt-2">
                                                <label class="form-label" for="">Tiêu đề</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Việc cần làm" />
                                            </div>
                                            <div class="mt-2">
                                                <button class="btn btn-primary">Thêm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-clock"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Ngày
                                    </p>
                                    <!--                                    dropdown ngày-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 200%">
                                        <h5 class="text-center">Ngày</h5>
                                        <form action="">
                                            <!-- lịch -->
                                            <div class="wrapper">
                                                <header
                                                    class="d-flex align-items-center justify-content-between w-100">
                                                    <p class="current-date"></p>
                                                    <div class="icons">
                                                        <span id="prev"
                                                            class="material-symbols-rounded">chevron_left</span>
                                                        <span id="next"
                                                            class="material-symbols-rounded">chevron_right</span>
                                                    </div>
                                                </header>
                                                <div class="calendar">
                                                    <ul class="weeks">
                                                        <li>CN</li>
                                                        <li>T2</li>
                                                        <li>T3</li>
                                                        <li>T4</li>
                                                        <li>T5</li>
                                                        <li>T6</li>
                                                        <li>T7</li>
                                                    </ul>
                                                    <ul class="days"></ul>
                                                </div>
                                            </div>
                                            <!-- ngày bắt đầu -->
                                            <div>
                                                <strong class="fs-14">Ngày bắt đầu</strong>
                                                <input type="datetime-local" name="" id=""
                                                    class="form-control border-0 my-2" />
                                            </div>
                                            <div>
                                                <strong class="fs-14">Ngày kết thúc</strong>
                                                <input type="datetime-local" name="" id=""
                                                    class="form-control border-0 my-2" />
                                            </div>
                                            <div class="mt-2">
                                                <strong class="fs-16">Thiết lập nhắc nhỏ</strong>
                                                <select name="" id="" class="form-select">
                                                    <option value="">1 ngày trước</option>
                                                </select>
                                            </div>

                                            <div class="mt-3 card">
                                                <button class="btn bg-primary text-white">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-paperclip"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Đính kèm
                                    </p>
                                    <!--                                    dropdown tệp đính kèm-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                        <h5 class="text-center">Đính kèm</h5>
                                        <form action="" class=" mt-3">
                                            <strong class="fs-14">Đính kèm tệp từ máy tính của bạn</strong>
                                            <input type="file" name="" id=""
                                                class="form-control mt-2" />

                                            <div class="mt-3">
                                                <strong class="fs-14">Đã xem gần đây</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="mt-1 d-flex justify-content-between align-items-center">
                                                        <i class="ri-artboard-line fs-20"></i>
                                                        <div class="w-100">
                                                            <strong class="ms-2 rounded">Tên thẻ</strong>
                                                            <br />
                                                            <span class="ms-2">Tên bảng - Đã xem 2 giờ trước</span>
                                                        </div>
                                                    </li>
                                                    <li class="mt-2 d-flex justify-content-between align-items-center">
                                                        <i class="ri-artboard-line fs-20"></i>
                                                        <div class="w-100">
                                                            <strong class="ms-2 rounded">Tên thẻ</strong>
                                                            <br />
                                                            <span class="ms-2">Tên bảng - Đã xem 2 giờ trước</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card">
                                                <button class="btn bg-dark-subtle">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-map-marker"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Vị trí
                                    </p>
                                    <!--                                    dropdown vị trí-->
                                    <div class="dropdown-menu dropdown-menu-md p-4">
                                        <form>
                                            <h5 class="mb-3" style="text-align: center">Thêm vị trí</h5>
                                            <div class="mb-2">
                                                <input type="search" class="form-control"
                                                    placeholder="Tìm kiếm vị trí" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-credit-card"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Ảnh bìa
                                    </p>
                                    <!--                                    dropdown ảnh bìa-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                        <form>
                                            <h5 class="mb-3 text-center">Ảnh bìa</h5>
                                            <div class="mb-2">
                                                <label for="">Tải ảnh lên</label>
                                                <input type="file" class="form-control" />
                                            </div>
                                            <div class="mb-2">
                                                <label for="">Tải ảnh lên</label>
                                                <input type="file" class="form-control" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mt-3 mb-3"><strong>Thao tác</strong></h5>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style="height: 30px; background-color: #c7c7c7">
                                    <i class="las la-arrow-circle-right"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Di chuyển
                                    </p>
                                    <!--                                    dropdown di chuyển-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                        <h5 class="text-center">Di chuyển thẻ</h5>
                                        <form>
                                            <strong class="fs-14">Chọn đích đến</strong>
                                            <div class="mt-2">
                                                <strong class="fs-16">Bảng thông tin</strong>
                                                <select name="" id="" class="form-select">
                                                    <option value="">FPT</option>
                                                </select>
                                            </div>
                                            <div class="row mt-2">
                                                <section class="col-8">
                                                    <strong class="fs-16">Danh sách</strong>
                                                    <select name="" id="" class="form-select">
                                                        <option value="">dự án tốt nghiệp</option>
                                                    </select>
                                                </section>
                                                <section class="col-4">
                                                    <strong class="fs-16">Vị trí</strong>
                                                    <select name="" id="" class="form-select">
                                                        <option value="">1</option>
                                                    </select>
                                                </section>
                                            </div>
                                            <button type="button" class="btn btn-primary waves-effect mt-2">
                                                Di chuyển
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-copy"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">
                                        Sao chép
                                    </p>
                                    <!--                                    dropdown sao chép-->
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                        <h5 class="text-center">Sao chép thẻ</h5>
                                        <form action="">
                                            <div>
                                                <strong class="fs-14">Tên</strong>
                                                <input type="text" name="" id=""
                                                    class="form-control border-1 my-2" placeholder="Tên thẻ" />
                                            </div>
                                            <div>
                                                <strong class="fs-14 mt-3">Giữ</strong>
                                                <ul style="list-style: none; margin-left: -32px" class="mt-2">
                                                    <li>
                                                        <input type="checkbox" name="" id=""
                                                            class="form-check-input" />
                                                        <label for="">Danh sách công việc</label>
                                                        <span>(1)</span>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="" id=""
                                                            class="form-check-input" />
                                                        <label for="">Thành viên</label> <span>(1)</span>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="" id=""
                                                            class="form-check-input" />
                                                        <label for="">Tệp đính kèm</label> <span>(1)</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <strong class="fs-14">Sao chép tới...</strong>
                                                <div class="mt-2">
                                                    <strong class="fs-16">Bảng thông tin</strong>
                                                    <select name="" id="" class="form-select">
                                                        <option value="">FPT</option>
                                                    </select>
                                                </div>
                                                <div class="row mt-2">
                                                    <section class="col-8">
                                                        <strong class="fs-16">Danh sách</strong>
                                                        <select name="" id="" class="form-select">
                                                            <option value="">dự án tốt nghiệp</option>
                                                        </select>
                                                    </section>
                                                    <section class="col-4">
                                                        <strong class="fs-16">Vị trí</strong>
                                                        <select name="" id="" class="form-select">
                                                            <option value="">1</option>
                                                        </select>
                                                    </section>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button class="btn bg-primary text-white">Tạo thẻ</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- lưu trữ-->
                            <div class="d-flex mt-3 mb-3 cursor-pointer archiver ">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-window-restore"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Lưu trữ
                                    </p>
                                    <div></div>
                                </div>
                            </div>
                            <!--                            hoàn tác-->
                            <div class="d-flex mt-3 mb-3 cursor-pointer restore-archiver d-none">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las la-window-restore"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Khôi phục
                                    </p>
                                    <div></div>
                                </div>
                            </div>
                            <!--                            xóa vĩnh viễn-->
                            <div class="d-flex mt-3 mb-3 cursor-pointer delete-archiver d-none">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3  w-100"
                                    style=" height: 30px; background-color: red">
                                    <i class="las la-window-restore"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Xóa
                                    </p>
                                    <div></div>
                                </div>
                            </div>

                            <div class="d-flex mt-3 mb-3 cursor-pointer">
                                <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                    style=" height: 30px; background-color: #c7c7c7">
                                    <i class="las ri-share-line"></i>
                                    <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-offset="-40,10">Chia sẻ</p>
                                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                        <h5 class="text-center">Chia sẻ</h5>
                                        <div class="border-bottom mt-3">
                                            <strong class="fs-14">Đường dẫn đến thẻ </strong>
                                            <i class="ri-earth-line fs-20 text-success"></i>
                                            <!--                                            <i class="ri-shield-user-fill fs-20 text-primary"></i>-->
                                            <!--                                            <i class="ri-lock-2-line fs-20 text-danger"></i>-->
                                            <input type="text" value="123" id=""
                                                class="form-control mt-2" readonly />
                                            <p class="mt-2">Hiện mã QR</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
