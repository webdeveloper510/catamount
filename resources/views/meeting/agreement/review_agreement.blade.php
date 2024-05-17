@extends('layouts.admin')
@section('page-title')
{{ __('Event Review') }}
@endsection
@section('title')
{{ __('Review Event') }}
@endsection
@php
$plansettings = App\Models\Utility::plansettings();
$setting = App\Models\Utility::settings();
$type_arr= explode(',',$setting['event_type']);
$type_arr = array_combine($type_arr, $type_arr);
$venue = explode(',',$setting['venue']);
$meal = ['Formal Plated' ,'Buffet Style' , 'Family Style'];
if(isset($setting['function']) && !empty($setting['function'])){
$function = json_decode($setting['function'],true);
}
$baropt = ['Open Bar', 'Cash Bar', 'Package Choice'];
if(isset($setting['barpackage']) && !empty($setting['barpackage'])){
$bar_package = json_decode($setting['barpackage'],true);
}
if(isset($setting['additional_items']) && !empty($setting['additional_items'])){
$additional_items = json_decode($setting['additional_items'],true);
}
@endphp

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('meeting.index') }}">{{ __('Event') }}</a></li>
<li class="breadcrumb-item">{{ __('Review') }}</li>
@endsection
@section('content')
<style>
    .floorimages {
        height: 400px;
        width: 600px;
        margin:0px !important;
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
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::model($meeting, ['route' => ['meeting.review_agreement.update', $meeting->id], 'method' => 'POST' ,'id'=> 'formdata']) }}
                        <div id="useradd-1" class="card">
                            <div class="col-md-12">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <h5>{{ __('Event') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    @if($meeting->attendees_lead != 0 )
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('attendees_lead', __('Lead'), ['class' => 'form-label']) }}
                                                {{Form::text('attendees_lead',$attendees_lead,array('class'=>'form-control','required'=>'required','readonly'=>'readonly'))}}
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('eventname', __('Event Name'), ['class' => 'form-label']) }}
                                                {{Form::text('eventname',$meeting->eventname,array('class'=>'form-control','required'=>'required','readonly'=>'readonly'))}}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('Assigned Staff',__('Assigned Staff'),['class'=>'form-label']) }}
                                                @foreach($users as $user)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="user[]" value="{{ $user->id }}" id="user_{{ $user->id }}" {{ in_array($user->id, $user_id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="user_{{ $user->id }}">
                                                        {{ $user->name }} ({{ $user->type }})
                                                    </label>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('company_name',__('Company Name'),['class'=>'form-label']) }}
                                                {{Form::text('company_name',null,array('class'=>'form-control','placeholder'=>__('Enter Company Name'),'required'=>'required'))}}
                                            </div>
                                        </div>

                                        <div class="col-12  p-0 modaltitle pb-3 mb-3">
                                            <h5 style="margin-left: 14px;">{{ __('Contact Information') }}</h5>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                                                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('phone',__('Phone'),['class'=>'form-label']) }}
                                                {{Form::text('phone',null,array('class'=>'form-control','placeholder'=>__('Enter Phone'),'required'=>'required'))}}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('email',__('Email'),['class'=>'form-label']) }}
                                                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Email'),'required'=>'required'))}}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('lead_address',__('Address'),['class'=>'form-label']) }}
                                                {{Form::text('lead_address',null,array('class'=>'form-control','placeholder'=>__('Address'),'required'=>'required'))}}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('relationship',__('Relationship'),['class'=>'form-label']) }}
                                                {{Form::text('relationship',null,array('class'=>'form-control','placeholder'=>__('Enter Relationship')))}}
                                            </div>
                                        </div>

                                        <div id="contact-info" style="display:none">
                                            <div class="row">
                                                <div class="col-12  p-0 modaltitle pb-3 mb-3">
                                                    <h5 style="margin-left: 14px;">{{ __('Other Contact Information') }}</h5>
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
                                                        {{Form::text('alter_phone',null,array('class'=>'form-control','placeholder'=>__('Enter Phone')))}}
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
                                            <h5>{{ __('Event Details') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{Form::label('type',__('Event Type'),['class'=>'form-label']) }}
                                                {!! Form::select('type', $type_arr, null,array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                <label for="venue" class="form-label">{{ __('Venue') }}</label>
                                                @foreach($venue as $key => $label)
                                                <div>
                                                    <input type="checkbox" name="venue[]" id="{{ $label }}" value="{{ $label }}" {{ in_array($label, $venue_function) ? 'checked' : '' }}>
                                                    <label for="{{ $label }}">{{ $label }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                                {!! Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                                {!! Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                        </div>
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
                                                {{Form::label('guest_count',__('Guest Count'),['class'=>'form-label']) }}
                                                {!! Form::number('guest_count', null,array('class' => 'form-control','min'=> 0)) !!}
                                            </div>
                                        </div>
                                        <div class="col-6 need_full">
                                            <div class="form-group">
                                                {{ Form::label('function', __('Function'), ['class' => 'form-label']) }}
                                                @if(isset($function) && !empty($function))
                                                @foreach($function as $key => $value)
                                                <div class="form-check">
                                                    {!! Form::checkbox('function[]',$value['function'],   in_array( $value['function'], $function_p) ? true : false , ['id' => 'function_' . $key, 'class' => 'form-check-input']) !!}
                                                    {{ Form::label($value['function'], $value['function'], ['class' => 'form-check-label']) }}
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-6 need_full" id="mailFunctionSection">
                                            @if(isset($function) && !empty($function))
                                            @foreach($function as $key =>$value)
                                            <div class="form-group" data-main-index="{{$key}}" data-main-value="{{$value['function']}}" id="function_package" style="display: none;">
                                                {{ Form::label('package', __($value['function']), ['class' => 'form-label']) }}
                                                @foreach($value['package'] as $k => $package)
                                                <?php $isChecked = false; ?>
                                            @if(isset($food_package) && !empty($food_package))
                                            @foreach($food_package as $func => $pack)
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
                                                    <input type="radio" id="image_{{ $loop->index }}" name="uploadedImage" class="form-check-input " value="{{ asset('/floor_images/' . $s->image) }}" style="display:none;" {{ asset('floor_images/' .$s->image)==$meeting->floor_plan ? 'checked' : '' }}>
                                                    <label for="image_{{ $loop->index }}" class="form-check-label">
                                                        <img src="{{asset('floor_images/'.$s->image)}}" alt="Uploaded Image" class="img-thumbnail floorimages zoom" data-bs-toggle="tooltip" title="{{$s->Description}}">
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
                                        <div class="form-group">
                                            <!-- {!! Form::checkbox('room', 1, null, ['id'=>'room', 'class' => 'checkbox']) !!}
                                                {!! Form::label('room', 'Rooms at the hotel') !!}  -->
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
                                                    {{ Form::radio('baropt', $label, isset($meeting->bar) && $meeting->bar == $label ? true :false, ['id' => $label]) }}
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
                                        </div>

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
                                                {{Form::label('allergies',__('Allergies'),['class'=>'form-label']) }}
                                                {{Form::text('allergies',null,array('class'=>'form-control','placeholder'=>__('Enter Allergies(if any)')))}}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                                <div class="form-group">
                                                    {{Form::label('atttachment',__('Attachments (If Any)'),['class'=>'form-label']) }}
                                                    <input type="file" name="atttachment" id="atttachment" class="form-control">

                                                </div>
                                            </div>

                                    </div>
                              
                                <div class="row">
                                <div class="col-12">
                                <div class="col-6 need_full">
                                    <div class="form-group">
                                        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                        <div class="checkbox-group">
                                            <input type="checkbox" id="approveCheckbox" name="status" value="Approve" {{ $meeting->status == 2 ? 'checked' : '' }}>
                                            <label for="approveCheckbox">Approve</label>

                                            <input type="checkbox" id="resendCheckbox" name="status" value="Resend" {{ $meeting->status == 0 ? 'checked' : '' }}>
                                            <label for="resendCheckbox">Resend</label>

                                            <input type="checkbox" id="withdrawCheckbox" name="status" value="Withdraw" {{ $meeting->status == 3 ? 'checked' : '' }}>
                                            <label for="withdrawCheckbox">Withdraw</label>
                                        </div>
                                    </div>
                                </div>
</div>
</div>
</div>
                                <div class="card-footer text-end">
                                    {{ Form::submit(__('Submit'), ['class' => 'btn  btn-primary ']) }}
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
</script>
<script>
    $('input:checkbox[name= "status"]').click(function() {
        var isChecked = $(this).prop('checked');
        var group = $(this).attr('name');

        if (isChecked) {
            $('input[name="' + group + '"]').not(this).prop('checked', false);
        }
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