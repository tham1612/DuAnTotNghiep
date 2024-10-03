@extends('layouts.masterMain')
@section('title')
    Calendar - TaskFlow
@endsection
@section('main')
    <div class="p-2" data-simplebar style="max-height: 80vh;">
        <div id="calendar"></div>
    </div>
    <input type="hidden" id="emailName" value="{{ Auth()->user()->email }}">
    <!-- Modal -->

@endsection

@section('style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>

@endsection
@section('script')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-timezone-with-data.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        const startDateInput = document.querySelector('input[name="start"]');
        const endDateInput = document.querySelector('input[name="end"]');
        var summary = document.querySelector('#summary');
        var attendees = document.querySelector('#attendees');
        var description = document.querySelector('#description');
        var active_checkbox = document.querySelector('#active_checkbox');
        var deteleEvent = document.getElementById('deteleEvent');
        var createEvent = document.getElementById('createEvent');
        var emailName = document.getElementById('emailName');

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
                summary.value = '';
                active_checkbox.checked = false; // Reset checkbox
                $('#detailCardModal6').modal('toggle'); // Hiển thị modal

                createEvent.addEventListener('click', function (e) {
                    e.preventDefault();
                    summary = summary.value;
                    attendees = attendees.value;
                    description = description.value;
                    start = moment(startDateInput.value).format('YYYY-MM-DD HH:mm:00');
                    end = moment(endDateInput.value).format('YYYY-MM-DD HH:mm:00');
                    $.ajax({
                        url: `/create-event`,
                        type: "POST",
                        dataType: "json",
                        data: {
                            summary,
                            attendees,
                            description,
                            start,
                            end
                        },
                        success: function (response) {
                            $('#detailCardModal6').modal('toggle');
                            alert(response.msg)
                        }
                    })
                })
            },
            editable: true,
            // update kéo thả
            eventDrop: function (event, delta, revertFunc) {
                if (!isAllowedToDrag(event)) {
                    revertFunc();
                }
                var changeDate = 'true';
                var id_gg_canlendar = event.id_google_calendar;
                var start = moment(event.start).format('YYYY-MM-DD HH:mm:00');
                var end = moment(event.end == null ? event.start : event.end).format('YYYY-MM-DD HH:mm:00');
                $.ajax({
                    url: `/update-event/${id_gg_canlendar}`,
                    type: "PUT",
                    dataType: "json",
                    data: {
                        changeDate,
                        id_gg_canlendar,
                        start,
                        end,
                    },
                    success: function (response) {
                        isAllowedToDrag(event) ? alert(response.msg) : alert(
                            'Bạn không có quyền thay đổi');

                    }
                })
            },
            // xem chi tiết
            eventClick: function (event) {
                $('#detailCardModal6').modal('toggle'); // bật modal lên
                var id_gg_canlendar = event.id_google_calendar;
                console.log(id_gg_canlendar, event)
                deteleEvent.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (isAllowedToDrag(event)) {
                        if (confirm('ban co muon xoa khong?')) {
                            $.ajax({
                                url: `/delete-event/${id_gg_canlendar}`,
                                type: "DELETE",
                                dataType: "json",
                                data: {},
                                success: function (response) {
                                    alert(response.msg);
                                    $('#detailCardModal6').modal('toggle');
                                }
                            })
                        }
                    } else {
                        alert('Bạn không có quyền để xóa');
                    }

                })

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
        // $(document).ready(function () {
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        // });

        function isAllowedToDrag(event) {
            const check = event.email == emailName.value
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
