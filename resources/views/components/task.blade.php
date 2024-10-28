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
</style>
@if(!empty($board))
    @foreach($board->catalogs as $catalog)
        @foreach ($catalog->tasks->toArray() as $task)
            @php
                $task = json_decode(json_encode($task));
            //    dd($task);
            @endphp
            <div class="modal fade" id="detailCardModal{{ $task->id }}" tabindex="-1"
                 aria-labelledby="detailCardModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 rounded-3">

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
                                                    <input type="hidden" id="task_end_date_{{ $task->id }}"
                                                           value="{{ $task->end_date }}">
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
                                                                    class="badge border rounded d-flex align-items-center justify-content-center"
                                                                    style=" background-color: {{$tag->color_code}}">
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
                                        <div class=" w-100" id="task-comment-{{$task->id}}">
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
                                                              <textarea name="content" class="form-control"
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
                                            @foreach($task->task_comments as $comment)
                                                @php
                                                    $comment = json_decode(json_encode($comment)) ;
                                                  $replyUser = collect($task->task_comments)->where('id', $comment->parent_id)->first();
                                                @endphp
                                                <div class="d-flex mt-2 conten-comment-{{$comment->id}}">
                                                    @if ($comment->user->image)
                                                        <img class="rounded header-profile-user object-fit-cover"
                                                             src="{{ asset('storage/' . $comment->user->image) }}"
                                                             alt="Avatar"/>
                                                    @else
                                                        <div
                                                            class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                            style="width: 40px;height: 40px">
                                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <section class="ms-2 w-100">
                                                        <strong>{{$comment->user->name}}</strong>
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
                                                            class="bg-info-subtle p-1 rounded ps-2 " id="1content-coment-{{$comment->id}}">
                                                            @if(!empty($replyUser))
                                                            <div
                                                                class="badge border rounded  align-items-center "
                                                                style=" background-color:  #4A90E2">@
                                                                {{$replyUser->user->name}}
                                                            </div>
                                                            @endif
                                                            {!! $comment->content !!}
                                                        </div>
                                                        <div class="">
                                                            <div class="fs-11 d-flex">
                                                                @if($comment->user->id === Auth::id())
                                                                <div class="">
                                                                    <span data-bs-toggle="dropdown"
                                                                          aria-haspopup="true"
                                                                          aria-expanded="false">Chỉnh sửa</span>
                                                                    <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-update-comemnt-{{$comment->id}} ">
                                                                        <div class="d-flex text-muted">Chỉnh sửa</div>
                                                                        <form class="flex-column"
                                                                              id="comment_form_{{$task->id}}}">
                                                                              <textarea name="content" class="form-control"
                                                                                        id="update_comment_{{$comment->id}}">{!! $comment->content !!}
                                                                                </textarea>
                                                                            <button type="button"
                                                                                    class="btn btn-primary mt-2"
                                                                                    onclick="updateTaskComment({{$task->id}},{{Auth::id()}},{{$comment->id}})">
                                                                                Lưu
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                    @else
                                                                <div class="">
                                                                <span data-bs-toggle="dropdown"
                                                                      aria-haspopup="true"
                                                                      aria-expanded="false">Trả lời</span>
                                                                    <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-reply-comemnt-{{$comment->id}} ">
                                                                        <div class="d-flex text-muted"><i class=" ri-arrow-go-forward-fill"></i><h5 class="text-center text-muted "> {{$comment->user->name}}</h5></div>
                                                                        <form class="flex-column"
                                                                              id="comment_form_{{$task->id}}">
                                                                      <textarea name="content" class="form-control"
                                                                                id="reply_comment_{{$comment->id}}"
                                                                                placeholder="Trả lời bình luận"></textarea>
                                                                            <button type="button"
                                                                                    class="btn btn-primary mt-2"
                                                                                    onclick="addReplyTaskComment({{$task->id}},{{Auth::id()}},{{$comment->id}})">
                                                                                Lưu
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                    @endif
                                                                @php $userOwner = $board->members->firstWhere('pivot.authorize', 'Owner');  @endphp
                                                                @if(auth()->id()===$comment->user->id || auth()->id()=== $userOwner->id )
                                                                    <span class="mx-1">-</span>
                                                                    <span data-bs-toggle="dropdown"
                                                                          aria-haspopup="true"
                                                                          aria-expanded="false">Xóa</span>
                                                                    <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                        <h5 class="text-center">Bạn có muốn xóa bình
                                                                            luận</h5>
                                                                        <p>Bình luận sẽ bị xóa vĩnh viễn và không thể khôi
                                                                            phục</p>
                                                                        <button class="btn btn-danger w-100"
                                                                                onclick="removeComment({{$comment->id}})">
                                                                            Xóa bình luận
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                            @endforeach
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
                                               aria-expanded="false" data-bs-offset="-40,10"
                                               onclick="loadTaskFormAddMember({{ $task->id }},{{$board->id}})">
                                                Thành viên
                                            </p>
                                            <!--dropdown thành viên-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%"
                                                 id="dropdown-content-add-member-task-{{ $task->id }}">
                                                {{--                                              dropdowns.member--}}
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
                                               aria-expanded="false" data-bs-offset="-40,10"
                                               onclick="loadTaskFormAddCheckList({{ $task->id }})">
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
                                               aria-expanded="false" data-bs-offset="-40,10"
                                               onclick="loadTaskFormAddAttach({{ $task->id }})">
                                                Đính kèm
                                            </p>
                                            <!--                                    dropdown tệp đính kèm-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%"
                                                 id="dropdown-content-add-attach-{{ $task->id }}">
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
                    </div>
                </div>
            </div>

            <!-- Modal ảnh (phóng to ảnh) -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true"
                 style="z-index: 1060">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content d-flex justify-content-center align-items-center bg-warning">
                        <img id="modalImage" style="width: 180vh; height: 90vh" src="" alt="Phóng to ảnh">
                    </div>
                </div>
            </div>

        @endforeach
    @endforeach
@endif
<!-- ckeditor -->
<script src="https://unpkg.com/@ckeditor/ckeditor5-build-classic@12.2.0/build/ckeditor.js"></script>
<!-- prismjs plugin -->

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
    document.addEventListener('click', function (event) {
        // Sự kiện cho nút hiển thị form 'Thêm mục'
        if (event.target.classList.contains('display-checklist')) {
            const formElement = event.target.closest('.row').querySelector('.addOrUpdate-checklist');
            formElement.classList.toggle('d-none'); // Hiện hoặc ẩn form
            event.target.classList.add('d-none'); // Ẩn nút hiển thị form
        }

        // Sự kiện cho nút 'Hủy'
        if (event.target.classList.contains('disable-checklist')) {
            const formElement = event.target.closest('.row').querySelector('.addOrUpdate-checklist');
            const inputElement = formElement.querySelector('.checklistItem');
            inputElement.value = ""; // Xóa nội dung ô nhập liệu
            formElement.classList.add('d-none'); // Ẩn form
            event.target.closest('.row').querySelector('.display-checklist').classList.remove('d-none'); // Hiện lại nút hiển thị form
        }
    });


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

    // Lặp qua tất cả các phần tử delete-archiver và thêm sự kiện
    deleteArchivers.forEach((deleteArchiver) => {
        deleteArchiver.addEventListener('click', () => {
            window.location.reload();
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

{{--xử lý hiện ảnh ở tệp đính kèm--}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Lấy tất cả các ảnh có class thumbnail
        var thumbnails = document.querySelectorAll('.thumbnail');
        var modalImage = document.getElementById('modalImage');
        var imageModal = document.getElementById('imageModal');

        // Lặp qua tất cả các ảnh thu nhỏ
        thumbnails.forEach(function (thumbnail) {
            thumbnail.addEventListener('click', function () {
                // Lấy src của ảnh thu nhỏ và gán vào modal ảnh
                modalImage.src = thumbnail.src;


                // Lấy id của modal task chính từ thuộc tính data-modal-id của ảnh
                var taskModalId = thumbnail.getAttribute('data-modal-id');
                var taskModal = new bootstrap.Modal(document.getElementById(taskModalId), {});

                // Hàm xử lý khi modal ảnh đóng
                function handleModalClose() {
                    taskModal.show();
                    // Gỡ bỏ sự kiện này để nó không bị gọi lại khi đóng modal ảnh
                    imageModal.removeEventListener('hidden.bs.modal', handleModalClose);
                }

                // Lắng nghe sự kiện modal ảnh bị đóng và mở lại modal task
                imageModal.addEventListener('hidden.bs.modal', handleModalClose);
            });
        });
    });

</script>
