@extends('layouts.admin')
@section('page-title')
    {{ __('Email Template Edit') }}
@endsection

@section('title')
    <div class="page-header-title">
        {{ __('Edit Email Template') }}
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('email.template.view') }}">{{ __('Email Template') }}</a></li>
    <li class="breadcrumb-item">{{ __('Details') }}</li>
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
<div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-2">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1" class="list-group-item list-group-item-action">{{ __('Edit Template') }} <div
                                    class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10">
                    <div class="card" id="useradd-1">
                        <div class="card-body">

                            <div class="language-wrap">
                                <div class="row">
                                    <div class="col-lg-12 col-md-9 col-sm-12 language-form-wrap">
                                    {{ Form::model($EmailTemplate, ['route' => ['update.email.template', $EmailTemplate->id], 'method' => 'POST' ,'id'=> 'formdata']) }}
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
@endsection