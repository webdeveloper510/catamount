@extends('layouts.admin')
@section('page-title')
{{__('Blocked Date')}}
@endsection
@section('title')
{{__('Blocked Date')}}
@endsection


@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Home')}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{__('Blocked Date')}}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="">
            <dl class="row">
                <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Start Date')}}</span></dt>
                <dd class="col-md-5"><span class="text-md">{{\Auth::user()->dateFormat($user_data->start_date)}}</span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('End Date')}}</span></dt>
                <dd class="col-md-5"><span class="text-md">{{\Auth::user()->dateFormat($user_data->end_date)}}</span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Start Time')}}</span></dt>
                <dd class="col-md-5"><span class="text-md">{{date('h:i A', strtotime($user_data->start_time))}}</span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('End Time')}}</span></dt>
                <dd class="col-md-5"><span class="text-md">{{date('h:i A', strtotime($user_data->end_time))}}</span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Venue')}}</span></dt>
                <dd class="col-md-5"><span class="text-md">{{$user_data->venue}}</span></dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Purpose')}}</span></dt>
                <dd class="col-md-5"><span class="text-md">{{$user_data->purpose}}</span></dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Blocked_by')}}</span></dt>
                <dd class="col-md-5"><span class="text-md">{{$blocked_username}}</span></dd>
            </dl>
        </div>
    </div>
    <div>
        @if(\Auth::user()->type == 'owner')
        <div>
            <a href="{{ url('/unblock-date/' . $user_data->id) }}"class="btn btn-secondary">Unblock This
                Date</a>
        </div>
        @else
        @if(\Auth::user()->id == $user_data->created_by)
        <div >
            <a href="{{ url('/unblock-date/' . $user_data->id) }}" class="btn btn-secondary">Unblock This
                Date</a>
        </div>
        @endif
        @endif

    </div>

</div>
@endsection