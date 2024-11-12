@extends('layouts.masterMain')
@section('title')
    Calendar - TaskFlow
@endsection
@section('main')

    @if(session('error'))
        <div class="alert alert-danger custom-alert">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .custom-alert {
            border-radius: 0.5rem;
            padding: 1rem;
            position: relative;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>

    @if(!\Illuminate\Support\Facades\Auth::user()->access_token)
        <a href="{{route('google.redirect')}}" class="btn btn-ghost-danger">Liên kết Google Calendar</a>
    @endif
    <div class="p-2" data-simplebar style="max-height: 80vh;">
        <div id="calendar"></div>
    </div>
    <input type="hidden" id="emailName" value="{{ Auth()->user()->email }}">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <h4 class="text-center">Tạo task</h4>
                <form>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" name="text" id="text">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Danh sách</label>
                        <select name="catalog_id" id="catalog_id" class="form-select">
                            <option hidden="" value="">---Lựa chọn---</option>
                            @foreach ($board->catalogs as $catalog)
                                <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Ngày bắt đầu</label>
                        <section class="d-flex align-items-center">
                            <input type="checkbox" class="form-check-input me-1" id="active_checkbox">
                            <input type="datetime-local" class="form-control" name="start_date">
                        </section>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Ngày kết thúc</label>
                        <input type="datetime-local" class="form-control" name="end_date">
                    </div>
                    <button class="btn btn-primary">Tạo mới</button>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>

@endsection
@section('script')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-timezone-with-data.min.js"></script>

    <script>
        let startDateInput = document.querySelector('input[name="start_date"]');
        let endDateInput = document.querySelector('input[name="end_date"]');
        let text = document.querySelector('#text');
        let active_checkbox = document.querySelector('#active_checkbox');
        let deteleEvent = document.getElementById('deteleEvent');
        let createEvent = document.getElementById('createEvent');
        let emailName = document.getElementById('emailName');
        let catalog_id = document.getElementById('catalog_id');

        // lấy ra dữ liệu trong db
        var fullCalendars = @json($listEvent);

        $('#calendar').fullCalendar({
            // custom header
            header: {
                'left': 'prev, today, next',
                'center': 'title', // tiêu đề
                'right': ' month , agendaWeek, agendaDay' // tháng, tuần, ngày
            },
            // navLinks: true,
            // eventBackgroundColor: 'pink', // thay đổi màu event
            events: fullCalendars, // hiện thị dữ liệu lên trên giao diện
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDays, event) {
                if (start.add(1, 'day').format('YYYY-MM-DD') === end.format('YYYY-MM-DD')) {
                    // trường hợp chỉ chọn 1 ngày
                    startDateInput.disabled = true;
                    startDateInput.value = '';
                    endDateInput.value = convertTimeString(end.subtract(1, 'days').format(
                        'YYYY-MM-DDTHH:mm'));
                } else {
                    // Trường hợp nhiều ngày
                    startDateInput.value = convertTimeString(start.subtract(1, 'days')
                        .format(
                            'YYYY-MM-DDTHH:mm'));
                    endDateInput.value = convertTimeString(end.subtract(1, 'days')
                        .format(
                            'YYYY-MM-DDTHH:mm'));
                    startDateInput.disabled = false;
                }

                handleDate();
                text.value = '';
                catalog_id.value = '';
                active_checkbox.checked = false; // Reset checkbox
                $('#exampleModal').modal('toggle'); // Hiển thị modal
                $('form').on('submit', function (e) {
                    e.preventDefault(); // Ngăn không cho form gửi đi

                    // Lấy giá trị của các trường Tiêu đề và Danh sách
                    var title = $('#text').val().trim();
                    var catalog = $('#catalog_id').val();

                    // Kiểm tra nếu Tiêu đề để trống hoặc chưa chọn Danh sách
                    if (title === '') {
                        notificationWeb('error', 'Vui lòng nhập tên')
                        return;
                    }

                    if (catalog === '') {
                        notificationWeb('error', 'Vui lòng chọn danh mục')
                        return;
                    }

                    // Nếu không có lỗi, tiến hành gửi AJAX
                    $.ajax({
                        url: '/tasks', // Đổi thành đường dẫn bạn muốn gửi form tới
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            $('#exampleModal').modal('toggle');
                            notificationWeb(response.action, response.msg)
                            text.value = '';
                            catalog_id.value = '';
                            startDateInput.value = '';
                            endDateInput.value = '';
                        },
                        error: function (xhr, status, error) {
                            alert('Có lỗi xảy ra khi gửi form!');
                            // Xử lý lỗi nếu có
                        }
                    });
                });

            },
            editable: true,
            // update kéo thả
            eventDrop: function (event, delta, revertFunc) {
                if (!isAllowedToDrag(event)) {
                    revertFunc();
                }
                console.log(event)
                var changeDate = 'true';
                var text = event.title;
                var id_gg_calendar = event.id_google_calendar;
                var id = event.id;
                var start = moment(event.start).format('YYYY-MM-DD HH:mm:00');
                var end = moment(event.end == null ? event.start : event.end).format('YYYY-MM-DD HH:mm:00');
                $.ajax({
                    url: `/tasks/${id}`,
                    type: "PUT",
                    dataType: "json",
                    data: {
                        text,
                        changeDate,
                        id,
                        id_gg_calendar,
                        start,
                        end,
                    },
                    success: function (response) {
                        isAllowedToDrag(event)
                            ? notificationWeb('success', 'Cập nhật ngày thành công!')
                            : notificationWeb('error', 'Bạn không có quyền thay đổi!');
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                })
            },
            // xem chi tiết
            eventClick: function (event) {

            },
            viewRender: function (view) {

                $('.fc-month-button').text('Tháng'); // Đổi văn bản nút trước
                $('.fc-agendaWeek-button').text('Tuần'); // Đổi văn bản nút tiếp theo
                $('.fc-agendaDay-button').text('Ngày'); // Đổi văn bản nút tiếp theo
                $('.fc-today-button').text('Hôm nay'); // Đổi văn bản nút hôm nay
            }

        });
    </script>

    <script>
        function isAllowedToDrag(event) {
            const check = event.email === emailName.value
            // ... các điều kiện khác
            return check;
        }

        function convertTimeString(timeString) {
            // Kiểm tra và thay thế ký tự "A" bằng "T"
            return timeString.replace('A', 'T');
        }

        function handleDate() {
            if (startDateInput.value) {
                const endDate = new Date(endDateInput.value);
                const startDate = new Date(startDateInput.value);

                endDate.setDate(endDate.getDate());
                startDate.setDate(startDate.getDate() + 1);

                const maxDate = endDate.toISOString().slice(0, 16);
                const minDate = startDate.toISOString().slice(0, 16);
                startDateInput.max = maxDate;
                endDateInput.min = minDate;
                console.log(maxDate, minDate)
            }


        }


        endDateInput.addEventListener('change', function () {
            handleDate();
        });

        startDateInput.addEventListener('change', function () {
            handleDate();
        });

        active_checkbox.addEventListener('click', function () {
            startDateInput.disabled = !startDateInput.disabled;
            startDateInput.value = '';

            handleDate();
        });
    </script>
@endsection
