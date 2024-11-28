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
    <div class="tasks-board mb-3 " id="kanbanboard">
        @foreach ($board->catalogs as $catalog)
            <div class="tasks-list rounded-3 p-2 border position-{{$catalog->position}}" data-value="{{ $catalog->id }}"
                 id="catalog_view_board_{{$catalog->id}}">
                <div class="d-flex mb-3 align-items-center">
                    <div class="flex-grow-1 d-flex">
                        <h6 class="fs-14 text-uppercase fw-semibold mb-0"
                            id="title-catalog-view-board-{{$catalog->id}}">
                            {{ \Str::limit($catalog->name, 25) }}
                        </h6>
                        <small
                            class="badge bg-success align-bottom ms-1 totaltask-badge totaltask-catalog-{{$catalog->id}}">{{ $catalog->tasks->count() }}</small>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                               data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="{{$catalog->id}}">
                                <span class="fw-medium text-muted fs-12">
                                    <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                    <div id="{{ $catalog->name . '-' . $catalog->id }}" class="tasks">
                        <!-- task item -->
                        @foreach ($catalog->tasks as $task)
                            @php
                                //                                $task = json_decode(json_encode($task));
                                //                                dd($task)
                            @endphp
                            <div class="card tasks-box cursor-pointer task-of-catalog-{{$catalog->id}}" id="task_id_view_{{$task->id}}"
                                 data-value="{{ $task->id }}">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <h6 class="fs-15 mb-0 flex-grow-1 " data-bs-toggle="modal"
                                            data-bs-target="#detailCardModal" data-task-id="{{ $task->id }}">
                                            {{ $task->text }}
                                        </h6>
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
                                                <div class="avatar-group">
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
                                                                        <img
                                                                            src="{{ asset('storage/' . $taskMember->image) }}"
                                                                            alt=""
                                                                            class="rounded-circle avatar-xs"
                                                                            style="width: 30px;height: 30px">
                                                                    @else
                                                                        <div class="avatar-xs"
                                                                             style="width: 30px;height: 30px">
                                                                            <div
                                                                                class="avatar-title rounded-circle bg-info-subtle text-primary"
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
                                                                <div class="avatar-xs" style="width: 30px;height: 30px">
                                                                    <div class="avatar-title rounded-circle"
                                                                         style="width: 30px;height: 30px">
                                                                        +{{ $task->members->count() - $maxDisplay }}
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $now = \Carbon\Carbon::now();


                                            $startDate = $task->start_date ? \Carbon\Carbon::parse($task->start_date) : null;
                                            $endDate = $task->end_date ? \Carbon\Carbon::parse($task->end_date) : null;


                                            if ($startDate && $endDate && $endDate->year === $now->year && $startDate->year === $now->year) {
                                                $dateFormat = ' d \t\h\á\n\g m';
                                            }else if($startDate && $startDate->year === $now->year){
                                                $dateFormat = ' d \t\h\á\n\g m';
                                            } else if($endDate && $endDate->year === $now->year){
                                                $dateFormat = ' d \t\h\á\n\g m';
                                            } else {
                                                $dateFormat = ' d \t\h\á\n\g m, Y';
                                            }

                                            $startDate = $startDate ? $startDate->format($dateFormat) : null;
                                            $endDate = $endDate ? $endDate->format($dateFormat) : null;
                                        @endphp
                                            <!-- ngày bắt đầu & kết thúc -->
                                        @if ($endDate && empty($startDate))
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <i class="ri-calendar-event-line fs-20 me-2"></i>
                                                <span
                                                    class="badge @if($task->progress == 100) bg-success
                                                    @elseif($now > $task->end_date) bg-danger
                                                    @elseif($now < $task->end_date) bg-warning
                                                    @endif "
                                                    id="date-view-board-{{$task->id}}">
                                                    {{ $endDate }}
                                                </span>
                                            </div>
                                        @elseif($startDate && empty($endDate))
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <i class="ri-calendar-event-line fs-20 me-2"></i>
                                                <span class="badge bg-primary" id="date-view-board-{{$task->id}}">
                                                    {{ $startDate }}
                                                </span>
                                            </div>
                                        @elseif($endDate && $startDate)
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <i class="ri-calendar-event-line fs-20 me-2"></i>
                                                <span
                                                    class="badge @if($task->progress == 100) bg-success
                                                    @elseif($now > $task->end_date) bg-danger
                                                    @elseif($now < $task->end_date) bg-warning
                                                    @endif "
                                                    id="date-view-board-{{$task->id}}">
                                                {{$startDate}} - {{ $endDate }}
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

                                        {{--                                        <div class="flex-grow-1 d-flex align-items-center">--}}
                                        {{--                                            <div class="d-flex flex-wrap gap-2">--}}
                                        {{--                                                <div class="fs-10 text-white p-1 rounded w-auto--}}
                                        {{--                                                @if(!$task->priority) d-none @endif"--}}
                                        {{--                                                     id="task-priority-view-board-{{$task->id}}"--}}
                                        {{--                                                     style="height: 20px;--}}
                                        {{--                                                      @if($task->priority == 'High')--}}
                                        {{--                                                   background-color: rgba(93,31,26,0.5)--}}
                                        {{--                                                @elseif($task->priority == 'Medium')--}}
                                        {{--                                                    background-color: rgba(83,63,4,0.5)--}}
                                        {{--                                                @elseif($task->priority == 'Low')--}}
                                        {{--                                                   background-color: rgba(22,69,85,0.5)--}}
                                        {{--                                                @endif">--}}
                                        {{--                                                    <p>Độ ưu--}}
                                        {{--                                                        tiên: {{$task->priority}}--}}
                                        {{--                                                        --}}{{--                                                        {{ $task->priority == 'High' ? 'Cao' :--}}
                                        {{--                                                        --}}{{--                                                                ($task->priority == 'Medium' ? 'Trung Bình' :--}}
                                        {{--                                                        --}}{{--                                                                ($task->priority == 'Low' ? 'Thấp' : '')) }}--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}

                                        {{--                                                <div class="fs-10 text-white p-1 rounded w-auto--}}
                                        {{--                                                @if(!$task->risk) d-none @endif"--}}
                                        {{--                                                     id="task-risk-view-board-{{$task->id}}"--}}
                                        {{--                                                     style="height: 20px; @if($task->risk == 'High')--}}
                                        {{--                                                   background-color: rgba(93,31,26,0.5)--}}
                                        {{--                                                @elseif($task->risk == 'Medium')--}}
                                        {{--                                                    background-color: rgba(83,63,4,0.5)--}}
                                        {{--                                                @elseif($task->risk == 'Low')--}}
                                        {{--                                                   background-color: rgba(22,69,85,0.5)--}}
                                        {{--                                                @endif">--}}
                                        {{--                                                    <p>Độ ưu--}}
                                        {{--                                                        tiên: {{$task->risk}}--}}
                                        {{--                                                        --}}{{--                                                        {{ $task->risk == 'High' ? 'Cao' :--}}
                                        {{--                                                        --}}{{--                                                                ($task->risk == 'Medium' ? 'Trung Bình' :--}}
                                        {{--                                                        --}}{{--                                                                ($task->risk == 'Low' ? 'Thấp' : '')) }}--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                                <div class="card-footer border-top-dashed">
                                    <div class="d-flex justify-content-end">
                                        <div class="flex-shrink-0">
                                            <ul class="link-inline mb-0">
                                                {{--  độ ưu tiên                                              --}}
                                                @if(!empty($task->priority))
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"
                                                           title="Độ ưu tiên">
                                                            <i id="task-priority-view-board-{{$task->id}}" class="ri-flag-fill align-bottom
                                                             @if($task->priority == 'High')
                                                                text-danger
                                                             @elseif($task->priority == 'Medium')
                                                                text-warning
                                                             @elseif($task->priority == 'Low')
                                                               text-info
                                                             @endif"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{--  rủi do                                              --}}
                                                @if(!empty($task->risk))
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted" title="Rủi do">
                                                            <i id="task-risk-view-board-{{$task->id}}" class=" ri-spam-fill align-bottom
                                                             @if($task->risk == 'High')
                                                                text-danger
                                                             @elseif($task->risk == 'Medium')
                                                                text-warning
                                                             @elseif($task->risk == 'Low')
                                                               text-info
                                                             @endif"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                <!-- theo dõi -->
                                                @if($task->followMembers->contains('user_id', auth()->id()))
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i
                                                                class="ri-eye-line align-bottom"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                <!-- bình luận -->
                                                @if($task->taskComments->isNotEmpty())
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i
                                                                class="ri-question-answer-line align-bottom"></i>
                                                            {{ $task->taskComments->count() < 10
                                                            ? '0'.$task->taskComments->count()
                                                             : $task->taskComments->count() }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <!-- tệp đính kèm -->
                                                @if($task->attachments->isNotEmpty())
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i
                                                                class="ri-attachment-2 align-bottom"></i>
                                                            {{ $task->attachments->count() < 10
                                                               ? '0'.$task->attachments->count()
                                                                : $task->attachments->count() }}</a>
                                                    </li>
                                                @endif
                                                <!-- checklist -->
                                                @php
                                                    //                                                    // Chuyển đổi $task->checklists sang mảng để dễ thao tác
                                                    //                                                       $checklistsArray = json_decode(json_encode($task->check_lists), true);
                                                    //
                                                    //                                                       // Đếm tổng số checklist items
                                                    //                                                       $totalChecklistItems = collect($checklistsArray)->sum(function($checklist) {
                                                    //                                                           return count($checklist['checklistItems']);
                                                    //                                                       });
                                                    //
                                                    //                                                       // Đếm số checklist items đã hoàn thành
                                                    //                                                       $completedChecklistItems = collect($checklistsArray)->sum(function($checklist) {
                                                    //                                                           return collect($checklist['checklistItems'])->where('is_complete', true)->count();
                                                    //                                                       });
                                                                                                       $allChecklistItems = $task->checklists->flatMap(function ($checklist) {
                                                                                                            return $checklist->checklistItems;
                                                                                                        });
                                                                                                        $inProgressItems = $task->checklists->flatMap(function ($checklist) {
                                                                                                            return $checklist->checklistItems->where('is_complete', true);
                                                                                                        });
                                                @endphp

                                                @if($task->checkLists->isNotEmpty())
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="text-muted"><i
                                                                class="ri-checkbox-line align-bottom"></i>
                                                        {{$inProgressItems->count().'/'.$allChecklistItems->count()}}
                                                    </li>
                                                @endif

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
                            aria-expanded="false" data-bs-offset="0,-50" onclick="loadFormAddTask({{ $catalog->id }})">
                        Thêm thẻ
                    </button>
                    <div class="dropdown-menu p-3 dropdown-content-add-task-{{$catalog->id }}" style="width: 285px"
                         aria-labelledby="dropdownMenuOffset2">
                        {{--dropdown.createTask--}}
                    </div>

                </div>
            </div>

        @endforeach
        <div class="rounded-3 p-2 bg-info-subtle board-{{$board->id}}" style="height: 40px;">
            <div class="d-flex align-items-center cursor-pointer" id="addCatalog" data-bs-toggle="dropdown"
                 aria-expanded="false" data-bs-offset="-7,-30" style="width: 280px"
                 onclick="loadFormAddCatalog({{ $board->id }})">
                <i class="ri-add-line fs-15"></i>
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                    Thêm danh sách
                </h6>
            </div>
            <div class="dropdown-menu p-3 dropdown-content-add-catalog-{{$board->id }}" style="width: 300px"
                 aria-labelledby="addCatalog">
                {{--dropdown.createCatalog--}}
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
