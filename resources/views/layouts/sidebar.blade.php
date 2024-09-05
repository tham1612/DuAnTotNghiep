<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('theme/admin/assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="{{asset('theme/admin/assets/images/logo-dark.png')}}" alt="" height="17">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('theme/admin/assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="{{asset('theme/admin/assets/images/logo-light.png')}}" alt="" height="17">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div class="app-menu navbar-menu">

                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#">
                            <i class="ri-home-3-line"></i> <span data-key="">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="inbox.html">
                            <i class="ri-inbox-archive-line"></i> <span data-key="">Inbox</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="docs.html">
                            <i class="ri-file-text-line"></i> <span data-key="">Docs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="Dashboards.html">
                            <i class="ri-dashboard-line"></i> <span data-key="">Dashboards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="more.html">
                            <i class="ri-more-fill"></i> <span data-key="">More</span>
                        </a>
                    </li>
                    <li class="menu-title"><span data-key="t-menu">Spaces</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="evverything.html">
                            <i class="ri-apps-fill"></i> <span data-key="">Everything</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                            <i class="ri-group-fill"></i> <span data-key="t-authentication">Teams Space</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAuth">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin"> Project
                                    </a>
                                    <div class="collapse menu-dropdown" id="sidebarSignIn">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="board.html" class="nav-link" data-key="t-basic"> Project
                                                    1
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="board.html" class="nav-link" data-key="t-cover"> Project
                                                    2
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link" href="evverything.html">
                            <i class="ri-function-line"></i><span data-key="">View All Space</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="evverything.html">
                            <i class="ri-add-line"></i><span data-key="">Create Space</span>
                        </a>
                    </li>



                    <!-- end Dashboard Menu -->

                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Board List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Board</a></li>
                                <li class="breadcrumb-item active">List</li>
                            </ol>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-left justify-content-between">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " id="pills-home-tab" href="teams-spaces-overview.html" role="tab" aria-controls="pills-home" aria-selected="true"><i
                                        class="ri-dashboard-line"></i> Overview</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-profile-tab" href="board.html" role="tab" aria-controls="pills-profile" aria-selected="false"><i
                                        class="ri-table-line"></i> Board</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-list-tab" href="teams-spaces-list.html" role="tab" aria-controls="pills-list" aria-selected="false"><i
                                        class="ri-list-unordered"></i> List</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-calendar-tab" href="calendar.html" role="tab" aria-controls="pills-calendar" aria-selected="false"><i
                                        class="ri-calendar-line"></i> Calendar</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-gantt-tab" href="gantt.html" role="tab" aria-controls="pills-gantt" aria-selected="false"><i class="ri-menu-2-line"></i>
                                    Gantt</a>
                            </li>
                            <li class="nav-item active" role="presentation">
                                <a class="nav-link" id="pills-table-tab" href="teams-spaces-table.html" role="tab" aria-controls="pills-table" aria-selected="false"><i
                                        class="ri-layout-3-line"></i> Table</a>
                            </li>
                        </ul>
                        <div class="col-lg-3 col-auto ms-auto">
                            <div class="search-box">
                                <input type="text" class="form-control search" id="search-task-options" placeholder="Search for project, tasks...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createListModal"><i class="ri-add-line align-bottom me-1"></i>Add
                            List</button>
                    </div>
                </div>

            </div>
            <div class="container-fluid">
                <div class="row" id="kanbanboard">
                    <div class="col-lg-12">
                        <div class="card" id="tasksList">
                            <div class="card-header border-0">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-grow-1">
                                        <h6 class="fs-14 text-uppercase fw-semibold mb-0">Inprogress <small class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                                        </h6>
                                        <div class="d-flex ms-4">
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                            Thay đổi tên</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                            Thêm thẻ</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Sao chép danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Di chuyển danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Sao chép danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Lưu trữ danh sách</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!--end card-body-->
                            <div class="card-body">
                                <div class="table-responsive table-card mb-4">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col" style="width: 40px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                </div>
                                            </th>
                                            <th class="sort">Name</th>
                                            <th class="sort">Assigned To</th>
                                            <th class="sort">Due Date</th>
                                            <th class="sort">Priority</th>
                                            <th class="sort">Status</th>
                                            <th class="sort">Comments</th>
                                        </tr>
                                        </thead>
                                        <tbody class="form-check-all big-div" id="div1">
                                        <tr class="small-div" id="drag1" draggable="true">
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                </div>
                                            </th>

                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 ">Thẻ công việc 1</div>
                                                    <div class="flex-shrink-0 ms-4">
                                                        <ul class="list-inline tasks-list-menu mb-0">
                                                            <li class="list-inline-item"><a href=""><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item"><a href="" data-bs-toggle="modal" data-bs-target="#createCardDetailModal"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="avatar-group" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                                    <a href="javascript: void(0);" class="avatar-group-item">
                                                        <i class="ri-user-add-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-calendar-2-line"><input type="date" name="" id=""></i>
                                                </a>
                                            </td>

                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-flag-2-line"></i>
                                                </a>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-select fs-14 text-uppercase fw-semibold mb-0">
                                                        <option value="unassigned">Unassigned</option>
                                                        <option value="todo">To do</option>
                                                        <option value="inprogress">Inprogress</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-chat-1-line"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="small-div" id="drag2" draggable="true">
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                </div>
                                            </th>

                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">Thẻ công việc 2</div>
                                                    <div class="flex-shrink-0 ms-4">
                                                        <ul class="list-inline tasks-list-menu mb-0">
                                                            <li class="list-inline-item"><a href=""><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item"><a href="" data-bs-toggle="modal" data-bs-target="#createCardDetailModal"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="avatar-group" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                                    <a href="javascript: void(0);" class="avatar-group-item">
                                                        <i class="ri-user-add-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-calendar-2-line"> <input type="date" name="" id=""></i>
                                                </a>
                                            </td>

                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-flag-2-line"></i>
                                                </a>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-select fs-14 text-uppercase fw-semibold mb-0">
                                                        <option value="unassigned">Unassigned</option>
                                                        <option value="todo">To do</option>
                                                        <option value="inprogress">Inprogress</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-chat-1-line"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#createCardModal"><i
                                            class="ri-add-line align-bottom me-1"></i>Add Card</button>

                                    <!--end table-->

                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                        <div class="card" id="tasksList">
                            <div class="card-header border-0">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-grow-1">
                                        <h6 class="fs-14 text-uppercase fw-semibold mb-0">To do <small class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                                        </h6>
                                        <div class="d-flex ms-4">
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                            Thay đổi tên</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                            Thêm thẻ</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Sao chép danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Di chuyển danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Sao chép danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Lưu trữ danh sách</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end card-body-->
                            <div class="card-body">
                                <div class="table-responsive table-card mb-4">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col" style="width: 40px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                </div>
                                            </th>
                                            <th class="sort">Name</th>
                                            <th class="sort">Assigned To</th>
                                            <th class="sort">Due Date</th>
                                            <th class="sort">Priority</th>
                                            <th class="sort">Status</th>
                                            <th class="sort">Comments</th>
                                        </tr>
                                        </thead>
                                        <tbody class="form-check-all big-div" id="div2">
                                        <tr class="small-div" id="drag3" draggable="true">
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                </div>
                                            </th>

                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">Thẻ công việc 3</div>
                                                    <div class="flex-shrink-0 ms-4">
                                                        <ul class="list-inline tasks-list-menu mb-0">
                                                            <li class="list-inline-item"><a href=""><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item"><a href="" data-bs-toggle="modal" data-bs-target="#createCardDetailModal"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="avatar-group" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                                    <a href="javascript: void(0);" class="avatar-group-item">
                                                        <i class="ri-user-add-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-calendar-2-line"> <input type="date" name="" id=""></i>
                                                </a>
                                            </td>

                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-flag-2-line"></i>
                                                </a>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-select fs-14 text-uppercase fw-semibold mb-0">
                                                        <option value="unassigned">Unassigned</option>
                                                        <option value="todo">To do</option>
                                                        <option value="inprogress">Inprogress</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-chat-1-line"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        <tr class="small-div" id="drag4" draggable="true">
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                </div>
                                            </th>

                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">Thẻ công việc 4</div>
                                                    <div class="flex-shrink-0 ms-4">
                                                        <ul class="list-inline tasks-list-menu mb-0">
                                                            <li class="list-inline-item"><a href=""><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item"><a href="" data-bs-toggle="modal" data-bs-target="#createCardDetailModal"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="avatar-group" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                                    <a href="javascript: void(0);" class="avatar-group-item">
                                                        <i class="ri-user-add-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-calendar-2-line"> <input type="date" name="" id=""></i>
                                                </a>
                                            </td>

                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-flag-2-line"></i>
                                                </a>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-select fs-14 text-uppercase fw-semibold mb-0">
                                                        <option value="unassigned">Unassigned</option>
                                                        <option value="todo">To do</option>
                                                        <option value="inprogress">Inprogress</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-chat-1-line"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#createCardModal"><i
                                            class="ri-add-line align-bottom me-1"></i>Add Card</button>
                                    <!--end table-->
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                        <div class="card" id="tasksList">
                            <div class="card-header border-0">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-grow-1">
                                        <h6 class="fs-14 text-uppercase fw-semibold mb-0">Completed <small class="badge bg-warning align-bottom ms-1 totaltask-badge">2</small>
                                        </h6>
                                        <div class="d-flex ms-4">
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                            Thay đổi tên</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="ri-edit-2-line align-bottom me-2 text-muted"></i>
                                                            Thêm thẻ</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Sao chép danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Di chuyển danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Sao chép danh sách</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" data-bs-toggle="modal" href="#"><i
                                                                class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i>
                                                            Lưu trữ danh sách</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end card-body-->
                            <div class="card-body">
                                <div class="table-responsive table-card mb-4">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col" style="width: 40px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                </div>
                                            </th>
                                            <th class="sort">Name</th>
                                            <th class="sort">Assigned To</th>
                                            <th class="sort">Due Date</th>
                                            <th class="sort">Priority</th>
                                            <th class="sort">Status</th>
                                            <th class="sort">Comments</th>
                                        </tr>
                                        </thead>
                                        <tbody class="form-check-all big-div" id="div3">
                                        <tr class="small-div" id="drag5" draggable="true">
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                </div>
                                            </th>

                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">Thẻ công việc</div>
                                                    <div class="flex-shrink-0 ms-4">
                                                        <ul class="list-inline tasks-list-menu mb-0">
                                                            <li class="list-inline-item"><a href=""><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item"><a href="" data-bs-toggle="modal" data-bs-target="#createCardDetailModal"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="avatar-group" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                                    <a href="javascript: void(0);" class="avatar-group-item">
                                                        <i class="ri-user-add-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-calendar-2-line"> <input type="date" name="" id=""></i>
                                                </a>
                                            </td>

                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-flag-2-line"></i>
                                                </a>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-select fs-14 text-uppercase fw-semibold mb-0">
                                                        <option value="unassigned">Unassigned</option>
                                                        <option value="todo">To do</option>
                                                        <option value="inprogress">Inprogress</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-chat-1-line"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        <tr class="small-div" id="drag6" draggable="true">
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                </div>
                                            </th>

                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">Thẻ công việc</div>
                                                    <div class="flex-shrink-0 ms-4">
                                                        <ul class="list-inline tasks-list-menu mb-0">
                                                            <li class="list-inline-item"><a href=""><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item"><a href="" data-bs-toggle="modal" data-bs-target="#createCardDetailModal"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="avatar-group" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                                    <a href="javascript: void(0);" class="avatar-group-item">
                                                        <i class="ri-user-add-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-calendar-2-line"> <input type="date" name="" id=""></i>
                                                </a>
                                            </td>

                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-flag-2-line"></i>
                                                </a>
                                            </td>
                                            <td class="">
                                                <div class="flex-grow-1">
                                                    <select class="form-select fs-14 text-uppercase fw-semibold mb-0">
                                                        <option value="unassigned">Unassigned</option>
                                                        <option value="todo">To do</option>
                                                        <option value="inprogress">Inprogress</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                            </td>

                                            <td class="">
                                                <a href="javascript: void(0);" class="avatar-group-item">
                                                    <i class="ri-chat-1-line"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#createCardModal"><i
                                            class="ri-add-line align-bottom me-1"></i>Add Card</button>

                                    <!--end table-->
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                <div class="modal fade" id="createListModal" tabindex="-1" aria-labelledby="createListModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header p-3 bg-info-subtle">
                                <h5 class="modal-title" id="createListModalLabel">Add List</h5>
                                <button type="button" class="btn-close" id="addListBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="#">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="ListName" class="form-label">List Name</label>
                                            <input type="text" class="form-control" id="ListName" placeholder="Enter List name">
                                        </div>
                                        <div class="mt-4">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="addNewList">Add
                                                    List</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end add list modal-->
                <div class="modal fade" id="createCardModal" tabindex="-1" aria-labelledby="createCardModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header p-3 bg-info-subtle">
                                <h5 class="modal-title" id="createCardModalLabel">Add Card</h5>
                                <button type="button" class="btn-close" id="addBoardBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="#">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="boardName" class="form-label">Card Name</label>
                                            <input type="text" class="form-control" id="boardName" placeholder="Enter board name">
                                        </div>
                                        <div class="mt-4">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="addNewCard">Add
                                                    Card</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end add card modal-->

                <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header p-3 ps-4 bg-success-subtle">
                                <h5 class="modal-title" id="inviteMembersModalLabel">Team Members</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="search-box mb-3">
                                    <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>

                                <div class="mb-4 d-flex align-items-center">
                                    <div class="me-2">
                                        <h5 class="mb-0 fs-13">Members :</h5>
                                    </div>
                                    <div class="avatar-group justify-content-center">
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Tonya Noble">
                                            <div class="avatar-xs">
                                                <img src="{{asset('theme/admin/assets/images/users/avatar-10.jpg')}}" alt="" class="rounded-circle img-fluid">
                                            </div>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Thomas Taylor">
                                            <div class="avatar-xs">
                                                <img src="{{asset('theme/admin/assets/images/users/avatar-8.jpg')}}" alt="" class="rounded-circle img-fluid">
                                            </div>
                                        </a>
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Nancy Martino">
                                            <div class="avatar-xs">
                                                <img src="{{asset('theme/admin/assets/images/users/avatar-2.jpg')}}" alt="" class="rounded-circle img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                                    <div class="vstack gap-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <img src="{{asset('theme/admin/assets/images/users/avatar-2.jpg')}}" alt="" class="img-fluid rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-0"><a href="javascript:void(0);" class="text-body d-block">Nancy Martino</a></h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-light btn-sm">Add</button>
                                            </div>
                                        </div>
                                        <!-- end member item -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                    HB
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-0"><a href="javascript:void(0);" class="text-body d-block">Henry Baird</a></h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-light btn-sm">Add</button>
                                            </div>
                                        </div>
                                        <!-- end member item -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <img src="{{asset('theme/admin/assets/images/users/avatar-3.jpg')}}" alt="" class="img-fluid rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-0"><a href="javascript:void(0);" class="text-body d-block">Frank Hook</a></h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-light btn-sm">Add</button>
                                            </div>
                                        </div>
                                        <!-- end member item -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <img src="{{asset('theme/admin/assets/images/users/avatar-4.jpg')}}" alt="" class="img-fluid rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-0"><a href="javascript:void(0);" class="text-body d-block">Jennifer Carter</a></h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                 theme/admin/               <button type="button" class="btn btn-light btn-sm">Add</button>
                                            </div>
                                        </div>
                                        <!-- end member item -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                                    AC
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-0"><a href="javascript:void(0);" class="text-body d-block">Alexis Clarke</a></h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-light btn-sm">Add</button>
                                            </div>
                                        </div>
                                        <!-- end member item -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <img src="{{asset('theme/admin/assets/images/users/avatar-7.jpg')}}" alt="" class="img-fluid rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-0"><a href="javascript:void(0);" class="text-body d-block">Joseph Parker</a></h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-light btn-sm">Add</button>
                                            </div>
                                        </div>
                                        <!-- end member item -->
                                    </div>
                                    <!-- end list -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-success w-xs">Assigned</button>
                            </div>
                        </div>
                        <!-- end modal-content -->
                    </div>
                    <!-- modal-dialog -->
                </div>
                <!-- end modal add member -->

                <div class="modal fade" id="createCardDetailModal" tabindex="-1" aria-labelledby="createCardDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0">
                            <div class="modal-header p-3 bg-info-subtle">
                                <h5 class="modal-title" id="createCardDetailModalLabel">Title Card</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="#">
                                    <div class="card-container">
                                        <div class="card-content col-md-8">
                                            <div class="card-title">Tên bảng</div>
                                            <div class="card-subtitle">Trong danh sách:<a href="#">Tên list</a>
                                            </div>

                                            <div class="section">
                                                <div class="section-title">Description</div>
                                                <textarea name="" id="" rows="10" cols="" style="width: 90%;"></textarea>
                                            </div>

                                            <div class="section">
                                                <div class="section-title">Checklist</div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Default checkbox
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        Checked checkbox
                                                    </label>
                                                </div>

                                            </div>

                                            <div class="section">
                                                <div class="section-title">Comment</div>
                                                <div class="activity-log">
                                                    <div>
                                                        <input type="text" name="" id="">
                                                    </div>
                                                    <div>
                                                        <span>Aaaaa</span> added Checklist to this card
                                                        <span>25 minutes ago</span>
                                                    </div>
                                                    <div>
                                                        <span>bbbbb</span> added this card to 1 bảng
                                                        <span>25 minutes ago</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-sidebar col-md-4">
                                            <div class="sidebar-section">
                                                <div class="sidebar-title">Add to card</div>
                                                <div class="title" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">Members</div>
                                                <div class="title">Labels</div>
                                                <div class="title">Checklist</div>
                                                <div class="title">Date
                                                    <input type="date" name="" id="">
                                                </div>
                                                <div class="title">Attachment</div>
                                                <div class="title">Cover</div>
                                            </div>
                                            <div class="sidebar-section">
                                                <div class="sidebar-title">Actions</div>
                                                <div class="title">Move</div>
                                                <div class="title">Copy</div>
                                                <div class="title">Make template</div>
                                                <div class="title">Archive</div>
                                                <div class="title">Share</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end add task () modal-->


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Velzon.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- Left Sidebar End -->
