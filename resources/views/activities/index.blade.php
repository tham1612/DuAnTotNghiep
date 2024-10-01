{{-- @extends('layouts.masterMain')
@section('main')

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel"
    style="width: 350px;"
>
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-center" id="offcanvasRightLabel">
            Hoạt Động
        </h5>
        <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body p-0 overflow-hidden">
        <div data-simplebar style="height: calc(100vh - 112px)">
            <ul style="list-style: none;" class="p-3">
                @foreach ($activities as $activity)
                    <li class="mb-3 d-flex align-items-start">
                        <!-- Avatar người thực hiện hoạt động -->
                        <div class="me-3">
                            <img src="{{ asset('path_to_avatar/'.$activity->causer->avatar ?? 'default_avatar.png') }}" alt="avatar" class="rounded-circle" width="40" height="40">
                        </div>
                        <!-- Nội dung hoạt động -->
                        <div class="activity-content">
                            <p class="mb-1">
                                <strong>{{ $activity->causer ? $activity->causer->name : 'Hệ thống' }}:</strong>
                                {{ $activity->description }}
                            </p>
                            <!-- Thời gian hoạt động -->
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection --}}
