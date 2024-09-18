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

// thay
    gantt.config.lightbox.sections = [
   {name:"description", height:70, map_to:"text", type:"textarea", focus:true},
   {name:"progress", height:30, map_to:"progress", type:"text"},
   {name:"time", type:"duration", map_to:"auto"}
];
gantt.init("gantt_here");
gantt.config.lightbox.sections = [
   {name:"description", height:70, map_to:"text", type:"textarea", focus:true},
   {name:"priority", height:30, map_to:"priority", type:"select", options:[
       {key:1, label:"High"},
       {key:2, label:"Medium"},
       {key:3, label:"Low"}
   ]},
   {name:"status", height:30, map_to:"status", type:"select", options:[
       {key:1, label:"Completed"},
       {key:2, label:"In Progress"},
       {key:3, label:"Not Started"}
   ]},
   {name:"time", type:"duration", map_to:"auto"}
];
//kết thúc
gantt.init("gantt_here");

</script>
</body>
@endsection

