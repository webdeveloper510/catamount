@extends('layouts.admin')
@section('page-title')
{{ __('Customer') }}
@endsection
@section('title')
{{ __('Customer') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('siteusers') }}">{{ __('Customers') }}</a></li>
<li class="breadcrumb-item">{{ $category }}</li>
@endsection
@section('action-btn')
<a href="#" data-url="{{ route('uploadusersinfo') }}" data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip"
    data-title="{{__('Upload User')}}" title="{{__('Upload')}}" class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-plus"></i>
</a>
<a href="{{ route('exportuser') }}" data-bs-toggle="tooltip" data-title="{{__('Export User')}}" title="{{__('Export')}}"
    class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-table-export"></i>
</a>
@endsection
@section('content')
<div class="container-field">
    <div id="wrapper">

        <div id="page-content-wrapper">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">{{__('Name')}}</th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Email')}}</th>
                                                <th scope="col" class="sort">{{__('Phone')}}</th>
                                                <th scope="col" class="sort">{{__('Category')}}</th>
                                                <th scope="col" class="sort">{{__('Address')}}</th>
                                                <th scope="col" class="sort">{{__('Notes')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('customer.info',urlencode(encrypt($user->id))) }}?cat={{$category}}"
                                                        data-size="md" title="{{ __('User Details') }}"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst($user->name) }}</b>
                                                    </a>
                                                </td>
                                                <td><span>{{$user->email}}</span></td>
                                                <td><span>{{$user->phone}}</span></td>
                                                <td><span>{{ucfirst($user->category)}}</span></td>
                                                <td><span>{{ucfirst($user->address)}}</span></td>
                                                <td><span>@if($user->notes == '') -- @else{{$user->notes}}@endif</span></td>
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
@push('script-page')
<script>
function storeIdInLocalStorage(link) {
    var id = link.id;
    localStorage.setItem('clickedLinkId', id);
}
</script>
@endpush