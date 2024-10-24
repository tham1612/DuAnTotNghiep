@extends('layouts.masterMain')

@section('title')
    Dashbroad
@endsection

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-height-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Phần trăn công việc hoàn thành</h5>
                    <div class="progress animated-progress custom-progress mb-1">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 38%" aria-valuenow="38"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-muted mb-2">You used 215 of 2000 of your API
                    </p>

                </div>
            </div>
        </div><!--end col-->

        <div class="col-lg-4">
            <div class="card card-animate card-height-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Số task hoàn thành</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="50"></span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded-circle fs-2">
                                    <i data-feather="check-circle" class="text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div><!--end col-->
        <div class="col-lg-4">
            <div class="card card-animate card-height-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Số task quá hạn</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="8"></span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-danger-subtle rounded-circle fs-2">
                                    <i data-feather="alert-octagon" class="text-danger"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div><!--end col-->
    </div>

    <div class="row" id="highlighted-boards">
        <div class="d-flex">
            <h5 class="card-title fs-18 mb-2">Bảng nổi bật</h5> 
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
                                        @if ($board && $board->image && \Storage::exists($board->image))
                                            <div class="image-container position-relative"
                                                style="width: 100%; height: 100px; overflow: hidden;">
                                                <img src="{{ asset('storage/' . $board->image) }}"
                                                    alt="{{ $board->name }}'s image" class="img-fluid"
                                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                                <div class="position-absolute top-0 end-0 p-1">
                                                    <button type="button"
                                                        class="btn avatar-xs p-0 favourite-btn {{ $board->is_star ? 'active' : '' }}"
                                                        onclick="updateIsStar2({{ $board->id }},{{ auth()->id() }})"
                                                        id="is_star_{{ $board->id }}">
                                                        <span class="avatar-title bg-transparent fs-15">
                                                            <i class="ri-star-fill"></i>
                                                        </span>
                                                    </button>

                                                    <div class="dropdown d-inline-block">
                                                        <button
                                                            class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            <i data-feather="more-horizontal" class="icon-sm"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                                role="tab"
                                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                                class="dropdown-item"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a>

                                                            <a class="dropdown-item" href=""><i
                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#removeProjectModal"><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center pb-3" style="height:100px;">
                                                <div class="position-absolute top-0 end-0 p-1">
                                                    <button type="button"
                                                        class="btn avatar-xs p-0 favourite-btn {{ $board->is_star ? 'active' : '' }}"
                                                        onclick="updateIsStar2({{ $board->id }},{{ auth()->id() }})"
                                                        id="is_star_{{ $board->id }}">
                                                        <span class="avatar-title bg-transparent fs-15">
                                                            <i class="ri-star-fill"></i>
                                                        </span>
                                                    </button>

                                                    <div class="dropdown d-inline-block">
                                                        <button
                                                            class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            <i data-feather="more-horizontal" class="icon-sm"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                                role="tab"
                                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                                class="dropdown-item"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a>

                                                            <a class="dropdown-item" href=""><i
                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#removeProjectModal"><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="py-3">
                                        <h5 class="fs-14 mb-3">
                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                role="tab"
                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                class="text-body">{{ \Illuminate\Support\Str::limit($board->name, 30) }}</a>
                                        </h5>
                                        <div class="row gy-3">
                                            <div class="col-6">
                                                <p class="text-muted mb-1">Theo dõi</p>
                                                <button class="btn btn-primary px-2 py-1 fs-12"
                                                    onclick="updateFollow({{ $board->id }}, {{ auth()->id() }})"
                                                    id="follow_{{ $board->id }}">
                                                    <i id="followIcon_{{ $board->id }}"
                                                        class="{{ $board->follow ? 'ri-eye-line' : 'ri-eye-off-line' }} "></i>
                                                </button>
                                            </div>

                                            <div class="col-6">
                                                <div>
                                                    <p class="text-muted mb-1">Ngày tạo</p>
                                                    <h5 class="fs-14">{{ $board->created_at->format('d-m-Y') }}</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mt-3">
                                            <p class="text-muted mb-0 me-2">Team
                                            </p>
                                            <div class="avatar-group">
                                                @php
                                                    // Giới hạn số thành viên hiển thị
                                                    $maxDisplay = 3;
                                                    $count = 0;
                                                @endphp

                                                @foreach ($board->boardMembers as $member)
                                                    @if ($count < $maxDisplay)
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="{{ $member->user->name }}">
                                                            <div class="avatar-xxs">
                                                                <div class="avatar-title rounded-circle bg-danger">
                                                                    @if ($member->user->avatar_url)
                                                                        <img src="{{ $member->user->avatar_url }}"
                                                                            alt="{{ $member->user->name }}"
                                                                            class="rounded-circle" width="16">
                                                                    @else
                                                                        <div class="avatar-title rounded-circle bg-danger">
                                                                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </a>
                                                        @php $count++; @endphp
                                                    @endif
                                                @endforeach

                                                <!-- Nút hiển thị số thành viên còn lại -->
                                                @if ($board->boardMembers->count() > $maxDisplay)
                                                    <a href="javascript: void(0);" class="avatar-group-item"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-placement="top"
                                                        title="{{ $board->boardMembers->count() - $maxDisplay }} more members">
                                                        <div class="avatar-xxs">
                                                            <div
                                                                class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                                +{{ $board->boardMembers->count() - $maxDisplay }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                    <div>
                                        <div class="d-flex mb-2">
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
                                                aria-valuenow="{{ $board->complete }}" aria-valuemin="0"
                                                aria-valuemax="100" style="width: {{ $board->complete }}%;"></div>
                                            <!-- Sử dụng trường complete -->
                                        </div><!-- /.progress -->
                                    </div>

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
            <h5 class="card-title fs-18 mb-2">Bảng của bạn</h5>
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
                                        @if ($board && $board->image && \Storage::exists($board->image))
                                            <div class="image-container position-relative"
                                                style="width: 100%; height: 100px; overflow: hidden;">
                                                <img src="{{ asset('storage/' . $board->image) }}"
                                                    alt="{{ $board->name }}'s image" class="img-fluid"
                                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                                <!-- Các nút tương tác với ảnh -->
                                                <div class="position-absolute top-0 end-0 p-1">
                                                    <button type="button"
                                                        class="btn avatar-xs p-0 favourite-btn {{ $board->is_star ? 'active' : '' }}"
                                                        onclick="updateIsStar2({{ $board->id }},{{ auth()->id() }})"
                                                        id="is_star_{{ $board->id }}">
                                                        <span class="avatar-title bg-transparent fs-15">
                                                            <i class="ri-star-fill"></i>
                                                        </span>
                                                    </button>

                                                    <div class="dropdown d-inline-block">
                                                        <button
                                                            class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            <i data-feather="more-horizontal" class="icon-sm"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                                role="tab"
                                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                                class="dropdown-item">
                                                                <i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>View
                                                            </a>
                                                            <a class="dropdown-item" href="">
                                                                <i
                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#removeProjectModal">
                                                                <i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Remove
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center pb-3" style="height:100px;">
                                                <div class="position-absolute top-0 end-0 p-1">
                                                    <button type="button"
                                                        class="btn avatar-xs p-0 favourite-btn {{ $board->is_star ? 'active' : '' }}"
                                                        onclick="updateIsStar2({{ $board->id }},{{ auth()->id() }})"
                                                        id="is_star_{{ $board->id }}">
                                                        <span class="avatar-title bg-transparent fs-15">
                                                            <i class="ri-star-fill"></i>
                                                        </span>
                                                    </button>

                                                    <div class="dropdown d-inline-block">
                                                        <button
                                                            class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            <i data-feather="more-horizontal" class="icon-sm"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                                role="tab"
                                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                                class="dropdown-item"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a>

                                                            <a class="dropdown-item" href=""><i
                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#removeProjectModal"><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>


                                    <div class="py-3">
                                        <h5 class="fs-14 mb-3">
                                            <a href="{{ route('b.edit', ['viewType' => 'dashboard', 'id' => $board->id]) }}"
                                                role="tab"
                                                aria-selected="{{ request()->get('type') == 'dashboard' ? 'true' : 'false' }}"
                                                aria-controls="pills-home nav-link {{ request()->get('type') == 'dashboard' ? 'active' : '' }}"
                                                class="text-body">{{ \Illuminate\Support\Str::limit($board->name, 30) }}</a>
                                        </h5>

                                        <div class="row gy-3">
                                            <div class="col-6">
                                                <p class="text-muted mb-1">Theo dõi</p>
                                                <button class="btn btn-primary px-2 py-1 fs-12"
                                                    onclick="updateFollow({{ $board->id }}, {{ auth()->id() }})"
                                                    id="follow_{{ $board->id }}">
                                                    <i id="followIcon_{{ $board->id }}"
                                                        class="{{ $board->follow ? 'ri-eye-line' : 'ri-eye-off-line' }} "></i>
                                                </button>

                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <p class="text-muted mb-1">Ngày tạo</p>
                                                    <h5 class="fs-14">{{ $board->created_at->format('d-m-Y') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-3">
                                            <p class="text-muted mb-0 me-2">Team
                                            </p>
                                            <div class="avatar-group">
                                                @php
                                                    // Giới hạn số thành viên hiển thị
                                                    $maxDisplay = 3;
                                                    $count = 0;
                                                @endphp

                                                @foreach ($board->boardMembers as $member)
                                                    @if ($count < $maxDisplay)
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="{{ $member->user->name }}">
                                                            <div class="avatar-xxs">
                                                                <div class="avatar-title rounded-circle bg-danger">
                                                                    @if ($member->user->avatar_url)
                                                                        <img src="{{ $member->user->avatar_url }}"
                                                                            alt="{{ $member->user->name }}"
                                                                            class="rounded-circle" width="16">
                                                                    @else
                                                                        <div class="avatar-title rounded-circle bg-danger">
                                                                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </a>
                                                        @php $count++; @endphp
                                                    @endif
                                                @endforeach

                                                <!-- Nút hiển thị số thành viên còn lại -->
                                                @if ($board->boardMembers->count() > $maxDisplay)
                                                    <a href="javascript: void(0);" class="avatar-group-item"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-placement="top"
                                                        title="{{ $board->boardMembers->count() - $maxDisplay }} more members">
                                                        <div class="avatar-xxs">
                                                            <div
                                                                class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                                +{{ $board->boardMembers->count() - $maxDisplay }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex mb-2">
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
                                                aria-valuenow="{{ $board->complete }}" aria-valuemin="0"
                                                aria-valuemax="100" style="width: {{ $board->complete }}%;"></div>
                                            <!-- Sử dụng trường complete -->
                                        </div><!-- /.progress -->
                                    </div>
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
