import './bootstrap';
Echo.channel('catalog')
    .listen('.CatalogCreated', (e) => {
        console.log("Nhận sự kiện CatalogCreated:", e);

        const kanbanBoard = document.getElementById("kanbanboard");

        if (kanbanBoard) {
            addCatalogToKanbanBoard(kanbanBoard, e);
        }
    });

// Hàm để thêm catalog vào Kanban board
function addCatalogToKanbanBoard(kanbanBoard, catalog) {
    const newCatalogDiv = document.createElement("div");
    newCatalogDiv.setAttribute("data-value", catalog.id);
    newCatalogDiv.innerHTML = `
        <h6>${catalog.name}</h6>
        <small class="badge bg-success">0</small>
        <!-- Các nội dung khác của catalog -->
    `;

    // Thêm catalog mới vào container
    kanbanBoard.appendChild(newCatalogDiv);
}




