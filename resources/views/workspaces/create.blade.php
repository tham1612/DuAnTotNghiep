@extends('layouts.masterhome')
@section('title')
    Workspace - TaskFlow
@endsection
@section('main')

    <div class="modal fade" id="workspaceModal" tabindex="-1" aria-labelledby="workspaceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 75%; height: 80vh;">
            <div class="modal-content border-0 rounded-3" style="height: 100%;">

                <div class="modal-header p-4">
                </div>

                <div class="modal-body" style="height: calc(100% ); ">
                    <h3 class="modal-title" id="workspaceModalLabel">Hãy xây dựng một Không gian làm việc</h3>

                    <div class="row h-100">

                        <div class="col-md-6 p-4 d-flex flex-column justify-content-between">
                            <form method="POST" action="{{route('workspaces.store')}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="workspaceName" class="form-label">Tên Không gian làm việc</label>
                                    <input type="text" id="workspaceName" class="form-control" placeholder="tên Workspace" name="name">
                                </div>

                                <div class="mb-4">
                                    <label for="workspaceDescription" class="form-label">Mô tả Không gian làm việc </label>
                                    <textarea id="workspaceDescription" class="form-control" rows="4"
                                              placeholder="Mô tả thêm về workspace của bạn ." name="description"></textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block" id="continueButton" disabled>Tiếp tục</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 d-flex justify-content-center  p-4">
                            <img src="{{ asset('theme/assets/images/small/img-7.jpg') }}" alt="Illustration" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        const workspaceNameInput = document.getElementById('workspaceName');
        const continueButton = document.getElementById('continueButton');


        function validateForm() {
            const isNameFilled = workspaceNameInput.value.trim() !== '';
            continueButton.disabled = !isNameFilled;
        }


        workspaceNameInput.addEventListener('input', validateForm);


        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('workspaceModal'), {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show();
        });
    </script>

@endsection
