@extends('layouts.admin')
@section('page-title')
{{__('Clients')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Clients')}}
</div>
@endsection
@section('action-btn')
<a href="#" data-url="{{ route('uploadusersinfo') }}" data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{__('Upload Client')}}" title="{{__('Upload')}}" class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-plus"></i>
</a>

@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Clients')}}</li>
@endsection
@section('content')

<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12 p0">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">{{__('Primary Contact')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="name">{{__('Organization')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Email')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Phone')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Address')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Category')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Lead Details')}} <span class="opticy"> dddd</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allcustomers as $customers)
                                            <tr>
                                                {{--@php
                                                @$customers = $customers[0];
                                                @endphp--}}
                                                <td>
                                                    @if(@$customers['category'] == 'event')
                                                    <a href="{{route('event.userinfo',urlencode(encrypt(@$customers['ref_id'])))}}" title="{{ __('User Details') }}" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst($customers['name']) }}</b>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('lead.userinfo',urlencode(encrypt(@$customers['ref_id']))) }}" data-size="md" title="{{ __('Lead Details') }}" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst(@$customers['name']) }}</b>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(@$customers['category'] == 'event')
                                                    <a href="{{route('event.userinfo',urlencode(encrypt(@$customers['ref_id'])))}}" title="{{ __('User Details') }}" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b>{{ucfirst(@$customers->company->company_name)}}</b>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('lead.userinfo',urlencode(encrypt(@$customers['ref_id']))) }}" data-size="md" title="{{ __('Lead Details') }}" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b>{{ucfirst(@$customers->company->company_name)}}</b>
                                                    </a>
                                                    @endif
                                                </td>
                                                <!-- <td>{{ucfirst(@$customers->company->company_name)}}</td> -->
                                                <td>{{ucfirst(@$customers['email'])}}</td>
                                                <td>{{ucfirst(@$customers['phone'])}}</td>
                                                <td>{{ucfirst(@$customers['address'])}}</td>
                                                <td>{{ucfirst(@$customers['type'])}}</td>
                                                <td class="text-end">
                                                    @can('Show Lead')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="javascript:void(0);" data-size="md" data-url="{{ route('lead.show',$customers->id) }}" data-bs-toggle="tooltip" title="{{__('Quick View')}}" data-ajax-popup="true" data-title="{{__('View Lead Details')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    @endcan
                                                </td>
                                            </tr>
                                            @endforeach
                                            @foreach($importedcustomers as $customers)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('customer.info',urlencode(encrypt($customers->id)))}}?cat={{$customers->category}}" data-size="md" title="{{ __('User Details') }}" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst($customers->name) }}</b>
                                                    </a>
                                                </td>
                                                {{--<td>{{ucfirst($customers->organization)}}</td>--}}
                                                <td>
                                                    @if(@$customers['category'] == 'event')
                                                    <a href="{{ route('customer.info',urlencode(encrypt($customers->id)))}}?cat={{$customers->category}}" title="{{ __('User Details') }}" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b>{{ucfirst($customers->organization)}}</b>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('customer.info',urlencode(encrypt($customers->id)))}}?cat={{$customers->category}}" data-size="md" title="{{ __('Lead Details') }}" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b>{{ucfirst($customers->organization)}}</b>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>{{ucfirst($customers->email)}}</td>
                                                <td>{{ucfirst($customers->phone)}}</td>
                                                <td>{{ucfirst($customers->address)}}</td>
                                                <td>{{ucfirst($customers->category)}}</td>
                                                <td class="text-end">
                                                   {{-- @can('Show Lead')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="javascript:void(0);" data-size="md" data-url="{{ route('lead.show',$customers->id) }}" data-bs-toggle="tooltip" title="{{__('Quick View')}}" data-ajax-popup="true" data-title="{{__('View Lead Details')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    @endcan--}}
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