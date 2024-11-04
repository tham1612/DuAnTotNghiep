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
    newCatalogDiv.classList.add("tasks-list", "rounded-3", "p-2", "border");
    newCatalogDiv.setAttribute("data-value", catalog.id);
    newCatalogDiv.innerHTML = `
        <div class="tasks-list rounded-3 p-2 border" data-value="${response.catalog.id}">
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                    ${catalog.name}
                    <small class="badge bg-success align-bottom ms-1 totaltask-badge">${catalog.task_count}</small>
                </h6>
            </div>
            <div class="flex-shrink-0">
                <div class="dropdown card-header-dropdown">
                    <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fw-medium text-muted fs-12">
                            <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Thêm thẻ</span>
                        <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Sao chép danh sách</span>
                        <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Di chuyển danh sách</span>
                        <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Theo dõi</span>
                        <span class="dropdown-item cursor-pointer" onclick="archiverCatalog(${catalog.id})">Lưu Trữ danh sách</span>
                        <span class="dropdown-item cursor-pointer" onclick="archiverAllTasks(${catalog.id})">Lưu trữ tất cả thẻ trong danh sách</span>
                    </div>
                </div>
            </div>
        </div>
        <div data-simplebar class="tasks-wrapper px-3 mx-n3">
            <div id="${catalog.name}-${catalog.id}" class="tasks">
                <!-- task item -->
            </div>
        </div>
        <div class="my-3">
            <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50">
                Thêm thẻ
            </button>
            <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
                <form>
                    <div class="mb-2">
                        <input type="text" id="add-task-catalog-${catalog.id}" class="form-control" name="text" placeholder="Nhập tên thẻ..."/>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <button type="button" class="btn btn-primary" onclick="submitAddTask(${catalog.id}, '${catalog.name}')">Thêm thẻ</button>
                        <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
                    </div>
                </form>
            </div>
        </div>
    `;
    if (kanbanBoard.firstChild) {
        kanbanBoard.insertBefore(newCatalogDiv, kanbanBoard.firstChild);
    } else {
        kanbanBoard.appendChild(newCatalogDiv);
    }
}

