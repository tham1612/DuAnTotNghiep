@extends('layouts.masterMain')

@section('main')
@if(session('error'))
<div class="alert alert-danger custom-alert">
    {{ session('error') }}
</div>
@endif

<style>
.custom-alert {
    border-radius: 0.5rem;
    padding: 1rem;
    position: relative;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
</style>
    <!DOCTYPE html>

    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">

        <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
        <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">

        <style type="text/css">
            html,
            body {
                height: 100%;
                padding: 0;
                margin: 0;
                overflow: hidden;
                width: 100%;
            }

            .custom_grid_background {
                background-color: #fff3f3;

            }

            /* .custom_task_background {
                    background-color: #f1edf0;
                } */
        </style>
    </head>

    <body>
        {{-- @if (session('success'))
            <div class="alert alert-success m-4" id="success-alert">
                {{ session('success') }}
            </div>
        @endif --}}

        <div id="gantt_here" style='width:100%; height:50vh'></div>
        <br>

        <button class="btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-bs-offset="70,10">
            <i class="ri-add-line me-1"></i>
            Thêm
        </button>
        <div class="dropdown-menu dropdown-menu-end p-3">
            <div class="my-2 cursor-pointer">
                <p data-bs-toggle="dropdown" aria-expanded="false"
                   onclick="loadFormAddCatalog({{ $board->id }})"
                   data-bs-offset="200,-250">Danh sách</p>
                <div class="dropdown-menu dropdown-menu-end p-3 dropdown-content-add-catalog-{{$board->id }}"
                     style="width: 200%" aria-labelledby="addCatalog">
                    {{--dropdown.createCatalog--}}
                </div>
            </div>

            <div class="mt-2 cursor-pointer">
                <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-280"> Thẻ</p>
                <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                    <form method="POST" action="{{ route('tasks.store') }}" onsubmit="formatDateTimeOnSubmit()" class="formItem">
                        @csrf
                        <h5 class="text-center">Thêm Task</h5>
                        <div class="mb-2">
                            <input type="text" class="form-control" name="text" placeholder="Nhập tên thẻ..."
                                required />
                        </div>
                        <div class="mb-2">
                            <select name="parent"  class="form-select">
                                <option value="">Parent</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="">Ngày bắt đầu</label>
                            <input type="datetime-local" class="form-control" name="start_date" id="start_date" required />
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="">Ngày kết thúc</label>
                            <input type="datetime-local" class="form-control" name="end_date" id="end_date" required />
                        </div>
                        <div class="mb-2">
                            <select name="catalog_id" id="" class="form-select">
                                <option value="">Catalog</option>
                                @foreach ($board->catalogs as $catalog)
                                    <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 d-grid">
                            <button type="submit" class="btn btn-primary">Thêm Task</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="addCatalog1">
            </div>

        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="activityCanvas" aria-labelledby="activityCanvasLabel"
            style="width: 350px;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="activityCanvasLabel">Hoạt động</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

        </div>
        <script type="text/javascript">
            gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
            gantt.config.order_branch = true;
            // gantt.config.order_branch_free = true;
            var boardId = "{{ $board->id }}"; // Gán giá trị ID của Board từ server
            gantt.init("gantt_here");
            gantt.load("/api/boards/" + boardId + "/tasks");
            // Cập nhật dataProcessor để thao tác với đúng URL
            var dp = new gantt.dataProcessor("/api");
            dp.init(gantt);
            dp.setTransactionMode("REST");
            // Override showLightbox to open your custom modal
            gantt.showLightbox = function(taskId) {
                openCustomModal(taskId); // Gọi modal tùy chỉnh
            };
            gantt.config.columns = [{
                    name: "text",
                    label: "Thẻ",
                    tree: true,
                    width: '*'
                }, // Cột tên nhiệm vụ
                {
                    name: "catalog",
                    label: "Danh Sách",
                    align: "center",
                    width: 200,
                    template: function(task) {
                        var catalog = getCatalogById(task.catalog_id); // Hàm lấy tên catalog
                        return catalog ? catalog.name :
                            "Không có danh sách"; // Hiển thị tên catalog, hoặc thông báo nếu không có
                    }
                }
            ];

            // Giả sử bạn đã có dữ liệu catalogs từ server
            var catalogs = @json($board->catalogs);

            // Hàm để lấy catalog theo ID
            function getCatalogById(catalog_id) {
                return catalogs.find(catalog => catalog.id == catalog_id);
            }

            // Hàm để mở modal tùy chỉn


            gantt.attachEvent("onTaskCreated", function(task) {
                // goi modal tuy chinh
                openCustomModal(task.id);
                return false
            })
            gantt.config.buttons_left = "";
            gantt.templates.grid_row_class = function(start, end, task) {
                return "custom_grid_background"; // Thay đổi màu nền của hàng lưới
            };
            gantt.templates.timeline_cell_class = function(task, date) {
                return "custom_task_background"; // Thay đổi màu nền của ô nhiệm vụ
            };
        </script>
    </body>
@endsection
