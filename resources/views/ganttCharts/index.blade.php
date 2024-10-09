@extends('layouts.masterMain')

@section('main')
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
        </style>
    </head>

    <body>
        @if (session('success'))
            <div class="alert alert-success m-4" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <div id="gantt_here" style='width:100%; height:350px;'></div>
        <br>

        <button class="btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-bs-offset="70,10">
            <i class="ri-add-line me-1"></i>
            Thêm
        </button>
        <div class="dropdown-menu dropdown-menu-end p-3">
            <div class="my-2 cursor-pointer">
                <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-250">Danh sách</p>
                <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                    <form action="{{ route('catalogs.store') }}" method="post" onsubmit="return disableButtonOnSubmit()">
                        @csrf
                        <div class="mb-2">
                            <input type="text" class="form-control" name="name" id="nameCatalog"
                                value="{{ old('name') }}" placeholder="Nhập tên danh sách..." />
                            <input type="hidden" name="board_id" value="{{ $board->id }}">
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <button type="submit" id="btnSubmitCatalog" class="btn btn-primary" disabled>
                                Thêm danh sách
                            </button>
                            <i class="ri-close-line fs-22 ms-2 cursor-pointer closeDropdown" role="button" tabindex="0"
                                aria-label="Close" data-dropdown-id="dropdownMenuOffset3"></i>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-2 cursor-pointer">
                <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-280"> Thẻ</p>
                <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                    <form method="POST" action="{{ route('tasks.store') }}" onsubmit="formatDateTimeOnSubmit()">
                        @csrf
                        <h5 class="text-center">Thêm Task</h5>

                        <div class="mb-2">
                            <input type="text" class="form-control" name="text" placeholder="Nhập tên thẻ..." required />
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
                                <option value="">---Lựa chọn---</option>
                                @foreach ($catalogs as $catalog)
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
            var boardId = "{{ $board->id}}"; // Gán giá trị ID của Board từ server
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
            var catalogs = @json($catalogs);

            // Hàm để lấy catalog theo ID
            function getCatalogById(catalog_id) {
                return catalogs.find(catalog => catalog.id == catalog_id);
            }

            // Hàm để mở modal tùy chỉnh
            function openCustomModal(taskId) {
                // Lấy phần tử modal dựa vào ID của nó
                var modalElement = document.getElementById('detailCardModal'+ taskId);

                if (modalElement) {
                    var modalInstance = new bootstrap.Modal(modalElement);
                    modalInstance.show();
                } else {
                    console.error("Modal không tồn tại!");
                }
            }
            gantt.attachEvent("onTaskCreated", function(task) {
                // goi modal tuy chinh
                openCustomModal(task.id);
                return false
            })
            gantt.config.buttons_left = "";
        </script>
    </body>
@endsection
