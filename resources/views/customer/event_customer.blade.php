@extends('layouts.admin')
@section('page-title')
{{ __('Training Clients') }}
@endsection
@section('title')
{{ __('Training Clients') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('siteusers') }}">{{ __('Clients') }}</a></li>
<li class="breadcrumb-item">{{ __('Training Clients') }}</li>
@endsection
@section('content')
<div class="container-field">
    <div id="wrapper">

        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">{{__('Primary Contact')}}</th>
                                                <th scope="col" class="sort" data-sort="organization">{{__('Organization')}}</th>
                                                <th scope="col" class="sort" data-sort="email">{{__('Email')}}</th>
                                                <th scope="col" class="sort">{{__('Phone')}}</th>
                                                <th scope="col" class="sort">{{__('Address')}}</th>
                                                <th scope="col" class="sort">{{__('Training')}}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eventcustomers as $user)
                                            <tr>
                                                <td><a href="{{route('event.userinfo',urlencode(encrypt($user->id)))}}" title="{{ __('User Details') }}" class="action-item text-primary" style="color:#1551c9 !important;"><b> {{ ucfirst($user->name) }}</b></a></td>
                                                <td><span>{{$user->company_name}}</span></td>
                                                <td><span>{{$user->email}}</span></td>
                                                <td><span>{{$user->phone}}</span></td>
                                                <td><span>{{$user->lead_address}}</span></td>
                                                <td><span>{{$user->type}}</span></td>
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