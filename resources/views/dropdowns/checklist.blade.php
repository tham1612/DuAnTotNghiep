<h5 class="mb-3" style="text-align: center">Thêm danh sách công việc</h5>
<form class="taskFormAdd formItem" data-task-id="{{ $taskId }}">
    <div class="mt-2">
        <label class="form-label" for="name_checkList_{{ $taskId }}">Tiêu đề</label>
        <input type="text" class="form-control name_checkList" id="name_checkList_{{ $taskId }}"
            placeholder="Việc cần làm" required />
    </div>
    <div class="mt-2">
        <button type="button" class="btn btn-primary create_checkList"
            onclick="submitAddCheckList({{ $taskId }}, this)" disabled>
            Thêm
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Enable button based on input
        $(document).on('input', '.name_checkList', function() {
            const button = $(this).closest('.taskFormAdd').find('.create_checkList');
            button.prop('disabled', $(this).val().trim() === '');
        });
    });

    let isSubmitting = false;

    function submitAddCheckList(taskId, button) {
        if (isSubmitting) return; // Prevent multiple submissions
        isSubmitting = true; // Mark as submitting

        const form = $(button).closest('.taskFormAdd');
        const name = form.find('.name_checkList').val();

        if (!name.trim()) {
            alert('Tiêu đề không được để trống!');
            isSubmitting = false; // Reset flag
            return false;
        }

        $(button).prop('disabled', true); // Disable button

        const formData = {
            task_id: taskId,
            name: name,
            method: 'POST'
        };

        $.ajax({
            url: `/tasks/checklist/create`,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle success
                form.hide(); // Hide form
                form.find('.name_checkList').val(''); // Clear input
                // Additional code to update UI with the new checklist item
                console.log('Checklist added successfully!', response);
            },
            error: function(xhr) {
                alert('Đã xảy ra lỗi!');
                console.log(xhr.responseText);
            },
            complete: function() {
                $(button).prop('disabled', false); // Re-enable button
                isSubmitting = false; // Reset flag
            }
        });

        return false;
    }
</script>
