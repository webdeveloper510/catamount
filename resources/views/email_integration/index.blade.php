@extends('layouts.admin')
@section('page-title')
{{__('Emails')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Emails')}}
</div>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Emails')}}</li>
@endsection
@section('action-btn')

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
                                                <th scope="col" class="sort" data-sort="name">{{__('Staff Member')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)

                                            <tr>
                                                <td> {{ucfirst($user['name'])}} <b>({{$user['type']}})</b>
                                                </td>
                                                <td><a href="{{ route('email.details',urlencode(encrypt($user['id']))) }}"
                                                        data-size="md" title="{{ __('Lead Details') }}"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;"><button class="btn btn-secondary float-end" type="button">View</button></a></td>
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