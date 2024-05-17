@extends('layouts.admin')
@section('breadcrumb')
@endsection
@section('page-title')
{{ __('Home') }}
@endsection
@section('title')
{{ __('Dashboard') }}
@endsection
@section('action-btn')
@endsection
@section('content')
    <div class="container-field">
        <div id="wrapper">
            <div id="page-content-wrapper">
                <div class="container-fluid xyz">
                    <div class="row">
                        <!-- <div class="col-lg-12"> -->
                            @if (\Auth::user()->type == 'owner')
                            <div class="col-lg-3 col-6 totallead"style="padding: 15px;">
                                <div class="card">
                                    <div class="card-body newcard_body" onclick="leads();">
                                        <div class="theme-avtar bg-info">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                        <div class="right_side">
                                        <h6 class="mb-3">{{ __('Total Lead') }}</h6>
                                        <h3 class="mb-0">{{ $data['totalLead'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6" id="toggleDiv" style="padding: 15px;">
                                <div class="card">
                                    <div class="card-body newcard_body" onclick="toggleOptions()">
                                        <div class="theme-avtar bg-warning">
                                            <i class="ti ti-user"></i>
                                        </div>
                                        <div class="right_side">
                                        <h6 class="mb-3">{{ __('Total Events') }}</h6>
                                        <h3 class="mb-0">{{ @$totalevent }} </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="optionsContainer"> -->
                            <div class="col-lg-3 col-6 upcmg optionsContainer"  style="padding: 15px;">
                                <div class="card option" onclick="showUpcoming()">
                                    <div class="card-body newcard_body" style="">
                                        <div class="theme-avtar bg-info">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                        <div class="right_side">
                                        <h6 class="mb-3">{{ __('Upcoming Events') }}</h6>
                                        <h4 class="mb-0">{{ @$upcoming }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6 cmplt optionsContainer"  style="padding: 15px;">
                                <div class="card option" onclick="showCompleted()">
                                    <div class="card-body newcard_body" style="">
                                        <div class="theme-avtar bg-info">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                        <div class="right_side">
                                        <h6 class="mb-3">{{ __('Completed Events') }}</h6>
                                        <h4 class="mb-0">{{ @$completed }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                            @endif

                            @php
                            $setting = App\Models\Utility::settings();
                            @endphp
                        <!-- </div> -->
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="inner_col">  
                                <h5 class="card-title mb-2">Active Leads</h5>
                                @foreach($activeLeads as $lead)
                                <div class="card">
                                    <div class="card-body new_bottomcard">
                                        <h4 class="card-text">{{ $lead['leadname'] }}
                                            <span>({{ $lead['type'] }})</span>
                                        </h4>
                                        @if($lead['start_date'] == $lead['end_date'])
                                            <p>{{ Carbon\Carbon::parse($lead['start_date'])->format('M d')}}</p>
                                        @else 
                                            <p>{{ Carbon\Carbon::parse($lead['start_date'])->format('M d')}} -
                                        {{ \Auth::user()->dateFormat($lead['end_date'])}}</p>
                                        @endif
                                        <!-- <span>{{date('h:i A', strtotime($lead['start_time']))}} - {{date('h:i A', strtotime($lead['end_time']))}}</span>                                                                                                                  -->
                                                                                                      
                                    </div>                              
                                </div>
                                @endforeach
                                @can('Create Lead')
                                <div class="col-12 text-end mt-3">
                                <a href="#" data-url="{{ route('lead.create',['lead',0]) }}" data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{__('Create New Lead')}}" title="{{__('Create Lead')}}" class="btn btn-sm btn-primary btn-icon m-1">
                                    <i class="ti ti-plus"></i>
                                </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="inner_col">   
                            <h5 class="card-title mb-2">Active/Upcoming Events</h5>
                                @foreach($activeEvent as $event)
                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-text">{{ $event['name'] }}
                                            <span>({{ $event['type'] }})</span>
</h4>
                                        @if($event['start_date'] == $event['end_date'])
                                            <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d')}}</p>
                                        @else 
                                            <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d')}} -
                                        {{ \Auth::user()->dateFormat($event['end_date'])}}</p>
                                        @endif
                                        <!-- <span>{{date('h:i A', strtotime($event['start_time']))}} - {{date('h:i A', strtotime($event['end_time']))}}</span>                                     -->
                                                                          
                                            <!-- <p>{{ $event['type'] }}</p>
                                            <h5 class="card-text">{{ $event['name'] }}</h5> -->
                                                    <!-- <p class="card-text">{{ $event['description'] }}</p>  -->
                                                                                                            
                                        </div>
                                    </div>
                                @endforeach                            
                                @can('Create Meeting')
                                    <div class="col-12 text-end mt-3">
                                        <a href="{{ route('meeting.create',['meeting',0]) }}"> 
                                            <button  data-bs-toggle="tooltip"title="{{ __('Create Event') }}" class="btn btn-sm btn-primary btn-icon m-1">
                                            <i class="ti ti-plus"></i></button>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="inner_col">    
                                <h5 class="card-title mb-2">Past Events</h5>
                                @foreach($pastEvents as $event)
                                <div class="card">
                                    <div class="card-body">                                    
                                        <h4 class="card-text">{{ $event['name'] }}
                                            <span>({{ $event['type'] }})</span>
</h4>
                                        @if($event['start_date'] == $event['end_date'])
                                            <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d')}}</p>
                                        @else 
                                            <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d')}} -
                                        {{ \Auth::user()->dateFormat($event['end_date'])}}</p>
                                        @endif
                                        <!-- <span>{{date('h:i A', strtotime($event['start_time']))}} - {{date('h:i A', strtotime($event['end_time']))}}</span>                                     -->
                                    </div>
                                </div>                            
                                @endforeach 
                            </div>
                        </div>    
                        <div class="col-sm">
                            <div class="inner_col">   
                                <h5 class="card-title mb-2">Lost Leads</h5>
                                @foreach($lostLeads as $lead)
                                <div class="card">
                                    <div class="card-body">  
                                        <h4 class="card-text">{{ $lead['leadname'] }}
                                            <span>{{ $lead['type'] }}</span>
</h4>
                                        @if($event['start_date'] == $event['end_date'])
                                            <p>{{ Carbon\Carbon::parse($lead['start_date'])->format('M d')}}</p>
                                        @else 
                                            <p>{{ Carbon\Carbon::parse($lead['start_date'])->format('M d')}} -
                                        {{ \Auth::user()->dateFormat($lead['end_date'])}}</p>
                                        @endif
                                        <!-- <span>{{date('h:i A', strtotime($lead['start_time']))}} - {{date('h:i A', strtotime($lead['end_time']))}}</span>                                                                                                                  -->
                                    </div>
                                </div>                            
                                @endforeach 
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

    @push('script-page')
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "dc4641f860664c6e824b093274f50291"}'></script>
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
                                dayGridMonth: "{{ __('Month') }}",
                            },
                            slotLabelFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                            },
                            themeSystem: 'bootstrap',
                            navLinks: true,
                            droppable: false,
                            eventLimit: true,
                            selectable: true,
                            selectMirror: true,
                            editable: false,
                            dayMaxEvents: 1,
                            handleWindowResize: true,
                            height: 'auto',
                            timeFormat: 'H(:mm)',
                            events: data,
                            select: function(info) {
                                var startDate = info.startStr;
                                var endDate = info.endStr;
                                localStorage.setItem('startDate', JSON.stringify(info));
                                openPopupForm(startDate, endDate);
                            },
                            eventContent: function(arg) {
                                return {
                                    html: arg.event.title,
                                };
                            },
                            eventMouseEnter: function(arg) {
                                if (arg.event.extendedProps.blocked_by) {
                                    arg.el.innerHTML += '<div class="blocked-by-tooltip">' + 'By:' + arg.event.extendedProps.blocked_by + '</div>';
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
                }

            });
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
                    $('input[name="start_time"]').attr('min', '00:00');
                    $('input[name="start_time"]').val('00:00');
                    $('input[name="start_time"]').attr('value', '00:00');
                    $('input[name="end_time"]').attr('min', '00:00');
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

                document.getElementById('purpose').value = '';
                $('.venue-checkbox').prop('checked', false);
                $('input[name="start_time"]').attr('min', '00:00');
                $('input[name="start_time"]').val('00:00');
                $('input[name="start_time"]').attr('value', '00:00');
            }

        }
    </script>
   
    <script>
        /* function toggleOptions() {
            var optionsContainer = document.getElementsByClassName('optionsContainer')[0];
            optionsContainer.style.display = optionsContainer.style.display === 'none' ? 'block' : 'none';
        } */

        function showUpcoming() {
            window.location.href = "{{ url('/meeting-upcoming') }}";
        }

        function showCompleted() {
            window.location.href = "{{ url('/meeting-completed') }}";
        }

        function leads() {
            window.location.href = "{{ url('/lead') }}";
        }
        jQuery(function() {
            $('div#toggleDiv').click(function(e) {
                e.preventDefault();
                $('div.optionsContainer').toggle('show');
            })
        })
    </script>
    @endpush