<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel"
    style="width: 350px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-center" id="offcanvasRightLabel">
            Cài đặt
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)">
            <ul style="list-style: none;" class="p-3">
                <li class=" d-flex align-items-center justify-content-flex-start" style="margin-top: -30px;">
                    <i class=" ri-error-warning-line fs-22"></i>
                    <div class="ms-3 fs-15 mt-3">
                        <p style="margin-bottom: 0px; margin-top: 15px;">Chi tiết bảng</p>
                        <p class="fs-10 " style="margin-top: 0px;">Thêm mô tả vào bảng</p>
                    </div>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start">
                    <i class="ri-line-chart-line fs-22"></i>
                    {{-- <a href="{{ route('b.boards.activities', ['boardId' => $board->id]) }}"><p class="ms-3 fs-15 mt-3">Hoạt động</p></a> --}}
                    <a href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#activityCanvas">
                        <p class="ms-3 fs-15 mt-3">Hoạt động</p>
                    </a>


                </li>
                <li class=" d-flex align-items-center justify-content-flex-start">
                    <i class="ri-archive-line fs-22"></i>
                    <p class="ms-3 fs-15 mt-3">Mục đã lưu trữ</p>
                </li>
                <hr>
                <li class=" d-flex align-items-center justify-content-flex-start">
                    <i class="ri-settings-3-line fs-22"></i>
                    <p class="ms-3 fs-15 mt-3">Cài đặt</p>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start">
                    <i class="ri-eye-line fs-22"></i>
                    <p class="ms-3 fs-15 mt-3">Theo dõi</p>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start">
                    <i class=" ri-file-copy-line fs-22"></i>
                    <p class="ms-3 fs-15 mt-3">Sao chép bảng</p>
                </li>
                <li class=" d-flex align-items-center justify-content-flex-start cursor-pointer"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-subtract-line fs-22"></i>
                    <p class="ms-3 fs-15 mt-3">Đóng bảng thông tin</p>
                    <div class="dropdown-menu dropdown-menu-md p-3 w-100">
                        <h5 class="text-center">Đóng bảng?</h5>

                        <p>Bạn có thể tìm và mở lại các bảng đã đóng ở cài đặt tài khoản</p>

                        <button class="btn btn-danger w-100">Đóng</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- <div class="offcanvas-foorter border p-3 text-center">
      <a href="javascript:void(0);" class="link-success"
        >View All Activity
        <i class="ri-arrow-right-s-line align-middle ms-1"></i
      ></a>
    </div> -->
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="activityCanvas" aria-labelledby="activityCanvasLabel"
    style="width: 350px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="activityCanvasLabel">Hoạt động</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)">
            <ul style="list-style: none;" class="p-3">
                @if (!empty($activities))
                    @foreach ($activities as $activity)
                        <li class="d-flex align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    {{-- @if ($activity->causer->avatar)
                                        <img src="{{ asset('path_to_avatar/' . $activity->causer->avatar) }}"
                                            alt="avatar" class="rounded-circle" width="40" height="40">
                                    @else
                                        <div class="bg-info-subtle rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($activity->causer->name, 0, 1)) }}
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
                            <div>
                                <p class="mb-1">
                                    <strong>{{ $activity->causer->name ?? 'Hệ thống' }}:</strong>
                                    {{ $activity->description ?? 'Không có mô tả' }}
                                    {{-- <p>Hoạt động trên bảng: {{ $activity->properties['board_id'] }}</p> --}}
                                    {{-- <p>Tên catalog: {{ $activity->properties['catalog_name'] ?? 'Không có tên danh sách' }}</p> --}}
                                    {{-- <p>Task được thêm:{{ $activity->properties['text'] }}</p> --}}
                                </p>
                                <small class="text-muted">
                                    {{ $activity && $activity->created_at ? $activity->created_at->diffForHumans() : 'Không xác định thời gian' }}
                                </small>



                            </div>
                        </li>
                    @endforeach
                @endif

            </ul>
        </div>
    </div>
</div>
