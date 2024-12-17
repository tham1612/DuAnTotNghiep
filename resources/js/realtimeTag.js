import './bootstrap';

Echo.channel(`tags.${boardId}`)
    .listen('RealtimeCreateTag', (response) => {
        console.log('hhh');
        let tagSection = document.getElementById(`tag-section-${response.task_id}`);
        let tagSectionView = document.querySelector(`.tag-task-section-${response.task_id}`);
        let tagTask = document.getElementById('tag-task-' + response.task_id);
        if (tagSection.length>0){
            if (tagSection.style.display === 'none') {
                tagSection.style.display = 'block';
            }
        }

        if ( tagSectionView && tagSectionView.classList.contains('hidden')) {
            tagSectionView.classList.remove('hidden');
        }
        let tagTaskView = document.querySelector(`.tag-task-view-${response.task_id}`);
        let tagItemView = document.querySelector(`[data-tag-view-id="${response.task_id}-${response.tag_id}"]`);
        let tagTaskAdd = `
                    <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="top" data-tag-id="${response.task_id}-${response.tag_id}"
                        title="${response.tagTaskName}">
                        <div
                            class="badge border rounded d-flex align-items-center justify-content-center"
                            style=" background-color: ${response.tagTaskColor}">
                            ${response.tagTaskName}
                        </div>
                    </div>
                    `;
        let tagTaskAddView = `
                    <div data-bs-toggle="tooltip"  data-tag-view-id="${response.task_id}-${response.tag_id}" data-bs-trigger="hover"
                            data-bs-placement="top" title="${response.tagTaskName}">
                        <div
                            class="text-white border rounded d-flex align-items-center justify-content-center"
                            style="width: 40px;height: 15px; background-color: ${response.tagTaskColor}">
                        </div>
                    </div>
                `;
        let tagBoard = document.getElementById('danh-sach-tag-' + response.board_id);
        let tagBoardAdd = `
                <li class="mt-1 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <input type="checkbox" checked
                               class="form-check-input-tag" value="${response.task_id}-${response.tag_id}"/>
                        <span class="mx-2 rounded p-2 col-10 text-white"
                              style="background-color: ${response.tagTaskColor}">${response.tagTaskName}</span>
                    </div>
                    <i class="ri-pencil-line fs-20 cursor-pointer" data-bs-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false"></i>
                </li>
            `;
        if (tagTask) {
            tagTask.innerHTML += tagTaskAdd;
        } else {
            console.error('ko thanh cong');
        }
        if (tagTaskView) {
            tagTaskView.innerHTML += tagTaskAddView;
        }
        if (tagBoard) {
            tagBoard.innerHTML += tagBoardAdd;
        }
    })
    .listen('RealtimeUpdateTag', (response) => {
        console.log('hahaha');
        let tagSection = document.getElementById(`tag-section-${response.task_id}`);
        let tagSectionView = document.querySelector(`.tag-task-section-${response.task_id}`);
        let tagTask = document.getElementById('tag-task-' + response.task_id);

        // Hiển thị tag nếu được thêm và section hiện đang ẩn
        if (response.action === 'added' && tagSection && tagSection.style.display === 'none') {
            tagSection.style.display = 'block';
        }
        if (response.action === 'added' && tagSectionView && tagSectionView.classList.contains('hidden')) {
            tagSectionView.classList.remove('hidden');
        }


        // Tìm và xử lý tag item dựa trên hành động
        let tagTaskView = document.querySelector(`.tag-task-view-${response.task_id}`);
        let tagItem = document.querySelector(`[data-tag-id="${response.task_id}-${response.tag_id}"]`);
        let tagItemView = document.querySelector(`[data-tag-view-id="${response.task_id}-${response.tag_id}"]`);
        if (response.action === 'added') {
            // Tạo nội dung tag mới
            let tagTaskAdd = `
                        <div class="tag-item" data-tag-id="${response.task_id}-${response.tag_id}"
                             data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                             title="${response.tagTaskName}">
                            <div class="badge border rounded d-flex align-items-center justify-content-center"
                                 style="background-color: ${response.tagTaskColor}">
                                ${response.tagTaskName}
                            </div>
                        </div>
                    `;
            let tagTaskAddView = `
                        <div data-bs-toggle="tooltip"  data-tag-id="${response.task_id}-${response.tag_id}" data-bs-trigger="hover"
                                data-bs-placement="top" title="${response.tagTaskName}">
                            <div
                                class="text-white border rounded d-flex align-items-center justify-content-center"
                                style="width: 40px;height: 15px; background-color: ${response.tagTaskColor}">
                            </div>
                        </div>
                    `;
            if (tagTask) {
                tagTask.innerHTML += tagTaskAdd;
            } else {
                console.error('Element tag-task-' + response.task_id + ' not found.');
            }
            if (tagTaskView) {
                tagTaskView.innerHTML += tagTaskAddView;
            } else {
                console.error(' not found.');
            }
        } else if (response.action === 'removed') {
            // Xóa tag
            if (tagItem) {
                tagItem.remove();
            }
            if (tagItemView) {
                tagItemView.remove();
            }
            if (tagTask && tagTask.children.length === 0) {
                tagSection.style.display = 'none';
            }
            if (tagTaskView && tagTaskView.innerHTML.trim() === '' && tagSectionView) {
                tagSectionView.style.display = 'none';
            }


        }

    })


console.log('Đang lắng nghe kênh:', `tags.${boardId}`);




