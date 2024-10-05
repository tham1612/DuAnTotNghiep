<!-- chia sẻ bảng & thêm thành viên -->
<div class="modal fade" id="addmemberModal" tabindex="-1" aria-labelledby="addmemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="addmemberModalLabel">
                    Chia sẻ bảng
                </h5>
                <button type="button" class="btn-close" id="btn-close-member" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <form action="{{ route('b.invite_board', $id) }}" method="post">
                            <div class=" d-flex justify-content-between">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="submissionidInput"
                                        placeholder="Nhập email hoặc tên người dùng" name="email" />
                                </div>
                                <div class="col-4 ms-2">
                                    <select name="authorize" id="" class="form-select">
                                        <option value="Member">Thành Viên</option>
                                        <option value="Sub_Owner">Phó nhóm</option>
                                        <option value="Viewer">Người Xem</option>
                                    </select>
                                </div>
                                <div class="col-2 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">
                                        Chia sẻ
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end col-->
                        <div class="d-flex justify-content-between">
                            <div class="col-1">
                                <i class="ri-attachment-2 fs-22"></i>
                            </div>
                            <div class="col-7 d-flex flex-column">
                                <section class="fs-12">
                                    <p style="margin-bottom: -5px;">Bất kỳ ai có thể theo gia với tư
                                        cách thành viên</p>
                                    <span><a href="">Sao chép liên kết</a></span>
                                    <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                    <span><a href="">Xóa liên kết</a></span>
                                </section>
                            </div>
                            <div class="col-4">
                                <select name="" id="" class="form-select">
                                    <option value="">Thay đổi quyền</option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                            <li class="nav-item d-flex align-items-center justify-content-between">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    Thành viên trong bảng
                                </a>
                                <span class="badge bg-dark align-items-center justify-content-center d-flex"
                                    style="border-radius: 100%; width: 20px ;height: 20px;">2</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    Yêu cầu tham gia
                                </a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <ul style="margin-left: -32px;">
                                    <li class="d-flex">
                                        <div class="col-1">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="Nancy">
                                                <img src="{{ Storage::url(\Illuminate\Support\Facades\Auth::user()->image) ? Storage::url(\Illuminate\Support\Facades\Auth::user()->image) : '' }}"
                                                    alt="" class="rounded-circle avatar-xs" />
                                            </a>
                                        </div>
                                        <div class="col-7 d-flex flex-column">
                                            <section class="fs-12">
                                                <p style="margin-bottom: 0px;">vinhpq <span>(bạn)</span>
                                                </p>
                                                <span>@vinhphi</span>
                                                <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                                <span>Quản trị viên không gian làm việc</span>
                                            </section>
                                        </div>
                                        <div class="col-4">
                                            <select name="" id="" class="form-select">
                                                <option value="">Quản trị viên</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane" id="profile1" role="tabpanel">
                                <ul style="margin-left: -32px;">
                                    <li class="d-flex justify-content-between">
                                        <div class="col-1">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Nancy">
                                                <img src="{{ Storage::url(\Illuminate\Support\Facades\Auth::user()->image) ? Storage::url(\Illuminate\Support\Facades\Auth::user()->image) : '' }}"
                                                    alt="" class="rounded-circle avatar-xs" />
                                            </a>
                                        </div>
                                        <div class="col-7 d-flex flex-column">
                                            <section class="fs-12">
                                                <p style="margin-bottom: 0px;">vinhpq <span>(bạn)</span>
                                                </p>
                                                <span>@vinhphi</span>
                                                <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                                <span>Quản trị viên không gian làm việc</span>
                                            </section>
                                        </div>
                                        <div class="col-4 d-flex justify-content-end">
                                            <button class="btn btn-primary me-2">Duyệt</button>
                                            <button class="btn btn-danger">Từ chối</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
