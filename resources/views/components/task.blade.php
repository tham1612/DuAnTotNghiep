<!-- chi tiết thẻ -->
<style>
    .custom-file-upload {
        background-color: rgba(235, 235, 235, 0.52);
        border-radius: 10px;
        display: inline-block;
        padding: 3px 35px;
        margin-top: 100px;
        margin-left: -10px;
    }

    .file-upload {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        width: 15%;
        height: 20%;
        opacity: 0; /* Ẩn input nhưng vẫn nhận được sự kiện click */
    }
</style>
            <div class="modal fade" id="detailCardModal" tabindex="-1"
                 aria-labelledby="detailCardModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 rounded-3 modal-task">




                    </div>
                </div>
            </div>


<!-- ckeditor -->
<script src="https://unpkg.com/@ckeditor/ckeditor5-build-classic@12.2.0/build/ckeditor.js"></script>
<!-- prismjs plugin -->

<script>
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    // Tạo một đối tượng để lưu trữ các editor đã khởi tạo
    const editors = {};

    // Khởi tạo ClassicEditor cho mỗi phần tử có class 'editor'
    document.querySelectorAll('.editor').forEach((editorElement, index) => {
        ClassicEditor
            .create(editorElement
                , {
                    toolbar: [
                        'heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'
                    ],
                    removePlugins: [
                        'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload',
                        'MediaEmbed', 'MediaEmbedToolbar'
                    ]
                }
            )
            .then(editor => {
                // Lưu trữ instance của từng editor với id của phần tử hoặc chỉ mục
                editors[editorElement.id] = editor;

                // Lắng nghe sự kiện change của editor
                editor.model.document.on('change:data', debounce(() => {
                    const taskId = editorElement.id.split('_')[1];
                    updateTask2(taskId);
                }, 1000));
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
<script>
    document.addEventListener('click', function (event) {
        // Sự kiện cho nút hiển thị form 'Thêm mục'
        if (event.target.classList.contains('display-checklist')) {
            const formElement = event.target.closest('.row').querySelector('.addOrUpdate-checklist');
            formElement.classList.toggle('d-none'); // Hiện hoặc ẩn form
            event.target.classList.add('d-none'); // Ẩn nút hiển thị form
        }

        // Sự kiện cho nút 'Hủy'
        if (event.target.classList.contains('disable-checklist')) {
            const formElement = event.target.closest('.row').querySelector('.addOrUpdate-checklist');
            const inputElement = formElement.querySelector('.checklistItem');
            inputElement.value = ""; // Xóa nội dung ô nhập liệu
            formElement.classList.add('d-none'); // Ẩn form
            event.target.closest('.row').querySelector('.display-checklist').classList.remove('d-none'); // Hiện lại nút hiển thị form
        }
    });


    //     xử lý lưu trữ cảu card
    // Lấy tất cả các phần tử có cùng class
    var archivers = document.querySelectorAll('.archiver');
    var restoreArchivers = document.querySelectorAll('.restore-archiver');
    var deleteArchivers = document.querySelectorAll('.delete-archiver');

    // Lặp qua tất cả các phần tử archiver và thêm sự kiện
    archivers.forEach((archiver, index) => {
        archiver.addEventListener('click', () => {
            restoreArchivers[index].classList.toggle('d-none');
            deleteArchivers[index].classList.toggle('d-none');
            archiver.classList.add('d-none');
        });
    });

    // Lặp qua tất cả các phần tử restore-archiver và thêm sự kiện
    restoreArchivers.forEach((restoreArchiver, index) => {
        restoreArchiver.addEventListener('click', () => {
            deleteArchivers[index].classList.add('d-none');
            restoreArchivers[index].classList.add('d-none');
            archivers[index].classList.toggle('d-none');
        });
    });

    // Lặp qua tất cả các phần tử delete-archiver và thêm sự kiện
    deleteArchivers.forEach((deleteArchiver) => {
        deleteArchiver.addEventListener('click', () => {
            window.location.reload();
        });
    });

    // Hàm ẩn khối bình luận và hiện textarea khi người dùng nhấp vào
    function toggleCommentForm(element) {
        // Lấy taskId từ data-attribute
        const taskId = element.getAttribute('data-task-id');

        // Tìm khối "Viết bình luận"
        const commentDiv = element;

        // Tìm form theo taskId
        const commentForm = document.querySelector(`form[data-task-id="${taskId}"]`);

        if (commentDiv && commentForm) {
            // Ẩn khối "Viết bình luận"
            commentDiv.style.display = 'none';

            // Hiện form
            commentForm.style.display = 'block';
        } else {
            console.error('Không tìm thấy phần tử với taskId:', taskId);
        }
    }

    // Hàm ẩn khối mô tả và hiện textarea khi người dùng nhấp vào
    function toggleDescriptionForm(element) {
        // Lấy taskId từ data-attribute
        const taskId = element.getAttribute('data-task-id');
        console.log('Task ID:', taskId);  // Kiểm tra giá trị taskId

        // Lấy khối mô tả đang được hiển thị
        const descriptionDiv = document.getElementById(`description_display_${taskId}`);

        // Lấy textarea và container của nó theo taskId
        const descriptionContainer = document.getElementById(`textarea_container_${taskId}`);
        const descriptionTextarea = document.getElementById(`description_${taskId}`);

        if (descriptionDiv && descriptionContainer && descriptionTextarea) {
            // Sử dụng class để ẩn thay vì trực tiếp thay đổi style
            descriptionDiv.classList.add('d-none');  // Thêm class Bootstrap ẩn div

            // Hiển thị textarea bằng cách xóa class d-none
            descriptionContainer.classList.remove('d-none');
            descriptionTextarea.focus();  // Đặt con trỏ vào textarea
        } else {
            console.error('Không tìm thấy phần tử với taskId:', taskId);
        }
    }
</script>

{{--xử lý hiện ảnh ở tệp đính kèm--}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Lấy tất cả các ảnh có class thumbnail
        var thumbnails = document.querySelectorAll('.thumbnail');
        var modalImage = document.getElementById('modalImage');
        var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));

        // Lặp qua tất cả các ảnh thu nhỏ
        thumbnails.forEach(function (thumbnail) {
            thumbnail.addEventListener('click', function () {
                // Lấy src của ảnh thu nhỏ và gán vào modal ảnh
                modalImage.src = thumbnail.src;

                // Hiển thị modal ảnh
                imageModal.show();

                // Lấy id của modal task chính từ thuộc tính data-modal-id của ảnh
                var taskModalId = thumbnail.getAttribute('data-modal-id');
                var taskModal = new bootstrap.Modal(document.getElementById(taskModalId), {});

                // Hàm xử lý khi modal ảnh đóng
                function handleModalClose() {
                    taskModal.show();
                    // Gỡ bỏ sự kiện này để nó không bị gọi lại khi đóng modal ảnh
                    document.getElementById('imageModal').removeEventListener('hidden.bs.modal', handleModalClose);
                }

                // Lắng nghe sự kiện modal ảnh bị đóng và mở lại modal task
                document.getElementById('imageModal').addEventListener('hidden.bs.modal', handleModalClose);
            });
        });
    });

</script>
