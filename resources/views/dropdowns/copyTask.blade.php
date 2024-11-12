<h5 class="text-center">Sao chép thẻ</h5>
<form class="submitFormCopyTask">
    <div>
        <strong class="fs-14">Tên</strong>
        <input type="text" name="text" id=""
               class="form-control border-1 my-2 nameCopyTask" value="{{$task->text}} sao chép" placeholder="Tên thẻ"/>
    </div>
    <div>
        <strong class="fs-14 mt-3">Giữ</strong>
        <ul style="list-style: none; margin-left: -32px" class="mt-2">
            <li>
                <input type="checkbox" name="isCheckList" id=""
                       class="form-check-input" checked value="true"/>
                <label for="">Việc cần làm</label>
            </li>
            <li>
                <input type="checkbox" name="isAttachment" id=""
                       class="form-check-input" checked value="true"/>
                <label for="">Tệp đính kèm</label>
            </li>
        </ul>
    </div>
    <div>
        <strong class="fs-14">Sao chép tới...</strong>
        <div class="mt-2">
            <strong class="fs-16">Bảng thông tin</strong>
            <select name="toBoard" id="toBoard" class="form-select toBoard">
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
                @foreach($workspace->boards as $boards)
                    <option value="{{ $boards->id }}"
                        @selected($boards->id === request()->route('id'))
                    >
                        {{ $boards->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="row mt-2">
            <section class="col-12">
                <strong class="fs-16">Danh sách</strong>
                <select name="catalog_id" id="toCatalog" class="form-select toCatalog">
                    @foreach ($board->catalogs as $catalogs)
                        <option value="{{ $catalogs->id }}" data-task-count="{{ $catalogs->tasks->count() }}"
                            @selected($catalogs->id === $task->catalog_id)>
                            {{ $catalogs->name }}
                        </option>
                    @endforeach
                </select>
            </section>
        </div>
    </div>
    <input type="hidden" name="id" value="{{$task->id}}">
    <div class="mt-3 d-grid">
        <button class="btn bg-primary text-white">Tạo thẻ</button>
    </div>
</form>
