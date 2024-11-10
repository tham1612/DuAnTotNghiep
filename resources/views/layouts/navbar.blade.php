<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="d-flex justify-content-between align-items-center">
                @php $memberIsStar = session('memberIsStar_' . $board->id); @endphp
                <h4 class="fs-20 mx-3 mt-2 " id="2-name-board-{{ $board->id }}">{{ $board->name }}</h4>
                <button type="button"
                    class="btn avatar-xs mt-n1 p-0 favourite-btn
                    @if ($memberIsStar) active @endif"
                    onclick="updateIsStar({{ $board->id }},{{ auth()->id() }})" id="is_star_{{ $board->id }}">
                    <span class="avatar-title bg-transparent fs-15">
                        <i class="ri-star-fill fs-20 mx-2"></i>

                    </span>
                </button>
                <div class="mx-2 cursor-pointer" id="dropdownToggle" aria-expanded="false" data-bs-offset="10,20">
                    <i id="accessIcon_{{ $board->id }}"
                        class="
                        @if ($board->access == 'private') ri-lock-2-line fs-20 text-danger
                        @elseif($board->access == 'public')
                            ri-shield-user-fill fs-20 text-primary @endif">
                    </i>
                    <span id="accessText_{{ $board->id }}">
                        @if ($board->access == 'private')
                            Riêng tư
                        @elseif($board->access == 'public')
                            Công khai
                        @endif
                    </span>
                    <!-- Dropdown menu -->
                    <form id="updateBoardForm{{ $board->id }}"
                        onsubmit="submitForm({{ $board->id }}); return false;">
                        <ul class="dropdown-menu dropdown-menu-md p-3" id="dropdownMenu"
                            style="width: 35%; display: none;">
                            @foreach (\App\Enums\AccessEnum::getValues() as $access)
                                <li class="mb-2">
                                    <label class="dropdown-item w-100 d-flex align-items-start"
                                        for="{{ $access }}Option">
                                        <input class="form-check-input me-2 mt-1" type="radio" name="access"
                                            id="Option{{ $board->id }}" value="{{ $access }}"
                                            {{ $board->access == $access ? 'checked' : '' }}>
                                        <div>
                                            @if ($access == 'private')
                                                <i class="ri-lock-2-line fs-20 text-danger"></i>
                                                <strong>Riêng tư</strong>
                                                <p class="fs-13 w-100">
                                                    Chỉ thành viên bảng thông tin mới có quyền xem bảng thông tin này.
                                                    Quản trị viên của Không gian làm việc có thể đóng bảng thông tin
                                                    hoặc xóa thành viên.
                                                </p>
                                            @elseif($access == 'public')
                                                <i class="ri-earth-line fs-20 text-success"></i>
                                                <strong>Công khai</strong>
                                                <p class="fs-13 w-100">
                                                    Tất cả thành viên của Không gian làm việc TaskFlow có thể xem và sửa
                                                    bảng thông tin này.
                                                </p>
                                            @endif
                                            {{--                                        </div> --}}
                                    </label>
                                </li>
                            @endforeach
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" id="closeDropdown">Đóng</button>
                                <button type="submit" class="btn btn-primary" id="saveChanges">Lưu thay đổi</button>
                            </div>
                        </ul>
                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
{{-- </div> --}}

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-left justify-content-between">
            <!-- các màn hình trong bảng -->
            <ul class="nav nav-pills d-flex justify-content-between align-items-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                        href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}" role="tab"
                        aria-controls="pills-home"
                        aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}">
                        <i class="ri-dashboard-line fs-20"></i><span class="readonly fs-14"> Bảng điều khiển</span>
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->get('type') == 'board' ? 'active' : '' }}"
                        href="{{ route('b.edit', ['viewType' => 'board', 'id' => $board->id]) }}" role="tab"
                        aria-controls="pills-profile"
                        aria-selected="{{ request()->get('type') == 'board' ? 'true' : 'false' }}">
                        <i class="ri-table-line fs-20"></i> <span class="readonly fs-14"> Bảng </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->get('type') == 'list' ? 'active' : '' }}"
                        href="{{ route('b.edit', ['viewType' => 'list', 'id' => $board->id]) }}" role="tab"
                        aria-controls="pills-list"
                        aria-selected="{{ request()->get('type') == 'list' ? 'true' : 'false' }}">
                        <i class=" ri-list-check-2 fs-20"></i><span class="readonly fs-14"> Danh sách</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->get('type') == 'ganttChart' ? 'active' : '' }}"
                        href="{{ route('b.edit', ['viewType' => 'gantt', 'id' => $board->id]) }}" role="tab"
                        aria-controls="pills-gantt"
                        aria-selected="{{ request()->get('type') == 'ganttChart' ? 'true' : 'false' }}">
                        <i class="ri-calendar-todo-fill fs-20"></i><span class="readonly fs-14"> Lịch trình</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->get('type') == 'table' ? 'active' : '' }}"
                        href="{{ route('b.edit', ['viewType' => 'table', 'id' => $board->id]) }}" role="tab"
                        aria-controls="pills-table"
                        aria-selected="{{ request()->get('type') == 'table' ? 'true' : 'false' }}">
                        <i class="ri-layout-3-line fs-20"></i> <span class="readonly fs-14"> Bảng</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ request()->get('type') == 'calendar' ? 'active' : '' }}"
                        href="{{ route('b.edit', ['viewType' => 'calendar', 'id' => $board->id]) }}" role="tab"
                        aria-controls="pills-gantt"
                        aria-selected="{{ request()->get('type') == 'calendar' ? 'true' : 'false' }}">
                        <i class=" ri-calendar-2-line fs-20"></i> <span class="readonly fs-14"> Lịch</span>
                    </a>
                </li>
            </ul>
            <div class="col-auto ms-auto d-flex justify-content-end align-items-center">
                <!--  bộ lọc -->
                <div class="d-flex justify-content-center align-items-center p-1 cursor-pointer"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                    <i class="ri-filter-3-line fs-20"></i>
                    <span class="readonly fs-14">Bộ lọc</span>
                </div>
                <div class="fs-20 fw-lighter text-secondary">|</div>
                <!-- setting bộ lọc -->
                <form class="dropdown-menu dropdown-menu-md p-3" style="width: 35%;max-height: 450px" data-simplebar
                    action="{{ route('b.edit', $board->id) }}" method="GET">
                    {{--                    @csrf --}}
                    <input type="hidden" name="viewType" id="viewType"
                        value="{{ request()->input('viewType') }}">
                    <p class="text-center fs-15"><strong>Lọc</strong></p>

                    <!-- lọc tìm kiếm -->
                    <div class="mt-2">
                        <strong>Từ khóa</strong>
                        <input type="text" name="search" id="search-filter" placeholder="Nhập từ khóa..."
                            class="form-control" />
                        <span class="fs-10">Tìm kiếm các thẻ, các thành viên, các nhãn và hơn thế nữa.</span>
                    </div>

                    <!-- lọc thành viên -->
                    <div class="mt-2">
                        <p><strong>Thành viên</strong></p>
                        <label for="no_member">
                            <input type="checkbox" name="no_member" id="no_member" @checked(isset($_GET['no_member']) ? $_GET['no_member'] : '') />
                            <span>Không có thành viên</span>
                        </label>
                        <br />
                        <label for="it_me">
                            <input type="checkbox" name="it_me" id="it-me" @checked(isset($_GET['it_me']) ? $_GET['it_me'] : '') />
                            <span>Các thẻ chỉ định cho tôi</span>
                        </label>
                    </div>

                    <!-- Ngày hết hạn -->
                    <div class="mt-2">
                        <p><strong>Ngày hết hạn</strong></p>
                        <label for="no_date">
                            <input type="checkbox" name="no_date" id="no-date" @checked(isset($_GET['no_date']) ? $_GET['no_date'] : '') />
                            <span>Không có ngày hết hạn</span>
                        </label>
                        <br />
                        <label for="no_overdue">
                            <input type="checkbox" name="no_overdue" id="no-overdue" @checked(isset($_GET['no_overdue']) ? $_GET['no_overdue'] : '') />
                            <span>Quá hạn</span>
                        </label>
                        <br />
                        <label for="due_tomorrow">
                            <input type="checkbox" name="due_tomorrow" id="due-tomorrow"
                                @checked(isset($_GET['due_tomorrow']) ? $_GET['due_tomorrow'] : '') />
                            <span>Hết hạn vào ngày mai</span>
                        </label>
                    </div>

                    <!-- Nhãn -->
                    <div class="mt-2">
                        <p><strong>Nhãn</strong></p>
                        <label for="no_tags" class="d-flex align-items-center">
                            <input type="checkbox" name="no_tags" id="no_tags" @checked(isset($_GET['no_tags']) ? $_GET['no_tags'] : '') />
                            <i class="ri-price-tag-3-line mx-2 fs-20"></i>
                            <span class="rounded col-11">Không có nhãn</span>
                        </label>
                        @foreach ($board->tags as $tag)
                            <label for="{{ $tag->name }}_tags_{{ $tag->id }}"
                                class="d-flex align-items-center">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    id="{{ $tag->name }}_tags_{{ $tag->id }}"
                                    @if (isset($_GET['tags'])) @foreach ($_GET['tags'] as $check_tag)
                                        @checked($check_tag == $tag->id)
                                        @endforeach @endif />
                                <span class="mx-2 rounded p-2 col-11"
                                    style="background-color: {{ $tag->color_code }}">
                                    {{ $tag->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary m">Lọc</button>
                </form>
                <section class="d-flex">
                    <!-- thêm thành viên & chia sẻ link bảng -->
                    <div class="d-flex justify-content-center align-items-center cursor-pointer me-2">
                        <div class="col-auto ms-sm-auto">
                            <div class="avatar-group">

                                @php $boardMembers = session('boardMembers_' . $board->id);@endphp

                                @php
                                    // Đếm số lượng board members
                                    $maxDisplay = 3;
                                    $count = 0;
                                @endphp

                                @foreach ($boardMembers as $boardMember)
                                    {{-- @php
                                        $boardMember = $boardMemberMain->user;
                                    @endphp --}}
                                    @if ($count < $maxDisplay)
                                        <a href="javascript: void(0);" class="avatar-group-item"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $boardMember['name'] }}">
                                            @if ($boardMember['image'])
                                                <img src="{{ asset('storage/' . $boardMember->image) }}"
                                                    alt="" class="rounded-circle avatar-xs object-fit-cover">
                                            @else
                                                <div class="avatar-xs" style="width: 40px;height: 40px">
                                                    <div class="avatar-title rounded-circle bg-light text-primary"
                                                        style="width: 40px;height: 40px">
                                                        {{ strtoupper(substr($boardMember['name'], 0, 1)) }}
                                                    </div>
                                                </div>
                                            @endif
                                        </a>
                                        @php $count++; @endphp
                                    @endif
                                @endforeach

                                @if (count($boardMembers) > $maxDisplay)
                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="{{ count($boardMembers) - $maxDisplay }} more">
                                        <div class="avatar-xs" style="width: 40px;height: 40px">
                                            <div class="avatar-title rounded-circle" style="width: 40px;height: 40px">
                                                +{{ count($boardMembers) - $maxDisplay }}
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="bg-primary p-1 rounded">
                            <i class="ri-user-add-line text-white"></i>
                            <a href="#addmemberModal" data-bs-toggle="modal" class="avatar-group-item">
                                <span class="text-white fs-14">Chia sẻ</span>
                            </a>
                        </div>
                    </div>
                    <!-- menu bảng -->
                    <div class="d-flex justify-content-center align-items-center p-2 cursor-pointer">
                        <i class="ri-list-settings-line fs-20" data-bs-toggle="offcanvas"
                            data-bs-target="#settingBoard" aria-controls="offcanvasRight"></i>
                    </div>
                </section>
            </div>
        </div>
    </div>

</div>
<script !src="">
    function submitForm(boardId) {

        var formData = {
            access: $('input[name="access"]:checked').val(),
        }
        $.ajax({
            url: `/b/${boardId}/update`,
            method: 'PUT',
            data: formData,
            success: function(response) {
                console.log('chế độ bảng thay dổi thành công');
                $('#dropdownMenu').hide();
                if (formData.access === 'private') {
                    $('#accessIcon_' + boardId).removeClass().addClass('ri-lock-2-line fs-20 text-danger');
                    $('#accessText_' + boardId).text('Riêng tư');
                } else if (formData.access === 'public') {
                    $('#accessIcon_' + boardId).removeClass().addClass(
                        'ri-shield-user-fill fs-20 text-primary');
                    $('#accessText_' + boardId).text('Công khai');
                }
            },
            error: function(xhr) {
                console.error('Lỗi xảy ra:', xhr.responseText);
            }
        });

        return false;
    }
</script>
