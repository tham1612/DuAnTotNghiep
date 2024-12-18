@extends('layouts.masterMain')
@section('title')
    Danh sách - TaskFlow
@endsection
@section('main')
    @if(session('error'))
        <div class="alert alert-danger custom-alert">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .custom-alert {
            border-radius: 0.5rem;
            padding: 1rem;
            position: relative;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>

    <div class="row mt-3 ms-3 me-3">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-left justify-content-between">
                <!-- Icon menu -->
                <div class="menu-icon">
                    <i class="ri-menu-line fs-20" id="menuIcon"></i>
                </div>
                <!-- Menu sẽ ẩn ban đầu -->
                <div id="verticalMenu" class="list-group d-none menu-catalog-{{$board->id}}" data-simplebar
                     style="max-height: 400px; width:300px">
                    @if (!empty($board))
                        @foreach ($board->catalogs as $catalog)
                            <a class="list-group-item list-group-item-action"
                               href="#{{ $catalog->id }}">{{ $catalog->name }} </a>
                        @endforeach
                    @endif
                </div>
                <button class="btn btn-primary ms-3" id="dropdownMenuOffset3" data-bs-toggle="dropdown"
                        aria-expanded="false" data-bs-offset="0,-50" onclick="loadFormAddCatalog({{ $board->id }})">
                    <i class="ri-add-line align-bottom me-1"></i>Thêm danh sách
                </button>
                <div class="dropdown-menu p-3 dropdown-content-add-catalog-{{$board->id }}" style="width: 300px"
                     aria-labelledby="addCatalog">
                    {{--dropdown.createCatalog--}}
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col-lg-12" id="example" class="display">
        <div data-simplebar data-bs-target="#list-example" data-bs-offset="0"
             class=" me-3 ms-3 list-catalog-{{$board->id }}" id="realtime-view-list">
            @if (!empty($board))
                @foreach ($board->catalogs as $catalog)
                    <div class="card" id="catalog_view_list_{{$catalog->id}}">
                        <div class="card-header border-0">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-grow-1">
                                    <h6 class="fs-14 fw-semibold mb-0" value="{{ $catalog->id }}">{{ $catalog->name }}
                                        <small
                                            class="badge bg-warning align-bottom ms-1 totaltask-badge totaltask-catalog-{{$catalog->id}}">{{ $catalog->tasks->count() }}</small>
                                    </h6>
                                    <div class="d-flex ms-4">
                                        <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                                           data-bs-target="#detailCardModalCatalog"
                                           data-setting-catalog-id="{{$catalog->id}}">
                                            <i class="ri-more-fill"></i>
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary ms-3" id="dropdownMenuOffset{{ $catalog->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50"
                                            onclick="loadFormAddTask({{ $catalog->id }})">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm thẻ
                                    </button>
                                    <div class="dropdown-menu p-3 dropdown-content-add-task-{{ $catalog->id }}"
                                         style="width: 285px"
                                         aria-labelledby="dropdownMenuOffset3">
                                        {{--dropdown.createTask--}}
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

                                    </tr>
                                    </thead>
                                    <tbody id="body-catalog-{{$catalog->id}}">
{{--                                    <tbody id="{{ $catalog->name . '-' . $catalog->id }}">--}}
                                    @foreach ($catalog->tasks as $task)
                                        <input type="hidden" id="text_{{$task->id}}" value="{{$task->text}}">
                                        <tr class="task-of-catalog-{{$catalog->id}}"
                                            id="task_id_view_{{$task->id}}">
                                            <td class="col-2">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-task-view-board-{{ $task->id }}" data-bs-toggle="modal"
                                                          data-task-id="{{$task->id}}">
                                                        {{ \Illuminate\Support\Str::limit($task->text, 20) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div id="member1"
                                                     class="cursor-pointer">
                                                    <div class="avatar-group d-flex justify-content-center"
                                                         id="newMembar">
                                                        @if ($task->members->isNotEmpty())
                                                            @php
                                                                // Giới hạn số thành viên hiển thị
                                                                $maxDisplay = 2;
                                                                $count = 0;
                                                            @endphp
                                                            @foreach ($task->members as $member)
                                                                @if ($count < $maxDisplay)
                                                                    <a href="javascript: void(0);"
                                                                       class="avatar-group-item"
                                                                       data-bs-toggle="tooltip"
                                                                       data-bs-trigger="hover"
                                                                       data-bs-placement="top"
                                                                       title="{{ $member->name }}">
                                                                        @if ($member->image)
                                                                            <img
                                                                                src="{{ asset('storage/' . $member->image) }}"
                                                                                alt=""
                                                                                class="rounded-circle avatar-xxs"/>
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
                                                                <a href="javascript: void(0);"
                                                                   class="avatar-group-item" data-bs-toggle="tooltip"
                                                                   data-bs-placement="top"
                                                                   title="{{ $task->members->count() - $maxDisplay }} more">
                                                                    <div class="avatar-xxs">
                                                                        <div
                                                                            class="bg-info-subtle rounded-circle avatar-xxs d-flex justify-content-center align-items-center">
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
                                                </div>
                                            </td>
                                            <form id="updatelistTaskForm_{{ $task->id }}">
                                                @php
                                                    $start_date = $task->start_date
                                                        ? \Carbon\Carbon::parse($task->start_date)->format(
                                                            'Y-m-d\TH:i',
                                                        )
                                                        : null;
                                                    $end_date = $task->end_date
                                                        ? \Carbon\Carbon::parse($task->end_date)->format(
                                                            'Y-m-d\TH:i',
                                                        )
                                                        : null;
                                                @endphp
                                                <td class="col-2">
                                                    <input type="datetime-local" name="start_date"
                                                           id="start_date_{{ $task->id }}"
                                                           value="{{ $start_date }}" class="form-control no-arrow"
                                                           onchange="updateTaskList({{ $task->id }})">
                                                </td>

                                                <td class="col-2">
                                                    <input type="datetime-local" name="end_date"
                                                           id="end_date_{{ $task->id }}"
                                                           value="{{ $end_date }}" class="form-control no-arrow"
                                                           onchange="updateTaskList({{ $task->id }})">
                                                </td>
                                                <td class="">
                                                    <span
                                                        class="badge
                                                        @if ($task->priority == 'High') bg-danger-subtle text-danger
                                                        @elseif ($task->priority == 'Medium') bg-warning-subtle text-warning
                                                        @elseif ($task->priority == 'Low') bg-success-subtle text-success
                                                        @else bg-info-subtle text-info @endif"
                                                        onclick="toggleSelect({{ $task->id }});">
                                                    {{ $task->priority }}
                                                </span>


                                                    <select name="priority" id="priority_{{ $task->id }}"
                                                            class="form-select no-arrow" style="display: none;"
                                                            onchange="updateTaskList({{ $task->id }})">
                                                        @foreach (\App\Enums\IndexEnum::getValues() as $priority)
                                                            <option value="{{ $priority }}"
                                                                @selected($task->priority == $priority)>
                                                                {{ $priority }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="catalog_id" id="catalog_id_{{ $task->id }}"
                                                            class="form-select no-arrow"
                                                            onchange="updateTaskList({{ $task->id }});">
                                                        @foreach ($board->catalogs as $catalog)
                                                            <option @selected($catalog->id == $task->catalog_id)
                                                                    value="{{ $catalog->id }}">
                                                                {{ $catalog->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                </td>
                                            </form>
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
            <link rel="stylesheet" href="{{ asset('theme/assets/libs/dragula/dragula.min.css') }}"/>
            <link rel="stylesheet"
                  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
        @endsection
        @section('script')
            <script>
                function toggleSelect(taskId) {
                    const select = document.getElementById(`priority_${taskId}`);
                    const badge = select.previousElementSibling;

                    if (select.style.display === "none") {
                        select.style.display = "block"; // Hiện select
                        badge.style.display = "none"; // Ẩn span
                    }
                }

                // ẩn hiện menu catalogs
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

                function updateTaskList(taskId) {
                    const startDateInput1 = document.getElementById('start_date_' + taskId).value;
                    const endDateInput1 = document.getElementById('end_date_' + taskId).value;

                    // Chuyển đổi giá trị sang đối tượng Date để so sánh
                    const startDate1 = new Date(startDateInput1);
                    const endDate1 = new Date(endDateInput1);

                    // Kiểm tra nếu cả ngày bắt đầu và ngày kết thúc đều có giá trị
                    if (startDateInput1 && endDateInput1 && startDate1 >= endDate1) {
                        // Hiển thị thông báo lỗi nếu ngày bắt đầu lớn hơn hoặc bằng ngày kết thúc
                        notificationWeb('error','Ngày bắt đầu phải nhỏ hơn ngày kết thúc.')
                        // Swal.fire({
                        //     icon: "error",
                        //     title: "Oops...",
                        //     text: "Ngày bắt đầu phải nhỏ hơn ngày kết thúc.",
                        // })
                        return; // Dừng thực hiện hàm nếu có lỗi
                    }
                    var formData = {
                        catalog_id: $('#catalog_id_' + taskId).val(),
                        start_date: $('#start_date_' + taskId).val(),
                        end_date: $('#end_date_' + taskId).val(),
                        priority: $('#priority_' + taskId).val(),
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
