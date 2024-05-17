@extends('layouts.admin')
@section('page-title')
{{ __('User Edit') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('settings') }}">{{ __('Settings') }}</a></li>
<li class="breadcrumb-item">{{ __('User') }}</li>
<li class="breadcrumb-item">{{ __('Edit') }}</li>
@endsection

@section('action-btn')
<!-- <div class="btn-group" role="group">
        @if (!empty($previous))
            <div class="action-btn ms-2">
                <a href="{{ route('user.edit', $previous) }}" class="btn btn-sm btn-primary btn-icon m-1"
                    data-bs-toggle="tooltip" title="{{ __('Previous') }}">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </div>
        @else
            <div class="action-btn ms-2">
                <a href="#" class="btn btn-sm btn-primary btn-icon m-1 disabled" data-bs-toggle="tooltip"
                    title="{{ __('Previous') }}">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </div>
        @endif
        @if (!empty($next))
            <div class="action-btn ms-2">
                <a href="{{ route('user.edit', $next) }}" class="btn btn-sm btn-primary btn-icon m-1"
                    data-bs-toggle="tooltip" title="{{ __('Next') }}">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </div>
        @else
            <div class="action-btn ms-2">
                <a href="#" class="btn btn-sm btn-primary btn-icon m-1 disabled" data-bs-toggle="tooltip"
                    title="{{ __('Next') }}">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </div>
        @endif
    </div> -->
@endsection
@section('title')
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{ __('Edit User (') }} {{ $user->name }}
        {{ ')' }}</h5>
</div>
@endsection
@section('content')
<div class="row mt-4">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xl-2">
                <div class="card sticky-top" style="top:30px">
                    <div class="list-group list-group-flush" id="useradd-sidenav">
                        <a href="#useradd-1" class="list-group-item list-group-item-action">{{ __('Edit User') }} <div
                                class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-10">
                <div id="useradd-1" class="card">
                    {{ Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT','enctype'=>'multipart/form-data']) }}
                    <div class="card-header">
                        <h5>{{ __('Overview') }}</h5>
                        <small class="text-muted">{{ __('Edit about your user information') }}</small>
                    </div>

                    <div class="card-body">
                        <!-- <form> -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
                                    @error('name')
                                    <span class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                                    {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Title'), 'required' => 'required']) }}
                                    @error('title')
                                    <span class="invalid-title" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required', 'disabled']) }}
                                    @error('email')
                                    <span class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group intl-tel-input">
                                    {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}

                                    <div class="intl-tel-input">
                                        <input type="tel" id="phone-input" name="phone" class="phone-input form-control"
                                            placeholder="Enter Phone" maxlength="16" value="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="countrycode" id="country-code">

                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('name', __('Gender'), ['class' => 'form-label']) }}
                                    {!! Form::select('gender', $gender ?? '', $user->gender, ['class' =>
                                    'form-control', 'required' => 'required']) !!}
                                    @error('gender')
                                    <span class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('user_roles', __('Roles'), ['class' => 'form-label']) }}
                                    {!! Form::select('user_roles', $roles, null, ['class' => 'form-control ',
                                    'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    {{ Form::label('name', __('Active'), ['class' => 'form-label']) }}
                                    <div>
                                        <input type="checkbox" class="form-check-input" name="is_active"
                                            {{ $user->is_active == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 p-0 modaltitle pb-3 mb-3">
                                <h5 style="margin-left: 14px;">{{__('Attachments(If Any)')}}</h5>
                                <!-- <hr class ="mb-4"> -->
                            </div>
                            <div class="col-12">
                                <div class=" form-group">
                                    {{Form::label('details',__('Upload Attachments'),['class'=>'form-label']) }}
                                    <input type="file" name="details" id="details" class="form-control">
                                </div>
                            </div>

                            <div class="text-end">
                                {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                            </div>  
                        </div>
                        <!-- </form> -->
                    </div>
                    {{ Form::close() }}
                </div>

                <!-- @if (\Auth::user()->type != 'super admin')
                        <div id="useradd-2" class="card">
                            {{ Form::open(['route' => ['streamstore', ['user', $user->name, $user->id]], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                            <div class="card-header">
                                <h5>{{ __('Stream') }}</h5>
                                <small class="text-muted">{{ __('Add stream comment') }}</small>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label('stream', __('Stream'), ['class' => 'form-label']) }}
                                                    {{ Form::text('stream_comment', null, ['class' => 'form-control', 'placeholder' => __('Enter Stream Comment'), 'required' => 'required']) }}
                                                </div>
                                            </div>

                                            <input type="hidden" name="log_type" value="user comment">
                                            <div class="col-12 mb-3 field" data-name="attachments">
                                                <div class="attachment-upload">
                                                    <div class="attachment-button">
                                                        <div class="pull-left">
                                                            <div class="form-group">
                                                            {{ Form::label('attachment', __('Attachment'), ['class' => 'form-label']) }}
                                                            {{-- {{ Form::file('attachment', ['class' => 'form-control']) }} --}}
                                                            <input type="file"name="attachment" class="form-control mb-3" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                            <img id="blah" width="20%" height="20%"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="attachments"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="text-end">
                                                    {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>


                            <div class="col-12">
                                <div class="card-header">
                                    <h5>{{ __('Latest comments') }}</h5>
                                </div>
                                @foreach ($streams as $stream)
                                    @php
                                        $remark = json_decode($stream->remark);
                                    @endphp
                                    @if ($remark->data_id == $user->id)
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-xl-12">
                                                    <ul class="list-group team-msg">
                                                        <li class="list-group-item border-0 d-flex align-items-start mb-2">
                                                            <div class="avatar me-3">
                                                                @php
                                                                    $profile=\App\Models\Utility::get_file('upload/profile/');
                                                                @endphp
                                                                <a href="{{(!empty($stream->file_upload))? ($profile.$stream->file_upload): asset(url("./assets/images/user/avatar-5.jpg"))}}" target="_blank">
                                                                    <img alt="" class="img-user" @if(!empty($stream->file_upload)) src="{{(!empty($stream->file_upload))? ($profile.$stream->file_upload): asset(url("./assets/images/user/avatar-5.jpg"))}}" @else  avatar="{{$remark->user_name}}" @endif>
                                                                </a>


                                                            </div>
                                                            <div class="d-block d-sm-flex align-items-center right-side">
                                                                <div
                                                                    class="d-flex align-items-start flex-column justify-content-center mb-3 mb-sm-0">
                                                                    <div class="h6 mb-1">{{ $remark->user_name }}
                                                                    </div>
                                                                    <span class="text-sm lh-140 mb-0">
                                                                        posted to <a href="#">{{ $remark->title }}</a> ,
                                                                        {{ $stream->log_type }} <a
                                                                            href="#">{{ $remark->stream_comment }}</a>
                                                                    </span>
                                                                </div>
                                                                <div class=" ms-2  d-flex align-items-center ">
                                                                    <small
                                                                        class="float-end ">{{ $stream->created_at }}</small>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            {{ Form::close() }}
                        </div>
                    @endif

                    @if (\Auth::user()->type != 'super admin')
                        <div id="useradd-3" class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5>{{ __('Tasks') }}</h5>
                                        <small class="text-muted">{{ __('Assigned tasks of this user') }}</small>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <a href="#" data-size="md" data-url="{{ route('task.create',['task',0]) }}"
                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                data-title="{{ __('Create New Task') }}" title="{{ __('Create') }}"
                                                class="btn btn-sm btn-primary theme bg-primary btn-icon-only ">
                                                <i class="ti ti-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">
                                                    {{ __('Name') }}</th>
                                                <th scope="col" class="sort" data-sort="budget">
                                                    {{ __('Assign') }}</th>
                                                <th scope="col" class="sort" data-sort="status">
                                                    {{ __('Stage') }}</th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    {{ __('Date Start') }}</th>
                                                <th scope="col" class="text-end">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <td>
                                                        <a href="#" data-size="md"
                                                            data-url="{{ route('task.show', $task->id) }}"
                                                            data-ajax-popup="true" data-title="{{ __('Task Details') }}"
                                                            class="action-item text-primary"> {{ $task->name }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $task->parent }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success p-2 px-3 rounded">{{ !empty($task->stages) ? $task->stages->name : '' }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success p-2 px-3 rounded">{{ \Auth::user()->dateFormat($task->start_date) }}</span>
                                                    </td>
                                                    <td class="text-end">

                                                            @can('Show Task')
                                                                <div class="action-btn bg-warning ms-2">
                                                                    <a href="#" data-size="md"
                                                                        data-url="{{ route('task.show', $task->id) }}"
                                                                        data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                        data-title="{{ __('Task Details') }}"
                                                                        title="{{ __('Details') }}"
                                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                                        <i class="ti ti-eye"></i>
                                                                    </a>
                                                                </div>
                                                            @endcan
                                                            @can('Edit Task')
                                                                <div class="action-btn bg-info ms-2">
                                                                    <a href="{{ route('task.edit', $task->id) }}"
                                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                                        data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                                        data-title="{{ __('Edit Task') }}"><i
                                                                            class="ti ti-edit"></i></a>
                                                                </div>
                                                            @endcan
                                                            @can('Delete Task')
                                                                <div class="action-btn bg-danger ms-2">
                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['task.destroy', $task->id]]) !!}
                                                                    <a href="#!"
                                                                        class="mx-3 btn btn-sm align-items-center text-white show_confirm"
                                                                        data-bs-toggle="tooltip" title='Delete'>
                                                                        <i class="ti ti-trash"></i>
                                                                    </a>
                                                                    {!! Form::close() !!}
                                                                </div>
                                                            @endcan

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    @endif -->
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>

@endsection
@push('css-page')
<style>
.iti.iti--allow-dropdown.iti--separate-dial-code {
    width: 100%;
}
</style>
@endpush
@push('script-page')
<script>
$(document).ready(function() {
    var phoneNumber = "<?php echo $user->phone;?>";
    var num = phoneNumber.trim();
    // if (phoneNumber.trim().length < 10) {
    //     alert('Please enter a valid phone number with at least 10 digits.');
    //     return;
    // }
    var lastTenDigits = phoneNumber.substr(-10);
    var formattedPhoneNumber = '(' + lastTenDigits.substr(0, 3) + ') ' + lastTenDigits.substr(3, 3) + '-' +
        lastTenDigits.substr(6);
    $('#phone-input').val(formattedPhoneNumber);
})
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
</script>
<script>
var scrollSpy = new bootstrap.ScrollSpy(document.body, {
    target: '#useradd-sidenav',
    offset: 300
})
</script>

<script>
$(document).on('change', 'select[name=parent]', function() {

    var parent = $(this).val();
    getparent(parent);
});

function getparent(bid) {
    console.log(bid);
    $.ajax({
        url: '{{ route("task.getparent") }}',
        type: 'POST',
        data: {
            "parent": bid,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
            console.log(data);
            $('#parent_id').empty(); {
                {
                    --$('#parent_id').append('<option value="">{{__("Select Parent")}}</option>');
                    --
                }
            }

            $.each(data, function(key, value) {
                $('#parent_id').append('<option value="' + key + '">' + value + '</option>');
            });
            if (data == '') {
                $('#parent_id').empty();
            }
        }
    });
}
</script>
@endpush