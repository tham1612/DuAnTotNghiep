@extends('layouts.master')

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
        // gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
        gantt.init("gantt_here");
        // gantt.load("/api/data");
        // var dp = new gantt.dataProcessor("/api");
        // dp.init(gantt);
        // dp.setTransactionMode("REST");
    </script>
</body>
@endsection

