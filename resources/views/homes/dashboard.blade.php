@extends('layouts.masterMain')

@section('title')
    Dashbroad
@endsection

@section('main')
    @if (session('error'))
        <div class="alert alert-danger custom-alert">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .custom-alert {
            border-radius: 0.5rem;
            padding: 1rem;
            position: relative;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>

    {{-- <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-sm-0">Bảng điều khiển</h4>
            </div>
        </div>
    </div> --}}

    <div class="row" id="highlighted-boards">
        <div class="d-flex">
            <h5 class="card-title fs-18 mb-3">Bảng nổi bật </h5>
        </div>
        <div class="row">
            @if (!empty($board_star))
                @php   session(['$board_star' => $board_star]); @endphp
                @if ($board_star->isEmpty())
                    <p>Không có bảng nào được đánh dấu là nổi bật.</p>
                @else
                    @foreach ($board_star as $board)
                        <div class="col-3 project-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="p-0 mt-n3 mx-n3 bg-secondary-subtle rounded-top position-relative">
                                        <div class="image-container position-relative"
                                            style="width: 100%; height: 120px; overflow: visible;">
                                            @if ($board && $board->image && \Storage::exists($board->image))
                                                <img src="{{ asset('storage/' . $board->image) }}"
                                                    alt="{{ $board->name }}'s image" class="img-fluid"
                                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                            @else
                                                <div class="text-center pb-3" style="height: 120px;"></div>
                                            @endif
                                            <div class="position-absolute top-0 end-0 p-1">
                                                <!-- Favorite Button -->
                                                <button type="button"
                                                    class="btn avatar-xs p-0 favourite-btn {{ $board->is_star ? 'active' : '' }}"
                                                    onclick="updateIsStar2({{ $board->id }}, {{ auth()->id() }})"
                                                    id="is_star_{{ $board->id }}">
                                                    <span class="avatar-title bg-transparent fs-20">
                                                        <i class="ri-star-fill"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fs-16 my-3">
                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                role="tab"
                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                class="text-body">{{ \Illuminate\Support\Str::limit($board->name, 30) }}</a>
                                        </h5>
                                        <div class="row mb-3">
                                            <div class="col-5 pe-0">

                                                <button class="btn btn-light px-1 py-1"
                                                    onclick="updateFollow({{ $board->id }}, {{ auth()->id() }})"
                                                    id="follow_{{ $board->id }}">
                                                    <span>
                                                        <i id="followIcon_{{ $board->id }}"
                                                            class="{{ $board->follow ? 'ri-eye-line' : 'ri-eye-off-line' }} "></i> Theo
                                                        dõi
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="col-7 ps-0 d-flex align-items-center ">
                                                <p class="text-muted mb-0 me-2">Team
                                                </p>
                                                <div class="avatar-group">
                                                    @php
                                                        // Giới hạn số thành viên hiển thị
                                                        $maxDisplay = 4;
                                                        $count = 0;
                                                    @endphp

                                                    @foreach ($board->members as $boardMember)
                                                        @if ($count < $maxDisplay)
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                data-bs-placement="top" title="{{ $boardMember->name }}">
                                                                <div class="avatar-xs" style="width: 25px;height: 25px">
                                                                    @if ($boardMember->image)
                                                                        <img src="{{ asset('storage/' . $boardMember->image) }}"
                                                                            alt="{{ $boardMember->name }}"
                                                                            class="rounded-circle"
                                                                            style="width: 25px;height: 25px">
                                                                    @else
                                                                        <div class="bg-info-subtle rounded-circle avatar-xs d-flex justify-content-center align-items-center"
                                                                            style="width: 25px;height: 25px">
                                                                            {{ strtoupper(substr($boardMember->name, 0, 1)) }}
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                            </a>
                                                            @php $count++; @endphp
                                                        @endif
                                                    @endforeach

                                                   <!-- Nút hiển thị số thành viên còn lại -->
                                                   @if ($board->members->count() > $maxDisplay)
                                                   <a href="javascript: void(0);" class="avatar-group-item"
                                                       data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                       data-bs-placement="top"
                                                       title="{{ $board->members->count() - $maxDisplay }} more members">
                                                       <div class="avatar-xs" style="width: 25px;height: 25px">
                                                           <div class="avatar-title fs-16 rounded-circle"
                                                               style="width: 25px;height: 25px">
                                                               +{{ $board->members->count() - $maxDisplay }}
                                                           </div>
                                                       </div>
                                                   </a>
                                               @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex mb-1">
                                        <div class="flex-grow-1">
                                            <div>Tiến độ</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                {{ $board->complete }}% / 100% <!-- Hiển thị phần trăm hoàn thành -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            aria-valuenow="{{ $board->complete }}" aria-valuemin="0" aria-valuemax="100"
                                            style="width: {{ $board->complete }}%;"></div>
                                        <!-- Sử dụng trường complete -->
                                    </div><!-- /.progress -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        <!-- end col -->
    </div>

    <div class="row">
        <div class="d-flex">
            <h5 class="card-title fs-18 mb-3">Bảng của bạn</h5>
        </div>
        <div class="row">
            @if (!empty($boards))
                @if ($boards->isEmpty())
                    <p>Không có bảng nào.</p>
                @else
                    @foreach ($boards as $board)
                        <div class="col-3 project-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="p-0 mt-n3 mx-n3 bg-secondary-subtle rounded-top position-relative">
                                        <div class="image-container position-relative"
                                            style="width: 100%; height: 120px; overflow: visible;">
                                            @if ($board && $board->image && \Storage::exists($board->image))
                                                <img src="{{ asset('storage/' . $board->image) }}"
                                                    alt="{{ $board->name }}'s image" class="img-fluid"
                                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                            @else
                                                <div class="text-center pb-3" style="height: 120px;"></div>
                                            @endif

                                            <div class="position-absolute top-0 end-0 p-1">
                                                <!-- Favorite Button -->
                                                <button type="button"
                                                    class="btn avatar-xs p-0 favourite-btn {{ $board->is_star ? 'active' : '' }}"
                                                    onclick="updateIsStar2({{ $board->id }}, {{ auth()->id() }})"
                                                    id="is_star_{{ $board->id }}">
                                                    <span class="avatar-title bg-transparent fs-20">
                                                        <i class="ri-star-fill"></i>
                                                    </span>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fs-16 mt-3">
                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                role="tab"
                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                class="text-body">{{ \Illuminate\Support\Str::limit($board->name, 30) }}</a>
                                        </h5>
                                        <div class="row mb-3">
                                            <div class="col-5 pe-0">
                                                <button class="btn btn-light px-1 py-1"
                                                    onclick="updateFollow({{ $board->id }}, {{ auth()->id() }})"
                                                    id="follow_{{ $board->id }}">
                                                    <span>
                                                        <i id="followIcon_{{ $board->id }}"
                                                            class="{{ $board->follow ? 'ri-eye-line' : 'ri-eye-off-line' }} "></i> Theo
                                                        dõi
                                                    </span>
                                                </button>

                                            </div>
                                            <div class="col-7 ps-0 d-flex align-items-center">
                                                <p class="text-muted mb-0 me-2">Team
                                                </p>
                                                <div class="avatar-group">
                                                    @php
                                                        // Giới hạn số thành viên hiển thị
                                                        $maxDisplay = 4;
                                                        $count = 0;
                                                    @endphp

                                                    @foreach ($board->members as $boardMember)
                                                        @if ($count < $maxDisplay)
                                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                data-bs-placement="top" title="{{ $boardMember->name }}">
                                                                <div class="avatar-xs" style="width: 25px;height: 25px">
                                                                    @if ($boardMember->image)
                                                                        <img src="{{ asset('storage/' . $boardMember->image) }}"
                                                                            alt="{{ $boardMember->name }}"
                                                                            class="rounded-circle"
                                                                            style="width: 25px;height: 25px">
                                                                    @else
                                                                        <div class="bg-info-subtle rounded-circle avatar-xs d-flex justify-content-center align-items-center"
                                                                            style="width: 25px;height: 25px">
                                                                            {{ strtoupper(substr($boardMember->name, 0, 1)) }}
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                            </a>
                                                            @php $count++; @endphp
                                                        @endif
                                                    @endforeach

                                                    <!-- Nút hiển thị số thành viên còn lại -->
                                                    @if ($board->members->count() > $maxDisplay)
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top"
                                                            title="{{ $board->members->count() - $maxDisplay }} more members">
                                                            <div class="avatar-xs" style="width: 25px;height: 25px">
                                                                <div class="avatar-title fs-16 rounded-circle"
                                                                    style="width: 25px;height: 25px">
                                                                    +{{ $board->members->count() - $maxDisplay }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex mb-1">
                                        <div class="flex-grow-1">
                                            <div>Tiến độ</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                {{ $board->complete }}% / 100% <!-- Hiển thị phần trăm hoàn thành -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            aria-valuenow="{{ $board->complete }}" aria-valuemin="0" aria-valuemax="100"
                                            style="width: {{ $board->complete }}%;"></div>
                                        <!-- Sử dụng trường complete -->
                                    </div><!-- /.progress -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        feather.replace();
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll('.counter-value');

            counters.forEach(counter => {
                const updateCounter = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;

                    const increment = target / 200; // tốc độ tăng giá trị

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCounter, 10); // tốc độ cập nhật
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCounter();
            });
        });

        function updateIsStar2(boardId, userId, ) {

            $.ajax({
                url: `/b/${boardId}/updateBoardMember`,
                method: "PUT",
                data: {
                    board_id: boardId,
                    user_id: userId,
                },
                success: function(response) {
                    console.log('Người dùng đã đánh dấu bảng nối bật:', response);
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        }

        function updateFollow(boardId, userId) {

            $.ajax({
                url: `/b/${boardId}/updateBoardMember2`,
                method: "PUT",
                data: {
                    board_id: boardId,
                    user_id: userId,
                },
                success: function(response) {
                    console.log('Người dùng đã folow bảng:', response);
                    let followIcon = $('#followIcon_' + boardId);
                    if (response.follow === 1) {
                        // Nếu người dùng đang theo dõi, cập nhật icon "eye-line" và màu sắc phù hợp
                        $('#followIcon_' + boardId).removeClass().addClass('ri-eye-line ');
                    } else {
                        // Nếu người dùng không theo dõi, cập nhật icon "eye-off-line" và màu sắc phù hợp
                        $('#followIcon_' + boardId).removeClass().addClass('ri-eye-off-line ');
                    }
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        }
    </script>

    <!-- apexcharts -->
    <script src="{{ asset('theme/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <script src="assets/js/pages/api-key.init.js"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('theme/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <!-- project list init -->
    <script src="{{ asset('theme/assets/js/pages/project-list.init.js') }}"></script>
@endsection
@section('styles')
    <!-- jsvectormap css -->
    <link href="{{ asset('theme/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /* Khi nút có class "active", icon sao sẽ chuyển sang màu vàng */
        .favourite-btn.active .avatar-title i {
            color: gold !important;
            /* Dùng !important để đảm bảo không bị ghi đè */
        }

        /* Mặc định icon sao có màu xám nếu không có class active */
        .favourite-btn .avatar-title i {
            color: gray;
        }
    </style>
@endsection
