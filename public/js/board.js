function archiverBoard(boardId) {
    console.log(boardId);
    $.ajax({
        url: `/b/${boardId}`,
        type: "POST",
        success: function(response) {
            notificationWeb(response.action, response.msg);
            if (response.action === "success")
                window.location.href = "http://127.0.0.1:8000/home";
        },
        error: function(xhr) {
            notificationWeb(response.action, response.msg);
        },
    });
}

function restoreBoard(boardId) {
    console.log(boardId);
    $.ajax({
        url: `/b/restoreBoard/${boardId}`,
        type: "POST",

        success: function (response) {
            let boardArchiverViewHeader = document.getElementById(`board-archiver-view-header-${boardId}`)

            notificationWeb(response.action, response.msg);


            if (response.action === "success") {
                if (boardArchiverViewHeader) boardArchiverViewHeader.remove();
                setTimeout(function () {
                    window.location.href = `http://127.0.0.1:8000/b/${response.board.id}/edit`;
                }, 1500)

            }


        },
        error: function(xhr) {
            notificationWeb(response.action, response.msg);
        },
    });
}

function destroyBoard(boardId) {
    console.log(boardId);
    $.ajax({
        url: `/b/destroyBoard/${boardId}`,
        type: "POST",

        success: function (response) {
            let boardArchiverViewHeader = document.getElementById(`board-archiver-view-header-${boardId}`)
            notificationWeb(response.action, response.msg);
            if (response.action === "success") {
                if (boardArchiverViewHeader) boardArchiverViewHeader.remove();
            }

        },
        error: function(xhr) {
            notificationWeb(response.action, response.msg);
        },
    });
}

// sao chép bảng
$(".submitFormCopyBoard").on("submit", function(e) {
    e.preventDefault();

    var name = $("#nameCopyBoard").val().trim();
    if (name === "") {
        notificationWeb("error", "Vui lòng nhập tiêu đề");
        return;
    }
    console.log(name);
    $.ajax({
        url: "/b/copyBoard",
        type: "POST",
        data: $(this).serialize(), // Lấy dữ liệu từ form
        success: function(response) {
            notificationWeb("success", "Sao chép bảng thành công");
            window.location.href = `http://127.0.0.1:8000/b/${response.board_id}/edit?viewType=board`;
        },
        error: function(xhr, status, error) {
            notificationWeb("error", "Có lỗi xảy ra!!");
        },
    });
});

//xử lý chọn board + catalog
// Khi chọn Board, lấy các Catalog tương ứng
$(document).on("change", ".toBoard", function(e) {
    var boardId = $(this).val();
    var toCatalogSelect = $(this)
        .closest(".mt-2")
        .next(".row")
        .find(".toCatalog");
    var toPositionSelect = $(this)
        .closest(".mt-2")
        .next(".row")
        .find(".toPosition");

    $.ajax({
        url: "/b/getDataBoard",
        method: "POST",

        data: { board_id: boardId },
        success: function(data) {

            // Xóa các option hiện tại trong Catalog và Position
            toCatalogSelect.empty();
            toPositionSelect.empty();

            // Thêm các option mới cho Catalog
            $.each(data.catalogs, function(index, catalog) {
                toCatalogSelect.append(
                    `<option value="${catalog.id}" data-task-count="${catalog.task_count}">${catalog.name}</option>`
                );
            });
        },
        error: function(xhr) {
            console.error("AJAX error:", xhr.responseText); // Ghi lại lỗi nếu có
        },
    });
});

// quyền của bảng
function updatePermission(permissionType, value, boardId) {
    $.ajax({
        url: `/b/settingBoard/${boardId}`,
        type: "POST",
        data: {
            permissionType: permissionType,
            value: value,
        },
        success: function(response) {
            console.log(response.board);
            notificationWeb(response.action, response.msg);

            let titleBoardNavbar = document.getElementById(
                `2-name-board-${response.board.id}`
            );
            let titleBoardSidebar = document.getElementById(
                `name-board-${response.board.id}`
            );
            let iconAccessBoardNavbar = document.getElementById(
                `accessIcon_${response.board.id}`
            );
            let textAccessBoardNavbar = document.getElementById(
                `accessText_${response.board.id}`
            );

            titleBoardNavbar.innerHTML = response.board.name;
            titleBoardSidebar.innerHTML = response.board.name;

            if (response.board.access === "private") {
                iconAccessBoardNavbar.classList.add("ri-lock-2-line");
                iconAccessBoardNavbar.classList.add("text-danger");
                iconAccessBoardNavbar.classList.remove("ri-shield-user-fill");
                iconAccessBoardNavbar.classList.remove("text-primary");
                textAccessBoardNavbar.innerHTML = "Riêng tư";
            }

            if (response.board.access === "public") {
                iconAccessBoardNavbar.classList.add("ri-shield-user-fill");
                iconAccessBoardNavbar.classList.add("text-primary");
                iconAccessBoardNavbar.classList.remove("ri-lock-2-line");
                iconAccessBoardNavbar.classList.remove("text-danger");

                textAccessBoardNavbar.innerHTML = "Công khai";
            }
        },
        error: function(error) {
            notificationWeb(response.action, response.msg);
        },
    });
}

// tạo bảng mẫu

$(".submitFormBoardTemplate").on("submit", function (e) {

    e.preventDefault();

    var form = $(this);
    var name = form.find(".titleBoardTemplate").val().trim();
    if (name === "") {
        notificationWeb("error", "Vui lòng nhập tiêu đề");
        return;
    }
    console.log(name);
    $.ajax({
        url: "/boardTemplate/create",
        type: "POST",
        data: $(this).serialize(), // Lấy dữ liệu từ form
        success: function(response) {
            notificationWeb(response.action, response.msg);
            if (response.action == "success")
                window.location.href = `http://127.0.0.1:8000/b/${response.board_id}/edit?viewType=board`;
        },
        error: function(xhr, status, error) {
            notificationWeb("error", "Có lỗi xảy ra!!");
        },
    });
});