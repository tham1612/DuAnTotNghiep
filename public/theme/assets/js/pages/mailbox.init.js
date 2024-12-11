var url = "http://127.0.0.1:8000/api/inbox/" + userIdmain,
    allmaillist = "";
const loader = document.querySelector("#elmLoader");
var getJSON = function (e, t) {
    var a = new XMLHttpRequest();
    a.open("GET", url + e, !0),
        (a.responseType = "json"),
        (a.onload = function () {
            var e = a.status;
            200 === e
                ? ((document.getElementById("elmLoader").innerHTML = ""),
                  t(null, a.response))
                : t(e, a.response);
        }),
        a.send();
};
// Hàm này dùng để tải và hiển thị dữ liệu email vào danh sách


function loadMailData(emails) {
    // Chuyển đến tab chính trong giao diện
    document
        .querySelector(
            '#mail-filter-navlist button[data-bs-target="#pills-primary"]'
        )
        .click();

    // Xóa nội dung danh sách email hiện tại
    var mailList = document.querySelector("#mail-list");
    mailList.innerHTML = "";

    if (emails.length === 0) {
        // Hiển thị thông báo nếu không có email nào
        mailList.innerHTML = `

                <div class="text-center py-5 mt-3">
                    <h5>Không có thông báo nào hiện có</h5>
                    <p>Bạn sẽ thấy thông báo ở đây khi có thông báo mới.</p>
                </div>

        `;
        return; // Dừng lại nếu không có dữ liệu
    }

    // Duyệt qua từng email trong danh sách
    Array.from(emails).forEach(function (email) {
        var statusClass = email.readed ? "" : "unread";
        var starClass = email.starred ? "active" : "";
        var countedText = email.counted ? "(" + email.counted + ")" : "";

        mailList.innerHTML += `
        <li class="notification-item ${statusClass}" data-id="${email.id}">
            <div class="col-mail col-mail-1">
                <div class="form-check checkbox-wrapper-mail fs-14">
                    <input class="form-check-input" type="checkbox" value="${email.id}" id="checkbox-${email.id}">
                    <label class="form-check-label" for="checkbox-${email.id}"></label>
                </div>
                <button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ${starClass}"></button>
                <a href="javascript: void(0);" class="title">
                    <span class="title-name">${email.name}</span> ${countedText}
                </a>
            </div>
            <div class="col-mail col-mail-2">
                <a href="javascript: void(0);" class="subject" style="padding-top: 13px;">
                    <span class="subject-title">${email.title}</span> – <span class="teaser">${email.description}</span>
                </a>
                <div class="date">${email.date}</div>
            </div>
        </li>`;
    });

    document.querySelectorAll(".notification-item").forEach(function (item) {
        item.addEventListener("click", function () {
            var notificationId = this.getAttribute("data-id");

            $.ajax({
                url: "/api/inbox/read/" + notificationId + "/" + userId,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    if (response.status === "success") {
                        item.classList.remove("unread");
                    }
                },
                error: function (xhr) {
                    console.error("Something went wrong:", xhr.responseText);
                },
            });
        });
    });
}


// Hàm này dùng để tải và hiển thị dữ liệu email xã hội vào danh sách
// function loadSocialMailData(emails) {
//     // Duyệt qua từng email trong danh sách
//     Array.from(emails).forEach(function (email) {
//         // Kiểm tra nếu email đã đọc hay chưa
//         var statusClass = email.readed ? "" : "unread";
//         // Kiểm tra nếu email đã được đánh dấu yêu thích
//         var starClass = email.starred ? "active" : "";
//         // Đếm số lượng nếu có
//         var countedText = email.counted ? "(" + email.counted + ")" : "";

//         // Thêm email vào danh sách xã hội
//         document.getElementById("social-mail-list").innerHTML +=
//             '<li class="' +
//             statusClass +
//             '">' +
//             '<div class="col-mail col-mail-1">' +
//             '<div class="form-check checkbox-wrapper-mail fs-14">' +
//             '<input class="form-check-input" type="checkbox" value="' +
//             email.id +
//             '" id="checkbox-' +
//             email.id +
//             '">' +
//             '<label class="form-check-label" for="checkbox-' +
//             email.id +
//             '"></label>' +
//             "</div>" +
//             '<input type="hidden" value=' +
//             email.userImg +
//             ' class="mail-userimg" />' +
//             '<button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ' +
//             starClass +
//             '">' +
//             '<i class="ri-star-fill"></i>' +
//             "</button>" +
//             '<a href="javascript: void(0);" class="title">' +
//             '<span class="title-name">' +
//             email.name +
//             "</span> " +
//             countedText +
//             "</a>" +
//             "</div>" +
//             '<div class="col-mail col-mail-2">' +
//             '<a href="javascript: void(0);" class="subject">' +
//             '<span class="subject-title">' +
//             email.title +
//             '</span> – <span class="teaser">' +
//             email.description +
//             "</span>" +
//             "</a>" +
//             '<div class="date">' +
//             email.date +
//             "</div>" +
//             "</div>" +
//             "</li>";

//         // Gọi các hàm xử lý khác để cập nhật giao diện
//         emailDetailShow();
//         emailDetailChange();
//         checkBoxAll();
//     });
// }

// Hàm này dùng để tải và hiển thị dữ liệu email khuyến mãi vào danh sách
// function loadPromotionsMailData(emails) {
//     // Duyệt qua từng email trong danh sách
//     Array.from(emails).forEach(function (email) {
//         // Kiểm tra nếu email đã đọc hay chưa
//         var statusClass = email.readed ? "" : "unread";
//         // Kiểm tra nếu email đã được đánh dấu yêu thích
//         var starClass = email.starred ? "active" : "";
//         // Đếm số lượng nếu có
//         var countedText = email.counted ? "(" + email.counted + ")" : "";

//         // Thêm email vào danh sách khuyến mãi
//         document.getElementById("promotions-mail-list").innerHTML +=
//             '<li class="' +
//             statusClass +
//             '">' +
//             '<div class="col-mail col-mail-1">' +
//             '<div class="form-check checkbox-wrapper-mail fs-14">' +
//             '<input class="form-check-input" type="checkbox" value="' +
//             email.id +
//             '" id="checkbox-' +
//             email.id +
//             '">' +
//             '<label class="form-check-label" for="checkbox-' +
//             email.id +
//             '"></label>' +
//             "</div>" +
//             '<input type="hidden" value=' +
//             email.userImg +
//             ' class="mail-userimg" />' +
//             '<button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ' +
//             starClass +
//             '">' +
//             '<i class="ri-star-fill"></i>' +
//             "</button>" +
//             '<a href="javascript: void(0);" class="title">' +
//             '<span class="title-name">' +
//             email.name +
//             "</span> " +
//             countedText +
//             "</a>" +
//             "</div>" +
//             '<div class="col-mail col-mail-2">' +
//             '<a href="javascript: void(0);" class="subject">' +
//             '<span class="subject-title">' +
//             email.title +
//             '</span> – <span class="teaser">' +
//             email.description +
//             "</span>" +
//             "</a>" +
//             '<div class="date">' +
//             email.date +
//             "</div>" +
//             "</div>" +
//             "</li>";

//         // Gọi các hàm xử lý khác để cập nhật giao diện
//         emailDetailShow();
//         emailDetailChange();
//         checkBoxAll();
//     });
// }

// Hàm này dùng để quản lý hành vi của nút đánh dấu yêu thích
function favouriteBtn() {
    // Duyệt qua từng nút yêu thích trong danh sách
    Array.from(document.querySelectorAll(".favourite-btn")).forEach(function (
        button
    ) {
        // Thêm sự kiện click cho nút
        button.addEventListener("click", function () {
            // Kiểm tra nếu nút đã được đánh dấu yêu thích
            if (button.classList.contains("active")) {
                // Nếu có, xóa lớp "active"
                button.classList.remove("active");
            } else {
                // Nếu chưa, thêm lớp "active"
                button.classList.add("active");
            }
        });
    });
}

// Hàm này dùng để quản lý việc hiển thị chi tiết email và các tương tác liên quan
function emailDetailShow() {
    var a = document.getElementsByTagName("body")[0],
        t =
            (Array.from(document.querySelectorAll(".message-list a")).forEach(
                function (e) {
                    e.addEventListener("click", function (t) {
                        a.classList.add("email-detail-show"),
                            Array.from(
                                document.querySelectorAll(
                                    ".message-list li.unread"
                                )
                            ).forEach(function (e) {
                                e.classList.contains("unread") &&
                                    t.target
                                        .closest("li")
                                        .classList.remove("unread");
                            });
                    });
                }
            ),
            Array.from(document.querySelectorAll(".close-btn-email")).forEach(
                function (e) {
                    e.addEventListener("click", function () {
                        a.classList.remove("email-detail-show");
                    });
                }
            ),
            !1),
        l = document.getElementsByClassName("email-menu-sidebar");
    Array.from(document.querySelectorAll(".email-menu-btn")).forEach(function (
        e
    ) {
        e.addEventListener("click", function () {
            Array.from(l).forEach(function (e) {
                e.classList.add("menubar-show"), (t = !0);
            });
        });
    }),
        window.addEventListener("click", function (e) {
            document
                .querySelector(".email-menu-sidebar")
                .classList.contains("menubar-show") &&
                (t ||
                    document
                        .querySelector(".email-menu-sidebar")
                        .classList.remove("menubar-show"),
                (t = !1));
        }),
        favouriteBtn();
}

// Hàm này dùng để quản lý hành vi của các checkbox trong danh sách email
function checkBoxAll() {
    // Thêm sự kiện cho từng checkbox trong danh sách email
    Array.from(
        document.querySelectorAll(".checkbox-wrapper-mail input")
    ).forEach(function (checkbox) {
        checkbox.addEventListener("click", function (event) {
            // Nếu checkbox được chọn, thêm lớp "active" vào li chứa nó
            if (event.target.checked) {
                event.target.closest("li").classList.add("active");
            } else {
                // Nếu không, xóa lớp "active"
                event.target.closest("li").classList.remove("active");
            }
        });
    });

    // Lấy tất cả checkbox trong tab hiện tại
    var checkboxes = document.querySelectorAll(
        ".tab-pane.show .checkbox-wrapper-mail input"
    );

    // Hàm xử lý cho hành vi chọn tất cả checkbox
    function selectAll() {
        var totalCheckboxes = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input"
        );
        var checkedCount = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input:checked"
        ).length;

        // Đánh dấu tất cả checkbox là checked và thêm lớp "active"
        Array.from(totalCheckboxes).forEach(function (checkbox) {
            checkbox.checked = true;
            checkbox.parentNode.parentNode.parentNode.classList.add("active");
        });

        // Hiện hoặc ẩn thanh hành động dựa trên số checkbox được chọn
        document.getElementById("email-topbar-actions").style.display =
            checkedCount > 0 ? "none" : "block";

        // Nếu có checkbox được chọn, bỏ chọn tất cả
        if (checkedCount > 0) {
            Array.from(totalCheckboxes).forEach(function (checkbox) {
                checkbox.checked = false;
                checkbox.parentNode.parentNode.parentNode.classList.remove(
                    "active"
                );
            });
        } else {
            // Nếu không có checkbox nào được chọn, chọn tất cả
            Array.from(totalCheckboxes).forEach(function (checkbox) {
                checkbox.checked = true;
                checkbox.parentNode.parentNode.parentNode.classList.add(
                    "active"
                );
            });
        }

        // Gọi hàm xóa các mục (nếu có)
        removeItems();
    }

    // Hàm xử lý cho hành vi bỏ chọn tất cả checkbox
    function deselectAll() {
        var totalCheckboxes = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input"
        );
        var checkedCount = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input:checked"
        ).length;

        // Bỏ chọn tất cả checkbox và xóa lớp "active"
        Array.from(totalCheckboxes).forEach(function (checkbox) {
            checkbox.checked = false;
            checkbox.parentNode.parentNode.parentNode.classList.remove(
                "active"
            );
        });

        // Hiện hoặc ẩn thanh hành động dựa trên số checkbox được chọn
        document.getElementById("email-topbar-actions").style.display =
            checkedCount > 0 ? "none" : "block";

        // Nếu có checkbox được chọn, bỏ chọn tất cả
        if (checkedCount > 0) {
            Array.from(totalCheckboxes).forEach(function (checkbox) {
                checkbox.checked = false;
                checkbox.parentNode.parentNode.parentNode.classList.remove(
                    "active"
                );
            });
        } else {
            // Nếu không có checkbox nào được chọn, chọn tất cả
            Array.from(totalCheckboxes).forEach(function (checkbox) {
                checkbox.checked = true;
                checkbox.parentNode.parentNode.parentNode.classList.add(
                    "active"
                );
            });
        }
    }

    // Thêm sự kiện cho mỗi checkbox trong danh sách để theo dõi trạng thái chọn
    Array.from(checkboxes).forEach(function (checkbox) {
        checkbox.addEventListener("click", function (event) {
            var totalCheckboxes = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input"
            );
            var selectAllCheckbox = document.getElementById("checkall");
            var checkedCount = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input:checked"
            ).length;

            // Cập nhật trạng thái cho checkbox chọn tất cả
            selectAllCheckbox.checked = checkedCount > 0;
            selectAllCheckbox.indeterminate =
                checkedCount > 0 && checkedCount < totalCheckboxes.length;

            // Hiện hoặc ẩn thanh hành động dựa trên số checkbox được chọn
            document.getElementById("email-topbar-actions").style.display =
                checkedCount > 0 ? "block" : "none";
        });
    });

    // Thêm sự kiện cho checkbox chọn tất cả
    document.getElementById("checkall").onclick = selectAll;
}

// Tải dữ liệu từ file JSON và xử lý kết quả
getJSON("mail-list.init.json", function (error, data) {
    // Kiểm tra xem có lỗi xảy ra không
    if (error !== null) {
        console.log("Something went wrong: " + error);
    } else {
        // Gán dữ liệu cho các biến tương ứng
        allmaillist = data[0].primary;
        socialmaillist = data[0].social;
        promotionsmaillist = data[0].promotions;

        // Gọi các hàm để hiển thị danh sách email
        loadMailData(allmaillist);
        // loadSocialMailData(socialmaillist);
        // loadPromotionsMailData(promotionsmaillist);
    }
});

// Thêm sự kiện click cho từng liên kết trong danh sách email
Array.from(document.querySelectorAll(".mail-list a")).forEach(function (link) {
    link.addEventListener("click", function () {
        var activeLink = document.querySelector(".mail-list a.active");

        // Xóa lớp "active" khỏi liên kết đang hoạt động (nếu có)
        if (activeLink) {
            activeLink.classList.remove("active");
        }

        // Thêm lớp "active" cho liên kết hiện tại
        link.classList.add("active");

        var labelType, filteredEmails;

        // Kiểm tra xem liên kết có thuộc loại nào không
        if (link.querySelector(".mail-list-link").hasAttribute("data-type")) {
            labelType = link.querySelector(".mail-list-link").innerHTML;
            filteredEmails = allmaillist.filter(
                (email) => email.labeltype === labelType
            );
        } else {
            labelType = link.querySelector(".mail-list-link").innerHTML;
            document.getElementById("mail-list").innerHTML = ""; // Xóa danh sách email hiện tại

            // Lọc danh sách email theo loại tab
            filteredEmails =
                labelType !== "All"
                    ? allmaillist.filter((email) => email.tabtype === labelType)
                    : allmaillist;

            // Hiển thị hoặc ẩn thanh điều hướng dựa trên loại tab
            document.getElementById("mail-filter-navlist").style.display =
                labelType !== "All" && labelType !== "Inbox" ? "none" : "block";
        }

        // Gọi hàm để tải dữ liệu email
        loadMailData(filteredEmails);
        favouriteBtn(); // Cập nhật nút yêu thích
    });
});

// Gọi hàm favouriteBtn() để thiết lập hành vi cho các nút yêu thích
favouriteBtn();

// Khởi tạo trình soạn thảo email
// ClassicEditor.create(document.querySelector("#email-editor"))
//     .then(function (editor) {
//         // Đặt chiều cao cho vùng chỉnh sửa
//         editor.ui.view.editable.element.style.height = "200px";
//     })
//     .catch(function (error) {
//         console.error(error); // Log lỗi nếu có
//     });

// var currentChatId = "users-chat";

// Hàm cuộn xuống dưới trong cuộc hội thoại chat
// function scrollToBottom(event) {
//     // Đặt thời gian chờ 100ms trước khi thực hiện cuộn
//     setTimeout(() => {
//         // Lấy phần tử cuộn và thiết lập vị trí cuộn đến đáy
//         new SimpleBar(
//             document.getElementById("chat-conversation")
//         ).getScrollElement().scrollTop =
//             document.getElementById("users-conversation").scrollHeight;
//     }, 100);
// }

// Hàm để xử lý việc xóa các mục trong danh sách email
// function removeItems() {
//     // Thêm sự kiện cho modal xóa khi hiển thị
//     document
//         .getElementById("removeItemModal")
//         .addEventListener("show.bs.modal", function (event) {
//             // Thêm sự kiện cho nút xóa trong modal
//             document
//                 .getElementById("delete-record")
//                 .addEventListener("click", function () {
//                     // Duyệt qua từng mục trong danh sách tin nhắn
//                     Array.from(
//                         document.querySelectorAll(".message-list li")
//                     ).forEach(function (item) {
//                         var itemId;

//                         // Kiểm tra nếu mục đang ở trạng thái "active"
//                         if (item.classList.contains("active")) {
//                             // Lấy giá trị ID của mục
//                             itemId =
//                                 item.querySelector(".form-check-input").value;

//                             // Cập nhật danh sách email bằng cách loại bỏ mục đã chọn
//                             allmaillist = allmaillist.filter(function (email) {
//                                 return email.id != itemId;
//                             });

//                             // Xóa mục khỏi DOM
//                             item.remove();
//                         }
//                     });

//                     // Đóng modal sau khi xóa
//                     document.getElementById("btn-close").click();

//                     // Ẩn thanh hành động nếu cần
//                     if (document.getElementById("email-topbar-actions")) {
//                         document.getElementById(
//                             "email-topbar-actions"
//                         ).style.display = "none";
//                     }

//                     // Đặt trạng thái checkbox "check all" về không chọn
//                     checkall.indeterminate = false;
//                     checkall.checked = false;
//                 });
//         });
// }

// Hàm để xử lý việc xóa một mục email đơn lẻ
function removeSingleItem() {
    var itemId;

    // Duyệt qua tất cả các nút xóa email
    document.querySelectorAll(".remove-mail").forEach(function (button) {
        // Thêm sự kiện cho mỗi nút xóa
        button.addEventListener("click", function (event) {
            // Lấy ID của mục cần xóa từ thuộc tính data
            itemId = button.getAttribute("data-remove-id");

            // Thêm sự kiện cho nút xác nhận xóa
            document
                .getElementById("delete-record")
                .addEventListener("click", function () {
                    // Lọc danh sách email để loại bỏ mục có ID trùng khớp
                    allmaillist = allmaillist.filter(function (email) {
                        return email.id != itemId;
                    });

                    // Tải lại danh sách email để cập nhật giao diện
                    loadMailData(allmaillist);

                    // Đóng modal hoặc giao diện sau khi xóa
                    document.getElementById("close-btn-email").click();
                });
        });
    });
}

// scrollToBottom(currentChatId), removeItems(), removeSingleItem();
// var markAllReadBtn = document.getElementById("mark-all-read"),
//     dummyUserImage =
//         (markAllReadBtn.addEventListener("click", function (e) {
//             0 === document.querySelectorAll(".message-list li.unread").length &&
//                 ((document.getElementById("unreadConversations").style.display =
//                     "block"),
//                 setTimeout(function () {
//                     document.getElementById(
//                         "unreadConversations"
//                     ).style.display = "none";
//                 }, 1e3)),
//                 Array.from(
//                     document.querySelectorAll(".message-list li.unread")
//                 ).forEach(function (e) {
//                     e.classList.contains("unread") &&
//                         e.classList.remove("unread");
//                 });
//         }),
//         "assets/images/users/user-dummy-img.jpg"),
//     mailChatDetailElm = !1;

// function emailDetailChange() {
//     Array.from(document.querySelectorAll(".message-list li")).forEach(function (
//         c
//     ) {
//         c.addEventListener("click", function () {
//             var e = c.querySelector(
//                     ".checkbox-wrapper-mail .form-check-input"
//                 ).value,
//                 e =
//                     (document
//                         .querySelector(".remove-mail")
//                         .setAttribute("data-remove-id", e),
//                     c.querySelector(".subject-title").innerHTML),
//                 a =
//                     ((document.querySelector(".email-subject-title").innerHTML =
//                         e),
//                     c.querySelector(".title-name").innerHTML),
//                 t =
//                     (Array.from(
//                         document.querySelectorAll(".accordion-item.left")
//                     ).forEach(function (e) {
//                         e.querySelector(".email-user-name").innerHTML = a;
//                         var t = c.querySelector(".mail-userimg").value;
//                         e.querySelector("img").setAttribute("src", t);
//                     }),
//                     document.querySelector(".user-name-text").innerHTML),
//                 l = document
//                     .querySelector(".header-profile-user")
//                     .getAttribute("src");
//             Array.from(
//                 document.querySelectorAll(".accordion-item.right")
//             ).forEach(function (e) {
//                 (e.querySelector(".email-user-name-right").innerHTML = t),
//                     e.querySelector("img").setAttribute("src", l);
//             });
//         });
//     });
// }
// document.querySelectorAll(".email-chat-list a").forEach(function (l) {
//     var e, t;
//     l.classList.contains("active") &&
//         ((document.getElementById("emailchat-detailElem").style.display =
//             "block"),
//         (e = document
//             .querySelector(".email-chat-list a.active")
//             .querySelector(".chatlist-user-name").innerHTML),
//         (t = document
//             .querySelector(".email-chat-list a.active")
//             .querySelector(".chatlist-user-image img")
//             .getAttribute("src")),
//         (document.querySelector(
//             ".email-chat-detail .profile-username"
//         ).innerHTML = e),
//         document
//             .getElementById("users-conversation")
//             .querySelectorAll(".left .chat-avatar")
//             .forEach(function (e) {
//                 t
//                     ? e.querySelector("img").setAttribute("src", t)
//                     : e
//                           .querySelector("img")
//                           .setAttribute("src", dummyUserImage);
//             })),
//         l.addEventListener("click", function (e) {
//             (document.getElementById("emailchat-detailElem").style.display =
//                 "block"),
//                 (mailChatDetailElm = !0);
//             var t = document.querySelector(".email-chat-list a.active"),
//                 t =
//                     (t && t.classList.remove("active"),
//                     this.classList.add("active"),
//                     scrollToBottom("users-chat"),
//                     l.querySelector(".chatlist-user-name").innerHTML),
//                 a = l
//                     .querySelector(".chatlist-user-image img")
//                     .getAttribute("src"),
//                 t =
//                     ((document.querySelector(
//                         ".email-chat-detail .profile-username"
//                     ).innerHTML = t),
//                     document.getElementById("users-conversation"));
//             Array.from(t.querySelectorAll(".left .chat-avatar")).forEach(
//                 function (e) {
//                     a
//                         ? e.querySelector("img").setAttribute("src", a)
//                         : e
//                               .querySelector("img")
//                               .setAttribute("src", dummyUserImage);
//                 }
//             );
//         });
// }),
//     document
//         .getElementById("emailchat-btn-close")
//         .addEventListener("click", function () {
//             (document.getElementById("emailchat-detailElem").style.display =
//                 "none"),
//                 (mailChatDetailElm = !1),
//                 document
//                     .querySelector(".email-chat-list a.active")
//                     .classList.remove("active");
//         });
// const triggerTabList = document.querySelectorAll(
//     "#mail-filter-navlist .nav-tabs button"
// );
// function resizeEvent() {
//     var e;
//     document.documentElement.clientWidth < 767 &&
//         ((e = document.querySelector(".email-chat-list a.active")) &&
//             e.classList.remove("active"),
//         (document.getElementById("emailchat-detailElem").style.display =
//             "none"));
// }
// triggerTabList.forEach((e) => {
//     const t = new bootstrap.Tab(e);
//     e.addEventListener("click", (e) => {
//         e.preventDefault();
//         document.querySelector(".tab-content .tab-pane.show");
//         t.show();
//     });
// }),
//     resizeEvent(),
//     (window.onresize = resizeEvent);
