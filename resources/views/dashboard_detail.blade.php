@extends('layouts.masterhome')
@section('title')
    dashbroad
@endsection

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Card</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Card</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex pt-2 pb-4">
            <h5 class="card-title fs-18 mb-1"></h5>
        </div>
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Thành viên<i
                                        class="ri-account-circle-line text-success fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-user-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="7">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Hoàn
                                    thành<i
                                        class=" ri-checkbox-circle-line
                                            text-success fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class=" ri-check-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="10">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Chưa
                                    hoàn thành<i class=" ri-close-circle-line text-danger fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="10">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Quá
                                    hạn<i
                                        class=" ri-indeterminate-circle-line text-danger fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class=" ri-close-line e display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="15">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Tổng<i
                                        class=" ri-add-circle-line text-success fs-18 float-end align-middle"></i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-checkbox-multiple-fill display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="50">0</span></h2>
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
                    <h4 class="card-title mb-0">Hoạt động gần đây</h4>
                </div><!-- end card header -->
                <div class="card-body" data-simplebar style="height: 400px;" class="px-3 mx-n3 mb-2">
                    <div class="upcoming-scheduled">
                        <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y"
                            data-deafult-date="today" data-inline-date="true">
                    </div>
                    <!-- Event items go here -->
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                                T
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Tên user</h6>
                            <p class="text-muted mb-0">Hoạt động</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span>
                            </p>
                        </div>
                    </div>

                    <!-- Repeat similar blocks for other events -->

                    <div class="mt-3 text-center">
                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">View all Events</a>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
    </div><!-- end row -->
    <div class="row">
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nhiệm vụ quá hạn</h5>
                </div>
                <div class="card-body">
                    <table id="scroll-vertical"
                        class="table table-bordered dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên card</th>
                                <th>Thành viên</th>
                                <th>Ngày hết hạn</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>VLZ-452</td>
                                <td>Symox v1.0.0</td>
                                <td>
                                    <div class="avatar-group">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-img="avatar-3.jpg"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                            title="Username">
                                            <img src="assets/images/users/avatar-3.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </div>
                                </td>
                                <td>03 Oct, 2021</td>
                                <td><span class="badge bg-info-subtle text-info">Re-open</span>
                                </td>

                            </tr>

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
        // Bar Chart
        const barCtx = document.getElementById('barChart');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        '#0ab39c',
                        '#405189',
                        '#3577f1',
                        '#f7b84b',
                        '#f06548',
                        '#299cdb'
                    ],
                    borderColor: [
                        '#0ab39c',
                        '#405189',
                        '#3577f1',
                        '#f7b84b',
                        '#f06548',
                        '#299cdb'
                    ],
                    borderWidth: '#088675',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Thanh', 'Thắm', 'Vinh', 'Nguyệt', 'Tuấn', 'Đạt'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        '#0ab39c',
                        '#405189',
                        '#3577f1',
                        '#f7b84b',
                        '#f06548',
                        '#299cdb'
                    ],
                    hoverOffset: 3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right', // Đặt vị trí của legend sang bên trái
                        labels: {
                            padding: 20 // Khoảng cách giữa legend và biểu đồ
                        }
                    }
                }
            }

        });

        // Donut Chart
        const doughnutCtx = document.getElementById('doughnutChart');
        const donutCtx = document.getElementById('doughnutChart');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hoàn thành', 'Chưa hoàn thành'],
                datasets: [{
                    label: 'Tiến độ dự án',
                    data: [70, 30],
                    backgroundColor: [
                        '#405189',
                        '#F5F5F5'
                    ],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right', // Đặt vị trí của legend sang bên trái
                        labels: {
                            padding: 20 // Khoảng cách giữa legend và biểu đồ
                        }
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
