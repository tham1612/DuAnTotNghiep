@extends('layouts.masterMain')

@section('main')
    <!DOCTYPE html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">

    <style type="text/css">
        html, body {
            height: 100%;
            padding: 0;
            margin: 0;
            overflow: hidden;
            width: 100%;
        }
    </style>
</head>

<body>
<div id="gantt_here" style='width:100%; height:420px;'></div>
<script type="text/javascript">
    gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
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
        var task = gantt.getTask(taskId);

        // Đưa dữ liệu vào input trong modal
        var inputElement = document.getElementById("borderInput");
        if (inputElement) {
            inputElement.value = task.text;
        } else {
            console.error("Phần tử input không tìm thấy!");
        }

        // Mở modal Bootstrap
        var modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    } else {
        console.error("Modal không tồn tại!");
    }
}
Hàm để lưu thay đổi từ modal
function saveTask() {
    var taskId = gantt.getSelectedId();  // Lấy ID của tác vụ hiện tại
    var task = gantt.getTask(taskId);  // Lấy thông tin tác vụ

    // Lấy dữ liệu từ modal
    var inputElement = document.getElementById("borderInput");
    if (inputElement) {
        task.text = inputElement.value;  // Cập nhật thông tin task từ modal
    }

    // Cập nhật task trong Gantt chart
    gantt.updateTask(taskId);

    // Đóng modal
    var modalElement = document.getElementById('detailCardModal');
    if (modalElement) {
        var modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();  // Ẩn modal
        }
    }
}
</script>
</body>
@endsection

