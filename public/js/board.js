function archiverBoard(boardId) {
    console.log(boardId)
    $.ajax({
        url: `/b/${boardId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg)
            window.location.href = 'http://127.0.0.1:8000/home';
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });

}

function restoreBoard(boardId) {
    console.log(boardId)
    $.ajax({
        url: `/b/restoreBoard/${boardId}`,
        type: 'POST',
        success: function (response) {
            console.log(response)
            notificationWeb(response.action, response.msg)
            window.location.href = `http://127.0.0.1:8000/b/${response.board}/edit?viewType=dashboard`;
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });

}

function destroyBoard(boardId) {
    console.log(boardId)
    $.ajax({
        url: `/b/destroyBoard/${boardId}`,
        type: 'POST',
        success: function (response) {
            notificationWeb(response.action, response.msg)
            window.location.href = 'http://127.0.0.1:8000/home';
        },
        error: function (xhr) {
            notificationWeb(response.action, response.msg)
        }
    });

}
