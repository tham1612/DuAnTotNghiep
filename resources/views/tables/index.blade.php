@extends('layouts.masterMain')
@section('title')
    Table - TaskFlow
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <table id="task-table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thẻ</th>
                            <th>Nhãn</th>
                            <th>Thành viên</th>
                            <th>Danh sách</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày hết hạn</th>
                            <th>Thao tác</th>

                        </tr>
                        </thead>

                        <tbody>

                        @if (!empty($board))
                            @foreach($board->catalogs as $catalog)
                                @foreach ($catalog->tasks as $task)
                                    <input type="hidden" id="text_{{$task->id}}" value="{{$task->text}}">
                                    <tr>
                                        <td>{{ $loop->iteration  }}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#detailCardModal{{ $task->id }}">
                                            {{ \Illuminate\Support\Str::limit($task->text, 30) }}
                                        </td>
                                        <td class="col-2">
                                            @if ($task->tags->isNotEmpty())
                                                <div class="flex-grow-1 d-flex align-items-center">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($task->tags as $tag)
                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                 data-bs-placement="top"
                                                                 title="{{$tag->name}}">
                                                                <div
                                                                    class="text-white border rounded d-flex align-items-center justify-content-center"
                                                                    style="width: 40px;height: 20px; background-color: {{$tag->color_code}}">{{$tag->name}}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="col-1">
                                            <div id="member1" data-bs-toggle="dropdown" aria-expanded="false"
                                                 class="member cursor-pointer">
                                                <div class="avatar-group d-flex justify-content-center" id="newMembar">
                                                    @if ($task->members->isNotEmpty())
                                                        @php
                                                            // Giới hạn số thành viên hiển thị
                                                            $maxDisplay = 2;
                                                            $count = 0;
                                                        @endphp
                                                        @foreach ($task->members as $member)
                                                            @if ($count < $maxDisplay)
                                                                <a href="" class="avatar-group-item member-task"
                                                                   data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                   data-bs-placement="top" title="{{ $member->name }}">
                                                                    @if ($member->image)
                                                                        <img
                                                                            src="{{ asset('storage/' . $member->image) }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs"/>
                                                                    @else
                                                                        <div
                                                                            class="bg-info-subtle rounded-circle avatar-xxs d-flex justify-content-center align-items-center">
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
                                                                <div class="avatar-xxs">
                                                                    <div
                                                                        class="avatar-title rounded-circle avatar-xxs bg-info-subtle d-flex justify-content-center align-items-center text-black">
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
                                                <div class="dropdown-menu dropdown-menu-end p-3"
                                                     aria-labelledby="member1">
{{--                                                    @include('dropdowns.member')--}}
                                                </div>
                                            </div>
                                        </td>
                                        <form id="updateTaskForm{{ $task->id }}">
                                            <td>
                                                <select name="catalog_id" id="catalog_id_{{ $task->id }}"
                                                        class="form-select no-arrow"
                                                        onchange="updateTask({{ $task->id }})">
                                                    @foreach ($board->catalogs as $catalog)
                                                        <option
                                                            @selected($catalog->id == $task->catalog_id) value="{{ $catalog->id }}">
                                                            {{ $catalog->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td class="col-2">
                                                <input type="datetime-local" name="start_date"
                                                       id="start_date_{{ $task->id }}" value="{{ $task->start_date }}"
                                                       class="form-control no-arrow"
                                                       onchange="updateTask({{ $task->id }})">
                                            </td>

                                            <td class="col-2">
                                                <input type="datetime-local" name="end_date"
                                                       value="{{ $task->end_date }}"
                                                       id="end_date_{{ $task->id }}" class="form-control no-arrow"
                                                       onchange="updateTask({{ $task->id }})">
                                            </td>
                                        </form>
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
                <form action="{{ route('catalogs.store') }}" method="post" onsubmit="return disableButtonOnSubmit()"
                      class="formItem">
                    @csrf
                    <div class="mb-2">
                        <input type="text" class="form-control" name="name" id="nameCatalog"
                               value="{{ old('name') }}" placeholder="Nhập tên danh sách..."/>
                        <input type="hidden" name="board_id" value="{{ $board->id }}">
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <button type="submit" id="btnSubmitCatalog" class="btn btn-primary" disabled>
                            Thêm danh sách
                        </button>
                        <i class="ri-close-line fs-22 ms-2 cursor-pointer closeDropdown" role="button" tabindex="0"
                           aria-label="Close" data-dropdown-id="dropdownMenuOffset3"></i>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-2 cursor-pointer">
            <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-280"> Thẻ</p>
            <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                <form action="{{ route('tasks.store') }}" method="POST" onsubmit="return disableButtonOnSubmit()"
                      class="formItem">
                    @csrf
                    <h5 class="text-center">Thêm thẻ</h5>
                    <div class="mb-2">
                        <input type="text" class="form-control taskNameInput" name="text"
                               value="{{ old('text') }}" placeholder="Nhập tên thẻ..."/>
                        @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <select name="catalog_id" id="" class="form-select">
                            <option value="">---Lựa chọn---</option>
                            @foreach ($board->catalogs as $catalog)
                                <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2 d-grid">
                        <button type="submit" class="btn btn-primary btnSubmitTask" disabled>
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
        $(document).ready(function () {
            $('#task-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ].map(function (extension) {
                    return {
                        extend: extension,
                        exportOptions: {
                            format: {
                                body: function (data, row, column, node) {
                                    if ($(node).is('td') && $(node).find('.member-task').length) {
                                        let memberList = [];
                                        $(node).find('.member-task').each(function () {
                                            let memberName = $(this).attr('data-bs-original-title');
                                            if (memberName) {
                                                memberList.push(memberName.trim());
                                            }
                                        });
                                        if (memberList.length > 0) {
                                            return memberList.join(', ');
                                        } else {
                                            return '';
                                        }
                                    }
                                    if ($(node).is('td') && $(node).find('select').length) {
                                        return $(node).find('select option:selected').text();
                                    }
                                    if ($(node).is('td') && $(node).find('.dropdown-menu').length) {
                                        return $(node).find('.dropdown-menu .active').text() || $(node).find('.badge').text();
                                    }
                                    if ($(node).is('td') && $(node).find('input[type="datetime-local"]').length) {
                                        return $(node).find('input[type="datetime-local"]').val();
                                    }
                                    return $.trim($(node).text());
                                }
                            }
                        }
                    }
                })
            });
        });

        function updateTask(taskId) {
            var formData = {
                catalog_id: $('#catalog_id_' + taskId).val(),
                start_date: $('#start_date_' + taskId).val(),
                end_date: $('#end_date_' + taskId).val(),
                text: $('#text_' + taskId).val(),
                id: taskId,
                changeDate: true
            };
            console.log(taskId);
            $.ajax({
                url: `/tasks/` + taskId,
                method: "PUT",
                dataType: 'json',
                data: formData,
                success: function (response) {
                    console.log('Task updated successfully:', response);
                },
                error: function (xhr) {
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        }
    </script>
@endsection
