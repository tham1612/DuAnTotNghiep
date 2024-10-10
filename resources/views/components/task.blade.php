<!-- chi tiết thẻ -->
@if(!empty($tasks))
    @foreach ($tasks as $task)
        <div class="modal fade" id="detailCardModal{{ $task->id }}" tabindex="-1" aria-labelledby="detailCardModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 rounded-3">

                    <div class="modal-header p-3"
                         style="
                      height: 150px;
                      object-fit: cover;
                       @if($task->image)
                           background-image:url('{{ asset('storage/' . $task->image) }}');
                       @else
                            background-image:url('{{asset('theme/assets/images/small/img-7.jpg')}}');
                       @endif
                    "
                         id="detailCardModalLabel">
                        <div></div>
                        <button type="button" class="btn-close bg-white" style="margin: -100px -5px 0px 0px"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#">
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
                                        <div class="col-12 d-flex mt-3">
                                            @if($task->members->count() > 1)
                                                <div class="p-3 col-3">
                                                    <strong>Thành viên</strong>
                                                    <section class="d-flex">
                                                        <!-- thêm thành viên & chia sẻ link bảng -->
                                                        <div
                                                            class="d-flex justify-content-center align-items-center cursor-pointer ">
                                                            <div class="col-auto ms-sm-auto">
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
                                                                                   class="avatar-group-item"
                                                                                   data-bs-toggle="tooltip"
                                                                                   data-bs-placement="top"
                                                                                   title="{{ $taskMember['name'] }}">
                                                                                    @if ($taskMember['image'])
                                                                                        <img
                                                                                            src="{{ asset('storage/' . $taskMember->image) }}"
                                                                                            alt=""
                                                                                            class="rounded-circle avatar-sm">
                                                                                    @else
                                                                                        <div class="avatar-sm">
                                                                                            <div
                                                                                                class="avatar-title rounded-circle bg-light text-primary">
                                                                                                {{ strtoupper(substr($taskMember['name'], 0, 1)) }}
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </a>
                                                                                @php $count++; @endphp
                                                                            @endif
                                                                        @endforeach

                                                                        @if ($task->members->count() > $maxDisplay)
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
                                                @php $memberFollow = \App\Models\Follow_member::where('task_id', $task->id)
                                                        ->where('user_id', auth()->id())
                                                        ->value('follow');
                                                @endphp
                                                <div
                                                    class="d-flex align-items-center justify-content-between rounded p-3 text-white cursor-pointer"
                                                    style="height: 35px; background-color: #c7c7c7"
                                                    id="notification_{{$task->id}}"
                                                    onclick="updateTaskMember({{ $task->id }}, {{ auth()->id() }})">
                                                    <i class="@if($memberFollow == 0)
                                                    ri-eye-off-line @elseif($memberFollow == 1) ri-eye-line @endif
                                                    fs-22" id="notification_icon_{{$task->id}}"></i>
                                                    <p class="ms-2 mt-3" id="notification_content_{{$task->id}}">Theo
                                                        dõi</p>
                                                    <div @if( $memberFollow == 0) class="d-none"
                                                         @endif id="notification_follow_{{$task->id}}">
                                                        <i class="ri-check-line fs-22 bg-light ms-2 rounded"
                                                           style="color: black"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(!empty($task->end_date) || !empty($task->start_date))
                                                <div class="p-3 ">
                                                    <strong>Ngày hết hạn</strong>
                                                    @php
                                                        $now = \Carbon\Carbon::now();
                                                        $endDate = \Carbon\Carbon::parse($task->end_date);
                                                    @endphp
                                                    <div
                                                        class="d-flex align-items-center justify-content-between rounded p-3 text-white cursor-pointer"
                                                        style="height: 35px; background-color: #c7c7c7">
                                                        <input type="checkbox" id="due_date_checkbox_{{ $task->id }}"
                                                               class="form-check-input"
                                                               onchange="updateTask2({{ $task->id }})" name="progress"
                                                               @if($task->progress == 100 ) checked @endif />
                                                        <p class="ms-2 mt-3">{{ $task->end_date }}</p>
                                                        <span
                                                            class="badge bg-success ms-2 {{ $now->gt($endDate) ? 'd-none' : '' }}"
                                                            id="due_date_success_{{ $task->id }}">Hoàn tất</span>
                                                        <span
                                                            class="badge bg-danger ms-2 {{ $now->gt($endDate) ? '' : 'd-none' }}"
                                                            id="due_date_due_{{ $task->id }}">Quá hạn</span>
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
                                            {{--                                    <textarea name="description" id="description_{{ $task->id}}" cols="25" rows="5"--}}
                                            {{--                                              class="form-control bg-light"--}}
                                            {{--                                              placeholder="Thêm mô tả chi tiết"--}}
                                            {{--                                              onchange="updateTask2({{ $task->id }})">{{$task->description}}</textarea>--}}
                                            <form class=" flex-column">
                                            <textarea name="content" class="form-control "
                                                      id="description_{{ $task->id}}" placeholder="Viết bình luận"
                                            >{{$task->description}}</textarea>
                                                <button class="btn btn-primary mt-2 writeComment"
                                                        data-value="{{$task->id}}">
                                                    Lưu
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @if(false)
                                        <!-- tệp -->
                                        <div class="row mt-3">
                                            <section class="d-flex">
                                                <i class="ri-link-m fs-22"></i>
                                                <p class="fs-18 ms-2 mt-1">Tệp đính kèm</p>
                                            </section>
                                            <div class="ps-4">
                                                <strong>Thẻ tên dự án</strong>
                                                <div class="d-flex flex-wrap row mt-2" style="align-items: start">
                                                    <!-- start card -->
                                                    <div class="col-6">
                                                        <div class="card card-height-100">
                                                            <div class="card-body">
                                                                <div class="d-flex flex-column h-100">
                                                                    <div class="d-flex">
                                                                        <div class="flex-grow-1">
                                                                            <p class="text-muted"></p>
                                                                        </div>
                                                                        <!--   cài đặt thẻ link-->
                                                                        <div class="flex-shrink-0">
                                                                            <div
                                                                                class="d-flex gap-1 align-items-center">
                                                                                <i class="ri-more-fill fs-20 cursor-pointer"
                                                                                   data-bs-toggle="dropdown"
                                                                                   aria-haspopup="true"
                                                                                   aria-expanded="false"></i>
                                                                                <div
                                                                                    class="dropdown-menu dropdown-menu-md"
                                                                                    style="padding: 15px 15px 0 15px">
                                                                                    <h5 class="text-center">Thao tác
                                                                                        mục</h5>
                                                                                    <p class="mt-2">liên kết thẻ</p>
                                                                                    <p>Xóa</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="d-flex mb-2 rounded bg-info-subtle p-2">
                                                                        <div class="flex-grow-1">
                                                                            <h5>Tên thẻ</h5>
                                                                            <div class="d-flex">
                                                                    <span class="badge bg-success me-1">giao
                                                                        diện</span>
                                                                                <span
                                                                                    class="badge bg-danger">code khó</span>
                                                                            </div>
                                                                            <div
                                                                                class="mt-3 d-flex justify-content-between">
                                                                                <div class="avatar-group">
                                                                                    <a href="javascript: void(0);"
                                                                                       class="avatar-group-item border-0"
                                                                                       data-bs-toggle="tooltip"
                                                                                       data-bs-trigger="hover"
                                                                                       data-bs-placement="top"
                                                                                       title="Darline Williams">
                                                                                        <div class="avatar-xxs">
                                                                                            <img
                                                                                                src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                                                                alt=""
                                                                                                class="rounded-circle img-fluid"/>
                                                                                        </div>
                                                                                    </a>

                                                                                </div>
                                                                                <ul class="link-inline mb-0">
                                                                                    <!-- theo dõi -->
                                                                                    <li class="list-inline-item">
                                                                                        <a href="javascript:void(0)"
                                                                                           class="text-muted"><i
                                                                                                class="ri-eye-line align-bottom"></i>
                                                                                            04</a>
                                                                                    </li>
                                                                                    <!-- bình luận -->
                                                                                    <li class="list-inline-item">
                                                                                        <a href="javascript:void(0)"
                                                                                           class="text-muted"><i
                                                                                                class="ri-question-answer-line align-bottom"></i>
                                                                                            19</a>
                                                                                    </li>
                                                                                    <!-- tệp đính kèm -->
                                                                                    <li class="list-inline-item">
                                                                                        <a href="javascript:void(0)"
                                                                                           class="text-muted"><i
                                                                                                class="ri-attachment-2 align-bottom"></i>
                                                                                            02</a>
                                                                                    </li>
                                                                                    <!-- checklist -->
                                                                                    <li class="list-inline-item">
                                                                                        <a href="javascript:void(0)"
                                                                                           class="text-muted"><i
                                                                                                class="ri-checkbox-line align-bottom"></i>
                                                                                            2/4</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end card body -->
                                                            <div
                                                                class="card-footer bg-transparent border-top-dashed py-2">
                                                                <div class="flex-grow-1">Tên bảng : Tên list</div>
                                                            </div>
                                                            <!-- end card footer -->
                                                        </div>
                                                        <!-- end card -->
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="ps-4">
                                                <strong>Tệp & liên kết</strong>
                                                <div class="table-responsive table-hover table-card">
                                                    <table class="table table-nowrap mt-4">
                                                        <tbody>
                                                        <tr class="cursor-pointer">
                                                            <td class="col-1">
                                                                <i class="ri-table-line fs-20 text-primary"></i>
                                                            </td>
                                                            <td class="text-start">FPT Polytecnic</td>
                                                            <td class="text-end">
                                                                <i class="ri-more-fill fs-20 cursor-pointer"
                                                                   data-bs-toggle="dropdown" aria-haspopup="true"
                                                                   aria-expanded="false"></i>
                                                                <div class="dropdown-menu dropdown-menu-md"
                                                                     style="padding: 15px 15px 0 15px">
                                                                    <h5 class="text-center">Thao tác mục</h5>
                                                                    <p class="mt-2">Chỉnh sửa</p>
                                                                    <p class="mt-2">Nhận xét</p>
                                                                    <p>Xóa</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(false)
                                        <!-- việc cần làm -->
                                        <div class="row mt-3">
                                            <section class="d-flex justify-content-between">
                                                <section class="d-flex">
                                                    <i class="ri-checkbox-line fs-22"></i>
                                                    <p class="fs-18 ms-2 mt-1">Việc cần làm</p>
                                                </section>
                                                <button class="btn btn-outline-dark" style="height: 35px"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Xóa
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                    <h5 class="text-center">Bạn có muốn xóa Việc cần làm</h5>

                                                    <p>Danh sách sẽ bị xóa vĩnh viễn và không thể khôi phục</p>

                                                    <button class="btn btn-danger w-100">Xóa danh sách công việc
                                                    </button>
                                                </div>
                                            </section>

                                            <div class="ps-4">
                                                <div class="progress animated-progress bg-light-subtle"
                                                     style="height: 20px">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         style="width: 50%"
                                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                        50%
                                                    </div>
                                                </div>
                                                <div class="table-responsive table-hover table-card">
                                                    <table class="table table-nowrap mt-4">
                                                        <tbody>
                                                        <tr class="cursor-pointer">
                                                            <td class="col-1">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           value="" id="cardtableCheck01"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p>checklist1</p>
                                                            </td>
                                                            <td class=" d-flex justify-content-end">
                                                                <div>
                                                                    <i class="ri-time-line fs-20 ms-2"
                                                                       data-bs-toggle="dropdown" aria-haspopup="true"
                                                                       aria-expanded="false"></i>
                                                                    <div
                                                                        class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                        @include('dropdowns.date')
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <i class="ri-user-add-line fs-20 ms-2"
                                                                       data-bs-toggle="dropdown" aria-haspopup="true"
                                                                       aria-expanded="false"></i>
                                                                    <div
                                                                        class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                        @include('dropdowns.member')
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <i class="ri-more-fill fs-20 ms-2"
                                                                       data-bs-toggle="dropdown" aria-haspopup="true"
                                                                       aria-expanded="false"></i>
                                                                    <div class="dropdown-menu dropdown-menu-md"
                                                                         style="padding: 15px 15px 0 15px">
                                                                        <h5 class="text-center">Thao tác mục</h5>
                                                                        <p class="mt-2">Chuyển sang thẻ</p>
                                                                        <p>Xóa</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="cursor-pointer addOrUpdate-checklist d-none">
                                                            <td class="col-1">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           value=""/>
                                                                </div>
                                                            </td>
                                                            <td colspan="2">
                                                                <form action="" class="w-100 " aria-labelledby="">
                                                                    <input type="text" name=""
                                                                           class="form-control checklistItem"
                                                                           placeholder="Thêm mục"/>
                                                                    <div class="d-flex mt-3 justify-content-between">
                                                                        <div>
                                                                            <button class="btn btn-primary">Thêm
                                                                            </button>
                                                                            <button
                                                                                class="btn btn-outline-dark disable-checklist">
                                                                                Hủy
                                                                            </button>
                                                                        </div>
                                                                        <div class="d-flex">
                                                                            <div>
                                                                                <i class="ri-time-line fs-20 ms-2"></i>
                                                                                <span data-bs-toggle="dropdown"
                                                                                      aria-haspopup="true"
                                                                                      aria-expanded="false">Ngày hết hạn
                                                                        </span>
                                                                                <div
                                                                                    class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                                    @include('dropdowns.date')
                                                                                </div>
                                                                            </div>

                                                                            <div>
                                                                                <i class="ri-user-add-line fs-20 ms-2"></i>
                                                                                <span data-bs-toggle="dropdown"
                                                                                      aria-haspopup="true"
                                                                                      aria-expanded="false">Chỉ định
                                                                        </span>
                                                                                <div
                                                                                    class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                                                    @include('dropdowns.member')
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn btn-outline-dark ms-3 mt-2 display-checklist"
                                                        type="button">
                                                    Thêm mục
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mt-4">
                                        <section class="d-flex">
                                            <i class="ri-line-chart-line fs-22"></i>
                                            <p class="fs-18 ms-2 mt-1">Hoạt động</p>
                                        </section>
                                        <div class="">
                                            <div class="d-flex">
                                                @if (auth()->user()->image)
                                                    <img class="rounded header-profile-user object-fit-cover"
                                                         src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->image) }}"
                                                         alt="Avatar"/>
                                                @else
                                                    <div
                                                        class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                        style="width: 40px;height: 40px">
                                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="ms-2">
                                                    <form action="#" method="post" class=" flex-column">
                                                    <textarea name="content" class="form-control "
                                                              id="editor_{{$task->id}}"
                                                              placeholder="Viết bình luận"></textarea>
                                                        <button type="submit" class="btn btn-primary mt-2">Lưu
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>

                                            {{-- <textarea name="" cols="25" rows="5" class="form-control bg-light"
                                                      placeholder="Viết bình luận...">
                                                    </textarea> --}}
                                            {{-- @foreach ($activities as $activity)
                                            <li class="d-flex align-items-start mb-3">
                                                <div class="me-3">
                                                    <img src="{{ asset('path_to_avatar/' . ($activity->causer->avatar ?? 'default_avatar.png')) }}" alt="avatar" class="rounded-circle" width="40" height="40">
                                                </div>
                                                <div>
                                                    <p class="mb-1">
                                                        <strong>{{ $activity->causer->name ?? 'Hệ thống' }}:</strong>
                                                        {{ $activity->description ?? 'Không có mô tả' }}
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ $activity && $activity->created_at ? $activity->created_at->diffForHumans() : 'Không xác định thời gian' }}
                                                    </small>



                                                </div>
                                            </li>
                                        @endforeach --}}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <h5 class="mt-3 mb-3"><strong>Thêm vào thẻ</strong></h5>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-user"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10">
                                                Thành viên
                                            </p>
                                            <!--dropdown thành viên-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                                @include('dropdowns.member')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-tag"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-check-square"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10">
                                                Việc cần làm
                                            </p>
                                            <!-- dropdown việc cần làm-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                                @include('dropdowns.checklist')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-clock"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10">
                                                Ngày
                                            </p>
                                            <!-- dropdown ngày-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                                @include('dropdowns.date')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-paperclip"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10">
                                                Đính kèm
                                            </p>
                                            <!--                                    dropdown tệp đính kèm-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                                @include('dropdowns.attach')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-map-marker"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">
                                                Vị trí
                                            </p>
                                            <!--                                    dropdown vị trí-->
                                            <div class="dropdown-menu dropdown-menu-md p-4">
                                                <form>
                                                    <h5 class="mb-3" style="text-align: center">Thêm vị trí</h5>
                                                    <div class="mb-2">
                                                        <input type="search" class="form-control"
                                                               placeholder="Tìm kiếm vị trí"/>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-credit-card"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10">
                                                Ảnh bìa
                                            </p>
                                            <!--                                    dropdown ảnh bìa-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                                @include('dropdowns.imagePhoto')
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mt-3 mb-3"><strong>Thao tác</strong></h5>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style="height: 30px; background-color: #c7c7c7">
                                            <i class="las la-arrow-circle-right"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-copy"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10">
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
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="ri-archive-line"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">
                                                Lưu trữ
                                            </p>
                                            <div></div>
                                        </div>
                                    </div>
                                    <!--                            hoàn tác-->
                                    <div class="d-flex mt-3 mb-3 cursor-pointer restore-archiver d-none">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las la-window-restore"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">
                                                Khôi phục
                                            </p>
                                            <div></div>
                                        </div>
                                    </div>
                                    <!--                            xóa vĩnh viễn-->
                                    <div class="d-flex mt-3 mb-3 cursor-pointer delete-archiver d-none">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3  w-100"
                                            style=" height: 30px; background-color: red">
                                            <i class="las la-window-restore"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">
                                                Xóa
                                            </p>
                                            <div></div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded p-3 text-white w-100"
                                            style=" height: 30px; background-color: #c7c7c7">
                                            <i class="las ri-share-line"></i>
                                            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10">Chia sẻ</p>
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                                @include('dropdowns.share')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ckeditor -->
        <script src="https://unpkg.com/@ckeditor/ckeditor5-build-classic@12.2.0/build/ckeditor.js"></script>
        <!-- prismjs plugin -->
        <script>
            ClassicEditor
                .create(
                    document.querySelector('#editor_{{$task->id}}')
                );

            ClassicEditor
                .create(
                    document.querySelector('#description_{{$task->id}}'),
                );
        </script>
    @endforeach
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationElements = document.querySelectorAll('[id^="notification_"]');

        // Duyệt qua từng phần tử để thêm sự kiện click
        notificationElements.forEach(notification => {
            notification.addEventListener('click', function () {
                // Lấy taskId từ id của phần tử
                const taskId = this.id.split('_')[1];

                // Lấy các phần tử liên quan
                const followElement = document.getElementById(`notification_follow_${taskId}`);
                const contentElement = document.getElementById(`notification_content_${taskId}`);
                const iconElement = document.getElementById(`notification_icon_${taskId}`);

                // Kiểm tra trạng thái hiện tại
                if (followElement.classList.contains('d-none')) {
                    // Nếu đang ẩn (chưa theo dõi), bật theo dõi
                    followElement.classList.remove('d-none'); // Hiện icon dấu check
                    contentElement.innerText = 'Đang theo dõi'; // Thay đổi nội dung
                    iconElement.classList.replace('ri-eye-off-line', 'ri-eye-line');// Thay đổi icon
                } else {
                    // Nếu đang hiển thị (đang theo dõi), bỏ theo dõi
                    followElement.classList.add('d-none'); // Ẩn icon dấu check
                    contentElement.innerText = 'Theo dõi'; // Quay lại nội dung cũ

                    iconElement.classList.replace('ri-eye-line', 'ri-eye-off-line');// Thay đổi icon về cũ
                }

                // In ra taskId để kiểm tra
                console.log('Bạn đã click vào thông báo của task với ID:', taskId);
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[id^="due_date_checkbox_"]').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const taskId = this.id.split('due_date_checkbox_')[1];  // Lấy taskId từ id của checkbox

                const successBadge = document.getElementById(`due_date_success_${taskId}`);
                const dueBadge = document.getElementById(`due_date_due_${taskId}`);

                if (!successBadge || !dueBadge) {
                    console.error('Không tìm thấy badge với id tương ứng:', taskId);
                    return;
                }

                if (this.checked) {
                    console.log('Chuyển sang "Hoàn tất" cho task:', taskId);
                    successBadge.classList.remove('d-none'); // Hiện "Hoàn tất"
                    dueBadge.classList.add('d-none'); // Ẩn "Quá hạn"
                } else {
                    console.log('Chuyển sang "Quá hạn" cho task:', taskId);
                    successBadge.classList.add('d-none'); // Ẩn "Hoàn tất"
                    dueBadge.classList.remove('d-none'); // Hiện "Quá hạn"
                }
            });
        });
    });

    function updateTask2(taskId) {
        var checkbox = document.getElementById('due_date_checkbox_' + taskId);
        var formData = {
            // catalog_id: $('#catalog_id_' + taskId).val(),
            // start_date: $('#start_date_' + taskId).val(),
            description: $('#description_' + taskId).val(),
            text: $('#text_' + taskId).val(),
            progress: checkbox.checked ? 100 : 0,

        };
        console.log(formData);
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

    function updateTaskMember(taskId, userId) {

        $.ajax({
            url: `/tasks/${taskId}/updateFolow`,
            method: "PUT",
            data: {
                task_id: taskId,
                user_id: userId,
            },
            success: function (response) {
                console.log('Người dùng đã folow Task:', response);

            },
            error: function (xhr) {
                console.error('An error occurred:', xhr.responseText);
            }
        });
    }

</script>
