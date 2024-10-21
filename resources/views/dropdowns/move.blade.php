{{--<h5 class="text-center">Di chuyển thẻ</h5>--}}
{{--<form>--}}
{{--    <strong class="fs-14">Chọn đích đến</strong>--}}
{{--    <div class="mt-2">--}}
{{--        <strong class="fs-16">Bảng thông tin</strong>--}}
{{--        <select name="" id="" class="form-control">--}}
{{--            <option value="">{{$board->name}}</option>--}}
{{--        </select>--}}
{{--    </div>--}}
{{--    <div class="row mt-2">--}}
{{--        <section class="col-8">--}}
{{--            <strong class="fs-16">Danh sách</strong>--}}
{{--            <select name="catalog_id" id="di-chuyen-catalog-id-{{ $task->id }}"--}}
{{--                    class="form-control no-arrow fs-16"--}}
{{--                    onchange="test({{ $task->id }})">--}}
{{--                @foreach ($board->catalogs as $catalog)--}}
{{--                    <option value="{{ $catalog->id }}"--}}
{{--                        @selected($catalog->id == $task->catalog_id)>--}}
{{--                        {{ $catalog->name }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </section>--}}
{{--        <section class="col-4">--}}
{{--            <strong class="fs-16">Vị trí</strong>--}}
{{--            <select name="task_position" id="task-position-{{ $task->id }}" class="form-select">--}}
{{--                <!-- Tạo ra các nhóm option cho từng catalog -->--}}
{{--                @foreach ($board->catalogs as $catalog)--}}
{{--                    <optgroup label="Danh sách: {{ $catalog->name }}" class="catalog-group" data-catalog="{{ $catalog->id }}">--}}
{{--                        @foreach ($catalog->tasks as $taskItem)--}}
{{--                            <option value="{{ $taskItem->id }}">{{ $taskItem->position }}</option>--}}
{{--                        @endforeach--}}
{{--                    </optgroup>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </section>--}}
{{--    </div>--}}
{{--    <button type="button" class="btn btn-primary waves-effect mt-2">--}}
{{--        Di chuyển--}}
{{--    </button>--}}
{{--</form>--}}

{{--<script>--}}
{{--    function test(taskId) {--}}
{{--        var catalogId = document.getElementById('di-chuyen-catalog-id-' + taskId).value;--}}

{{--        // Ẩn tất cả các optgroup--}}
{{--        var optGroups = document.querySelectorAll('#task-position-' + taskId + ' optgroup');--}}
{{--        optGroups.forEach(function(optGroup) {--}}
{{--            optGroup.style.display = 'none';  // Ẩn tất cả các nhóm task--}}
{{--        });--}}

{{--        // Hiển thị đúng nhóm optgroup theo catalogId đã chọn--}}
{{--        var selectedOptGroup = document.querySelector('#task-position-' + taskId + ' optgroup[data-catalog="' + catalogId + '"]');--}}
{{--        if (selectedOptGroup) {--}}
{{--            selectedOptGroup.style.display = 'block';  // Hiển thị nhóm task tương ứng với catalog--}}
{{--        }--}}
{{--    }--}}

{{--    // Khởi tạo mặc định khi trang tải--}}
{{--    document.addEventListener('DOMContentLoaded', function() {--}}
{{--        var taskId = {{ $task->id }};--}}
{{--        updateTaskPositions(taskId);  // Gọi ngay khi trang tải--}}
{{--    });--}}
{{--</script>--}}
