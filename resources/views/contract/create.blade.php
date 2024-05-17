@php
$plansettings = App\Models\Utility::plansettings();
@endphp
@extends('layouts.admin')
@section('page-title')
{{ __('Contracts') }}
@endsection
@section('title')
{{ __('Contracts') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item "><a href="{{ route('contracts.index') }}">{{ __('Contracts') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('New Contract') }}</li>
@endsection
@section('action-btn')
<!-- <a href="{{ route('contact.grid') }}" class="btn btn-sm btn-primary btn-icon m-1"
            data-bs-toggle="tooltip"title="{{ __('Grid View') }}">
            <i class="ti ti-layout-grid text-white"></i>
    </a> -->
@can('Create Contact')

<a href="{{ route('contracts.new_contract') }}" class="btn btn-sm btn-primary btn-icon m-1"
    title="{{ __('Create') }}">Create New Template</a>
@endcan
@endsection
@section('content')
<head>
    <meta charset="UTF-8">
    <script src="https://pd-js-sdk.s3.amazonaws.com/0.2.20/pandadoc-js-sdk.min.js"></script>
    <link rel="stylesheet" href="https://pd-js-sdk.s3.amazonaws.com/0.2.20/pandadoc-js-sdk.css" />
    <style>
    .pandadoc iframe {
        width: 100%;
        height: 480px;
    }
    </style>
</head>
<body>
<!-- <div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-header" style=" background: #dbe1e6;"><b>
                                                Use Templates</b></li>
                                    </ul>
                                    <ul class="list-group"
                                        style="display: grid; grid-template-columns: repeat(3, 1fr);">
                                      
                                        @foreach($results as $result)
                                        @foreach($result as $res)
                                        <li class="list-group-item list-item-style">
                                            <a href="{{ route('contracts.detail',$res['id']) }}" target="_blank"
                                                data-size="md" class="action-item text-primary"
                                                style="color:#1551c9 !important;">
                                                <b>{{ ucfirst(str_replace('[DEV] ', '', $res['name'])) }}</b>
                                            </a>
                                        </li>
                                        @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> -->
<div id="pandadoc-sdk" class="pandadoc"></div>


<script>
 var doclist = new PandaDoc.DocList({mode: PandaDoc.DOC_LIST_MODE.LIST});
doclist.init({
    el: '#pandadoc-sdk',
    data: {
        metadata: {
            Status: 'Completed' 
        }
    },
    cssClass: 'style-me',
    events: {
        onInit: function(){},
        onDocumentCreate: function(){}
    }
});
    </script>
</body>

@endsection
