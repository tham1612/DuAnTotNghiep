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

        <button class="btn btn-primary"
                data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" data-bs-offset="70,10">
            <i class="ri-add-line me-1"></i>
                Thêm
            </button>
            <div class="dropdown-menu dropdown-menu-end p-3">
            <div class="my-2 cursor-pointer">
                <p data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-250">Danh sách</p>
                <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                    <form action="{{route('catalogs.store')}}" method="POST" onsubmit="disableButtonOnSubmit()">
                        @csrf
                        <h5 class="text-center">Thêm danh sách</h5>
                        <div class="mb-2">
                            <input type="text" class="form-control" id="exampleDropdownFormEmail"
                                   placeholder="Nhập tên danh sách..."name="name"/>
                            <input type="hidden" name="board_id" value="{{ $board->id }}">
                        </div>
                        <div class="mb-2 d-grid ">
                            <button type="submit" class="btn btn-primary">
                                Thêm danh sách
                            </button>

                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-2 cursor-pointer">
                <p  data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="200,-280"> Thẻ</p>
                <div class="dropdown-menu dropdown-menu-end p-3" style="width: 200%">
                    <form>
                        <h5 class="text-center">Thêm Task</h5>
                        <div class="mb-2">
                            <input type="text" class="form-control" id="" name="text"
                                   placeholder="Nhập tên thẻ..."/>
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control" id="" name="duration"
                                   placeholder="Nhập khoảng thời gian"/>
                        </div>
                        <div class="mb-2">
                            <input type="date" class="form-control" id="" name="start_date"
                                   placeholder="chọn ngày bắt đầu "/>
                        </div>
                        <div class="mb-2">
                            <select name="catalog_id" id="catalog_id" class="form-select">
                                <option value="">Chọn catalog</option>
                                @foreach ($catalogs as $catalog)
                                    <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 d-grid">
                            <button type="submit" class="btn btn-primary">
                                Thêm thẻ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="addCatalog1">

            </div>

        </div>
        <script type="text/javascript">
            gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
            gantt.config.order_branch = true;
            gantt.config.order_branch_free = true;
            gantt.init("gantt_here");
            gantt.load("/api/data");
            var dp = new gantt.dataProcessor("/api");
            dp.init(gantt);
            dp.setTransactionMode("REST");
            // Override showLightbox to open your custom modal
            gantt.showLightbox = function(taskId) {
                openCustomModal(taskId); // Gọi modal tùy chỉnh
            };

            // Hàm để mở modal tùy chỉnh
            function openCustomModal(taskId) {
                // Lấy phần tử modal dựa vào ID của nó
                var modalElement = document.getElementById('detailCardModal');

                if (modalElement) {
                    // Lấy task từ Gantt chart bằng taskId (giả sử bạn có taskId)
                    // var task = gantt.getTask(taskId);

                    // Đưa dữ liệu vào input trong modal
                    // var inputElement = document.getElementById("borderInput");
                    // if (inputElement) {
                    //     inputElement.value = task.text;
                    // } else {
                    //     console.error("Phần tử input không tìm thấy!");
                    // }

                    // Mở modal Bootstrap
                    var modalInstance = new bootstrap.Modal(modalElement);
                    modalInstance.show();
                } else {
                    console.error("Modal không tồn tại!");
                }
            }


        </script>
    </body>
@endsection
