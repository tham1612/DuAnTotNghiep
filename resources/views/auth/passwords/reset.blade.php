@extends('layouts.master')

@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="index.html" class="d-inline-block auth-logo">
                                <img src="assets/images/logo-light.png" alt="" height="20">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Create new password</h5>
                                <p class="text-muted">Your new password must be different from previous used
                                    password.</p>
                            </div>

                            <div class="p-2">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                        {{-- @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password"
                                                class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                                onpaste="return false" placeholder="Enter password" id="password-input"
                                                aria-describedby="passwordInput" name="password" required
                                                autocomplete="new-password">

                                            <button
                                                class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none text-muted password-addon"
                                                type="button" id="togglePassword">
                                                <i class="ri-eye-fill align-middle" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="confirm-password-input">Confirm
                                            Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" placeholder="Enter Confirm Password"
                                                class="form-control pe-5 password-input @error('password_confirmation') is-invalid @enderror"
                                                id="confirm-password-input" aria-describedby="confirmPasswordInput"
                                                name="password_confirmation" required autocomplete="new-password">

                                                <button
                                                    class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none text-muted password-addon"
                                                    type="button" id="togglePassword">
                                                    <i class="ri-eye-fill align-middle" id="eyeIcon"></i>
                                                </button>
                                        </div>
                                    </div>

                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13">Password must contain:</h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b>
                                        </p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter
                                            (a-z)</p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b>
                                            letter (A-Z)</p>
                                        <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)
                                        </p>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">Remember
                                            me</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Reset Password</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Wait, I remember my password... <a href="auth-signin-basic.html"
                                class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
