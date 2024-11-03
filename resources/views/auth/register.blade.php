@extends('layouts.master')
@section('title')
    Đăng kí
@endsection
@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="#" class="d-inline-block auth-logo">
                                <img src="{{ asset('theme/assets/images/logo-light.png') }}" alt="" height="50">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">TaskFlow - quản lí công viêc</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Tạo tài khoản mới.</h5>
                                <p class="text-muted">Đăng kí tài khoản TaskFlow miễn phí ngay bây giờ.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input id="useremail" type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="useremail"
                                            placeholder="Nhập email" name="email" value="{{ old('email') }}"
                                            required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Tên đăng nhập <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="username" placeholder="Nhập tên đăng nhập" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Mật khẩu</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password"
                                                class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                                onpaste="return false" placeholder="Nhập mật khẩu" id="password-input"
                                                aria-describedby="passwordInput" name="password" required
                                                autocomplete="new-password">

                                            <button
                                                class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none text-muted password-addon"
                                                type="button" id="togglePassword">
                                                <i class="ri-eye-fill align-middle" id="eyeIcon"></i>
                                            </button>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="confirm-password-input">Xác nhận mật khẩu</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" placeholder="Nhập xác nhận mật khẩu"
                                                class="form-control pe-5 password-input @error('password_confirmation') is-invalid @enderror"
                                                id="confirm-password-input" aria-describedby="confirmPasswordInput"
                                                name="password_confirmation" required autocomplete="new-password">

                                            <button
                                                class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none text-muted password-addon"
                                                type="button" id="togglePassword">
                                                <i class="ri-eye-fill align-middle" id="eyeIcon"></i>
                                            </button>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Đăng kí</button>
                                    </div>
{{--
                                    <div class="mt-4 text-center">
                                        <div>
                                            <button type="button"
                                                class="btn btn-primary btn-icon waves-effect waves-light"><i
                                                    class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button"
                                                class="btn btn-danger btn-icon waves-effect waves-light"><i
                                                    class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i
                                                    class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i
                                                    class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div> --}}
                                </form>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Bạn đã có tài khoản ? <a href="{{ route('login') }}"
                                class="fw-semibold text-primary text-decoration-underline">
                                Đăng nhập</a></p>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
