// import './bootstrap';

// Echo.channel('catalog')
//     .listen('.CatalogCreated', (e) => {
//         console.log("Nhận sự kiện CatalogCreated:", e);
//         addCatalogToCurrentView(e); // Gọi hàm chính để thêm catalog vào view hiện tại
//     });

// function addCatalogToCurrentView(catalog) {
//     const currentView = getCurrentView(); // Xác định view hiện tại
//     console.log("Current View:", currentView); // Log để xem view hiện tại
//     switch (currentView) {
//         case 'view1':
//             addCatalogToKanbanBoard(document.getElementById("kanbanboard"), catalog);
//             break;
//         case 'view2':
//             addCatalogToView2(catalog);
//             break;
//         // Thêm các view khác nếu cần
//         default:
//             console.error("Không xác định được view hiện tại.");
//     }
// }

// // Hàm xác định màn hình hiện tại
// function getCurrentView() {
//     // Kiểm tra id hoặc class để xác định màn hình hiện tại
//     if (document.getElementById("kanbanboard")) {
//         console.log("Detected view1");
//         return 'view1';
//     } else if (document.getElementById("view2Container")) {
//         console.log("Detected view2");
//         return 'view2';
//     }
//     return null; // Không xác định được view
// }

// // Hàm thêm catalog vào Kanban Board (view1)
// function addCatalogToKanbanBoard(kanbanBoard, catalog) {
//     const newCatalogDiv = document.createElement("div");
//     newCatalogDiv.classList.add("tasks-list", "rounded-3", "p-2", "border", "shadow-sm", "mb-4");
//     newCatalogDiv.setAttribute("data-value", catalog.id);

//     newCatalogDiv.innerHTML = `
//         <div class="d-flex mb-3 align-items-center">
//             <div class="flex-grow-1">
//                 <h6 class="fs-14 text-uppercase fw-semibold mb-0">
//                     ${catalog.name}
//                     <small class="badge bg-success align-bottom ms-1 totaltask-badge">${catalog.task_count}</small>
//                 </h6>
//             </div>
//             <div class="flex-shrink-0">
//                 <div class="dropdown card-header-dropdown">
//                     <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//                         <span class="fw-medium text-muted fs-12">
//                             <i class="ri-more-fill fs-20" title="Cài Đặt"></i>
//                         </span>
//                     </a>
//                     <div class="dropdown-menu dropdown-menu-end">
//                         <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Thêm thẻ</span>
//                         <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Sao chép danh sách</span>
//                         <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Di chuyển danh sách</span>
//                         <span class="dropdown-item cursor-pointer" onclick="destroyCatalog(${catalog.id})">Theo dõi</span>
//                         <span class="dropdown-item cursor-pointer" onclick="archiverCatalog(${catalog.id})">Lưu Trữ danh sách</span>
//                         <span class="dropdown-item cursor-pointer" onclick="archiverAllTasks(${catalog.id})">Lưu trữ tất cả thẻ trong danh sách</span>
//                     </div>
//                 </div>
//             </div>
//         </div>
//         <div data-simplebar class="tasks-wrapper px-3 mx-n3">
//             <div id="${catalog.name}-${catalog.id}" class="tasks">
//                 <!-- task item -->
//             </div>
//         </div>
//         <div class="my-3">
//             <button class="btn btn-soft-info w-100" id="dropdownMenuOffset2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,-50">
//                 Thêm thẻ
//             </button>
//             <div class="dropdown-menu p-3" style="width: 285px" aria-labelledby="dropdownMenuOffset2">
//                 <form>
//                     <div class="mb-2">
//                         <input type="text" id="add-task-catalog-${catalog.id}" class="form-control" name="text" placeholder="Nhập tên thẻ..."/>
//                     </div>
//                     <div class="mb-2 d-flex align-items-center">
//                         <button type="button" class="btn btn-primary" onclick="submitAddTask(${catalog.id}, '${catalog.name}')">Thêm thẻ</button>
//                         <i class="ri-close-line fs-22 ms-2 cursor-pointer"></i>
//                     </div>
//                 </form>
//             </div>
//         </div>
//     `;

//     kanbanBoard.insertBefore(newCatalogDiv, kanbanBoard.firstChild);
// }

// // Hàm thêm catalog vào View2 với giao diện đơn giản hơn
// function addCatalogToView2(catalog) {
//     const viewElement = document.getElementById("view2Container");
//     if (viewElement) {
//         const newCatalogDiv = document.createElement("div");
//         newCatalogDiv.classList.add("custom-style-view2", "rounded", "border", "p-3", "mb-4");
//         newCatalogDiv.setAttribute("data-value", catalog.id);

//         newCatalogDiv.innerHTML = `
//             <h4>${catalog.name}</h4>
//             <p class="text-muted">Số lượng task: ${catalog.task_count}</p>
//             <button class="btn btn-outline-primary btn-sm mt-2" onclick="addTask(${catalog.id})">Thêm Task</button>
//             <!-- Các thành phần bổ sung khác cho view2 -->
//         `;

//         viewElement.insertBefore(newCatalogDiv,viewElement.firstChild);
//     }
// }
