import './bootstrap';


Echo.channel('catalogs')
    .listen('RealtimeCreateCatalog', (e) => {
        console.log("Nhận sự kiện CatalogCreated:", e);
        addCatalogToCurrentView(e); // Gọi hàm chính để thêm catalog vào view hiện tại
    });

function addCatalogToCurrentView(catalog) {
    const currentView = getCurrentView(); // Xác định view hiện tại
    console.log("Current View:", currentView); // Log để xem view hiện tại
    switch (currentView) {
        case 'view1':
            addCatalogToKanbanBoard(document.getElementById("kanbanboard"), catalog);
            break;
        case 'view2':
            addCatalogToView2(catalog);
            break;
        // Thêm các view khác nếu cần
        default:
            console.error("Không xác định được view hiện tại.");
    }
}

// Hàm xác định màn hình hiện tại
function getCurrentView() {
    // Kiểm tra id hoặc class để xác định màn hình hiện tại
    if (document.getElementById("kanbanboard")) {
        console.log("Detected view1");
        return 'view1';
    } else if (document.getElementById("realtime-view-list")) {
        console.log("Detected view2");
        return 'view2';
    }
    return null; // Không xác định được view
}

// Hàm thêm catalog vào Kanban Board (view1)
function addCatalogToKanbanBoard(kanbanBoard, catalog) {
    let listCatalog = $('.board-' + catalog.board_id);
    const newCatalogDiv = document.createElement("div");
    newCatalogDiv.classList.add("tasks-list", "rounded-3", "p-2", "border",`position-${catalog.position}`);
    newCatalogDiv.setAttribute("data-value", catalog.id);
    newCatalogDiv.setAttribute("id", `catalog_view_board_${catalog.id}`);

    newCatalogDiv.innerHTML = `
        <div class="d-flex mb-3 align-items-center">
            <div class="flex-grow-1">
                <h6 class="fs-14 text-uppercase fw-semibold mb-0"  id="title-catalog-view-board-${catalog.id}">
                    ${catalog.name}
                   <small class="badge bg-success align-bottom ms-1 totaltask-badge
                                totaltask-catalog-${catalog.id}">0</small>
                </h6>
            </div>
             <div class="flex-shrink-0">
                <div class="dropdown card-header-dropdown">
                   <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                       data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="${catalog.id}">
                        <span class="fw-medium text-muted fs-12">
                            <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
                        </span>
                    </a>
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
    listCatalog.before(newCatalogDiv)

}

// Hàm thêm catalog vào View2 với giao diện đơn giản hơn
function addCatalogToView2(catalog) {
    let listMenuList = $('.menu-catalog-' + catalog.board_id);
    let menuList = `
                <a class="list-group-item list-group-item-action"
                   href="#${catalog.id}">${catalog.name} </a>
            `;
    if (listMenuList.length) {
        listMenuList.append(menuList);
    } else {
        console.error(`Không tìm thấy phần tử với class menu-catalog-${catalog.board_id}`);
    }
    let listCatalogList = $('.list-catalog-' + catalog.board_id);
    let catalogList = `
             <div class="card" id="catalog_view_list_${catalog.id}">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1">
                            <h6 class="fs-14 fw-semibold mb-0" value="${catalog.id}">${catalog.name}
                                  <small
                                    class="badge bg-warning align-bottom ms-1 totaltask-badge
                                     totaltask-catalog-${catalog.id}">
                                    0</small>
                            </h6>
                            <div class="d-flex ms-4">
                               <a class="text-reset dropdown-btn cursor-pointer" data-bs-toggle="modal"
                                   data-bs-target="#detailCardModalCatalog" data-setting-catalog-id="${catalog.id}">
                                    <i class="ri-more-fill"></i>
                                </a>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-3" id="dropdownMenuOffset${catalog.id}"
                                         data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50"
                                        onclick="loadFormAddTask(${catalog.id})">
                                    <i class="ri-add-line align-bottom me-1"></i>Thêm thẻ
                                </button>
                                <div class="dropdown-menu p-3 dropdown-content-add-task-${catalog.id}" style="width: 285px"
                                     aria-labelledby="dropdownMenuOffset3">
<!--                                    // dropdown.createTask-->
                                </div>
                        </div>
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-3">
                        <table id="catalog-table-${catalog.id}" style="width:100%"
                               class="table table-bordered dt-responsive nowrap table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Thẻ</th>
                                <th>Thành viên</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Độ ưu tiên</th>
                                <th>Danh sách</th>

                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody id="body-catalog-${catalog.id}">
<!--                           // nội dung của task-->
                            </tbody>
                        </table>
                    </div>

                </div>
                <!--end card-body-->
            </div>
            `;
    if (listCatalogList) {
        listCatalogList.append(catalogList);
    } else {
        console.error(`Không tìm thấy phần tử với class '.list-catalog-${catalog.board_id}' `);
    }
}
