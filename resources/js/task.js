// import './bootstrap';
// Echo.channel('tasks')
//     .listen('.TaskCreated', (e) => {
//         console.log("Nhận sự kiện TaskCreated:", e);

//         const catalogId = e.task.catalog_id; // ID của catalog mà task thuộc về

//         // Tìm catalog dựa trên data-value
//         const catalogElement = document.querySelector(`.tasks-list[data-value="${catalogId}"] .tasks`);

//         if (catalogElement) {
//             addTaskToCatalog(catalogElement, e.task); // Thêm task vào catalog nếu tìm thấy
//         } else {
//             console.error(`Không tìm thấy catalog với data-value: ${catalogId}`);
//         }
//     });

// function addTaskToCatalog(catalogElement, task) {
//     const newTaskDiv = document.createElement("div");
//     newTaskDiv.classList.add("card", "tasks-box", "cursor-pointer");
//     newTaskDiv.setAttribute("data-value", task.id);
//     newTaskDiv.innerHTML = `
//         <div class="card-body">
//             <div class="d-flex mb-2">
//                 <h6 class="fs-15 mb-0 flex-grow-1" data-bs-toggle="modal"
//                     data-bs-target="#detailCardModal" data-task-id="${task.id}">
//                     ${task.text}
//                 </h6>
//                 <div class="dropdown">
//                     <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1"
//                        data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
//                     <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
//                         <li><span class="dropdown-item" href="#">Mở thẻ</span></li>
//                         <li><span class="dropdown-item" href="#">Chỉnh sửa nhãn</span></li>
//                         <li><span class="dropdown-item" href="#">Thay đổi thành viên</span></li>
//                         <li><span class="dropdown-item" href="#">Chỉnh sửa ngày</span></li>
//                         <li><span class="dropdown-item" href="#">Sao chép</span></li>
//                         <li><span class="dropdown-item" href="#" onclick="archiverTask(${task.id})">Lưu trữ</span></li>
//                     </ul>
//                 </div>
//             </div>
//             <div class="mt-3" data-bs-toggle="modal" data-bs-target="#detailCardModal">
//                 <!-- Nội dung bổ sung cho task (nếu có) -->
//             </div>
//         </div>
//     `;
//     // Thêm task mới vào đầu danh sách task của catalog
//     catalogElement.insertBefore(newTaskDiv, catalogElement.firstChild);
// }
