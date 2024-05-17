@extends('layouts.admin')
@section('page-title')
{{__('Customers')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Customers')}}
</div>
@endsection
@section('action-btn')
<a href="#" data-url="{{ route('uploadusersinfo') }}" data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip"
    data-title="{{__('Upload User')}}" title="{{__('Upload')}}" class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-plus"></i>
</a>

@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Customers')}}</li>
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
                                                <th scope="col" class="sort" data-sort="name">{{__('Name')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Email')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Phone')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Address')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Category')}} <span class="opticy"> dddd</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allcustomers as $customers)
                                            <tr>
                                                <td>
                                                    @if($customers->category == 'event')
                                                    <a href="{{route('event.userinfo',urlencode(encrypt($customers->ref_id)))}}"
                                                        title="{{ __('User Details') }}"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst($customers->name) }}</b>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('lead.userinfo',urlencode(encrypt($customers->ref_id))) }}"
                                                        data-size="md" title="{{ __('Lead Details') }}"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst($customers->name) }}</b>
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>{{ucfirst($customers->email)}}</td>
                                                <td>{{ucfirst($customers->phone)}}</td>
                                                <td>{{ucfirst($customers->address)}}</td>
                                                <td>{{ucfirst($customers->type)}}</td>
                                            </tr>
                                            @endforeach
                                            @foreach($importedcustomers as $customers)
                                            <tr>
                                                <td> <a href="{{ route('customer.info',urlencode(encrypt($customers->id)))}}?cat={{$customers->category}}"
                                                        data-size="md" title="{{ __('User Details') }}"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst($customers->name) }}</b>
                                                    </a>
                                                </td>
                                                <td>{{ucfirst($customers->email)}}</td>
                                                <td>{{ucfirst($customers->phone)}}</td>
                                                <td>{{ucfirst($customers->address)}}</td>
                                                <td>{{ucfirst($customers->category)}}</td>
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