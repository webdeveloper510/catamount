@extends('layouts.admin')
@section('page-title')
    {{__('Lead')}}
@endsection
@section('title')
        <div class="page-header-title">
            {{__('Email Templates')}}
        </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Home')}}</a></li>
    <li class="breadcrumb-item">{{__('Email Templates')}}</li>
@endsection
@section('action-btn')
        <a href="{{route('email.template.create')}}"  data-size="lg" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary btn-icon m-1">
            <i class="ti ti-plus"></i>
        </a>
@endsection

@section('content')
<div class="container-field">
    <div id="wrapper">
        <div id="sidebar-wrapper">
            <div class="card sticky-top" style="top:30px">
                <div class="list-group list-group-flush sidebar-nav nav-pills nav-stacked" id="menu">
                    <a href="#useradd-1" class="list-group-item list-group-item-action">
                        <span class="fa-stack fa-lg pull-left"><i class="ti ti-calendar"></i></span>
                        <span class="dash-mtext">{{ __('Template') }} </span></a>
                </div>
            </div>
        </div>
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="card" id ="useradd-1">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable" id="datatable">
                        <thead>
                            <tr>
                                <th>{{__('Email Templates')}}</th>
                                <th class="text-end">{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($EmailTemplate as $key=>$template)
                                <tr>
                                    <td>
                                    <b>{{ucfirst($template->subject)}}</b>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-btn bg-info ms-2">
                                                <a href="{{ route('edit.email.template',$template->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white " data-bs-toggle="tooltip"title="{{__('Details')}}" data-title="{{__('Edit Lead')}}"><i class="ti ti-edit"></i></a>
                                            </div>
                                        <div class="action-btn bg-danger ms-2">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['delete.email.template', $template->id]]) !!}
                                            <a href="#!" class="mx-3 btn btn-sm  align-items-center text-white show_confirm" data-bs-toggle="tooltip" title='Delete'>
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        {!! Form::close() !!}
                                        </div>
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
@endsection