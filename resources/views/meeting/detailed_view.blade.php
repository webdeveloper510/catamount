<?php
if (isset($event->func_package) && !empty($event->func_package)) {
    $package = json_decode($event->func_package, true);
}
if (isset($event->ad_opts) && !empty($event->ad_opts)) {
    $additional = json_decode($event->ad_opts, true);
}
if (isset($event->bar_package) && !empty($event->bar_package)) {
    $bar = json_decode($event->bar_package, true);
}
/* $payments = App\Models\PaymentLogs::where('event_id', $event->id)->get();
$payinfo = App\Models\PaymentInfo::where('event_id', $event->id)->get(); */
$files = Storage::files('app/public/Event/' . $event->id);


if (App\Models\PaymentLogs::where('event_id', $event->id)->exists()) {
    $payments = App\Models\PaymentLogs::where('event_id', $event->id)->orderBy('id', 'desc')->get();
    $payinfo = App\Models\PaymentInfo::where('event_id', $event->id)->get();
}
if (App\Models\Billing::where('event_id', $event->id)->exists()) {
    $deposit = App\Models\Billing::where('event_id', $event->id)->first();
}
$beforedeposit = App\Models\Billing::where('event_id', $event->id)->first();

?>
@extends('layouts.admin')
@section('page-title')
{{ __('Training Information') }}
@endsection
@section('title')
{{ __('Training Information') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Training Information') }}</li>
@endsection
@section('action-btn')

@endsection
@section('filter')
@endsection
@section('content')
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <dl class="row ">
                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Training')}}</span></dt>
                        @if($event->attendees_lead != 0)
                        <dd class="col-md-6 need_half"><span class="">{{ !empty($event->attendees_leads->leadname)?$event->attendees_leads->leadname:'--' }}</span>
                        </dd>
                        @else
                        <dd class="col-md-6 need_half"><span class="">{{$event->eventname}}</span></dd>
                        @endif
                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Training Type')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">{{$event->type}}</span></dd>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Date')}}</span></dt>
                        @if($event->start_date == $event->end_date)
                        <dd class="col-md-6 need_half"><span class="">{{\Auth::user()->dateFormat($event->start_date)}}</span>
                        </dd>
                        @else
                        <dd class="col-md-6 need_half "><span class="">{{\Auth::user()->dateFormat($event->start_date)}} -
                                {{\Auth::user()->dateFormat($event->end_date)}}</span></dd>
                        @endif

                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Time')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">{{date('h:i A', strtotime($event->start_time))}} -
                                {{date('h:i A', strtotime($event->end_time))}}</span></dd>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Guest Count')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">{{$event->guest_count}}</span></dd>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Trainings Location')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">{{$event->venue_selection}}</span></dd>
                        {{--<dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Deposits')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">@if(@$payinfo->deposits != 0){{@$payinfo->deposits}}@else -- @endif</span></dd>
                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Payments /Credit (-)')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">@if(@$payinfo->paymentCredit != 0){{@$payinfo->paymentCredit}}@else -- @endif</span></dd>--}}
                        @if(isset($package) && !empty($package))
                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Package')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">@foreach ($package as $key => $value)
                                {{implode(',',$value)}}
                                @endforeach
                            </span>
                        </dd>
                        @endif

                        @if(isset($additional) && !empty($additional))
                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Additional Items')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">@foreach ($additional as $key => $value)
                                {{implode(',',$value)}}
                                @endforeach
                            </span>
                        </dd>
                        @endif
                        @if(isset($bar) && !empty($bar))
                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Bar Package')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">
                                {{implode(',',$bar)}}
                            </span>
                        </dd>
                        @endif

                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Billing Amount')}}</span></dt>
                        <dd class="col-md-6 need_half"><span class="">@if($event->total != 0)${{$event->total}}@else Billing Not
                                Created @endif</span>
                        </dd>
                        <hr class="mt-5">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <h3>{{ __('Setup') }}</h3>
                            </div>
                        </div>
                        <hr>
                        <img src="{{$event->floor_plan}}" alt="" style="    width: 40% ;" class="need_full">
                    </dl>
                    @if(isset($payments) && !empty($payments))
                    <?php
                    $latefee = 0;
                    $adj = 0;
                    $collect_amount = 0;
                    foreach ($payinfo as $k => $val) {
                        $latefee += $val->latefee;
                        $adj += $val->adjustments;
                    }
                    foreach ($payments as  $value) {
                        $collect_amount += $value->amount;
                    }

                    ?>
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <h3 class="mt-3 text-center">Transaction Summary</h3>
                                <div class="table-responsive overflow_hidden">
                                    <table id="datatable" class="table datatable align-items-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">{{ __('Created On') }}</th>
                                                <th scope="col" class="sort" data-sort="status">{{ __('Name') }}</th>
                                                <th scope="col" class="sort" data-sort="completion">{{ __('Transaction Id') }}
                                                </th>
                                                <th>{{__('Invoice')}}</th>
                                                <th scope="col" class="sort" data-sort="completion">{{ __('Event Amount') }}
                                                </th>
                                                <th scope="col" class="sort" data-sort="completion">{{ __('Amount Collected') }}
                                                </th>
                                                <th scope="col" class="sort" data-sort="completion">{{ __('Amount Due') }}</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payKey => $payment)
                                            <tr>
                                                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->created_at)->format('M d, Y')}}
                                                </td>
                                                <td>{{$payment->name_of_card}}</td>
                                                <td>{{$payment->transaction_id ?? '--'}}</td>
                                                <td><a href="{{ Storage::url('app/public/Invoice/'.$payment->event_id.'/'.$payment->invoices) }}" download style="    color: #1551c9 !important;">{{ucfirst($payment->invoices )}}</a>
                                                </td>
                                                <td>${{$event->total}}</td>
                                                <td>${{$payment->amount}}</td>
                                                <td>{{ $event->total - $payinfo[$payKey]->deposits - $payinfo[$payKey]->paymentCredit - $payinfo[$payKey]->collect_amount }}
                                                </td>
                                            </tr>

                                            @endforeach
                                            <hr>
                                            <tr style="    background: aliceblue;">
                                                <td></td>
                                                <td colspan='3'><b>Deposits on File:</b></td>
                                                <td colspan='3'>
                                                    {{( $beforedeposit->deposits != 0) ? '$'.$beforedeposit->deposits : '--' }}
                                                </td>
                                            </tr>
                                            <tr style="    background: aliceblue;">
                                                <td></td>
                                                <td colspan='3'><b>Payments /Credit (-):</b></td>
                                                <td colspan='3'>
                                                    {{( $beforedeposit->paymentCredit != 0 ) ? '$'.$beforedeposit->paymentCredit : '--' }}
                                                </td>
                                            </tr>
                                            <tr style="background: darkgray;">
                                                <td></td>
                                                <td colspan='3'><b>Adjustments:</b></td>
                                                <td colspan='3'>{{($adj != 0) ? '$'.$adj : '--' }}</td>
                                            </tr>
                                            <tr style=" background: #c0e3c0;">
                                                <td></td>
                                                <td colspan='3'><b>Latefee:</b></td>
                                                <td colspan='3'>{{ ($latefee != 0) ? '$'. $latefee :'--' }}</td>
                                            </tr>
                                            <tr style="    background: floralwhite;">
                                                <td></td>
                                                <td colspan='3'><b>Total Amount Recieved:</b></td>
                                                <td colspan='3'>
                                                    {{((isset($beforedeposit->deposits) && isset($beforedeposit->paymentCredit) ? $beforedeposit->deposits + $beforedeposit->paymentCredit : 0) + $collect_amount<=0) ? '--' : '$'.((isset($beforedeposit->deposits) && isset($beforedeposit->paymentCredit) ? $beforedeposit->deposits + $beforedeposit->paymentCredit : 0) + $collect_amount)}}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                @if(isset($files) && !empty($files))
                                <h3>Attachments</h3>
                                <hr>
                                <div class="col-md-12" style="display:flex;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Attachment</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($files as $file)
                                            <tr>
                                                <td>{{ basename($file) }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($file) }}" download style=" position: absolute;color: #1551c9 !important">
                                                        View Document</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection