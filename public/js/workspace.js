//  update thông tin workspace
$(document).ready(function () {
    $("#editWorkspaceForm").on("submit", function (e) {
        e.preventDefault(); // Ngăn chặn hành vi submit mặc định

        $("#loading").show(); // Hiển thị loading
        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr("action"), // URL từ action của form
            method: $(this).attr("method"), // Phương thức từ form
            data: formData,
            processData: false, // Không xử lý dữ liệu
            contentType: false, // Không đặt kiểu content mặc định
            success: function (response) {
                notificationWeb(response.action, response.message);
                console.log("cật nhật thành công");
            },
            error: function (xhr) {
                $("#loading").hide(); // Ẩn loading

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = "";
                    $.each(errors, function (key, value) {
                        errorMessages +=
                            '<div class="alert alert-danger">' +
                            value[0] +
                            "</div>";
                    });
                    $("#formResponse").html(errorMessages);
                } else {
                    $("#formResponse").html(
                        '<div class="alert alert-danger">Có lỗi xảy ra!</div>'
                    );
                }
            },
        });
    });
});

//update quyền của workspace
$(document).ready(function () {
    $("#updateAccessForm").on("submit", function (e) {
        e.preventDefault(); // Ngăn chặn hành vi submit mặc định

        $("#loading").show(); // Hiển thị loading
        $("#formResponse").html(""); // Xóa các thông báo cũ

        let formData = $(this).serialize(); // Lấy dữ liệu từ form

        $.ajax({
            url: $(this).attr("action"), // Lấy URL từ form
            method: $(this).attr("method"), // Lấy method từ form
            data: formData,

            success: function (response) {
                // $('#formResponse').html('<div class="alert alert-success">' + response.message + '</div>');
                notificationWeb(response.action, response.message);
                document.getElementById("access").innerText = "Riêng tư";
                setTimeout(function () {
                    $("#formResponse").html("");
                }, 3000);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = "";
                    $.each(errors, function (key, value) {
                        errorMessages +=
                            '<div class="alert alert-danger">' +
                            value[0] +
                            "</div>";
                    });
                    notificationWeb(response.action, response.message);
                } else {
                    // $('#formResponse').html('<div class="alert alert-danger">Có lỗi xảy ra: ' + xhr.responseJSON.message + '</div>');
                    notificationWeb(response.action, response.message);
                }
            },
        });
    });
});

//kick thành viên
document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên các nút kích thành viên
    document
        .querySelectorAll(".dropdown-item.text-danger")
        .forEach((button) => {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                // const wmId = this.getAttribute("data-wm-id"); // Lấy wm_id từ thuộc tính data
                const wmId = this.getAttribute("href").split("/").pop();
                const listItem = document.getElementById(`li_${wmId}`); // Tìm thẻ li tương ứng
                const targetUl = document.getElementById("tab-ul-3"); // Lấy thẻ ul đích (tab-ul-3)
                const count3 = document.getElementById("tab_3"); // Lấy element
                const countString = count3.textContent || count3.innerText; // Lấy nội dung dưới dạng chuỗi
                const countInt = parseInt(countString, 10);

                const so3 = countInt + 1;
                const count1 = document.getElementById("tab_1");
                const so1 = count1.innerText - 1;

                // Gọi AJAX
                fetch(`/workspace/activate-member/${wmId}`, {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest", // Để Laravel nhận diện đây là AJAX request
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Tạo một thẻ <li> mới với giao diện của tab-ul-3
                            const newListItem = document.createElement("li");
                            newListItem.className =
                                "d-flex justify-content-between";
                            newListItem.id = `li_${wmId}`;
                            newListItem.innerHTML = `
                            <div class="col-1">
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
                            </div>
                            <div class="col-7 d-flex flex-column">
                                <section class="fs-12">
                                    <p style="margin-bottom: 0px;" class="text-black">
                                        ${data.name}
                                        <span class="text-black">(Người xem)</span>
                                    </p>
                                    <span>@${data.name}</span>
                                    <span><i class="ri-checkbox-blank-circle-fill"></i></span>
                                    <span>Tham quan không gian làm việc</span>
                                </section>
                            </div>
                            <div class="col-4 d-flex justify-content-end">
                                <i class="ri-more-2-fill cursor-pointer ml-4" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item text-primary" href="http://127.0.0.1:8000/workspace/add-guest/${wmId}">Thêm người dùng</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="http://127.0.0.1:8000/workspace/delete-guest/${wmId}">Loại</a>
                                    </li>
                                </ul>
                            </div>
                        `;

                            // Thêm thẻ li mới vào tab-ul-3
                            targetUl.appendChild(newListItem);

                            // Xóa thẻ li khỏi tab-ul-1
                            listItem.remove();
                            count1.innerHTML = so1;
                            count3.innerHTML = so3;
                            // Hiển thị thông báo thành công
                            notificationWeb(data.action, data.msg);
                            // location.reload();
                        } else {
                            alert("Không thể thực hiện yêu cầu!");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Không thể thực hiện yêu cầu!");
                    });
            });
        });
});

//thăng cấp thành viên
document.querySelectorAll(".upgrade-member").forEach((item) => {
    item.addEventListener("click", function () {
        const wmId = this.dataset.wmId; // Lấy wm_id từ thẻ a

        fetch(`/workspace/upgrade-member-ship/${wmId}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest", // Đánh dấu request là AJAX
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    notificationWeb(data.action, data.message);
                    // Tìm thẻ li chứa nút được bấm
                    const listItem = document.getElementById(`li_${wmId}`);
                    // Cập nhật nút mới
                    listItem.querySelector(".activate-member").outerHTML = `
                    <button
                        class="btn btn-outline-success activate-member">
                        Phó nhóm
                    </button>`;

                    // Cập nhật trạng thái trong <section>
                    const section = listItem.querySelector("section.fs-12");

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
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Không thể thực hiện yêu cầu!");
            });
    });
});

//thêm khách làm thành viên
document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên tất cả các thẻ <a> có class "dropdown-item text-danger"
    document.querySelectorAll(".dropdown-item.text-primary").forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định (chuyển trang)

            const wmId = this.getAttribute("href").split("/").pop(); // Lấy wm_id từ URL

            const listItem = document.getElementById(`li_${wmId}`); // Lấy thẻ li tương ứng
            const count1 = document.getElementById("tab_1"); // Lấy element
            const countString = count1.textContent || count1.innerText; // Lấy nội dung dưới dạng chuỗi
            const countInt = parseInt(countString, 10);

            const so1 = countInt + 1;
            const count3 = document.getElementById("tab_3");
            const so3 = count3.innerText - 1;

            const targetUl = document.getElementById("tab-ul-1");

            // Gọi AJAX
            fetch(`/workspace/add-guest/${wmId}`, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest", // Để Laravel nhận diện đây là AJAX request
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const newListItem = document.createElement("li");
                        newListItem.className =
                            "d-flex justify-content-between mt-2";
                        newListItem.id = `li_${wmId}`;
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
                                    <span>Thành viên của không gian làm việc</span>
                                </section>
                            </div>
                            </div>

                            <div
                                class=" d-flex align-items-center justify-content-end">
                                <button
                                    class="btn btn-outline-primary activate-member">
                                    Thành
                                    viên
                                </button>
                                <!-- Nút ba chấm -->
                                <div class="dropdown ms-2">
                                    <i class="ri-more-2-fill cursor-pointer"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"></i>
                                    <!-- Popup xuất hiện khi nhấn nút ba chấm -->

                                    <ul class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton">
                                        <li>
                                           <a class="dropdown-item text-primary"
                                                href="http://127.0.0.1:8000/workspace/management-franchise/${
                                                    data.owner_id
                                                }/${wmId}">Nhượng
                                                quyền</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-primary upgrade-member"
                                                data-wm-id="${wmId}"
                                                href="javascript:void(0);">
                                                Thăng cấp thành viên
                                            </a>
                                        </li>
                                        <li>
                                             <a class="dropdown-item text-danger"
                                                href="http://127.0.0.1:8000/workspace/activate-member/${wmId}">Kích
                                                thành
                                                viên</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        `;

                        targetUl.appendChild(newListItem);

                        listItem.remove();
                        // Hiển thị thông báo nếu cần
                        notificationWeb(data.action, data.msg);
                        count3.innerHTML = so3;
                        count1.innerHTML = so1;
                        // location.reload();
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Không thể thực hiện yêu cầu!");
                });
        });
    });
});

//duyệt thành viên vào wsp
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn.btn-primary.me-2").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định

            const form = this.closest("form"); // Lấy form chứa nút bấm
            const wmId = form.querySelector("input[name='user_id']").value; // Lấy user_id từ form
            const wsmId = form.querySelector("input[name='wsm_id']").value; // Lấy user_id từ form
            const workspaceId = form.querySelector(
                "input[name='workspace_id']"
            ).value; // Lấy workspace_id từ form
            // const count = document.getElementById("tab_2");
            // const so = count.innerText - 1;

            const count1 = document.getElementById("tab_1"); // Lấy element
            const countString = count1.textContent || count1.innerText; // Lấy nội dung dưới dạng chuỗi
            const countInt = parseInt(countString, 10);

            const so1 = countInt + 1;
            const count2 = document.getElementById("tab_2");
            const so2 = count2.innerText - 1;

            const listItem = document.getElementById(`li_${wsmId}`);
            const targetUl = document.getElementById("tab-ul-1");

            // Gọi AJAX
            fetch(`/workspace/accept-member`, {
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
                    workspace_id: workspaceId,
                    wsm_id: wsmId,
                }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP status ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log(data); // Debug phản hồi
                    if (data.success) {
                        const newListItem = document.createElement("li");
                        newListItem.className =
                            "d-flex justify-content-between mt-2";
                        newListItem.id = `li_${wmId}`;
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
                                    <span>Thành viên của không gian làm việc</span>
                                </section>
                            </div>
                            </div>

                            <div
                                class=" d-flex align-items-center justify-content-end">
                                <button
                                    class="btn btn-outline-primary activate-member">
                                    Thành
                                    viên
                                </button>
                                <!-- Nút ba chấm -->
                                <div class="dropdown ms-2">
                                    <i class="ri-more-2-fill cursor-pointer"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"></i>
                                    <!-- Popup xuất hiện khi nhấn nút ba chấm -->

                                    <ul class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton">
                                        <li>
                                           <a class="dropdown-item text-primary"
                                                href="http://127.0.0.1:8000/workspace/management-franchise/${
                                                    data.owner_id
                                                }/${wmId}">Nhượng
                                                quyền</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-primary upgrade-member"
                                                data-wm-id="${wmId}"
                                                href="javascript:void(0);">
                                                Thăng cấp thành viên
                                            </a>
                                        </li>
                                        <li>
                                             <a class="dropdown-item text-danger"
                                                href="http://127.0.0.1:8000/workspace/activate-member/${wmId}">Kích
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
                        // location.reload();
                    } else {
                        alert(data.msg || "Có lỗi xảy ra!");
                    }
                })
                .catch((error) => {
                    console.error("Fetch failed:", error); // Hiển thị lỗi rõ ràng
                    alert(`Lỗi: ${error.message}`);
                });
        });
    });
});

//từ chối lời mời vào wsp
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn.btn-danger").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của nút bấm

            const form = this.closest("form"); // Lấy form chứa nút bấm
            const wsmId = form.action.split("/").pop(); // Lấy `wsm_id` từ URL của form
            const listItem = document.getElementById(`li_${wsmId}`); // Phần tử danh sách tương ứng
            const countElement = document.getElementById("tab_2"); // Phần tử hiển thị số lượng

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

//loại người dùng khỏi không gian làm việc
document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên các nút kích thành viên
    document
        .querySelectorAll(".dropdown-item.text-warning")
        .forEach((button) => {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                // const wmId = this.getAttribute("data-wm-id"); // Lấy wm_id từ thuộc tính data
                const wmId = this.getAttribute("href").split("/").pop();
                const listItem = document.getElementById(`li_${wmId}`); // Tìm thẻ li tương ứng
                const count1 = document.getElementById("tab_3");
                const so1 = count1.innerText - 1;

                // Gọi AJAX
                fetch(`/workspace/delete-guest/${wmId}`, {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest", // Để Laravel nhận diện đây là AJAX request
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Tạo một thẻ <li> mới với giao diện của tab-ul-3

                            // Xóa thẻ li khỏi tab-ul-1
                            listItem.remove();
                            count1.innerHTML = so1;
                            // Hiển thị thông báo thành công
                            notificationWeb(data.action, data.msg);
                            // location.reload();
                        } else {
                            alert("Không thể thực hiện yêu cầu!");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Không thể thực hiện yêu cầu!");
                    });
            });
        });
});
