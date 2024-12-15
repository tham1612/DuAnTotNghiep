import './bootstrap';

Echo.channel(`tasks.${boardId}`)
    .listen('RealtimeUpdateTask', (response) => {
        console.log('hehhe');
        if(response.task.text){
            let taskNameElement = $(`.text-task-view-board-${response.task.id}`);
            if (taskNameElement.length > 0) {
                taskNameElement.html(response.task.text);
            }else{
                console.log('hic')
            }
        }
        const dateViewBoard = document.getElementById(`date-view-board-${response.task.id}`);
            let dateSection = document.getElementById(`date-section-${response.task.id}`);
            let date = ''; // Khởi tạo biến date

            const now = new Date();

// Kiểm tra điều kiện cho start_date và end_date
            if (response.task.start_date && response.task.end_date) {
                // Trường hợp có ngày hết hạn hoặc có cả ngày bắt đầu và ngày hết hạn
                const endDate = new Date(response.task.end_date);
                const startDate = new Date(response.task.start_date);

                date = `
            <strong>Ngày</strong>
            <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                 style="height: 35px; background-color: #091e420f; color: #172b4d">
                <input type="checkbox" id="due_date_checkbox_${response.task.id}"
                       class="form-check-input"
                       onchange="updateTask2(${response.task.id})" name="progress"
                       ${response.task.progress == 100 ? 'checked' : ''} />
                <input type="hidden" id="task_end_date_${response.task.id}" value="${response.task.end_date}">
                <p class="ms-2 mt-3">${formatFullDate(startDate)}-${formatFullDate(endDate)}</p>`;

                if (response.task.progress == 100) {
                    date += `<span class="badge bg-success ms-2" id="due_date_success_${response.task.id}">Hoàn tất</span>`;
                } else if (now < endDate) {
                    date += `<span class="badge bg-warning ms-2" id="due_date_success_${response.task.id}">Sắp đến hạn</span>`;
                } else if (now > endDate) {
                    date += `<span class="badge bg-danger ms-2" id="due_date_due_${response.task.id}">Quá hạn</span>`;
                }

                date += `</div>`;

                if (dateViewBoard) dateViewBoard.innerHTML = `${formatDate(startDate)}-${formatDate(endDate)}`
            } else if (response.task.end_date) {
                const endDate = new Date(response.task.end_date);

                date = `
                <strong>Ngày kết thúc</strong>
                <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                     style="height: 35px; background-color: #091e420f; color: #172b4d">
                    <input type="checkbox" id="due_date_checkbox_${response.task.id}"
                           class="form-check-input"
                           onchange="updateTask2(${response.task.id})" name="progress"
                           ${response.task.progress == 100 ? 'checked' : ''} />
                    <input type="hidden" id="task_end_date_${response.task.id}" value="${response.task.end_date}">
                    <p class="ms-2 mt-3">${formatFullDate(endDate)}</p>`;

                if (response.task.progress == 100) {
                    date += `<span class="badge bg-success ms-2" id="due_date_success_${response.task.id}">Hoàn tất</span>`;
                } else if (now < endDate) {
                    date += `<span class="badge bg-warning ms-2" id="due_date_success_${response.task.id}">Sắp đến hạn</span>`;
                } else if (now > endDate) {
                    date += `<span class="badge bg-danger ms-2" id="due_date_due_${response.task.id}">Quá hạn</span>`;
                }

                date += `</div>`;

                if (dateViewBoard) {
                    dateViewBoard.innerHTML = `${formatDate(endDate)}`
                }
            } else if (response.task.start_date) {
                const startDate = new Date(response.task.start_date);
                date = `
                    <strong>Ngày bắt đầu</strong>
                    <div class="d-flex align-items-center justify-content-between rounded p-3 cursor-pointer"
                         style="height: 35px; background-color: #091e420f; color: #172b4d">
                        <p class="ms-2 mt-3">${formatFullDate(startDate)}</p>
                    </div>
                `;

                if (dateViewBoard) dateViewBoard.innerHTML = `${formatDate(startDate)}`
            }
                if (dateSection) {
                    if (dateSection.style.display === 'none') {
                        dateSection.style.display = 'block'; // Hiển thị lại phần tử nếu đang bị ẩn
                    }
                    dateSection.innerHTML = date; // Thay thế toàn bộ nội dung của `dateSection`
                }

    });

function formatFullDate(date) {
    const now = new Date();
    const year = date.getFullYear();
    const currentYear = now.getFullYear();

    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0');

    if (year !== currentYear) {
        return `${hours}:${minutes} ${day} tháng ${month}, ${year}`;
    } else {
        return `${hours}:${minutes} ${day} tháng ${month}`;
    }
}
