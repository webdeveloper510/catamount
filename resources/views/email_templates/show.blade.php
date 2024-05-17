@extends('layouts.admin')

@section('page-title')
    {{ __('Email Templates') }}
@endsection

@section('title')
    {{ __('Email Templates') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Email Templates') }}</li>
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
@php
  $lang = isset($users->lang) ? $users->lang : 'en';
  if ($lang == null) {
      $lang = 'en';
  }
  $LangName = $currEmailTempLang->language;
@endphp
@section('action-btn')
    <div class="text-end mb-3">
        <div class="d-flex justify-content-end drp-languages">
            <ul class="list-unstyled mb-0 m-2">
                <li class="dropdown dash-h-item drp-language" style="list-style-type: none;">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="drp-text hide-mob text-primary">{{ ucFirst($LangName->fullName)  }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                        @foreach ($languages as $code => $lang)
                            <a href="{{ route('manage.email.language', [$emailTemplate->id, $code]) }}"
                                class="dropdown-item {{ $currEmailTempLang->lang == $lang ? 'text-primary' : '' }}">{{ ucfirst($lang) }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
            <ul class="list-unstyled mb-0 m-2">
                <li class="dropdown dash-h-item drp-language" style="list-style-type: none;">
                    <a class="dash-head-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="drp-text hide-mob text-primary">{{ __('Template: ') }}
                            {{ $emailTemplate->name }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                        @foreach ($EmailTemplates as $EmailTemplate)
                            <a href="{{ route('manage.email.language', [$EmailTemplate->id, Request::segment(3) ? Request::segment(3) : \Auth::user()->lang]) }}"
                                class="dropdown-item {{ $emailTemplate->name == $EmailTemplate->name ? 'text-primary' : '' }}">{{ $EmailTemplate->name }}
                            </a>
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </div> 
   
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="row">

            </div>
            <div class="card">
                <div class="card-body">

                    <div class="language-wrap">
                        <div class="row">
                            <h6>{{ __('Place Holders') }}</h6>
                            <div class="col-lg-12 col-md-9 col-sm-12 language-form-wrap">

                                <div class="card">
                                    <div class="card-header card-body">
                                        <div class="row text-xs">
                                            @if ($emailTemplate->slug == 'new_user')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Email') }} : <span
                                                            class="pull-right text-primary">{email}</span></p>
                                                    <p class="col-6">{{ __('Password') }} : <span
                                                            class="pull-right text-primary">{password}</span></p>
                                                </div>
                                            @elseif($emailTemplate->slug == 'lead_assigned')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Lead Name') }} : <span
                                                            class="pull-right text-primary">{lead_name}</span></p>
                                                    <p class="col-6">{{ __('Lead Email') }} : <span
                                                            class="pull-right text-primary">{lead_email}</span></p>
                                                    <p class="col-6">{{ __('Lead Assign User') }} : <span
                                                            class="pull-right text-primary">{lead_assign_user}</span></p>
                                                    <p class="col-6">{{ __('Lead Description') }} : <span
                                                            class="pull-right text-primary">{lead_description}</span></p>
                                                    <p class="col-6">{{ __('Lead Source') }} : <span
                                                            class="pull-right text-primary">{lead_source}</span></p>
                                                </div>
                                            @elseif($emailTemplate->slug == 'task_assigned')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Task Name') }} : <span
                                                            class="pull-right text-primary">{task_name}</span></p>
                                                    <p class="col-6">{{ __('Task Start Date') }} : <span
                                                            class="pull-right text-primary">{task_start_date}</span></p>
                                                    <p class="col-6">{{ __('Task Due Date') }} : <span
                                                            class="pull-right text-primary">{task_due_date}</span></p>
                                                    <p class="col-6">{{ __('Task Stage') }} : <span
                                                            class="pull-right text-primary">{task_stage}</span></p>
                                                    <p class="col-6">{{ __('Task Assign User') }} : <span
                                                            class="pull-right text-primary">{task_assign_user}</span></p>
                                                    <p class="col-6">{{ __('Task Description') }} : <span
                                                            class="pull-right text-primary">{task_description}</span></p>
                                                </div>
                                            @elseif($emailTemplate->slug == 'quote_created')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Quote Number') }} : <span
                                                            class="pull-right text-primary">{quote_number}</span></p>
                                                    <p class="col-6">{{ __('Billing Address') }} : <span
                                                            class="pull-right text-primary">{billing_address}</span></p>
                                                    <p class="col-6">{{ __('Shipping Address') }} : <span
                                                            class="pull-right text-primary">{shipping_address}</span></p>
                                                    <p class="col-6">{{ __('Quotation Description') }} : <span
                                                            class="pull-right text-primary">{description}</span></p>
                                                    <p class="col-6">{{ __('Quote Assign User') }} : <span
                                                            class="pull-right text-primary">{quote_assign_user}</span></p>
                                                    <p class="col-6">{{ __('Quoted Date') }} : <span
                                                            class="pull-right text-primary">{date_quoted}</span></p>
                                                </div>
                                            @elseif($emailTemplate->slug == 'new_sales_order')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Quote Number') }} : <span
                                                            class="pull-right text-primary">{quote_number}</span></p>
                                                    <p class="col-6">{{ __('Billing Address') }} : <span
                                                            class="pull-right text-primary">{billing_address}</span></p>
                                                    <p class="col-6">{{ __('Shipping Address') }} : <span
                                                            class="pull-right text-primary">{shipping_address}</span></p>
                                                    <p class="col-6">{{ __('Quotation Description') }} : <span
                                                            class="pull-right text-primary">{description}</span></p>
                                                    <p class="col-6">{{ __('Quoted Date') }} : <span
                                                            class="pull-right text-primary">{date_quoted}</span></p>
                                                    <p class="col-6">{{ __('Salesorder Assign User') }} : <span
                                                            class="pull-right text-primary">{salesorder_assign_user}</span>
                                                    </p>

                                                </div>
                                            @elseif($emailTemplate->slug == 'new_invoice' || $emailTemplate->slug == 'invoice_payment_recored')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Invoice Number') }} : <span
                                                            class="pull-right text-primary">{invoice_id}</span></p>
                                                    <p class="col-6">{{ __('Invoice Client') }} : <span
                                                            class="pull-right text-primary">{invoice_client}</span></p>
                                                    <p class="col-6">{{ __('Invoice Issue Date') }} : <span
                                                            class="pull-right text-primary">{created_at}</span></p>
                                                    <p class="col-6">{{ __('Invoice Status') }} : <span
                                                            class="pull-right text-primary">{invoice_status}</span></p>
                                                    <p class="col-6">{{ __('Invoice Total') }} : <span
                                                            class="pull-right text-primary">{invoice_total}</span></p>
                                                    <p class="col-6">{{ __('Invoice Sub Total') }} : <span
                                                            class="pull-right text-primary">{invoice_sub_total}</span></p>

                                                </div>
                                            @elseif($emailTemplate->slug == 'meeting_assigned')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Attendees User') }} : <span
                                                            class="pull-right text-primary">{attendees_user}</span></p>
                                                    <p class="col-6">{{ __('Attendees Contact') }} : <span
                                                            class="pull-right text-primary">{attendees_contact}</span></p>
                                                    <p class="col-6">{{ __('Meeting Title') }} : <span
                                                            class="pull-right text-primary">{meeting_name}</span></p>
                                                    <p class="col-6">{{ __('Meeting Start Date') }} : <span
                                                            class="pull-right text-primary">{meeting_start_date}</span></p>
                                                    <p class="col-6">{{ __('Meeting Due Date') }} : <span
                                                            class="pull-right text-primary">{meeting_due_date}</span></p>
                                                    <p class="col-6">{{ __('Meeting Assign User') }} : <span
                                                            class="pull-right text-primary">{meeting_assign_user}</span>
                                                    </p>
                                                    <p class="col-6">{{ __('Meeting Description') }} : <span
                                                            class="pull-right text-primary">{meeting_description}</span>
                                                    </p>
                                                </div>
                                            @elseif($emailTemplate->slug == 'campaign_assigned')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Campaign Title') }} : <span
                                                            class="pull-right text-primary">{campaign_title}</span></p>
                                                    <p class="col-6">{{ __('Campaign Status') }} : <span
                                                            class="pull-right text-primary">{campaign_status}</span></p>
                                                    <p class="col-6">{{ __('Campaign Start Date') }} : <span
                                                            class="pull-right text-primary">{campaign_start_date}</span>
                                                    </p>
                                                    <p class="col-6">{{ __('Campaign Due Date') }} : <span
                                                            class="pull-right text-primary">{campaign_due_date}</span></p>
                                                    <p class="col-6">{{ __('Campaign Assign User') }} : <span
                                                            class="pull-right text-primary">{campaign_assign_user}</span>
                                                    </p>
                                                    <p class="col-6">{{ __('Campaign Description') }} : <span
                                                            class="pull-right text-primary">{campaign_description}</span>
                                                    </p>
                                                </div>
                                            @elseif($emailTemplate->slug == 'new_contract')
                                                <div class="row">
                                                    <p class="col-6">{{ __('App Name') }} : <span
                                                            class="pull-end text-primary">{app_name}</span></p>
                                                    <p class="col-6">{{ __('Company Name') }} : <span
                                                            class="pull-right text-primary">{company_name}</span></p>
                                                    <p class="col-6">{{ __('App Url') }} : <span
                                                            class="pull-right text-primary">{app_url}</span></p>
                                                    <p class="col-6">{{ __('Contract Client') }} : <span
                                                            class="pull-right text-primary">{contract_client}</span></p>
                                                    <p class="col-6">{{ __('Contract Subject') }} : <span
                                                            class="pull-right text-primary">{contract_subject}</span></p>
                                                    <p class="col-6">{{ __('Contract Start_Date') }} : <span
                                                            class="pull-right text-primary">{contract_start_date}</span>
                                                    </p>
                                                    <p class="col-6">{{ __('Contract End_Date') }} : <span
                                                            class="pull-right text-primary">{contract_end_date}</span></p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-9 col-sm-12 language-form-wrap">
                                {{ Form::model($currEmailTempLang, ['route' => ['email_template.update', $currEmailTempLang->parent_id], 'method' => 'PUT']) }}
                                <div class="row">
                                    <div class="form-group col-12">
                                        {{ Form::label('subject', __('Subject'), ['class' => 'form-control-label text-dark']) }}
                                        {{ Form::text('subject', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{ Form::label('name', __('Name'), ['class' => 'form-control-label text-dark']) }}
                                        {{ Form::text('name', $emailTemplate->name, ['class' => 'form-control font-style', 'disabled' => 'disabled']) }}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{ Form::label('from', __('From'), ['class' => 'form-control-label text-dark']) }}
                                        {{ Form::text('from', $emailTemplate->from, ['class' => 'form-control font-style', 'required' => 'required']) }}
                                    </div>
                                    <div class="form-group col-12">
                                        {{ Form::label('content', __('Email Message'), ['class' => 'form-control-label text-dark']) }}
                                        {{ Form::textarea('content', $currEmailTempLang->content, ['class' => 'summernote', 'required' => 'required']) }}

                                    </div>


                                    <div class="col-md-12 text-end">
                                        {{ Form::hidden('lang', null) }}
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
@endsection
