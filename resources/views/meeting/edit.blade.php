@extends('layouts.admin')
@section('page-title')
{{ __('Training Edit') }}
@endsection
@section('title')
{{ __('Edit Training') }}
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
if(!empty($meeting->func_package)){
$func_package = json_decode($meeting->func_package,true);
}
$secondary_contact = json_decode($meeting->secondary_contact,true);
$user_data = json_decode($meeting->user_data,true);

@endphp

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('meeting.index') }}">{{ __('Training') }}</a></li>
<li class="breadcrumb-item">{{ __('Edit') }}</li>
@endsection
@section('content')
<style>
    .floorimages {
        height: 400px;
        width: 600px;
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
</style>

<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper p0">
            <div class="container-fluid xyz p0">
                <div class="row1">
                    <div class="col-lg-12 p0">
                        {{ Form::model($meeting, ['route' => ['meeting.update', $meeting->id], 'method' => 'PUT' ,'id'=> 'formdata','enctype' => 'multipart/form-data']) }}
                        <div id="useradd-1" class="card">
                            <div class="col-md-12">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <h5>{{ __('Training') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if($meeting->attendees_lead != 0 )
                                        <div class="col-12 need_full">
                                            <div class="form-group">
                                                {{ Form::label('attendees_lead', __('Lead'), ['class' => 'form-label']) }}
                                                {{Form::text('attendees_lead',$attendees_lead,array('class'=>'form-control','required'=>'required','readonly'=>'readonly'))}}
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-12 need_full">
                                            <div class="form-group">
                                                {{ Form::label('eventname', __('Training Name'), ['class' => 'form-label']) }}
                                                {{Form::text('eventname',$meeting->eventname,array('class'=>'form-control','required'=>'required','readonly'=>'readonly'))}}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-12 need_full">
                                            <div class="form-group">
                                                <div class="col-12  p-0 modaltitle pb-3 mb0">
                                                    <h5 style="margin-left: 14px;" class="mb-0">{{ __('Assigned Trainer') }}</h5>
                                                </div>
                                                @foreach($users as $user)
                                                @if(\Auth::user()->type == 'owner' || (\Auth::user()->id == $user->id && str_contains(\Auth::user()->type, 'Trainer')))
                                                <div class="form-check">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input class="form-check-input inputDisable" type="checkbox" name="user[{{ $user->id }}][checkbox]" value="{{ $user->id }}" id="user_{{ $user->id }}" {{ in_array($user->id, $user_idNew) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="user_{{ $user->id }}">{{ $user->name }}</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="number" name="user[{{ $user->id }}][amount]" id="user_amount_{{ $user->id }}" class="form-control" value="{{ @$user_data[$user->id]['amount'] }}" disabled required>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                                <script>
                                                    document.querySelectorAll('input.inputDisable').forEach(function(element) {
                                                        element.addEventListener('click', function() {
                                                            var value = element.value;
                                                            var checked = element.checked;
                                                            var userAmountInput = document.querySelector(`input#user_amount_${value}`);
                                                            if (!checked) {
                                                                userAmountInput.disabled = true;
                                                            } else {
                                                                userAmountInput.disabled = false;
                                                            }
                                                        });
                                                    });

                                                    document.querySelectorAll('input.inputDisable').forEach(function(input) {
                                                        var val = input.value;
                                                        var checked = input.checked;
                                                        var targetInput = document.getElementById('user_amount_' + val);
                                                        if (checked) {
                                                            targetInput.disabled = false;
                                                        } else {
                                                            targetInput.disabled = true;
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="col-12 need_full">
                                            <div class="form-group">
                                                {{Form::label('company_name',__('Company Name'),['class'=>'form-label']) }}
                                                {{Form::text('company_name',null,array('class'=>'form-control','placeholder'=>__('Enter Company Name'),'required'=>'required'))}}
                                            </div>
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
                                                    <input type="tel" id="phone-input" name="phone" class="phone-input form-control" placeholder="Enter Phone" maxlength="16" value="{{$meeting->phone}}" required>
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
                                                {{Form::text('secondary_contact[name]',@$secondary_contact['name'],array('class'=>'form-control','placeholder'=>__('Enter Name')))}}
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
                                                    <input type="tel" id="phone-input1" name="secondary_contact[secondary_contact]" class="phone-input form-control" value="{{@$secondary_contact['secondary_contact']}}" placeholder="Enter Phone" maxlength="16">
                                                    <input type="hidden" name="countrycode1" id="country-code1">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('email',__('Email'),['class'=>'form-label']) }}
                                                {{Form::text('secondary_contact[email]',@$secondary_contact['email'],array('class'=>'form-control','placeholder'=>__('Enter Email')))}}
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

                                                {{Form::text('secondary_contact[lead_address]',@$secondary_contact['lead_address'],array('class'=>'form-control','placeholder'=>__('Address')))}}
                                            </div>

                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('relationship',__('Title'),['class'=>'form-label']) }}
                                                {{Form::text('secondary_contact[relationship]',@$secondary_contact['relationship'],array('class'=>'form-control','placeholder'=>__('Enter Title')))}}
                                            </div>
                                        </div>

                                        <div id="contact-info" style="display:none">
                                            <div class="row">
                                                <div class="col-12  p-0 modaltitle pb-3 mb-3">
                                                    <h5 style="margin-left: 14px;">{{ __('Other Contact Information') }}</h5>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {{Form::label('alter_name',__('Name'),['class'=>'form-label']) }}
                                                        {{Form::text('alter_name',null,array('class'=>'form-control','placeholder'=>__('Enter Name')))}}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {{Form::label('alter_phone',__('Phone'),['class'=>'form-label']) }}
                                                        {{Form::text('alter_phone',null,array('class'=>'form-control','placeholder'=>__('Enter Phone')))}}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {{Form::label('alter_email',__('Email'),['class'=>'form-label']) }}
                                                        {{Form::text('alter_email',null,array('class'=>'form-control','placeholder'=>__('Enter Email')))}}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {{Form::label('alter_lead_address',__('Address'),['class'=>'form-label']) }}
                                                        {{Form::text('alter_lead_address',null,array('class'=>'form-control','placeholder'=>__('Address')))}}
                                                    </div>
                                                </div>
                                                <div class="col-6">
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
                                                {{Form::label('type',__('Training Type'),['class'=>'form-label']) }}
                                                {!! Form::select('type', $type_arr, null,array('class' => 'form-control','required'=>'required')) !!}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                <label for="venue" class="form-label">{{ __('Trainings') }}</label>
                                                @foreach($venue as $key => $label)
                                                <div>
                                                    <input type="checkbox" class="venue-checkbox" name="venue[]" id="{{ $label }}" value="{{ $label }}" {{ in_array($label, $venue_function) ? 'checked' : '' }}>
                                                    <label for="{{ $label }}">{{ $label }}</label>
                                                </div>
                                                @endforeach
                                                <input type="text" name="venue[]" class="custom-text-field" pattern="[^,]*" oninput="this.value = this.value.replace(/,/g, '')"
                                                    onkeydown="if(event.key === ',') event.preventDefault()" id="custom_text" value="{{ (!in_array(end($venue_function), $venue)) ? end($venue_function) : '' }}">
                                                <label for="custom_text">{{ __('Custom Loction') }}</label>+

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
                                        </div>

                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('room', __('Customer Location'), ['class' => 'form-label']) }}
                                                <span class="text-sm">
                                                    <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                                                </span>
                                                {!! Form::text('room',$meeting->room, ['class' =>
                                                'form-control',
                                                'required' => 'required']) !!}
                                            </div>
                                            @if ($errors->has('room'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('room') }}</strong>
                                            </span>
                                            @endif

                                        </div>

                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                                {!! Form::text('start_date', null, ['class' => 'form-control dateChangeFormat', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <!-- <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                                {!! Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                        </div> -->
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('start_time', __('Start Time'), ['class' => 'form-label']) }}
                                                {!! Form::input('time', 'start_time',null, ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('end_time', __('End Time'), ['class' => 'form-label']) }}
                                                {!! Form::input('time', 'end_time', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('guest_count',__('Attendees'),['class'=>'form-label']) }}
                                                {!! Form::number('guest_count', null,array('class' => 'form-control','min'=> 1,'required'=>'required')) !!}
                                            </div>
                                        </div>
                                        {{--<div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('function', __('Function'), ['class' => 'form-label']) }}
                                        <br>
                                        @foreach($function as $value)
                                        <label>
                                            <input type="checkbox" id="{{ $value['function'] }}" name="function[]" value="{{ $value['function'] }}" class="function-checkbox" {{ in_array($value['function'], $function_p) ? 'checked' : '' }} onchange="toggleDiv(" {{ $value['function'] }}"")">
                                            {{ $value['function'] }}
                                        </label>
                                        <br>
                                        @endforeach
                                    </div>
                                </div>--}}
                                <div class="col-6 need_full" id="mailFunctionSection">
                                    @if(isset($function) && !empty($function))
                                    @foreach($function as $key =>$value)
                                    <div class="form-group" data-main-index="{{$key}}" data-main-value="{{$value['function']}}" id="function_package" style="display: none;">
                                        {{ Form::label('package', __($value['function']), ['class' => 'form-label']) }}
                                        @foreach($value['package'] as $k => $package)
                                        <?php $isChecked = false; ?>
                                        @if(isset($func_package) && !empty($func_package))
                                        @foreach($func_package as $func => $pack)
                                        @foreach($pack as $keypac => $packval)
                                        @if($package == $packval)
                                        <?php $isChecked = true; ?>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @endif
                                        <div class="form-check" data-main-index="{{$k}}" data-main-package="{{$package}}">
                                            {!! Form::checkbox('package_'.str_replace(' ', '', strtolower($value['function'])).'[]',$package, $isChecked, ['id' => 'package_' . $key.$k, 'data-function' => $value['function'], 'class' => 'form-check-input']) !!}
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
                                            {!! Form::checkbox('additional_'.str_replace(' ', '_', strtolower($fun_key)).'[]',$pac_key, null, ['data-function' => $fun_key, 'class' => 'form-check-input']) !!}
                                            {{ Form::label($pac_key, $pac_key, ['class' => 'form-check-label']) }}
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                    @endforeach
                                    @endif

                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <label><b>Setup</b></label>
                                        @foreach($setup as $s)
                                        <div class="col-6  mt-4 need_full">
                                            <input type="radio" id="image_{{ $loop->index }}" name="uploadedImage" class="form-check-input " value="{{ asset('floor_images/' .$s->image) }}" {{ asset('floor_images/' .$s->image)==$meeting->floor_plan ? 'checked' : '' }} style="display:none">
                                            <label for="image_{{ $loop->index }}" class="form-check-label">
                                                <img src="{{asset('floor_images/'. $s->image)}}" alt="Uploaded Image" class="img-thumbnail floorimages zoom" data-bs-toggle="tooltip" title="{{$s->Description}}">
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
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
                                {{--<div class="form-group">
                                            {{Form::label('rooms',__('Room'),['class'=>'form-label']) }}
                                <input type="number" name="rooms" min=0 class="form-control" value="{{$meeting->room}}">
                            </div>
                            <div class="col-6 need_full">
                                <div class="form-group">
                                    {!! Form::label('meal', 'Meal Preference') !!}
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
                                        {{ Form::radio('baropt', $label,isset($meeting->bar) && $meeting->bar == $label ? true :false, ['id' => $label]) }}
                                        {{ Form::label('baropt' . ($key + 1), $label) }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-6 need_full" id="barpacakgeoptions" style="display: none;">
                                @if(isset($bar_package) && !empty($bar_package))
                                @foreach($bar_package as $key =>$value)
                                <div class="form-group" data-main-index="{{$key}}" data-main-value="{{$value['bar']}}">
                                    {{ Form::label('bar', __($value['bar']), ['class' => 'form-label']) }}
                                    @foreach($value['barpackage'] as $k => $bar)
                                    <div class="form-check" data-main-index="{{$k}}" data-main-package="{{$bar}}">
                                        {!! Form::radio('bar'.'_'.str_replace(' ', '', strtolower($value['bar'])), $bar, false, ['id' => 'bar_' . $key.$k, 'data-function' => $value['bar'], 'class' => 'form-check-input']) !!}
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
                            @if($atttachments)
                            <div class="col-12">
                                <div class="row">
                                    @foreach($atttachments as $atchKey => $atchValue)
                                    <div class="col-6">
                                        <div class="form-group">
                                            <img src="{{ url('storage/app/public/' . $atchValue->filepath) }}" alt="{{ $atchValue->filename }}" srcset="" style="width: 100%;">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    {{ Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary ']) }}
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

@endsection
@push('script-page')
<style>
    .iti.iti--allow-dropdown.iti--separate-dial-code {
        width: 100%;
    }
</style>

<script>
    $(document).ready(function() {
        var phoneNumber = "<?php echo $meeting->phone; ?>";
        var num = phoneNumber.trim();
        // if (phoneNumber.trim().length < 10) {
        //     alert('Please enter a valid phone number with at least 10 digits.');
        //     return;
        // }
        var lastTenDigits = phoneNumber.substr(-10);
        var formattedPhoneNumber = '(' + lastTenDigits.substr(0, 3) + ') ' + lastTenDigits.substr(3, 3) + '-' +
            lastTenDigits.substr(6);
        $('#phone-input').val(formattedPhoneNumber);


        var phoneNumber1 = "<?php echo @$secondary_contact['secondary_contact'] ?>";
        var num = phoneNumber1.trim();
        var lastTenDigits1 = phoneNumber1.substr(-10);
        var formattedPhoneNumber1 = '(' + lastTenDigits1.substr(0, 3) + ') ' + lastTenDigits1.substr(3, 3) + '-' +
            lastTenDigits1.substr(6);
        $('#phone-input1').val(formattedPhoneNumber1);
    })
</script>
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
    });
    // $(document).ready(function() {
    //     $('#start_date, #end_date').change(function() {
    //         var startDate = new Date($('#start_date').val());
    //         var endDate = new Date($('#end_date').val());

    //         if ($(this).attr('id') === 'start_date' && endDate < startDate) {
    //             $('#end_date').val($('#start_date').val());
    //         } else if ($(this).attr('id') === 'end_date' && endDate < startDate) {
    //             $('#start_date').val($('#end_date').val());
    //         }
    //     });
    // });
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
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: '#useradd-sidenav',
        offset: 300
    })
    $(document).ready(function() {
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
        var selectedValue = $('input[name="bar"]:checked').val();
        if (selectedValue == 'Package Choice') {
            $('#package').show();
        }
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
</script>

<script>
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

    function toggleDiv(value) {
        var divId = value.toLowerCase();
        var div = document.getElementById(divId);

        if (div) {
            div.style.display = document.getElementById(value).checked ? 'block' : 'none';
        }
    }
    $(document).ready(function() {
        $('input[name="uploadedImage"]').each(function() {
            if ($(this).prop('checked')) {
                var imageId = $(this).attr('id');
                $('label[for="' + imageId + '"] img').addClass('selected-image');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('input[name="uploadedImage"]').change(function() {
            $('.floorimages').removeClass('selected-image');

            if ($(this).is(':checked')) {
                var imageId = $(this).attr('id');
                $('label[for="' + imageId + '"] img').addClass('selected-image');
            }
        });
    });
</script>

@endpush