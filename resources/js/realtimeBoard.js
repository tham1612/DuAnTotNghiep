import './bootstrap';


Echo.channel(`boards.${boardId}`)
    .listen('RealtimeBoardDetail', (e) => {
        console.log("Nhận sự kiện RealtimeBoardDetail:", e);


        let titleBoardNavbar = document.getElementById(
            `2-name-board-${e.board.id}`
        );
        let titleBoardSidebar = document.getElementById(
            `name-board-${e.board.id}`
        );
        let iconAccessBoardNavbar = document.getElementById(
            `accessIcon_${e.board.id}`
        );
        let textAccessBoardNavbar = document.getElementById(
            `accessText_${e.board.id}`
        );

        titleBoardNavbar.innerHTML = e.board.name;
        titleBoardSidebar.innerHTML = e.board.name;

        const isPrivate = e.board.access === "private";
        iconAccessBoardNavbar.classList.toggle("ri-lock-2-line", isPrivate);
        iconAccessBoardNavbar.classList.toggle("text-danger", isPrivate);
        iconAccessBoardNavbar.classList.toggle("ri-shield-user-fill", !isPrivate);
        iconAccessBoardNavbar.classList.toggle("text-primary", !isPrivate);

        textAccessBoardNavbar.innerHTML = isPrivate ? "Riêng tư" : "Công khai";
        if (e.board.image) {
            let imageElement = $('#image-board-' + boardId);

            if (imageElement.is('img')) {
                // Nếu phần tử là <img>, cập nhật src với URL mới
                imageElement.attr('src', `/storage/${e.board.image}?t=${new Date().getTime()}`);
            } else {
                // Nếu phần tử là <div>, thay thế bằng thẻ <img> mới
                imageElement.replaceWith(`
                 <img id="image-board-${boardId}" class="bg-info-subtle rounded d-flex justify-content-center align-items-center me-2"
                 src="/storage/${e.board.image}?t=${new Date().getTime()}"
                 style="width: 30px; height: 30px" alt="image" />
        `);
            }
        }
        notificationWeb('', 'Quản trị viên đã thay đổi thông tin của bảng')
    });

