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
        @foreach ($catalog->tasks as $task)
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
                                           onchange="updateTask2({{ $task->id }})" id="image_{{ $task->id }}">
                                </label>
                                {{--                                <input type="file" onchange="updateTask2({{ $task->id }})"--}}
                                {{--                                       class="profile-img-file-input d-inline"--}}
                                {{--                                       id="image_{{ $task->id }}" value="{{ $task->text }}">--}}
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
                                                @php
//                                                     $memberFollow = \App\Models\Follow_member::where('task_id', $task->id)
//                                                        ->where('user_id', auth()->id())
//                                                        ->value('follow');
                                                 $memberFollow1 = $task->followMembers->firstWhere('user_id', auth()->id());
                                                 $memberFollow = $memberFollow1 ? $memberFollow1->follow : 0;

                                                @endphp
                                                <div
                                                    class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                                                    style="height: 35px; background-color: #091e420f; color: #172b4d"
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
                                                    @if(!empty($task->end_date) || !empty($task->start_date))
                                                        <p class="ms-2 mt-3">{{ $task->end_date }}</p>
                                                    @endif
                                                    <span
                                                        class="badge bg-success ms-2 {{ $now->gt($endDate) ? 'd-none' : '' }}"
                                                        id="due_date_success_{{ $task->id }}">Hoàn tất</span>
                                                    <span
                                                        class="badge bg-danger ms-2 {{ $now->gt($endDate) ? '' : 'd-none' }}"
                                                        id="due_date_due_{{ $task->id }}">Quá hạn</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- mô tả -->
                                    <div class="row mt-3">
                                        <section class="d-flex">
                                            <i class="ri-menu-2-line fs-22"></i>
                                            <p class="fs-18 ms-2 mt-1">Mô tả</p>
                                        </section>
                                        <div class="ps-4"><textarea name="description"
                                                                    id="description_{{ $task->id}}"
                                                                    cols="25" rows="5"
                                                                    class="form-control bg-light editor"
                                                                    placeholder="Thêm mô tả chi tiết"
                                                                    onchange="updateTask2({{ $task->id }})">{{$task->description}}</textarea>
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

                                    @if(!empty($task->checklist))

                                        <!-- việc cần làm -->
                                        <div class="row mt-3">
                                            <section class="d-flex justify-content-between">
                                                <section class="d-flex">
                                                    <i class="ri-checkbox-line fs-22"></i>
                                                     <!-- Lặp qua từng checklist -->
                                                    <p class="fs-18 ms-2 mt-1">{{ $task->checklist->name }}</p>

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
                                                            @foreach($task->checklist->checkListItems as $checklistItem)
                                                                <tr class="cursor-pointer">
                                                                    <td class="col-1">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                   type="checkbox" name="check_list_id"
                                                                                   value="{{$checklistItem->id}}"
                                                                                   id="check_list_{{$checklistItem->id}}"/>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{$checklistItem->name}}</p>
                                                                    </td>
                                                                    <td class=" d-flex justify-content-end">
                                                                        <div>
                                                                            @if(!empty($checklistItem->end_date))
                                                                                <span data-bs-toggle="dropdown"
                                                                                      aria-haspopup="true"
                                                                                      aria-expanded="false"
                                                                                      id="dropdownToggle_{{$checklistItem->id}}">
                                                                                    {{$checklistItem->end_date}}
                                                                                </span>

                                                                            @else
                                                                                <i class="ri-time-line fs-20 ms-2"
                                                                                   data-bs-toggle="dropdown"
                                                                                   aria-haspopup="true"
                                                                                   aria-expanded="false"
                                                                                   id="dropdownToggle_{{$checklistItem->id}}"></i>
                                                                            @endif
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-md p-3 w-50"
                                                                                aria-labelledby="dropdownToggle_{{$checklistItem->id}}">
                                                                                @include('dropdowns.dateCheckList', ['checklistItem' => $checklistItem])
                                                                            </div>
                                                                        </div>
                                                                        @if(!empty($checklistItem->checkListItemMembers))
                                                                            <div class="">
                                                                                @php
                                                                                    // Đếm số lượng checkListItemMember
                                                                                    $maxDisplay = 3;
                                                                                    $count = 0;
                                                                                @endphp

                                                                                @foreach ($checklistItem->checkListItemMembers as $checkListItemMember)
                                                                                    @if ($count < $maxDisplay)
                                                                                        <a href="javascript: void(0);"
                                                                                           class="avatar-group-item"
                                                                                           data-bs-toggle="tooltip"
                                                                                           data-bs-placement="top"
                                                                                           title="{{ $checkListItemMember->user->name }}">
                                                                                            @if ($checkListItemMember->user->image)
                                                                                                <img
                                                                                                    src="{{ asset('storage/' . $checkListItemMember->user->image) }}"
                                                                                                    alt=""
                                                                                                    class="rounded-circle avatar-sm object-fit-cover"
                                                                                                    style="width: 20px;height: 20px">
                                                                                            @else
                                                                                                <div class="avatar-sm">
                                                                                                    <div
                                                                                                        class="avatar-title rounded-circle bg-light text-primary">
                                                                                                        {{ strtoupper(substr($checkListItemMember->user->name, 0, 1)) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        </a>
                                                                                        @php $count++; @endphp
                                                                                    @endif
                                                                                @endforeach

                                                                                @if (count($checklistItem->checkListItemMembers) > $maxDisplay)
                                                                                    <a href="javascript: void(0);"
                                                                                       class="avatar-group-item"
                                                                                       data-bs-toggle="tooltip"
                                                                                       data-bs-placement="top"
                                                                                       title="{{ count($checklistItem->checkListItemMembers) - $maxDisplay }} more">
                                                                                        <div class="avatar-sm">
                                                                                            <div
                                                                                                class="avatar-title rounded-circle">
                                                                                                +{{ count($checklistItem->checkListItemMembers) - $maxDisplay }}
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <i class="ri-user-add-line fs-20 ms-2"
                                                                               data-bs-toggle="dropdown"
                                                                               aria-haspopup="true"
                                                                               aria-expanded="false"

                                                                               id="dropdownToggle_{{$checklistItem->id}}"></i>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-md p-3 w-50 ">
                                                                                @include('dropdowns.memberCheckList', ['checklistItem' => $checklistItem])
                                                                            </div>
                                                                        </div>

                                                                        <div>
                                                                            <i class="ri-more-fill fs-20 ms-2"
                                                                               data-bs-toggle="dropdown"
                                                                               aria-haspopup="true"
                                                                               aria-expanded="false"></i>
                                                                            <div class="dropdown-menu dropdown-menu-md"
                                                                                 style="padding: 15px 15px 0 15px">
                                                                                <h5 class="text-center">Thao tác
                                                                                    mục</h5>
                                                                                <p class="mt-2">Chuyển sang thẻ</p>
                                                                                <p>Xóa</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
{{--                                                                <tr class="cursor-pointer addOrUpdate-checklist d-none">--}}
{{--                                                                    <td colspan="2">--}}
{{--                                                                        <form--}}
{{--                                                                            onsubmit="return FormCheckListItem({{$checklist->id}})">--}}
{{--                                                                            <input type="hidden" name="check_list_id"--}}
{{--                                                                                   id="check_list_id_{{$checklist->id}}"--}}
{{--                                                                                   value="{{$checklist->id}}">--}}
{{--                                                                            <input type="text" name="name"--}}
{{--                                                                                   id="name_{{$checklist->id}}"--}}
{{--                                                                                   class="form-control checklistItem"--}}
{{--                                                                                   placeholder="Thêm mục"/>--}}
{{--                                                                            <div--}}
{{--                                                                                class="d-flex mt-3 justify-content-between">--}}
{{--                                                                                <div>--}}
{{--                                                                                    <button type="submit"--}}
{{--                                                                                            class="btn btn-primary">Thêm--}}
{{--                                                                                    </button>--}}
{{--                                                                                    <a class="btn btn-outline-dark disable-checklist">Hủy</a>--}}
{{--                                                                                </div>--}}

{{--                                                                            </div>--}}
{{--                                                                        </form>--}}
{{--                                                                    </td>--}}
{{--                                                                </tr>--}}
                                                            @endforeach
                                                        <tr class="cursor-pointer addOrUpdate-checklist d-none">
                                                            <td colspan="2">
                                                                <form class="formItem">
                                                                    <input type="hidden" name="check_list_id" id="check_list_id_{{$task->checklist->id}}" value="{{$task->checklist->id}}">
                                                                    <input type="text" name="name" id="name_{{$task->checklist->id}}" class="form-control checklistItem" placeholder="Thêm mục"/>

                                                                    <div class="d-flex mt-3 justify-content-between">
                                                                        <div>
                                                                            <button type="button" class="btn btn-primary" onclick="FormCheckListItem({{$task->checklist->id}})" >Thêm</button>
                                                                            <a class="btn btn-outline-dark disable-checklist">Hủy</a>
                                                                        </div>

                                                                    </div>
                                                                </form>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn btn-outline-dark ms-3 mt-2 display-checklist"
                                                        type="button" id="">
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
                                                    <textarea name="content" class="form-control editor"
                                                              id="comment_{{$task->id}}"
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
                                            class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                                            style=" height: 30px; background-color: #091e420f; color: #172b4d">
                                            <i class="las la-user fs-20"></i>
                                            <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                            class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                                            style=" height: 30px; background-color: #091e420f; color: #172b4d">
                                            <i class="las la-clock fs-20"></i>
                                            <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-bs-offset="-40,10"
                                               id="dropdownToggle_{{$task->id}}">
                                                Ngày
                                            </p>
                                            <!-- dropdown ngày-->
                                            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 150%">
                                                @include('dropdowns.date', ['task' => $task])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 mb-3 cursor-pointer">
                                        <div
                                            class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                                            style=" height: 30px; background-color: #091e420f; color: #172b4d">
                                            <i class="las la-paperclip fs-20"></i>
                                            <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                            class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                                            style=" height: 30px; background-color: #091e420f; color: #172b4d">
                                            <i class="las la-map-marker fs-20"></i>
                                            <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                            class="d-flex align-items-center justify-content-flex-start rounded fw-medium fs-15 p-3 w-100"
                                            style=" height: 30px; background-color: #091e420f; color: #172b4d">
                                            <i class="las la-credit-card fs-20"></i>
                                            <p class="ms-2 mt-3" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                                @include('dropdowns.copyTask')
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
                                                @include('dropdowns.share')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
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
            .create(editorElement)
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
    // xử lý checklist card
    const displayChecklistBtns = document.querySelectorAll('.display-checklist');
    const disableChecklistBtns = document.querySelectorAll('.disable-checklist');
    const checklistForms = document.querySelectorAll('.addOrUpdate-checklist');
    const checklistItems = document.querySelectorAll('.checklistItem');

    displayChecklistBtns.forEach((displayChecklistBtn, index) => {
        displayChecklistBtn.addEventListener('click', () => {
            checklistForms[index].classList.toggle('d-none'); // Hiện hoặc ẩn form
            displayChecklistBtn.classList.add('d-none'); // Ẩn nút hiện form
        });
    });

    disableChecklistBtns.forEach((disableChecklistBtn, index) => {
        disableChecklistBtn.addEventListener('click', () => {
            checklistItems[index].value = ""; // Xóa nội dung ô nhập liệu
            checklistForms[index].classList.add('d-none'); // Ẩn form
            displayChecklistBtns[index].classList.toggle('d-none'); // Hiện lại nút hiện form
        });
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

    // //     xử lý theo dõi + ngày hết hạn của card
    // const notification = document.querySelector('#notification');
    // const notification_follow = document.querySelector('#notification_follow');
    // const notification_icon = document.querySelector('#notification_icon');
    // const notification_content = document.querySelector('#notification_content');
    // notification.addEventListener('click', () => {
    //     notification_follow.classList.toggle('d-none');
    //     notification_icon.classList.contains("ri-eye-line") ?
    //         notification_icon.className = "ri-eye-off-line fs-22" :
    //         notification_icon.className = "ri-eye-line fs-22";
    //     notification_content.textContent === "Theo dõi" ?
    //         notification_content.innerHTML = "Đang theo dõi" :
    //         notification_content.innerHTML = "Theo dõi";
    // });
    //
    // const due_date_checkbox = document.querySelector('#due_date_checkbox');
    // const due_date_success = document.querySelector('#due_date_success');
    // const due_date_due = document.querySelector('#due_date_due');
    // due_date_checkbox.addEventListener('click', () => {
    //     due_date_due.classList.toggle('d-none');
    //     due_date_success.classList.toggle('d-none');
    // });
</script>

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
        var description = editors['description_' + taskId].getData();
        var checkbox = document.getElementById('due_date_checkbox_' + taskId);
        var image = document.getElementById('image_' + taskId);

        var formData = new FormData();
        formData.append('description', description);
        formData.append('text', $('#text_' + taskId).val());
        formData.append('progress', checkbox.checked ? 100 : 0);

        // Kiểm tra và thêm file ảnh nếu có
        if (image.files.length > 0) {
            formData.append('image', image.files[0]);
        }
        formData.append('_method', 'PUT');
        console.log([...formData]);
        console.log(image);
        $.ajax({
            url: `/tasks/` + taskId,
            method: "POST",  // Sử dụng POST nhưng với method PUT
            dataType: 'json',
            data: formData,
            processData: false,  // Bắt buộc phải false để không xử lý FormData thành chuỗi
            contentType: false,  // Bắt buộc phải false để đặt đúng 'multipart/form-data'
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

    function FormCheckListItem(checkListId) {
        var formData = {
            check_list_id: $('#check_list_id_' + checkListId).val(),
            name: $('#name_' + checkListId).val()
        };
        if (!formData.name.trim()) {
            alert('Tiêu đề không được để trống!');
            return false;
        }
        console.log(formData);
        $.ajax({
            url: `/tasks/checklist/checklistItem/create`,
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log('CheckListItem đã được thêm thành công!', response);
                $(this).find('button[type="submit"]').prop('disabled', false);
            },
            error: function (xhr) {
                alert('Đã xảy ra lỗi!');
                console.log(xhr.responseText);
                $(this).find('button[type="submit"]').prop('disabled', false);
            }
        });

        return false;
    }


</script>
