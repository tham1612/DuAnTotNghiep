@extends('layouts.masterMain')
@section('title')
    Table - TaskFlow
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{--                <div class="card-header"> --}}
                {{--                    <h5 class="card-title mb-0">Basic Datatables</h5> --}}
                {{--                </div> --}}
                @if (session('success'))
                    <div class="alert alert-success m-4" id="success-alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-body">
                    <table id="task-list" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thẻ</th>
                            <th>Danh sách</th>
                            <th>Nhãn</th>
                            <th>Thành viên</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày hết hạn</th>
                            <th>Thao tác</th>

                        </tr>
                        </thead>

                        <tbody>
                        @if($tasks)
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td data-bs-toggle="modal" data-bs-target="#detailCardModal">
                                        {{ \Illuminate\Support\Str::limit($task->text, 30) }}
                                    </td>
                                    <form id="updateTaskForm_{{ $task->id }}">
                                        @csrf
                                        @method('PUT')
                                    <td>
                                            <select name="catalog_id" id="catalogSelect_{{ $task->id }}" class="form-select no-arrow"
                                                    onchange="updateTaskCatalog({{ $task->id }});">
                                                @foreach ($catalogs as $catalog)
                                                    <option @selected($catalog->id == $task->catalog_id) value="{{ $catalog->id }}">
                                                        {{ $catalog->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </td>
                                    <td>
                                        <div id="tag1" data-bs-toggle="dropdown" aria-expanded="false"
                                             class=" cursor-pointer">
                                            <span class="badge bg-danger">Gấp</span>
                                            <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="tag1">
                                                @include('dropdowns.tag')
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-2">
                                        <div id="member1" data-bs-toggle="dropdown" aria-expanded="false"
                                             class="cursor-pointer">
                                            <div class="avatar-group d-flex justify-content-center" id="newMembar">
                                                @if ($task->members->isNotEmpty())
                                                    @php
                                                        // Giới hạn số thành viên hiển thị
                                                        $maxDisplay = 3;
                                                        $count = 0;
                                                    @endphp
                                                    @foreach ($task->members as $member)
                                                        @if ($count < $maxDisplay)
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                               data-bs-placement="top" title="{{ $member->name }}">
                                                                @if ($member->image)
                                                                    <img src="{{ asset('storage/' . $member->image) }}"
                                                                         alt="" class="rounded-circle avatar-xs"/>
                                                                @else
                                                                    <div
                                                                        class="bg-info-subtle rounded-circle d-flex justify-content-center align-items-center"
                                                                        style="width: 40px;height: 40px">
                                                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                                                    </div>
                                                                @endif
                                                            </a>
                                                            @php $count++; @endphp
                                                        @endif
                                                    @endforeach

                                                    @if ($task->members->count() > $maxDisplay)
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                           data-bs-toggle="tooltip" data-bs-placement="top"
                                                           title="{{ $task->members->count() - $maxDisplay }} more">
                                                            <div class="avatar-xs">
                                                                <div
                                                                    class="avatar-title rounded-circle bg-info-subtle d-flex justify-content-center align-items-center text-black"
                                                                    style="width: 40px; height: 40px;">
                                                                    +{{ $task->members->count() - $maxDisplay }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @else
                                                    <span>
                                                        <i class="bx fs-20 bxs-user-plus cursor-pointer"
                                                           data-bs-toggle="tooltip"
                                                           title="Thêm thành viên"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="member1">
                                                @include('dropdowns.member')
                                            </div>
                                        </div>
                                    </td>

                                    <td class="col-2">
                                            <input type="datetime-local" name="start_date" id="start_date_{{ $task->id }}"
                                                   value="{{ $task->start_date }}"
                                                  class="form-control no-arrow"
                                                   onchange="updateTaskCatalog({{ $task->id }});">
                                    </td>

                                    <td class="col-2">
                                            <input type="datetime-local" name="end_date" value="{{ $task->end_date }}"
                                                   id="end_date_{{ $task->id }}" class="form-control no-arrow"
                                                   onchange="updateTaskCatalog({{ $task->id }});">
                                    </td>

                                    </form>
                                    <td class="col-1 text-center">
                                        <a href="javascript:void(0);" class="text-muted" id="settingTask1"
                                           data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
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
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <button class="btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-bs-offset="70,10">
        <i class="ri-add-line me-1"></i>
        Thêm
    </button>

    <div class="dropdown-menu dropdown-menu-end p-3">
        <div class="my-2 cursor-pointer">
            <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-250">Danh sách</p>
            <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                <form action="{{ route('catalogs.store') }}" method="POST" onsubmit="disableButtonOnSubmit()">
                    @csrf
                    <h5 class="text-center">Thêm danh sách</h5>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="exampleDropdownFormEmail" name="name"
                               placeholder="Nhập tên danh sách..."/>
                    </div>
                    <input type="hidden" name="board_id" value="{{ $board->id }}">

                    <div class="mb-2 d-grid ">
                        <button type="submit" class="btn btn-primary">
                            Thêm danh sách
                        </button>
                        {{--                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i> --}}
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-2 cursor-pointer">
            <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-280"> Thẻ</p>
            <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                <form action="{{ route('tasks.store') }}" method="POST" onsubmit="disableButtonOnSubmit()">
                    @csrf
                    <h5 class="text-center">Thêm thẻ</h5>
                    <div class="mb-2">
                        <input type="text" name="text" class="form-control" id="exampleDropdownFormEmail"
                               placeholder="Nhập tên thẻ..."/>
                    </div>
                    <div class="mb-2">
                        <select name="catalog_id" id="" class="form-select">
                            <option value="">---Lựa chọn---</option>
                            @foreach ($catalogs as $catalog)
                                <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                            @endforeach
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
    <style>
        .no-arrow {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: none;
            border: none;
            box-shadow: none;
        }

        .no-arrow {
            background-color: transparent;
            cursor: default;
            /* Đảm bảo không có thay đổi khi di chuột */
        }

        /* Loại bỏ hiệu ứng hover, focus và active */
        .no-arrow:hover,
        .no-arrow:focus,
        .no-arrow:active {
            background-color: transparent;
            outline: none;
            box-shadow: none;
        }

        /* Loại bỏ focus */
        .no-arrow {
            outline: none;
        }

        /* Đảm bảo không có outline hoặc box-shadow khi được focus */
        .no-arrow:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
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

    {{-- <script src="{{ asset('theme/assets/js/pages/datatables.init.js') }}"></script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#task-list", {
                order: [
                    [0, 'desc'],
                ]
            });
        });

        {{--function submitForm() {--}}
        {{--    document.getElementById('{{ $task->id ??null }}taskForm').submit(); // Submit form khi giá trị thay đổi--}}
        {{--}--}}
        {{--function updateTaskCatalog({{ $task->id ?? null }}) {--}}
        {{--    var formData = new FormData(document.getElementById('updateTaskForm_' + {{ $task->id }}));--}}
        {{--    var catalogId = document.getElementById('catalogSelect_' + {{ $task->id }}).value;--}}
        {{--    var start_date = document.getElementById('start_date_' + {{ $task->id }}).value;--}}
        {{--    var end_date = document.getElementById('end_date_' + {{ $task->id }}).value;--}}

        {{--    $.ajax({--}}
        {{--        url: `tasks/{$task->id }`, // URL tới route cập nhật task--}}
        {{--        type: "POST",--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        },--}}
        {{--        data: {--}}
        {{--            _method: 'PUT', // Vì phương thức PUT không hỗ trợ trực tiếp qua form, cần chỉ định--}}
        {{--            catalog_id: catalogId--}}
        {{--        },--}}
        {{--        success: function(response) {--}}
        {{--            console.log('Task updated successfully:', response);--}}
        {{--        },--}}
        {{--        error: function(xhr) {--}}
        {{--            console.error('An error occurred:', xhr.responseText);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
        function updateTask({{ $task->id ?? null }}) {

            var formData = new FormData(document.getElementById('updateTaskForm_' + {{$task->id}}));

            $.ajax({
                url: `tasks/{$task->id }`,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Task updated successfully:', response);
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        }

    </script>
@endsection
