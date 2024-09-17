<div class="modal fade" id="workspaceModal" tabindex="-1" aria-labelledby="workspaceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 70%; height: 60vh;">
        <div class="modal-content border-0 rounded-3" style="height: 100%;">

            <div class="modal-header p-4">
            </div>

            <div class="modal-body" style="height: calc(100% ); ">

                <div class="row">
                    <form method="POST" action="{{route('workspaces.store')}}"
                          class="col-6 d-flex flex-column justify-content-between">
                        <h3 class="modal-title fw-bold" id="workspaceModalLabel">Hãy xây dựng một Không gian làm
                            việc</h3>
                        <p class="fs-15">Tăng năng suất của bạn bằng cách giúp mọi người dễ dàng truy cập bảng ở một
                            vị
                            trí.</p>

                        @csrf
                        <div class="mb-3 mt-3">
                            <label for="workspaceName" class="form-label">Tên Không gian làm việc</label>
                            <input type="text" id="workspaceName" class="form-control"
                                   placeholder="tên Workspace" name="name">
                        </div>

                        <div class="mb-4">
                            <label for="workspaceDescription" class="form-label">Mô tả Không gian làm
                                việc </label>
                            <textarea id="workspaceDescription" class="form-control" rows="4"
                                      placeholder="Mô tả thêm về không gian làm việc của bạn ."
                                      name="description"></textarea>
                            <p class="mt-2">Đưa các thành viên của bạn vào bảng với mô tả ngắn về Không gian làm
                                việc của
                                bạn.</p>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block" id="continueButton"
                                    disabled>Tiếp tục
                            </button>
                        </div>
                    </form>


                    <div class="col-6 rounded"
                         style="background: url({{ asset('theme/assets/images/small/img-7.jpg') }});height:500px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>--}}

<script>
    const workspaceNameInput = document.getElementById('workspaceName');
    const continueButton = document.getElementById('continueButton');


    function validateForm() {
        const isNameFilled = workspaceNameInput.value.trim() !== '';
        continueButton.disabled = !isNameFilled;
    }

    workspaceNameInput.addEventListener('input', validateForm);


    // document.addEventListener('DOMContentLoaded', function () {
    //     var myModal = new bootstrap.Modal(document.getElementById('workspaceModal'), {
    //         // backdrop: 'static',
    //         keyboard: false
    //     });
    //     myModal.show();
    // });
</script>
