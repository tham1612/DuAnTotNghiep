<div class="modal-header p-3"
     style="
                             height: 150px;
                             background-size: cover; /* Đảm bảo ảnh phủ đầy khung mà không bị móp */
                             background-position: center; /* Đảm bảo ảnh được căn giữa */
                             background-repeat: no-repeat; /* Không lặp lại ảnh */
                             object-fit: cover;
                             @if($task->image)
                                 background-image: url('{{ asset('storage/' . $task->image) }}');
                             @else
                                 background-image: url('{{ asset('theme/assets/images/small/img-7.jpg') }}');
                             @endif
         "
     id="detailCardModalLabel">
    <div class="">
        <label for="file-upload" class="custom-file-upload">
            <i class=" ri-image-add-line fs-24"></i>
            <input type="file" class="file-upload"
                   onchange="updateTask2({{ $task->id }})" id="image_task_{{ $task->id }}">
        </label>
    </div>

    <button type="button" class="btn-close bg-white" style="margin: -100px -5px 0px 0px"
            data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-9 p-2">
            <div class="row">
                <div class="col-12">
                    <!-- Input Border Style -->
                    <div>
                        <section class="d-flex mb-2">
                            <i class="ri-artboard-line fs-24 mt-1"></i>
                            <input type="text" name="text"
                                   class="form-control border-0 ms-1 fs-18 fw-medium bg-transparent ps-0"
                                   id="text_{{ $task->id }}" value="{{ $task->text }}"
                                   onchange="updateTask2({{ $task->id }})"/>

                        </section>

                        <span
                            class="ms-4">trong danh sách : <strong>{{$task->catalog->name}}</strong> </span>

                    </div>
                </div>
                <div class="col-12 d-flex mt-3 flex-wrap">
                    @if(count($task->members))
                        <div class="p-3 col-3">
                            <strong>Thành viên</strong>
                            <section class="d-flex">
                                <!-- thêm thành viên & chia sẻ link bảng -->
                                <div
                                    class="d-flex justify-content-center align-items-center cursor-pointer ">
                                    <div class="col-auto ms-sm-auto">
                                        <div class="avatar-group " id="list-member-task">
                                            @if (count($task->members))

                                                @php
                                                    // Đếm số lượng board members
                                                    $maxDisplay = 3;
                                                    $count = 0;
                                                @endphp

                                                @foreach ($task->members as $taskMember)
                                                    @if ($count < $maxDisplay)
                                                        <a href="javascript: void(0);"
                                                           class="avatar-group-item"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="top"
                                                           title="{{ $taskMember->name }}">
                                                            @if ($taskMember->image)
                                                                <img
                                                                    src="{{ asset('storage/' . $taskMember->image) }}"
                                                                    alt=""
                                                                    class="rounded-circle avatar-sm">
                                                            @else
                                                                <div class="avatar-sm">
                                                                    <div
                                                                        class="avatar-title rounded-circle bg-info-subtle text-primary"
                                                                        style="width: 35px;height: 35px">
                                                                        {{ strtoupper(substr($taskMember->name, 0, 1)) }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </a>
                                                        @php $count++; @endphp
                                                    @endif
                                                @endforeach

                                                @if (count($task->members) > $maxDisplay)
                                                    <a href="javascript: void(0);"
                                                       class="avatar-group-item"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       title="{{ $task->members->count() - $maxDisplay }} more">
                                                        <div class="avatar-sm">
                                                            <div
                                                                class="avatar-title rounded-circle">
                                                                +{{ $task->members->count() - $maxDisplay }}
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
                    @endif
                    <div class="p-3">
                        <strong>Thông báo</strong>
                        @php
                            //                                                     $memberFollow = \App\Models\Follow_member::where('task_id', $task->id)
                            //                                                        ->where('user_id', auth()->id())
                            //                                                        ->value('follow');
                         $memberFollow1 = collect($task->follow_members)->firstWhere('user_id', auth()->id());
                         $memberFollow = $memberFollow1 ? $memberFollow1->follow : 0;

                        @endphp
                        <div
                            class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                            style="height: 35px; background-color: #091e420f; color: #172b4d"
                            id="notification_{{$task->id}}"
                            onclick="updateTaskMember({{ $task->id }}, {{ auth()->id() }})">
                            <i class="@if($memberFollow == 1)
                                                    ri-eye-line @else ri-eye-off-line @endif
                                                    fs-22" id="notification_icon_{{$task->id}}"></i>
                            <p class="ms-2 mt-3" id="notification_content_{{$task->id}}">
                                @if($memberFollow == 1)
                                    Đang theo dõi
                                @else
                                    Theo dõi
                                @endif</p>
                            <div @if( $memberFollow == 0) class="d-none"
                                 @endif id="notification_follow_{{$task->id}}">
                                <i class="ri-check-line fs-22 bg-light ms-2 rounded"
                                   style="color: black"></i>
                            </div>
                        </div>
                    </div>


                    <div class="p-3 ">
                        <strong>Ngày hết hạn</strong>
                        @php
                            $now = \Carbon\Carbon::now();
                            $endDate = \Carbon\Carbon::parse($task->end_date);
                        @endphp
                        <div
                            class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                            style="height: 35px; background-color: #091e420f; color: #172b4d">
                            <input type="checkbox" id="due_date_checkbox_{{ $task->id }}"
                                   class="form-check-input"
                                   onchange="updateTask2({{ $task->id }})" name="progress"
                                   @if($task->progress == 100 ) checked @endif />
                            <input type="hidden" id="task_end_date_{{ $task->id }}" value="{{ $task->end_date }}">
                            @if(!empty($task->end_date) || !empty($task->start_date))
                                <p class="ms-2 mt-3">{{ $task->end_date }}</p>
                            @endif
                            @if($task->progress == 100 )
                                <span
                                    class="badge bg-success ms-2  d-none}"
                                    id="due_date_success_{{ $task->id }}">Hoàn tất</span>
                            @else
                                <span
                                    class="badge bg-success ms-2 {{ $now->gt($endDate) ? 'd-none' : '' }}"
                                    id="due_date_success_{{ $task->id }}">Hoàn tất</span>
                                <span
                                    class="badge bg-danger ms-2 {{ $now->gt($endDate) ? '' : 'd-none' }}"
                                    id="due_date_due_{{ $task->id }}">Quá hạn</span>
                            @endif

                        </div>
                    </div>

                    @if(count($task->tags))
                        <div class="p-3">
                            <strong>Nhãn</strong>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($task->tags as $tag)
                                    <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                         data-bs-placement="top"
                                         title="{{$tag->name}}">
                                        <div
                                            class="text-white border rounded d-flex align-items-center justify-content-center"
                                            style="width: 60px;height: 35px; background-color: {{$tag->color_code}}">
                                            {{$tag->name}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- mô tả -->
            <div class="row mt-3">
                <section class="d-flex">
                    <i class="ri-menu-2-line fs-22"></i>
                    <p class="fs-18 ms-2 mt-1">Mô tả</p>
                </section>
                <div class="ps-4">
                    <div id="textarea_container_{{ $task->id }}" class="d-none">
                                                 <textarea name="description"
                                                           id="description_{{ $task->id}}"
                                                           cols="25" rows="5"
                                                           class="form-control bg-light editor"
                                                           placeholder="Thêm mô tả chi tiết"
                                                           onchange="updateTask2({{ $task->id }})">{{$task->description}}</textarea>
                    </div>

                    <!-- Khối hiển thị mô tả chi tiết hoặc thông báo nếu không có mô tả -->
                    <div class="bg-info-subtle rounded pt-2 ps-2 d-flex align-items-start"
                         id="description_display_{{ $task->id }}"
                         style="height: 80px; cursor: pointer;"
                         data-task-id="{{$task->id}}"
                         onclick="toggleDescriptionForm(this)">
                        {!! $task->description ? $task->description : 'Thêm mô tả chi tiết hơn' !!}
                    </div>
                </div>
            </div>


            @include('components.attachment', ['attachment' => $task->attachments, 'task' => $task])
            @include('components.checklist', ['checklist' => $task->check_lists, 'task' => $task])


            <div class="row mt-4">
                <section class="d-flex">
                    <i class="ri-line-chart-line fs-22"></i>
                    <p class="fs-18 ms-2 mt-1">Hoạt động</p>
                </section>
                <div class=" w-100">
                    <div class="d-flex">
                        @if (auth()->user()->image)
                            <img class="rounded header-profile-user object-fit-cover"
                                 src="{{asset('storage/' . auth()->user()->image) }}"
                                 alt="Avatar"/>
                        @else
                            <div
                                class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                style="width: 40px;height: 40px">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="ms-2 w-100">
                            <form class="flex-column" id="comment_form_{{$task->id}}"
                                  style="display: none;" data-task-id="{{$task->id}}">
                                                              <textarea name="content" class="form-control editor"
                                                                        id="comment_task_{{$task->id}}"
                                                                        placeholder="Viết bình luận"></textarea>

                                <button type="button" class="btn btn-primary mt-2"
                                        onclick="addTaskComment({{$task->id}},{{Auth::id()}})">
                                    Lưu

                                </button>
                            </form>

                            <div class="bg-info-subtle p-2 rounded ps-2"
                                 data-task-id="{{$task->id}}" onclick="toggleCommentForm(this)">
                                Viết bình luận
                            </div>
                        </div>

                    </div>
                    @if(!empty($task->task_comments))
                    @foreach($task->task_comments as $comment)
                        @php $comment = json_decode(json_encode($comment)) @endphp
                        <div class="d-flex mt-2">
                            @if (auth()->user()->image)
                                <img class="rounded header-profile-user object-fit-cover"
                                     src="{{ asset('storage/' . auth()->user()->image) }}"
                                     alt="Avatar"/>
                            @else
                                <div
                                    class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                    style="width: 40px;height: 40px">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <section class="ms-2 w-100">
                                <strong>{{auth()->user()->name}}</strong>
                                @php
                                    $createdAt = \Carbon\Carbon::parse($comment->created_at);
                                    $now = \Carbon\Carbon::now();
                                    $diffInHours = $createdAt->diffInHours($now);
                                    \Carbon\Carbon::setLocale('vi');
                                @endphp

                                @if ($diffInHours < 24)
                                    <span class="fs-11">{{ $createdAt->diffForHumans() }}</span>
                                @else
                                    <span
                                        class="fs-11">{{ $createdAt->format('H:i j \t\h\g m, Y') }}</span>
                                @endif
                                <div
                                    class="bg-info-subtle p-1 rounded ps-2">{!! $comment->content !!}
                                </div>
                                <div class="fs-11"><span>Trả lời</span><span
                                        class="mx-1">-</span><span>Xóa</span></div>
                            </section>
                        </div>
                    @endforeach
                    @endif


                </div>
            </div>
        </div>
        <div class="col-3">
            <h5 class="mt-3 mb-3"><strong>Thêm vào thẻ</strong></h5>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-user fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" data-bs-offset="-40,10" onclick="loadTaskFormAddMember({{ $task->id }},{{$board->id}})">
                        Thành viên
                    </p>
                    <!--dropdown thành viên-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%" id="dropdown-content-add-member-task-{{ $task->id }}">
                        {{--                                                @include('dropdowns.member')--}}
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-tag fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" data-bs-offset="-40,10">
                        Nhãn
                    </p>
                    <!--dropdown nhãn-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                        @include('dropdowns.tag')
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-check-square fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" data-bs-offset="-40,10" onclick="loadTaskFormAddCheckList({{ $task->id }})">
                        Việc cần làm
                    </p>

                    <!-- dropdown việc cần làm-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%" id="dropdown-content-add-checkList-{{ $task->id }}">
                        <!-- Nội dung form sẽ được chèn vào đây bằng AJAX -->
                    </div>
                </div>
            </div>

            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-clock fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       onclick="loadFormAddDateTask({{ $task->id }})"
                       aria-expanded="false" data-bs-offset="-40,10"
                       id="dropdownToggle_{{$task->id}}">
                        Ngày
                    </p>
                    <!-- dropdown ngày-->
                    <div class="dropdown-menu dropdown-menu-md p-3"
                         id="dropdown-content-add-date-task-{{ $task->id }}"
                         style="width: 150%">
                        {{--                                                @include('dropdowns.date', ['task' => $task])--}}
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-paperclip fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" data-bs-offset="-40,10" onclick="loadTaskFormAddAttach({{ $task->id }})">
                        Đính kèm
                    </p>
                    <!--                                    dropdown tệp đính kèm-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%" id="dropdown-content-add-attach-{{ $task->id }}">
                        {{--                                                @include('dropdowns.attach')--}}
                    </div>
                </div>
            </div>

            <h5 class="mt-3 mb-3"><strong>Thao tác</strong></h5>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style="height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-arrow-circle-right fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" data-bs-offset="-40,10">
                        Di chuyển
                    </p>
                    <!--                                    dropdown di chuyển-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                        @include('dropdowns.move')
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-copy fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" data-bs-offset="-40,10">
                        Sao chép
                    </p>
                    <!--  dropdown sao chép-->
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                        {{--                                                @include('dropdowns.copyTask')--}}
                    </div>
                </div>
            </div>

            <!-- lưu trữ-->
            <div class="d-flex mt-3 mb-3 cursor-pointer archiver ">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="ri-archive-line fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Lưu trữ
                    </p>
                    <div></div>
                </div>
            </div>
            <!--                            hoàn tác-->
            <div class="d-flex mt-3 mb-3 cursor-pointer restore-archiver d-none">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las la-window-restore fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Khôi phục
                    </p>
                    <div></div>
                </div>
            </div>
            <!--                            xóa vĩnh viễn-->
            <div class="d-flex mt-3 mb-3 cursor-pointer delete-archiver d-none">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: red">
                    <i class="las la-window-restore fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Xóa
                    </p>
                    <div></div>
                </div>
            </div>

            <div class="d-flex mt-3 mb-3 cursor-pointer">
                <div
                    class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                    style=" height: 30px; background-color: #091e420f; color: #172b4d">
                    <i class="las ri-share-line fs-20"></i>
                    <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" data-bs-offset="-40,10">Chia sẻ</p>
                    <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                        {{--                                                @include('dropdowns.share')--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
