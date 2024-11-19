@extends('layouts.masterMain')

@section('main')
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="{{ asset('theme/assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt=""/>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                @if (auth()->user()->image)
                                    <img class="rounded-circle avatar-xl img-thumbnail user-profile-imager object-fit-cover"
                                         src="{{asset('storage/' . auth()->user()->image)}}"
                                         alt="Avatar"/>
                                @else
                                    <div class="bg-info-subtle rounded d-flex justify-content-center align-items-center fs-20"
                                         style="width: 80px;height: 80px">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input type="file" name="image"
                                           class="profile-img-file-input @error('image') is-invalid @enderror"
                                           id="image"
                                           placeholder="Image">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for="image" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Liên kết mạng xã hội </h5>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 bg-primary">
                                    <i class="ri-global-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="websiteInput" placeholder="www.facebook.com">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 bg-success">
                                    <i class="ri-dribbble-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="dribbleName" placeholder="Username">
                        </div>
                        <div class="d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 bg-danger">
                                    <i class="ri-pinterest-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="pinterestName" placeholder="Username">
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i>Thông tin người dùng
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('users.update', $user->id) }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Họ và tên:</label>
                                                <input type="text"
                                                       class="form-control  @error('fullName') is-invalid @enderror"
                                                       name="fullName" id="fullName" placeholder="Enter your fullname"
                                                       value="{{ old('fullName', $user->fullName) }}">
                                                @error('fullName')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Tên:</label>
                                                <input type="text" name="name"
                                                       class="form-control  @error('name') is-invalid @enderror "
                                                       id="name" placeholder="Enter your name"
                                                       value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Số điện thoại:</label>
                                                <input type="text"
                                                       class="form-control  @error('phone') is-invalid @enderror "
                                                       name="phone" id="phone" placeholder="Enter your phone number"
                                                       value="{{ old('phone', $user->phone) }}">
                                                @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email"
                                                       class="form-control  @error('email') is-invalid @enderror "
                                                       id="email" placeholder="Enter your email" name="email"
                                                       value="{{ old('email', $user->email) }}" disabled>
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Địa chỉ:</label>
                                                <input type="text"
                                                       class="form-control  @error('address') is-invalid @enderror "
                                                       placeholder="Enter your address" name="address"
                                                       id="address" value="{{ old('address', $user->address) }}">
                                                @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="social_name"
                                                       class="form-label  @error('social_name') is-invalid @enderror">Tên mạng xã hội:</label>
                                                <input type="text" class="form-control" name="social_name"
                                                       id="social_name" placeholder="PH33245 Đinh Thị Minh Nguyệt"
                                                       value="{{ old('social_name', $user->social_name) }}"/>
                                                @error('social_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 pb-2">
                                                <label for="introduce" class="form-label">Giới thiệu về bản thân:</label>
                                                <textarea name="introduce"
                                                          class="form-control  @error('introduce') is-invalid @enderror"
                                                          id="introduce"
                                                          placeholder="Enter your introduction"
                                                          rows="3">{{ old('introduce', $user->introduce) }}</textarea>
                                                @error('introduce')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-start">
                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

        </div>

    </form>
@endsection