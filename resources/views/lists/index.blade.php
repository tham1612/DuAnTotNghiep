@extends('layouts.masterMain')
@section('title')
    List - TaskFlow
@endsection
@section('main')
    <div class="row mt-3 ms-3 me-3">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-left justify-content-between">
                <!-- Icon menu -->
                <div class="menu-icon">
                    <i class="ri-menu-line fs-20" id="menuIcon"></i>
                </div>
                <!-- Menu sẽ ẩn ban đầu -->
                <div id="verticalMenu" class="list-group d-none">
                    <a class="list-group-item list-group-item-action" href="#list-item-1">Unassigned</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-2">Inprogress</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-3">To do</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-4">Completed</a>
                </div>
                <button class="btn btn-primary ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                        aria-expanded="false" data-bs-offset="0,-50">
                    <i class="ri-add-line align-bottom me-1"></i>Add Catalog
                </button>
                <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                    <form>
                        <div class="mb-2">
                            <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                   placeholder="Nhập danh sách công việc..."/>
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary">
                                Add Catalog
                            </button>
                            <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div data-simplebar data-bs-target="#list-example" data-bs-offset="0" style="height: 60vh;">
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
                            <button class="btn btn-primary ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-offset="0,-50">
                                <i class="ri-add-line align-bottom me-1"></i>Add Task
                            </button>
                            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                <form>
                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                               placeholder="Nhập tên thẻ..."/>
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
                                <th class="sort">Catalog</th>
                                <th class="sort">Comments</th>
                                <th class="sort"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i></th>
                            </tr>
                            </thead>
                            <tbody class="form-check-all big-div" id="unassigned">
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
                                    </div>
                                </td>
                                <td class="col-2">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <div class="avatar-group">
                                            <a href="javascript:void(0);"
                                               class="avatar-group-item avatarClick"
                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                               data-bs-placement="top" title="Nancy">
                                                <img
                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xs"/>
                                            </a>
                                        </div>
                                    </div>


                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                        @include('dropdowns.member')
                                    </div>
                                </td>


                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td>
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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
                                </td>

                            </tr>
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
                                            Thẻ công việc b
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer">
                                        <i class="ri-user-add-line fs-20 ms-2 userAddIcon" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false"></i>
                                    </div>

                                    <!-- Avatar group sẽ ẩn ban đầu -->
                                    <div class="avatar-group d-none avatarGroup" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <section class="d-flex">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript:void(0);"
                                                           class="avatar-group-item avatarClick"
                                                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                           data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                   class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                               class="avatar-group-item selectUser"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="Nancy">
                                                                <img
                                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt="" class="rounded-circle avatar-xs"/>
                                                            </a>
                                                            <p class="ms-3 mt-3">Nancy</p>
                                                        </div>
                                                        <i class="ri-close-line fs-20 closeIcon"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </td>

                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td>
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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
                            <button class="btn btn-primary ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-offset="0,-50">
                                <i class="ri-add-line align-bottom me-1"></i>Add Task
                            </button>
                            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                <form>
                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                               placeholder="Nhập tên thẻ..."/>
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
                                <th class="sort">Catalog</th>
                                <th class="sort">Comments</th>
                                <th class="sort"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i></th>
                            </tr>
                            </thead>
                            <tbody class="form-check-all big-div" id="improgress">
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
                                            Thẻ công việc 1
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer">
                                        <i class="ri-user-add-line fs-20 ms-2 userAddIcon" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false"></i>
                                    </div>

                                    <!-- Avatar group sẽ ẩn ban đầu -->
                                    <div class="avatar-group d-none avatarGroup" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <section class="d-flex">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript:void(0);"
                                                           class="avatar-group-item avatarClick"
                                                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                           data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu  dropdown-menu-lg p-3 userDropdown">
                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                   class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                               class="avatar-group-item selectUser"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="Nancy">
                                                                <img
                                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt="" class="rounded-circle avatar-xs"/>
                                                            </a>
                                                            <p class="ms-3 mt-3">Nancy</p>
                                                        </div>
                                                        <i class="ri-close-line fs-20 closeIcon"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </td>

                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td>
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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
                                </td>

                            </tr>
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
                                            Thẻ công việc 2
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer">
                                        <i class="ri-user-add-line fs-20 ms-2 userAddIcon" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false"></i>
                                    </div>

                                    <!-- Avatar group sẽ ẩn ban đầu -->
                                    <div class="avatar-group d-none avatarGroup" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <section class="d-flex">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript:void(0);"
                                                           class="avatar-group-item avatarClick"
                                                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                           data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                   class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                               class="avatar-group-item selectUser"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="Nancy">
                                                                <img
                                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt="" class="rounded-circle avatar-xs"/>
                                                            </a>
                                                            <p class="ms-3 mt-3">Nancy</p>
                                                        </div>
                                                        <i class="ri-close-line fs-20 closeIcon"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </td>

                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td>
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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
                            <button class="btn btn-primary ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-offset="0,-50">
                                <i class="ri-add-line align-bottom me-1"></i>Add Task
                            </button>
                            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                <form>
                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                               placeholder="Nhập tên thẻ..."/>
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
                                <th class="sort">Catalog</th>
                                <th class="sort">Comments</th>
                                <th class="sort"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i></th>
                            </tr>
                            </thead>
                            <tbody class="form-check-all big-div" id="to-do">
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
                                            Thẻ công việc 3
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer">
                                        <i class="ri-user-add-line fs-20 ms-2 userAddIcon" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false"></i>
                                    </div>

                                    <!-- Avatar group sẽ ẩn ban đầu -->
                                    <div class="avatar-group d-none avatarGroup" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <section class="d-flex">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript:void(0);"
                                                           class="avatar-group-item avatarClick"
                                                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                           data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                   class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                               class="avatar-group-item selectUser"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="Nancy">
                                                                <img
                                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt="" class="rounded-circle avatar-xs"/>
                                                            </a>
                                                            <p class="ms-3 mt-3">Nancy</p>
                                                        </div>
                                                        <i class="ri-close-line fs-20 closeIcon"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </td>

                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td>
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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
                                </td>

                            </tr>
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
                                            Thẻ công việc 4
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer">
                                        <i class="ri-user-add-line fs-20 ms-2 userAddIcon" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false"></i>
                                    </div>

                                    <!-- Avatar group sẽ ẩn ban đầu -->
                                    <div class="avatar-group d-none avatarGroup" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <section class="d-flex">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript:void(0);"
                                                           class="avatar-group-item avatarClick"
                                                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                           data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                   class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                               class="avatar-group-item selectUser"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="Nancy">
                                                                <img
                                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt=""
                                                                    class="rounded-circle avatar-xs"/>
                                                            </a>
                                                            <p class="ms-3 mt-3">Nancy</p>
                                                        </div>
                                                        <i class="ri-close-line fs-20 closeIcon"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </td>

                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td>
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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
                        <button class="btn btn-primary ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,-50">
                            <i class="ri-add-line align-bottom me-1"></i>Add Task
                        </button>
                        <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                            <form>
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                           placeholder="Nhập tên thẻ..."/>
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
                                <th class="sort">Catalog</th>
                                <th class="sort">Comments</th>
                                <th class="sort"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i></th>
                            </tr>
                            </thead>
                            <tbody class="form-check-all big-div" id="completed">
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
                                            Thẻ công việc 5
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer">
                                        <i class="ri-user-add-line fs-20 ms-2 userAddIcon" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false"></i>
                                    </div>

                                    <!-- Avatar group sẽ ẩn ban đầu -->
                                    <div class="avatar-group d-none avatarGroup" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <section class="d-flex">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript:void(0);"
                                                           class="avatar-group-item avatarClick"
                                                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                           data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                   class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                               class="avatar-group-item selectUser"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="Nancy">
                                                                <img
                                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt=""
                                                                    class="rounded-circle avatar-xs"/>
                                                            </a>
                                                            <p class="ms-3 mt-3">Nancy</p>
                                                        </div>
                                                        <i class="ri-close-line fs-20 closeIcon"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </td>


                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td class="">
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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

                                </td>

                            </tr>
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
                                            Thẻ công việc 6
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <!-- Icon hiển thị ban đầu -->
                                    <div class="d-flex cursor-pointer">
                                        <i class="ri-user-add-line fs-20 ms-2 userAddIcon" data-bs-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false"></i>
                                    </div>

                                    <!-- Avatar group sẽ ẩn ban đầu -->
                                    <div class="avatar-group d-none avatarGroup" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                        <section class="d-flex">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="col-auto ms-sm-auto">
                                                    <div class="avatar-group" id="newMembar">
                                                        <a href="javascript:void(0);"
                                                           class="avatar-group-item avatarClick"
                                                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                           data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Dropdown menu hiển thị thành viên -->
                                    <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                        <h5 class="text-center">Thành viên</h5>
                                        <form action="">
                                            <input type="text" name="" id=""
                                                   class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

                                            <!-- thành viên của thẻ -->
                                            <div class="mt-3">
                                                <strong class="fs-14">Thành viên của thẻ</strong>
                                                <ul class="" style="list-style: none; margin-left: -32px">
                                                    <li class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                               class="avatar-group-item selectUser"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="Nancy">
                                                                <img
                                                                    src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                    alt=""
                                                                    class="rounded-circle avatar-xs"/>
                                                            </a>
                                                            <p class="ms-3 mt-3">Nancy</p>
                                                        </div>
                                                        <i class="ri-close-line fs-20 closeIcon"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </td>

                                <td class=""><a href="javascript: void(0);" class="avatar-group-item">
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
                                                           placeholder="Nhập bình luận..."/>
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
                                <td>
                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                       data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ri-more-fill"></i></a>
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
{{--                    </div>--}}
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
        /* Đặt icon menu */
        .menu-icon {
            cursor: pointer;
            position: relative;
        }

        /* Menu sẽ xuất hiện */
        #verticalMenu {
            position: absolute;
            top: 0px;
            left: 40px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(225, 222, 222, 0.1);
            z-index: 1000;
            width: 200px;
        }

        .list-group-item:hover {
            background-color: #f0f0f0;
        }
    </style>
    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dragula/dragula.min.css') }}"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
@endsection
@section('script')

    <script>
        document.getElementById('menuIcon').addEventListener('click', function () {
            const verticalMenu = document.getElementById('verticalMenu');

            // Toggle hiển thị/ẩn menu
            if (verticalMenu.classList.contains('d-none')) {
                verticalMenu.classList.remove('d-none');
                verticalMenu.classList.add('d-block');
            } else {
                verticalMenu.classList.remove('d-block');
                verticalMenu.classList.add('d-none');
            }
        });

        // Xử lý khi click vào một item trong menu
        document.querySelectorAll('#verticalMenu .list-group-item').forEach(function (item) {
            item.addEventListener('click', function () {
                // Ẩn menu sau khi chọn item
                const verticalMenu = document.getElementById('verticalMenu');
                verticalMenu.classList.remove('d-block');
                verticalMenu.classList.add('d-none');
            });
        });

        // kéo thả
        dragula([
            document.getElementById("unassigned"),
            document.getElementById("improgress"),
            document.getElementById("to-do"),
            document.getElementById("completed")
        ]);
        removeOnSpill: false
            .on("drag", function (el) {
                el.className.replace("ex-moved", "");
            })
            .on("drop", function (el) {
                el.className += "ex-moved";
            })
            .on("over", function (el, container) {
                container.className += "ex-over";
            })
            .on("out", function (el, container) {
                container.className.replace("ex-over", "");
            });

        // Xử lý sự kiện cho mỗi icon được lặp
        document.querySelectorAll('.userAddIcon').forEach(function (icon) {
            icon.addEventListener('click', function () {
                var dropdownMenu = this.closest('td').querySelector('.userDropdown');
                dropdownMenu.classList.toggle('show'); // Hiển thị/ẩn dropdown
            });
        });

        // Xử lý khi chọn thành viên trong dropdown
        document.querySelectorAll('.selectUser').forEach(function (user) {
            user.addEventListener('click', function () {
                var parentTd = this.closest('td');
                var avatarGroup = parentTd.querySelector('.avatarGroup');
                var userAddIcon = parentTd.querySelector('.userAddIcon');
                var dropdownMenu = parentTd.querySelector('.userDropdown');

                // Ẩn icon và dropdown, hiển thị group-avatar
                userAddIcon.style.display = 'none';
                dropdownMenu.classList.remove('show');
                avatarGroup.classList.remove('d-none');
            });
        });

        // Xử lý khi click vào group-avatar để hiện lại dropdown
        document.querySelectorAll('.avatarClick').forEach(function (avatar) {
            avatar.addEventListener('click', function () {
                var dropdownMenu = this.closest('td').querySelector('.userDropdown');
                dropdownMenu.classList.toggle('show'); // Hiển thị/ẩn dropdown
            });
        });
    </script>
@endsection
