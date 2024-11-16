{{-- @foreach ($board->catalogs as $catalog) --}}
<div class="modal fade"
     id="detailCardModalCatalog" tabindex="-1"
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
            <div class="modal-body modal-setting-catalog">
{{--                {{--                        modalSettingCatalog      --}}
            </div>
        </div>
    </div>
</div>
{{-- @endforeach --}}
