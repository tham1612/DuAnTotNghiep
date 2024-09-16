@extends('layouts.masterMain')
@section('title')
    Table - TaskFlow
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{--                <div class="card-header">--}}
                {{--                    <h5 class="card-title mb-0">Basic Datatables</h5>--}}
                {{--                </div>--}}
                <div class="card-body">
                    <table id="example"
                           class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>Thẻ</th>
                            <th>Danh sách</th>
                            <th>Nhãn</th>
                            <th>Thành viên</th>
                            <th>Ngày hết hạn</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td data-bs-toggle="modal"
                                data-bs-target="#detailCardModal">Tên thẻ</td>
                            <td class="col-2">
                                <select name="" id="" class="form-select ">
                                    <option value="">Can lam</option>
                                    <option value="">Sap lam</option>
                                    <option value="">Booooo</option>
                                </select>
                            </td>
                            <td>
                                <div id="tag1"
                                     data-bs-toggle="dropdown" aria-expanded="false" class=" cursor-pointer">
                                    <span class="badge bg-danger">Gấp</span>
                                    <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="tag1">
                                        @include('dropdowns.tag')
                                    </div>
                                </div>
                            </td>
                            <td class="col-2">
                                <div id="member1"
                                     data-bs-toggle="dropdown" aria-expanded="false" class=" cursor-pointer">
                                    <div class="avatar-group" id="newMembar">
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                            <img src="{{asset('theme/assets/images/users/avatar-5.jpg')}}" alt=""
                                                 class="rounded-circle avatar-xs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                            <img src="{{asset('theme/assets/images/users/avatar-3.jpg')}}" alt=""
                                                 class="rounded-circle avatar-xs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                            <img src="{{asset('theme/assets/images/users/avatar-10.jpg')}}" alt=""
                                                 class="rounded-circle avatar-xs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Thomas">
                                            <img src="{{asset('theme/assets/images/users/avatar-8.jpg')}}" alt=""
                                                 class="rounded-circle avatar-xs"/>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                           data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="Herbert">
                                            <img src="{{asset('theme/assets/images/users/avatar-2.jpg')}}" alt=""
                                                 class="rounded-circle avatar-xs"/>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="member1">
                                        @include('dropdowns.member')
                                    </div>
                                </div>
                            </td>
                            <td class=" col-2">
                                <input type="datetime-local" name="" id="" class="form-control">
                            </td>

                            <td class="col-1 text-center">
                                <a href="javascript:void(0);" class="text-muted" id="settingTask1"
                                   data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="ri-more-fill"></i></a>
                                <ul class="dropdown-menu" aria-labelledby="settingTask1">
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
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <button class="btn btn-primary"
            data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" data-bs-offset="70,10">
        <i class="ri-add-line me-1"></i>
        Thêm
    </button>
    <div class="dropdown-menu dropdown-menu-end p-3">
        <div class="my-2 cursor-pointer">
            <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-250">Danh sách</p>
            <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                <form>
                    <h5 class="text-center">Thêm danh sách</h5>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                               placeholder="Nhập tên danh sách..."/>
                    </div>
                    <div class="mb-2">
                        <select name="" id="" class="form-select">
                            <option value="">5</option>
                        </select>
                    </div>
                    <div class="mb-2 d-grid ">
                        <button type="submit" class="btn btn-primary">
                            Thêm danh sách
                        </button>
                        {{--                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>--}}
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-2 cursor-pointer">
            <p  data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-280"> Thẻ</p>
            <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                <form>
                    <h5 class="text-center">Thêm thẻ</h5>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="exampleDropdownFormEmail"
                               placeholder="Nhập tên thẻ..."/>
                    </div>
                    <div class="mb-2">
                        <select name="" id="" class="form-select">
                            <option value="">Cần làm</option>
                        </select>
                    </div>
                    <div class="mb-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            Thêm thẻ
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="addCatalog1">

        </div>

    </div>

@endsection

@section('style')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('script')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{asset('theme/assets/js/pages/datatables.init.js')}}"></script>
@endsection
