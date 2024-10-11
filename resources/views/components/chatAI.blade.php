<div class="offcanvas offcanvas-end" tabindex="-1" id="chatAi" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Chat AI</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="chat-conversation p-3 " id="chat-conversation">
            <div id="responseBox">
                <!-- Tin nhắn của người dùng và phản hồi từ hệ thống sẽ được chèn vào đây -->
                @if (!empty($chats))

                @if ($chats->isEmpty())
                    <p style="text-align: center; color: #999;">No messages yet.</p>
                @else
                    @foreach ($chats as $chat)
                        <div class="user-message" style="text-align: right; margin-bottom: 10px;">
                            <span
                                style="background-color: #d1e7dd; padding: 8px 12px; border-radius: 15px; display: inline-block;">
                                {{ $chat->prompt }}
                            </span>
                        </div>
                        <div class="ai-response" style="margin-bottom: 10px;">
                            <span
                                style="background-color: #f1f1f1; padding: 8px 12px; border-radius: 15px; display: inline-block;">
                                {{ $chat->response }}
                            </span>
                        </div>
                    @endforeach
                @endif
                @endif

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
                                <button type="button" class="btn btn-link text-decoration-none emoji-btn"
                                    id="emoji-btn">
                                    <i class="bx bx-smile align-middle"></i>
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
