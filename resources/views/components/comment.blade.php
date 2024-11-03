@foreach($comments as $comment)
    @php
        $replyUser = $comments->firstWhere('id', $comment->parent_id);
    @endphp

    <div class="d-flex mt-2 conten-comment-{{$comment->id}}">
        @if ($comment->user->image)
            <img class="rounded header-profile-user object-fit-cover"
                 src="{{ asset('storage/' . $comment->user->image) }}"
                 alt="Avatar"/>
        @else
            <div
                class="bg-info-subtle rounded d-flex justify-content-center align-items-center"
                style="width: 40px;height: 40px">
                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
            </div>
        @endif
        <section class="ms-2 w-100">
            <strong>{{$comment->user->name}}</strong>
            @php
                $createdAt = \Carbon\Carbon::parse($comment->created_at);
                $now = \Carbon\Carbon::now();
                $diffInHours = $createdAt->diffInHours($now);
                \Carbon\Carbon::setLocale('vi');


            @endphp

            @if ($diffInHours < 24)
                <span class="fs-11">{{ $createdAt->diffForHumans() }}</span>

            @else
                <span
                    class="fs-11">{{ $createdAt->format('H:i j \t\h\g m, Y') }}</span>
            @endif
            <div

                class="bg-info-subtle p-1 rounded ps-2 " id="1content-coment-{{$comment->id}}">
                @if(!empty($replyUser))
                    <div
                        class="badge border rounded  align-items-center "
                        style=" background-color:  #4A90E2">@
                        {{$replyUser->user->name}}
                    </div>
                @endif
                {!! $comment->content !!}
            </div>
            <div class="">
                <div class="fs-11 d-flex">
                    @if($comment->user->id === Auth::id())
                        <div class="">
                                <span data-bs-toggle="dropdown"
                                      aria-haspopup="true"
                                      aria-expanded="false">Chỉnh sửa</span>
                            <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-update-comemnt-{{$comment->id}} ">
                                <div class="d-flex text-muted">Chỉnh sửa</div>
                                <form class="flex-column"
                                      id="comment_form_{{$taskId}}">
                                              <textarea name="content" class="form-control"
                                                        id="update_comment_{{$comment->id}}">{!! $comment->content !!}
                                                </textarea>
                                    <button type="button"
                                            class="btn btn-primary mt-2"
                                            onclick="updateTaskComment({{$taskId}},{{Auth::id()}},{{$comment->id}})">
                                        Lưu
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="">
                                <span data-bs-toggle="dropdown"
                                      aria-haspopup="true"
                                      aria-expanded="false">Trả lời</span>
                            <div class="dropdown-menu dropdown-menu-md p-3 dropdown-menu-reply-comemnt-{{$comment->id}} ">
                                <div class="d-flex text-muted"><i class=" ri-arrow-go-forward-fill"></i><h5 class="text-center text-muted "> {{$comment->user->name}}</h5></div>
                                <form class="flex-column"
                                      id="comment_form_{{$taskId}}">
                                              <textarea name="content" class="form-control"
                                                        id="reply_comment_{{$comment->id}}"
                                                        placeholder="Trả lời bình luận"></textarea>
                                    <button type="button"
                                            class="btn btn-primary mt-2"
                                            onclick="addReplyTaskComment({{$taskId}},{{Auth::id()}},{{$comment->id}})">
                                        Lưu
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{--                        @php $userOwner = $board->members->firstWhere('pivot.authorize', 'Owner');  @endphp--}}
                    @if(auth()->id()===$comment->user->id || auth()->id()=== $userOwner->id )
                        <span class="mx-1">-</span>
                        <span data-bs-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false">Xóa</span>
                        <div class="dropdown-menu dropdown-menu-md p-3 w-50">
                            <h5 class="text-center">Bạn có muốn xóa bình
                                luận</h5>
                            <p>Bình luận sẽ bị xóa vĩnh viễn và không thể khôi
                                phục</p>
                            <button class="btn btn-danger w-100"
                                    onclick="removeComment({{$comment->id}})">
                                Xóa bình luận
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

@endforeach

