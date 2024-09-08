@extends('layouts.masterhome')
@section('title')
    dashbroad
@endsection
@section('main')
    <div class="row">
        <div class="col">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Dashboard</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-height-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Phần trăn công việc hoàn thành</h5>
                                <div class="progress animated-progress custom-progress mb-1">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 38%"
                                        aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div>
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
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                data-target="50"></span></h2>
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
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                data-target="8"></span></h2>
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

                <div class="row">
                    <div class="d-flex">
                        <h5 class="card-title fs-18 mb-2">Bảng của bạn</h5>
                    </div>
                    <div class="col-3 project-card">

                        <div class="card">

                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-secondary-subtle rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn active">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/dribbble.png') }}" alt=""
                                            height="32">
                                    </div>
                                </div>

                                <div class="py-3">
                                    <h5 class="fs-14 mb-3"><a href="apps-projects-overview.html" class="text-body">Tên
                                            Board</a></h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-warning-subtle text-warning fs-12">
                                                    Inprogress
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">08 Dec, 2021</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Terry Moberly">
                                                <div class="avatar-xxs">
                                                    <div class="avatar-title rounded-circle bg-danger">
                                                        T
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Ruby Miller">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div><i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                17/20
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="71"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 71%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <div class="col-3  project-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-light rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/slack.png') }}" alt=""
                                            height="32">
                                    </div>
                                </div>
                                <div class="py-3">
                                    <h5 class="mb-3 fs-14"><a href="apps-projects-overview.html"
                                            class="text-body">Ecommerce app</a></h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-warning-subtle text-warning fs-12">
                                                    Inprogress
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">20 Nov, 2021</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Irma Metz">
                                                <img src="{{ asset('theme/assets/images/users/avatar-9.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="James Clem">
                                                <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                11/45
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <div class="col-3 project-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-primary-subtle rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/dropbox.png') }}" alt=""
                                            height="32">
                                    </div>
                                </div>

                                <div class="py-3">
                                    <h5 class="mb-3 fs-14"><a href="apps-projects-overview.html"
                                            class="text-body">Redesign - Landing page</a>
                                    </h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-warning-subtle text-warning fs-12">
                                                    Inprogress
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">10 Jul, 2021</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Brent Gonzalez">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Sylvia Wright">
                                                <div class="avatar-xxs">
                                                    <div class="avatar-title rounded-circle bg-secondary">
                                                        S
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Ellen Smith">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-4.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                13/26
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    <div class="col-3 project-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-danger-subtle rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn active">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/mail_chimp.png') }}" alt=""
                                            height="32">
                                    </div>
                                </div>

                                <div class="py-3">
                                    <h5 class="mb-3 fs-14"><a href="apps-projects-overview.html"
                                            class="text-body">Multipurpose landing
                                            template</a></h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-success-subtle text-success fs-12">
                                                    Completed
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">18 Sep, 2021</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Donna Kline">
                                                <div class="avatar-xxs">
                                                    <div class="avatar-title rounded-circle bg-danger">
                                                        D
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Lee Winton">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Johnny Shorter">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                25/32
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                
                <div class="row">
                    <div class="d-flex">
                        <h5 class="card-title fs-18 mb-2">Bảng của khách</h5>
                    </div>

                    <div class="col-xxl-3 col-sm-6 project-card">

                        <div class="card">

                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-secondary-subtle rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn active">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/dribbble.png') }}" alt=""
                                            height="32">
                                    </div>
                                </div>

                                <div class="py-3">
                                    <h5 class="fs-14 mb-3"><a href="apps-projects-overview.html" class="text-body">Tên
                                            Board</a></h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-warning-subtle text-warning fs-12">
                                                    Inprogress
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">08 Dec, 2021</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Terry Moberly">
                                                <div class="avatar-xxs">
                                                    <div class="avatar-title rounded-circle bg-danger">
                                                        T
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Ruby Miller">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div><i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                17/20
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="71"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 71%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    <div class="col-xxl-3 col-sm-6 project-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-light rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/slack.png') }}" alt=""
                                            height="32">
                                    </div>
                                </div>
                                <div class="py-3">
                                    <h5 class="mb-3 fs-14"><a href="apps-projects-overview.html"
                                            class="text-body">Ecommerce app</a></h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-warning-subtle text-warning fs-12">
                                                    Inprogress
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">20 Nov, 2021</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Irma Metz">
                                                <img src="{{ asset('theme/assets/images/users/avatar-9.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="James Clem">
                                                <img src="{{ asset('theme/assets/images/users/avatar-10.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                11/45
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-3 col-sm-6 project-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-primary-subtle rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/dropbox.png') }}" alt=""
                                            height="32">
                                    </div>
                                </div>

                                <div class="py-3">
                                    <h5 class="mb-3 fs-14"><a href="apps-projects-overview.html"
                                            class="text-body">Redesign - Landing page</a>
                                    </h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-warning-subtle text-warning fs-12">
                                                    Inprogress
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">10 Jul, 2021</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Brent Gonzalez">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-3.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Sylvia Wright">
                                                <div class="avatar-xxs">
                                                    <div class="avatar-title rounded-circle bg-secondary">
                                                        S
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Ellen Smith">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-4.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                13/26
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    <div class="col-xxl-3 col-sm-6 project-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-3 mt-n3 mx-n3 bg-danger-subtle rounded-top">
                                    <div class="d-flex gap-1 align-items-center justify-content-end my-n2">
                                        <button type="button" class="btn avatar-xs p-0 favourite-btn active">
                                            <span class="avatar-title bg-transparent fs-15">
                                                <i class="ri-star-fill"></i>
                                            </span>
                                        </button>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="apps-projects-overview.html"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
                                                <a class="dropdown-item" href="apps-projects-create.html"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#removeProjectModal"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pb-3">
                                        <img src="{{ asset('theme/assets/images/brands/mail_chimp.png') }}"
                                            alt="" height="32">
                                    </div>
                                </div>

                                <div class="py-3">
                                    <h5 class="mb-3 fs-14"><a href="apps-projects-overview.html"
                                            class="text-body">Multipurpose landing
                                            template</a></h5>
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Status</p>
                                                <div class="badge bg-success-subtle text-success fs-12">
                                                    Completed
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted mb-1">Deadline</p>
                                                <h5 class="fs-14">18 Sep, 2021</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3">
                                        <p class="text-muted mb-0 me-2">Team :</p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Donna Kline">
                                                <div class="avatar-xxs">
                                                    <div class="avatar-title rounded-circle bg-danger">
                                                        D
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Lee Winton">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-5.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Johnny Shorter">
                                                <div class="avatar-xxs">
                                                    <img src="{{ asset('theme/assets/images/users/avatar-6.jpg') }}"
                                                        alt="" class="rounded-circle img-fluid">
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Add Members">
                                                <div class="avatar-xxs">
                                                    <div
                                                        class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1">
                                            <div>Tasks</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                25/32
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm animated-progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                                        <!-- /.progress-bar -->
                                    </div><!-- /.progress -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <!-- end col -->
                </div>
                <!-- end row -->
        </div> <!-- end col -->

    </div>
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ asset('theme/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

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
@endsection
.
