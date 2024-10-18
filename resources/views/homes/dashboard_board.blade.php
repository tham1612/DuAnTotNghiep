@php
    use App\Models\Task;
    use App\Models\Catalog;
    use Carbon\Carbon;
    use App\Models\BoardMember;
    use App\Models\User;

    // Lấy danh sách thành viên và đếm số nhiệm vụ mà mỗi thành viên được giao
    $taskCountPerMember = Task::with('members')
        ->selectRaw('users.name, COUNT(tasks.id) as task_count')
        ->join('task_members', 'tasks.id', '=', 'task_members.task_id')
        ->join('users', 'users.id', '=', 'task_members.user_id')
        ->groupBy('users.name')
        ->get();

    // Chuyển danh sách thành viên và số nhiệm vụ thành các mảng để truyền vào JavaScript
    $memberNames = $taskCountPerMember->pluck('name'); // Lấy tên thành viên
    $taskCounts = $taskCountPerMember->pluck('task_count'); // Lấy số lượng nhiệm vụ
    // Lấy danh sách thành viên từ session hoặc database
    $boardMembers = session('boardMembers', []); // Sử dụng session nếu có

    // Đếm số lượng thành viên trong bảng (board) cụ thể
    $totalMembers = BoardMember::where('board_id', $id)->count(); // Đếm số lượng thành viên của bảng dựa trên board_id

    // Tính tổng số lượng nhiệm vụ của tất cả các catalogs thuộc bảng cụ thể
    $totalTasksCount = Task::whereHas('catalog', function ($query) use ($id) {
        $query->where('board_id', $id); // Chỉ lấy tasks thuộc catalogs của bảng (board) cụ thể
    })->count();

    // Lấy danh sách các task quá hạn từ cơ sở dữ liệu cho các catalog thuộc bảng cụ thể
    $task_over = Task::with(['members', 'catalog']) // Gọi quan hệ members và catalog
        ->whereHas('catalog', function ($query) use ($id) {
            $query->where('board_id', $id); // Lọc tasks thuộc các catalogs của board cụ thể
        })
        ->where('end_date', '<', Carbon::now()) // So sánh ngày hết hạn với ngày hiện tại
        ->get();

    // Lấy danh sách các task mà người dùng hiện tại là thành viên và thuộc về bảng cụ thể
    $my_task = Task::with(['members', 'catalog']) // Gọi quan hệ members và catalog
        ->whereHas('catalog', function ($query) use ($id) {
            $query->where('board_id', $id); // Lọc tasks thuộc các catalogs của board cụ thể
        })
        ->whereHas('members', function ($query) {
            $query->where('user_id', auth()->id()); // Lọc các task mà người dùng hiện tại là thành viên
        })
        ->get();

    // Tính số lượng nhiệm vụ quá hạn cho các catalog thuộc bảng cụ thể
    $overdueTasksCount = Task::whereHas('catalog', function ($query) use ($id) {
        $query->where('board_id', $id); // Chỉ tính tasks thuộc catalogs của bảng cụ thể
    })
        ->where('end_date', '<', Carbon::now())
        ->count();

    // Tính số lượng nhiệm vụ hoàn thành (process = 100) và chưa hoàn thành (process = 0)
    $completedTasksCount = Task::whereHas('catalog', function ($query) use ($id) {
        $query->where('board_id', $id); // Lọc tasks thuộc các catalogs của board cụ thể
    })
        ->where('progress', 100) // Lọc nhiệm vụ đã hoàn thành
        ->count();

    $incompleteTasksCount = Task::whereHas('catalog', function ($query) use ($id) {
        $query->where('board_id', $id); // Lọc tasks thuộc các catalogs của board cụ thể
    })
        ->where('progress', 0) // Lọc nhiệm vụ chưa hoàn thành
        ->count();

@endphp
@extends('layouts.masterMain')
@section('title')
    Dashbroad_board
@endsection
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard_board</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Dashboard_board</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex">
            <h5 class="card-title fs-18 mb-1"></h5>
        </div>
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Thành viên trong bảng
                                    <i class="ri-account-circle-line text-success fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-user-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">

                                        <h2 class="mb-0">
                                            <!-- Hiển thị số lượng thành viên -->
                                            <span>{{ $totalMembers }}</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Task hoàn thành
                                    <i class="ri-checkbox-circle-line text-success fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-check-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">
                                            <span class="counter-value"
                                                data-target="{{ $completedTasksCount }}">{{ $completedTasksCount }}</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Task chưa hoàn thành
                                    <i class="ri-close-circle-line text-danger fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">
                                            <span class="counter-value"
                                                data-target="{{ $incompleteTasksCount }}">{{ $incompleteTasksCount }}</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Task quá hạn
                                    <i class="ri-indeterminate-circle-line text-danger fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-close-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <!-- Hiển thị số lượng nhiệm vụ quá hạn -->
                                        <h2 class="mb-0"><span>{{ $overdueTasksCount }}</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Tổng task
                                    <i class="ri-add-circle-line text-success fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-checkbox-multiple-fill display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <!-- Hiển thị tổng số lượng nhiệm vụ -->
                                        <h2 class="mb-0"><span>{{ $totalTasksCount }}</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tiến độ hoàn thành dự án</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 400px;">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tổng nhiệm vụ giao cho từng người</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 400px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header border-bottom-dashed align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Hoạt động gần đây</h4>
                    <div class="flex-shrink-0">
                    </div>
                </div><!-- end cardheader -->
                <div class="card-body p-0">
                    <div data-simplebar style="max-height: 400px;" class="p-3">
                        <div class="acitivity-timeline acitivity-main">
                            @if (!empty($activities))
                                @foreach ($activities as $activity)
                                    <li class="d-flex align-items-start mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @if (!empty($activity->causer) && !empty($activity->causer->avatar))
                                                    <img src="{{ asset('path_to_avatar/' . $activity->causer->avatar) }}"
                                                        alt="avatar" class="rounded-circle" width="40" height="40">
                                                @else
                                                    <div class="bg-info-subtle rounded-circle d-flex justify-content-center align-items-center"
                                                        style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($activity->causer->name ?? 'Hệ thống', 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
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
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
    </div><!-- end row -->
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Nhiệm vụ của thành viên</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div>
                        <canvas id="barChart"></canvas>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- Hiển thị danh sách các task -->
        <div class="col-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 py-1">Nhiệm vụ của bạn</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Thành viên<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- Danh sách thành viên khác có thể lọc -->
                                @foreach ($boardMembers as $member)
                                    <a class="dropdown-item" href="#">{{ $member->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->

                <div class="card-body" data-simplebar style="max-height: 300px; max-width: 100%;">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-nowrap table-centered align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Thẻ</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Độ ưu tiên</th>
                                    <th>Danh sách</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                @foreach ($my_task as $task)
                                    <tr>
                                        <!-- Thẻ (tên nhiệm vụ) -->
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label ms-1" for="checkTask{{ $task->id }}">
                                                    {{ $task->text }}
                                                </label>
                                            </div>
                                        </td>
                                        <!-- Ngày bắt đầu -->
                                        <td class="text-muted">
                                            {{ \Carbon\Carbon::parse($task->start_date)->format('d M Y') }}
                                        </td>
                                        <!-- Ngày kết thúc -->
                                        <td class="text-muted">
                                            {{ \Carbon\Carbon::parse($task->end_date)->format('d M Y') }}
                                        </td>

                                        <!-- Độ ưu tiên -->
                                        <td>
                                            <span
                                                class="badge
                                                @if ($task->priority == 'High') bg-danger-subtle text-danger
                                                @elseif ($task->priority == 'Medium') bg-warning-subtle text-warning
                                                @elseif ($task->priority == 'Low') bg-success-subtle text-success
                                                @else bg-info-subtle text-info @endif">
                                                {{ $task->priority }}
                                        </td>

                                        <!-- Danh sách -->
                                        <td class="text-muted">
                                            {{ $task->catalog->name ?? 'Không có danh sách' }}
                                        </td>
                                    </tr><!-- end -->
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                </div><!-- end cardbody -->

            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-0">Nhiệm vụ quá hạn</h5>
                </div>
                <div class="card-body" data-simplebar style="max-height: 300px;">
                    <table id="scroll-vertical"
                        class="table table-bordered dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên card</th>
                                <th>Thành viên</th>
                                <th>Ngày hết hạn</th>
                                <th>Danh sách</th>
                                <th>Độ ưu tiên</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($task_over as $task)
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td>{{ $task->text }}</td>
                                    <td>
                                        <div class="avatar-group d-flex justify-content-center" id="newMembar">
                                            @if ($task->members->isNotEmpty())
                                                @php
                                                    // Giới hạn số thành viên hiển thị
                                                    $maxDisplay = 3;
                                                    $count = 0;
                                                @endphp
                                                @foreach ($task->members as $member)
                                                    @if ($count < $maxDisplay)
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="{{ $member->name }}">
                                                            @if ($member->image)
                                                                <img src="{{ asset('storage/' . $member->image) }}"
                                                                    alt="" class="rounded-circle avatar-xs" />
                                                            @else
                                                                <div class="bg-info-subtle rounded-circle d-flex justify-content-center align-items-center"
                                                                    style="width: 40px;height: 40px">
                                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </a>
                                                        @php $count++; @endphp
                                                    @endif
                                                @endforeach

                                                @if ($task->members->count() > $maxDisplay)
                                                    <a href="javascript: void(0);" class="avatar-group-item"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ $task->members->count() - $maxDisplay }} more">
                                                        <div class="avatar-xs">
                                                            <div class="avatar-title rounded-circle bg-info-subtle d-flex justify-content-center align-items-center text-black"
                                                                style="width: 40px; height: 40px;">
                                                                +{{ $task->members->count() - $maxDisplay }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ Carbon::parse($task->end_date)->format('d M, Y') }}</td>
                                    <td>{{ $task->catalog->name ?? 'Chưa có danh sách' }}</td>
                                    <!-- Hiển thị tên danh sách -->
                                    <td>
                                        <span
                                            class="badge
                                            @if ($task->priority == 'High') bg-danger-subtle text-danger
                                            @elseif ($task->priority == 'Medium') bg-warning-subtle text-warning
                                            @elseif ($task->priority == 'Low') bg-success-subtle text-success
                                            @else bg-info-subtle text-info @endif">
                                            {{ $task->priority }}
                                        </span>

                                    </td> <!-- Hiển thị độ ưu tiên với màu sắc tương ứng -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Truyền dữ liệu từ PHP vào JavaScript
        const completedTasks = @json($completedTasksCount); // Số nhiệm vụ hoàn thành
        const incompleteTasks = @json($incompleteTasksCount); // Số nhiệm vụ chưa hoàn thành

        // Tạo biểu đồ Donut
        const donutCtx = document.getElementById('doughnutChart');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hoàn thành', 'Chưa hoàn thành'],
                datasets: [{
                    label: 'Tiến độ dự án',
                    data: [completedTasks, incompleteTasks], // Dữ liệu từ PHP
                    backgroundColor: [
                        '#405189', // Màu cho nhiệm vụ hoàn thành
                        '#F5F5F5' // Màu cho nhiệm vụ chưa hoàn thành
                    ],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right', // Đặt vị trí của legend sang bên phải
                        labels: {
                            padding: 20 // Khoảng cách giữa legend và biểu đồ
                        }
                    }
                }
            }
        });
        // Hàm tạo màu ngẫu nhiên với tông màu nhạt hơn
        function getRandomLightColor() {
            const letters = 'BCDEF'; // Giới hạn các chữ số từ B đến F để tạo màu nhạt hơn
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * letters.length)];
            }
            return color;
        }

        // Hàm tạo mảng màu ngẫu nhiên với số lượng màu cụ thể
        function getRandomColors(count) {
            let colors = [];
            for (let i = 0; i < count; i++) {
                colors.push(getRandomLightColor()); // Gọi hàm tạo màu nhạt
            }
            return colors;
        }


        // Truyền dữ liệu từ PHP vào JavaScript
        const memberNames = @json($memberNames); // Tên của các thành viên
        const taskCounts = @json($taskCounts); // Số lượng nhiệm vụ giao cho từng thành viên

        // Tạo màu ngẫu nhiên cho mỗi thành viên
        const randomColors = getRandomColors(memberNames.length); // Tạo mảng màu ngẫu nhiên cho số lượng thành viên

        // Tạo biểu đồ Pie
        const pieCtx = document.getElementById('pieChart');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: memberNames, // Tên các thành viên
                datasets: [{
                    label: 'Số nhiệm vụ',
                    data: taskCounts, // Số lượng nhiệm vụ
                    backgroundColor: randomColors, // Màu sắc ngẫu nhiên
                    hoverOffset: 3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right', // Đặt vị trí của legend sang bên phải
                        labels: {
                            padding: 20 // Khoảng cách giữa legend và biểu đồ
                        }
                    }
                }
            }
        });

        // Tạo biểu đồ Bar Chart
        const barCtx = document.getElementById('barChart');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: memberNames, // Sử dụng tên thành viên cho trục x
                datasets: [{
                    label: 'Số nhiệm vụ',
                    data: taskCounts, // Số lượng nhiệm vụ tương ứng
                    backgroundColor: randomColors, // Sử dụng màu ngẫu nhiên
                    borderColor: randomColors, // Sử dụng màu ngẫu nhiên cho viền
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Đảm bảo trục y bắt đầu từ 0
                    }
                }
            }
        });
    </script>


    <!-- apexcharts -->
    <script src="{{ asset('theme/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Swiper Js -->
    <script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <!--Swiper slider js-->
    <script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <!-- Marketplace init -->
    <script src="{{ asset('theme/assets/js/pages/dashboard-nft.init.js') }}"></script>
@endsection

@section('styles')
    <!--Swiper slider css-->
    <link href="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
