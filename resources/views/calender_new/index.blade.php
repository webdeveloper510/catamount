@extends('layouts.admin')
@section('page-title')
{{__('Calendar')}}
@endsection
@section('title')
{{__('Calendar')}}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Calendar')}}</li>
@endsection
<?php  
$settings = App\Models\Utility::settings();
$venue = explode(',',$settings['venue']);
?>
<style>
li.item-event {
    display: flex;
    /* justify-content: space-between; */
}

li.item-event>p:nth-child(2) {
    margin-left: 35%;
}
</style>
<style>
#popup-form {
    display: none;
    /*position: fixed; */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    border-radius: 2px;
    width: 600px;
}

#overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}


.blocked-by-tooltip {
    position: absolute;
    background-color: #145388;
    color: #fff;
    padding: 10px;
    border-radius: 8px;
    z-index: 2000;
    margin-top: -28px;
    margin-left: -94px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
    background: linear-gradient(45deg, #145388, #145388);
}

.blocked-by-tooltip:hover {
    background-color: #145388;
    transform: scale(1.05);
}

p.close-popup {
    margin-bottom: 0 !important;
}
</style>
@section('content')
<div class="container">
    <div class="row calender" id="useradd-1">
        <div class="col-sm-8">
            <div id="calendar"></div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Event lists
                        <a href="{{ route('meeting.create',['meeting',0]) }}" style="float: right;"
                            data-date-selected="" id="selectedDate">
                            <button data-bs-toggle="tooltip" title="{{ __('Create') }}"
                                class="btn btn-sm btn-primary btn-icon m-1" data-bs-placement="top"
                                data-bs-original-title="Create"><i class="ti ti-plus"></i></button>
                        </a>
                    </h3>
                    <p class="text-muted" id="daySelected"></p>
                    <ul class="event-cards list-group list-group-flush mt-3 w-100" id="listEvent">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blockd_dates">
    @foreach($blockeddate as $key=> $value)
    <input type="hidden" name="strt{{$key}}" value="{{$value->start_date}}">
    <input type="hidden" name="end{{$key}}" value="{{$value->end_date}}">
    <!-- <input type="hidden" name="title{{$key}}" value="{{$value->title}}"> -->
    @endforeach
</div>
<div id="overlay"></div>
<div id="popup-form">
    <div class="row step1 blocked" data-popdate="">
        <div class="card">
            <div class="col-md-12">
                {{ Form::open(['route' => 'meeting.blockdate', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h5>{{ __('Block Date') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Venue</label>
                                <div class="checkbox-container d-flex flex-wrap">
                                    @foreach ($venue as $value => $label)
                                    <div class="form-check mx-2">
                                        <input class="form-check-input venue-checkbox" type="checkbox" id="{{ $value }}"
                                            name="venue[]" value="{{ $label }}">
                                        <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                {!! Form::date('start_date', date('Y-m-d'), ['class' => 'form-control', 'required' =>
                                'required']) !!}
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('start_time', __('Start Time'), ['class' => 'form-label']) }}
                                {!! Form::time('start_time', '00:00', ['class' => 'form-control']) !!}
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {!! Form::date('end_date', date('Y-m-d'), ['class' => 'form-control', 'required' =>
                                'required','required' => 'required']) !!}
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('end_time', __('End Time'), ['class' => 'form-label']) }}
                                {!! Form::time('end_time', '00:00', ['class' => 'form-control', 'required' =>
                                'required']) !!}
                            </div>
                        </div> -->
                        <div class="col-12">
                            <div class="form-group">
                                {{Form::label('purpose',__('Purpose'),['class'=>'form-label']) }}
                                {{Form::textarea('purpose',null,['class'=>'form-control','rows'=>2])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    {{ Form::submit(__('Block'), ['id'=>'block','class' => 'btn  btn-primary ']) }}
                    <button class="btn btn-primary" id="unblock" data-bs-toggle="tooltip" title="{{__('Close')}}"
                        style="display:none">Unblock</button>
                    <p class="btn  btn-primary close-popup" data-bs-toggle="tooltip" title="{{__('Close')}}">Close</p>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

</div>
@endsection
@push('script-page')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
$(document).on('click', 'button.fc-timeGridDay-button', function() {
    setTimeout(() => {
         fetchDayData();
        },200)
});
$(document).on('click', 'button.fc-timeGridWeek-button', function() {
    setTimeout(() => {
    fetchWeekData();
},200)
});
$(document).on('click', 'button.fc-dayGridMonth-button', function() {
    setTimeout(() => {
    fetchMonthData();
},200)
});
$(document).ready(function() {
    display_count();
    setTimeout(() => {
        fetchMonthData();
    }, 2450);
});
function fetchMonthData(){
    document.getElementById('daySelected')
    .innerHTML = '';
    var month = $('.fc-toolbar-title').text();
    var parts = month.split(' ');
    var monthName = parts[0];
    var year = parts[1];

    // Create a new date object by specifying the month and year
    var date = new Date(monthName + ' 1, ' + year);
    // var date = new Date(month);
    // Get the month and year separately
    var monthNumber = date.getMonth() + 1; // Adding 1 because month index starts from 0
    var year = date.getFullYear();
    $.ajax({
        url: "{{route('monthbaseddata')}}",
        type: 'POST',
        data: {
            "month": monthNumber,
            "year": year,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {

            var html = '';
            if (data.length != 0) {
                $(data).each(function(index, element) {
                    console.log(element.id);


                    var start = element.start_time;
                    var start_time = moment(start, 'HH:mm:ss')
                        .format('h:mm A');
                    var end = element.end_time;
                    var end_time = moment(end, 'HH:mm:ss').format(
                        'h:mm A');
                    var start_date = moment(element.start_date).format('D MMM, YYYY');
                    // var id = element.id;
                    // var url = '{{route("meeting.detailview", urlencode(encrypt('.id.'))) }}';
                    var id = element.id;
                    $.ajax({
                        url: '{{ route("get.encoded.id", ":id") }}'.replace(
                            ':id',
                            id),
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            var encodedId = response.encodedId;
                            // Now you have the encoded ID, use it as needed
                            var url =
                                '{{ route("meeting.detailview", ":encodedId") }}';
                            url = url.replace(':encodedId', encodedId);
                            // console.error(url);
                            html += `<a href="${url}"><li class="list-group-item card mb-3">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-info">
                                            <i class="ti ti-calendar-event"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="m-0">${element.eventname} (${element.name})</h6>
                                            <small class="text-muted">${start_date}</small><br>
                                            <small class="text-muted">${start_time} - ${end_time}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li></a>`;

                            $('#listEvent').html(html);

                            // Use the URL as needed
                        },
                    });
                });
            } else {

                html =
                    `<h6 class="m-0">No event found!</h6>`;
                document.getElementById('daySelected')
                    .innerHTML = '';
                document.getElementById('listEvent')
                    .innerHTML = html;
            }
        }

    });
}
function fetchWeekData(){
    document.getElementById('daySelected').innerHTML = '';
    var week = $('.fc-toolbar-title').text();
    // var dateString = "May 5 – 11, 2024";
    // Split the string by comma and space
    var parts = week.split(', ');
    if (parts.length === 2) {
        var dates = parts[0].split(' – '); // Split the first part by " – " to get start and end dates

        if (dates.length === 2) {
            // Extract month and day for start date
            var startParts = dates[0].split(' ');
            var startDay = parseInt(startParts[1]); // Extract start day
            var startMonthString = startParts[0]; // Extract start month

            // Extract month and day for end date
            var endParts = dates[1].split(' ');
            var endDay, endMonthString;
            if (endParts.length === 2) {
                endMonthString = endParts[0]; // Extract end month
                endDay = parseInt(endParts[1]); // Extract end day
            } else {
                endMonthString = startMonthString; // Use the same month as start date
                endDay = parseInt(endParts[0]); // Extract end day
            }

            // Map month string to month number
            var monthMap = {
                "Jan": 0,
                "Feb": 1,
                "Mar": 2,
                "Apr": 3,
                "May": 4,
                "Jun": 5,
                "Jul": 6,
                "Aug": 7,
                "Sep": 8,
                "Oct": 9,
                "Nov": 10,
                "Dec": 11
            };

            var startMonth = monthMap[startMonthString];
            var endMonth = monthMap[endMonthString];
            // Get the year
            var year = parseInt(parts[1]);

            // Create start date
            var startDate = new Date(year, startMonth, startDay);
            // Create end date
            var endDate = new Date(year, endMonth, endDay);

            // Format start date as YYYY-MM-DD
            var formattedStartDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);

            // Format end date as YYYY-MM-DD
            var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

            $.ajax({
                url: "{{route('weekbaseddata')}}",
                type: 'POST',
                data: {
                    "startdate": formattedStartDate,
                    "enddate": formattedEndDate,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    console.log(data);
                    var html = '';
                    if (data.length != 0)
                        $(data).each(function(index, element) {
                            var start = element.start_time;
                            var start_time = moment(start, 'HH:mm:ss').format('h:mm A');
                            var end = element.end_time;
                            var end_time = moment(end, 'HH:mm:ss').format('h:mm A');
                            var start_date = moment(element.start_date).format('D MMM, YYYY');
                            var id = element.id;
                            $.ajax({
                                url: '{{ route("get.encoded.id", ":id") }}'.replace(':id', id),
                                method: 'GET',
                                dataType: 'json',
                                success: function(response) {

                                    var encodedId = response.encodedId;

                                    // Now you have the encoded ID, use it as needed
                                    var url = '{{ route("meeting.detailview", ":encodedId") }}';
                                    url = url.replace(':encodedId', encodedId);
                                    // console.error(url);
                                    html += `<a href="${url}"><li class="list-group-item card mb-3">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-auto mb-3 mb-sm-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="theme-avtar bg-info">
                                                        <i class="ti ti-calendar-event"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 class="m-0">${element.eventname} (${element.name})</h6>
                                                        <small class="text-muted">${start_date}</small><br>
                                                        <small class="text-muted">${start_time} - ${end_time}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li></a>`;
                                    $('#listEvent').html(html);

                                    console.log(html)
                                    // Use the URL as needed
                                },
                            });
                        });
                    else {

                        html = `<h6 class="m-0">No event found!</h6>`;
                        document.getElementById('daySelected').innerHTML = '';
                        document.getElementById('listEvent').innerHTML = html;
                    }
                }
            });
        }
    }
}
function fetchDayData(){
    document.getElementById('daySelected').innerHTML = '';
    var day = $('.fc-toolbar-title').text();
    // Parse the date string
    var date = new Date(day);
    // Get the year, month, and day
    var year = date.getFullYear();
    var month = date.getMonth() + 1; // Adding 1 because month index starts from 0
    var day = date.getDate();
    // Format month and day to have leading zeros if necessary
    var monthString = month < 10 ? '0' + month : month;
    var dayString = day < 10 ? '0' + day : day;

    // Construct the formatted date string
    var formattedDate = year + '-' + monthString + '-' + dayString;
    $.ajax({
        url: "{{route('daybaseddata')}}",
        type: 'POST',
        data: {
            "date": formattedDate,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
            console.log(data);
            var html = '';
            if (data.length != 0)
                $(data).each(function(index, element) {
                    var start = element.start_time;
                    var start_time = moment(start, 'HH:mm:ss')
                        .format('h:mm A');
                    var end = element.end_time;
                    var end_time = moment(end, 'HH:mm:ss').format(
                        'h:mm A');
                    var start_date = moment(element.start_date).format('D MMM, YYYY');
                    var id = element.id;
                    $.ajax({
                        url: '{{ route("get.encoded.id", ":id") }}'.replace(':id',
                            id),
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {

                            var encodedId = response.encodedId;

                            // Now you have the encoded ID, use it as needed
                            var url =
                                '{{ route("meeting.detailview", ":encodedId") }}';
                            url = url.replace(':encodedId', encodedId);
                            // console.error(url);
                            html += `<a href="${url}"><li class="list-group-item card mb-3">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="m-0">${element.eventname} (${element.name})</h6>
                                    <small class="text-muted">${start_date}</small><br>
                                    <small class="text-muted">${start_time} - ${end_time}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li></a>`;
                            $('#listEvent').html(html);

                            console.log(html)
                            // Use the URL as needed
                        },
                    });
                });
            else {

                html =
                    `<h6 class="m-0">No event found!</h6>`;
                document.getElementById('daySelected')
                    .innerHTML = '';
                document.getElementById('listEvent')
                    .innerHTML = html;
            }
        }
    });
}
function display_count() {
    var events = new Array();
    $.ajax({
        url: '{{route("eventinformation")}}',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            document.getElementById('daySelected').innerHTML =
                '';
            var eventDates = {};
            // Count the number of events for each date
            response.forEach(function(event) {
                var startDate = moment(event.start_date).format('YYYY-MM-DD');
                if (eventDates[startDate]) {
                    eventDates[startDate]++;
                } else {
                    eventDates[startDate] = 1;
                }
            });

            // Convert the event counts into background event objects
            var backgroundEvents = [];
            // console.log(eventDates);
            for (var date in eventDates) {
                backgroundEvents.push({
                    title: eventDates[date],
                    start: date,
                    textColor: '#fff',
                    display: 'background',
                });
            }
            $.ajax({
                url: '{{ route("blockedDatesInformation") }}',
                method: 'GET',
                dataType: 'json',
                success: function(blockedDates) {

                    blockedDates.forEach(function(event) {
                        var startDate = moment(event.start_date).format(
                            'YYYY-MM-DD');
                        var endDate = moment(event.end_date).format(
                            'YYYY-MM-DD');
                        backgroundEvents.push({
                            title: event.purpose + ' (Blocked)',
                            start: startDate,
                            end: endDate,
                            textColor: '#fff',
                            color: '#8fa6b3',
                            url: "{{url('/show-blocked-date-popup')}}" +
                                '/' +
                                event.id

                        });
                    });
                    let calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        buttonText: {
                            timeGridDay: "{{ __('Day') }}",
                            timeGridWeek: "{{ __('Week') }}",
                            dayGridMonth: "{{ __('Month') }}"
                        },
                        slotLabelFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false,
                        },
                        themeSystem: 'bootstrap',
                        navLinks: true,
                        droppable: false,
                        selectable: true,
                        selectMirror: true,
                        editable: false,
                        dayMaxEvents: true,
                        handleWindowResize: true,
                        showNonCurrentDates: false,
                        height: 'auto',
                        timeFormat: 'H(:mm)',
                        initialView: 'dayGridMonth',
                        eventDisplay: 'block',
                        select: function(start, end, allDay, info) {

                            var selectedStartDate = start.startStr;
                            var selectedEndDate = start.endStr;

                            var formattedStartDate = moment(
                                    selectedStartDate)
                                .format(
                                    'dddd, MMMM DD, YYYY');
                            var selectedDate = moment(selectedStartDate)
                                .format(
                                    'Y-MM-DD');
                            sessionStorage.setItem('selectedDate',
                                selectedDate);
                            document.getElementById('daySelected')
                                .innerHTML =
                                formattedStartDate;
                            document.getElementById('selectedDate')
                                .setAttribute(
                                    'data-date-selected',
                                    selectedDate);
                            fetch("{{url('/calender-meeting-data')}}?start=" +
                                    start
                                    .startStr, {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-Token": "{{ csrf_token() }}",
                                        },
                                        body: JSON.stringify({
                                            request_type: 'viewMeeting',
                                            start: start.startStr,
                                            end: start.endStr,
                                        }),
                                    })
                                .then(response => response.json())
                                .then(data => {
                                    const JSON = data.events;
                                    // console.log(JSON);

                                    if (JSON.length != 0) {
                                        Json = [];
                                        JSON.forEach((event, index,
                                            array) => {
                                            var start = event
                                                .start_time;
                                            var start_time =
                                                moment(
                                                    start,
                                                    'HH:mm:ss')
                                                .format(
                                                    'h:mm A');
                                            var end = event
                                                .end_time;
                                            var end_time =
                                                moment(end,
                                                    'HH:mm:ss')
                                                .format(
                                                    'h:mm A');
                                            if (event
                                                .attendees_lead ==
                                                0) {
                                                eventname =
                                                    event
                                                    .eventname;
                                            } else {
                                                eventname =
                                                    'event';
                                            }
                                            lists = `
                                        <li class="list-group-item card mb-3" data-index="${index}">
                                        
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="theme-avtar bg-info">
                                                            <i class="ti ti-calendar-event"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <h6 class="m-0">${eventname} (${event.name})</h6>
                                                            
                                                            <small class="text-muted">${start_time} - ${end_time}</small>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                    </li>
                                    `;
                                            Json.push(lists);
                                        });
                                        document.getElementById(
                                                'listEvent')
                                            .innerHTML = Json
                                            .join(
                                                '');
                                    } else {
                                        // localStorage.setItem('startDate', JSON.stringify(start));
                                        openPopupForm(selectedStartDate,
                                            selectedEndDate);
                                        lists =
                                            `<h6 class="m-0">No event found!</h6>`;
                                        document.getElementById(
                                                'listEvent')
                                            .innerHTML = lists;
                                    }
                                    calendar.refetchEvents();
                                })
                                .catch(console.error);
                        },
                        events: backgroundEvents,
                        eventContent: function(arg) {
                            return {
                                html: arg.event.title,
                            };
                        },
                        eventMouseEnter: function(arg) {
                            if (arg.event.extendedProps.blocked_by) {
                                arg.el.innerHTML +=
                                    '<div class="blocked-by-tooltip">' +
                                    'By:' + arg
                                    .event.extendedProps.blocked_by +
                                    '</div>';
                            }
                        },
                        eventMouseLeave: function(arg) {
                            var tooltip = arg.el.querySelector(
                                '.blocked-by-tooltip');
                            if (tooltip) {
                                tooltip.remove();
                            }
                        },

                    });
                    calendar.render();
                    $(document).on('click', 'button.fc-next-button', function() {
                        var view = calendar.view.type;
                        if (view == 'dayGridMonth') {
                            fetchMonthData();
                        }
                        else if(view == 'timeGridWeek') {
                            fetchWeekData();
                        }
                        else  if (view == 'timeGridDay'){
                            fetchDayData();
                        }
                    });
                    $(document).on('click', 'button.fc-prev-button', function() {
                        var view = calendar.view.type;
                        if (view == 'dayGridMonth') {
                            setTimeout(() => {
                            fetchMonthData();
                        },200)
                        }
                        else if(view == 'timeGridWeek') {
                            setTimeout(() => {
                            fetchWeekData();
                        },200)
                        }
                        else  if(view == 'timeGridDay'){
                            setTimeout(() => {
                            fetchDayData();
                        },200)
                        }
                    });
                }
            });
        }
    })
  
    $('.close-popup').on('click', function() {
        closePopupForm();
    });
    $('input[name="venue[]"]').on('change', function() {
        if ($(this).is(':checked')) {
            const valueDataString = localStorage.getItem('startDate');
            const valueDataArg = JSON.parse(valueDataString);
            var startdate = valueDataArg.startStr;
            var enddate = valueDataArg.endStr;
            let venue = $(this).val();
            ff(startdate, enddate, venue);
        } else {
            // console.log("deselect")

            $('.venue-checkbox').prop('checked', false);
            // $('input[name="start_time"]').attr('min', '00:00');
            // $('input[name="start_time"]').val('00:00');
            // $('input[name="start_time"]').attr('value', '00:00');
            // $('input[name="end_time"]').attr('min', '00:00');
        }
    });
    function ff(startdate, enddate, venue) {
        var url = "{{url('/buffer-time')}}";

        $.ajax({
            url: url,
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                startdate: startdate,
                enddate: enddate,
                venue: venue,
            },
            success: function(data, bufferedTime) {
                if (data.bufferedTime) {
                    // console.log('Buffered Time:', data.bufferedTime);
                    $('input[name="start_time"]').attr('min', data.bufferedTime);
                    $('input[name="start_time"]').val(data.bufferedTime);
                    $('input[name="start_time"]').attr('value', data.bufferedTime);
                    $('input[name="end_time"]').attr('min', data.bufferedTime);

                } else {
                    // console.log('No data found');
                    $('input[name="start_time"]').attr('min', '00:00');
                    $('input[name="start_time"]').val('00:00');
                    $('input[name="start_time"]').attr('value', '00:00');
                    $('input[name="end_time"]').attr('min', '00:00');
                }
            },
            error: function(data) {
                console.log('error');
            },
        });
    }
    function openPopupForm(start, end) {
        var enddate = moment(end).subtract(1, 'days').format('yyyy-MM-DD');
        $("input[name = 'start_date']").attr('value', start);
        $("input[name = 'end_date']").attr('value', enddate);
        $("div#popup-form").show();
    }
    function closePopupForm() {
        $('#popup-form').hide();
        $('#overlay').hide();
        // document.getElementById('start_time').value = '00:00';
        // document.getElementById('end_time').value = '00:00';
        document.getElementById('purpose').value = '';
        $('.venue-checkbox').prop('checked', false);
        $('input[name="start_time"]').attr('min', '00:00');
        $('input[name="start_time"]').val('00:00');
        $('input[name="start_time"]').attr('value', '00:00');
    }
}
</script>

@endpush