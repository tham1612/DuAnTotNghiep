<!-- chi tiết thẻ -->
<style>
    .custom-file-upload {
        background-color: rgba(235, 235, 235, 0.52);
        border-radius: 10px;
        display: inline-block;
        padding: 3px 35px;
        margin-top: 100px;
        margin-left: -10px;
    }

    .file-upload {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        width: 15%;
        height: 20%;
        opacity: 0; /* Ẩn input nhưng vẫn nhận được sự kiện click */
    }

    #modalImage {
        max-width: 100%;
        max-height: 80vh;
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }

    #modalImage.zoomed {
        transform: scale(2); /* Tăng kích thước ảnh gấp 2 lần */
        cursor: zoom-out;
    }
</style>
<div class="modal-header p-3 modal-header-{{$task->id}}"
     style="

         height: 150px;
         background-size: cover; /* Đảm bảo ảnh phủ đầy khung mà không bị móp */
         background-position: center; /* Đảm bảo ảnh được căn giữa */
         background-repeat: no-repeat; /* Không lặp lại ảnh */
         object-fit: cover;
         background-image: url('{{ $image }}');
         "
     id="detailCardModalLabel">
    <div class="">
        <label for="file-upload" class="custom-file-upload">
            <i class=" ri-image-add-line fs-24"></i>
            <input type="file" class="file-upload" onchange="updateTask2({{ $task->id }})"
                   id="image_task_{{ $task->id }}">
        </label>
    </div>

    <button type="button" class="btn-close bg-white" style="margin: -100px -5px 0px 0px" data-bs-dismiss="modal"
            aria-label="Close"></button>
</div>

<div class="modal-body modal-body-{{ $task->id }}">
    <div class="row">
        <div class="col-9 p-2">
            <div class="row">
                <div class="col-12">
                    <!-- Input Border Style -->
                    <div>
                        <section class="d-flex mb-2">
                            <i class="ri-artboard-line fs-24 mt-1"></i>
                            <input type="text" name="text"
                                   class="form-control border-0 ms-1 fs-18 fw-medium bg-transparent ps-0  cursor-pointer"
                                   id="text_{{ $task->id }}" value="{{ $task->text }}"
                                   onchange="updateTask2({{ $task->id }})"/>

                        </section>

                        <span class="ms-3">Trong danh sách : <strong>{{ $task->catalog->name }}</strong> </span>

                    </div>
                </div>
                <div class="col-12 d-flex flex-wrap">
                    <div class="p-3" id="member-section-{{ $task->id }}"
                         style="{{ count($task->members) ? '' : 'display: none;' }}">
                        <strong>Thành viên</strong>
                        <section class="d-flex">
                            <!-- thêm thành viên & chia sẻ link bảng -->
                            <div class="d-flex mt-1 justify-content-center align-items-center cursor-pointer ">
                                <div class="col-auto ms-sm-auto">
                                    <div class="avatar-group " id="list-member-task-{{ $task->id }}">
                                        @if (count($task->members))
                                            @php
                                                // Đếm số lượng board members
                                                $maxDisplay = 3;
                                                $count = 0;
                                            @endphp
                                            @foreach ($task->members as $taskMember)
                                                @if ($count < $maxDisplay)
                                                    <a href="javascript: void(0);" class="avatar-group-item"
                                                       data-bs-toggle="tooltip" data-bs-placement="top"
                                                       id="member-{{ $taskMember->id }}-{{ $task->id }}"
                                                       title="{{ $taskMember->name }}">
                                                        @if ($taskMember->image)
                                                            <img src="{{ asset('storage/' . $taskMember->image) }}"
                                                                 alt="" class="rounded-circle avatar-xs"
                                                                 style="width: 30px;height: 30px">
                                                        @else
                                                            <div class="avatar-xs" style="width: 30px;height: 30px">
                                                                <div
                                                                    class="avatar-title rounded-circle bg-info-subtle text-primary"
                                                                    style="width: 30px;height: 30px">
                                                                    {{ strtoupper(substr($taskMember->name, 0, 1)) }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </a>
                                                    @php $count++; @endphp
                                                @endif
                                            @endforeach

                                            @if (count($task->members) > $maxDisplay)
                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                   data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="{{ count($task->members) - $maxDisplay }} more">
                                                    <div class="avatar-xs" style="width: 30px;height: 30px">
                                                        <div class="avatar-title rounded-circle"
                                                             style="width: 30px;height: 30px">
                                                            +{{ count($task->members) - $maxDisplay }}
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="p-3">
                        <strong>Thông báo</strong>
                        @php
                            $memberFollow1 = collect($task->followMembers)->firstWhere('user_id', $userId);
                            $memberFollow = $memberFollow1 ? $memberFollow1->follow : 0;
                        @endphp
                        <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                             style="height: 35px; background-color: #091e420f; color: #172b4d"
                             id="notification_{{ $task->id }}"
                             onclick="updateTaskMember({{ $task->id }}, {{ $userId }})">
                            <i class="@if ($memberFollow == 1) ri-eye-line @else ri-eye-off-line @endif
                                                    fs-22"
                               id="notification_icon_{{ $task->id }}"></i>
                            <p class="ms-2 mt-3" id="notification_content_{{ $task->id }}">
                                @if ($memberFollow == 1)
                                    Đang theo dõi
                                @else
                                    Theo dõi
                                @endif
                            </p>
                            <div @if ($memberFollow == 0) class="d-none" @endif
                            id="notification_follow_{{ $task->id }}">
                                <i class="ri-check-line fs-22 bg-light ms-2 rounded" style="color: black"></i>
                            </div>
                        </div>
                    </div>


                    <div class="p-3" id="date-section-{{ $task->id }}"
                         style="{{ !empty($task->end_date) || !empty($task->start_date) ? '' : 'display: none;' }}">
                        @php

                            $now = \Carbon\Carbon::now();


                            $startDate = $task->start_date ? \Carbon\Carbon::parse($task->start_date) : null;
                            $endDate = $task->end_date ? \Carbon\Carbon::parse($task->end_date) : null;


                           if ($startDate && $endDate && $endDate->year === $now->year && $startDate->year === $now->year) {
                                                $dateFormat = 'H:i d \t\h\á\n\g m';
                                            }else if($startDate && $startDate->year === $now->year){
                                                $dateFormat = 'H:i d \t\h\á\n\g m';
                                            } else if($endDate && $endDate->year === $now->year){
                                                $dateFormat = 'H:i d \t\h\á\n\g m';
                                            } else {
                                                $dateFormat = 'H:i d \t\h\á\n\g m, Y';
                                            }

                            $startDate = $startDate ? $startDate->format($dateFormat) : null;
                            $endDate = $endDate ? $endDate->format($dateFormat) : null;
                        @endphp
                        @if ($startDate && empty($endDate))
                            <strong>Ngày bắt đầu</strong>
                            <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                                 style="height: 35px; background-color: #091e420f; color: #172b4d">
                                <p class="ms-2 mt-3">{{ $startDate }}</p>
                            </div>
                        @endif
                        @if ($endDate && empty($startDate))
                            <strong>Ngày kết thúc</strong>
                            <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                                 style="height: 35px; background-color: #091e420f; color: #172b4d">
                                <input type="hidden" id="task_end_date_{{ $task->id }}" value="{{ $task->end_date }}">
                                <input type="checkbox" id="due_date_checkbox_{{ $task->id }}"
                                       class="form-check-input"
                                       onchange="updateTask2({{ $task->id }})" name="progress"
                                       @if($task->progress == 100) checked @endif />
                                <p class="ms-2 mt-3">{{ $endDate }}</p>
                                @if($task->progress == 100)
                                    <span
                                        class="badge bg-success ms-2 "
                                        id="due_date_success_{{ $task->id }}">Hoàn thành</span>
                                @elseif($now < $task->end_date)
                                    <span
                                        class="badge bg-warning ms-2 "
                                        id="due_date_success_{{ $task->id }}">Sắp đến hạn</span>
                                @elseif($now > $task->end_date)
                                    <span
                                        class="badge bg-danger ms-2 "
                                        id="due_date_success_{{ $task->id }}">Quá hạn</span>
                                @endif
                            </div>
                        @endif
                        @if($endDate && $startDate)
                            <strong>Ngày</strong>
                            <div
                                class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                                style="height: 35px; background-color: #091e420f; color: #172b4d">

                                <input type="checkbox" id="due_date_checkbox_{{ $task->id }}"
                                       class="form-check-input"
                                       onchange="updateTask2({{ $task->id }})" name="progress"
                                       @if($task->progress == 100) checked @endif />

                                <input type="hidden" id="task_end_date_{{ $task->id }}" value="{{ $task->end_date }}">

                                <p class="ms-2 mt-3">
                                    {{ $startDate }} - {{ $endDate }}
                                </p>

                                @if($task->progress == 100)
                                    <span
                                        class="badge bg-success ms-2 "
                                        id="due_date_success_{{ $task->id }}">Hoàn thành</span>
                                @elseif($now < $task->end_date)
                                    <span
                                        class="badge bg-warning ms-2 "
                                        id="due_date_success_{{ $task->id }}">Sắp đến hạn</span>
                                @elseif($now > $task->end_date)
                                    <span
                                        class="badge bg-danger ms-2 "
                                        id="due_date_success_{{ $task->id }}">Quá hạn</span>
                                @endif

                            </div>

                        @endif
                    </div>
                    <div class="ms-2 p-3" id="tag-section-{{ $task->id }}"
                         style="{{ count($task->tags) ? '' : 'display: none;' }}">
                        <strong>Nhãn</strong>
                        <div class="d-flex mt-1 flex-wrap gap-2" id="tag-task-{{ $task->id }}">
                            @foreach ($task->tags as $tag)
                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                     data-tag-id="{{ $task->id }}-{{ $tag->id }}"
                                     title="{{ $tag->name }}">
                                    <div class="badge border rounded d-flex align-items-center justify-content-center"
                                         style=" background-color: {{ $tag->color_code }}">

                                        {{ $tag->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- trường bổ xung -->
            <div class="row">
                <section class="d-flex">
                    <i class="ri-menu-2-line fs-22"></i>
                    <p class="fs-18 ms-2 mt-1">Trường bổ xung</p>
                </section>
                <div class="ps-4 d-flex gap-1">
                    <div class="col-4">
                        <label for="">Độ ưu tiên</label>
                        <select name="" id="" class="form-select no-arrow"
                                onchange="updatePriorityOrRisk('priority', this.value, {{$task->id}})">
                            <option value="" hidden selected>Chọn...</option>
                            <option value="High" @selected($task->priority == 'High')>Cao</option>
                            <option value="Medium" @selected($task->priority == 'Medium')>Trung Bình</option>
                            <option value="Low" @selected($task->priority == 'Low')>Thấp</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="">Rủi do</label>
                        <select name="" id="" class="form-select"
                                onchange="updatePriorityOrRisk('risk', this.value, {{$task->id}})">
                            <option value="" hidden selected>Chọn...</option>
                            <option value="High" @selected($task->risk == 'High')>Cao</option>
                            <option value="Medium" @selected($task->risk == 'Medium')>Trung Bình</option>
                            <option value="Low" @selected($task->risk == 'Low')>Thấp</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- mô tả -->
            <div class="row mt-2">
                <section class="d-flex">
                    <i class="ri-menu-2-line fs-22"></i>
                    <p class="fs-18 ms-2 mt-1">Mô tả</p>
                </section>
                <div class="ps-4">
                    <div id="textarea_container_{{ $task->id }}" class="d-none">
                        <textarea name="description" id="description_{{ $task->id }}" cols="25" rows="5"
                                  class="form-control bg-light editor" placeholder="Thêm mô tả chi tiết"
                                  onchange="updateTask2({{ $task->id }})">{{ $task->description }}</textarea>
                    </div>

                    <!-- Khối hiển thị mô tả chi tiết hoặc thông báo nếu không có mô tả -->
                    <div class="bg-info-subtle rounded pt-2 ps-2 d-flex align-items-start"
                         id="description_display_{{ $task->id }}" style="height: 80px; cursor: pointer;"
                         data-task-id="{{ $task->id }}" onclick="toggleDescriptionForm(this)">
                        {!! $task->description ? $task->description : 'Thêm mô tả chi tiết hơn' !!}
                    </div>
                </div>
            </div>


            @include('components.attachment', ['attachment' => $task->attachments, 'task' => $task])
            @include('components.checklist', ['checklist' => $task->check_lists, 'task' => $task])
            <div class="row mt-4">
                <section class="d-flex justify-content-between">
                    <div class="d-flex">
                        <i class="ri-line-chart-line fs-22"></i>
                        <p class="fs-18 ms-2 mt-1">Hoạt động</p>
                    </div>

                    <div class="hstack gap-2 flex-wrap mb-3"
                         style="{{ count($task->taskComments) ? '' : 'display: none;' }}">

                        <button class="btn btn-outline-dark" type="button"
                                onclick="loadAllTaskComment({{ $task->id }})" data-bs-toggle="collapse"
                                data-bs-target="#activity-{{ $task->id }}" aria-expanded="false"
                                aria-controls="collapseExample">
                            Xem chi tiết
                        </button>
                    </div>
                </section>
                <div class="comments-container w-100" id="task-comment-{{ $task->id }}">
                    <div class="d-flex">
                        @if (auth()->user()->image)
                            <img class="rounded header-profile-user object-fit-cover"
                                 src="{{ asset('storage/' . auth()->user()->image) }}" alt="Avatar"/>
                        @else
                            <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                 style="width: 40px;height: 40px">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="ms-2 w-100">
                            <form class="flex-column" id="comment_form_{{ $task->id }}" style="display: none;"
                                  data-task-id="{{ $task->id }}">
                                <textarea name="content" class="form-control" id="comment_task_{{ $task->id }}"
                                          placeholder="Viết bình luận"></textarea>

                                <button type="button" class="btn btn-primary mt-2"
                                        onclick="addTaskComment({{ $task->id }},{{ $userId }})">
                                    Lưu

                                </button>
                            </form>

                            <div class="bg-info-subtle p-2 rounded ps-2  cursor-pointer" data-task-id="{{ $task->id }}"
                                 onclick="toggleCommentForm(this)">
                                Viết bình luận
                            </div>
                        </div>

                    </div>
                    <div class="collapse show" id="activity-{{ $task->id }}">
                        {{--                                            @include('components.comment'); --}}
                    </div>

                </div>
            </div>
        </div>
        <div class="col-3">
            <h5 class="mt-3 mb-3"><strong>Thêm vào thẻ</strong></h5>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-user fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       data-bs-offset="-40,10"
                       onclick="loadTaskFormAddMember({{ $task->id }},{{ $boardId }})">
                        Thành viên
                    </p>
                    <!--dropdown thành viên-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%"
                         id="dropdown-content-add-member-task-{{ $task->id }}">
                        {{--                                              dropdowns.member --}}
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-tag fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       onclick="loadTaskTag({{ $task->id }},{{ $boardId }})" aria-expanded="false"
                       data-bs-offset="-40,10">
                        Nhãn
                    </p>
                    <!--dropdown nhãn-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%"
                         id="dropdown-list-tag-task-board-{{ $task->id }}">
                        {{-- dropdowns.tag --}}
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-check-square fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       data-bs-offset="-40,10" onclick="loadTaskFormAddCheckList({{ $task->id }})">
                        Việc cần làm
                    </p>

                    <!-- dropdown việc cần làm-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%"
                         id="dropdown-content-add-checkList-{{ $task->id }}">
                        <!-- Nội dung form sẽ được chèn vào đây bằng AJAX -->
                    </div>
                </div>
            </div>

            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-clock fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       onclick="loadFormAddDateTask({{ $task->id }})" aria-expanded="false"
                       data-bs-offset="-40,10" id="dropdownToggle_{{ $task->id }}">
                        Ngày
                    </p>
                    <!-- dropdown ngày-->
                    <div class="dropdown-menu dropdown-menu-md p-3"
                         id="dropdown-content-add-date-task-{{ $task->id }}" style="width: 150%">
                        {{--                                                @include('dropdowns.date', ['task' => $task]) --}}
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-paperclip fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       data-bs-offset="-40,10" onclick="loadTaskFormAddAttach({{ $task->id }})">
                        Đính kèm
                    </p>
                    <!--                                    dropdown tệp đính kèm-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%"
                         id="dropdown-content-add-attach-{{ $task->id }}">
                        {{--                                                @include('dropdowns.attach') --}}
                    </div>
                </div>
            </div>

            <h5 class="mt-3 mb-3"><strong>Thao tác</strong></h5>
{{--            <div class="d-flex mt-3 mb-3 cursor-pointer">--}}
{{--                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"--}}
{{--                     style="height: 30px; background-color: #091e420f; color: #172b4d">--}}
{{--                    <i class="las la-arrow-circle-right fs-20"></i>--}}
{{--                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
{{--                       data-bs-offset="-40,10">--}}
{{--                        Di chuyển--}}
{{--                    </p>--}}
{{--                    <!--                                    dropdown di chuyển-->--}}
{{--                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">--}}
{{--                        @include('dropdowns.move')--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-copy fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       data-bs-offset="-40,10">
                        Sao chép
                    </p>
                    <!--  dropdown sao chép-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                        @include('dropdowns.copyTask')
                    </div>
                </div>
            </div>

            <!-- lưu trữ-->
            <div class="d-flex mt-3 mb-3 cursor-pointer archiver ">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d"
                     onclick="archiverTask({{ $task->id }})">
                    <i class="ri-archive-line fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Lưu trữ
                    </p>
                    <div></div>
                </div>
            </div>
            <!--                            hoàn tác-->
            <div class="d-flex mt-3 mb-3 cursor-pointer restore-archiver d-none">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: #091e420f; color: #172b4d"
                     onclick="restoreTask({{ $task->id }})" data-value="true">
                    <i class="las la-window-restore fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Khôi phục
                    </p>
                    <div></div>
                </div>
            </div>
            <!--                            xóa vĩnh viễn-->
            <div class="d-flex mt-3 mb-3 cursor-pointer delete-archiver d-none">
                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                     style=" height: 30px; background-color: red"
                     onclick="destroyTask({{ $task->id }})">
                    <i class="las la-window-restore fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Xóa
                    </p>
                    <div></div>
                </div>
            </div>

{{--            <div class="d-flex mt-3 mb-3 cursor-pointer">--}}
{{--                <div class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"--}}
{{--                     style=" height: 30px; background-color: #091e420f; color: #172b4d">--}}
{{--                    <i class="las ri-share-line fs-20"></i>--}}
{{--                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
{{--                       data-bs-offset="-40,10">Chia sẻ</p>--}}
{{--                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">--}}
{{--                        --}}{{--                                                @include('dropdowns.share') --}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>

</div>


<script>
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    // Tạo một đối tượng để lưu trữ các editor đã khởi tạo
    const editors = {};

    // Khởi tạo ClassicEditor cho mỗi phần tử có class 'editor'
    document.querySelectorAll('.editor').forEach((editorElement, index) => {
        ClassicEditor
            .create(editorElement
                , {
                    toolbar: [
                        'heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'
                    ],
                    removePlugins: [
                        'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload',
                        'MediaEmbed', 'MediaEmbedToolbar'
                    ]
                }
            )
            .then(editor => {
                // Lưu trữ instance của từng editor với id của phần tử hoặc chỉ mục
                editors[editorElement.id] = editor;

                // Lắng nghe sự kiện change của editor
                editor.model.document.on('change:data', debounce(() => {
                    const taskId = editorElement.id.split('_')[1];
                    updateTask2(taskId);
                }, 1000));
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
<script>



    //     xử lý lưu trữ cảu card
    // Lấy tất cả các phần tử có cùng class
    var archivers = document.querySelectorAll('.archiver');
    var restoreArchivers = document.querySelectorAll('.restore-archiver');
    var deleteArchivers = document.querySelectorAll('.delete-archiver');

    // Lặp qua tất cả các phần tử archiver và thêm sự kiện
    archivers.forEach((archiver, index) => {
        archiver.addEventListener('click', () => {
            restoreArchivers[index].classList.toggle('d-none');
            deleteArchivers[index].classList.toggle('d-none');
            archiver.classList.add('d-none');
        });
    });

    // Lặp qua tất cả các phần tử restore-archiver và thêm sự kiện
    restoreArchivers.forEach((restoreArchiver, index) => {
        restoreArchiver.addEventListener('click', () => {
            deleteArchivers[index].classList.add('d-none');
            restoreArchivers[index].classList.add('d-none');
            archivers[index].classList.toggle('d-none');
        });
    });


    // Hàm ẩn khối bình luận và hiện textarea khi người dùng nhấp vào
    function toggleCommentForm(element) {
        // Lấy taskId từ data-attribute
        const taskId = element.getAttribute('data-task-id');

        // Tìm khối "Viết bình luận"
        const commentDiv = element;

        // Tìm form theo taskId
        const commentForm = document.querySelector(`form[data-task-id="${taskId}"]`);

        if (commentDiv && commentForm) {
            // Ẩn khối "Viết bình luận"
            commentDiv.style.display = 'none';

            // Hiện form
            commentForm.style.display = 'block';
        } else {
            console.error('Không tìm thấy phần tử với taskId:', taskId);
        }
    }

    // Hàm ẩn khối mô tả và hiện textarea khi người dùng nhấp vào
    function toggleDescriptionForm(element) {
        // Lấy taskId từ data-attribute
        const taskId = element.getAttribute('data-task-id');
        console.log('Task ID:', taskId);  // Kiểm tra giá trị taskId

        // Lấy khối mô tả đang được hiển thị
        const descriptionDiv = document.getElementById(`description_display_${taskId}`);

        // Lấy textarea và container của nó theo taskId
        const descriptionContainer = document.getElementById(`textarea_container_${taskId}`);
        const descriptionTextarea = document.getElementById(`description_${taskId}`);

        if (descriptionDiv && descriptionContainer && descriptionTextarea) {
            // Sử dụng class để ẩn thay vì trực tiếp thay đổi style
            descriptionDiv.classList.add('d-none');  // Thêm class Bootstrap ẩn div

            // Hiển thị textarea bằng cách xóa class d-none
            descriptionContainer.classList.remove('d-none');
            descriptionTextarea.focus();  // Đặt con trỏ vào textarea
        } else {
            console.error('Không tìm thấy phần tử với taskId:', taskId);
        }
    }
</script>






