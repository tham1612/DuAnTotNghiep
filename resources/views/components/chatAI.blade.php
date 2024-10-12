@php
    $chats = \App\Models\ChatAI::where('user_id', Auth::id())->get();
@endphp

<div class="offcanvas offcanvas-end" tabindex="-1" id="chatAi" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Chat AI</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="chat-conversation p-3" id="chat-conversation">
            <div id="responseBox" class="pb-3">
                <!-- Hiển thị thông điệp mặc định nếu không có tin nhắn -->
                @if ($chats->isEmpty())
                    <p class="default-message"
                        style="text-align: center; color: #999; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;">
                        Tôi có thể giúp gì được cho bạn?</p>
                @endif

                <!-- Vòng lặp tin nhắn người dùng và phản hồi từ hệ thống -->
                @foreach ($chats as $chat)
                    <div class="user-message mb-3" style="text-align: right; margin-bottom: 10px;">
                        <span
                            style="background-color: #d1e7dd; padding: 8px 12px; border-radius: 15px; display: inline-block; max-width: 300px;">
                            {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($chat->prompt))) !!}
                        </span>
                    </div>

                    <div class="ai-response mb-3" style="margin-bottom: 10px;">
                        <span
                            style="background-color: #f1f1f1; padding: 8px 12px; border-radius: 15px; display: inline-block; max-width: 300px;">
                            {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($chat->response))) !!}
                        </span>
                    </div>
                @endforeach
            </div>
            <!-- Thanh tải sẽ xuất hiện ở đây khi chờ câu trả lời -->
            <div id="loadingSpinner" style="display: none; text-align: center; margin: 10px;" class="pb-3">
                <div class="spinner-border text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer border text-center">
        <div class="chat-input-section p-4">
            <form id="chatinput-form" action="{{ route('store') }}" method="POST">
                @csrf
                <div class="row g-0 align-items-center">
                    <div class="col-auto">
                        <div class="chat-input-links me-2">
                            <div class="links-list-item">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal" id="delete-btn">
                                    <i class=" ri-delete-bin-5-fill align-middle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="chat-input-feedback" id="inputFeedback" style="display: none;">
                            Please Enter a Message
                        </div>
                        <input type="text" class="form-control chat-input bg-light border-light" id="prompt"
                            placeholder="Nhập tin nhắn" name="prompt" autocomplete="off">
                    </div>
                    <div class="col-auto">
                        <div class="chat-input-links ms-2">
                            <div class="links-list-item">
                                <button type="submit" id="sendBtn"
                                    class="btn btn-success chat-send waves-effect waves-light" disabled>
                                    <i class="ri-send-plane-2-fill align-bottom"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon src="https://cdn.lordicon.com/zpxybbhl.json" trigger="loop"
                    colors="primary:#405189,secondary:#0ab39c" style="width:150px;height:150px">
                </lord-icon>
                <div class="mt-3">
                    <h4>Bạn có chắc chắn muốn xóa toàn bộ lịch sử chat không?</h4>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal thông báo thành công -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                    colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>

                <div class="mt-4 pt-3">
                    <h4>Đã xóa thành công lịch sử chat!</h4>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
