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
                    @foreach ($catalogs as $catalog)
                        <a class="list-group-item list-group-item-action" href="#{{ $catalog->id }}">{{ $catalog->name }} </a>
                    @endforeach
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

    <div class="col-lg-12">
        <div data-simplebar data-bs-target="#list-example" data-bs-offset="0" style="height: 60vh;">
            @foreach ($catalogs as $catalog)
                <div class="card" id="{{ $catalog->id }}">
                    <div class="card-header border-0">
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-grow-1">
                                <h6 class="fs-14 text-uppercase fw-semibold mb-0"  value="{{ $catalog->id }}">{{ $catalog->name }}
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
                                    <i class="ri-add-line align-bottom me-1"></i>Add Task
                                </button>
                                <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset3">
                                    <form action="{{route('tasks.store')}}" method="POST" onsubmit="disableButtonOnSubmit()">
                                    @csrf
                                        <div class="mb-2">
                                            <input type="text" class="form-control" name="text"
                                                placeholder="Nhập tên task..."/>
                                            <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
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
                                <tbody class="form-check-all big-div" id="">
                                    @foreach($catalog->tasks as $task)
                                        <tr class="" id="" draggable="true">
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="option1">
                                                </div>
                                            </th>
                                            <td class="">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1" data-bs-toggle="modal"
                                                        data-bs-target="#detailCardModal">
                                                        {{ Str::limit($task->text, 20, '...') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-2">
                                                <div class="d-flex cursor-pointer" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <div class="avatar-group">
                                                        {{-- <a href="javascript:void(0);"
                                                        class="avatar-group-item avatarClick"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-placement="top" title="Nancy">
                                                            <img
                                                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle avatar-xs"/>
                                                        </a> --}}
                                                        @foreach($task->members as $taskMember)
                                                            <a href="javascript: void(0);" class="avatar-group-item">
                                                                <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($taskMember->image)) }}"
                                                                alt=""
                                                                class="rounded-circle avatar-xs"/>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <!-- Dropdown menu hiển thị thành viên -->
                                                <div class="dropdown-menu dropdown-menu-lg p-3 userDropdown">
                                                    @include('dropdowns.member')
                                                </div>
                                            </td>
                                            <td class="col-1">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <input class="form-control" type="datetime-local" value="{{$task->start_date}}"></i>
                                                </a>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-control text-uppercase fw-semibold mb-0">
                                                        @foreach(\App\Enums\IndexEnum::getValues() as $priority)
                                                            <option
                                                                @selected($task->priority == $priority)
                                                                value="{{ $priority }}">
                                                                {{ $priority }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-control text-uppercase fw-semibold mb-0">
                                                        @foreach($board->catalogs as $catalog)
                                                        <option
                                                            @selected($catalog->id == $task->catalog_id)
                                                            value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                                        @endforeach
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
                                    @endforeach
                                    {{-- <tr class="small-div" id="drag5" draggable="true">
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

                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!--end card-body-->
                </div>
            @endforeach
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
