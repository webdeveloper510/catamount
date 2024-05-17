<?php
$pay = App\Models\PaymentLogs::where('event_id',$event->id)->get();
$total = 0;
foreach($pay as $p){
$total += $p->amount;
}
?>
<div class="row">
    <div class="col-md-12">
        <dl class="row">
            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Type')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{ $event->type }}</span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Customer Name')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{ $event->name }}</span></dd>
            
            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Email')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{ $event->email }}</span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Phone')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{ $event->phone }}</span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Address')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{ $event->lead_address }}</span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Date')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{ \Auth::user()->dateFormat($event->start_date)}}</span></dd>

            
            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__(' Time')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">
                        @if($event->start_time == $event->end_time)
                        --
                        @else
                        {{date('h:i A', strtotime($event->start_time))}} -
                        {{date('h:i A', strtotime($event->end_time))}}
                        @endif
                    </span>
                </dd>
           
            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Venue')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{ $event->venue_selection }}</span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Billing Amount')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">${{ number_format($event->total) }}</span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__(' Amount Due')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">${{ number_format($event->total - $total) }}</span></dd>
            

            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Event Created')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">{{\Auth::user()->dateFormat($event->created_at)}}</span></dd>
            
            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Any Special Requirements')}}</span></dt>
            @if($event->spcl_req) 
                <dd class="col-md-6 need_half"><span class="">{{$event->spcl_req}}</span></dd>
            @else
                <dd class="col-md-6 need_half"><span class="">--</span></dd>
            @endif
            <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Status')}}</span></dt>
            <dd class="col-md-6 need_half"><span class="">
                @if($billing->status == 0)
                    <span class="badge bg-info p-2 px-3 rounded">{{__(\App\Models\Billing::$status[$billing->status]) }}</span>
                @elseif($billing->status == 1)
                    <span class="badge bg-warning p-2 px-3 rounded">{{__(\App\Models\Billing::$status[$billing->status]) }}</span>
                @else($billing->status == 2)
                    <span class="badge bg-success p-2 px-3 rounded">{{__(\App\Models\Billing::$status[$billing->status]) }}</span>
                @endif
            </dd>
        </dl>
    </div>
    <div class="w-100 text-end pr-2">
            @can('Manage Payment')
            <div class="action-btn bg-warning ms-2">
                <a href="{{ route('billing.estimateview',urlencode(encrypt($event->id)))}}"> 
                <button  data-bs-toggle="tooltip"title="{{ __('View Invoice') }}" class="btn btn-sm btn-secondary btn-icon m-1">
                <i class="fa fa-print"></i></button>
            </a>
            </div>
            @endcan
        </div>
</div>