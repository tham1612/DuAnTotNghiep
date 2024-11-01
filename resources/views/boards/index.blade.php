@extends('layouts.masterMain')
@section('title')
    Board - TaskFlow
@endsection
@section('main')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{--        @dd($board->catalogs->first()->tasks) --}}
    <div class="tasks-board mb-3" id="kanbanboard">
        @foreach ($board->catalogs as $catalog)
            <div class="tasks-list rounded-3 p-2 border" data-value="{{ $catalog->id }}">
                <div class="d-flex mb-3 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                            {{ $catalog->name }}
                            <small
                                class="badge bg-success align-bottom ms-1 totaltask-badge">{{ $catalog->tasks->count() }}</small>
                        </h6>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <span class="fw-medium text-muted fs-12">
                                    <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                                </span>
                            </a>
                            <!--                    setting list-->
                            <div class="dropdown-menu dropdown-menu-end">
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog({{ $catalog->id }})">Thêm thẻ</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog({{ $catalog->id }})">Sao chép danh sách</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog({{ $catalog->id }})">Di chuyển danh sách</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="destroyCatalog({{ $catalog->id }})">Theo dõi</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="archiverCatalog({{ $catalog->id }})">Lưu Trữ danh sách</span>
                                <span class="dropdown-item cursor-pointer"
                                      onclick="archiverAllTasks({{ $catalog->id }})">Lưu trữ tất cả thẻ trong danh sách</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                    <div id="{{ $catalog->name . '-' . $catalog->id }}" class="tasks">
                        <!-- task item -->
                        @foreach ($catalog->tasks as $task)
                            <div class="card tasks-box cursor-pointer" data-value="{{ $task->id }}">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <h6 class="fs-15 mb-0 flex-grow-1  task-title" data-bs-toggle="modal"
                                            data-bs-target="#detailCardModal{{ $task->id }}">
                                            {{ $task->text }}
                                        </h6>
                                        {{--                                        <h6 class="fs-15 mb-0 flex-grow-1 task-title"--}}
                                        {{--                                            data-task-id="{{ $task->id }}">--}}
                                        {{--                                            {{ $task->text }}--}}
                                        {{--                                        </h6>--}}
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
                                               data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="ri-more-fill"></i></a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                <li>
                                                    <span class="dropdown-item" href="#"><i
                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                        Mở thẻ</span>
                                                </li>
                                                <li>
                                                    <span class="dropdown-item" href="#"><i
                                                            class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                        Chỉnh sửa nhãn</span>
                                                </li>
                                                <li>
                                                    <span class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                        Thay đổi thành viên</span>
                                                </li>
                                                <li>
                                                    <span class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                        Chỉnh sửa ngày</span>
                                                </li>
                                                <li>
                                                    <span class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                        Sao chép</span>
                                                </li>
                                                <li>
                                                    <span class="dropdown-item" data-bs-toggle="modal"
                                                          onclick="archiverTask({{$task->id}})"><i
                                                            class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                        Lưu trữ</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                                        <!-- Ảnh bìa -->
                                        @if ($task->image)
                                            <div class="tasks-img rounded"
                                                 style="
                                                     background-image: url('{{ asset('storage/' . $task->image) }}');
                                                     background-size: cover;
                                                     background-position: center;
                                                     background-repeat: no-repeat;
                                                     width: 100%;
                                                     height: 150px;
                                                 ">
                                            </div>
                                        @endif
                                        <!-- giao việc cho thành viên-->
                                        @if ($task->members->count() >= 1)
                                            <div class="flex-grow-1 d-flex align-items-center" style="height: 30px">
                                                <i class="ri-account-circle-line fs-20 me-2"></i>
                                                <div class="avatar-group mt-3">
                                                    @if ($task->members->isNotEmpty())
                                                        @php
                                                            // Đếm số lượng board members
                                                            $maxDisplay = 3;
                                                            $count = 0;
                                                        @endphp
                                                        @foreach ($task->members as $taskMember)
                                                            @if ($count < $maxDisplay)
                                                                <a href="javascript: void(0);"
                                                                   class="avatar-group-item border-0"
                                                                   data-bs-toggle="tooltip" data-bs-placement="top"
                                                                   title="{{ $taskMember['name'] }}">
                                                                    @if ($taskMember['image'])

                                                                        <img src="{{ asset('storage/' . $taskMember->image) }}"
                                                                            alt="" class="rounded-circle avatar-xss">
                                                                    @else
                                                                        <div class="avatar-xss">
                                                                            <div class="avatar-title rounded-circle bg-info-subtle text-primary"

                                                                                style="width: 30px;height: 30px">
                                                                                {{ strtoupper(substr($taskMember['name'], 0, 1)) }}
                                                                            </div>
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
                                                                <div class="avatar-xss">
                                                                    <div class="avatar-title rounded-circle" style="width: 35px;height: 35px">

                                                                        +{{ $task->members->count() - $maxDisplay }}
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        @endif
                                        <!-- ngày bắt đầu & kết thúc -->
                                        @if ($task->start_date && $task->end_date)
                                            @php
                                                $start_date = \Carbon\Carbon::parse($task->start_date);
                                                $end_date = \Carbon\Carbon::parse($task->end_date);
                                                $start =
                                                    $start_date->format('d') . ' tháng ' . $start_date->format('m');
                                                $end = $end_date->format('d') . ' tháng ' . $end_date->format('m');
                                            @endphp
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <i class="ri-calendar-event-line fs-20 me-2"></i>
                                                <span class="badge bg-success text-whites-12"> {{ $start }} -
                                                    {{ $end }}
                                                </span>
                                            </div>
                                        @endif
                                        <!-- nhãn -->
                                        @if ($task->tags->isNotEmpty())
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <i class="ri-price-tag-3-line fs-20 me-2"></i>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($task->tags as $tag)
                                                        <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                             data-bs-placement="top" title="{{ $tag->name }}">
                                                            <div
                                                                class="text-white border rounded d-flex align-items-center justify-content-center"
                                                                style="width: 40px;height: 15px; background-color: {{ $tag->color_code }}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer border-top-dashed">
                                    <div class="d-flex justify-content-end">
                                        <div class="flex-shrink-0">
                                            <ul class="link-inline mb-0">
                                                <!-- theo dõi -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)" class="text-muted"><i
                                                            class="ri-eye-line align-bottom"></i>
                                                        04</a>
                                                </li>
                                                <!-- bình luận -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)" class="text-muted"><i
                                                            class="ri-question-answer-line align-bottom"></i>
                                                        19</a>
                                                </li>
                                                <!-- tệp đính kèm -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)" class="text-muted"><i
                                                            class="ri-attachment-2 align-bottom"></i>
                                                        02</a>
                                                </li>
                                                <!-- checklist -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)" class="text-muted"><i
                                                            class="ri-checkbox-line align-bottom"></i>
                                                        2/4</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="my-3">
                    <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown"
                            aria-expanded="false" data-bs-offset="0,-50">
                        Thêm thẻ
                    </button>
                    <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
                        <form action="{{ route('tasks.store') }}" class="formItem" method="post"
                              onsubmit="return disableButtonOnSubmit()">
                            @csrf
                            <div class="mb-2">
                                <input type="text" class="form-control taskNameInput" name="text"
                                       placeholder="Nhập tên thẻ..."/>
                                <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <button type="submit" class="btn btn-primary btnSubmitTask" disabled>
                                    Thêm thẻ
                                </button>
                                <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="rounded-3 p-2 bg-info-subtle" style="height: 40px;">
            <div class="d-flex align-items-center cursor-pointer" id="addCatalog" data-bs-toggle="dropdown"
                 aria-expanded="false" data-bs-offset="-7,-30" style="width: 280px">
                <i class="ri-add-line fs-15"></i>
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                    Thêm danh sách
                </h6>
            </div>
            <div class="dropdown-menu p-3" style="width: 300px" aria-labelledby="addCatalog">
<<<<<<< HEAD
                <form >
=======
                <form action="{{ route('catalogs.store') }}" method="post" class="formItem"
                      onsubmit="return disableButtonOnSubmit()">
                    @csrf
>>>>>>> 9030464260f282aac86310aa5953d7570d2d9f87
                    <div class="mb-2">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               id="nameCatalog" value="{{ old('name') }}" placeholder="Nhập tên danh sách..."/>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <button type="button" id="btnSubmitCatalog" class="btn btn-primary"onclick="submitAddCatalog({{ $board->id }})">
                            Thêm danh sách
                        </button>
                        <i class="ri-close-line fs-22 ms-2 cursor-pointer closeDropdown" role="button" tabindex="0"
                           aria-label="Close" data-dropdown-id="dropdownMenuOffset3"></i>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('style')
    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dragula/dragula.min.css') }}"/>
@endsection
@section('script')
    <script>
        var tasks_list = [
            @foreach ($board->catalogs as $catalog)
            document.getElementById("{{ $catalog->name . '-' . $catalog->id }}"),
            @endforeach
        ]
    </script>
    <!--taks-kanban-->
    <script src="{{ asset('theme/assets/js/pages/tasks-kanban.init.js') }}"></script>
@endsection
