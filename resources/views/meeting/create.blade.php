@extends('layouts.admin')
@section('page-title')
{{ __('Training Create') }}
@endsection
@section('title')
{{ __('Create Training') }}
@endsection
@php
$plansettings = App\Models\Utility::plansettings();
$setting = App\Models\Utility::settings();
$type_arr= explode(',',$setting['event_type']);
$type_arr = array_combine($type_arr, $type_arr);
$venue = explode(',',$setting['venue']);
if(isset($setting['function']) && !empty($setting['function'])){
$function = json_decode($setting['function'],true);
}
if(isset($setting['additional_items']) && !empty($setting['additional_items'])){
$additional_items = json_decode($setting['additional_items'],true);
}
$meal = ['Formal Plated' ,'Buffet Style' , 'Family Style'];
$baropt = ['Open Bar', 'Cash Bar', 'Package Choice'];
if(isset($setting['barpackage']) && !empty($setting['barpackage'])){
$bar_package = json_decode($setting['barpackage'],true);
}
if(request()->has('lead')){
$leadId = decrypt(urldecode(request()->query('lead')));
}

@endphp
@section('content')
<style>
    .floorimages {
        height: 400px;
        width: 100%;
        margin: 0px !important;
    }

    .selected-image {
        border: 2px solid #3498db;
        box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .selected-image:hover {
        border-color: #2980b9;
        box-shadow: 0 0 15px rgba(41, 128, 185, 0.8);
    }

    .zoom {
        background-color: none;
        transition: transform .2s;
    }

    .zoom:hover {
        -ms-transform: scale(1.5);
        -webkit-transform: scale(1.5);
        transform: scale(1.2);
    }


    .fa-asterisk {
        font-size: xx-small;
        position: absolute;
        padding: 1px;
    }
</style>
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper p0">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <h5>{{ __('Training') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {{Form::label('Select Existing Lead/New Training',__('Select Existing Lead/New Training'),['class'=>'form-label']) }}
                                    <div class="form-group">
                                        {{ Form::radio('newevent',__('Existing Lead'),true) }}
                                        {{ Form::label('newevent','Existing Lead') }}
                                        {{ Form::radio('newevent',__('New Training'),false) }}
                                        {{ Form::label('newevent','New Training') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="event_option">
                            {{ Form::open(['url' => 'meeting', 'method' => 'post', 'enctype' => 'multipart/form-data','id'=>'formdata'] )  }}
                            <div id="useradd-1" class="card">
                                <div class="col-md-12">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <h5>{{ __('Create Training') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12" id="lead_select">
                                                <div class="form-group">
                                                    {{ Form::label('lead', __('Lead'), ['class' => 'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {!! Form::select('lead', $attendees_lead, null, ['class' =>
                                                    'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-12" id="new_event" style="display: none;">
                                                <div class="form-group">
                                                    {{ Form::label('eventname', __('Training Name'), ['class' => 'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {{Form::text('eventname',null,array('class'=>'form-control','placeholder'=>__('Enter Training Name')))}}
                                                </div>
                                            </div>
                                            <div class="col-12 need_full">
                                                <div class="form-group">
                                                    {{Form::label('Assigned Trainer',__('Assigned Trainer'),['class'=>'form-label']) }}
                                                    @foreach($users as $user)
                                                    <div class="form-check">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <input class="form-check-input inputDisable" type="checkbox" name="user[{{ $user->id }}][checkbox]" value="{{ $user->id }}" id="user_{{ $user->id }}">
                                                                <label class="form-check-label" for="user_{{ $user->id }}">
                                                                    {{ $user->name }}
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="number" class="form-control" name="user[{{ $user->id }}][amount]" id="user_amount_{{ $user->id }}" disabled required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @if ($errors->has('user'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('user') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <script>
                                                document.querySelectorAll('input.inputDisable').forEach(function(element) {
                                                    element.addEventListener('click', function() {
                                                        var value = element.value;
                                                        var checked = element.checked;
                                                        var userAmountInput = document.querySelector(`input#user_amount_${value}`);
                                                        if (!checked) {
                                                            userAmountInput.disabled = true;
                                                            userAmountInput.value = '';
                                                        } else {
                                                            userAmountInput.disabled = false;
                                                            userAmountInput.value = '';
                                                        }
                                                    });
                                                });
                                            </script>

                                            <div class="col-12 need_full">
                                                {{Form::label('type',__('Training Type'),['class'=>'form-label']) }}
                                                <span class="text-sm">
                                                    <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                </span>
                                                <select name="type" id="type" class="form-control" required>
                                                    <option value="">Select Type</option>
                                                    @foreach($type_arr as $type)
                                                    <option value="{{$type}}">{{$type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('company_name',__('Company Name'),['class'=>'form-label']) }}
                                                    {{Form::text('company_name',null,array('class'=>'form-control','placeholder'=>__('Enter Company Name'),'required'=>'required'))}}
                                                </div>
                                                @if ($errors->has('company_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-12  p-0 modaltitle pb-3 mb0">
                                                <h5 style="margin-left: 14px;" class="mb-0">{{ __('Primary Contact') }}</h5>
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
                                                </div>
                                                @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('phone',__('Phone'),['class'=>'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    <div class="intl-tel-input">
                                                        <input type="tel" id="phone-input" name="primary_contact" class="phone-input form-control" placeholder="Enter Phone" maxlength="16" required>




                                                        <input type="hidden" name="countrycode" id="country-code">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('email',__('Email'),['class'=>'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Email'),'required'=>'required'))}}
                                                </div>
                                                @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('lead_address',__('Address'),['class'=>'form-label']) }}

                                                    {{Form::text('lead_address',null,array('class'=>'form-control','placeholder'=>__('Address')))}}
                                                </div>

                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('relationship',__('Title'),['class'=>'form-label']) }}
                                                    {{Form::text('relationship',null,array('class'=>'form-control','placeholder'=>__('Enter Title')))}}
                                                </div>
                                            </div>
                                            <div class="col-12  p-0 modaltitle pb-3 mb0">
                                                <h5 style="margin-left: 14px;" class="mb-0">{{ __('Secondary Contact') }}</h5>
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                                                    {{Form::text('secondary_contact[name]',null,array('class'=>'form-control','placeholder'=>__('Enter Name')))}}
                                                </div>
                                                @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('phone',__('Phone'),['class'=>'form-label']) }}
                                                    <div class="intl-tel-input">
                                                        <input type="tel" id="phone-input1" name="secondary_contact[secondary_contact]" class="phone-input form-control" placeholder="Enter Phone" maxlength="16">
                                                        <input type="hidden" name="countrycode1" id="country-code1">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('email',__('Email'),['class'=>'form-label']) }}
                                                    {{Form::text('secondary_contact[email]',null,array('class'=>'form-control','placeholder'=>__('Enter Email')))}}
                                                </div>
                                                @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('lead_address',__('Address'),['class'=>'form-label']) }}

                                                    {{Form::text('secondary_contact[lead_address]',null,array('class'=>'form-control','placeholder'=>__('Address')))}}
                                                </div>

                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('relationship',__('Title'),['class'=>'form-label']) }}
                                                    {{Form::text('secondary_contact[relationship]',null,array('class'=>'form-control','placeholder'=>__('Enter Title')))}}
                                                </div>
                                            </div>
                                            <div id="contact-info" style="display:none">
                                                <div class="row">
                                                    <div class="col-12  p-0 modaltitle pb-3 mb-3">
                                                        <h5 style="margin-left: 14px;">
                                                            {{ __('Other Contact Information') }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-6 need_full">
                                                        <div class="form-group">
                                                            {{Form::label('alter_name',__('Name'),['class'=>'form-label']) }}
                                                            {{Form::text('alter_name',null,array('class'=>'form-control','placeholder'=>__('Enter Name')))}}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 need_full">
                                                        <div class="form-group">
                                                            {{Form::label('alter_phone',__('Phone'),['class'=>'form-label']) }}
                                                            <div class="intl-tel-input">
                                                                <input type="tel" name="alter_phone" class="phone-input form-control" placeholder="Enter Phone">
                                                                <input type="hidden" name="countrycode" id="country-code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 need_full">
                                                        <div class="form-group">
                                                            {{Form::label('alter_email',__('Email'),['class'=>'form-label']) }}
                                                            {{Form::text('alter_email',null,array('class'=>'form-control','placeholder'=>__('Enter Email')))}}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 need_full">
                                                        <div class="form-group">
                                                            {{Form::label('alter_lead_address',__('Address'),['class'=>'form-label']) }}
                                                            {{Form::text('alter_lead_address',null,array('class'=>'form-control','placeholder'=>__('Address')))}}
                                                        </div>
                                                    </div>

                                                    <div class="col-6 need_full">
                                                        <div class="form-group">
                                                            {{Form::label('alter_relationship',__('Relationship'),['class'=>'form-label']) }}
                                                            {{Form::text('alter_relationship',null,array('class'=>'form-control','placeholder'=>__('Enter Relationship')))}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end mt-3">
                                                <button data-bs-toggle="tooltip" id="opencontact" title="{{ __('Add Contact') }}" class="btn btn-sm btn-primary btn-icon m-1">
                                                    <i class="ti ti-plus"></i>
                                                </button>
                                            </div>
                                            @if (isset($setting['is_enabled']) && $setting['is_enabled'] == 'on')
                                            <div class="form-group col-md-6">
                                                <label>{{ __('Synchronize in Google Calendar') }}</label>
                                                <div class="form-check form-switch pt-2">
                                                    <input id="switch-shadow" class="form-check-input" value="1" name="is_check" type="checkbox">
                                                    <label class="form-check-label" for="switch-shadow"></label>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="event-details" class="card">
                                <div class="col-md-12">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <h5>{{ __('Training Details') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{Form::label('guest_count',__('Attendees'),['class'=>'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {!! Form::number('guest_count', null,array('class' =>
                                                    'form-control','min'=> 0, 'required'=>'required')) !!}
                                                </div>
                                                @if ($errors->has('guest_count'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('guest_count') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    <label for="venue_selection" class="form-label">Trainings</label>
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    @foreach($venue as $key => $label)
                                                    <div>
                                                        <input type="checkbox" name="venue[]" class="venue-checkbox" value="{{ $label }}" id="venue{{ $key + 1 }}">
                                                        <label for="{{ $label }}">{{ $label }}</label>
                                                    </div>
                                                    @endforeach
                                                    <input type="text" name="venue[]" class="custom-text-field" pattern="[^,]*" oninput="this.value = this.value.replace(/,/g, '')"
                                                        onkeydown="if(event.key === ',') event.preventDefault()" id="custom_text" value="">
                                                    <label for="custom_text">{{ __('Custom Loction') }}</label>

                                                    <div id="validation-error" style="display: none;">
                                                        <span id="error-message" style="color: red;"></span>
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        const venueCheckboxes = document.querySelectorAll('.venue-checkbox');
                                                        const textField = document.querySelector('.custom-text-field');
                                                        const errorMessageElement = document.getElementById('error-message');
                                                        const errorContainer = document.getElementById('validation-error');
                                                        venueCheckboxes.forEach(function(checkbox) {
                                                            checkbox.addEventListener('change', validateFields);
                                                        });
                                                        textField.addEventListener('input', validateFields);
                                                        validateFields();

                                                        function validateFields() {
                                                            const checkboxesChecked = document.querySelectorAll('.venue-checkbox:checked').length;
                                                            const textInputValue = textField.value.trim();
                                                            if (textInputValue !== "") {
                                                                errorContainer.style.display = "none";
                                                                venueCheckboxes.forEach(function(checkbox) {
                                                                    checkbox.removeAttribute("required");
                                                                });
                                                                textField.removeAttribute("required");
                                                            } else if (textInputValue === "" && checkboxesChecked === 0) {
                                                                errorMessageElement.textContent = "Please select at least one training location or provide a custom location.";
                                                                errorContainer.style.display = "block";
                                                                venueCheckboxes.forEach(function(checkbox) {
                                                                    checkbox.setAttribute("required", "true");
                                                                });
                                                                textField.setAttribute("required", "true");
                                                            } else if (textInputValue === "" && checkboxesChecked > 0) {
                                                                errorContainer.style.display = "none";
                                                                venueCheckboxes.forEach(function(checkbox) {
                                                                    checkbox.removeAttribute("required");
                                                                });
                                                                textField.removeAttribute("required");
                                                            } else {
                                                                errorContainer.style.display = "none";
                                                                venueCheckboxes.forEach(function(checkbox) {
                                                                    checkbox.removeAttribute("required");
                                                                });
                                                                textField.removeAttribute("required");
                                                            }
                                                        }
                                                    });
                                                </script>
                                                @if ($errors->has('venue'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('venue') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{ Form::label('customer_location', __('Customer Location'), ['class' => 'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {!! Form::text('customer_location', null, ['class' =>
                                                    'form-control',
                                                    'required' => 'required']) !!}
                                                </div>
                                                @if ($errors->has('customer_location'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('customer_location') }}</strong>
                                                </span>
                                                @endif

                                            </div>


                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {!! Form::text('start_date', date('Y-m-d'), ['class' =>
                                                    'form-control dateChangeFormat',
                                                    'required' => 'required']) !!}
                                                </div>
                                                @if ($errors->has('start_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start_date') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                            <!-- <div class="col-6">
                                                <div class="form-group">
                                                    {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                                    {!! Form::date('end_date',date('Y-m-d'), ['class' => 'form-control',
                                                    'required' => 'required']) !!}
                                                </div>
                                                @if ($errors->has('end_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end_date') }}</strong>
                                                </span>
                                                @endif

                                            </div> -->
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{ Form::label('start_time', __('Start Time'), ['class' => 'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {!! Form::input('time', 'start_time', null, ['class' =>
                                                    'form-control', 'required' => 'required']) !!}
                                                </div>
                                                @if ($errors->has('start_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start_time') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                            <div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{ Form::label('end_time', __('End Time'), ['class' => 'form-label']) }}
                                                    <span class="text-sm">
                                                        <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                    </span>
                                                    {!! Form::input('time', 'end_time', null, ['class' =>
                                                    'form-control', 'required' => 'required']) !!}
                                                </div>
                                                @if ($errors->has('end_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end_time') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            {{--<div class="col-6 need_full">
                                                <div class="form-group">
                                                    {{ Form::label('function', __('Function'), ['class' => 'form-label']) }}
                                            <span class="text-sm">
                                                <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                            </span>
                                            @if(isset($function) && !empty($function))
                                            @foreach($function as $key => $value)
                                            <div class="form-check">
                                                {!! Form::checkbox('function[]',$value['function'], null, ['id'
                                                => 'function_' . $key, 'class' => 'form-check-input']) !!}
                                                {{ Form::label($value['function'], $value['function'], ['class' => 'form-check-label']) }}
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        @if ($errors->has('function'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end_time') }}</strong>
                                        </span>
                                        @endif
                                    </div>--}}
                                    <div class="col-6 need_full" id="mailFunctionSection">
                                        @if(isset($function) && !empty($function))
                                        @foreach($function as $key =>$value)
                                        <div class="form-group" data-main-index="{{$key}}" data-main-value="{{$value['function']}}" id="function_package" style="display: none;">
                                            {{ Form::label('package', __($value['function']), ['class' => 'form-label']) }}
                                            <span class="text-sm">
                                                <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                            </span>
                                            @foreach($value['package'] as $k => $package)
                                            <div class="form-check" data-main-index="{{$k}}" data-main-package="{{$package}}">
                                                {!! Form::checkbox('package_'.str_replace(' ', '',
                                                strtolower($value['function'])).'[]',$package, null, ['id' =>
                                                'package_' . $key.$k, 'data-function' => $value['function'],
                                                'class' => 'form-check-input']) !!}
                                                {{ Form::label($package, $package, ['class' => 'form-check-label']) }}

                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6 need_full" id="additionalSection">
                                        @if(isset($additional_items) && !empty($additional_items))
                                        {{ Form::label('additional', __('Additional items'), ['class' => 'form-label']) }}
                                        @foreach($additional_items as $ad_key =>$ad_value)
                                        @foreach($ad_value as $fun_key =>$packageVal)
                                        <div class="form-group" data-additional-index="{{$fun_key}}" data-additional-value="{{key($packageVal)}}" id="ad_package" style="display: none;">
                                            {{ Form::label('additional', __($fun_key), ['class' => 'form-label']) }}
                                            @foreach($packageVal as $pac_key =>$item)
                                            <div class="form-check" data-additional-index="{{$pac_key}}" data-additional-package="{{$pac_key}}">
                                                {!! Form::checkbox('additional_'.str_replace(' ', '_',
                                                strtolower($fun_key)).'[]',$pac_key, null, ['data-function' =>
                                                $fun_key, 'class' => 'form-check-input']) !!}
                                                {{ Form::label($pac_key, $pac_key, ['class' => 'form-check-label']) }}
                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                        @endforeach
                                        @endif

                                    </div>
                                    @if($setup->isNotEmpty())
                                    <div class="col-12">
                                        <div class="row">
                                            <label><b>Setup</b></label>
                                            @foreach($setup as $s)
                                            <div class="col-6 need_full mt-4">
                                                <input type="radio" id="image_{{ $loop->index }}" name="uploadedImage" class="form-check-input " value="{{ asset('floor_images/' . $s->image) }}" style="display:none;">
                                                <label for="image_{{ $loop->index }}" class="form-check-label">
                                                    <img src="{{asset('floor_images/'.$s->image)}}" alt="Uploaded Image" class="img-thumbnail floorimages zoom" data-bs-toggle="tooltip" title="{{$s->Description}}">
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @error('uploadedImage')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="special_req" class="card">
                        <div class="col-md-12">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <h5>{{ __('Any Special Requirements') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="form-group">
                                                {{Form::label('rooms',__('Room'),['class'=>'form-label']) }}
                                    <input type="number" name="rooms" min=0 class="form-control">

                                </div>
                                <div class="col-6 need_full">
                                    <div class="form-group">
                                        {!! Form::label('meal', 'Meal Preference') !!}
                                        <span class="text-sm">
                                            <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                        </span>
                                        @foreach($meal as $key => $label)
                                        <div>
                                            {{ Form::radio('meal', $label , false, ['id' => $label]) }}
                                            {{ Form::label('meal' . ($key + 1), $label) }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-6 need_full">
                                    <div class="form-group">
                                        {!! Form::label('baropt', 'Bar') !!}
                                        @foreach($baropt as $key => $label)
                                        <div>
                                            {{ Form::radio('baropt', $label, false, ['id' => $label]) }}
                                            {{ Form::label('baropt' . ($key + 1), $label) }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-6" id="barpacakgeoptions" style="display: none;">
                                    @if(isset($bar_package) && !empty($bar_package))
                                    @foreach($bar_package as $key =>$value)
                                    <div class="form-group" data-main-index="{{$key}}" data-main-value="{{$value['bar']}}">
                                        {{ Form::label('bar', __($value['bar']), ['class' => 'form-label']) }}
                                        @foreach($value['barpackage'] as $k => $bar)
                                        <div class="form-check" data-main-index="{{$k}}" data-main-package="{{$bar}}">
                                            {!! Form::radio('bar'.'_'.str_replace(' ', '',
                                            strtolower($value['bar'])), $bar, false, ['id' => 'bar_' .
                                            $key.$k, 'data-function' => $value['bar'], 'class' =>
                                            'form-check-input']) !!}
                                            {{ Form::label($bar, $bar, ['class' => 'form-check-label']) }}
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                    @endif
                                </div>--}}
                                <div class="col-12">
                                    <div class="form-group">
                                        {{Form::label('spcl_request',__('Special Requests / Considerations'),['class'=>'form-label']) }}
                                        {{Form::text('spcl_request',null,array('class'=>'form-control'))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="other_info" class="card">
                    <div class="col-md-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <h5>{{ __('Other Information') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{Form::label('allergies',__('Other Remarks'),['class'=>'form-label']) }}
                                        {{Form::text('allergies',null,array('class'=>'form-control','placeholder'=>__('Enter Other Remarks (if any)')))}}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        {{Form::label('atttachment',__('Attachments (If Any)'),['class'=>'form-label']) }}
                                        <input type="file" name="atttachment" id="atttachment" class="form-control">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input type="reset" id="resetForm" value="" style="display: none;">
                            {{ Form::submit(__('Save'), ['class' => 'btn  btn-primary ']) }}
                        </div>
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
@push('script-page')
<script>
    $(document).ready(function() {
        // Attach a keyup event listener to input fields
        $('input').on('keyup', function() {
            // Get the input value
            var value = $(this).val();
            // Check if the input value contains spaces
            if (value.indexOf(' ') !== -1) {
                // Display validation message
                $('#validationMessage').text('Spaces are not allowed in this field').show();
            } else {
                // Hide validation message if no spaces are found
                $('#validationMessage').hide();
            }
        });
    });
    $(document).ready(function() {
        $("input[type='text'][name='lead_name'],input[type='text'][name='name'], input[type='text'][name='email'], select[name='type'],input[type='tel'][name='primary_contact'],input[name='guest_count'],input[name='start_date'],input[name='start_time'],input[name='end_time']")
            .focusout(function() {

                var input = $(this);
                var errorMessage = '';
                if (input.attr('name') === 'email' && input.val() !== '') {
                    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(input.val())) {
                        errorMessage = 'Invalid email address.';
                    }
                } else if (input.val() == '') {
                    errorMessage = 'This field is required.';
                }

                if (errorMessage != '') {
                    input.css('border', 'solid 2px red');
                } else {
                    // If it is not blank. 
                    input.css('border', 'solid 2px black');
                }

                // Remove any existing error message
                input.next('.validation-error').remove();

                // Append the error message if it exists
                if (errorMessage != '') {
                    input.after('<div class="validation-error text-danger" style="padding:2px;">' +
                        errorMessage + '</div>');
                }
            });
    });
</script>

<script>
    function initializePhoneInput(inputSelector, countryCodeSelector) {
        var input = document.querySelector(inputSelector);
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
        });
        var updateCountryCode = function() {
            var countryCode = iti.getSelectedCountryData().dialCode;
            $(countryCodeSelector).val(countryCode);
        };
        updateCountryCode();

        input.addEventListener('countrychange', updateCountryCode);
        input.addEventListener('input', updateCountryCode);

        var countryIso2 = iti.getSelectedCountryData().iso2;
        if (countryIso2 !== 'us') {
            iti.setCountry('us');
        }

        return iti;
    }

    function onAjaxSuccess() {
        var iti1 = initializePhoneInput("#phone-input", "#country-code");
        var iti2 = initializePhoneInput("#phone-input1", "#country-code1");
    }

    function assignTraner_disable() {
        document.querySelectorAll('input.inputDisable').forEach(function(input) {
            var val = input.value;
            var checked = input.checked;
            var targetInput = document.getElementById('user_amount_' + val);
            if (checked) {
                targetInput.value = '';
                targetInput.disabled = false;
            } else {
                targetInput.value = '';
                targetInput.disabled = true;
            }
        });
    }

    function dateChangeFormat(data) {
        var date = new Date(data);
        var format = date.toLocaleDateString('en-US');
        return format;
    }


    $(document).ready(function() {

        var leadId = localStorage.getItem('leadId');
        if (leadId) {
            const options = document.querySelectorAll('#lead option');
            const valuesArray = Array.from(options).find(option => option.value === leadId);
            if (!valuesArray) {
                localStorage.removeItem('leadId');
                return false;
            } else {
                $('select[name="lead"]').val(leadId);
                var venu = leadId;
                $.ajax({
                    url: "{{ route('meeting.lead') }}",
                    type: 'POST',
                    data: {
                        "venue": venu,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        console.log(data);
                        secondary_contact = JSON.parse(data.secondary_contact);
                        //  console.log('secondary_contact');

                        if (data.user_data) {
                            user_data = JSON.parse(data.user_data);

                            $.each(user_data, function(key, element) {
                                $(`input[name="user[${element.checkbox}][amount]"]`).val(element.amount);

                                document.querySelectorAll('input.inputDisable').forEach(function(input) {
                                    var val = input.value;
                                    var checked = input.checked;
                                    if (element.checkbox != checked) {
                                        var targetInput = document.getElementById('user_amount_' + val);
                                        if (checked) {
                                            targetInput.value = '';
                                            targetInput.disabled = false;
                                        } else {
                                            targetInput.value = '';
                                            targetInput.disabled = true;
                                        }
                                    }
                                });


                            });
                        }


                        // func_pack = json_decode(data.func_package);
                        venue_str = data.venue_selection;
                        venue_arr = venue_str.split(",");
                        // func_str = data.function;
                        // func_arr = func_str.split(",");
                        $('input[name ="company_name"]').val(data.company_name);
                        $('input[name ="name"]').val(data.name);
                        $('input[name ="allergies"]').val(data.allergies);
                        $('input[name ="spcl_request"]').val(data.spcl_req);
                        // Phone number formatting
                        // var phoneInput = $('input[name ="phone"]');
                        // phoneInput.val(data.phone);
                        // phoneInput.trigger('input');
                        // phoneInput.addEventListener('input', enforceFormat);
                        // phoneInput.addEventListener('input', formatToPhone); 
                        // $('input[name ="end_date"]').val(data.end_date);
                        $('input[name ="relationship"]').val(data.relationship);


                        $('input[name="start_date"]').val(dateChangeFormat(data.start_date));
                        // $('input[name ="start_date"]').val(data.start_date);
                        $('input[name ="start_time"]').val(data.start_time);
                        $('input[name ="end_time"]').val(data.end_time);
                        // $('input[name ="rooms"]').val(data.rooms);
                        $('input[name ="customer_location"]').val(data.rooms);
                        $('input[name ="email"]').val(data.email);
                        $('input[name ="primary_contact"]').val(data.primary_contact);


                        $('input[name ="secondary_contact[name]"]').val(secondary_contact.name);
                        $('input[name ="secondary_contact[secondary_contact]"]').val(secondary_contact.secondary_contact);
                        $('input[name ="secondary_contact[email]"]').val(secondary_contact.email);
                        $('input[name ="secondary_contact[lead_address]"]').val(secondary_contact.lead_address);
                        $('input[name ="secondary_contact[relationship]"]').val(secondary_contact.relationship);


                        $('input[name ="lead_address"]').val(data.lead_address);
                        $("select[name='type'] option[value='" + data.type + "']").prop("selected", true);
                        $("input[name='bar'][value='" + data.bar + "']").prop('checked', true);
                        // $("input[name='user[]'][value='" + data.assigned_user + "']").prop('checked', true);
                        $("input[name='user[" + data.assigned_user + "][checkbox]'][value='" + data.assigned_user + "']").prop('checked', true);
                        $.each(venue_arr, function(i, val) {
                            $("input[name='venue[]'][value='" + val + "']").prop('checked', true);
                        });
                        $('#custom_text').val(venue_arr[venue_arr.length - 1]);
                        $('input[name ="guest_count"]').val(data.guest_count);

                        // $.each(func_arr, function(i, val) {$("input[name='function[]'][value='" + val + "']").prop('checked', true);});
                        // var checkedFunctions = $('input[name="function[]"]:checked').map(function() {return $(this).val();}).get();
                        var mailFunctionSection = document.getElementById('mailFunctionSection');
                        var divs = mailFunctionSection.querySelectorAll('.form-group');
                        divs.forEach(function(div) {
                            var mainValue = div.getAttribute('data-main-value');
                            if (checkedFunctions.includes(mainValue)) {
                                div.style.display = 'block';
                            } else {
                                div.style.display = 'none';
                            }
                        });
                        var phoneNumber = data.primary_contact;
                        var num = phoneNumber.trim();
                        var lastTenDigits = phoneNumber.substr(-10);
                        var formattedPhoneNumber = '(' + lastTenDigits.substr(0, 3) + ') ' + lastTenDigits.substr(3, 3) + '-' + lastTenDigits.substr(6);
                        $('#phone-input').val(formattedPhoneNumber);

                        var phoneNumber1 = secondary_contact.secondary_contact;
                        var num = phoneNumber1.trim();
                        var lastTenDigits1 = phoneNumber1.substr(-10);
                        var formattedPhoneNumber1 = '(' + lastTenDigits1.substr(0, 3) + ') ' + lastTenDigits1.substr(3, 3) + '-' + lastTenDigits1.substr(6);
                        $('#phone-input1').val(formattedPhoneNumber1);
                        assignTraner_disable();
                        validateFields();
                    }
                });
            }
            // localStorage.removeItem('leadId');
        }
    });
</script>
<style>
    .iti.iti--allow-dropdown.iti--separate-dial-code {
        width: 100%;
    }
</style>
<!-- <script>
$(document).ready(function() {
    $('input[name="uploadedImage"]').change(function() {
        $('.floorimages').removeClass('selected-image');
        if ($(this).is(':checked')) {
            var imageId = $(this).attr('id');
            $('label[for="' + imageId + '"] img').addClass('selected-image');
        }
    });
});
</script> -->
<script>
    $(document).ready(function() {
        var input = document.querySelector("#phone-input");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
        });
        var indiaCountryCode = iti.getSelectedCountryData().iso2;
        var countryCode = iti.getSelectedCountryData().dialCode;
        $('#country-code').val(countryCode);
        if (indiaCountryCode !== 'us') {
            iti.setCountry('us');
        }


        var input1 = document.querySelector("#phone-input1");
        var iti = window.intlTelInput(input1, {
            separateDialCode: true,
        });
        var indiaCountryCode1 = iti.getSelectedCountryData().iso2;
        var countryCode1 = iti.getSelectedCountryData().dialCode;
        $('#country-code1').val(countryCode1);
        if (indiaCountryCode1 !== 'us') {
            iti.setCountry('us');
        }

        // $('#start_date, #end_date').change(function() {
        //     var startDate = new Date($('#start_date').val());
        //     var endDate = new Date($('#end_date').val());

        //     if ($(this).attr('id') === 'start_date' && endDate < startDate) {
        //         $('#end_date').val($('#start_date').val());
        //     } else if ($(this).attr('id') === 'end_date' && endDate < startDate) {
        //         $('#start_date').val($('#end_date').val());
        //     }
        // });
        $('input[name="uploadedImage"]').change(function() {
            $('.floorimages').removeClass('selected-image');
            if ($(this).is(':checked')) {
                var imageId = $(this).attr('id');
                $('label[for="' + imageId + '"] img').addClass('selected-image');
            }
        });
    });
</script>
<script>
    const isNumericInput = (event) => {
        const key = event.keyCode;
        return ((key >= 48 && key <= 57) || // Allow number line
            (key >= 96 && key <= 105) // Allow number pad
        );
    };
    const isModifierKey = (event) => {
        const key = event.keyCode;
        return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
            (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
            (key > 36 && key < 41) || // Allow left, up, right, down
            (
                // Allow Ctrl/Command + A,C,V,X,Z
                (event.ctrlKey === true || event.metaKey === true) &&
                (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
            )
    };
    const enforceFormat = (event) => {
        // Input must be of a valid number format or a modifier key, and not longer than ten digits
        if (!isNumericInput(event) && !isModifierKey(event)) {
            event.preventDefault();
        }
    };
    const formatToPhone = (event) => {
        if (isModifierKey(event)) {
            return;
        }
        // I am lazy and don't like to type things more than once
        const target = event.target;
        const input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
        const zip = input.substring(0, 3);
        const middle = input.substring(3, 6);
        const last = input.substring(6, 10);

        if (input.length > 6) {
            target.value = `(${zip}) ${middle} - ${last}`;
        } else if (input.length > 3) {
            target.value = `(${zip}) ${middle}`;
        } else if (input.length > 0) {
            target.value = `(${zip}`;
        }
    };
    const inputElement = document.getElementById('phone-input');
    inputElement.addEventListener('keydown', enforceFormat);
    inputElement.addEventListener('keyup', formatToPhone);
    const inputElement1 = document.getElementById('phone-input1');
    inputElement1.addEventListener('keydown', enforceFormat);
    inputElement1.addEventListener('keyup', formatToPhone);
</script>
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            var isValid = true;

            // Iterate over each checked function
            $('input[name="function[]"]:checked').each(function() {
                var functionName = $(this).val();
                var checkboxName = 'package_' + functionName.replace(/ /g, '').toLowerCase() + '[]';
                // Check if at least one checkbox for this function is checked
                if ($('input[name="' + checkboxName + '"]:checked').length === 0) {
                    // If no checkbox is checked for this function, set isValid to false
                    isValid = false;
                    return false; // Exit the loop
                }
            });
            // If validation failed, prevent form submission
            if (!isValid) {
                event.preventDefault();
                show_toastr('Success', 'Select Food Package for selected Function', 'danger');
                return false;
            }
        });
    });
</script>
<script>
    $(document).ready(function() {

        //$('input[name=newevent]').prop('checked', false);
        $('input[name="newevent"]').on('click', function() {
            $('#lead_select').hide();
            $('#new_event').hide();
            $('#event_option').show();
            var selectedValue = $(this).val();
            if (selectedValue == 'Existing Lead') {
                $('#lead_select').show();
            } else {
                $('#new_event').show();
                $('input#resetForm').trigger('click');
            }
        });
        $('select[name= "lead"]').on('change', function() {
            $("input[name='user[]'").prop('checked', false);
            $("input[name='bar']").prop('checked', false);
            $("input[name='user[]']").prop('checked', false);
            $("input[name='venue[]']").prop('checked', false);
            $("input[name='function[]']").prop('checked', false);
            var venu = this.value;
            $.ajax({
                url: "{{ route('meeting.lead') }}",
                type: 'POST',
                data: {
                    "venue": venu,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    // console.log(data);
                    secondary_contact = JSON.parse(data.secondary_contact);


                    if (data.user_data) {
                        user_data = JSON.parse(data.user_data);

                        $.each(user_data, function(key, element) {
                            $(`input[name="user[${element.checkbox}][amount]"]`).val(element.amount);

                            document.querySelectorAll('input.inputDisable').forEach(function(input) {
                                var val = input.value;
                                var checked = input.checked;
                                var targetInput = document.getElementById('user_amount_' + val);
                                if (String(element.checkbox) == val) {
                                    targetInput.disabled = !checked;
                                } else {
                                    targetInput.disabled = true;
                                }

                            });
                        });
                    }

                    venue_str = data.venue_selection;
                    venue_arr = venue_str.split(",");
                    func_str = data.function;
                    // func_arr = func_str.split(",");
                    $('input[name ="company_name"]').val(data.company_name);
                    $('input[name ="name"]').val(data.name);
                    $('input[name ="relationship"]').val(data.relationship);
                    $('input[name ="primary_contact"]').val(data.primary_contact);
                    // $('input[name ="start_date"]').val(data.start_date);
                    $('input[name ="start_date"]').val(dateChangeFormat(data.start_date));

                    $('input[name ="secondary_contact[name]"]').val(secondary_contact.name);
                    $('input[name ="secondary_contact[secondary_contact]"]').val(secondary_contact.secondary_contact);
                    $('input[name ="secondary_contact[email]"]').val(secondary_contact.email);
                    $('input[name ="secondary_contact[lead_address]"]').val(secondary_contact.lead_address);
                    $('input[name ="secondary_contact[relationship]"]').val(secondary_contact.relationship);
                    // $('input[name ="end_date"]').val(data.end_date);
                    $('input[name ="start_time"]').val(data.start_time);
                    $('input[name ="end_time"]').val(data.end_time);
                    $('input[name ="spcl_request"]').val(data.spcl_req);
                    $('input[name ="allergies"]').val(data.allergies);
                    // $('input[name ="rooms"]').val(data.rooms);
                    $('input[name ="customer_location"]').val(data.rooms);
                    $('input[name ="email"]').val(data.email);
                    $('input[name ="lead_address"]').val(data.lead_address);
                    $("select[name='type'] option[value='" + data.type + "']").prop("selected",
                        true);
                    $("input[name='baropt'][value='" + data.bar + "']").prop('checked', true);
                    // $("input[name='user[]'][value='" + data.assigned_user + "']").prop('checked', true);
                    $("input[name='user[" + data.assigned_user + "][checkbox]'][value='" + data.assigned_user + "']").prop('checked', true);
                    $.each(venue_arr, function(i, val) {
                        $("input[name='venue[]'][value='" + val + "']").prop('checked',
                            true);
                    });
                    /* $.each(func_arr, function(i, val) {
                        $("input[name='function[]'][value='" + val + "']").prop(
                            'checked', true);
                    }); */
                    $('input[name ="guest_count"]').val(data.guest_count);
                    var checkedFunctions = $('input[name="function[]"]:checked').map(
                        function() {
                            return $(this).val();
                        }).get();
                    var mailFunctionSection = document.getElementById('mailFunctionSection');
                    var divs = mailFunctionSection.querySelectorAll('.form-group');
                    divs.forEach(function(div) {
                        var mainValue = div.getAttribute('data-main-value');
                        if (checkedFunctions.includes(mainValue)) {
                            div.style.display = 'block';
                        } else {
                            div.style.display = 'none';
                        }
                    });
                    assignTraner_disable();
                }
            });
        });

        jQuery(function() {
            $('input[name="function[]"]').change(function() {
                $('div#mailFunctionSection > div').hide();
                $('input[name="function[]"]:checked').each(function() {
                    var funVal = $(this).val();
                    $('div#mailFunctionSection > div').each(function() {
                        var attr_value = $(this).data('main-value');
                        if (attr_value == funVal) {
                            $(this).show();
                        }
                    });
                });
            });
        });
        jQuery(function() {
            $('div#mailFunctionSection input[type=checkbox]').change(function() {
                $('div#additionalSection > div').hide();
                $('div#mailFunctionSection input[type=checkbox]:checked').each(function() {
                    var funcValue = $(this).val();
                    $('div#additionalSection > div').each(function() {
                        var ad_val = $(this).data('additional-index');
                        if (funcValue == ad_val) {
                            $(this).show();
                        }
                    });
                });
            });
        });
        jQuery(function() {
            $('input[type=radio][name = baropt]').change(function() {
                $('div#barpacakgeoptions').hide();
                var value = $(this).val();
                if (value == 'Package Choice') {
                    $('div#barpacakgeoptions').show();
                }
            });
        });
    });
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: '#useradd-sidenav',
        offset: 300
    })
    document.getElementById('opencontact').addEventListener('click', function(event) {
        var x = document.getElementById("contact-info");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
        event.stopPropagation();
        event.preventDefault();
    });
</script>
@endpush