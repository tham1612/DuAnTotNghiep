@extends('layouts.master')
@section('title')
Quên mật khẩu
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
                                <h5 class="text-primary">Quên mật khẩu?</h5>
                                <p class="text-muted">Đặt lại mật khẩu bằng email</p>
                                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                    colors="primary:#0ab39c" class="avatar-xl"></lord-icon>
                            </div>
                            @if (session('status'))
                                <div class="alert border-0 alert-success text-center mb-2 mx-2" role="alert">
                                    {{ session('status') }}
                                </div>
                            @else
                                <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                                    Nhập email của bạn và hướng dẫn sẽ được gửi cho bạn!
                                </div>
                            @endif
                            <div class="p-2">
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <input id="email" type="email"
                                            class="form-control" name="email" placeholder="Nhập email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        {{-- @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}
                                    </div>

                                    <div class="text-center mt-4">
                                        <button class="btn btn-success w-100" type="submit">Gửi email</button>
                                    </div>
                                </form><!-- end form -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Tôi đã nhớ mật khẩu ...<a href="{{ route('login') }}"
                                class="fw-semibold text-primary text-decoration-underline">Đăng nhập </a>
                        </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
