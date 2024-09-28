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
                    <table id="task-table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
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
                            @if ($tasks)
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->id }}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#detailCardModal" class="col-2">
                                            {{ \Illuminate\Support\Str::limit($task->text, 30) }}
                                        </td>
                                        <td>
                                            <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                                id="{{ $task->id }}updateTaskForm">
                                                @csrf
                                                @method('PUT')
                                                <select name="catalog_id" id="catalogSelect" class="form-select no-arrow"
                                                    onchange="document.getElementById('{{ $task->id }}updateTaskForm').submit();">
                                                    @foreach ($catalogs as $catalog)
                                                        <option @selected($catalog->id == $task->catalog_id) value="{{ $catalog->id }}">
                                                            {{ $catalog->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </form>
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
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs" />
                                                                    @else
                                                                        <div class="bg-info-subtle rounded-circle d-flex justify-content-center align-items-center"
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
                                                                    <div class="avatar-title rounded-circle bg-info-subtle d-flex justify-content-center align-items-center text-black"
                                                                        style="width: 40px; height: 40px;">
                                                                        +{{ $task->members->count() - $maxDisplay }}
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span>
                                                            <i class="bx fs-20 bxs-user-plus cursor-pointer"
                                                                data-bs-toggle="tooltip" title="Thêm thành viên"></i>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="member1">
                                                    @include('dropdowns.member')
                                                </div>
                                            </div>
                                        </td>

                                        <td class="col-2">
                                            <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                                id="{{ $task->id }}startTaskForm">
                                                @csrf
                                                @method('PUT')
                                                <input type="datetime-local" name="start_date"
                                                    value="{{ $task->start_date }}" id="startDateInput"
                                                    class="form-control no-arrow"
                                                    onchange="document.getElementById('{{ $task->id }}startTaskForm').submit();">
                                            </form>
                                        </td>

                                        <td class="col-2">
                                            <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                                id="{{ $task->id }}endTaskForm">
                                                @csrf
                                                @method('PUT')
                                                <input type="datetime-local" name="end_date" value="{{ $task->end_date }}"
                                                    id="endDateInput" class="form-control no-arrow"
                                                    onchange="document.getElementById('{{ $task->id }}endTaskForm').submit();">
                                            </form>
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
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" placeholder="Nhập tên danh sách..." />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="board_id" value="{{ $board->id }}">

                    <div class="mb-2 d-grid ">
                        <button type="submit" class="btn btn-primary">
                            Thêm danh sách
                        </button>
                        {{-- <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i> --}}
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
                        <input type="text" class="form-control @error('text') is-invalid @enderror" name="text"
                            value="{{ old('text') }}" placeholder="Nhập tên thẻ..." />
                        @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@endsection
@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <!-- JSZip for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
    <!-- pdfMake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <!-- Buttons for Excel, PDF, and Print -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#task-table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csv',
                        exportOptions: {
                            format: {
                                body: function(data, row, column, node) {
                                    // Kiểm tra nếu là cột select hoặc dropdown
                                    if ($(node).is('select') || $(node).is('.dropdown-menu')) {
                                        // Trả về giá trị được chọn
                                        return $(node).find('option:selected').text() || $(node)
                                            .find('.active').text();
                                    }
                                    return data; // Trả về giá trị gốc cho các cột khác
                                }
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            format: {
                                body: function(data, row, column, node) {
                                    if ($(node).is('select') || $(node).is('.dropdown-menu')) {
                                        return $(node).find('option:selected').text() || $(node)
                                            .find('.active').text();
                                    }
                                    return data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            format: {
                                body: function(data, row, column, node) {
                                    if ($(node).is('select') || $(node).is('.dropdown-menu')) {
                                        return $(node).find('option:selected').text() || $(node)
                                            .find('.active').text();
                                    }
                                    return data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            format: {
                                body: function(data, row, column, node) {
                                    if ($(node).is('select') || $(node).is('.dropdown-menu')) {
                                        return $(node).find('option:selected').text() || $(node)
                                            .find('.active').text();
                                    }
                                    return data;
                                }
                            }
                        }
                    }
                ]
            });
        });
    </script>
@endsection
