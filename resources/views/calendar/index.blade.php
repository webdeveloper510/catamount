@extends('layouts.admin')
@section('page-title')
{{__('Calendar')}}
@endsection
@section('title')
{{__('Calendar')}}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Home')}}</a></li>
<li class="breadcrumb-item">{{__('Calendar')}}</li>
@endsection
@section('action-btn')
@can('Create Meeting')
<a href="{{ route('meeting.create',['meeting',0]) }}" data-title="{{__('Create New Event')}}"
    class="btn btn-sm btn-info">
    {{__('Add Events')}}
</a>
@endcan
<div class="checkbox"><b>COMPLETED EVENTS</b></div>
<div class="checkbox1"><b>UPCOMING EVENTS</b></div>
<div class="checkbox2"><b>BLOCKED DATES</b></div>
@endsection
@section('filter')

@endsection


@push('script-page')
<style>
.blocked-by-tooltip {
    position: absolute;
    background-color: #333;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    z-index: 1000;
}

/* CHECKBOX 1 COMPLETED */
.checkbox {
    width: -1px;
    height: 20px;
    float: left;
    margin-right: 10px;
    margin-left: 130px;
    margin-bottom: 14px;
    position: relative;
}

.checkbox:after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: red;
    top: 0px;
    left: -22px;
}

/* CHECKBOX 1 UPCOMING */
.checkbox1 {
    /* width: 26px; */
    height: 20px;
    float: left;
    margin-right: 10px;
    margin-bottom: 14px;
    position: relative;
    margin-top: 23px;
    margin-left: -147px;
}

.checkbox1:after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: green;
    top: 0px;
    left: -22px;
}

/* CHECKBOX 1 BLOCKED */
.checkbox2 {
    /* width: 26px; */
    height: 20px;
    float: left;
    margin-right: 10px;
    margin-bottom: 14px;
    margin-top: 47px;
    position: relative;
    margin-left: -147px;
}

.checkbox2:after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: Gray;
    top: 0px;
    left: -22px;
}

#popup-form {
    display: none;
    position: fixed;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    border-radius: 2px
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
</style>

@endpush
@php
$setting = App\Models\Utility::settings();
@endphp


@section('content')
<div class="blockd_dates">
    @foreach($blockeddate as $key=> $value)
    <input type="hidden" name="strt{{$key}}" value="{{$value->start_date}}">
    <input type="hidden" name="end{{$key}}" value="{{$value->end_date}}">
    @endforeach
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 style="width: 150px;">{{ __('Calendar') }}</h5>
                <input type="hidden" id="path_admin" value="{{url('/')}}">
            </div>
            <div class="card-body">
                <div id='calendar' class='calendar'></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Next events</h4>

                <ul class="event-cards list-group list-group-flush mt-3 w-100">
                    @php
                    $now = Carbon\Carbon::now();
                    $this_month_meeting = \Auth::user()->type == 'owner'
                    ? App\Models\meeting::where('created_by', \Auth::user()->creatorId())->get()
                    : App\Models\meeting::where('user_id', \Auth::user()->id)->get();
                    @endphp

                    @foreach($this_month_meeting as $meeting)
                    @php
                    $start_date = Carbon\Carbon::parse($meeting->start_date);
                    @endphp

                    @if($start_date >= $now)
                    <li class="list-group-item card mb-3">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-calendar-event"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="m-0">{{$meeting->name}}</h6>
                                        <small class="text-muted">{{$meeting->start_date}} to
                                            {{$meeting->end_date}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
<div id="overlay"></div>
<div id="popup-form">
    <div class="row">
        <div class="card">
            <div class="col-md-12">
                <div class="card-header">
                    {{ Form::open(['route' => 'meeting.blockdate', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <h5>{{ __('Block Date') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                {!! Form::date('start_date', date('Y-m-d'), ['class' => 'form-control', 'required' =>
                                'required']) !!}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {!! Form::date('end_date', date('Y-m-d'), ['class' => 'form-control', 'required' =>
                                'required']) !!}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                {{Form::label('purpose',__('Purpose'),['class'=>'form-label']) }}
                                {{Form::textarea('purpose',null,array('class'=>'form-control','rows'=>2))}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    {{ Form::submit(__('Block'), ['id'=>'block','class' => 'btn  btn-primary ']) }}
                    {{Form::close()}}
                    <button class="btn btn-primary" id="unblock" data-bs-toggle="tooltip" title="{{__('Close')}}"
                        style="display:none">Unblock</button>
                    <button class="btn  btn-primary" id="close-popup" data-bs-toggle="tooltip"
                        title="{{__('Close')}}">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css-page')

@endpush
@push('script-page')
<script defer src='https://static.cloudflareinsights.com/beacon.min.js'
    data-cf-beacon='{"token": "dc4641f860664c6e824b093274f50291"}'></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript">
@php
$segment = Request::segment(2);
@endphp
$(document).ready(function() {
    get_data();
});

function get_data() {
    var segment = "{{$segment}}";
    if (segment == 'call') {
        var urls = $("#path_admin").val() + "/call/get_call_data";
    } else if (segment == 'meeting') {
        var urls = $("#path_admin").val() + "/meeting/get_meeting_data";
    } else if (segment == 'task') {
        var urls = $("#path_admin").val() + "/task/get_task_data";
    } else {
        var urls = $("#path_admin").val() + "/all-data";
    }

    var calender_type = $('#calender_type :selected').val();
    // console.log("calender_type"+calender_type)
    // $('#calendar').removeClass('local_calender');
    // $('#calendar').removeClass('goggle_calender');

    if (calender_type == undefined) {
        calender_type = 'local_calender';
    }
    $('#calendar').addClass(calender_type);
    $.ajax({
        url: urls,
        method: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            'calender_type': calender_type
        },
        success: function(data) {
            (function() {
                var etitle;
                var etype;
                var etypeclass;
                var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
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
                    height: 'auto',
                    timeFormat: 'H(:mm)',
                    events: data,
                    select: function(info) {
                        var startDate = info.startStr;
                        var endDate = info.endStr;
                        console.log(endDate)
                        openPopupForm(startDate, endDate);
                    },
                    eventContent: function(arg) {
                        return {
                            html: arg.event.title,
                        };
                    },

                    eventMouseEnter: function(arg) {
                        if (arg.event.extendedProps.blocked_by) {
                            arg.el.innerHTML += '<div class="blocked-by-tooltip">' + 'By:' +
                                arg.event.extendedProps.blocked_by + '</div>';
                        }
                    },

                    eventMouseLeave: function(arg) {
                        var tooltip = arg.el.querySelector('.blocked-by-tooltip');
                        if (tooltip) {
                            tooltip.remove();
                        }
                    },
                });
                calendar.render();
            })();

            function openPopupForm(start, end) {
                $("#block").show();
                $("#unblock").hide();
                $(".blockd_dates input").each(function(index) {
                    if ($(this).val() == start) {
                        $("#unblock").show();
                        $("#block").hide();
                    }
                });
                var enddate = moment(end).subtract(1, 'days').format('yyyy-MM-DD');
                $("input[name = 'start_date']").attr('value', start);
                $("input[name = 'end_date']").attr('value', enddate);
                $('#popup-form').show();
                $('#overlay').show();
            }

        }

    });
    $('#close-popup').on('click', function() {
        closePopupForm();
    });
    function closePopupForm() {
        $('#popup-form').hide();
        $('#overlay').hide();
    }
}
$('#unblock').on('click', function() {
    var start = $('#popup-form input[name = "start_date"]').val();
    var end = $('#popup-form input[name = "end_date"]').val();
    var purpose = $('#popup-form textarea[name = "purpose"]').val();
    var url = "{{route('meeting.unblock')}}";
    $.ajax({
        url: url,
        method: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            'start': start,
            'end': end,
        },
        success: function(data) {
            location.reload();
            // console.log(data);
        }
    })
});
</script>
<script type="text/javascript">
$(document).on('change', 'select[name=parent]', function() {

    var parent = $(this).val();
    getparent(parent);
});

function getparent(bid) {
    // console.log(bid);
    $.ajax({
        url: '{{route("call.getparent")}}',
        type: 'POST',
        data: {
            "parent": bid,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
            // console.log(data);
            $('#parent_id').empty(); {
                {
                    --$('#parent_id').append('<option value="">{{__('
                        Select Parent ')}}</option>');
                    --
                }
            }

            $.each(data, function(key, value) {
                $('#parent_id').append('<option value="' + key + '">' + value + '</option>');
            });
            if (data == '') {
                $('#parent_id').empty();
            }
        }
    });
}

$(document).on('change', '#parents', function() {
    // console.log('h');
    var parent = $(this).val();
    getparents(parent);
});

function getparents(bid) {
    // console.log(bid);
    $.ajax({
        url: '{{route("task.getparent")}}',
        type: 'POST',
        data: {
            "parent": bid,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
            // console.log(data);
            $('#parent_id').empty(); {
                {
                    --$('#parent_id').append('<option value="">{{__('
                        Select Parent ')}}</option>');
                    --
                }
            }

            $.each(data, function(key, value) {
                $('#parent_id').append('<option value="' + key + '">' + value + '</option>');
            });
            if (data == '') {
                $('#parent_id').empty();
            }
        }
    });
}
</script>

@endpush