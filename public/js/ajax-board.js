let isSubmitting = false;
function submitAddCatalog( boardId) {
    if (isSubmitting) return; // Nếu đang xử lý, không cho phép submit
    isSubmitting = true;
    let formData = {
        board_id: boardId,
        name: $('#nameCatalog').val(),
    };
    $.ajax({
        url: `/catalogs`,
        type: 'POST',
        data: formData,
        success: function(response) {

            // let checkList = document.getElementById('checkListCreate');
            // let listItem = `
            //
            // `;
            // if (checkList) {
            //     checkList.innerHTML += listItem;
            // } else {
            //     console.error('Không tìm thấy phần tử checkListcreat');
            // }
             $('#nameCatalog').val('');
            console.log('Catalog đã được thêm thành công!', response);
        },
        error: function(xhr) {
            alert('Đã xảy ra lỗi!');
            console.log(xhr.responseText);
        },
        complete: function() {
            // Đặt lại cờ sau 3 giây để cho phép gửi lại
            setTimeout(() => {
                isSubmitting = false;
            }, 2000);
        }
    });
    return false;
}
