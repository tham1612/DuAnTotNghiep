<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fs-20 mx-3 mt-2">Tên bảnggggggggg</h4>
                <button type="button" class="btn avatar-xs mt-n1 p-0 favourite-btn active">
                    <span class="avatar-title bg-transparent fs-15">
                        <i class="ri-star-fill fs-20 mx-2"></i>
                    </span>
                </button>
                <div class="mx-2 cursor-pointer" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false"
                     data-bs-offset="10,20">
                    <i class="ri-shield-user-fill fs-20 text-primary"></i>
                    <span class="fs-15">Không gian làm việc</span>
                    <!-- cài đặt quyền của bảng -->
                    <ul class="dropdown-menu dropdown-menu-md p-3" style="width: 35%"
                        aria-labelledby="dropdownMenuOffset">
                        <li>
                            <a class="dropdown-item w-100" href="#">
                                <i class="ri-lock-2-line fs-20 text-danger"></i>
                                <strong>Riêng tư</strong>
                                <p class="fs-13 w-100">
                                    Chỉ thành viên bảng thông tin mới có quyền xem
                                    bảng thông tin này. Quản trị viên của Không gian
                                    làm việc có thể đóng bảng thông tin hoặc xóa thành
                                    viên.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item w-100" href="#">
                                <i class="ri-shield-user-fill fs-20 text-primary"></i>
                                <strong>Không gian làm việc</strong>
                                <p class="fs-13 w-100">
                                    Tất cả thành viên của Không gian làm việc Trello
                                    Không gian làm việc có thể xem và sửa bảng thông
                                    tin này.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item w-100" href="#">
                                <i class="ri-earth-line fs-20 text-success"></i>
                                <strong>Công khai</strong>
                                <p class="fs-13 w-100">
                                    Bất kỳ ai trên mạng internet đều có thể xem bảng
                                    thông tin này. Chỉ thành viên bảng thông tin mới
                                    có quyền sửa.
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-left justify-content-between">
            <!-- các màn hình trong bảng -->
            <ul class="nav nav-pills d-flex justify-content-between align-items-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-home-tab" href="teams-spaces-overview.html" role="tab"
                       aria-controls="pills-home" aria-selected="true"><i class="ri-dashboard-line"></i> Overview</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" href="teams-spaces-board.html" role="tab"
                       aria-controls="pills-profile" aria-selected="false"><i class="ri-table-line"></i> Board</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-list-tab" href="teams-spaces-list.html" role="tab"
                       aria-controls="pills-list" aria-selected="false"><i class="ri-list-unordered"></i> List</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-calendar-tab" href="calendar.html" role="tab"
                       aria-controls="pills-calendar" aria-selected="false"><i class="ri-calendar-line"></i>
                        Calendar</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-gantt-tab" href="gantt.html" role="tab"
                       aria-controls="pills-gantt" aria-selected="false"><i class="ri-menu-2-line"></i> Gantt</a>
                </li>
                <li class="nav-item active" role="presentation">
                    <a class="nav-link" id="pills-table-tab" href="teams-spaces-table.html" role="tab"
                       aria-controls="pills-table" aria-selected="false"><i class="ri-layout-3-line"></i> Table</a>
                </li>
            </ul>
            <div class="col-auto ms-auto d-flex justify-content-end align-items-center">
                <!--  bộ lọc -->
                <div class="d-flex justify-content-center align-items-center p-1 cursor-pointer"
                     data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                    <i class="ri-filter-3-line fs-20"></i>
                    <span class="readonly">Bộ lọc</span>
                </div>
                <div class="fs-20 fw-lighter text-secondary">|</div>
                <!-- setting bộ lọc -->
                <ul class="dropdown-menu dropdown-menu-md p-3" style="width: 35%">
                    <p class="text-center fs-15"><strong>Lọc</strong></p>
                    <!-- lọc tìm kiếm -->
                    <div class="mt-2">
                        <strong>Từ khóa</strong>
                        <input type="text" name="" id="" placeholder="Nhập từ khóa..."
                               class="form-control" />
                        <span class="fs-10">Tìm kiếm các thẻ, các thành viên, các nhãn và hơn thế
                            nữa.</span>
                    </div>
                    <!-- lọc thành viên -->
                    <div class="mt-2">
                        <p><strong>Thành viên</strong></p>

                        <label for="no_member">
                            <input type="checkbox" name="" id="no_member" />
                            <span>Không có thành viên</span>
                        </label>
                        <br />
                        <label for="it_mee">
                            <input type="checkbox" name="" id="it_mee" />
                            <span>Các thẻ chỉ định cho tôi</span>
                        </label>
                    </div>
                    <!-- Ngày hết hạn -->
                    <div class="mt-2">
                        <p><strong>Ngày hết hạn</strong></p>
                        <label for="no_date">
                            <input type="checkbox" name="" id="no_date" />
                            <span>Không có ngày hết hạn</span>
                        </label>
                        <br />
                        <label for="no_overdue">
                            <input type="checkbox" name="" id="no_overdue" />
                            <span>Quá hạn</span>
                        </label>
                        <br />
                        <label for="due_tomorrow">
                            <input type="checkbox" name="" id="due_tomorrow" />
                            <span>Hết hạn vào ngày mai</span>
                        </label>
                    </div>
                    <!-- nhãn -->
                    <div class="mt-2">
                        <p><strong>Nhãn</strong></p>
                        <label for="no_tags" class="d-flex align-items-center">
                            <input type="checkbox" name="" id="no_tags" />
                            <i class="ri-price-tag-3-line mx-2 fs-20"></i>
                            <span class="rounded col-11">Không có nhãn</span>
                        </label>
                        <br />

                        <label for="primary_tags" class="d-flex align-items-center">
                            <input type="checkbox" name="" id="primary_tags" />
                            <span class="bg bg-primary mx-2 rounded p-3 col-11">
                            </span>
                        </label>
                        <br />
                        <label for="danger_tags" class="d-flex align-items-center">
                            <input type="checkbox" name="" id="danger_tags" />
                            <span class="bg bg-danger mx-2 rounded p-3 col-11">
                            </span>
                        </label>
                        <br />
                        <label for="success_tags" class="d-flex align-items-center">
                            <input type="checkbox" name="" id="success_tags" />
                            <span class="bg bg-success mx-2 rounded p-3 col-11">
                            </span>
                        </label>
                        <br />
                        <div data-input-flag data-option-flag-name>
                            <input type="text" class="form-control rounded-end flag-input" readonly
                                   placeholder="Chọn nhãn" data-bs-toggle="dropdown" aria-expanded="false" />
                            <div class="dropdown-menu w-100">
                                <div class="p-2 px-3 pt-1 searchlist-input">
                                    <input type="text"
                                           class="form-control form-control-sm border search-countryList"
                                           placeholder="Tìm kiếm nhãn" />
                                </div>
                                <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-ghost-secondary mt-2">
                            Lọc
                        </button>
                    </div>
                </ul>

                <section class="d-flex">
                    <!-- thêm thành viên & chia sẻ link bảng -->
                    <div class="d-flex justify-content-center align-items-center cursor-pointer me-2">
                        <div class="col-auto ms-sm-auto">
                            <div class="avatar-group" id="newMembar">
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                   data-bs-trigger="hover" data-bs-placement="top" title="Nancy">
                                    <img src="{{asset('theme/assets/images/users/avatar-5.jpg')}}" alt=""
                                         class="rounded-circle avatar-xs" />
                                </a>
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                   data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                    <img src="{{asset('theme/assets/images/users/avatar-3.jpg')}}" alt=""
                                         class="rounded-circle avatar-xs" />
                                </a>
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                   data-bs-trigger="hover" data-bs-placement="top" title="Tonya">
                                    <img src="{{asset('theme/assets/images/users/avatar-10.jpg')}}" alt=""
                                         class="rounded-circle avatar-xs" />
                                </a>
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                   data-bs-trigger="hover" data-bs-placement="top" title="Thomas">
                                    <img src="{{asset('theme/assets/images/users/avatar-8.jpg')}}" alt=""
                                         class="rounded-circle avatar-xs" />
                                </a>
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                   data-bs-trigger="hover" data-bs-placement="top" title="Herbert">
                                    <img src="{{asset('theme/assets/images/users/avatar-2.jpg')}}" alt=""
                                         class="rounded-circle avatar-xs" />
                                </a>
                            </div>
                        </div>
                        <div class="bg-primary p-2 rounded">
                            <i class="ri-user-add-line text-white"></i>
                            <a href="#addmemberModal" data-bs-toggle="modal" class="avatar-group-item">
                                <span class="text-white">Chia sẻ</span>
                            </a>
                        </div>
                    </div>
                    <!-- menu bảng -->
                    <div class="d-flex justify-content-center align-items-center p-2 cursor-pointer">
                        <i class="ri-list-settings-line fs-15" data-bs-toggle="offcanvas"
                           data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"></i>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
