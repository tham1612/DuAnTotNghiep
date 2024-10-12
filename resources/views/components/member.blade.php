<!-- chia sẻ bảng & thêm thành viên -->
<div class="modal fade" id="addmemberModal" tabindex="-1" aria-labelledby="addmemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="addmemberModalLabel">
                    Chia sẻ bảng
                </h5>
                <button type="button" class="btn-close" id="btn-close-member" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row g-3">
                    <form action="{{ route('b.invite_board') }}" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $board->id }}">
                        <div class=" d-flex justify-content-between">
                            <div class="col-6">
                                <input type="text" class="form-control" id="submissionidInput"
                                    placeholder="Nhập email hoặc tên người dùng" name="email" />
                            </div>
                            <div class="col-4 ms-2">
                                <select name="authorize" id="" class="form-select">
                                    <option value="Member">Thành Viên</option>
                                    <option value="Sub_Owner">Phó nhóm</option>
                                    <option value="Viewer">Người Xem</option>
                                </select>
                            </div>
                            <div class="col-2 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">
                                    Chia sẻ
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--end col-->
                    <div class="d-flex justify-content-between">
                        <div class="col-1">
                            <a href="#">
                                <i id="copy-icon" class="ri-attachment-2 fs-22" onclick="copyLink()"></i>
                            </a>
                        </div>
                        <div class="col-6 d-flex flex-column">
                            <section class="fs-12">
                                <p style="margin-bottom: -5px;">Bất kỳ ai có thể theo gia với tư cách thành viên</p>
                                <span><a href="#" onclick="copyLink()">Sao chép liên kết</a></span>
                            </section>
                        </div>
                        <div class="col-5">
                            <select name="members" class="form-select invite-member-select">
                                <option value="">Thành viên trong không gian làm việc</option>
                                @foreach ($wspMember as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!--end col-->
                    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                        <li class="nav-item d-flex align-items-center justify-content-between">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                Thành viên
                            </a>
                            <span class="badge bg-dark align-items-center justify-content-center d-flex"
                                style="border-radius: 100%; width: 20px ;height: 20px;">
                                @if (!empty($boardMembers))
                                    {{ $boardMembers->count() + 1 }}
                                @endif
                            </span>

                        </li>
                        <li class="nav-item d-flex align-items-center justify-content-between">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                Yêu cầu tham gia
                            </a>
                            <span class="badge bg-dark align-items-center justify-content-center d-flex"
                                style="border-radius: 100%; width: 20px ;height: 20px;">
                                @if (!empty($boardMemberInvites))
                                    {{ $boardMemberInvites->count() }}
                                @endif
                            </span>
                        </li>


                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <ul style="margin-left: -32px;">
                                <li class="d-flex">
                                    <div class="col-1">
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                            title="Nancy">
                                            @if (!empty($boardOwner))
                                                @if ($boardOwner->image)
                                                    <img src="{{ Storage::url($boardOwner->image) ? Storage::url($boardOwner->image) : '' }}"
                                                        alt="" class="rounded-circle avatar-xs" />
                                                @else
                                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                        style="width: 25px;height: 25px">
                                                        {{ strtoupper(substr($boardOwner->name, 0, 1)) }}
                                                    </div>
                                                    <span class="fs-15 ms-2 text-white" id="swicthWs">
                                                        {{ \Illuminate\Support\Str::limit($boardOwner->name, 16) }}
                                                        <i class=" ri-arrow-drop-down-line fs-20"></i>
                                                    </span>
                                                @endif
                                            @endif


                                        </a>
                                    </div>
                                    <div class="col-8 d-flex flex-column">
                                        <section class="fs-12">
                                            @if (!empty($boardOwner))
                                                <p style="margin-bottom: 0px;" class="text-danger fw-bloder">
                                                    {{ $boardOwner->name }}
                                                    @if ($boardOwner->user_id == Auth::id())
                                                        <span class="text-danger fw-bloder">(bạn)</span>
                                                    @else
                                                        <span class="text-danger fw-bold">(chủ)</span>
                                                    @endif

                                                </p>
                                                <span> {{ $boardOwner->name }}</span>
                                                <span>-</span>
                                                <span>Quản trị viên của bảng</span>
                                            @endif
                                        </section>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-outline-danger ">Quản
                                            trị viên</button>
                                    </div>
                                </li>
                                @if (!empty($boardMembers))
                                    @foreach ($boardMembers as $item)
                                        <li class="d-flex mt-1 mb-1">
                                            <div class="col-1">
                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-item="top" title="Nancy">
                                                    @if ($item->image)
                                                        <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                            alt="" class="rounded-circle avatar-xs" />
                                                    @else
                                                        <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                            style="width: 25px;height: 25px">
                                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                                        </div>
                                                        <span class="fs-15 ms-2 text-white" id="swicthWs">
                                                            {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                            <i class=" ri-arrow-drop-down-line fs-20"></i>
                                                        </span>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="col-8 d-flex flex-column">
                                                <section class="fs-12">
                                                    <p style="margin-bottom: 0px;" class="text-black">
                                                        {{ $item->name }}
                                                        @if ($item->user_id == Auth::id())
                                                            <span class="text-success">(Bạn)</span>
                                                        @elseif($item->authorize === 'Sub_Owner')
                                                            <span class="text-primary">(Phó
                                                                nhóm)</span>
                                                        @else
                                                            <span class="text-black">(Thành
                                                                viên)</span>
                                                        @endif

                                                    </p>
                                                    <span>@ {{ $item->name }}</span>
                                                    <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                                    <span>Thành viên của bảng</span>
                                                </section>
                                            </div>
                                            <div class="col-3">
                                                <button class="btn btn-outline-primary">Thành
                                                    viên</button>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="tab-pane" id="profile1" role="tabpanel">
                            <ul style="margin-left: -32px;">
                                @if (!empty($boardMembers))
                                    @foreach ($boardMemberInvites as $item)
                                        <li class="d-flex justify-content-between">
                                            <div class="col-1">
                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="top" title="Nancy">
                                                    @if ($item->image)
                                                        <img src="{{ Storage::url($item->image) ? Storage::url($item->image) : '' }}"
                                                            alt="" class="rounded-circle avatar-xs" />
                                                    @else
                                                        <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                                                            style="width: 25px;height: 25px">
                                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                                        </div>
                                                        <span class="fs-15 ms-2 text-white" id="swicthWs">
                                                            {{ \Illuminate\Support\Str::limit($item->name, 16) }}
                                                            <i class=" ri-arrow-drop-down-line fs-20"></i>
                                                        </span>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="col-7 d-flex flex-column">
                                                <section class="fs-12">
                                                    <p style="margin-bottom: 0px;" class="text-black">
                                                        {{ $item->name }}
                                                        <span class="text-black">(Người
                                                            mới)</span>
                                                    </p>
                                                    <span>@ {{ $item->name }}</span>
                                                    <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                                    <span>Đã gửi lời mời vao không gian làm
                                                        việc</span>
                                                </section>
                                            </div>
                                            <div class="col-4 d-flex justify-content-end">
                                                {{-- <form onsubmit="disableButtonOnSubmit()"
                                                action="{{ route('accept_member') }}" method="post">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" value="{{ $item->user_id }}" name="user_id">
                                                <input type="hidden" value="{{ $item->workspace_id }}"
                                                    name="workspace_id">
                                                <input type="hidden" value="NULL" name="type_update">
                                                <button class="btn btn-primary me-2" type="submit">Duyệt</button>
                                            </form>
                                            <form action="{{ route('refuse_member', $item->wm_id) }}"
                                                onsubmit="disableButtonOnSubmit()" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" type="submit">Từ chối</button>
                                            </form> --}}
                                            </div>
                                        </li>
                                        <br>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function copyLink() {
        const link = '{{ $board->link_invite }}'; // Lấy link từ biến Laravel
        navigator.clipboard.writeText(link).then(function() {
            // Thay đổi icon sau khi sao chép thành công
            const copyIcon = document.getElementById('copy-icon');
            copyIcon.classList.remove('ri-attachment-2'); // Xóa icon hiện tại
            copyIcon.classList.add('ri-check-line'); // Thêm icon dấu kiểm

            // Thay đổi văn bản "Sao chép liên kết"
            const copyText = document.querySelector('span a');
            copyText.textContent = 'Đã sao chép';

            // Đặt thời gian chờ 20 giây trước khi chuyển icon và văn bản về trạng thái ban đầu
            setTimeout(function() {
                // Khôi phục lại icon và văn bản sau 20 giây
                copyIcon.classList.remove('ri-check-line');
                copyIcon.classList.add('ri-attachment-2');
                copyIcon.textContent = ''; // Xóa nội dung text nếu có

                copyText.textContent = 'Sao chép liên kết';
            }, 5000); // 20000 milliseconds = 20 giây

        }).catch(function(error) {
            console.error('Error copying text: ', error);
            alert('Có lỗi xảy ra, vui lòng thử lại.');
        });
    }



    document.querySelector('.invite-member-select').addEventListener('change', function() {
        const memberId = this.value;
        const boardId = {{ $board->id }}; // Sửa lại thành đúng tên biến
        if (memberId) {
            const memberName = this.options[this.selectedIndex].text;

            if (confirm(`Bạn có chắc muốn mời thành viên ${memberName}?`)) {
                // Gọi đến URL xử lý mời thành viên
                const inviteUrl =
                    `/b/invite-member-workspace/${memberId}/${boardId}`; // Sửa lại URL đúng với route

                fetch(inviteUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // parse response as JSON
                    })
                    .then(data => {
                        if (data.success) {
                            alert(`Đã thêm thành viên ${memberName} thành công`);
                            window.location.reload();
                        } else {
                            alert('Thêm thành viên thất bại');
                        }
                    })
                    .catch(error => {
                        console.error('Error inviting member:', error);
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    });
            }
        }
    });
</script>
