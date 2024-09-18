<!-- chia sẻ bảng & thêm thành viên -->
<div
    class="modal fade"
    id="{{"create-board-home-modal" ? "create-board-home-modal" : "create-board-template-home-modal" }}"
    tabindex="-1"
    aria-labelledby="create-board-home-modal-label"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content border-0" style="width: 125%;">
            <div class="modal-header p-3 d-grid" style="grid-template-columns: 1fr auto 1fr;">
                <span></span> <!-- Khoảng trống để đẩy tiêu đề ra giữa -->
                <h5 class="modal-title " id="create-board-home-modal-label">
                    Tạo bảng
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    id="btn-close-member"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body" style="margin-top: -50px">
                @php
                    $userId = \Illuminate\Support\Facades\Auth::id();
                    $workspaces = \App\Models\Workspace::query()

                    ->whereHas('users', function ($query) use ($userId) {
                          $query
                          ->where('user_id', $userId)
                              ->whereIn('authorize', ['Owner', 'Member']);
                      })->get();
                @endphp
                <form class="p-3" action="{{route('b.store')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mt-3">
                        <label for="" class="form-label">Tiêu đề bảng<span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="title-board"
                            placeholder="Nhập tiêu đề bảng"
                            autofocus
                            name="name"
                        />
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Không gian làm việc</label>
                        <select name="workspace_id" id="" class="form-select">
                            <option value="">---lựa chọn ---- </option>
                            @foreach($workspaces as $workspace)
                                <option value="{{$workspace->id}}">{{$workspace->name}}</option>
                            @endforeach


                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Quyền xem</label>
                        <select name="access" id="" class="form-select">
                            @foreach(\App\Enums\AccessEnum::getLimitedChoices() as $access)
                                <option value="{{ $access }}">
                                    {{ \App\Enums\AccessEnum::coerce($access)->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3 card">
                        <button class="btn btn-primary">Tạo mới</button>
                    </div>
                    <!--end col-->
                </form>
            </div>
        </div>
    </div>
</div>
