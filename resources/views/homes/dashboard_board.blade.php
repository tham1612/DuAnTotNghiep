@extends('layouts.masterHome')
@section('title')
    dashbroad_board
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
        <div class="d-flex">
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
            <div class="card card-height-100">
                <div class="card-header border-bottom-dashed align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Hoạt động gần đây</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            Xem tất cả các hoạt động
                        </button>
                    </div>
                </div><!-- end cardheader -->
                <div class="card-body p-0">
                    <div data-simplebar style="max-height: 400px;" class="p-3">
                        <div class="acitivity-timeline acitivity-main">
                            <div class="acitivity-item d-flex">
                                <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                    <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                        <i class="ri-shopping-cart-2-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Purchase by James Price</h6>
                                    <p class="text-muted mb-1">Product noise
                                        evolve smartwatch
                                    </p>
                                    <small class="mb-0 text-muted">02:14 PM
                                        Today</small>
                                </div>
                            </div>

                            <div class="acitivity-item py-3 d-flex">
                                <div class="flex-shrink-0">
                                    <img src="assets/images/users/avatar-2.jpg" alt=""
                                        class="avatar-xs rounded-circle acitivity-avatar">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Natasha Carey have liked the
                                        products</h6>
                                    <p class="text-muted mb-1">Allow users to
                                        like products in
                                        your WooCommerce store.</p>
                                    <small class="mb-0 text-muted">25 Dec,
                                        2021</small>
                                </div>
                            </div>
                            <div class="acitivity-item py-3 d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs acitivity-avatar">
                                        <div class="avatar-title rounded-circle bg-secondary">
                                            <i class="mdi mdi-sale fs-14"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Today offers by <a href="apps-ecommerce-seller-details.html"
                                            class="link-secondary">Digitech
                                            Galaxy</a></h6>
                                    <p class="text-muted mb-2">Offer is valid on
                                        orders of
                                        Rs.500 Or above for selected products
                                        only.</p>
                                    <small class="mb-0 text-muted">12 Dec,
                                        2021</small>
                                </div>
                            </div>
                            <div class="acitivity-item py-3 d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs acitivity-avatar">
                                        <div class="avatar-title rounded-circle bg-danger-subtle text-danger">
                                            <i class="ri-bookmark-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Favoried Product</h6>
                                    <p class="text-muted mb-2">Esther James have
                                        favorited
                                        product.</p>
                                    <small class="mb-0 text-muted">25 Nov,
                                        2021</small>
                                </div>
                            </div>
                            <div class="acitivity-item py-3 d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs acitivity-avatar">
                                        <div class="avatar-title rounded-circle bg-secondary">
                                            <i class="mdi mdi-sale fs-14"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Flash sale starting <span class="text-primary">Tomorrow.</span>
                                    </h6>
                                    <p class="text-muted mb-0">Flash sale by <a href="javascript:void(0);"
                                            class="link-secondary fw-medium">Zoetic
                                            Fashion</a>
                                    </p>
                                    <small class="mb-0 text-muted">22 Oct,
                                        2021</small>
                                </div>
                            </div>
                            <div class="acitivity-item py-3 d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs acitivity-avatar">
                                        <div class="avatar-title rounded-circle bg-info-subtle text-info">
                                            <i class="ri-line-chart-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Monthly sales report</h6>
                                    <p class="text-muted mb-2"><span class="text-danger">
                                            2 days left</span> notification to
                                        submit the
                                        monthly sales report. <a href="javascript:void(0);"
                                            class="link-warning text-decoration-underline">Reports
                                            Builder</a>
                                    </p>
                                    <small class="mb-0 text-muted">15 Oct</small>
                                </div>
                            </div>
                            <div class="acitivity-item d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}" alt=""
                                        class="avatar-xs rounded-circle acitivity-avatar" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Frank Hook Commented</h6>
                                    <p class="text-muted mb-2 fst-italic">" A
                                        product that has
                                        reviews is more likable to be sold than
                                        a product. "</p>
                                    <small class="mb-0 text-muted">26 Aug,
                                        2021</small>
                                </div>
                            </div>
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
        <div class="col-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 py-1">My Tasks</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Thành viên<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Thanh Thanh</a>
                                <a class="dropdown-item" href="#">Thị Thắm </a>
                                <a class="dropdown-item" href="#">Minh Nguyệt</a>
                                <a class="dropdown-item" href="#">Quang Vinh</a>
                                <a class="dropdown-item" href="#">Giang Tuấn</a>
                                <a class="dropdown-item" href="#">Thành Đạt</a>
                                <a class="dropdown-item" href="#">Trọng Nam</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body"  data-simplebar style="max-height: 300px;">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-nowrap table-centered align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Dedline</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Assignee</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask1">
                                            <label class="form-check-label ms-1" for="checkTask1">
                                                Create new Admin Template
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">03 Nov 2021</td>
                                    <td><span class="badge bg-success-subtle text-success">Completed</span>
                                    </td>
                                    <td>
                                        <div class="avatar-group flex-nowrap">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="assets/images/users/avatar-1.jpg" alt=""
                                                        class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="assets/images/users/avatar-2.jpg" alt=""
                                                        class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="assets/images/users/avatar-3.jpg" alt=""
                                                        class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask2">
                                            <label class="form-check-label ms-1" for="checkTask2">
                                                Marketing Coordinator
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">17 Nov 2021</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Progress</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="" data-bs-original-title="Den Davis">
                                            <img src="assets/images/users/avatar-7.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask3">
                                            <label class="form-check-label ms-1" for="checkTask3">
                                                Administrative Analyst
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">26 Nov 2021</td>
                                    <td><span class="badge bg-success-subtle text-success">Completed</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="" data-bs-original-title="Alex Brown">
                                            <img src="assets/images/users/avatar-6.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask4">
                                            <label class="form-check-label ms-1" for="checkTask4">
                                                E-commerce Landing Page
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">10 Dec 2021</td>
                                    <td><span class="badge bg-danger-subtle text-danger">Pending</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="" data-bs-original-title="Prezy Morin">
                                            <img src="assets/images/users/avatar-5.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask5">
                                            <label class="form-check-label ms-1" for="checkTask5">
                                                UI/UX Design
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">22 Dec 2021</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Progress</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title=""
                                            data-bs-original-title="Stine Nielsen">
                                            <img src="assets/images/users/avatar-1.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask6">
                                            <label class="form-check-label ms-1" for="checkTask6">
                                                Projects Design
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">31 Dec 2021</td>
                                    <td><span class="badge bg-danger-subtle text-danger">Pending</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title=""
                                            data-bs-original-title="Jansh William">
                                            <img src="assets/images/users/avatar-4.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                    <div class="mt-3 text-center">
                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">Load
                            More</a>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nhiệm vụ quá hạn</h5>
                </div>
                <div class="card-body"  data-simplebar style="max-height: 300px;">
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
    @endsection@extends('layouts.masterHome')
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
                                    hoàn thành<i
                                        class=" ri-close-circle-line text-danger fs-18 float-end align-middle"></i>
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
        <div class="col-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 py-1">My Tasks</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Thành viên<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Thanh Thanh</a>
                                <a class="dropdown-item" href="#">Thị Thắm </a>
                                <a class="dropdown-item" href="#">Minh Nguyệt</a>
                                <a class="dropdown-item" href="#">Quang Vinh</a>
                                <a class="dropdown-item" href="#">Giang Tuấn</a>
                                <a class="dropdown-item" href="#">Thành Đạt</a>
                                <a class="dropdown-item" href="#">Trọng Nam</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-nowrap table-centered align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Dedline</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Assignee</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask1">
                                            <label class="form-check-label ms-1" for="checkTask1">
                                                Create new Admin Template
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">03 Nov 2021</td>
                                    <td><span class="badge bg-success-subtle text-success">Completed</span>
                                    </td>
                                    <td>
                                        <div class="avatar-group flex-nowrap">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="assets/images/users/avatar-1.jpg" alt=""
                                                        class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="assets/images/users/avatar-2.jpg" alt=""
                                                        class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="assets/images/users/avatar-3.jpg" alt=""
                                                        class="rounded-circle avatar-xxs">
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask2">
                                            <label class="form-check-label ms-1" for="checkTask2">
                                                Marketing Coordinator
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">17 Nov 2021</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Progress</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="" data-bs-original-title="Den Davis">
                                            <img src="assets/images/users/avatar-7.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask3">
                                            <label class="form-check-label ms-1" for="checkTask3">
                                                Administrative Analyst
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">26 Nov 2021</td>
                                    <td><span class="badge bg-success-subtle text-success">Completed</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="" data-bs-original-title="Alex Brown">
                                            <img src="assets/images/users/avatar-6.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask4">
                                            <label class="form-check-label ms-1" for="checkTask4">
                                                E-commerce Landing Page
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">10 Dec 2021</td>
                                    <td><span class="badge bg-danger-subtle text-danger">Pending</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="" data-bs-original-title="Prezy Morin">
                                            <img src="assets/images/users/avatar-5.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask5">
                                            <label class="form-check-label ms-1" for="checkTask5">
                                                UI/UX Design
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">22 Dec 2021</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Progress</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title=""
                                            data-bs-original-title="Stine Nielsen">
                                            <img src="assets/images/users/avatar-1.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" value=""
                                                id="checkTask6">
                                            <label class="form-check-label ms-1" for="checkTask6">
                                                Projects Design
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">31 Dec 2021</td>
                                    <td><span class="badge bg-danger-subtle text-danger">Pending</span>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title=""
                                            data-bs-original-title="Jansh William">
                                            <img src="assets/images/users/avatar-4.jpg" alt=""
                                                class="rounded-circle avatar-xxs">
                                        </a>
                                    </td>
                                </tr><!-- end -->
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                    <div class="mt-3 text-center">
                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">Load
                            More</a>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
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
