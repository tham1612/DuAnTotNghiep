<h5 class="text-center">Nhãn</h5>
<form action="">
    <input type="text" name="" id=""
           class="form-control border-1" placeholder="Tìm nhãn..."/>
    <div class="mt-3">
        <strong class="fs-14">Nhãn</strong>
        <ul class=""  data-simplebar style="list-style: none; margin-left: -32px; max-height: 200px;" id="danh-sach-tag-{{$board->id}}">
            @foreach($board->tags as $tag)
                @php  $tag = json_decode(json_encode($tag)); @endphp
                <li class="mt-1 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <input type="checkbox" @checked(collect($task->tags)->pluck('id')->contains($tag->id))
                        class="form-check-input-tag" value="{{$task->id}}-{{$tag->id}}"/>
                        <span class=" mx-2 rounded p-2 col-10 text-white"
                              style="background-color: {{$tag->color_code}}">{{$tag->name}} </span>
                    </div>
                    <i class="ri-pencil-line fs-20 cursor-pointer" data-bs-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false"></i>

{{--                    <div class="dropdown-menu dropdown-menu-md p-3 border-2" style="width: 110%">--}}
{{--                        <h5 class="text-center">Cập nhật</h5>--}}
{{--                        <form>--}}
{{--                            <input type="hidden" name="board_id" value="{{$tag->board_id}}">--}}
{{--                            <div class="mt-3">--}}
{{--                                <label for="">Tiêu đề</label>--}}
{{--                                <input type="text" name="name" class="form-control border-1"--}}
{{--                                       placeholder="Nhập tên nhãn" value="{{$tag->name}}"/>--}}
{{--                            </div>--}}
{{--                            <div class="mt-3">--}}
{{--                                <label class="fs-14">Chọn màu</label>--}}
{{--                                <div class="d-flex flex-wrap gap-2 select-color">--}}
{{--                                    @if(isset($colors))--}}
{{--                                        @foreach($colors as $color)--}}
{{--                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover"--}}
{{--                                                 data-bs-placement="top"--}}
{{--                                                 title="{{$color->name}}">--}}
{{--                                                <div--}}
{{--                                                    class="color-box border rounded @if($color->code == $tag->color_code) selected-tag @endif"--}}
{{--                                                    style="width: 50px;height: 30px; background-color: {{$color->code}}">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mt-3">--}}
{{--                                <button class="btn btn-primary" id="update-tag-form">--}}
{{--                                    Cập nhật--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card">
        <div
            class="d-flex align-items-center justify-content-center rounded p-3  w-100"
            style=" height: 30px; background-color: #091e420f; color: #172b4d">
            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false" data-bs-offset="-120,-100">
                Tạo nhãn mới
            </p>
            <!--dropdown nhãn-->
            <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-creat-tag" style="width: 125%">
                @include('dropdowns.createTag')
            </div>
        </div>
    </div>
</form>
