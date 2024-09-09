@extends('layouts.master')
@section('main')
    <div class="row mt-3 ms-3 me-3 ">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-left justify-content-between">         
                <ul class="nav nav-pills d-flex justify-content-between align-items-center list-group" id="list-example" style="flex-direction: row !important;">
                    <div id="list-example" class="list-group" style="flex-direction: row !important;">
                        <a class="list-group-item list-group-item-action" href="#list-item-1">Unassigned</a>
                        <a class="list-group-item list-group-item-action" href="#list-item-2">Inprogress</a>
                        <a class="list-group-item list-group-item-action" href="#list-item-3">To do</a>
                        <a class="list-group-item list-group-item-action" href="#list-item-4">Completed</a>
                    </div>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="scrollspy-example mt-0" style="height: 80vh;">
            <div class="card" id="list-item-1">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1">
                            <h6 class="fs-14 text-uppercase fw-semibold mb-0">Unassigned <small
                                    class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                            </h6>
                            <div class="d-flex ms-4">
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                Thay đổi tên</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Thêm thẻ</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Di chuyển danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Lưu trữ danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary mt-3 ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,-50">
                                <i class="ri-add-line align-bottom me-1"></i>Add Task</button>
                            </button>
                            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                <form>
                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                            placeholder="Nhập tên thẻ..." />
                                    </div>
                                    <div class="mb-2 d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary">
                                            Add task
                                        </button>
                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- <div class="col-xxl-5 col-sm-12">
                            <div class="search-box">
                                <input type="text" class="form-control search bg-light border-light"
                                    placeholder="Search task ...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 40px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort">Task</th>
                                    <th class="sort">Assigned To</th>
                                    <th class="sort">Due Date</th>
                                    <th class="sort">Priority</th>
                                    <th class="sort">List</th>
                                    <th class="sort">Comments</th>
                                </tr>
                            </thead>
                            <tbody class="form-check-all big-div">
                                <tr class="small-div" id="drag5" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">
                                                Thẻ công việc a
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                                            data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1" placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="todo">To do</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="">
                                        <a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                                aria-expanded="false" data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>

                                    </td>

                                </tr>
                                <tr class="small-div" id="drag6" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">Thẻ công việc b
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                                            data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1" placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="todo">To do</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>

                                    <td class=""><a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                                aria-expanded="false" data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <div class="d-flex justify-content-end mt-2 me-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev" href="#">
                                    Previous
                                </a>

                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
            <div class="card" id="list-item-2">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1">
                            <h6 class="fs-14 text-uppercase fw-semibold mb-0">Inprogress <small
                                    class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                            </h6>
                            <div class="d-flex ms-4">
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                Thay đổi tên</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Thêm thẻ</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Di chuyển danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Lưu trữ danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary mt-3 ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,-50">
                                <i class="ri-add-line align-bottom me-1"></i>Add Task</button>
                            </button>
                            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                <form>
                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                            placeholder="Nhập tên thẻ..." />
                                    </div>
                                    <div class="mb-2 d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary">
                                            Add task
                                        </button>
                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 40px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>
                                    <th class="sort">Task</th>
                                    <th class="sort">Assigned To</th>
                                    <th class="sort">Due Date</th>
                                    <th class="sort">Priority</th>
                                    <th class="sort">List</th>
                                    <th class="sort">Comments</th>
                                </tr>
                            </thead>
                            <tbody class="form-check-all big-div">
                                <tr class="small-div" id="drag1" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">Thẻ công việc 1
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                                            data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1" placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="todo">To do</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class=""><a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                                aria-expanded="false" data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="small-div" id="drag2" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">Thẻ công việc 2
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                                            data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1" placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="todo">To do</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class=""><a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                                aria-expanded="false" data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>
                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-2 me-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
            <div class="card" id="list-item-3">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1">
                            <h6 class="fs-14 text-uppercase fw-semibold mb-0">To do <small
                                    class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                            </h6>
                            <div class="d-flex ms-4">
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                Thay đổi tên</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Thêm thẻ</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Di chuyển danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Lưu trữ danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary mt-3 ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,-50">
                                <i class="ri-add-line align-bottom me-1"></i>Add Task</button>
                            </button>
                            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                <form>
                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                            placeholder="Nhập tên thẻ..." />
                                    </div>
                                    <div class="mb-2 d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary">
                                            Add task
                                        </button>
                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 40px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>
                                    <th class="sort">Task</th>
                                    <th class="sort">Assigned To</th>
                                    <th class="sort">Due Date</th>
                                    <th class="sort">Priority</th>
                                    <th class="sort">List</th>
                                    <th class="sort">Comments</th>
                                </tr>
                            </thead>
                            <tbody class="form-check-all big-div">
                                <tr class="small-div" id="drag3" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">Thẻ công việc 3
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                                            data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1" placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="todo">To do</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class=""><a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                                aria-expanded="false" data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>
                                    </td>

                                </tr>
                                <tr class="small-div" id="drag4" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">Thẻ công việc 4
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                                            data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1" placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item"
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                        data-bs-placement="top" title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="todo">To do</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class=""><a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>

                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-2 me-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
            <div class="card" id="list-item-4">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1">
                            <h6 class="fs-14 text-uppercase fw-semibold mb-0">Completed <small
                                    class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                            </h6>
                            <div class="d-flex ms-4">
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                Thay đổi tên</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                Thêm thẻ</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Di chuyển danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Sao chép danh sách</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                    class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                Lưu trữ danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3 ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                            aria-expanded="false" data-bs-offset="0,-50">
                            <i class="ri-add-line align-bottom me-1"></i>Add Task</button>

                        </button>
                        <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                            <form>
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                        placeholder="Nhập tên thẻ..." />
                                </div>
                                <div class="mb-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary">
                                        Add task
                                    </button>
                                    <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 40px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>
                                    <th class="sort">Task</th>
                                    <th class="sort">Assigned To</th>
                                    <th class="sort">Due Date</th>
                                    <th class="sort">Priority</th>
                                    <th class="sort">List</th>
                                    <th class="sort">Comments</th>
                                </tr>
                            </thead>
                            <tbody class="form-check-all big-div">
                                <tr class="small-div" id="drag5" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">Thẻ công việc
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href=""
                                                            data-bs-toggle="modal" data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1"
                                                        placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item"
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                        data-bs-placement="top" title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item"
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                        data-bs-placement="top" title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item"
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                        data-bs-placement="top" title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="todo">To do</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class=""><a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>
                                    </td>

                                </tr>
                                <tr class="small-div" id="drag6" draggable="true">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                value="option1">
                                        </div>
                                    </th>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1" data-bs-toggle="modal"
                                                data-bs-target="#detailCardModal">Thẻ công việc
                                            </div>
                                            <div class="flex-shrink-0 ms-4">
                                                <ul class="list-inline tasks-list-menu mb-0">
                                                    <li class="list-inline-item"><a href=""><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a href=""
                                                            data-bs-toggle="modal" data-bs-target="#detailCardModal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteOrder">
                                                            <i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group">
                                            <i class="ri-user-add-line fs-20 ms-2" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                <h5 class="text-center">Thành viên</h5>
                                                <form action="">
                                                    <input type="text" name="" id=""
                                                        class="form-control border-1"
                                                        placeholder="Tìm kiếm thành viên" />

                                                    <!-- thành viên của thẻ -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            thẻ</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item"
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                        data-bs-placement="top" title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>

                                                                <i class="ri-close-line fs-20"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- thành viên của bảng -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên của
                                                            bảng</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item"
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                        data-bs-placement="top" title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Thành viên Không gian làm việc -->
                                                    <div class="mt-3">
                                                        <strong class="fs-14">Thành viên Không gian
                                                            làm
                                                            việc</strong>
                                                        <ul class="" style="list-style: none; margin-left: -32px">
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item"
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                        data-bs-placement="top" title="Nancy">
                                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    </a>
                                                                    <p class="ms-3 mt-3">name</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=""> <a href="javascript: void(0);" class="avatar-group-item">
                                            <input class="form-control" type="date" name=""
                                                id=""></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-utppercase fw-semibold mb-0">
                                                <option value="hign">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                    </td>
                                    <td class="">
                                        <div class="flex-grow-1">
                                            <select class="form-control text-uppercase fw-semibold mb-0">
                                                <option value="unassigned">Unassigned</option>
                                                <option value="todo">To do</option>
                                                <option value="inprogress">Inprogress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </td>

                                    <td class=""><a href="javascript: void(0);">
                                            <button class="btn ms-3" id="dropdownMenuOffset3"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                data-bs-offset="0,-50">
                                                <i class="ri-chat-1-line fs-20"></i></button>
                                            </button>
                                            <div class="dropdown-menu p-3" style="width: 285px"
                                                aria-labelledby="dropdownMenuOffset3">
                                                <form>
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control"
                                                            id="exampleDropdownFormEmail"
                                                            placeholder="Nhập bình luận..." />
                                                    </div>
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            Gửi
                                                        </button>
                                                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </a>

                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-2 me-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
    </div>
    <!--end task-board-->
@endsection

@section('style')
    <style>
        .dropdown-item p {
            overflow-wrap: break-word;
            /* Cho phép xuống dòng */
            white-space: normal;
            /* Cho phép nội dung xuống dòng */
            width: 200%;
            /* Đảm bảo chiều rộng của thẻ p không vượt quá chiều rộng của li */
        }

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
        document.addEventListener('dragstart', function(event) {
            event.dataTransfer.setData('text/plain', event.target.id);
            event.target.style.opacity = '0.5';
        });
        document.addEventListener('dragend', function(event) {
            event.target.style.opacity = '1';
        });

        document.addEventListener('dragover', function(event) {
            event.preventDefault();
        });
        document.addEventListener('drop', function(event) {
            event.preventDefault();
            const id = event.dataTransfer.getData('text');
            const draggableElement = document.getElementById(id);
            let dropzone = event.target;
            console.log("Trying to drop on:", dropzone);

            while (!dropzone.classList.contains('big-div') && dropzone !== document.body) {
                dropzone = dropzone.parentElement;
            }
            if (dropzone.classList.contains('big-div')) {
                dropzone.appendChild(draggableElement);
                console.log("Dropped on:", dropzone);
            } else {
                console.log("Drop failed: Not a valid dropzone");
            }
        });
    </script>

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

        // hàm ngăn chặn bị tắt khi người dùng tác động lên dropdown
        $(document).ready(function() {
            $('.dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });
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
