@extends('layouts.masterMain')
@section('title')
    List - TaskFlow
@endsection
@section('main')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Khai báo đường dẫn đến route check.user với một placeholder 'id'
    let checkUserRoute = "{{ route('check.user', ['id' => '']) }}"; // Đây là URL gốc

    function searchData() {
        let query = document.getElementById('searchInput').value;

        axios.get('/chat', {
                params: {
                    query: query
                }
            })
            .then(function(response) {
                let users = response.data;
                let output = '';

                if (users.length > 0) {
                    users.forEach(user => {
                        // Thay thế 'id' trong đường dẫn với user.id
                        output += `
    <li>
        <a href="${checkUserRoute.replace(/\/$/, '')}/${user.id}">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                    <div class="avatar-xxs">
                        <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                             class="rounded-circle img-fluid userprofile" alt="">
                        ${user.status === 'on' ? '<span class="user-status"></span>' : ''}
                    </div>
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <p class="text-truncate mb-0">${user.name}</p>
                </div>
            </div>
        </a>
    </li>
    `;
                    });
                    document.getElementById('userResults').innerHTML = output;
                    document.getElementById('tb').innerHTML = '';
                } else {
                    document.getElementById('tb').innerHTML = '<p>Tên không phù hợp</p>';
                    document.getElementById('userResults').innerHTML = '';
                }

            })
            .catch(function(error) {
                console.log('Không lấy được dữ liệu', error);
            });
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- Đảm bảo jQuery được tải -->
<script>
    // Đường dẫn từ route của Laravel
    const chatURL = "{{ route('chat', ['roomId' => '']) }}"; // Giả sử bạn không cần cung cấp `roomId` tại đây

    const currentURL = window.location.href;

    function updateUserStatus(status) {
        $.ajax({
            url: '/update-status',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Gửi CSRF token để xác thực
                status: status // Gửi trạng thái
            },
            success: function(response) {
                if (response.success) {
                    console.log(`Status đã được cập nhật thành '${status}'`);
                }
            },
            error: function(xhr) {
                console.error("Có lỗi xảy ra khi cập nhật status:", xhr.responseText);
            }
        });
    }

    // Kiểm tra nếu URL hiện tại là một trang chat
    if (currentURL.startsWith(chatURL)) {
        console.log("Người dùng đã vào trang chat");

        // Cập nhật status thành 'on' khi vào trang
        updateUserStatus('on');

        // Thêm sự kiện trước khi rời khỏi trang
        window.addEventListener('beforeunload', function() {
            // Cập nhật status thành 'off' khi thoát
            updateUserStatus('off');
        });
    }
</script>


<style>
    /* Đặt kiểu chung cho các tin nhắn */
    .an {
        display: none;
    }

    .message {
        padding: 10px;
        margin: 5px;
        max-width: 70%;
        border-radius: 10px;
        clear: both;
        /* Đảm bảo mỗi tin nhắn bắt đầu trên dòng mới */
    }

    /* Tin nhắn của bạn hiển thị bên phải */
    .message.right {

        /* Màu cho tin nhắn của bạn */
        text-align: right;
        float: right;
        /* Căn về bên phải */
    }

    /* Tin nhắn của người khác hiển thị bên trái */
    .message.left {

        /* Màu cho tin nhắn của người khác */
        text-align: left;
        float: left;
        /* Căn về bên trái */
    }
</style>

   
       
   
<div class="">
    <div class="">
        <div class="container-fluid">
            <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                <!-- sidebar -->
                <div class="chat-leftsidebar">
                    <div class="px-4 pt-4 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="mb-4">Trò chuyện</h5>
                            </div>
                        </div>
                        <div class="search-box">
                            <form class="d-flex">
                                @csrf
                                <input style="width:220px!important;" type="text" id="searchInput"
                                    onkeyup="searchData()" class="form-control bg-light border-primary"
                                    placeholder="Nhập tên người dùng">
                            </form>
                            <i class="ri-search-2-line search-icon"></i>
                        </div>
                    </div> <!-- .p-4 -->

                    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified" role="tablist">
                        <li class="nav-item">
                            <a style="font-size:20px" class="nav-link active" data-bs-toggle="tab"
                                href="#chats" role="tab">
                                Tin nhắn
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="chats" role="tabpanel">
                            <div class="chat-room-list pt-3" data-simplebar>
                                <div class="chat-message-list">
                                    <ul class="list-unstyled chat-list chat-user-list" id="userList">
                                        <li id="userResults">

                                        </li>
                                        <p id="tb" class="text-center"></p>
                                        @if ($users->isNotEmpty())
                                            <p class="text-center">Đã liên hệ</p>
                                            @foreach ($users as $user)
                                                @php
                                                    $currentUserId = auth()->id();
                                                @endphp

                                                @foreach ($rooms as $room)
                                                    @php
                                                        $membersArray = explode(',', $room->members_hash);
                                                        $isInRoom =
                                                            in_array($currentUserId, $membersArray) &&
                                                            in_array($user->id, $membersArray);
                                                    @endphp

                                                    @if ($isInRoom && $user->id !== $currentUserId)
                                                        <li id="an1">
                                                            <a href="{{ url('chat/' . $room->id . '/' . $user->id) }}"
                                                                id="userList">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                                        <div
                                                                            class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                            <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                                                class="rounded-circle avatar-xs"
                                                                                alt="">
                                                                            <span
                                                                                id="status-span-{{ $user->id }}"
                                                                                class="onof {{ $user->status === 'on' ? 'user-status' : '' }}"></span>
                                                                            <script>
                                                                                setInterval(function() {
                                                                                    fetch('/user/status/{{ $user->id }}')
                                                                                        .then(response => response.json())
                                                                                        .then(data => {
                                                                                            const statusSpan = document.getElementById('status-span-{{ $user->id }}');
                                                                                            if (data.status === 'on') {
                                                                                                statusSpan.classList.add('user-status');
                                                                                            } else {
                                                                                                statusSpan.classList.remove('user-status');
                                                                                            }
                                                                                        })
                                                                                        .catch(error => console.error('Error fetching status:', error));
                                                                                }, 1000);
                                                                            </script>
                                                                        </div>
                                                                    </div>

                                                                    <div style="margin-left: -15px"
                                                                        class="flex-grow-1 overflow-hidden">
                                                                        <p class="text-truncate mb-0 mt-2">
                                                                            {{ $user->name }}</p>
                                                                        <p class="latest-message"
                                                                            data-user-id="{{ $user->id }}">
                                                                            <!-- Nội dung tin nhắn sẽ được hiển thị ở đây -->
                                                                        </p>

                                                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                const currentUserId = {{ $currentUserId }};
                                                                                const otherUserId = {{ $user->id }};

                                                                                function fetchLatestMessage() {
                                                                                    $.get(`/latest-message/${currentUserId}/${otherUserId}`, function(data) {
                                                                                        if (data) {
                                                                                            const messagePrefix = (data.sender_id == currentUserId) ? "Bạn: " : "";
                                                                                            const messageDate = new Date(data.created_at +
                                                                                                'Z'); // Thêm 'Z' để xác định đây là UTC

                                                                                            // Chuyển đổi sang giờ Việt Nam (GMT+7)
                                                                                            const vietnamTimezoneOffset = 7 * 60; // GMT+7
                                                                                            const localTimezoneOffset = messageDate
                                                                                                .getTimezoneOffset(); // Lấy offset của thời gian địa phương
                                                                                            const vietnamDate = new Date(messageDate.getTime() + (vietnamTimezoneOffset +
                                                                                                localTimezoneOffset) * 60000);

                                                                                            // Hiển thị thời gian
                                                                                            const formattedDate = vietnamDate.toLocaleDateString('vi-VN');
                                                                                            const formattedTime = vietnamDate.toLocaleTimeString('vi-VN', {
                                                                                                hour: '2-digit',
                                                                                                minute: '2-digit',
                                                                                                second: '2-digit',
                                                                                            });

                                                                                            $(`.latest-message[data-user-id="{{ $user->id }}"]`).html(`
                                                                                            <span>${messagePrefix}${data.message}</span>
                                                                                            <span style="float: right; font-size: 0.9em; color: gray;">
                                                                                            ${formattedDate} ${formattedTime}
                                                                                            </span>
                                                                                          `);
                                                                                        }
                                                                                    });
                                                                                }

                                                                                // Cập nhật tin nhắn mỗi giây cho từng người dùng
                                                                                setInterval(fetchLatestMessage, 1000);
                                                                            });
                                                                        </script>

                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            <p class="text-center">Hãy trò chuyện với ai đó</p>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user-chat  w-100 overflow-hidden">
                    <div class="chat-content d-lg-flex">
                        <!-- start chat conversation section -->
                        <div class="w-100 overflow-hidden position-relative">
                            <!-- conversation user -->
                            <div class="position-relative">
                                <div class="position-relative" id="users-chat">
                                    @if (isset($receiverId) && $receiverId && isset($userss) && $userss)
                                        <div class="p-3 user-chat-topbar">
                                            <div class="row align-items-center">
                                                <!-- avt chat -->
                                                <div class="col-sm-4 col-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                            <a href="javascript: void(0);"
                                                                class="user-chat-remove fs-18 p-1"><i
                                                                    class="ri-arrow-left-s-line align-bottom"></i></a>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                    <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                                        class="rounded-circle avatar-xs"
                                                                        alt="">
                                                                    <span id="check"
                                                                        class=""></span>

                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <h5 class="text-truncate mb-0 fs-16">
                                                                        <a>{{ $userss->name }}</a>
                                                                    </h5>
                                                                    <p class="text-truncate text-muted fs-8 mb-0 userStatus"
                                                                        id="user-status">
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 col-4">
                                                    <ul class="list-inline user-chat-nav text-end mb-0">
                                                        <!-- chấm than -->
                                                        <li
                                                            class="list-inline-item d-none d-lg-inline-block m-0">
                                                            <button type="button"
                                                                class="btn btn-ghost-secondary btn-icon"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#userProfileCanvasExample"
                                                                aria-controls="userProfileCanvasExample">
                                                                <i data-feather="info" class="icon-sm"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- khung chat cá nhân -->
                                        <div class="chat-conversation p-3 p-lg-4" id="message-box"
                                            style="max-height: 100%; overflow-y: auto;">
                                            <div class="messages-box justify-content-between"
                                                id="message-list">
                                                @php
                                                    // Lấy ID của người dùng hiện tại
                                                    $currentUserId = Auth::id();

                                                    // Truy vấn đến bảng messages với điều kiện sender_id và receiver_id
                                                    $messages = \App\Models\Message::where(function (
                                                        $query,
                                                    ) use ($currentUserId, $receiverId) {
                                                        $query
                                                            ->where('sender_id', $currentUserId)
                                                            ->orWhere('sender_id', $receiverId);
                                                    })
                                                        ->where(function ($query) use (
                                                            $currentUserId,
                                                            $receiverId,
                                                        ) {
                                                            $query
                                                                ->where('receiver_id', $currentUserId)
                                                                ->orWhere('receiver_id', $receiverId);
                                                        })
                                                        ->get();
                                                @endphp
                                                @if ($messages->isNotEmpty())
                                                    @foreach ($messages as $message)
                                                        @if ($message->sender_id == Auth::id())
                                                            <!-- Tin nhắn từ người dùng hiện tại, căn sang phải -->
                                                            <div class="d-flex justify-content-end mb-2">
                                                                <div class="mb-2"
                                                                    style="background-color: #5F93ED; padding: 10px; border-radius: 5px; color: #ffffff; line-height: 1.2; margin-right: 0;">
                                                                    {{ $message->message }}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Tin nhắn từ người khác, căn sang trái -->
                                                            <div class="d-flex mb-2">
                                                                <div class="bg-info-subtle d-flex justify-content-center align-items-center"
                                                                    style="width: 40px; height: 40px; margin-right: 10px; border-radius: 50%;">
                                                                    A
                                                                </div>
                                                                <div
                                                                    style="background-color: #E6E4D5; padding: 10px; border-radius: 5px; color: #333; line-height: 1.2;">
                                                                    {{ $message->message }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    <!-- Phần đánh dấu để cuộn xuống cuối -->
                                                    <div id="bottom"></div>
                                                @else
                                                    <p>Không có tin nhắn nào trong phòng này - Hãy trò chuyện
                                                        ngay.</p>
                                                @endif
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-center"
                                                style="margin-top:300px">
                                                <p class="text-center">Hãy trò chuyện với ai đó</p>
                                            </div>
                                    @endif
                                </div>

                            </div>
                            @if (isset($receiverId) && $receiverId && isset($userss) && $userss)
                                <div class="chat-input-section p-3 p-lg-4">
                                    <form onsubmit="return false;" enctype="multipart/form-data">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-auto">
                                                <div class="chat-input-links me-2">
                                                    <div class="links-list-item">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <input type="text"
                                                    class="form-control chat-input bg-light border-light"
                                                    id="message-input" placeholder="Nhập tin nhắn">
                                            </div>
                                            <div class="col-auto">
                                                <div class="chat-input-links ms-2">
                                                    <div class="links-list-item">
                                                        <button id="send-message-btn"
                                                            class="btn btn-success chat-send waves-effect waves-light">
                                                            <i class="ri-send-plane-2-fill align-bottom"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            @else
                            @endif


                            <div class="replyCard">
                                <div class="card mb-0">
                                    <div class="card-body py-3">
                                        <div class="replymessage-block mb-0 d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="conversation-name"></h5>
                                                <p class="mb-0"></p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" id="close_toggle"
                                                    class="btn btn-sm btn-link mt-n2 me-n3 fs-18">
                                                    <i class="bx bx-x align-middle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end chat-wrapper -->

    </div>
    <!-- container-fluid -->
</div>
<div class="offcanvas offcanvas-end border-0" tabindex="-1" id="userProfileCanvasExample">
    <!--end offcanvas-header-->
    <div class="offcanvas-body profile-offcanvas p-0">
        <div class="team-cover">
            <img src="{{ asset('theme/assets/images/small/img-9.jpg') }}" alt=""
                class="img-fluid" />
        </div>
        <div class="p-1 pb-4 pt-0">
            <div class="team-settings">
                <div class="row g-0">
                    <div class="col">
                        <div class="btn nav-btn">
                            <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        @if (isset($receiverId) && $receiverId && isset($user) && $user)
            <div class="p-3 text-center">
                <img src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}" alt=""
                    class="avatar-lg img-thumbnail rounded-circle mx-auto profile-img">
                <div class="mt-3">
                    <h5 class="fs-16 mb-1"><a href="javascript:void(0);"
                            class="link-primary username">{{ $userss->name }}</a>
                    </h5>
                    @if ($userss->status === 'on')
                        <p class="text-muted onn">
                            <i class="ri-checkbox-blank-circle-fill me-1 align-bottom text-success"></i>Online
                        </p>
                    @else
                        <p class="text-muted onn">
                            <i class="ri-checkbox-blank-circle-fill me-1 align-bottom text-dark"></i>Offline
                        </p>
                    @endif
                </div>
            </div>
            <!-- thông tin cá nhân -->
            <div class="border-top border-top-dashed p-3">
                <h5 class="fs-15 mb-3">Thông tin người dùng</h5>
                <div class="mb-3">
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Số điện thoại</p>
                    <h6>8888888888</h6>
                </div>
                <div class="mb-3">
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Email</p>
                    <h6>{{ $userss->email }}</h6>
                </div>

            </div>
        @else
            <h1>wwww</h1>
        @endif

    </div>
    <!--end offcanvas-body-->
</div>
<script src={{ asset('theme/assets/js/app.js') }}></script>

<script>
    let userId = {{ auth()->id() }};
    let receiverId = {{ $receiverId }};
    let roomId = {{ $roomId }};
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var chatContainer = document.getElementById('bottom');
        chatContainer.scrollIntoView();
    });
</script>

@vite('resources/js/present.js') <!-- Gắn file JavaScript -->
@endsection