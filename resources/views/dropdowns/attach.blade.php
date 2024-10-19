<h5 class="text-center">Đính kèm</h5>
<form action="" class="mt-3" enctype="multipart/form-data">
    <strong class="fs-14">Đính kèm tệp từ máy tính của bạn</strong>
    <input type="file" name="file_name[]" id="file_name_task_{{$task->id}}"
           class="form-control mt-2" multiple onchange="uploadTaskAttachments( {{$task->id}} )"/>
</form>

<div class="mt-3">
    <strong class="fs-14">Đã xem gần đây</strong>
    <ul class="" style="list-style: none; margin-left: -32px">
        <li class="mt-1 d-flex justify-content-between align-items-center">
            <i class="ri-artboard-line fs-20"></i>
            <div class="w-100">
                <strong class="ms-2 rounded">Tên thẻ</strong>
                <br/>
                <span class="ms-2">Tên bảng - Đã xem 2 giờ trước</span>
            </div>
        </li>
        <li class="mt-2 d-flex justify-content-between align-items-center">
            <i class="ri-artboard-line fs-20"></i>
            <div class="w-100">
                <strong class="ms-2 rounded">Tên thẻ</strong>
                <br/>
                <span class="ms-2">Tên bảng - Đã xem 2 giờ trước</span>
            </div>
        </li>
    </ul>
</div>


