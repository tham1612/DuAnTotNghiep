@extends('layouts.master')
@section('title')
    List - TaskFlow
@endsection
@section('main')
    <div class="auth-page-wrapper auth-bg-cover d-flex justify-content-center align-items-center" style="min-height: 75vh">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <lord-icon class="avatar-xl" src="https://cdn.lordicon.com/etwtznjn.json" trigger="loop"
                                        colors="primary:#405189,secondary:#0ab39c"></lord-icon>
                                    <h1 class="text-primary mb-4">Không có quyền truy cập.</h1>
                                    {{--                                    <h4 class="text-uppercase">Sorry, Page not Found 😭</h4> --}}
                                    <p class="text-muted mb-4">Gửi yêu cầu tới quản trị viên bảng này để có quyền truy
                                        cập. Nếu bạn được chấp thuận tham gia thì bạn sẽ nhận được một email.</p>
                                    <a href="http://127.0.0.1:8000/" class="btn btn-success">
                                        <i class="mdi mdi-home me-1"></i>
                                        Gửi yêu cầu
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
@endsection
