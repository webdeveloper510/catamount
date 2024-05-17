@extends('layouts.admin')
@section('page-title')
{{__('Proposal')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Proposal')}}
</div>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item"><a href="{{ route('lead.index') }}">{{__('Leads')}}</a></li>
<li class="breadcrumb-item">{{__('Proposal Information')}}</li>
@endsection
@section('action-btn')
<?php $status= App\Models\Lead::find($decryptedId)->status; ?>
@if($status > 1)
<a href="#" data-size="md" data-url="{{ route('lead.shareproposal',urlencode(encrypt($decryptedId))) }}"
    data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Proposal') }}" title="{{ __('Share Proposal') }}"
    class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-share"></i>
</a>
@endif
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
                                                <!-- <th scope="col" class="sort" data-sort="name">{{__('Lead')}}</th> -->
                                                <th scope="col" class="sort" data-sort="name">{{__('Proposal')}}</th>
                                                <!-- <th scope="col" class="sort" data-sort="budget">{{__('Email')}}</th> -->
                                                <th scope="col" class="sort">{{__('Notes')}}</th>
                                                <th scope="col" class="sort">{{__('Document')}}</th>
                                                <th scope="col" class="sort">{{__('Created On')}}</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($proposal_info as $info)
                                            <tr>
                                                <td>{{App\Models\Lead::where('id',$info->lead_id)->first()->name}}</td>
                                                <!-- <td>{{App\Models\Lead::where('id',$info->lead_id)->first()->email}}</td> -->
                                                <td>{{$info->notes ?? '--'}}</td>
                                                <td><a href="{{route('lead.viewproposal',urlencode(encrypt($info->lead_id))) }}"
                                                        style=" color: teal;">View
                                                        Document</a></td>
                                                <td>{{ \Auth::user()->dateFormat($info->created_at) }}</td>
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