@extends('layouts.masterMain')
@section('title')
    Board - TaskFlow
@endsection
@section('main')
    {{--    @dd($board->catalogs->first()->tasks) --}}
    <div class="tasks-board mb-3" id="kanbanboard">

        @foreach ($board->catalogs as $data)
            @php
                $catalogs = \App\Models\Catalog::find($data->id);
                $count = $catalogs->tasks->count();
            @endphp
            <div class="tasks-list rounded-3 p-2 border" data-value="{{ $data->id }}">
                <div class="d-flex mb-3 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                            {{ $data->name }}
                            <small class="badge bg-success align-bottom ms-1 totaltask-badge">{{ $count }}</small>
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
                                <a class="dropdown-item" href="#">Thêm thẻ</a>
                                <a class="dropdown-item" href="#">Sao chép danh sách</a>
                                <a class="dropdown-item" href="#">Di chuyển danh sách</a>
                                <a class="dropdown-item" href="#">Theo dõi</a>
                                <a class="dropdown-item" href="#">Lưu Trữ danh sách</a>
                                <a class="dropdown-item" href="#">Lưu trữ tất cả thẻ trong danh sách</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                    <div id="{{$data->name}}" class="tasks">
                        <!-- task item -->
                        @foreach ($data->tasks as $task)
                            <div class="card tasks-box cursor-pointer" data-value="{{ $task->id }}">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailCardModal{{ $task->id }}">
                                            {{$task->text}}
                                        </h6>
                                        <div class="dropdown">
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
                                        </div>
                                    </div>
                                    <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
                                        <!-- Ảnh bìa -->
                                        @if ($task->image)
                                            <div class="tasks-img rounded"
                                                style=" background-image: url('{{ asset('theme/assets/images/small/img-7.jpg') }}'); ">
                                            </div>
                                        @endif
                                        <!-- giao việc cho thành viên-->
                                        @if (false)
                                            <div class="flex-shrink-0 d-flex align-items-center">
                                                <i class="ri-account-circle-line fs-20 me-2"></i>
                                                <div class="avatar-group">
                                                    <a href="javascript: void(0);" class="avatar-group-item"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-placement="top" title="Alexis">
                                                        <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                            alt="" class="rounded-circle avatar-xxs" />
                                                    </a>
                                                    <a href="javascript: void(0);" class="avatar-group-item"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-placement="top" title="Nancy">
                                                        <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                            alt="" class="rounded-circle avatar-xxs" />
                                                    </a>
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
                                        @if ($task->tag)
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <i class="ri-price-tag-3-line fs-20 me-2"></i>
                                                <span class="badge bg-success text-whites-12"> làm nhanh </span>
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
                    <!--end card-->

                    <!--end tasks-->
                </div>
                <div class="my-3">
                    <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown"
                        aria-expanded="false" data-bs-offset="0,-50">
                        Thêm thẻ
                    </button>
                    <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
                        <form action="{{ route('tasks.store') }}" method="post">
                            @csrf
                            <div class="mb-2">
                                <input type="text" class="form-control" id="exampleDropdownFormEmail" name="text"
                                    placeholder="Nhập tên thẻ..." />
                                <input type="hidden" name="catalog_id" value="{{ $data->id }}">
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
                <form action="{{ route('catalogs.store') }}" method="post">
                    @csrf
                    <div class="mb-2">
                        <input type="text" class="form-control" id="exampleDropdownFormEmail" name="name"
                            placeholder="Nhập tên danh sách..." />
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
@endsection

@section('style')
    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/dragula/dragula.min.css') }}" />
@endsection
@section('script')
    <script>
        var tasks_list = [
            @foreach($board->catalogs as $data)
            document.getElementById("{{$data->name}}"),
            @endforeach
        ]
    </script>
    <!--taks-kanban-->
    <script src="{{ asset('theme/assets/js/pages/tasks-kanban.init.js') }}"></script>
@endsection
