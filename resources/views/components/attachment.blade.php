<div class="row mt-3" id="attachment-section-{{$task->id}}"
     style="{{ count($task->attachments) ? '' : 'display: none;' }}">
    <section class="d-flex">
        <i class="ri-link-m fs-22"></i>
        <p class="fs-18 ms-2 mt-1">Tệp đính kèm</p>
    </section>
    @if(false)
        <div class="ps-4">
            <strong>Thẻ tên dự án</strong>
            <div class="d-flex flex-wrap row mt-2" style="align-items: start">
                <!-- start card -->
                <div class="col-6">
                    <div class="card card-height-100">
                        <div class="card-body">
                            <div class="d-flex flex-column h-100">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted"></p>
                                    </div>
                                    <!--   cài đặt thẻ link-->
                                    <div class="flex-shrink-0">
                                        <div
                                            class="d-flex gap-1 align-items-center">
                                            <i class="ri-more-fill fs-20 cursor-pointer"
                                               data-bs-toggle="dropdown"
                                               aria-haspopup="true"
                                               aria-expanded="false"></i>
                                            <div
                                                class="dropdown-menu dropdown-menu-md"
                                                style="padding: 15px 15px 0 15px">
                                                <h5 class="text-center">Thao tác
                                                    mục</h5>
                                                <p class="mt-2">liên kết thẻ</p>
                                                <p>Xóa</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="d-flex mb-2 rounded bg-info-subtle p-2">
                                    <div class="flex-grow-1">
                                        <h5>Tên thẻ</h5>
                                        <div class="d-flex">
                                                                    <span class="badge bg-success me-1">giao
                                                                        diện</span>
                                            <span
                                                class="badge bg-danger">code khó</span>
                                        </div>
                                        <div
                                            class="mt-3 d-flex justify-content-between">
                                            <div class="avatar-group">
                                                <a href="javascript: void(0);"
                                                   class="avatar-group-item border-0"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-trigger="hover"
                                                   data-bs-placement="top"
                                                   title="Darline Williams">
                                                    <div class="avatar-xxs">
                                                        <img
                                                            src="{{ asset('theme/assets/images/users/avatar-2.jpg') }}"
                                                            alt=""
                                                            class="rounded-circle img-fluid"/>
                                                    </div>
                                                </a>

                                            </div>
                                            <ul class="link-inline mb-0">
                                                <!-- theo dõi -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)"
                                                       class="text-muted"><i
                                                            class="ri-eye-line align-bottom"></i>
                                                        04</a>
                                                </li>
                                                <!-- bình luận -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)"
                                                       class="text-muted"><i
                                                            class="ri-question-answer-line align-bottom"></i>
                                                        19</a>
                                                </li>
                                                <!-- tệp đính kèm -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)"
                                                       class="text-muted"><i
                                                            class="ri-attachment-2 align-bottom"></i>
                                                        02</a>
                                                </li>
                                                <!-- checklist -->
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0)"
                                                       class="text-muted"><i
                                                            class="ri-checkbox-line align-bottom"></i>
                                                        2/4</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                        <div
                            class="card-footer bg-transparent border-top-dashed py-2">
                            <div class="flex-grow-1">Tên bảng : Tên list</div>
                        </div>
                        <!-- end card footer -->
                    </div>
                    <!-- end card -->
                </div>

            </div>

        </div>
    @endif
    <div class="ps-4">
        <strong>Tệp </strong>
        <div
            class="table-responsive table-hover table-card attachments-container"
            style="max-height: 400px; overflow-y: auto;">
            <table class="table table-nowrap mt-4">
                <tbody id="list-attachment-task-{{$task->id}}">
                @foreach($task->attachments as $attachment)
                    @php
                        $now = \Carbon\Carbon::now();

                          $attachmentDate = $attachment->created_at ? \Carbon\Carbon::parse($attachment->created_at) : null;
                          if($attachmentDate && $attachment->year === $now->year){
                              $dateFormat = 'H:i d \t\h\á\n\g m';
                              } else {
                               $dateFormat = 'H:i d \t\h\á\n\g m, Y';
                          }
                          $attachmentDate = $attachmentDate ? $attachmentDate->format($dateFormat) : null;
                    @endphp
                    <tr class="cursor-pointer attachment_{{$attachment->id}} ">
                        <td class="col-1">
                            <img
                                src="{{ asset('storage/' . $attachment->file_name) }}"
                                alt="Attachment Image"
                                class="thumbnail"
                                data-modal-id="exampleModal"
                                style="
                            width: 100px;
                            height: auto;
                            object-fit: cover;
                            border-radius: 8px;
                            ">
                        </td>
                        <td class="text-start name_attachment "
                            id="name_display_{{ $attachment->id }}">
                            <div class="d-flex flex-column">
                                <span>{{ strtoupper(substr($attachment->name, 0, 50)) }}</span>
                                <span> Đã thêm {{$attachmentDate}}</span>
                            </div>

                        </td>
                        <td class="text-end">
                            <i class="ri-more-fill fs-20 cursor-pointer"
                               data-bs-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false"></i>
                            <div class="dropdown-menu dropdown-menu-md"
                                 style="padding: 15px 15px 0 15px">
                                <input type="text" name="name"
                                       class="form-control border-0 text-center fs-16 fw-medium bg-transparent"
                                       id="name_attachment_{{ $attachment->id }}"
                                       value="{{ $attachment->name }}"
                                       onchange="updateTaskAttachment({{ $attachment->id }})"/>

                                <p id="attachment_id_{{ $attachment->id }}"
                                   class="cursor-pointer text-danger"
                                   onclick="deleteTaskAttachment({{ $attachment->id }},{{$task->id}})">
                                    Xóa</p>

                            </div>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal phóng to ảnh -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true"
     style="z-index: 1060">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content d-flex justify-content-center align-items-center bg-warning">
            <img id="modalImage" style="width: 150vh; height: 90vh" src="" alt="Phóng to ảnh">
        </div>
    </div>
</div>
