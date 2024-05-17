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
<style>
h6 {
    font-size: 12px !important;
}
</style>
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz" id="useradd-1">
                <div class="row">
                    @if (\Auth::user()->type == 'owner'||\Auth::user()->type == 'Admin')
                    <div class="col-lg-4 col-sm-12 totallead" style="padding: 15px;">
                        <a href="{{route('lead.index')}}" target="_blank">
                            <div class="card">
                                <div class="card-body newcard_body" onclick="leads();">
                                    <div class="theme-avtar bg-info">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                    <div class="right_side">
                                        <h6 class="mb-3">{{ __('Active Leads') }}</h6>
                                        <h3 class="mb-0">{{ $data['totalLead'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-12" id="toggleDiv" style="padding: 15px;">
                        <a href="{{route('meeting.index')}}" target="_blank">
                            <div class="card">
                                <div class="card-body newcard_body">
                                    <div class="theme-avtar bg-warning">
                                        <i class="fa fa-tasks"></i>
                                    </div>
                                    <div class="right_side">
                                        <h6 class="mb-3">{{ __('Active/Upcoming Events') }}</h6>
                                        <h3 class="mb-0">{{ @$upcoming }} </h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-sm-12" style="padding: 15px;">
                        <a href="{{route('billing.index')}}" target="_blank">
                            <div class="card">
                                <div class="card-body newcard_body new-div">
                                    <div class="theme-avtar bg-success">
                                        <i class="fa fa-dollar-sign"></i>
                                    </div>
                                    <div class="flex-div">
                                        <div style="">
                                            <h6 class="mb-0">{{ __('Amount(E)') }}</h6>
                                            <h3 class="mb-0">
                                                {{ $events_revenue != 0 ? '$'.number_format($events_revenue) : '--' }}
                                            </h3>
                                        </div>
                                        <div class="mt10">
                                            <h6 class="mb-0">{{ __('Amount Recieved(E)') }}</h6>
                                            <h3 class="mb-0">
                                                {{ $events_revenue_generated != 0 ? '$'.number_format($events_revenue_generated) : '--' }}
                                            </h3>

                                        </div>
                                        <!-- </div>
                                    <div class="right_side" style="    width: 35% !important;"> -->
                                    </div>
                                </div>
                            </div>
                    </div>
                    </a>
                    @endif
                    @php
                    $setting = App\Models\Utility::settings();
                    @endphp
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="inner_col">
                            <h5 class="card-title mb-2">Active Leads</h5>
                            <div class="scrol-card">

                                @foreach($activeLeads as $lead)

                                <div class="card">
                                    <div class="card-body new_bottomcard">
                                        <h5 class="card-text">{{ $lead['leadname'] }}
                                            <span>({{ $lead['type'] }})</span>
                                        </h5>

                                        @if($lead['start_date'] == $lead['end_date'])
                                        <p>{{ Carbon\Carbon::parse($lead['start_date'])->format('M d')}}</p>
                                        @else
                                        <p>{{ Carbon\Carbon::parse($lead['start_date'])->format('M d')}} -
                                            {{ \Auth::user()->dateFormat($lead['end_date'])}}
                                        </p>
                                        @endif
                                        @can('Show Lead')
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="javascript:void(0);" data-size="md"
                                                data-url="{{ route('lead.show',$lead['id']) }}" data-bs-toggle="tooltip"
                                                title="{{__('Quick View')}}" data-ajax-popup="true"
                                                data-title="{{__('Lead Details')}}"
                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </div>
                                        @endcan
                                    </div>

                                </div>
                                @endforeach
                            </div>
                            @can('Create Lead')
                            <div class="col-12 text-end mt-3">
                                <a href="javascript:void(0);" data-url="{{ route('lead.create',['lead',0]) }}"
                                    data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip"
                                    data-title="{{__('Create New Lead')}}" title="{{__('Create Lead')}}"
                                    class="btn btn-sm btn-primary btn-icon m-1">
                                    <i class="ti ti-plus"></i>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="inner_col">
                            <h5 class="card-title mb-2">Active/Upcoming Events</h5>
                            <div class="scrol-card">
                                @foreach($activeEvent as $event)

                                <div class="card">
                                    <div class="card-body new_bottomcard">
                                        <h5 class="card-text">{{ $event['name'] }}
                                            <span>({{ $event['type'] }})</span>
                                        </h5>
                                        @if($event['start_date'] == $event['end_date'])
                                        <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d')}}</p>
                                        @else
                                        <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d')}} -
                                            {{ \Auth::user()->dateFormat($event['end_date'])}}
                                        </p>
                                        @endif
                                        @can('Show Meeting')
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="javascript:void(0);" data-size="md"
                                                data-url="{{ route('meeting.show', $event['id']) }}"
                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                data-title="{{ __('Event Details') }}" title="{{ __('Quick View') }}"
                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @can('Create Meeting')
                            <div class="col-12 text-end mt-3">
                                <a href="{{ route('meeting.create',['meeting',0]) }}">
                                    <button data-bs-toggle="tooltip" title="{{ __('Create Event') }}"
                                        class="btn btn-sm btn-primary btn-icon m-1">
                                        <i class="ti ti-plus"></i></button>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="inner_col">
                            <h5 class="card-title mb-2">Finances</h5>
                            <div class="scrol-card">
                                <div class="card">
                                    <div class="card-body">
                                        @foreach($events as $event)
                                        <?php
                                            $pay = App\Models\PaymentLogs::where('event_id',$event['id'])->get();
                                            $total = 0;
                                            foreach($pay as $p){
                                            $total += $p->amount;
                                            }
                                        ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-text">{{ $event['name'] }}
                                                    <span>({{ $event['type'] }})</span>
                                                </h5>

                                                <div style="color: #a99595;">
                                                    Billing Amount: ${{ number_format($event['total'])}}<br>
                                                    Pending Amount: ${{number_format($event['total']- $total)}}
                                                </div>

                                                <div class="date-y">
                                                    @if($event['start_date'] == $event['end_date'])
                                                    <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d, Y')}}
                                                    </p>
                                                    @else
                                                    <p>{{ Carbon\Carbon::parse($event['start_date'])->format('M d, Y')}}
                                                        -
                                                        {{ \Auth::user()->dateFormat($event['end_date'])}}
                                                    </p>
                                                    @endif
                                                </div>
                                                @can('Show Invoice')
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#" data-size="md"
                                                        data-url="{{ route('billing.show',$event['id']) }}"
                                                        data-bs-toggle="tooltip" title="{{__('Quick View')}}"
                                                        data-ajax-popup="true" data-title="{{__('Invoice Details')}}"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                </div>
                                                @endcan

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
        </div>
    </div>
</div>
<style>
h5.card-text {
    font-size: 16px;
}


.flex-div {
    display: flex;
    justify-content: space-between;
}

.inner_col {
    padding: 10px;
    border: 1px dotted #ccc;
    border-radius: 20px;
    margin-top: 10px;
}

.date-y {
    float: right;
    padding-bottom: 10px;
    text-align: right;
    width: 100%;
    margin-top: 10px;
}

.inner_col p {
    position: intial !important;
}

.right_side {
    /* width: 70%; */
    float: left;
    text-align: left;
}

.theme-avtar {
    margin-right: 10px;
}

.inner_col .scrol-card {
    padding: 10px;
    border: 1px dotted #ccc;
    border-radius: 20px;
    margin-top: 10px;
    max-height: 210px;
    overflow-y: scroll;
}

.inner_col {
    min-height: 320px;
}

@media only screen and (max-width: 1280px) {
    .flex-div {
        display: block !important;
    }

    .card {

        height: 100%;
    }

    .new-div {
        display: flex;

    }

    .mt10 {
        margin-top: 10px;
    }
}
</style>

@endsection
@push('script-page')
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('firebase-messaging-sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            })
            .catch(function(err) {
                console.error('ServiceWorker registration failed: ', err);
            });
    });
}
</script>

<script>
$(document).ready(function() {
    var firebaseConfig = {
        apiKey: "AIzaSyB3y7uzZSAP39LOIvZwOjJOdFD2myDnvQk",
        authDomain: "notify-71d80.firebaseapp.com",
        projectId: "notify-71d80",
        storageBucket: "notify-71d80.appspot.com",
        messagingSenderId: "684664764020",
        appId: "1:684664764020:web:71f82128ffc0e20e3fc321",
        measurementId: "G-FTD60E8WG9"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    messaging
        .requestPermission()
        .then(function() {
            return messaging.getToken()
        })
        .then(function(response) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("store.token") }}',
                type: 'POST',
                data: {
                    token: response
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log('Token stored.');
                },
                error: function(error) {
                    console.log(error);
                },
            });
        }).catch(function(error) {
            console.log(error);
        });
    messaging.onMessage(function(payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
})
</script>
@endpush