<h5 class="text-center">Nhãn</h5>
<form action="">
{{--    <input type="text" name="" id=""--}}
{{--           class="form-control border-1" placeholder="Tìm nhãn..."/>--}}
    <div class="mt-3">
        <strong class="fs-14">Nhãn</strong>
        <ul class="" data-simplebar style="list-style: none; margin-left: -32px; max-height: 200px;"
            id="danh-sach-tag-{{$boardId}}">
            @foreach($tags as $tag)
                <li class="mt-1 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <input type="checkbox" {{ $tag->isChecked ? 'checked' : '' }}
                        class="form-check-input-tag" value="{{$taskId}}-{{$tag->id}}"/>
                        <span class=" mx-2 rounded p-2 col-11 text-white"
                              style="background-color: {{$tag->color_code}}">{{$tag->name}} </span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card">
        <div
            class="d-flex align-items-center justify-content-center rounded p-3  w-100"
            style=" height: 30px; background-color: #091e420f; color: #172b4d">
            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
               onclick="loadFormCreateTag({{ $taskId }})"
               aria-expanded="false" data-bs-offset="-120,-100" id="dropdownToggle_{{ $taskId }}">
                Tạo nhãn mới
            </p>
            <!--dropdown nhãn-->
            <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-creat-tag" style="width: 125%"
                 id="dropdown-create-tag-{{ $taskId }}">
                {{--                dropdowns.createTag--}}
            </div>
        </div>
    </div>
</form>
