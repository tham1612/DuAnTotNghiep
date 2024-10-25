@if (!empty($task->check_lists) && !empty($task))
    @foreach ($task->check_lists as $checklist)
        @php $checklist = json_decode(json_encode($checklist)); @endphp
        <!-- việc cần làm -->
        <div class="row mt-3 list-checklist-{{ $checklist->id }}">
            <section class="d-flex justify-content-between">
                <section class="d-flex">
                    <i class="ri-checkbox-line fs-22"></i>
                    <!-- Lặp qua từng checklist -->
                    <input type="text" name="name"
                        class="form-control border-0 ms-1 fs-18 fw-medium bg-transparent ps-0"
                        id="name_{{ $checklist->id }}" value="{{ $checklist->name }}"
                        onchange="submitUpdateCheckList({{ $checklist->id }},{{ $task->id }})" />
                </section>
                <button class="btn btn-outline-dark" style="height: 35px" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Xóa
                </button>
                <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                    <h5 class="text-center">Bạn có muốn xóa Việc cần làm</h5>

                    <p>Danh sách sẽ bị xóa vĩnh viễn và không thể khôi phục</p>

                    <button class="btn btn-danger w-100" onclick="removeCheckList({{ $checklist->id }})">Xóa danh sách
                        công việc
                    </button>
                </div>
            </section>

            <div class="ps-4">
                <div class="progress animated-progress bg-light-subtle" style="height: 20px"
                    data-checklist-id="{{ $checklist->id }}">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%"
                        id="progress-bar-checklist-{{ $checklist->id }}" aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100">
                        0%
                    </div>
                </div>
                <div class="table-responsive table-hover table-card">
                    <table class="table table-nowrap mt-4">
                        <tbody id="check-list-{{ $checklist->id }}">
                            @foreach ($checklist->check_list_items as $checklistItem)
                                @php  $checklistItem= json_decode(json_encode($checklistItem));  @endphp
                                <tr class="cursor-pointer check-list-item-{{ $checklistItem->id }}">
                                    <td class="col-1">
                                        <div class="form-check">
                                            <input class="form-check-input-checkList" type="checkbox" name="is_complete"
                                                @checked($checklistItem->is_complete) value="100"
                                                id="is_complete-{{ $checklistItem->id }}"
                                                data-checklist-id="{{ $checklist->id }}"
                                                data-checklist-item-id="{{ $checklistItem->id }}"
                                                data-task-id="{{ $task->id }}" />
                                        </div>


                                    </td>
                                    <td>
                                        <p>{{ $checklistItem->name }}</p>
                                    </td>
                                    <td class=" d-flex justify-content-end">
                                        <div>
                                            @if (!empty($checklistItem->end_date))
                                                <span data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"
                                                    id="dropdownToggle_dateChecklistItem_{{ $checklistItem->id }}"
                                                    onclick="loadTaskFormAddDateCheckListItem({{ $checklistItem->id }})">
                                                    {{ $checklistItem->end_date }}
                                                </span>
                                            @else
                                                <i class="ri-time-line fs-20 " data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    onclick="loadTaskFormAddDateCheckListItem({{ $checklistItem->id }})"
                                                    id="dropdownToggle_dateChecklistItem_{{ $checklistItem->id }}"></i>
                                            @endif
                                            <div class="dropdown-menu dropdown-menu-md p-3 w-50"
                                                id="dropdown-content-add-date-check-list-item-{{ $checklistItem->id }}"
                                                aria-labelledby="dropdownToggle_dateChecklistItem_{{ $checklistItem->id }}">
                                                {{--                                      dropdowns.dateCheckList sẽ được gọi vô đây --}}
                                            </div>
                                        </div>


                                        <div class="d-flex ms-4">
                                            @if ($checklistItem->check_list_item_members)
                                                <div style="margin-right: -15px">
                                                    @php
                                                        // Đếm số lượng checkListItemMember
                                                        $maxDisplay = 3;
                                                        $count = 0;
                                                    @endphp

                                                    @foreach ($checklistItem->check_list_item_members as $checkListItemMember)
                                                        @php  $checkListItemMember= json_decode(json_encode($checkListItemMember));  @endphp
                                                        @if ($count < $maxDisplay)
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ $checkListItemMember->user->name }}">
                                                                @if ($checkListItemMember->user->image)
                                                                    <img src="{{ asset('storage/' . $checkListItemMember->user->image) }}"
                                                                        alt=""
                                                                        class="rounded-circle avatar-sm object-fit-cover"
                                                                        style="width: 20px;height: 20px">
                                                                @else
                                                                    <div class="avatar-sm">
                                                                        <div class="avatar-title rounded-circle bg-info-subtle text-primary"
                                                                            style="width: 30px;height: 30px">
                                                                            {{ strtoupper(substr($checkListItemMember->user->name, 0, 1)) }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </a>
                                                            @php $count++; @endphp
                                                        @endif
                                                    @endforeach

                                                    @if (count($checklistItem->check_list_item_members) > $maxDisplay)
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ count($checklistItem->check_list_item_members) - $maxDisplay }} more">
                                                            <div class="avatar-sm">
                                                                <div class="avatar-title rounded-circle">
                                                                    +{{ count($checklistItem->check_list_item_members) - $maxDisplay }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                            <i class="ri-user-add-line fs-20" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"
                                                onclick="loadChecklistItemFormAddMember({{ $checklistItem->id }},{{ $board->id }})"
                                                id="dropdownToggle_{{ $checklistItem->id }}"></i>
                                            <div id="dropdown-content-add-member-check-list-{{ $checklistItem->id }}"
                                                class="dropdown-menu dropdown-menu-md p-3 w-50">
                                                {{--                                        @include('dropdowns.memberCheckList', ['checklistItem' => $checklistItem]) --}}
                                            </div>
                                        </div>

                                        <div>
                                            <i class="ri-more-fill fs-20" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-md"
                                                style="padding: 15px 15px 0 15px">
                                                <h5 class="text-center">Thao tác
                                                    mục</h5>
                                                <p class="mt-2">Chuyển sang thẻ</p>
                                                <p class="cursor-pointer text-danger"
                                                    onclick="removeCheckListItem({{ $checklistItem->id }})">
                                                    Xóa</p>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="cursor-pointer addOrUpdate-checklist d-none">
                                <td colspan="2">
                                    <form class="formItem">
                                        <input type="hidden" name="check_list_id"
                                            id="check_list_id_{{ $checklist->id }}" value="{{ $checklist->id }}">
                                        <input type="text" name="name"
                                            id="name_check_list_item_{{ $checklist->id }}"
                                            class="form-control checklistItem" placeholder="Thêm mục" />

                                        <div class="d-flex mt-3 justify-content-between">
                                            <div>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="FormCheckListItem({{ $checklist->id }})">
                                                    Thêm
                                                </button>
                                                <a class="btn btn-outline-dark disable-checklist">Hủy</a>
                                            </div>

                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-outline-dark ms-3 mt-2 display-checklist" type="button" id="">
                    Thêm mục
                </button>
            </div>
        </div>
    @endforeach
@endif
<div id="checkListCreate"></div>
