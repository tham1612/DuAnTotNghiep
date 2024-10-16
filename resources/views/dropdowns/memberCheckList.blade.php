<h5 class="text-center">Thành viên</h5>
<form action="">
    <input type="text" name="" id="" class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

    @php
        $boardMembers = session('boardMembers');

    @endphp
        <!-- thành viên của thẻ -->
    <div class="mt-3">
        <label class="fs-14">Thành viên của thẻ</label>
        <ul id="cardMembersList-{{$checklistItem->id}}" class="" style="list-style: none; margin-left: -32px">
            @if(!empty($checklistItem->checkListItemMembers))
                @foreach ($checklistItem->checkListItemMembers as $checkListItemMember)
                    <li id="card-member-{{$checkListItemMember->user->id}}-{{$checkListItemMember->check_list_item_id}}" class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="javascript: void(0);" class="avatar-group-item"
                               data-bs-toggle="tooltip" data-bs-placement="top"
                               title="{{$checkListItemMember->user->name}}">
                                @if ($checkListItemMember->user->image)
                                    <img src="{{ asset('storage/' . $checkListItemMember->user->image) }}"
                                         alt="" class="rounded-circle avatar-sm object-fit-cover"
                                         style="width: 40px;height: 40px">
                                @else
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                            {{ strtoupper(substr($checkListItemMember->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                @endif
                            </a>
                            <p class="ms-3 mt-3">{{$checkListItemMember->user->name}}</p>
                        </div>
                        <i class="ri-close-line fs-20" onclick="removeMemberFromCard({{$checkListItemMember->user->id}}, {{$checkListItemMember->check_list_item_id}})"></i>
                    </li>
                @endforeach
            @endif
            <!-- Thành viên của thẻ sẽ được thêm vào đây bằng JavaScript -->
        </ul>

    </div>

    <!-- thành viên của bảng -->
    <div class="mt-3">
        <label class="fs-14">Thành viên của bảng</label>
        <ul class="" style="list-style: none; margin-left: -32px">
            @php $boardMembers=  session('boardMembers');@endphp
            @foreach ($boardMembers as $boardMember)
                <li class="d-flex justify-content-between align-items-center board-member-item"
                    data-member-id="{{ $boardMember['id'] }}" data-check-list-item="{{$checklistItem->id}}"
                    data-member-name="{{ $boardMember['name'] }}">
                    <div class="d-flex align-items-center">
                        <a href="javascript: void(0);" class="avatar-group-item"
                           data-bs-toggle="tooltip" data-bs-placement="top"
                           title="{{ $boardMember['name'] }}">
                            @if ($boardMember['image'])
                                <img src="{{ asset('storage/' . $boardMember->image) }}"
                                     alt="" class="rounded-circle avatar-sm object-fit-cover"
                                     style="width: 40px;height: 40px">
                            @else
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded-circle bg-light text-primary">
                                        {{ strtoupper(substr($boardMember['name'], 0, 1)) }}
                                    </div>
                                </div>
                            @endif
                        </a>
                        <p class="ms-3 mt-3">{{ $boardMember['name'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Thành viên Không gian làm việc -->
    @if($board->access->value == "public")
        <div class="mt-3">
            <strong class="fs-14">Thành viên Không gian làm việc</strong>
            <ul class="" style="list-style: none; margin-left: -32px">
                <li class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="javascript: void(0);" class="avatar-group-item"
                           data-bs-toggle="tooltip" data-bs-trigger="hover"
                           data-bs-placement="top" title="Nancy">
                            <img
                                src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                alt="" class="rounded-circle avatar-xs"/>
                        </a>
                        <p class="ms-3 mt-3">vinhpq</p>
                    </div>
                </li>
            </ul>
        </div>
    @endif
</form>

<script>

    function addMemberToCheckListItem(memberId, memberName, checklistItemId) {
        if (document.getElementById('card-member-' + memberId + '-' + checklistItemId)) {
            alert(memberName + " đã có trong danh sách thành viên của thẻ.");
            return;
        }
        $.ajax({
            url: `/checklistItem/addMemberChecklist`,
            type: 'POST',
            data: {
                user_id: memberId,
                check_list_item_id: checklistItemId,
            },
            success: function(response) {
                var cardMembersList = document.getElementById('cardMembersList' + checklistiemid);
                var listItem = `
                <li id="card-member-${memberId}-${checklistItemId}" class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" title="${memberName}">
                            <div class="avatar-sm">
                                <div class="avatar-title rounded-circle bg-light text-primary">
                                    ${memberName.charAt(0).toUpperCase()}
                                </div>
                            </div>
                        </a>
                        <p class="ms-3 mt-3">${memberName}</p>
                    </div>
                    <i class="ri-close-line fs-20" onclick="removeMemberFromCard(${memberId}, ${checklistItemId})"></i>
                </li>
            `;
                cardMembersList.innerHTML += listItem;
                console.log('Thành viên đã được thêm vào thẻ thành công.');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }


    function removeMemberFromCard(memberId, checklistItemId) {
        $.ajax({
            url: `/checklistItem/deleteMemberChecklist`,
            type: 'POST',
            data: {
                user_id: memberId,
                check_list_item_id:checklistItemId
            },
            success: function(response) {
                var memberElement = document.getElementById('card-member-' + memberId + '-' + checklistItemId);
                if (memberElement) {
                    memberElement.remove();
                }
                console.log('Thành viên đã được xóa thành công khỏi thẻ.');
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra khi xóa thành viên.');
                console.log(xhr.responseText);
            }
        });
    }


    // Thêm sự kiện click cho từng thành viên của bảng
    document.querySelectorAll('.board-member-item').forEach(item => {
        item.addEventListener('click', function () {
            var memberId = this.getAttribute('data-member-id');
            var memberName = this.getAttribute('data-member-name');
            var check_list_item_id = this.getAttribute('data-check-list-item');
            addMemberToCheckListItem(memberId, memberName,check_list_item_id);
        });
    });
</script>
