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
                <div id="verticalMenu" class="list-group d-none" data-simplebar style="max-height: 400px; width:300px">
                    @if (!empty($catalogs))
                        @foreach ($catalogs as $catalog)
                            <a class="list-group-item list-group-item-action"
                                href="#{{ $catalog->id }}">{{ $catalog->name }} </a>
                        @endforeach
                    @endif
                    {{-- <a class="list-group-item list-group-item-action" href="#list-item-1">{{ $catalog->name }} </a>
                    <a class="list-group-item list-group-item-action" href="#list-item-2">Inprogress</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-3">To do</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-4">Completed</a> --}}
                </div>
                <button class="btn btn-primary ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                    aria-expanded="false" data-bs-offset="0,-50">
                    <i class="ri-add-line align-bottom me-1"></i>Thêm danh sách
                </button>
                <div class="dropdown-menu p-3" style="width: 300px" aria-labelledby="dropdownMenuOffset3">
                    <form action="{{ route('catalogs.store') }}" method="post" onsubmit="disableButtonOnSubmit()">
                        @csrf
                        <div class="mb-2">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" placeholder="Nhập tên danh sách..." />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="board_id" value="{{ $board->id }}">
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary">
                                Thêm danh sách
                            </button>
                            <i class="ri-close-line fs-22 ms-2 cursor-pointer closeDropdown" role="button" tabindex="0"
                                aria-label="Close" data-dropdown-id="dropdownMenuOffset3"></i>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" id="example" class="display">
        <div data-simplebar data-bs-target="#list-example" data-bs-offset="0" style="height: 60vh;">
            @if(!empty($catalogs))

            @foreach ($catalogs as $catalog)
                <div class="card" id="{{ $catalog->id }}">
                    <div class="card-header border-0">
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-grow-1">
                                <h6 class="fs-14 fw-semibold mb-0" value="{{ $catalog->id }}">{{ $catalog->name }}
                                    <small
                                        class="badge bg-warning align-bottom ms-1 totaltask-badge">{{ $catalog->tasks->count() }}</small>
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
                                <button class="btn btn-primary ms-3" id="dropdownMenuOffset{{ $catalog->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50">
                                    <i class="ri-add-line align-bottom me-1"></i>Thêm thẻ
                                </button>
                                <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                    <form action="{{ route('tasks.store') }}" method="POST"
                                        onsubmit="disableButtonOnSubmit()">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="text" class="form-control @error('text') is-invalid @enderror"
                                                name="text" value="{{ old('text') }}"
                                                placeholder="Nhập tên thẻ..." />
                                            @error('text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
                                        </div>
                                        <div class="mb-2 d-flex align-items-center">
                                            <button type="submit" class="btn btn-primary">
                                                Thêm thẻ
                                            </button>
                                            <i class="ri-close-line fs-22 ms-2 cursor-pointer closeDropdown"
                                                role="button" tabindex="0" aria-label="Close"
                                                data-dropdown-id="dropdownMenuOffset{{ $catalog->id }}"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end card-body-->
                    <div class="card-body">
                        <div class="table-responsive table-card mb-3">
                            <table id="catalog-table-{{ $catalog->id }}" style="width:100%"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Thẻ</th>
                                        <th>Thành viên</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Độ ưu tiên</th>
                                        <th>Danh sách</th>
                                        <th>Bình luận</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($catalog->tasks as $task)
                                        <tr draggable="true">
                                            <td class="col-2">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1" data-bs-toggle="modal"
                                                        data-bs-target="#detailCardModal{{ $task->id }}">
                                                        {{ \Illuminate\Support\Str::limit($task->text, 20) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div id="member1" data-bs-toggle="dropdown" aria-expanded="false"
                                                    class="cursor-pointer">
                                                    <div class="avatar-group d-flex justify-content-center"
                                                        id="newMembar">
                                                        @if ($task->members->isNotEmpty())
                                                            @php
                                                                // Giới hạn số thành viên hiển thị
                                                                $maxDisplay = 3;
                                                                $count = 0;
                                                            @endphp
                                                            @foreach ($task->members as $member)
                                                                @if ($count < $maxDisplay)
                                                                    <a href="javascript: void(0);"
                                                                        class="avatar-group-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                                        title="{{ $member->name }}">
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
                                            <form id="updatelistTaskForm_{{ $task->id }}">
                                                <td class="col-2">
                                                    <input type="datetime-local" name="start_date"
                                                           id="start_date_{{ $task->id }}"
                                                           value="{{ $task->start_date }}"
                                                           class="form-control no-arrow"
                                                           onchange="updateTaskList({{ $task->id }})">
                                                </td>

                                                <td class="col-2">
                                                    <input type="datetime-local" name="end_date" value="{{ $task->end_date }}"
                                                           id="end_date_{{ $task->id }}" class="form-control no-arrow"
                                                           onchange="updateTaskList({{ $task->id }})">
                                                </td>
                                            <td class="">
                                                    <select name="priority" id="priority_{{ $task->id }}" class="form-select no-arrow"
                                                            onchange="updateTaskList({{ $task->id }});">
                                                            @foreach(\App\Enums\IndexEnum::getValues() as $priority)
                                                                <option
                                                                    @selected($task->priority == $priority)
                                                                    value="{{ $priority }}">
                                                                    {{ $priority }}
                                                                </option>
                                                            @endforeach
                                                    </select>


                                            </td>
                                            <td>
                                                <select name="catalog_id" id="catalog_id_{{ $task->id }}" class="form-select no-arrow"
                                                            onchange="updateTaskList({{ $task->id }});">
                                                        @foreach ($catalogs as $catalog)
                                                            <option @selected($catalog->id == $task->catalog_id)
                                                                value="{{ $catalog->id }}">
                                                                {{ $catalog->name }}
                                                            </option>
                                                        @endforeach

                                                </select>

                                            </td>
                                            </form>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!--end card-body-->
                </div>
            @endforeach
        @endif
    </div>
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
    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dragula/dragula.min.css') }}" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection
@section('script')
    <script>
        document.getElementById('menuIcon').addEventListener('click', function() {
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
        document.querySelectorAll('#verticalMenu .list-group-item').forEach(function(item) {
            item.addEventListener('click', function() {
                // Ẩn menu sau khi chọn item
                const verticalMenu = document.getElementById('verticalMenu');
                verticalMenu.classList.remove('d-block');
                verticalMenu.classList.add('d-none');
            });
        });

        // // kéo thả
        // dragula([
        //     document.getElementById("unassigned"),
        //     document.getElementById("improgress"),
        //     document.getElementById("to-do"),
        //     document.getElementById("completed")
        // ]);
        // removeOnSpill: false
        //     .on("drag", function (el) {
        //         el.className.replace("ex-moved", "");
        //     })
        //     .on("drop", function (el) {
        //         el.className += "ex-moved";
        //     })
        //     .on("over", function (el, container) {
        //         container.className += "ex-over";
        //     })
        //     .on("out", function (el, container) {
        //         container.className.replace("ex-over", "");
        //     });
        function updateTaskList(taskId) {
            var formData = {
                catalog_id: $('#catalog_id_' + taskId).val(),
                start_date: $('#start_date_' + taskId).val(),
                end_date: $('#end_date_' + taskId).val(),
                priority: $('#priority_' + taskId).val(),
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
