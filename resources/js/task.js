import './bootstrap';
Echo.channel('tasks')
    .listen('.TaskCreated', (e) => {
        console.log("Nhận sự kiện TaskCreated:", e);

    });

function addTaskToKanbanBoard(kanbanBoard, task) {
    const newTaskDiv = document.createElement("div");
    newTaskDiv.setAttribute("data-value", task.id);
    newTaskDiv.innerHTML = `

    `;
    if (kanbanBoard.firstChild) {
        kanbanBoard.insertBefore(newTaskDiv, kanbanBoard.firstChild);
    } else {
        kanbanBoard.appendChild(newTaskDiv);
    }
}

