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
                    @if(!empty($catalogs))
                        @foreach ($catalogs as $catalog)
                            <a class="list-group-item list-group-item-action" href="#{{ $catalog->id }}">{{ $catalog->name }} </a>
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
                <div class="dropdown-menu p-3" style="width: 300px" aria-labelledby="addCatalog">
                    <form action="{{route('catalogs.store')}}" method="post" onsubmit="disableButtonOnSubmit()">
                        @csrf
                        <div class="mb-2">
                            <input type="text" class="form-control" id="exampleDropdownFormEmail" name="name"
                                   placeholder="Nhập tên danh sách..."/>
                            <input type="hidden" name="board_id" value="{{ $board->id }}">
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary">
                                Thêm danh sách
                            </button>
                            <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
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
                                    <small class="badge bg-warning align-bottom ms-1 totaltask-badge">{{ $catalog->tasks->count() }}</small>
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
                                    <i class="ri-add-line align-bottom me-1"></i>Thêm thẻ
                                </button>
                                <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                    <form action="{{route('tasks.store')}}" method="POST" onsubmit="disableButtonOnSubmit()">
                                    @csrf
                                        <div class="mb-2">
                                            <input type="text" class="form-control" name="text"
                                                placeholder="Nhập tên thẻ..."/>
                                            <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
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
                    </div>

                    <!--end card-body-->
                    <div class="card-body">
                        <div class="table-responsive table-card mb-4">
                            <table id="task-list" class="table table-bordered dt-responsive nowrap table-striped align-middle">
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
                                    @foreach($catalog->tasks as $task)
                                        <tr draggable="true">
                                            <td class="col-2">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1" data-bs-toggle="modal"
                                                        data-bs-target="#detailCardModal">
                                                        {{ \Illuminate\Support\Str::limit($task->text, 20) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
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
                                            <td class="col-1">
                                                <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                                      id="{{ $task->id }}startTaskForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="datetime-local" name="start_date"
                                                           value="{{ $task->start_date }}"
                                                           id="startDateInput" class="form-control no-arrow"
                                                           onchange="document.getElementById('{{ $task->id }}startTaskForm').submit();">
                                                </form>
                                            </td>

                                            <td class="col-1">
                                                <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                                      id="{{ $task->id }}endTaskForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="datetime-local" name="end_date" value="{{ $task->end_date }}"
                                                           id="endDateInput" class="form-control no-arrow"
                                                           onchange="document.getElementById('{{ $task->id }}endTaskForm').submit();">
                                                </form>
                                            </td>
                                            <td class="">
                                                <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                                      id="{{ $task->id }}updateTaskForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="priority" id="prioritySelect" class="form-select no-arrow"
                                                            onchange="document.getElementById('{{ $task->id }}updateTaskForm').submit();">
                                                            @foreach(\App\Enums\IndexEnum::getValues() as $priority)
                                                                <option
                                                                    @selected($task->priority == $priority)
                                                                    value="{{ $priority }}">
                                                                    {{ $priority }}
                                                                </option>
                                                            @endforeach
                                                    </select>

                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                                      id="{{ $task->id }}updateTaskForm1">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="catalog_id" id="catalogSelect" class="form-select no-arrow"
                                                            onchange="document.getElementById('{{ $task->id }}updateTaskForm1').submit();">
                                                        @foreach ($catalogs as $catalog)
                                                            <option
                                                                @selected($catalog->id == $task->catalog_id) value="{{ $catalog->id }}">
                                                                {{ $catalog->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </form>
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
