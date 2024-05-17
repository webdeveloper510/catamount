@extends('layouts.admin')
@section('page-title')
{{__('Emails')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Email Communication')}}
</div>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item"><a href="{{ route('email.index') }}">{{__('Emails')}}</a></li>
<li class="breadcrumb-item">{{__('Communication')}}</li>

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
                                                <th scope="col" class="sort" data-sort="name">{{__('Name')}}</th>
                                                <th scope="col" class="sort" data-sort="name"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lead_id as $lead)
                                            <tr>
                                                <td>{{ucfirst(App\Models\Lead::withTrashed()->find($lead['lead_id'])->name)}}
                                                </td>
                                                <td><a href="{{ route('email.conversations', urlencode(encrypt($lead['id']))) }}"
                                                        data-size="md" title="{{ __('Lead Details') }}"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;"><button class="btn btn-secondary float-end" type="button">Email Communication</button></a></td>
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