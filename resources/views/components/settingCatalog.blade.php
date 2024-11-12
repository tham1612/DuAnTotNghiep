<div class="modal fade"
     id="detailCardModalCatalog{{ $catalog->id }}" tabindex="-1"
     aria-labelledby="create-board-home-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header p-3 d-grid" style="grid-template-columns: 1fr auto 1fr;">
                <span></span> <!-- Khoảng trống để đẩy tiêu đề ra giữa -->
                <h5 class="modal-title " id="create-board-home-modal-label">
                    Cài đặt danh sách
                </h5>
                <button type="button" class="btn-close" id="btn-close-member" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center"
                                 role="tablist" aria-orientation="vertical">
                                <a class="nav-link active show" id="create-task-catalog-tab{{ $catalog->id }}"
                                   data-bs-toggle="pill"
                                   href="#create-task-catalog{{ $catalog->id }}" role="tab"
                                   aria-controls="create-task-catalog{{ $catalog->id }}"
                                   aria-selected="true">
                                    Chỉnh sửa
                                </a>
                                <a class="nav-link" id="copy-catalog-tab{{ $catalog->id }}" data-bs-toggle="pill"
                                   href="#copy-catalog{{ $catalog->id }}" role="tab"
                                   aria-controls="copy-catalog{{ $catalog->id }}"
                                   aria-selected="false">
                                    Sao chép danh sách
                                </a>
                                <a class="nav-link" id="move-catalog-tab{{ $catalog->id }}" data-bs-toggle="pill"
                                   href="#move-catalog{{ $catalog->id }}" role="tab"
                                   aria-controls="move-catalog{{ $catalog->id }}"
                                   aria-selected="false">
                                    Di chuyển danh sách
                                </a>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-lg-9">
                            <div class="tab-content text-muted mt-3 mt-lg-0">
                                <div class="tab-pane fade active show" id="create-task-catalog{{ $catalog->id }}"
                                     role="tabpanel"
                                     aria-labelledby="create-task-catalog-tab{{ $catalog->id }}">
                                    <div class="">
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-outline-primary"
                                                    onclick="archiverCatalog({{ $catalog->id }})"> Lưu Trữ danh sách
                                            </button>
                                            <button class="btn btn-outline-primary"
                                                    onclick="archiverAllTasks({{ $catalog->id }})"> Lưu trữ tất cả
                                                thẻ trong danh
                                                sách
                                            </button>
                                        </div>
                                        <form class="row mt-3 submitFormUpdateCatalog">
                                            <label>Tên bảng</label>
                                            <textarea name="name" id=""
                                                      class="form-control mb-2 nameUpdateTask">{{$catalog->name}}</textarea>
                                            <input type="hidden" name="id" class="id" value="{{$catalog->id}}">
                                            <button class="btn btn-primary">Lưu</button>
                                        </form>

                                    </div>

                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane fade" id="copy-catalog{{ $catalog->id }}" role="tabpanel"
                                     aria-labelledby="copy-catalog-tab{{ $catalog->id }}">
                                    <form class="row submitFormCopyCatalog">
                                        <label>Tên bảng</label>
                                        <textarea name="name" id=""
                                                  class="form-control mb-2 nameCopyTask">{{$catalog->name}} sao chép</textarea>
                                        <input type="hidden" name="id" class="id" value="{{$catalog->id}}">
                                        <button class="btn btn-primary">Tạo danh sách</button>
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane fade" id="move-catalog{{ $catalog->id }}" role="tabpanel"
                                     aria-labelledby="move-catalog-tab{{ $catalog->id }}">
                                    <form class="row submitFormMoveCatalog">
                                        <label>Bảng thông tin</label>
                                        <textarea name="name" id=""
                                                  class="form-control mb-2 nameMoveTask"
                                                  placeholder="Nhập tên danh sách">{{$catalog->name}}</textarea>
                                        <select name="board_id" id="" class="form-select mb-3">
                                            @php
                                                $userId = \Illuminate\Support\Facades\Auth::id();
                                                $workspace = \App\Models\Workspace::query()
                                                      ->with(['boards' => function ($query) use ($userId) {
                                                          $query->whereHas('boardMembers', function ($q) use ($userId) {
                                                              $q->where('user_id', $userId);
                                                          });
                                                      }])
                                                      ->findOrFail(session('board')->workspace_id);
                                            @endphp
                                            @foreach($workspace->boards as $board)
                                                <option value="{{$board->id}}"
                                                    @selected($catalog->board->id == $board->id)>{{$board->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id" class="id" value="{{$catalog->id}}">
                                        <button class="btn btn-primary">Di chuyển danh sách</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
