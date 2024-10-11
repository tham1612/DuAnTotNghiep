<h5 class="text-center">Nhãn</h5>
<form action="">
    <input type="text" name="" id=""
           class="form-control border-1" placeholder="Tìm nhãn..."/>
    <div class="mt-3">
        <strong class="fs-14">Nhãn</strong>
        <ul class="" style="list-style: none; margin-left: -32px">
            <li class="mt-1 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center w-100">
                    <input type="checkbox" name="" id="danger_tags"
                           class="form-check-input"/>
                    <span class="bg bg-danger mx-2 rounded p-3 col-10"> </span>
                </div>
                <i class="ri-pencil-line fs-20"></i>
            </li>
            <li class="mt-1 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center w-100">
                    <input type="checkbox" name="" id="danger_tags"
                           class="form-check-input"/>
                    <span class="bg bg-info mx-2 rounded p-3 col-10"> </span>
                </div>
                <i class="ri-pencil-line fs-20"></i>
            </li>
            <li class="mt-1 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center w-100">
                    <input type="checkbox" name="" id="danger_tags"
                           class="form-check-input"/>
                    <span class="bg bg-success mx-2 rounded p-3 col-10">
                                                            </span>
                </div>
                <i class="ri-pencil-line fs-20"></i>
            </li>
        </ul>
    </div>
    <div class="card">
        <div
            class="d-flex align-items-center justify-content-center rounded p-3 text-white w-100"
            style=" height: 30px; background-color: #c7c7c7">
            <p class="ms-2 mt-3 fs-15" data-bs-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false" data-bs-offset="-120,-100">
                Tạo nhãn mới
            </p>
            <!--dropdown nhãn-->
            <div class="dropdown-menu dropdown-menu-md p-3" style="width: 125%">
                @include('dropdowns.createTag')
            </div>
        </div>
    </div>
</form>
