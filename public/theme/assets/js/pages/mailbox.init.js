var url = "http://127.0.0.1:8000/theme/assets/json/",
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
function loadMailData(e) {
    // Nhấp vào nút để kích hoạt tab có id là "pills-primary"
    document
        .querySelector(
            '#mail-filter-navlist button[data-bs-target="#pills-primary"]'
        )
        .click(),
        // Xóa nội dung hiện tại của phần tử có id là "mail-list"
        (document.querySelector("#mail-list").innerHTML = ""),
        // Chuyển đổi đối tượng e thành mảng và lặp qua từng phần tử của mảng
        Array.from(e).forEach(function (e, t) {
            // Xác định trạng thái của email (đọc hay chưa đọc)
            var a = e.readed ? "" : "unread";
            // Xác định trạng thái của email (được đánh dấu sao hay không)
            var l = e.starred ? "active" : "";
            // Tạo chuỗi thông tin số lượng email (nếu có)
            var c = e.counted ? "(" + e.counted + ")" : "";

            // Cập nhật nội dung của phần tử HTML có id là "mail-list" bằng cách thêm thông tin email vào
            document.querySelector("#mail-list").innerHTML +=
                '<li class="' +
                a +
                '">' +
                '<div class="col-mail col-mail-1">' +
                '<div class="form-check checkbox-wrapper-mail fs-14">' +
                '<input class="form-check-input" type="checkbox" value="' +
                e.id +
                '" id="checkbox-' +
                e.id +
                '">' +
                '<label class="form-check-label" for="checkbox-' +
                e.id +
                '"></label>' +
                "</div>" +
                '<input type="hidden" value=' +
                e.userImg +
                ' class="mail-userimg" />' +
                '<button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ' +
                l +
                '">' +
                '<i class="ri-star-fill"></i>' +
                "</button>" +
                '<a href="javascript: void(0);" class="title"><span class="title-name">' +
                e.name +
                " " +
                c +
                "</span></a>" +
                "</div>" +
                '<div class="col-mail col-mail-2">' +
                '<a href="javascript: void(0);" class="subject"><span class="subject-title">' +
                e.title +
                '</span> – <span class="teaser">' +
                e.description +
                "</span></a>" +
                '<div class="date">' +
                e.date +
                "</div>" +
                '<div class="assign" style="display: none;">' +
                e.assign +
                "</div>" +
                '<div class="status" style="display: none;">' +
                e.status_task +
                "</div>" +
                '<div class="date_t" style="display: none;">' +
                e.date_task +
                "</div>" +
                '<div class="priority_task" style="display: none;">' +
                e.priority +
                "</div>" +
                '<div class="time_estimate_task" style="display: none;">' +
                e.time_estimate +
                "</div>" +
                '<div class="track_time_task" style="display: none;">' +
                e.track_time +
                "</div>" +
                '<div class="tag" style="display: none;">' +
                e.tag +
                "</div>" +
                "</div>" +
                "</li>";

            // Gọi các hàm khác để xử lý thêm (các hàm này không được định nghĩa trong đoạn mã hiện tại)
            favouriteBtn();
            emailDetailShow();
            emailDetailChange();
            checkBoxAll();
        });
}
function loadSocialMailData(e) {
    // Chuyển đổi đối tượng e thành một mảng và lặp qua từng phần tử của mảng
    Array.from(e).forEach(function (e, t) {
        // Xác định trạng thái của email (đọc hay chưa đọc)
        var a = e.readed ? "" : "unread";
        // Xác định trạng thái của email (được đánh dấu sao hay không)
        var l = e.starred ? "active" : "";
        // Tạo chuỗi thông tin số lượng email (nếu có)
        var c = e.counted ? "(" + e.counted + ")" : "";

        // Cập nhật nội dung của phần tử HTML có id là "social-mail-list" bằng cách thêm thông tin email vào
        document.getElementById("social-mail-list").innerHTML +=
            '<div class="social-mail-item ' +
            a +
            '">' +
            '<div class="mail-status ' +
            l +
            '"></div>' +
            '<div class="mail-info">' +
            '<span class="mail-name">' +
            e.name +
            " " +
            c +
            "</span>" +
            '<span class="mail-title">' +
            e.title +
            "</span>" +
            '<span class="mail-description"> – ' +
            e.description +
            "</span>" +
            '<span class="mail-date">' +
            e.date +
            "</span>" +
            "</div>" +
            "</div>";

        // Gọi các hàm khác để xử lý thêm (các hàm này không được định nghĩa trong đoạn mã hiện tại)
        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
}
function loadPromotionsMailData(e) {
    Array.from(e).forEach(function (e, t) {
        var a = e.readed ? "" : "unread",
            l = e.starred ? "active" : "",
            c = e.counted ? "(" + e.counted + ")" : "";
        (document.getElementById("promotions-mail-list").innerHTML +=
            '<li class="' +
            a +
            '">                <div class="col-mail col-mail-1">                    <div class="form-check checkbox-wrapper-mail fs-14">                        <input class="form-check-input" type="checkbox" value="' +
            e.id +
            '" id="checkbox-' +
            e.id +
            '">                        <label class="form-check-label" for="checkbox-' +
            e.id +
            '"></label>                    </div>                    <input type="hidden" value=' +
            e.userImg +
            ' class="mail-userimg" />                    <button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ' +
            l +
            '">                    <i class="ri-star-fill"></i>                    </button>                    <a href="javascript: void(0);" class="title"><span class="title-name">' +
            e.name +
            "</span> " +
            c +
            '</a>                </div>                <div class="col-mail col-mail-2">                    <a href="javascript: void(0);" class="subject"><span class="subject-title">' +
            e.title +
            '</span> – <span class="teaser">' +
            e.description +
            '</span>                    </a>                    <div class="date">' +
            e.date +
            "</div>                </div>            </li>"),
            emailDetailShow(),
            emailDetailChange(),
            checkBoxAll();
    });
}
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
function checkBoxAll() {
    Array.from(
        document.querySelectorAll(".checkbox-wrapper-mail input")
    ).forEach(function (e) {
        e.addEventListener("click", function (e) {
            1 == e.target.checked
                ? e.target.closest("li").classList.add("active")
                : e.target.closest("li").classList.remove("active");
        });
    });
    var e = document.querySelectorAll(
        ".tab-pane.show .checkbox-wrapper-mail input"
    );
    function a() {
        var e = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input"
            ),
            t = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input:checked"
            ).length;
        Array.from(e).forEach(function (e) {
            (e.checked = !0),
                e.parentNode.parentNode.parentNode.classList.add("active");
        }),
            (document.getElementById("email-topbar-actions").style.display =
                0 < t ? "none" : "block"),
            0 < t
                ? Array.from(e).forEach(function (e) {
                      (e.checked = !1),
                          e.parentNode.parentNode.parentNode.classList.remove(
                              "active"
                          );
                  })
                : Array.from(e).forEach(function (e) {
                      (e.checked = !0),
                          e.parentNode.parentNode.parentNode.classList.add(
                              "active"
                          );
                  }),
            (this.onclick = l),
            removeItems();
    }
    function l() {
        var e = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input"
            ),
            t = document.querySelectorAll(
                ".tab-pane.show .checkbox-wrapper-mail input:checked"
            ).length;
        Array.from(e).forEach(function (e) {
            (e.checked = !1),
                e.parentNode.parentNode.parentNode.classList.remove("active");
        }),
            (document.getElementById("email-topbar-actions").style.display =
                0 < t ? "none" : "block"),
            0 < t
                ? Array.from(e).forEach(function (e) {
                      (e.checked = !1),
                          e.parentNode.parentNode.parentNode.classList.remove(
                              "active"
                          );
                  })
                : Array.from(e).forEach(function (e) {
                      (e.checked = !0),
                          e.parentNode.parentNode.parentNode.classList.add(
                              "active"
                          );
                  }),
            (this.onclick = a);
    }
    Array.from(e).forEach(function (e) {
        e.addEventListener("click", function (e) {
            var t = document.querySelectorAll(
                    ".tab-pane.show .checkbox-wrapper-mail input"
                ),
                a = document.getElementById("checkall"),
                l = document.querySelectorAll(
                    ".tab-pane.show .checkbox-wrapper-mail input:checked"
                ).length;
            (a.checked = 0 < l),
                (a.indeterminate = 0 < l && l < t.length),
                e.target.closest("li").classList.contains("active"),
                (document.getElementById("email-topbar-actions").style.display =
                    0 < l ? "block" : "none");
        });
    }),
        (document.getElementById("checkall").onclick = a);
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
    setTimeout(() => {
        new SimpleBar(
            document.getElementById("chat-conversation")
        ).getScrollElement().scrollTop =
            document.getElementById("users-conversation").scrollHeight;
    }, 100);
}
function removeItems() {
    document
        .getElementById("removeItemModal")
        .addEventListener("show.bs.modal", function (e) {
            document
                .getElementById("delete-record")
                .addEventListener("click", function () {
                    Array.from(
                        document.querySelectorAll(".message-list li")
                    ).forEach(function (e) {
                        var t, a;
                        e.classList.contains("active") &&
                            ((t = e.querySelector(".form-check-input").value),
                            (a = t),
                            (allmaillist = allmaillist.filter(function (e) {
                                return e.id != a;
                            })),
                            e.remove());
                    }),
                        document.getElementById("btn-close").click(),
                        document.getElementById("email-topbar-actions") &&
                            (document.getElementById(
                                "email-topbar-actions"
                            ).style.display = "none"),
                        (checkall.indeterminate = !1),
                        (checkall.checked = !1);
                });
        });
}
function removeSingleItem() {
    var a;
    document.querySelectorAll(".remove-mail").forEach(function (t) {
        t.addEventListener("click", function (e) {
            (a = t.getAttribute("data-remove-id")),
                document
                    .getElementById("delete-record")
                    .addEventListener("click", function () {
                        var t;
                        (t = a),
                            loadMailData(
                                (allmaillist = allmaillist.filter(function (e) {
                                    return e.id != t;
                                }))
                            ),
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
    Array.from(document.querySelectorAll(".message-list li")).forEach(function (
        c
    ) {
        c.addEventListener("click", function () {
            var checkboxInput = c.querySelector(
                ".checkbox-wrapper-mail .form-check-input"
            );
            if (checkboxInput) {
                var e = checkboxInput.value;
                var removeMailBtn = document.querySelector(".remove-mail");
                if (removeMailBtn) {
                    removeMailBtn.setAttribute("data-remove-id", e);
                }
            }

            var status_task = c.querySelector(".status");
            var date_task = c.querySelector(".date_t");
            var priority = c.querySelector(".priority_task");
            var time_estimate = c.querySelector(".time_estimate_task");
            var track_time = c.querySelector(".track_time_task");
            var tag = c.querySelector(".tag");
            var subjectTitle = c.querySelector(".subject-title");

            updateEmailDetail(".email-subject-title", subjectTitle);
            updateEmailDetail(".status_task", status_task);
            updateEmailDetail(".date_task", date_task);
            updateEmailDetail(".priority", priority);
            updateEmailDetail(".time_estimate", time_estimate);
            updateEmailDetail(".tag_task", tag);
            updateEmailDetail(".track_time", track_time);

            var titleName = c.querySelector(".title-name");
            if (titleName) {
                var a = titleName.textContent;
                updateSenderInfo(a, c);
            }

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
