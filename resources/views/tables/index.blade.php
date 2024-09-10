
@extends('layouts.master')
@section('title')
    Table - TaskFlow
@endsection
@section('main')
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tr>
                    <th>Thẻ</th>
                    <th>Danh sách</th>
                    <th> Nhãn</th>
                    <th>Thành viên</th>
                    <th></i>Ngày hết hạn</th>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-grow-1 ">Thẻ công việc 1</div>
                            <div class="flex-shrink-0 ms-4">
                                <ul class="list-inline tasks-list-menu mb-0">
                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                            data-bs-target="#createCardDetailModal"><i
                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerButton" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">xin chào</button>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerlabel" data-bs-toggle="modal"
                            data-bs-target="#nhan">
                            <div style="width: 100px;height: 20px; background-color: red; border-radius: 5px;">
                            </div>
                        </button>
                    </td>
                    <td><button type="button" class="btn border-0 bg-transparent" id="triggermember" data-bs-toggle="modal"
                            data-bs-target="#member"> <img src="theme/assets/images/users/0518.png_300.png" width="50px"
                                alt=""></button></td>
                    <td><a href="javascript: void(0);" class="avatar-group-item">
                            <i class="ri-calendar-2-line"><input type="date" name="" id=""></i>
                        </a></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-grow-1 ">Thẻ công việc 1</div>
                            <div class="flex-shrink-0 ms-4">
                                <ul class="list-inline tasks-list-menu mb-0">
                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                            data-bs-target="#createCardDetailModal"><i
                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerButton" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">xin chào</button>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerlabel" data-bs-toggle="modal"
                            data-bs-target="#nhan">
                            <div style="width: 100px;height: 20px; background-color: red; border-radius: 5px;">
                            </div>
                        </button>
                    </td>
                    <td><button type="button" class="btn border-0 bg-transparent" id="triggermember" data-bs-toggle="modal"
                            data-bs-target="#member"> <img src="theme/assets/images/users/0518.png_300.png" width="50px"
                                alt=""></button></td>
                    <td><a href="javascript: void(0);" class="avatar-group-item">
                            <i class="ri-calendar-2-line"><input type="date" name="" id=""></i>
                        </a></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-grow-1 ">Thẻ công việc 1</div>
                            <div class="flex-shrink-0 ms-4">
                                <ul class="list-inline tasks-list-menu mb-0">
                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                            data-bs-target="#createCardDetailModal"><i
                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerButton" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">xin chào</button>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerlabel" data-bs-toggle="modal"
                            data-bs-target="#nhan">
                            <div style="width: 100px;height: 20px; background-color: red; border-radius: 5px;">
                            </div>
                        </button>
                    </td>
                    <td><button type="button" class="btn border-0 bg-transparent" id="triggermember" data-bs-toggle="modal"
                            data-bs-target="#member"> <img src="theme/assets/images/users/0518.png_300.png" width="50px"
                                alt=""></button></td>
                    <td><a href="javascript: void(0);" class="avatar-group-item">
                            <i class="ri-calendar-2-line"><input type="date" name="" id=""></i>
                        </a></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-grow-1 ">Thẻ công việc 1</div>
                            <div class="flex-shrink-0 ms-4">
                                <ul class="list-inline tasks-list-menu mb-0">
                                    <li class="list-inline-item"><a href="" data-bs-toggle="modal"
                                            data-bs-target="#createCardDetailModal"><i
                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerButton"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">xin chào</button>
                    </td>
                    <td>
                        <button type="button" class="btn border-0 bg-transparent" id="triggerlabel"
                            data-bs-toggle="modal" data-bs-target="#nhan">
                            <div style="width: 100px;height: 20px; background-color: red; border-radius: 5px;">
                            </div>
                        </button>
                    </td>
                    <td><button type="button" class="btn border-0 bg-transparent" id="triggermember"
                            data-bs-toggle="modal" data-bs-target="#member"> <img
                                src="theme/assets/images/users/0518.png_300.png" width="50px" alt=""></button>
                    </td>
                    <td><a href="javascript: void(0);" class="avatar-group-item">
                            <i class="ri-calendar-2-line"><input type="date" name="" id=""></i>
                        </a></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Button "Thêm" -->
    <button class="btn btn-primary ms-3" id="themBtn">+Thêm</button>

    <!-- Button "A" và "B" sẽ bị ẩn lúc đầu -->
   <!-- Button "A" mở modal add thẻ -->
<button id="aBtn" class="hidden btn btn-primary" data-bs-toggle="modal"
data-bs-target="#addthe">Thẻ</button>

<!-- Button "B" mở modal add danh sách -->
<button id="bBtn" class="hidden btn btn-primary" data-bs-toggle="modal"
data-bs-target="#addds">Danh sách</button>


    <!-- //modal thẻ -->
    <div class="modal fade" id="createCardDetailModal" tabindex="-1" aria-labelledby="createCardDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="createCardDetailModalLabel">Title Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body container">
                        <form action="#">
                            <div class="row">
                                <div class="col-8 border p-2">
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
                                            <div class="ps-4">
                                                <strong>Thành viên</strong>
                                                <section class="d-flex">
                                                    <!-- thêm thành viên & chia sẻ link bảng -->
                                                    <div
                                                        class="d-flex justify-content-center align-items-center cursor-pointer me-2">
                                                        <div class="col-auto ms-sm-auto">
                                                            <div class="avatar-group" id="newMembar">
                                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Nancy">
                                                                    <img src="theme/assets/images/users/avatar-5.jpg"
                                                                        alt="" class="rounded-circle avatar-xs" />
                                                                </a>
                                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Frank">
                                                                    <img src="theme/assets/images/users/avatar-3.jpg"
                                                                        alt="" class="rounded-circle avatar-xs" />
                                                                </a>
                                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Tonya">
                                                                    <img src="theme/assets/images/users/avatar-10.jpg"
                                                                        alt="" class="rounded-circle avatar-xs" />
                                                                </a>
                                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Thomas">
                                                                    <img src="theme/assets/images/users/avatar-8.jpg"
                                                                        alt="" class="rounded-circle avatar-xs" />
                                                                </a>
                                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Herbert">
                                                                    <img src="theme/assets/images/users/avatar-2.jpg"
                                                                        alt="" class="rounded-circle avatar-xs" />
                                                                </a>

                                                                <button type="button" class="border-0 bg-transparent"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle">
                                                                            +</div>
                                                                    </div>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-md p-4">
                                                                    <form>
                                                                        <div class="mb-2">
                                                                            <label class="form-label"
                                                                                for="exampleDropdownFormEmail">Email
                                                                                address</label>
                                                                            <input type="email" class="form-control"
                                                                                id="exampleDropdownFormEmail"
                                                                                placeholder="email@example.com" />
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label class="form-label"
                                                                                for="exampleDropdownFormPassword">Password</label>
                                                                            <input type="password" class="form-control"
                                                                                id="exampleDropdownFormPassword"
                                                                                placeholder="Password" />
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="rememberdropdownCheck" />
                                                                                <label class="form-check-label"
                                                                                    for="rememberdropdownCheck">Remember
                                                                                    me</label>
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Sign in
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="ps-4">
                                                <strong>Thông báo</strong>
                                                <div class="d-flex align-items-center justify-content-between rounded p-3 text-white cursor-pointer"
                                                    style="height: 30px; background-color: darkgray">
                                                    <i class="ri-eye-line fs-22"></i>
                                                    <p class="ms-2 mt-3 fs-15">Theo dõi</p>
                                                    <div>
                                                        <i class="ri-check-line fs-22 bg-light ms-2 rounded"
                                                            style="color: black"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ps-4">
                                                <strong>Ngày hết hạn</strong>
                                                <div class="d-flex align-items-center justify-content-between rounded p-3 text-white cursor-pointer"
                                                    style="height: 30px; background-color: darkgray">
                                                    <input type="checkbox" name="" id=""
                                                        class="form-check-input" checked />
                                                    <p class="ms-2 mt-3 fs-15">20:00 28 thg 8</p>

                                                    <span class="badge bg-success ms-2">Hoàn tất</span>
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
                                            <textarea name="" id="" cols="25" rows="5" class="form-control bg-light"
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
                                                                            <span class="badge bg-danger">code
                                                                                khó</span>
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
                                                                                        <img src="theme/assets/images/users/avatar-2.jpg"
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
                                                                            <span class="badge bg-danger">code
                                                                                khó</span>
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
                                                                                        <img src="theme/assets/images/users/avatar-2.jpg"
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
                                                                            <span class="badge bg-danger">code
                                                                                khó</span>
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
                                                                                        <img src="theme/assets/images/users/avatar-2.jpg"
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
                                            <button class="btn btn-outline-dark" style="height: 35px">
                                                Xóa
                                            </button>
                                        </section>
                                        <div class="ps-4">
                                            <div class="progress animated-progress bg-light-subtle" style="height: 20px">
                                                <div class="progress-bar" role="progressbar" style="width: 50%"
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
                                                            <td class="text-end">
                                                                <i class="ri-time-line fs-20 ms-2"></i>
                                                                <i class="ri-user-add-line fs-20 ms-2"></i>
                                                                <i class="ri-more-fill fs-20 ms-2"></i>
                                                            </td>
                                                        </tr>
                                                        <tr class="cursor-pointer addOrUpdate-checklist">
                                                            <td class="col-1">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="cardtableCheck01" />
                                                                </div>
                                                            </td>
                                                            <td colspan="2">
                                                                <form action="" class="w-100"
                                                                    aria-labelledby="checklistItem">
                                                                    <input type="text" name="" id=""
                                                                        class="form-control" placeholder="Thêm mục" />
                                                                    <div class="d-flex mt-3 justify-content-between">
                                                                        <div>
                                                                            <button class="btn btn-primary">Thêm</button>
                                                                            <button
                                                                                class="btn btn-outline-dark disable-checklist">
                                                                                Hủy
                                                                            </button>
                                                                        </div>
                                                                        <div>
                                                                            <i class="ri-time-line fs-20 ms-2"></i>
                                                                            <span>Chỉ định</span>
                                                                            <i class="ri-user-add-line fs-20 ms-2"></i>
                                                                            <span>Ngày hết hạn</span>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button class="btn btn-outline-dark ms-3 display-checklist">
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
                                            <textarea name="" id="" cols="25" rows="5" class="form-control bg-light"
                                                placeholder="Viết bình luận..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 border">
                                    <h5 class="mt-3 mb-3"><strong>Thêm vào thẻ</strong></h5>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-user"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Thành viên
                                            </p>

                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">Thành viên</h5>
                                                    <div class="mb-2">
                                                        <input type="search" class="form-control"
                                                            placeholder="Tìm kiếm tên thành viên" />
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Thành viên của
                                                            thẻ</label>
                                                        <div class="mt-2 mb-2">
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Nancy">
                                                                <img src="theme/assets/images/users/avatar-5.jpg"
                                                                    alt="" class="rounded-circle avatar-xs" /></a>
                                                            <span>Name Member</span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Thành viên của
                                                            bảng</label>
                                                        <div class="mt-2 mb-2">
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-trigger="hover" data-bs-placement="top"
                                                                title="Nancy">
                                                                <img src="theme/assets/images/users/avatar-2.jpg"
                                                                    alt="" class="rounded-circle avatar-xs" /></a>
                                                            <span>Name Member</span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-tag"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Nhãn
                                            </p>

                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">Nhãn</h5>
                                                    <div class="mb-2">
                                                        <input type="search" class="form-control"
                                                            placeholder="Tìm nhãn" />
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="primary_tags" class="d-flex align-items-center">
                                                            <input type="checkbox" name="" id="primary_tags" />
                                                            <span class="bg bg-primary mx-2 rounded p-3 col-11">
                                                            </span>
                                                        </label>
                                                        <br />
                                                        <label for="danger_tags" class="d-flex align-items-center">
                                                            <input type="checkbox" name="" id="danger_tags" />
                                                            <span class="bg bg-danger mx-2 rounded p-3 col-11">
                                                            </span>
                                                        </label>
                                                        <br />
                                                        <label for="success_tags" class="d-flex align-items-center">
                                                            <input type="checkbox" name="" id="success_tags" />
                                                            <span class="bg bg-success mx-2 rounded p-3 col-11">
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <button type="button" class="btn btn-light waves-effect">
                                                        Tạo nhãn mới
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-check-square"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Việc cần làm
                                            </p>
                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">
                                                        Thêm danh sách công việc
                                                    </h5>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Tiêu đề</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Việc cần làm" />
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Sao chép từ mục</label>
                                                        <select name="" id="" class="form-control">
                                                            <option value="1">AAAA</option>
                                                            <option value="2">BBBB</option>
                                                            <option value="3">CCCC</option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-clock"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Ngày
                                            </p>
                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">Ngày</h5>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Ngày bắt đầu</label>
                                                        <input type="date" class="form-control" />
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Ngày kết thúc</label>
                                                        <input type="date" class="form-control" />
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Thiết lập nhắc
                                                            hẹn</label>
                                                        <select name="" id="" class="form-control">
                                                            <option value="1">Trước 1 giờ</option>
                                                            <option value="2">Trước 1 ngày</option>
                                                            <option value="3">Trươc 10 phút</option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-primary waves-effect">
                                                        Lưu
                                                    </button>
                                                    <button type="button" class="btn btn-light waves-effect">
                                                        Gỡ bỏ
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-paperclip"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Đính kèm
                                            </p>
                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">
                                                        Tệp đính kèm
                                                    </h5>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="">Thêm tệp đính
                                                            kèm</label>
                                                        <input type="file" class="form-control" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-map-marker"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Vị trí
                                            </p>
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
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-credit-card"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Ảnh bìa
                                            </p>
                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">Ảnh bìa</h5>
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
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-arrow-circle-right"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Di chuyển
                                            </p>
                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">
                                                        Di chuyển thẻ
                                                    </h5>
                                                    <h5>Chọn đích đến</h5>
                                                    <div class="mb-2">
                                                        <label for="">Bảng thông tin </label>
                                                        <select class="form-select mb-3"
                                                            aria-label="Default select example">
                                                            <option selected>Open this select menu</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="">Danh sách</label>
                                                        <select class="form-select mb-3"
                                                            aria-label="Default select example">
                                                            <option selected>Open this select menu</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-primary waves-effect">
                                                        Di chuyển
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-copy"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Sao chép
                                            </p>
                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">
                                                        Sao chép thẻ
                                                    </h5>
                                                    <div class="mb-2">
                                                        <label for="">Tên </label>
                                                        <input type="text" name="" id=""
                                                            class="form-control" />
                                                    </div>
                                                    <h5>Sao chép đến</h5>
                                                    <div class="mb-2">
                                                        <label for="">Bảng thông tin </label>
                                                        <select class="form-select mb-3"
                                                            aria-label="Default select example">
                                                            <option selected>Open this select menu</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="">Danh sách</label>
                                                        <select class="form-select mb-3"
                                                            aria-label="Default select example">
                                                            <option selected>Open this select menu</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-primary waves-effect">
                                                        Di chuyển
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-chalkboard"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Tạo mẫu
                                            </p>
                                            <div></div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las la-window-restore"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Lưu trữ
                                            </p>
                                            <div></div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white"
                                            style="width: 80%; height: 30px; background-color: darkgray">
                                            <i class="las ri-share-line"></i>
                                            <p class="ms-2 mt-3 fs-15">Chia sẻ</p>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //modal danh sách -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="custom-table">
                        <h3 class="text-center">Thay đổi danh sách</h3>
                        <div class="input-placeholder mb-2">
                            <input type="text" class="form-control" placeholder="Tìm các danh sách">
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">Danh sách A</li>
                            <li class="list-group-item">Danh sách B</li>
                            <li class="list-group-item">Danh sách V</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- //modal nhãn -->
    <div class="modal fade" id="nhan" tabindex="-1" aria-labelledby="a" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <h3 class="text-center mb-4">Nhãn</h3>

                        <div class="form-group  mb-3">
                            <input type="text" class="form-control" placeholder="Tìm nhãn viên">
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="custom-control custom-checkbox mr-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1"></label>
                            </div>
                            <div class="flex-grow-1 bg-success text-white text-center p-2 rounded" style="height:40px;">
                            </div>
                            <div class="ml-3">
                                <button class="btn border-0 bg-transparent"><i
                                        class=" fas fa-pencil-alt text-primary"></i></button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="custom-control custom-checkbox mr-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1"></label>
                            </div>
                            <div class="flex-grow-1 bg-primary text-white text-center p-2 rounded" style="height:40px;">
                            </div>
                            <div class="ml-3">
                                <button class="btn border-0 bg-transparent"><i
                                        class=" fas fa-pencil-alt text-primary"></i></button>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary btn-block mb-2 w-100">Tạo nhãn
                                mới</button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary btn-block w-100 ">Bật chế độ thân
                                thiện với người mù màu</button>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- //modal thành viên -->
    <div class="modal fade" id="member" tabindex="-1" aria-labelledby="a" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <h3 class="text-center mb-4">Thành viên</h3>
                        <div class="form-group  mb-4">
                            <input type="text" class="form-control" placeholder="Tìm kiếm thành viên">
                        </div>
                        <div>Thành viên của thẻ</div>
                        <div class="d-flex mb-3">
                            <img src="theme/assets/images/users/0518.png_300.png" width="50px" alt="">
                            <p>nam </p>
                        </div>
                        <div>Thành viên của bảng</div>
                        <div class="d-flex">
                            <img src="theme/assets/images/users/0518.png_300.png" width="50px" alt="">
                            <p>nam </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page-content -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Velzon.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- //modal add  the -->
    <!-- Modal add the -->
<div class="modal fade" id="addthe" tabindex="-1" aria-labelledby="exampleModaladdthe" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nội dung của modal thêm thẻ -->
                <div>
                    <div>
                        <!-- Tiêu đề căn giữa -->
                        <h2 class="text-center">Thêm Thẻ</h2>

                        <!-- Input với label Tên -->
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Tên</label>
                            <input type="text" class="form-control" id="inputName"
                                placeholder="Nhập tên cho thẻ này">
                        </div>

                        <!-- Label Danh sách và Select -->
                        <div class="mb-3">
                            <label for="selectList" class="form-label">Danh sách</label>
                            <select class="form-select" id="selectList">
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                            </select>
                        </div>

                        <!-- Hai label với checkbox, ngày bắt đầu và ngày kết thúc -->
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkStartDate">
                                    <label class="form-check-label" for="checkStartDate">Ngày bắt
                                        đầu</label>
                                </div>
                                <input type="date" class="form-control mt-2" id="inputStartDate" disabled>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkEndDate">
                                    <label class="form-check-label" for="checkEndDate">Ngày kết thúc</label>
                                </div>
                                <input type="date" class="form-control mt-2" id="inputEndDate" disabled>
                            </div>
                            <button type="button" class="btn btn-primary  mt-3 w-100">Thêm Thẻ</button>
                        </div>

                        <!-- Button thêm thẻ màu xanh dương -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- //modal add ds -->
    <!-- Modal add ds -->
<div class="modal fade" id="addds" tabindex="-1" aria-labelledby="exampleModaladdds" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="text-center">Thêm Danh Sách</h2>

                <!-- Label Vị trí và Select -->
                <div class="mb-3">
                    <label for="selectPosition" class="form-label">Vị trí</label>
                    <select class="form-select" id="selectPosition">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <button type="button" class="btn btn-primary mt-3 w-100">Thêm Danh Sách</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
            data-bs-target="#theme-settings-offcanvas" aria-conthols="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .card-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            padding: 20px;
            display: flex;
            flex-direction: row;
            font-size: 14px;
            width: 100%;
        }

        .card-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            word-break: break-word;
        }

        .card-subtitle {
            font-size: 12px;
            color: #5e6c84;
            margin-bottom: 20px;
        }

        .card-subtitle a {
            color: #0079bf;
            text-decoration: none;
        }

        .card-subtitle a:hover {
            text-decoration: underline;
        }

        .section {
            padding: 0px 0px;
            margin-bottom: 20px;
            margin-right: 80px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .activity-log input[type="text"] {
            width: 90%;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .checklist-item input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
        }

        .title {
            display: inline-block;
            padding: 8px;
            margin-top: 10px;
            background-color: #ebecf0;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            text-align: center;
            width: 100%;
        }

        .sidebar-item {
            margin-bottom: 10px;
        }

        .sidebar-item .btn {
            width: 100%;
            text-align: left;
        }

        .sidebar-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #5e6c84;
        }

        .sidebar-title,
        .section-title {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 12px;
        }

        .sidebar-section {
            margin-bottom: 20px;
        }

        .sidebar-section .btn {
            margin-bottom: 8px;
        }

        textarea:focus {
            outline: none;
            border-color: #0079bf;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection
@section('script')
    <script src="assets/libs/bootsthap/js/bootsthap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Vector map-->
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Dashboard init -->
    <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <script src="assets/fonts/font-fontawesome-ae333ffef2.js"></script>
    <script>
        //danh sách
        document.addEventListener('DOMContentLoaded', function() {
            var triggerButton = document.getElementById('triggerButton');
            var modal = document.getElementById('exampleModal');
            var modalDialog = modal.querySelector('.modal-dialog');

            triggerButton.addEventListener('click', function() {
                var rect = triggerButton.getBoundingClientRect();
                var modalBackdrop = document.querySelector('.modal-backdrop');

                modal.style.display = 'block'; // Hiển thị modal
                modalDialog.style.top = (rect.bottom + window.scrollY + 10) +
                    'px'; // Căn modal ngay dưới nút
                modalDialog.style.left = rect.left + 'px'; // Căn trái với nút
                modalDialog.style.margin = '0'; // Loại bỏ margin mặc định
                modalBackdrop && (modalBackdrop.style.zIndex = '1040'); // Đảm bảo backdrop không chắn modal
            });

            // Đóng modal khi nhấp vào nút đóng
            document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    modal.style.display = 'none'; // Ẩn modal khi nhấp vào nút đóng
                });
            });

            // Đóng modal khi nhấp ra ngoài modal
            document.addEventListener('click', function(event) {
                if (!modal.contains(event.target) && event.target !== triggerButton) {
                    modal.style.display = 'none';
                }
            });
        });
        //nhãn
        document.addEventListener('DOMContentLoaded', function() {
            var triggerButton = document.getElementById('triggerlabel');
            var modal = document.getElementById('nhan');
            var modalDialog = modal.querySelector('.modal-dialog');

            triggerButton.addEventListener('click', function() {
                var rect = triggerButton.getBoundingClientRect();
                var modalBackdrop = document.querySelector('.modal-backdrop');

                modal.style.display = 'block'; // Hiển thị modal
                modalDialog.style.top = (rect.bottom + window.scrollY + 10) +
                    'px'; // Căn modal ngay dưới nút
                modalDialog.style.left = rect.left + 'px'; // Căn trái với nút
                modalDialog.style.margin = '0'; // Loại bỏ margin mặc định
                modalBackdrop && (modalBackdrop.style.zIndex = '1040'); // Đảm bảo backdrop không chắn modal
            });

            // Đóng modal khi nhấp vào nút đóng
            document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    modal.style.display = 'none'; // Ẩn modal khi nhấp vào nút đóng
                });
            });

            // Đóng modal khi nhấp ra ngoài modal
            document.addEventListener('click', function(event) {
                if (!modal.contains(event.target) && event.target !== triggerButton) {
                    modal.style.display = 'none';
                }
            });
        });
        //thành viên
        document.addEventListener('DOMContentLoaded', function() {
            var triggerButton = document.getElementById('triggermember');
            var modal = document.getElementById('member');
            var modalDialog = modal.querySelector('.modal-dialog');

            triggerButton.addEventListener('click', function() {
                var rect = triggerButton.getBoundingClientRect();
                var modalBackdrop = document.querySelector('.modal-backdrop');

                modal.style.display = 'block'; // Hiển thị modal
                modalDialog.style.top = (rect.bottom + window.scrollY + 10) +
                    'px'; // Căn modal ngay dưới nút
                modalDialog.style.left = rect.left + 'px'; // Căn trái với nút
                modalDialog.style.margin = '0'; // Loại bỏ margin mặc định
                modalBackdrop && (modalBackdrop.style.zIndex = '1040'); // Đảm bảo backdrop không chắn modal
            });

            // Đóng modal khi nhấp vào nút đóng
            document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    modal.style.display = 'none'; // Ẩn modal khi nhấp vào nút đóng
                });
            });

            // Đóng modal khi nhấp ra ngoài modal
            document.addEventListener('click', function(event) {
                if (!modal.contains(event.target) && event.target !== triggerButton) {
                    modal.style.display = 'none';
                }
            });
        });


        // Lấy các phần tử button
        const themBtn = document.getElementById('themBtn');
        const aBtn = document.getElementById('aBtn');
        const bBtn = document.getElementById('bBtn');

        // Sự kiện click cho button "Thêm"
        themBtn.addEventListener('click', function() {
            // Ẩn button "Thêm"
            themBtn.classList.add('hidden');
            // Hiển thị button "A" và "B"
            aBtn.classList.remove('hidden');
            bBtn.classList.remove('hidden');
        });
    </script>
@endsection
>>>>>>> 4d02292d6e1b76addb75d466d2c287371f0de58c
