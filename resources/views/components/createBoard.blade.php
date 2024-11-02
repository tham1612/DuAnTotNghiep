<!-- chia sẻ bảng & thêm thành viên -->
<div class="modal fade"
     id="{{ 'create-board-home-modal' ? 'create-board-home-modal' : 'create-board-template-home-modal' }}" tabindex="-1"
     aria-labelledby="create-board-home-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header p-3 d-grid" style="grid-template-columns: 1fr auto 1fr;">
                <span></span> <!-- Khoảng trống để đẩy tiêu đề ra giữa -->
                <h5 class="modal-title " id="create-board-home-modal-label">
                    Tạo bảng
                </h5>
                <button type="button" class="btn-close" id="btn-close-member" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin-top: -50px">
                @php
                    $userId = \Illuminate\Support\Facades\Auth::id();

                    $workspace = \App\Models\Workspace::query()
                        ->whereHas('users', function ($query) use ($userId) {
                            $query->where('user_id', $userId)->where('is_active', 1);
                        })
                        ->get();

                @endphp
                <form class="formItem" action="{{ route('b.store') }}" method="POST" onsubmit="disableButtonOnSubmit()">
                    @csrf

                    <div class="mt-3">
                        <label for="" class="form-label">Tiêu đề bảng<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('board.name') is-invalid @enderror"
                               id="boardName" placeholder="Nhập tiêu đề bảng" value="{{ old('board.name') }}"
                               name="name" />
                        @error('board.name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Không gian làm việc</label>
                        <select name="workspace_id" id="" class="form-select">
                            @foreach ($workspace as $workspace1)
                                <option value="{{ $workspace1->id }}">{{ $workspace1->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Quyền xem</label>
                        <select name="access" id="" class="form-select">
                            @foreach (\App\Enums\AccessEnum::getLimitedChoices() as $access)
                                <option value="{{ $access }}">
                                    {{ \App\Enums\AccessEnum::coerce($access)->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3 card">
                        <button class="btn btn-primary" type="submit" disabled>Tạo mới</button>
                    </div>
                    <!--end col-->
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.formItem');

        forms.forEach((form) => {
            const textInput = form.querySelector('input[type="text"]');
            const submitButton = form.querySelector('button[type="submit"]');

            if (textInput && submitButton) {
                // Kiểm tra trạng thái của input để enable/disable button
                textInput.addEventListener('input', function() {
                    const isFilled = textInput.value.trim() !== '';
                    console.log(`Input value: "${textInput.value}", Is filled: ${isFilled}`);
                    submitButton.disabled = !isFilled;
                });

                // Xử lý khi button được nhấn
                submitButton.addEventListener('click', function(event) {
                    disableButtonOnSubmit(event, textInput, submitButton);
                });
            }
        });

        function disableButtonOnSubmit(event, input, button) {
            event.preventDefault();
            if (button.disabled) return;

            button.disabled = true;
            event.target.closest('form').submit();
            input.value = '';

            setTimeout(() => {
                button.disabled = false;
            }, 3000);
        }
    });
</script>
