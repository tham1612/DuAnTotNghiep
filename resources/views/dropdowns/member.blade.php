<h5 class="text-center">Thành viên</h5>
<form action="">
    <input type="text" name="" id="" class="form-control border-1" placeholder="Tìm kiếm thành viên"/>

    @php
        $boardMembers = session('boardMembers');

    @endphp

        <!-- thành viên của thẻ -->
    <div class="mt-3">
        <label class="fs-14">Thành viên của Task</label>
        <ul id="cardMembersList-{{$task->id}}" class="" style="list-style: none; margin-left: -32px">
            @if(!empty($task->members))
                @foreach ($task->members as $taskMember)
                    <li id="card-member-{{$taskMember->id}}-{{$task->id}}" class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="javascript: void(0);" class="avatar-group-item"
                               data-bs-toggle="tooltip" data-bs-placement="top"
                               title="{{$taskMember->name}}">
                                @if ($taskMember->image)
                                    <img src="{{ asset('storage/' . $taskMember->image) }}"
                                         alt="" class="rounded-circle avatar-sm object-fit-cover"
                                         style="width: 40px;height: 40px">
                                @else
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                            {{ strtoupper(substr($taskMember->name, 0, 1)) }}
                                        </div>
                                    </div>
                                @endif

                            </a>
                            <p class="ms-3 mt-3">{{$taskMember->name}}</p>
                        </div>
                        <i class="ri-close-line fs-20" onclick="removeMemberFromTask({{$taskMember->id}}, {{$task->id}})"></i>
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
                    data-user-id="{{ $boardMember['id'] }}" data-task-id="{{$task->id}}"
                    data-user-name="{{ $boardMember['name'] }}">
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

    function addMemberToTask(user_id, name, task_id) {
        if (document.getElementById('card-member-' + user_id  + '-' + task_id)) {
            alert(name + " đã có trong danh sách thành viên của thẻ.");
            return;
        }
        $.ajax({
            url: `/tasks/addMember`,
            type: 'POST',
            data: {
                user_id: user_id,
                task_id: task_id,
            },
            success: function(response) {
                var cardMembersList = document.getElementById('cardMembersList-' + task_id);
                var listItem = `
                <li id="card-member-${user_id}-${task_id}" class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" title="${name}">
                            <div class="avatar-sm">
                                <div class="avatar-title rounded-circle bg-light text-primary">
                                    ${name.charAt(0).toUpperCase()}
                                </div>
                            </div>
                        </a>
                        <p class="ms-3 mt-3">${name}</p>
                    </div>
                    <i class="ri-close-line fs-20" onclick="removeMemberFromTask(${user_id}, ${task_id})"></i>
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


    function removeMemberFromTask(user_id, task_id) {
        console.log('User ID:', user_id, 'Task ID:', task_id);
        $.ajax({
            url: `/tasks/deleteTaskMember`,
            type: 'POST',
            data: {
                user_id: user_id,
                task_id: task_id
            },
            success: function(response) {
                var memberElement = document.getElementById('card-member-' + user_id + '-' + task_id);
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.board-member-item').forEach(item => {
            item.addEventListener('click', function () {
                var user_id = this.getAttribute('data-user-id');
                var name = this.getAttribute('data-user-name');
                var task_id = this.getAttribute('data-task-id');

                addMemberToTask(user_id, name, task_id);

                // Ẩn thành viên này trong danh sách
                this.style.display = 'none'; // Ẩn item
            });
        });
    });

</script>
