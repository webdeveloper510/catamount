@extends('layouts.admin')
@section('page-title')
{{ __('Invoice') }}
@endsection
@section('title')
{{ __('Invoice') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Invoice') }}</li>
@endsection
@section('content')
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <div class="table-responsive overflow_hidden">
                                    <table id="datatable" class="table datatable align-items-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">{{ __('Name') }} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="status">{{ __('Event') }} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    {{ __('Event Date') }} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    {{ __('Payment Status') }} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    {{ __('Billing Amount') }}<span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    {{ __('Paid Amount') }} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="text-end">{{ __('Action') }}<span class="opticy"> dddd</span> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($events as $event)
                                            <tr>
                                                <td>
                                                    <a href="" data-size="md" data-title="{{ __('Invoice Details') }}"
                                                        class="action-item text-primary">
                                                        <a href="{{route('meeting.detailview',urlencode(encrypt($event->id)))}}"
                                                            data-size="md" title="{{ __('Detailed view ') }}"
                                                            style="color: #1551c9 !important;">
                                                            {{ ucfirst($event->name)}}</a>

                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="budget">{{ ucfirst($event->type)}}</span>
                                                </td>
                                                <td>
                                                    @if($event->start_date == $event->end_date)
                                                    <span
                                                        class="budget">{{\Auth::user()->dateFormat($event->start_date)}}</span>
                                                    @elseif($event->start_date != $event->end_date)
                                                    <span
                                                        class="budget">{{ Carbon\Carbon::parse($event->start_date)->format('M d')}}
                                                        - {{\Auth::user()->dateFormat($event->end_date)}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(\App\Models\Billing::where('event_id',$event->id)->exists())
                                                    <?php $bill = \App\Models\Billing::where('event_id', $event->id)->pluck('status')->first() ?>
                                                    @if($bill == 1)
                                                    <span
                                                        class=" text-info">{{__(\App\Models\Billing::$status[$bill]) }}</span>
                                                    @elseif($bill == 2)
                                                    <span
                                                        class=" text-warning ">{{__(\App\Models\Billing::$status[$bill]) }}</span>
                                                    @else($bill == 3)
                                                    <span
                                                        class=" text-success">{{__(\App\Models\Billing::$status[$bill]) }}</span>
                                                    @endif
                                                    @else
                                                    <span
                                                        class=" text-danger ">{{__(\App\Models\Billing::$status[0]) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{($event->total != 0)? '$'. number_format($event->total):'--'}}
                                                </td>
                                                <td> @if(\App\Models\PaymentLogs::where('event_id',$event->id)->exists())
                                                    <?php $pay = App\Models\PaymentLogs::where('event_id',$event->id)->get();
                                                $deposit = App\Models\Billing::where('event_id',$event->id)->first();
                                                    $total = 0;
                                                    foreach($pay as $p){
                                                    $total += $p->amount;
                                                    }?>
                                                    {{ ($total != 0)?'$'.(isset($deposit)?$deposit->deposits:0) + $total:'--'}}
                                                    @endif</td>
                                                <td class="text-end">
                                                    <!-- <div class="action-btn bg-primary ms-2">
                                                        <a href="{{route('billing.invoicepdf',$event->id)}}" data-size="md"
                                                           title="{{__('Create')}}"class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-invoice"></i>
                                                        </a>
                                                    </div>  -->
                                                    @if(!(\App\Models\Billing::where('event_id',$event->id)->exists()))
                                                        @can('Create Payment')
                                                        <div class="action-btn bg-primary ms-2">
                                                            <a href="#" data-size="md"
                                                                data-url="{{ route('billing.create',['billing',$event->id]) }}"
                                                                data-bs-toggle="tooltip" title="{{__('Create')}}"
                                                                data-ajax-popup="true"
                                                                data-title="{{__('Invoice Details')}}"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                                <i class="ti ti-plus"></i>
                                                            </a>
                                                        </div>
                                                        @endcan
                                                    @endif
                                                    @if(\App\Models\Billing::where('event_id',$event->id)->exists())
                                                        @can('Manage Payment')
                                                        <?php 
                                                            $paymentLog = App\Models\PaymentLogs::where('event_id', $event->id)->orderBy('id', 'desc')->first();
                                                            $paymentInfo = App\Models\PaymentInfo::where('event_id',$event->id)->orderBy('id', 'desc')->first();
                                                        ?>
                                                        @if($paymentLog)
                                                            @if($paymentLog->amount != 0)
                                                            <div class="action-btn bg-primary ms-2">
                                                                <a href="#" data-size="md"
                                                                    data-url="{{ route('billing.paylink',$event->id) }}"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{__('Share Payment Link')}}" data-ajax-popup="true"
                                                                    data-title="{{__('Payment Link')}}"
                                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                                    <i class="ti ti-share"></i>
                                                                </a>
                                                            </div>
                                                            @endif
                                                        @else
                                                        <div class="action-btn bg-primary ms-2">
                                                            <a href="#" data-size="md"
                                                                data-url="{{ route('billing.paylink',$event->id) }}"
                                                                data-bs-toggle="tooltip"
                                                                title="{{__('Share Payment Link')}}" data-ajax-popup="true"
                                                                data-title="{{__('Payment Link')}}"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                                <i class="ti ti-share"></i>
                                                            </a>
                                                        </div>
                                                        @endif
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" data-size="md"
                                                                data-url="{{ route('billing.paymentinfo',urlencode(encrypt($event->id))) }}"
                                                                data-bs-toggle="tooltip" title="{{__('Payment')}}"
                                                                data-ajax-popup="true"
                                                                data-title="{{__('Payment Information')}}"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                                <i class=" fa fa-credit-card "></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('Manage Payment')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" data-size="md"
                                                            data-url="{{ route('billing.show',$event->id) }}"
                                                            data-bs-toggle="tooltip" title="{{__('Quick View')}}"
                                                            data-ajax-popup="true"
                                                            data-title="{{__('Invoice Details')}}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    @endcan
                                                    @can('Delete Payment')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' =>
                                                        ['billing.destroy', $event->id]]) !!}

                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm  align-items-center text-white show_confirm"
                                                            data-bs-toggle="tooltip" title='Delete'>
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    @endcan
                                                    @endif

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection