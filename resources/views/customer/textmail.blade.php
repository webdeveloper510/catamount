@extends('layouts.admin')

@section('page-title')
    {{ __('Text Mail') }}
@endsection
@section('title')
    {{ __('Text Mail') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Text Mail') }}</li>
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/summernote/summernote-bs4.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('css/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        if ($(".pc-tinymce-2").length) {
            tinymce.init({
                selector: '.pc-tinymce-2',
                height: "400",
                content_style: 'body { font-family: "Inter", sans-serif; }'
            });
        }

        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
            });
        });

    </script>
@endpush
@section('content')
<div class="container-field">
    <div id="wrapper">
        <div id="sidebar-wrapper">
            <div class="card sticky-top" style="top:30px">
                <div class="list-group list-group-flush sidebar-nav nav-pills nav-stacked" id="menu">
                    <a href="#useradd-1" class="list-group-item list-group-item-action">
                        <span class="fa-stack fa-lg pull-left"><i class="ti ti-calendar"></i></span>
                        <span class="dash-mtext">{{ __('Create Mail') }} </span></a>
                </div>
            </div>
        </div>
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id = "useradd-1">
                            <div class="card-body">
                                <div class="language-wrap">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-9 col-sm-12 language-form-wrap">
                                            {{Form::open(array('route'=>'store.email.template','method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))}}
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    {{ Form::label('subject', __('Subject'), ['class' => 'form-control-label text-dark']) }}
                                                    {{ Form::text('subject', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{ Form::label('from', __('From'), ['class' => 'form-control-label text-dark']) }}
                                                    {{ Form::text('from',null, ['class' => 'form-control font-style', 'required' => 'required']) }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    {{ Form::label('content', __('Email Message'), ['class' => 'form-control-label text-dark']) }}
                                                    {{ Form::textarea('content',null, ['class' => 'summernote', 'required' => 'required']) }}
                                                </div>
                                                <div class="col-md-12 text-end">
                                                    <input type="submit" value="{{ __('Save') }}"
                                                        class="btn btn-print-invoice  btn-primary">
                                                </div>

                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
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