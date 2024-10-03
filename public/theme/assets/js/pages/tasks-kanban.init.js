var myModalEl,
    kanbanboard,
    scroll,
    addNewBoard,
    addMember,
    profileField,
    reader;

var taskId = document.getElementsByClassName('tasks-box');
var catalog_id_old, catalog_id;

function noTaskImage() {
    Array.from(document.querySelectorAll("#kanbanboard .tasks-list")).forEach(
        function (e) {
            0 < e.querySelectorAll(".tasks-box").length
                ? e.querySelector(".tasks").classList.remove("noTask")
                : e.querySelector(".tasks").classList.add("noTask");
        }
    );
}

function taskCounter() {
    (task_lists = document.querySelectorAll("#kanbanboard .tasks-list")) &&
    Array.from(task_lists).forEach(function (e) {
        (tasks = e.getElementsByClassName("tasks")),
            Array.from(tasks).forEach(function (e) {
                (task_box = e.getElementsByClassName("tasks-box")),
                    (task_counted = task_box.length);
            }),
            (badge = e.querySelector(".totaltask-badge").innerText = ""),
            (badge = e.querySelector(".totaltask-badge").innerText = task_counted);
    });
}

function newKanbanbaord() {
    var e = document.getElementById("boardName").value,
        a = Math.floor(100 * Math.random()),
        t = "review_task_" + a;
    (kanbanlisthtml =
        '<div class="tasks-list" id=' +
        ("remove_item_" + a) +
        '><div class="d-flex mb-3"><div class="flex-grow-1"><h6 class="fs-14 text-uppercase fw-semibold mb-0">' +
        e +
        '<small class="badge bg-success align-bottom ms-1 totaltask-badge">0</small></h6></div><div class="flex-shrink-0"><div class="dropdown card-header-dropdown"><a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fw-medium text-muted fs-12">Priority<i class="mdi mdi-chevron-down ms-1"></i></span></a><div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Priority</a><a class="dropdown-item" href="#">Date Added</a></div></div></div></div><div data-simplebar class="tasks-wrapper px-3 mx-n3"><div class="tasks" id="' +
        t +
        '" ></div></div><div class="my-3"><button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#creatertaskModal">Add More</button></div></div>'),
        document
            .getElementById("kanbanboard")
            .insertAdjacentHTML("beforeend", kanbanlisthtml),
        document.getElementById("addBoardBtn-close").click(),
        noTaskImage(),
        taskCounter(),
        drake.destroy(),
        tasks_list.push(document.getElementById(t)),
        (drake = dragula(tasks_list).on("out", function (e, a) {
            noTaskImage(), taskCounter();
        })),
        (document.getElementById("boardName").value = "");
}

function newMemberAdd() {
    var e = document.getElementById("firstnameInput").value,
        a = localStorage.getItem("kanbanboard-member");
    (newMembar =
        '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' +
        e +
        '">' +
        a +
        "</a>"),
        document
            .getElementById("newMembar")
            .insertAdjacentHTML("afterbegin", newMembar),
        document.getElementById("btn-close-member").click();
}

tasks_list &&
((myModalEl = document.getElementById("deleteRecordModal")) &&
myModalEl.addEventListener("show.bs.modal", function (e) {
    document
        .getElementById("delete-record")
        .addEventListener("click", function () {
            e.relatedTarget.closest(".tasks-box").remove(),
                document.getElementById("delete-btn-close").click(),
                taskCounter();
        });

}),
    (drake = dragula(tasks_list)
        .on("drag", function (e) {
            // catalog truoc do
            const targetList = e.parentElement.closest('.tasks-list');
            catalog_id_old = targetList.dataset.value;
            // lấy id task bị keo
            console.log('catalog_old ' + catalog_id_old);
            taskId = event.target.closest('.tasks-box').dataset.value;
            console.log(taskId)
            e.className = e.className.replace("ex-moved", "");
        })
        .on("drop", function (e, target) {
            // Lấy data-value của danh sách (task list) mà task được thả vào
            const targetList = e.parentElement.closest('.tasks-list'); // Lấy phần tử cha (tasks-list) chứa task vừa được thả
            if (targetList) {
                // lấy id catalog được thả vào
                catalog_id = targetList.dataset.value;
                console.log("Task " + taskId + " được thả vào danh sách với giá trị:", catalog_id); // Xuất giá trị của danh sách ra console
            }
            // lấy vị trí cuối cùng trong danh sách
            const tasks = Array.from(target.children);
            const position = tasks.indexOf(e);
            console.log('vị trí được thả', position)

            // $(document).ready(function () {
                $.ajax({
                    url: `/tasks/updatePosition/${taskId}` ,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    data: {
                        position,
                        catalog_id_old,
                        catalog_id
                    },
                    success: function (response) {
                        console.log(response);
                    }
                })
            // })
            e.className += " ex-moved";
        })
        .on("over", function (e, a) {
            a.className += " ex-over";
        })
        .on("out", function (e, a) {
            (a.className = a.className.replace("ex-over", "")),
                noTaskImage(),
                taskCounter();
        })),
(kanbanboard = document.querySelectorAll("#kanbanboard")) &&
(scroll = autoScroll([document.querySelector("#kanbanboard")], {
    margin: 20,
    maxSpeed: 100,
    scrollWhenOutside: !0,
    autoScroll: function () {

        return this.down && drake.dragging;
    },
})),
(addNewBoard = document.getElementById("addNewBoard")) &&
document
    .getElementById("addNewBoard")
    .addEventListener("click", newKanbanbaord),
    (addMember = document.getElementById("addMember"))) &&
(document.getElementById("addMember").addEventListener("click", newMemberAdd),
    (profileField = document.getElementById("profileimgInput")),
    (reader = new FileReader()),
    profileField.addEventListener("change", function (e) {
        reader.readAsDataURL(profileField.files[0]),
            (reader.onload = function () {
                var e = reader.result;
                localStorage.setItem(
                    "kanbanboard-member",
                    '<img src="' + e + '" alt="profile" class="rounded-circle avatar-xs">'
                );
            });
    }));
