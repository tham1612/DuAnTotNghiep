function archiverBoard(boardId) {
    console.log(boardId);
    $.ajax({
        url: `/b/${boardId}`,
        type: "POST",
        success: function (response) {
            notificationWeb(response.action, response.msg);
            if (response.action === "success")
                window.location.href = "http://127.0.0.1:8000/home";
        },
        error: function (xhr) {
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
            let boardArchiverViewHeader = document.getElementById(
                `board-archiver-view-header-${boardId}`
            );

            notificationWeb(response.action, response.msg);

            if (response.action === "success") {
                if (boardArchiverViewHeader) boardArchiverViewHeader.remove();
                setTimeout(function () {
                    window.location.href = `http://127.0.0.1:8000/b/${response.board.id}/edit`;
                }, 1500);
            }
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg);
        },
    });
}

function destroyBoard(boardId) {
    Swal.fire({
        // title: "Xóa bảng vĩnh viễn?",
        html: `
                <div>
                <strong class="fs-20">Xóa bảng vĩnh viễn?</strong>
                  <p class="fs-15 mt-2" style="text-align: left">Những điều cần biết</p>
                     <ul class="fs-14" style="text-align: left;margin-top: -10px">
                         <li>Điều này là vĩnh viễn và không thể hoàn tác.</li>
                         <li>Các danh sách, thẻ thuộc bảng sẽ bị xóa vĩnh viễn</li>
                     </ul>
                </div>
                `,
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Đồng ý",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/b/destroyBoard/${boardId}`,
                type: "POST",

                success: function (response) {
                    let boardArchiverViewHeader = document.getElementById(
                        `board-archiver-view-header-${boardId}`
                    );
                    notificationWeb(response.action, response.msg);
                    if (response.action === "success") {
                        if (boardArchiverViewHeader)
                            boardArchiverViewHeader.remove();
                    }
                },
                error: function (xhr) {
                    notificationWeb(response.action, response.msg);
                },
            });
        }
    });
}

// sao chép bảng
$(".submitFormCopyBoard").on("submit", function (e) {
    e.preventDefault();

    var name = $("#nameCopyBoard").val().trim();
    if (name === "") {
        notificationWeb("error", "Vui lòng nhập tiêu đề");
        return;
    }
    $.ajax({
        url: "/b/copyBoard",
        type: "POST",
        data: $(this).serialize(), // Lấy dữ liệu từ form
        success: function (response) {
            notificationWeb(response.action, response.msg);
            if (response.action === "success")
                window.location.href = `http://127.0.0.1:8000/b/${response.board_id}/edit?viewType=board`;
        },
        error: function (xhr, status, error) {
            notificationWeb("error", "Có lỗi xảy ra!!");
        },
    });
});

//xử lý chọn board + catalog
// Khi chọn Board, lấy các Catalog tương ứng
$(document).on("change", ".toBoard", function (e) {
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
        success: function (data) {
            // Xóa các option hiện tại trong Catalog và Position
            toCatalogSelect.empty();
            toPositionSelect.empty();

            // Thêm các option mới cho Catalog
            $.each(data.catalogs, function (index, catalog) {
                toCatalogSelect.append(
                    `<option value="${catalog.id}" data-task-count="${catalog.task_count}">${catalog.name}</option>`
                );
            });
        },
        error: function (xhr) {
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
        success: function (response) {
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

            const isPrivate = response.board.access === "private";
            iconAccessBoardNavbar.classList.toggle("ri-lock-2-line", isPrivate);
            iconAccessBoardNavbar.classList.toggle("text-danger", isPrivate);
            iconAccessBoardNavbar.classList.toggle(
                "ri-shield-user-fill",
                !isPrivate
            );
            iconAccessBoardNavbar.classList.toggle("text-primary", !isPrivate);

            textAccessBoardNavbar.innerHTML = isPrivate
                ? "Riêng tư"
                : "Công khai";
        },
        error: function (error) {
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
        success: function (response) {
            notificationWeb(response.action, response.msg);
            if (response.action == "success")
                window.location.href = `http://127.0.0.1:8000/b/${response.board_id}/edit?viewType=board`;
        },
        error: function (xhr, status, error) {
            notificationWeb("error", "Có lỗi xảy ra!!");
        },
    });
});

//kích thành viên khỏi bảng
document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên các nút kích thành viên
    document
        .querySelectorAll(".dropdown-item.text-danger")
        .forEach((button) => {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                // const wmId = this.getAttribute("data-wm-id"); // Lấy wm_id từ thuộc tính data
                const wmId = this.getAttribute("href").split("/").pop();
                const link = `li_board_${wmId}`;
                const listItem = document.getElementById(link); // Tìm thẻ li tương ứng
                const count1 = document.getElementById("tab_board_1");
                const so1 = count1.innerText - 1;
                console.log(link);

                if (!listItem) {
                    alert("Không tìm thấy thành phần cần chuyển!");
                    return;
                }

                // Gọi AJAX
                fetch(`/b/activate-member/${wmId}`, {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest", // Để Laravel nhận diện đây là AJAX request
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Xóa thẻ li khỏi tab-ul-1
                            listItem.remove();
                            count1.innerHTML = so1;
                            // Hiển thị thông báo thành công
                            notificationWeb(data.action, data.msg);
                            // location.reload();
                        }
                    });
            });
        });
});

//thăng cấp thành viên
document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên các nút kích thành viên
    document
        .querySelectorAll(".dropdown-item.text-primary")
        .forEach((button) => {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                // const wmId = this.getAttribute("data-wm-id"); // Lấy wm_id từ thuộc tính data
                const wmId = this.getAttribute("href").split("/").pop();
                const link = `li_board_${wmId}`;
                const listItem = document.getElementById(link); // Tìm thẻ li tương ứng
                console.log(link);

                // Gọi AJAX
                fetch(`/b/upgrade-member-ship/${wmId}`, {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest", // Để Laravel nhận diện đây là AJAX request
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            listItem.querySelector(
                                ".activate-member"
                            ).outerHTML = `
                                <button
                                    class="btn btn-outline-success activate-member"
                                    data-wm-id="${wmId}">
                                    Phó nhóm
                                </button>`;

                            // Cập nhật trạng thái trong <section>
                            const section =
                                listItem.querySelector("section.fs-12");

                            section.innerHTML = `
                                <p style="margin-bottom: 0px;" class="text-black">
                                    ${data.name} <span class="text-success">(Phó nhóm)</span>
                                </p>
                                <span>
                                    @${data.name}
                                </span>
                                <span>-</span>
                                <span>Phó nhóm của không gian làm việc</span>
                            `;

                            notificationWeb(data.action, data.msg);
                            // location.reload();
                        }
                    });
            });
        });
});

//duyệt thành viên vào bảng
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn.btn-primary.me-2").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định
            const targetUl = document.getElementById("tab-board-ul-1"); // Lấy thẻ ul đích (tab-ul-3)

            const form = this.closest("form"); // Lấy form chứa nút bấm
            const wmId = form.querySelector("input[name='user_id']").value; // Lấy user_id từ form
            const wsmId = form.querySelector("input[name='bm_id']").value; // Lấy user_id từ form

            const workspaceId = form.querySelector(
                "input[name='board_id']"
            ).value; // Lấy workspace_id từ form
            // const count = document.getElementById("tab_board_2");
            // const so = count.innerText - 1;
            const link = `li_board_${wsmId}`;
            const listItem = document.getElementById(link);

            const count1 = document.getElementById("tab_board_1"); // Lấy element
            const countString = count1.textContent || count1.innerText; // Lấy nội dung dưới dạng chuỗi
            const countInt = parseInt(countString, 10);

            const so1 = countInt + 1;
            const count2 = document.getElementById("tab_board_2");
            const so2 = count2.innerText - 1;
            // Gọi AJAX
            fetch(`/b/accept-member`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    user_id: wmId,
                    board_id: workspaceId,
                    bm_id: wsmId,
                }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP status ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        const newListItem = document.createElement("li");
                        newListItem.className =
                            "d-flex justify-content-between mt-2";
                        newListItem.id = `li_board_${wsmId}`;
                        newListItem.innerHTML = `
                        <div class="d-flex">
                           <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="${
                               data.name
                           }">
                                ${
                                    data.image
                                        ? `<img src="${data.image}" alt="" class="rounded-circle avatar-xs" />`
                                        : `<div class="bg-info-subtle rounded d-flex justify-content-center align-items-center" style="width: 25px;height: 25px">
                                            ${data.name[0].toUpperCase()}
                                        </div>`
                                }
                            </a>
                            <div class="ms-3 d-flex flex-column">
                                <section class="fs-12">
                                    <p style="margin-bottom: 0px;" class="text-black">
                                        ${data.name}
                                            <span class="text-black">(Thành
                                                viên)</span>
                                    </p>
                                    <span>@${data.name}</span>
                                    <span>-</span>
                                    <span>Thành viên của bảng</span>
                                </section>
                            </div>
                        </div>


                        <div class=" d-flex align-items-center justify-content-end">
                            <button class="btn btn-outline-primary activate-member">Thành
                                viên
                            </button>
                            <div class="dropdown ms-2">
                                <i class="ri-more-2-fill cursor-pointer" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false"></i>

                                    <ul class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton">
                                        <li>
                                             <a class="dropdown-item text-primary"
                                                href="http://127.0.0.1:8000/b/management-franchise/${
                                                    data.owner_id
                                                }/${wsmId}">Nhượng
                                                quyền</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-primary"
                                                href="http://127.0.0.1:8000/b/upgrade-member-ship/${wsmId}">Thăng
                                                cấp
                                                thành
                                                viên</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger"
                                                href="http://127.0.0.1:8000/b/activate-member/${wsmId}">Kích
                                                thành
                                                viên</a>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                        `;
                        targetUl.appendChild(newListItem);
                        listItem.remove();
                        notificationWeb(data.action, data.msg);
                        count1.innerHTML = so1;
                        count2.innerHTML = so2;
                    } else {
                        alert(data.msg || "Có lỗi xảy ra!");
                    }
                });
        });
    });
});

//từ chối thành viên vào bảng
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn.btn-danger").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của nút bấm

            const form = this.closest("form"); // Lấy form chứa nút bấm
            const wsmId = form.action.split("/").pop(); // Lấy `wsm_id` từ URL của form
            const listItem = document.getElementById(`li_board_${wsmId}`); // Phần tử danh sách tương ứng
            const countElement = document.getElementById("tab_board_2"); // Phần tử hiển thị số lượng

            // Gọi AJAX
            fetch(form.action, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP status ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Xóa phần tử danh sách
                        listItem?.remove();

                        // Giảm số lượng trong tab_2
                        if (countElement) {
                            const newCount =
                                parseInt(countElement.innerText, 10) - 1;
                            countElement.innerText =
                                newCount >= 0 ? newCount : 0;
                        }

                        // Hiển thị thông báo
                        notificationWeb(data.action, data.msg);
                    } else {
                        alert(data.msg || "Có lỗi xảy ra!");
                    }
                })
                .catch((error) => {
                    console.error("Fetch failed:", error); // Log lỗi
                    alert(`Lỗi: ${error.message}`);
                });
        });
    });
});
