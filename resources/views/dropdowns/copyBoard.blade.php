<h5 class="text-center">Sao chép bảng</h5>
<form class="submitFormCopyBoard">
    <div>
        <strong class="fs-14">Tiêu đề</strong>
        <input type="text" name="name" id="nameCopyBoard"
               class="form-control border-1 my-2" placeholder="Tên bảng" value="{{$board->name}} sao chép"/>
    </div>
    <div>
        <strong class="fs-14">Quyền của bảng</strong>
        <select name="access" class="form-select my-2">
            <option value="private">Riêng tư</option>
            <option value="public">Công khai</option>
        </select>
    </div>
    <div>
        <strong class="fs-14 mt-3">Giữ</strong>
        <ul style="list-style: none; margin-left: -32px" class="mt-2">
            <li>
                <input type="checkbox" name="isCatalog" id=""
                       class="form-check-input" checked value="1"/>
                <label for="">Danh sách công việc</label>
                <span>({{$board->catalogs->count()}})</span>
            </li>
            {{--            <li>--}}
            {{--                <input type="checkbox" name="isTask" id=""--}}
            {{--                       class="form-check-input" checked value="1"/>--}}
            {{--                <label for="">Thẻ công việc</label> <span>(1)</span>--}}
            {{--            </li>--}}
            <li>
                <input type="checkbox" name="isTag" id=""
                       class="form-check-input" checked value="1"/>
                <label for="">Nhãn công việc</label>
                <span>({{$board->tags->count()}})</span>
            </li>
        </ul>
    </div>
    <input type="hidden" name="workspace_id" value="{{$board->workspace_id}}">
    <input type="hidden" name="id" value="{{$board->id}}">
    <div class="mt-3 d-grid">
        <button class="btn bg-primary text-white ">Tạo bảng</button>
    </div>
</form>
