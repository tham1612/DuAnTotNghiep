var url = "http://127.0.0.1:8000/theme/assets/json/", // Đường dẫn đến thư mục chứa tệp JSON
    allmaillist = ""; // Biến để lưu danh sách email (ban đầu là một chuỗi rỗng)

const loader = document.querySelector("#elmLoader"); // Lấy phần tử HTML có ID là "elmLoader" để hiển thị trạng thái tải

// Hàm getJSON để tải tệp JSON từ máy chủ
var getJSON = function (filename, callback) {
    var a = new XMLHttpRequest(); // Tạo một đối tượng XMLHttpRequest để thực hiện yêu cầu AJAX
    a.open("GET", url + filename, true); // Mở yêu cầu GET đến đường dẫn chứa tệp JSON
    a.responseType = "json"; // Đặt kiểu phản hồi là JSON

    // Xử lý phản hồi khi yêu cầu hoàn tất
    a.onload = function () {
        var status = a.status; // Lấy mã trạng thái từ phản hồi
        if (status === 200) {
            // Nếu mã trạng thái là 200 (OK)
            document.getElementById("elmLoader").innerHTML = ""; // Xóa nội dung của loader
            callback(null, a.response); // Gọi hàm callback với thông tin phản hồi
        } else {
            callback(status, a.response); // Gọi hàm callback với lỗi nếu mã trạng thái không phải 200
        }
    };

    a.send(); // Gửi yêu cầu
};

// Lấy tất cả data importain
function loadMailData(e) {
    // Nhấp vào nút để kích hoạt tab có id là "pills-primary"
    document
        .querySelector(
            '#mail-filter-navlist button[data-bs-target="#pills-primary"]'
        )
        .click();

    // Xóa nội dung hiện tại của phần tử có id là "mail-list"
    document.querySelector("#mail-list").innerHTML = "";

    // Chuyển đổi đối tượng e thành mảng và lặp qua từng phần tử của mảng
    Array.from(e).forEach(function (email, index) {
        // Xác định trạng thái của email (đọc hay chưa đọc)
        var unreadClass = email.readed ? "" : "unread";

        // Xác định trạng thái của email (được đánh dấu sao hay không)
        var starredClass = email.starred ? "active" : "";

        // Tạo chuỗi thông tin số lượng email (nếu có)
        var countInfo = email.counted ? `(${email.counted})` : "";

        // Cập nhật nội dung của phần tử HTML có id là "mail-list"
        document.querySelector("#mail-list").innerHTML += `
            <li class="${unreadClass}">
                <div class="col-mail col-mail-1">
                    <div class="form-check checkbox-wrapper-mail fs-14">
                        <input class="form-check-input" type="checkbox" value="${email.id}" id="checkbox-${email.id}">
                        <label class="form-check-label" for="checkbox-${email.id}"></label>
                    </div>
                    <input type="hidden" value="${email.userImg}" class="mail-userimg" />
                    <button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ${starredClass}">
                        <i class="ri-star-fill"></i>
                    </button>
                    <a href="javascript: void(0);" class="title">
                        <span class="title-name">${email.name} ${countInfo}</span>
                    </a>
                </div>
                <div class="col-mail col-mail-2">
                    <a href="javascript: void(0);" class="subject">
                        <span class="subject-title">${email.title}</span> –
                        <span class="teaser">${email.description}</span>
                    </a>
                    <div class="date">${email.date}</div>
                    <div class="assign" style="display: none;">${email.assign}</div>
                    <div class="status" style="display: none;">${email.status_task}</div>
                    <div class="date_t" style="display: none;">${email.date_task}</div>
                    <div class="priority_task" style="display: none;">${email.priority}</div>
                    <div class="time_estimate_task" style="display: none;">${email.time_estimate}</div>
                    <div class="track_time_task" style="display: none;">${email.track_time}</div>
                    <div class="tag" style="display: none;">${email.tag}</div>
                </div>
            </li>
        `;

        // Gọi các hàm khác để xử lý thêm
        favouriteBtn();
        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
}
function loadSocialMailData(e) {
    // Chuyển đổi đối tượng e thành một mảng và lặp qua từng phần tử của mảng
    Array.from(e).forEach(function (email, index) {
        // Xác định trạng thái của email (đọc hay chưa đọc)
        var unreadClass = email.readed ? "" : "unread";

        // Xác định trạng thái của email (được đánh dấu sao hay không)
        var starredClass = email.starred ? "active" : "";

        // Tạo chuỗi thông tin số lượng email (nếu có)
        var countInfo = email.counted ? `(${email.counted})` : "";

        // Cập nhật nội dung của phần tử HTML có id là "social-mail-list"
        document.getElementById("social-mail-list").innerHTML += `
            <div class="social-mail-item ${unreadClass}">
                <div class="mail-status ${starredClass}"></div>
                <div class="mail-info">
                    <span class="mail-name">${email.name} ${countInfo}</span>
                    <span class="mail-title">${email.title}</span>
                    <span class="mail-description"> – ${email.description}</span>
                    <span class="mail-date">${email.date}</span>
                </div>
            </div>
        `;

        // Gọi các hàm khác để xử lý thêm
        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
}

function loadPromotionsMailData(e) {
    Array.from(e).forEach(function (email, index) {
        // Xác định trạng thái của email (đọc hay chưa đọc)
        var unreadClass = email.readed ? "" : "unread";

        // Xác định trạng thái của email (được đánh dấu sao hay không)
        var starredClass = email.starred ? "active" : "";

        // Tạo chuỗi thông tin số lượng email (nếu có)
        var countInfo = email.counted ? `(${email.counted})` : "";

        // Cập nhật nội dung của phần tử HTML có id là "promotions-mail-list"
        document.getElementById("promotions-mail-list").innerHTML += `
            <li class="${unreadClass}">
                <div class="col-mail col-mail-1">
                    <div class="form-check checkbox-wrapper-mail fs-14">
                        <input class="form-check-input" type="checkbox" value="${email.id}" id="checkbox-${email.id}">
                        <label class="form-check-label" for="checkbox-${email.id}"></label>
                    </div>
                    <input type="hidden" value="${email.userImg}" class="mail-userimg" />
                    <button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ${starredClass}">
                        <i class="ri-star-fill"></i>
                    </button>
                    <a href="javascript: void(0);" class="title">
                        <span class="title-name">${email.name}</span> ${countInfo}
                    </a>
                </div>
                <div class="col-mail col-mail-2">
                    <a href="javascript: void(0);" class="subject">
                        <span class="subject-title">${email.title}</span> –
                        <span class="teaser">${email.description}</span>
                    </a>
                    <div class="date">${email.date}</div>
                </div>
            </li>
        `;

        // Gọi các hàm khác để xử lý thêm
        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
}

//đánh dấu sao yêu thích
function favouriteBtn() {
    Array.from(document.querySelectorAll(".favourite-btn")).forEach(function (
        e
    ) {
        e.addEventListener("click", function () {
            e.classList.contains("active")
                ? e.classList.remove("active")
                : e.classList.add("active");
        });
    });
}

function emailDetailShow() {
    // Lấy phần tử <body>
    var body = document.getElementsByTagName("body")[0];

    // Khởi tạo biến để theo dõi trạng thái của menu
    var isMenuVisible =
        // Gán sự kiện click cho tất cả các liên kết trong danh sách tin nhắn
        (Array.from(document.querySelectorAll(".message-list a")).forEach(
            function (link) {
                link.addEventListener("click", function (event) {
                    // Thêm lớp 'email-detail-show' vào <body> để hiển thị chi tiết email
                    body.classList.add("email-detail-show");

                    // Đánh dấu email là đã đọc bằng cách xóa lớp 'unread'
                    Array.from(
                        document.querySelectorAll(".message-list li.unread")
                    ).forEach(function (item) {
                        if (item.classList.contains("unread")) {
                            item.classList.remove("unread");
                        }
                    });
                });
            }
        ),
        // Gán sự kiện click cho tất cả các nút đóng email
        Array.from(document.querySelectorAll(".close-btn-email")).forEach(
            function (closeButton) {
                closeButton.addEventListener("click", function () {
                    // Xóa lớp 'email-detail-show' khi nút đóng được nhấn
                    body.classList.remove("email-detail-show");
                });
            }
        ),
        false); // Giá trị mặc định

    // Lấy tất cả các phần tử menu bên
    var menuSidebar = document.getElementsByClassName("email-menu-sidebar");

    // Gán sự kiện click cho tất cả các nút menu email
    Array.from(document.querySelectorAll(".email-menu-btn")).forEach(function (
        menuButton
    ) {
        menuButton.addEventListener("click", function () {
            // Hiển thị menu bên
            Array.from(menuSidebar).forEach(function (menu) {
                menu.classList.add("menubar-show");
                isMenuVisible = true; // Đánh dấu menu là đang hiển thị
            });
        });
    });

    // Gán sự kiện click cho toàn bộ cửa sổ
    window.addEventListener("click", function (event) {
        // Kiểm tra nếu menu bên đang hiển thị
        if (
            document
                .querySelector(".email-menu-sidebar")
                .classList.contains("menubar-show")
        ) {
            // Nếu menu không được kích hoạt từ một nút menu, ẩn menu
            if (!isMenuVisible) {
                document
                    .querySelector(".email-menu-sidebar")
                    .classList.remove("menubar-show");
            }
            isMenuVisible = false; // Reset trạng thái menu
        }
    });

    // Gọi hàm favouriteBtn để xử lý trạng thái yêu thích cho các email
    favouriteBtn();
}

function checkBoxAll() {
    // Gán sự kiện click cho tất cả các checkbox
    Array.from(
        document.querySelectorAll(".checkbox-wrapper-mail input")
    ).forEach(function (checkbox) {
        checkbox.addEventListener("click", function (event) {
            // Thêm hoặc xóa lớp 'active' cho phần tử cha của checkbox dựa trên trạng thái checked
            if (event.target.checked) {
                event.target.closest("li").classList.add("active");
            } else {
                event.target.closest("li").classList.remove("active");
            }
        });
    });

    // Lấy tất cả các checkbox trong tab hiện tại
    var checkboxesInActiveTab = document.querySelectorAll(
        ".tab-pane.show .checkbox-wrapper-mail input"
    );

    // Hàm để chọn hoặc bỏ chọn tất cả checkbox
    function selectAllCheckboxes() {
        var checkboxes = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input"
        );
        var checkedCount = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input:checked"
        ).length;

        // Nếu có checkbox nào được checked, bỏ chọn tất cả
        if (checkedCount > 0) {
            Array.from(checkboxes).forEach(function (checkbox) {
                checkbox.checked = false;
                checkbox.parentNode.parentNode.parentNode.classList.remove(
                    "active"
                );
            });
            document.getElementById("email-topbar-actions").style.display =
                "block";
        } else {
            // Nếu không có checkbox nào được checked, chọn tất cả
            Array.from(checkboxes).forEach(function (checkbox) {
                checkbox.checked = true;
                checkbox.parentNode.parentNode.parentNode.classList.add(
                    "active"
                );
            });
            document.getElementById("email-topbar-actions").style.display =
                "none";
        }

        // Gọi hàm để xử lý việc xóa các mục
        removeItems();
    }

    // Hàm để xử lý sự kiện click cho checkbox "Check All"
    function toggleSelectAll() {
        var checkboxes = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input"
        );
        var checkedCount = document.querySelectorAll(
            ".tab-pane.show .checkbox-wrapper-mail input:checked"
        ).length;

        // Bỏ chọn tất cả checkbox và ẩn các mục hành động nếu có checkbox được checked
        Array.from(checkboxes).forEach(function (checkbox) {
            checkbox.checked = false;
            checkbox.parentNode.parentNode.parentNode.classList.remove(
                "active"
            );
        });

        document.getElementById("email-topbar-actions").style.display =
            checkedCount > 0 ? "none" : "block";
    }

    // Gán sự kiện click cho mỗi checkbox
    Array.from(checkboxesInActiveTab).forEach(function (checkbox) {
        checkbox.addEventListener("click", function (event) {
            var allCheckboxes = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input"
            );
            var checkAllCheckbox = document.getElementById("checkall");
            var checkedCount = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input:checked"
            ).length;

            // Cập nhật trạng thái của checkbox "Check All"
            checkAllCheckbox.checked = checkedCount > 0;
            checkAllCheckbox.indeterminate =
                checkedCount > 0 && checkedCount < allCheckboxes.length;

            // Hiện hoặc ẩn các mục hành động dựa trên số lượng checkbox được checked
            document.getElementById("email-topbar-actions").style.display =
                checkedCount > 0 ? "block" : "none";
        });
    });

    // Gán sự kiện click cho checkbox "Check All"
    document.getElementById("checkall").onclick = selectAllCheckboxes;
}

getJSON("mail-list.init.json", function (e, t) {
    null !== e
        ? console.log("Something went wrong: " + e)
        : ((allmaillist = t[0].primary),
          (socialmaillist = t[0].social),
          (promotionsmaillist = t[0].promotions),
          loadMailData(allmaillist),
          loadSocialMailData(socialmaillist),
          loadPromotionsMailData(promotionsmaillist));
}),
    Array.from(document.querySelectorAll(".mail-list a")).forEach(function (l) {
        l.addEventListener("click", function () {
            var t,
                e,
                a = document.querySelector(".mail-list a.active");
            a && a.classList.remove("active"),
                l.classList.add("active"),
                l.querySelector(".mail-list-link").hasAttribute("data-type")
                    ? ((t = l.querySelector(".mail-list-link").innerHTML),
                      (e = allmaillist.filter((e) => e.labeltype === t)))
                    : ((t = l.querySelector(".mail-list-link").innerHTML),
                      (document.getElementById("mail-list").innerHTML = ""),
                      (e =
                          "All" != t
                              ? allmaillist.filter((e) => e.tabtype === t)
                              : allmaillist),
                      (document.getElementById(
                          "mail-filter-navlist"
                      ).style.display =
                          "All" != t && "Inbox" != t ? "none" : "block")),
                loadMailData(e),
                favouriteBtn();
        });
    }),
    favouriteBtn(),
    ClassicEditor.create(document.querySelector("#email-editor"))
        .then(function (e) {
            e.ui.view.editable.element.style.height = "200px";
        })
        .catch(function (e) {
            console.error(e);
        });
var currentChatId = "users-chat";
function scrollToBottom(e) {
    // Đặt thời gian chờ 100ms trước khi cuộn xuống
    setTimeout(() => {
        // Lấy phần tử chứa cuộc hội thoại
        const chatElement = document.getElementById("chat-conversation");

        // Lấy phần tử chứa danh sách người dùng
        const usersElement = document.getElementById("users-conversation");

        // Cuộn đến đáy của phần tử chat
        new SimpleBar(chatElement).getScrollElement().scrollTop =
            usersElement.scrollHeight;
    }, 100); // Thời gian chờ
}

function removeItems() {
    // Gán sự kiện cho modal khi nó hiển thị
    document
        .getElementById("removeItemModal")
        .addEventListener("show.bs.modal", function (event) {
            // Gán sự kiện cho nút xóa
            document
                .getElementById("delete-record")
                .addEventListener("click", function () {
                    // Lặp qua tất cả các mục trong danh sách tin nhắn
                    Array.from(
                        document.querySelectorAll(".message-list li")
                    ).forEach(function (item) {
                        if (item.classList.contains("active")) {
                            // Lấy giá trị của checkbox trong mục
                            var emailId =
                                item.querySelector(".form-check-input").value;

                            // Cập nhật danh sách tất cả email bằng cách lọc các email không được chọn
                            allmaillist = allmaillist.filter(function (email) {
                                return email.id != emailId;
                            });

                            // Xóa mục khỏi giao diện
                            item.remove();
                        }
                    });

                    // Đóng modal sau khi xóa
                    document.getElementById("btn-close").click();

                    // Ẩn thanh công cụ nếu nó tồn tại
                    if (document.getElementById("email-topbar-actions")) {
                        document.getElementById(
                            "email-topbar-actions"
                        ).style.display = "none";
                    }

                    // Đặt trạng thái của checkbox "Check All" về chưa chọn
                    checkall.indeterminate = false;
                    checkall.checked = false;
                });
        });
}

function removeSingleItem() {
    // Khai báo biến để lưu id của email cần xóa
    var emailId;

    // Gán sự kiện click cho tất cả các nút xóa
    document.querySelectorAll(".remove-mail").forEach(function (button) {
        button.addEventListener("click", function (event) {
            // Lấy id của email từ thuộc tính data-remove-id
            emailId = button.getAttribute("data-remove-id");

            // Gán sự kiện cho nút "Xóa" trong modal
            document
                .getElementById("delete-record")
                .addEventListener("click", function () {
                    // Lọc danh sách email để xóa email có id tương ứng
                    allmaillist = allmaillist.filter(function (email) {
                        return email.id != emailId;
                    });

                    // Tải lại danh sách email
                    loadMailData(allmaillist);

                    // Đóng modal sau khi xóa
                    document.getElementById("close-btn-email").click();
                });
        });
    });
}

scrollToBottom(currentChatId), removeItems(), removeSingleItem();
var markAllReadBtn = document.getElementById("mark-all-read"),
    dummyUserImage =
        (markAllReadBtn.addEventListener("click", function (e) {
            0 === document.querySelectorAll(".message-list li.unread").length &&
                ((document.getElementById("unreadConversations").style.display =
                    "block"),
                setTimeout(function () {
                    document.getElementById(
                        "unreadConversations"
                    ).style.display = "none";
                }, 1e3)),
                Array.from(
                    document.querySelectorAll(".message-list li.unread")
                ).forEach(function (e) {
                    e.classList.contains("unread") &&
                        e.classList.remove("unread");
                });
        }),
        "assets/images/users/user-dummy-img.jpg"),
    mailChatDetailElm = !1;
function emailDetailChange() {
    // Lặp qua tất cả các mục trong danh sách tin nhắn
    Array.from(document.querySelectorAll(".message-list li")).forEach(function (
        item
    ) {
        // Gán sự kiện click cho từng mục
        item.addEventListener("click", function () {
            // Lấy checkbox trong mục
            var checkboxInput = item.querySelector(
                ".checkbox-wrapper-mail .form-check-input"
            );
            if (checkboxInput) {
                // Lấy giá trị của checkbox (ID email)
                var emailId = checkboxInput.value;
                var removeMailBtn = document.querySelector(".remove-mail");
                if (removeMailBtn) {
                    // Cập nhật thuộc tính data-remove-id của nút xóa
                    removeMailBtn.setAttribute("data-remove-id", emailId);
                }
            }

            // Lấy các thông tin khác từ mục
            var status_task = item.querySelector(".status");
            var date_task = item.querySelector(".date_t");
            var priority = item.querySelector(".priority_task");
            var time_estimate = item.querySelector(".time_estimate_task");
            var track_time = item.querySelector(".track_time_task");
            var tag = item.querySelector(".tag");
            var subjectTitle = item.querySelector(".subject-title");

            // Cập nhật thông tin email chi tiết
            updateEmailDetail(".email-subject-title", subjectTitle);
            updateEmailDetail(".status_task", status_task);
            updateEmailDetail(".date_task", date_task);
            updateEmailDetail(".priority", priority);
            updateEmailDetail(".time_estimate", time_estimate);
            updateEmailDetail(".tag_task", tag);
            updateEmailDetail(".track_time", track_time);

            // Cập nhật thông tin người gửi
            var titleName = item.querySelector(".title-name");
            if (titleName) {
                var senderName = titleName.textContent;
                updateSenderInfo(senderName, item);
            }

            // Cập nhật thông tin người dùng hiện tại
            updateCurrentUserInfo();
        });
    });
}

function updateEmailDetail(detailSelector, sourceElement) {
    // Kiểm tra xem phần tử nguồn có tồn tại và có thuộc tính textContent không
    if (sourceElement && sourceElement.textContent) {
        // Chọn phần tử cần cập nhật dựa trên bộ chọn CSS
        var detailElement = document.querySelector(detailSelector);

        // Kiểm tra xem phần tử cần cập nhật có tồn tại không
        if (detailElement) {
            // Kiểm tra xem phần tử cần cập nhật có phần tử con và phần tử con đầu tiên không phải là thẻ <i>
            if (
                detailElement.children.length > 0 &&
                detailElement.children[0].tagName !== "I"
            ) {
                // Nếu có phần tử con đầu tiên không phải là thẻ <i>, cập nhật văn bản của nó
                detailElement.children[0].textContent =
                    sourceElement.textContent;
                console.log("phần tử" + detailSelector + " th 1");
            } else {
                // Nếu không có phần tử con hoặc phần tử con đầu tiên là thẻ <i>
                console.log("phần tử" + detailSelector + " th 2");
                // Tìm nút văn bản (Text Node) đầu tiên trong phần tử cần cập nhật
                var textNode = Array.from(detailElement.childNodes).find(
                    (node) => node.nodeType === Node.TEXT_NODE
                );

                if (textNode) {
                    // Nếu tìm thấy nút văn bản, cập nhật nội dung của nó
                    console.log("phần tử" + detailSelector + " th 3");
                    textNode.textContent = sourceElement.textContent;
                } else {
                    console.log("phần tử" + detailSelector + " th 4");
                    // Nếu không tìm thấy nút văn bản, tạo một nút văn bản mới và thêm nó vào phần tử
                    detailElement.appendChild(
                        document.createTextNode(sourceElement.textContent)
                    );
                }
            }
        }
    }
}

function updateSenderInfo(senderName, container) {
    Array.from(document.querySelectorAll(".accordion-item.left")).forEach(
        function (e) {
            var nameElement = e.querySelector(".email-user-name");
            if (nameElement) {
                nameElement.textContent = senderName;
            }
            var imgElement = container.querySelector(".mail-userimg");
            if (imgElement) {
                var imgSrc = imgElement.value;
                var targetImg = e.querySelector("img");
                if (targetImg) {
                    targetImg.setAttribute("src", imgSrc);
                }
            }
        }
    );
}

function updateCurrentUserInfo() {
    var currentUserName = document.querySelector(".user-name-text");
    var currentUserImg = document.querySelector(".header-profile-user");
    if (currentUserName && currentUserImg) {
        var t = currentUserName.textContent;
        var l = currentUserImg.getAttribute("src");
        Array.from(document.querySelectorAll(".accordion-item.right")).forEach(
            function (e) {
                var nameElement = e.querySelector(".email-user-name-right");
                var imgElement = e.querySelector("img");
                if (nameElement) {
                    nameElement.textContent = t;
                }
                if (imgElement) {
                    imgElement.setAttribute("src", l);
                }
            }
        );
    }
}

document.querySelectorAll(".email-chat-list a").forEach(function (l) {
    var e, t;
    l.classList.contains("active") &&
        ((document.getElementById("emailchat-detailElem").style.display =
            "block"),
        (e = document
            .querySelector(".email-chat-list a.active")
            .querySelector(".chatlist-user-name").innerHTML),
        (t = document
            .querySelector(".email-chat-list a.active")
            .querySelector(".chatlist-user-image img")
            .getAttribute("src")),
        (document.querySelector(
            ".email-chat-detail .profile-username"
        ).innerHTML = e),
        document
            .getElementById("users-conversation")
            .querySelectorAll(".left .chat-avatar")
            .forEach(function (e) {
                t
                    ? e.querySelector("img").setAttribute("src", t)
                    : e
                          .querySelector("img")
                          .setAttribute("src", dummyUserImage);
            })),
        l.addEventListener("click", function (e) {
            (document.getElementById("emailchat-detailElem").style.display =
                "block"),
                (mailChatDetailElm = !0);
            var t = document.querySelector(".email-chat-list a.active"),
                t =
                    (t && t.classList.remove("active"),
                    this.classList.add("active"),
                    scrollToBottom("users-chat"),
                    l.querySelector(".chatlist-user-name").innerHTML),
                a = l
                    .querySelector(".chatlist-user-image img")
                    .getAttribute("src"),
                t =
                    ((document.querySelector(
                        ".email-chat-detail .profile-username"
                    ).innerHTML = t),
                    document.getElementById("users-conversation"));
            Array.from(t.querySelectorAll(".left .chat-avatar")).forEach(
                function (e) {
                    a
                        ? e.querySelector("img").setAttribute("src", a)
                        : e
                              .querySelector("img")
                              .setAttribute("src", dummyUserImage);
                }
            );
        });
}),
    document
        .getElementById("emailchat-btn-close")
        .addEventListener("click", function () {
            (document.getElementById("emailchat-detailElem").style.display =
                "none"),
                (mailChatDetailElm = !1),
                document
                    .querySelector(".email-chat-list a.active")
                    .classList.remove("active");
        });
const triggerTabList = document.querySelectorAll(
    "#mail-filter-navlist .nav-tabs button"
);
function resizeEvent() {
    var e;
    document.documentElement.clientWidth < 767 &&
        ((e = document.querySelector(".email-chat-list a.active")) &&
            e.classList.remove("active"),
        (document.getElementById("emailchat-detailElem").style.display =
            "none"));
}
triggerTabList.forEach((e) => {
    const t = new bootstrap.Tab(e);
    e.addEventListener("click", (e) => {
        e.preventDefault();
        document.querySelector(".tab-content .tab-pane.show");
        t.show();
    });
}),
    resizeEvent(),
    (window.onresize = resizeEvent);
