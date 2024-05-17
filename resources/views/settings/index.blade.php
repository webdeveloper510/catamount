@extends('layouts.admin')
@php
$settings = App\Models\Utility::settings();
// $logo = asset(Storage::url('uploads/logo/'));
$logo = \App\Models\Utility::get_file('uploads/logo/');
$color = isset($settings['color']) ? $settings['color'] : 'theme-4';
// $company_logo = \App\Models\Utility::getValByName('company_logo');
// $company_small_logo = \App\Models\Utility::getValByName('company_small_logo');
$company_favicon = \App\Models\Utility::getValByName('company_favicon');
$dark_logo = Utility::getValByName('company_logo_dark');
$light_logo = Utility::getValByName('company_logo_light');
$company_logo = \App\Models\Utility::GetLogo();
$lang = \App\Models\Utility::getValByName('default_language');
$EmailTemplates = App\Models\EmailTemplate::all();
$venue = explode(',',$settings['venue']);
$venue = array_combine($venue,$venue);
if(!empty($settings['function'])){
$function =json_decode($settings['function']);
}
if(!empty($settings['additional_items'])){
$additional_items =json_decode($settings['additional_items'],true);
}
if(!empty($settings['barpackage'])){
$bar =json_decode($settings['barpackage']);
}
if(!empty($settings['fixed_billing'])){
$billing =json_decode($settings['fixed_billing'],true);
}
$campaign = explode(',',$settings['campaign_type']);
$file_type = config('files_types');

$local_storage_validation = $settings['local_storage_validation'];
$local_storage_validations = explode(',', $local_storage_validation);

$s3_storage_validation = $settings['s3_storage_validation'];
$s3_storage_validations = explode(',', $s3_storage_validation);

$wasabi_storage_validation = $settings['wasabi_storage_validation'];
$wasabi_storage_validations = explode(',', $wasabi_storage_validation);

$SITE_RTL = env('SITE_RTL');
if ($SITE_RTL == '') {
$SITE_RTL == 'off';
}
if(isset($settings['event_type']) && !empty($settings['event_type'])){
$eventtypes = explode(',',$settings['event_type']);
}

$meta_image = \App\Models\Utility::get_file('uploads/metaevent/');
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
@endphp

@push('css-page')
@if ($color == 'theme-1')
<style>
/* ul>li>a.active {
        border: 4px solid #fff;
        filter: drop-shadow(5px 6px 6px #145388);
    } */
/* Popup container */
/* .popup {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .popup .popuptext {
        visibility: hidden;
        width: 160px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 8px 0;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -80px;
    }

    .popup .popuptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .popup .show {
        visibility: visible;
        -webkit-animation: fadeIn 1s;
        animation: fadeIn 1s
    }

    @-webkit-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    } */
/* Style the modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

ul>li.active {
    border: 4px solid #fff;
    filter: drop-shadow(5px 6px 6px #145388);
}

.btn-check:checked+.btn-outline-success,
.btn-check:active+.btn-outline-success,
.btn-outline-success:active,
.btn-outline-success.active,
.btn-outline-success.dropdown-toggle.show {
    color: #ffffff;
    background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
    border-color: #51459d !important;

}

.btn-outline-success:hover {
    color: #ffffff;
    background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
    border-color: #51459d !important;
}

.btn.btn-outline-success {
    color: #51459d;
    border-color: #51459d !important;
}
</style>
@endif
@if ($color == 'theme-2')
<style>
.btn-check:checked+.btn-outline-success,
.btn-check:active+.btn-outline-success,
.btn-outline-success:active,
.btn-outline-success.active,
.btn-outline-success.dropdown-toggle.show {
    color: #ffffff;
    background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
    border-color: #1F3996 !important;

}

.btn-outline-success:hover {
    color: #ffffff;
    background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
    border-color: #1F3996 !important;
}

.btn.btn-outline-success {
    color: #1F3996;
    border-color: #1F3996 !important;
}
</style>
@endif
@if ($color == 'theme-4')
<style>
.btn-check:checked+.btn-outline-success,
.btn-check:active+.btn-outline-success,
.btn-outline-success:active,
.btn-outline-success.active,
.btn-outline-success.dropdown-toggle.show {
    color: #ffffff;
    background-color: #584ed2 !important;
    border-color: #584ed2 !important;

}

.btn-outline-success:hover {
    color: #ffffff;
    background-color: #584ed2 !important;
    border-color: #584ed2 !important;
}

.btn.btn-outline-success {
    color: #584ed2;
    border-color: #584ed2 !important;
}
</style>
@endif
@if ($color == 'theme-3')
<style>
.btn-check:checked+.btn-outline-success,
.btn-check:active+.btn-outline-success,
.btn-outline-success:active,
.btn-outline-success.active,
.btn-outline-success.dropdown-toggle.show {
    color: #ffffff;
    background-color: #6fd943 !important;
    border-color: #6fd943 !important;

}

.btn-outline-success:hover {
    color: #ffffff;
    background-color: #6fd943 !important;
    border-color: #6fd943 !important;
}

.btn.btn-outline-success {
    color: #6fd943;
    border-color: #6fd943 !important;
}
</style>
@endif
<style>
/* li:has(> a.active) {
    border-color: #2980b9;
    box-shadow: 0 0 15px rgba(41, 128, 185, 0.8);
} */
li:has(> a.active) {
    border-color: #afafaf;
    box-shadow: 0 0 15px rgb(12 12 12 / 80%);
}

input[type="radio"] {
    display: none;
}

.floorimages {
    height: 250px;
    width: 100%;
    margin: 26px;
}

canvas#signatureCanvas {
    border: 1px solid black;
    width: 100%;
    height: 167px;
    border-radius: 8px;
}

.accordion-collapse {
    display: none;
    /* Initially hide the accordion body */
}
</style>
@endpush
@push('script-page')
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<script>
function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}
</script>
<script>


</script>

<script>
function check_theme(color_val) {
    $('#theme_color').prop('checked', false);
    $('input[value="' + color_val + '"]').prop('checked', true);
}
var scrollSpy = new bootstrap.ScrollSpy(document.body, {
    target: '#useradd-sidenav',
    offset: 300
})
</script>
<script>
$(document).ready(function() {
    $('.list-group-item').on('click', function() {
        var href = $(this).attr('data-href');
        $('.tabs-card').addClass('d-none');
        $(href).removeClass('d-none');
        $('#tabs .list-group-item').removeClass('text-primary');
    });
});

function check_theme(color_val) {
    $('#theme_color').prop('checked', false);
    $('input[value="' + color_val + '"]').prop('checked', true);
}
</script>
<script>
$(document).on("change", "select[name='quote_template'], input[name='quote_color']", function() {
    var template = $("select[name='quote_template']").val();
    var color = $("input[name='quote_color']:checked").val();
    $('#quote_frame').attr('src', '{{ url("/quote/preview")}}' + template + '/' + color);
});
$(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function() {
    var template = $("select[name='invoice_template']").val();
    var color = $("input[name='invoice_color']:checked").val();
    $('#invoice_frame').attr('src', '{{ url("/invoice/preview") }}' + template + '/' + color);
});
$(document).on("change", "select[name='salesorder_template'], input[name='salesorder_color']", function() {
    var template = $("select[name='salesorder_template']").val();
    var color = $("input[name='salesorder_color']:checked").val();
    $('#salesorder_frame').attr('src', '{{ url("/salesorder/preview") }}' + template + '/' + color);
});
</script>

<script>
$(document).on("click", '.send_email', function(e) {
    e.preventDefault();
    var title = $(this).attr('data-title');

    var size = 'md';
    var url = $(this).attr('data-url');
    if (typeof url != 'undefined') {
        $("#commonModal .modal-title").html(title);
        $("#commonModal .modal-dialog").addClass('modal-' + size);
        $("#commonModal").modal('show');

        $.post(url, {
            _token: '{{ csrf_token() }}',
            mail_driver: $("#mail_driver").val(),
            mail_host: $("#mail_host").val(),
            mail_port: $("#mail_port").val(),
            mail_username: $("#mail_username").val(),
            mail_password: $("#mail_password").val(),
            mail_encryption: $("#mail_encryption").val(),
            mail_from_address: $("#mail_from_address").val(),
            mail_from_name: $("#mail_from_name").val(),

        }, function(data) {
            $('#commonModal .modal-body').html(data);
        });
    }
});


$(document).on('submit', '#test_email', function(e) {

    e.preventDefault();
    $("#email_sending").show();
    var post = $(this).serialize();
    var url = $(this).attr('action');
    $.ajax({
        type: "post",
        url: url,
        data: post,
        cache: false,

        success: function(data) {


            if (data.is_success) {
                show_toastr('Success', data.message, 'success');
            } else {
                show_toastr('Error', data.message, 'error');
            }
            $("#email_sending").hide();
            $('#commonModal').modal('hide');
        },
        complete: function() {
            $('#test_email .btn-create').removeAttr('disabled');
        },
    });
});
</script>
<script>
var scrollSpy = new bootstrap.ScrollSpy(document.body, {
    target: '#useradd-sidenav',
    offset: 300,
})
$(".list-group-item").click(function() {
    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $(this).addClass('active');

    }
    // $('.list-group-item').filter(function() {
    //     return this.href == id;
    // }).parent().removeClass('text-primary');
});

function check_theme(color_val) {
    $('#theme_color').prop('checked', false);
    $('input[value="' + color_val + '"]').prop('checked', true);
}

$(document).on('change', '[name=storage_setting]', function() {
    if ($(this).val() == 's3') {
        $('.s3-setting').removeClass('d-none');
        $('.wasabi-setting').addClass('d-none');
        $('.local-setting').addClass('d-none');
    } else if ($(this).val() == 'wasabi') {
        $('.s3-setting').addClass('d-none');
        $('.wasabi-setting').removeClass('d-none');
        $('.local-setting').addClass('d-none');
    } else {
        $('.s3-setting').addClass('d-none');
        $('.wasabi-setting').addClass('d-none');
        $('.local-setting').removeClass('d-none');
    }
});
</script>
<script type="text/javascript">
function enablecookie() {
    const element = $('#enable_cookie').is(':checked');
    $('.cookieDiv').addClass('disabledCookie');
    if (element == true) {
        $('.cookieDiv').removeClass('disabledCookie');
        $("#cookie_logging").attr('checked', true);
    } else {
        $('.cookieDiv').addClass('disabledCookie');
        $("#cookie_logging").attr('checked', false);
    }
}
$(document).ready(function() {
    $('.accordion-button').click(function() {
        console.log('click')
        var target = $(this).attr('data-bs-target');
        $(target).toggle();
    });
});
</script>
@endpush
@section('page-title')
{{ __('Settings') }}
@endsection
@section('title')
{{ __('Settings') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Settings') }}</li>
@endsection
@section('content')
<div class="container-field">
    <div id="wrapper1">
        <div id="page-content-wrapper" class="p0">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="faq justify-content-center">
                            <div class="col-sm-12 col-md-12 col-xxl-12">
                                <div class="accordion accordion-flush setting setting-accordion1" id="accordionExample">
                                    @if (\Auth::user()->type == 'owner')
                                    <div id="company-email-setting" class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse16" aria-expanded="false"
                                                aria-controls="collapse16">
                                                <h5>{{ __('Email Settings') }}</h5>
                                                <small class="text-muted">{{ __('Edit your email details') }}</small>
                                            </button>
                                        </h2>
                                        <div id="collapse16" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                {{ Form::open(['route' => 'email.setting', 'method' => 'post']) }}
                                                <div class="card-body">
                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_driver"
                                                                    class="col-form-label text-dark">{{ __('Mail Driver') }}</label>
                                                                <input type="text" name="mail_driver" id="mail_driver"
                                                                    class="form-control {{ $errors->has('mail_driver') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_driver']) || is_null($settings['mail_driver']) ? '' : $settings['mail_driver'] }}"
                                                                    placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_driver_placeholder') }}" />
                                                                @if ($errors->has('mail_driver'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_driver') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_host"
                                                                    class="col-form-label text-dark">{{ __('Mail Host') }}</label>
                                                                <input type="text" name="mail_host" id="mail_host"
                                                                    class="form-control {{ $errors->has('mail_host') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_host']) || is_null($settings['mail_host']) ? '' : $settings['mail_host'] }}"
                                                                    placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_host_placeholder') }}" />
                                                                @if ($errors->has('mail_host'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_host') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_port"
                                                                    class="col-form-label text-dark">{{ __('Mail Port') }}</label>
                                                                <input type="number" name="mail_port" id="mail_port"
                                                                    class="form-control {{ $errors->has('mail_port') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_port']) || is_null($settings['mail_port']) ? '' : $settings['mail_port'] }}"
                                                                    placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_port_placeholder') }}" />
                                                                @if ($errors->has('mail_port'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_port') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_username"
                                                                    class="col-form-label text-dark">{{ __('Mail Username') }}</label>
                                                                <input type="text" name="mail_username"
                                                                    id="mail_username"
                                                                    class="form-control {{ $errors->has('mail_username') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_username']) || is_null($settings['mail_username']) ? '' : $settings['mail_username'] }}"
                                                                    placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_username_placeholder') }}" />
                                                                @if ($errors->has('mail_username'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_username') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_password"
                                                                    class="col-form-label text-dark">{{ __('Mail Password') }}</label>
                                                                <input type="text" name="mail_password"
                                                                    id="mail_password"
                                                                    class="form-control {{ $errors->has('mail_password') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_password']) || is_null($settings['mail_password']) ? '' : $settings['mail_password'] }}"
                                                                    placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_password_placeholder') }}" />
                                                                @if ($errors->has('mail_password'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_password') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_encryption"
                                                                    class="col-form-label text-dark">{{ __('Mail Encryption') }}</label>
                                                                <input type="text" name="mail_encryption"
                                                                    id="mail_encryption"
                                                                    class="form-control {{ $errors->has('mail_encryption') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_encryption']) || is_null($settings['mail_encryption']) ? '' : $settings['mail_encryption'] }}"
                                                                    placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_encryption_placeholder') }}" />
                                                                @if ($errors->has('mail_encryption'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_encryption') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_from_address"
                                                                    class="col-form-label text-dark">{{ __('Mail From Address') }}</label>
                                                                <input type="text" name="mail_from_address"
                                                                    id="mail_from_address"
                                                                    class="form-control {{ $errors->has('mail_from_address') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_from_address']) || is_null($settings['mail_from_address']) ? '' : $settings['mail_from_address'] }}"
                                                                    placeholder="{{ __('Enter Mail From Address') }}" />
                                                                @if ($errors->has('mail_from_address'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_from_address') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mail_from_name"
                                                                    class="col-form-label text-dark">{{ __('Mail From Name') }}</label>
                                                                <input type="text" name="mail_from_name"
                                                                    id="mail_from_name"
                                                                    class="form-control {{ $errors->has('mail_from_name') ? 'is-invalid' : '' }}"
                                                                    value="{{ !isset($settings['mail_from_name']) || is_null($settings['mail_from_name']) ? '' : $settings['mail_from_name'] }}"
                                                                    placeholder="{{ __('Enter Mail From Name') }}" />
                                                                @if ($errors->has('mail_from_name'))
                                                                <span class="invalid-feedback text-danger text-xs">
                                                                    {{ $errors->first('mail_from_name') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="footer-row justify-content-end felx-wrap d-flex">

                                                            <input type="submit" value="{{ __('Save Changes') }}"
                                                                class="btn btn-print-invoice  btn-primary m-r-10 mb-2">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item card" id="twilio-settings">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse15" aria-expanded="false"
                                                aria-controls="collapse15">
                                                <h5>{{ __('Twilio Settings') }}</h5>
                                                <small class="text-muted">{{ __('Edit your twilio details') }}</small>
                                            </button>
                                        </h2>
                                        <div id="collapse15" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                {{ Form::model($settings, ['route' => 'twilio.setting', 'method' => 'post']) }}
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="form-group col-md-4">
                                                        {{ Form::label('SID', __('SID'), ['class' => 'form-label']) }}
                                                        {{ Form::text('twilio_sid', isset($settings['twilio_sid']) ? $settings['twilio_sid'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Twilio Sid'), 'required' => 'required']) }}
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{ Form::label('Token', __('Token'), ['class' => 'form-label']) }}
                                                        {{ Form::text('twilio_token', isset($settings['twilio_token']) ? $settings['twilio_token'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Twilio Token'), 'required' => 'required']) }}
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{ Form::label('From', __('From'), ['class' => 'form-label']) }}

                                                        {{ Form::text('twilio_from', isset($settings['twilio_from']) ? $settings['twilio_from'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Twilio From'), 'required' => 'required']) }}
                                                    </div>
                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h4 class="small-title">{{ __('Module Settings') }}</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                <span>{{ __('New User') }}</span>
                                                                <div class="form-check form-switch float-end">
                                                                    {{ Form::checkbox('twilio_user_create', '1', isset($settings['twilio_user_create']) && $settings['twilio_user_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_user_create']) }}
                                                                    <label class="form-check-label"
                                                                        for="twilio_user_create"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span>{{ __('New Lead') }}</span>
                                                                <div class="form-check form-switch float-end">
                                                                    {{ Form::checkbox('twilio_lead_create', '1', isset($settings['twilio_lead_create']) && $settings['twilio_lead_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_lead_create']) }}
                                                                    <label class="form-check-label"
                                                                        for="twilio_lead_create"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span>{{ __('New Meeting') }}</span>
                                                                <div class="form-check form-switch float-end">
                                                                    {{ Form::checkbox('twilio_meeting_create', '1', isset($settings['twilio_meeting_create']) && $settings['twilio_meeting_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_meeting_create']) }}
                                                                    <label class="form-check-label"
                                                                        for="twilio_meeting_create"></label>
                                                                </div>
                                                            </li>
                                                            <!-- <li class="list-group-item">
                                                                                <span>{{ __('New Quotes') }}</span>
                                                                                <div class="form-check form-switch float-end">
                                                                                    {{ Form::checkbox('twilio_quotes_create', '1', isset($settings['twilio_quotes_create']) && $settings['twilio_quotes_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_quotes_create']) }}
                                                                                    <label class="form-check-label" for="twilio_quotes_create"></label>
                                                                                </div>
                                                                            </li> -->
                                                        </ul>
                                                    </div>
                                                    <!-- <div class="col-md-4">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <span>{{ __('New Sales Order') }}</span>
                                                            <div class="form-check form-switch float-end">
                                                                {{ Form::checkbox('twilio_salesorder_create', '1', isset($settings['twilio_salesorder_create']) && $settings['twilio_salesorder_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_salesorder_create']) }}
                                                                <label class="form-check-label" for="twilio_salesorder_create"></label>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span>{{ __('New Invoice') }}</span>
                                                            <div class="form-check form-switch float-end">
                                                                {{ Form::checkbox('twilio_invoice_create', '1', isset($settings['twilio_invoice_create']) && $settings['twilio_invoice_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_invoice_create']) }}
                                                                <label class="form-check-label" for="twilio_invoice_create"></label>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span>{{ __('New Invoice Payment') }}</span>
                                                            <div class="form-check form-switch float-end">
                                                                {{ Form::checkbox('twilio_invoicepay_create', '1', isset($settings['twilio_invoicepay_create']) && $settings['twilio_invoicepay_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_invoicepay_create']) }}
                                                                <label class="form-check-label" for="twilio_invoicepay_create"></label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-4">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <span>{{ __('New Meeting') }}</span>
                                                            <div class="form-check form-switch float-end">
                                                                {{ Form::checkbox('twilio_meeting_create', '1', isset($settings['twilio_meeting_create']) && $settings['twilio_meeting_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_meeting_create']) }}
                                                                <label class="form-check-label" for="twilio_meeting_create"></label>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span>{{ __('New Task') }}</span>
                                                            <div class="form-check form-switch float-end">
                                                                {{ Form::checkbox('twilio_task_create', '1', isset($settings['twilio_task_create']) && $settings['twilio_task_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_task_create']) }}
                                                                <label class="form-check-label" for="twilio_task_create"></label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div> -->
                                                    <div class="text-end">
                                                        {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                                                    </div>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @can('Manage User')
                                    <div id="user-settings" class="accordion-item  card">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse17" aria-expanded="false"
                                                aria-controls="collapse17">
                                                <h5>{{ __('Staff Settings') }}</h5>
                                                @can('Create User')
                                                <div class="action-btn bg-warning ms-2" style="float: inline-end;">
                                                    <a href="javascript:void(0);" data-url="{{ route('user.create') }}"
                                                        data-size="md" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                        title="{{ __('Create Staff') }}"
                                                        data-title="{{ __('Create Staff Member') }}"
                                                        class="btn btn-sm btn-primary btn-icon">
                                                        <i class="ti ti-plus"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                            </button>
                                        </h2>
                                        <div id="collapse17" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="table-responsive overflow_hidden">
                                                    <table id="datatable" class="table align-items-center datatable">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="sort" data-sort="username">
                                                                    {{ __('Avatar') }}</th>
                                                                <!-- <th scope="col" class="sort" data-sort="username">{{ __('User Name') }}</th> -->
                                                                <th scope="col" class="sort" data-sort="name">
                                                                    {{ __('Name') }}</th>
                                                                <th scope="col" class="sort" data-sort="email">
                                                                    {{ __('Email') }}</th>
                                                                @if (\Auth::user()->type != 'super admin')
                                                                <th scope="col" class="sort" data-sort="title">
                                                                    {{ __('Type') }}</th>
                                                                <th scope="col" class="sort" data-sort="isactive">
                                                                    {{ __('Status') }}</th>
                                                                @endif
                                                                @if (Gate::check('Edit User') || Gate::check('Delete
                                                                User'))
                                                                <th class="text-end" scope="col">{{ __('Action') }}</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $profile = \App\Models\Utility::get_file('upload/profile/');
                                                            @endphp
                                                            @foreach($users as $user)
                                                            <tr>
                                                                <td>
                                                                    <span class="avatar">
                                                                        <a href="{{ $profile }}{{ !empty($user->avatar) ? $user->avatar : 'avatar.png' }}"
                                                                            target="_blank">
                                                                            <img class="rounded-circle" width="25%"
                                                                                @if($user->avatar)
                                                                            src="{{ $profile }}{{ !empty($user->avatar) ? $user->avatar : 'avatar.png' }}"@else
                                                                            src="{{ $profile . 'avatar.png' }}"
                                                                            @endif alt="{{ $user->name }}">
                                                                        </a>
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <span class="budget"> {{ ucfirst($user->name) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="budget">{{ $user->email }}</span>
                                                                </td>
                                                                @if (\Auth::user()->type != 'super admin')
                                                                <td>
                                                                    {{ ucfirst($user->type) }}
                                                                </td>
                                                                <td>
                                                                    @if ($user->is_active == 1)
                                                                    <span
                                                                        class="badge bg-success p-2 px-3 rounded">{{ __('Active') }}</span>
                                                                    @else
                                                                    <span
                                                                        class="badge bg-danger p-2 px-3 rounded">{{ __('In Active') }}</span>
                                                                    @endif
                                                                </td>
                                                                @endif
                                                                @if (Gate::check('Edit User') || Gate::check('Delete
                                                                User'))
                                                                <td class="text-end">
                                                                    @if(Storage::disk('public')->exists('UserInfo/' .
                                                                    $user->id))
                                                                    <div class="action-btn bg-secondary ms-2"
                                                                        style="float: right;">
                                                                        <a href="#" data-size="md"
                                                                            data-url="{{route('user.docs',$user->id)}}"
                                                                            data-ajax-popup="true"
                                                                            data-bs-toggle="tooltip"
                                                                            data-title="{{ __('Attachments') }}"
                                                                            title="{{ __('Attachments') }}"
                                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                                            <i class="ti ti-eye"></i>
                                                                        </a>
                                                                    </div>
                                                                    @endif
                                                                    <div class="action-btn bg-success ms-2">
                                                                        <a href="javascript:void(0);"
                                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                                            data-size="md"
                                                                            data-url="{{ route('user.reset', \Crypt::encrypt($user->id)) }}"
                                                                            data-ajax-popup="true"
                                                                            title="{{ __('Reset Password') }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-title="{{ __('Reset Password') }}">
                                                                            <i class="ti ti-key"></i>
                                                                        </a>
                                                                    </div>
                                                                    @can('Show User')
                                                                    <div class="action-btn bg-warning ms-2">
                                                                        <a href="javascript:void(0);" data-size="md"
                                                                            data-url="{{ route('user.show', $user->id) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            title="{{ __('Details') }}"
                                                                            data-ajax-popup="true"
                                                                            data-title="{{ __('User Details') }}"
                                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                                            <i class="ti ti-eye"></i>
                                                                        </a>
                                                                    </div>
                                                                    @endcan
                                                                    @can('Edit User')
                                                                    <div class="action-btn bg-info ms-2">
                                                                        <a href="{{ route('user.edit', $user->id) }}"
                                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                                            data-bs-toggle="tooltip"
                                                                            title="{{ __('Edit') }}"
                                                                            data-title="{{ __('Edit User') }}"><i
                                                                                class="ti ti-edit"></i></a>
                                                                    </div>
                                                                    @endcan
                                                                    @can('Delete User')
                                                                    <div class="action-btn bg-danger ms-2">
                                                                        {!! Form::open(['method' => 'DELETE', 'route' =>
                                                                        ['user.destroy', $user->id]]) !!}
                                                                        <a href="#!"
                                                                            class="mx-3 btn btn-sm align-items-center text-white show_confirm"
                                                                            data-bs-toggle="tooltip" title='Delete'>
                                                                            <i class="ti ti-trash"></i>
                                                                        </a>
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    @endcan
                                                                </td>
                                                                @endif
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                    @can('Manage Role')
                                    <div id="role-settings" class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse18" aria-expanded="false"
                                                aria-controls="collapse18">
                                                <h5>{{ __('Role Settings') }}</h5>
                                                @can('Create Role')
                                                <div class="action-btn bg-warning ms-2" style="float: inline-end;">
                                                    <a href="javascript:void(0);" data-url="{{ route('role.create') }}"
                                                        data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                        title="{{__(' Create Role')}}"
                                                        data-title="{{__('Create New Role')}}"
                                                        class="btn btn-sm btn-primary btn-icon m-1">
                                                        <i class="ti ti-plus"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                            </button>
                                        </h2>
                                        <div id="collapse18" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="card-body table-border-style">
                                                    <div class="table-responsive">
                                                        <table class="table datatable" id="datatable1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="150">{{__('Role')}} </th>
                                                                    <th>{{__('Permissions')}} </th>
                                                                    @if(Gate::check('Edit Role') ||
                                                                    Gate::check('Delete Role'))
                                                                    <th width="150" class="text-end">
                                                                        {{__('Action')}} </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($roles as $role)
                                                                <tr>
                                                                    <td width="150">{{ $role->name }}</td>
                                                                    <td class="Permission mt-10">
                                                                        <div class="badges">
                                                                            {{-- @for($j=0;$j<count($role->permissions()->pluck('name'));$j++)
                                                                                                <span class="badge bg-primary p-1 px-2 rounded ">{{$role->permissions()->pluck('name')[$j]}}</span>
                                                                            @endfor --}}
                                                                            @foreach ($role->permissions as $permission)
                                                                            <span
                                                                                class="badge rounded p-2 m-1 px-3 bg-primary">
                                                                                <a href="#"
                                                                                    class="text-white">{{ $permission->name }}</a>
                                                                            </span>
                                                                            @endforeach
                                                                        </div>
                                                                    </td>
                                                                    @if(Gate::check('Edit Role') ||
                                                                    Gate::check('Delete Role'))
                                                                    <td class="text-end">
                                                                        @can('Edit Role')
                                                                        <div class="action-btn bg-info ms-2">
                                                                            <a href="#"
                                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                                                data-url="{{ route('role.edit',$role->id) }}"
                                                                                data-size="lg" data-ajax-popup="true"
                                                                                data-bs-toggle="tooltip"
                                                                                title="{{__('Edit')}}"
                                                                                data-title="{{__('Edit Role')}}">
                                                                                <i class="ti ti-edit"></i>
                                                                            </a>
                                                                        </div>
                                                                        @endcan

                                                                        @can('Delete Role')
                                                                        <div class="action-btn bg-danger ms-2">
                                                                            {!! Form::open(['method' =>
                                                                            'DELETE', 'route' =>
                                                                            ['role.destroy', $role->id]]) !!}
                                                                            <a href="#!"
                                                                                class="mx-3 btn btn-sm  align-items-center text-white show_confirm"
                                                                                data-bs-toggle="tooltip" title='Delete'>
                                                                                <i class="ti ti-trash"></i>
                                                                            </a>
                                                                            {!! Form::close() !!}
                                                                        </div>
                                                                        @endcan
                                                                    </td>
                                                                    @endif
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                    <div id="eventsettings" class="accordion-item card mt-2">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse19" aria-expanded="false"
                                                aria-controls="collapse19">
                                                <h5>{{ __('Event Settings') }}</h5>
                                            </button>
                                        </h2>
                                        <div id="collapse19" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div id="eventtype-settings" class="card">
                                                    <div class="col-md-12">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <h5>{{ __('Event Type Settings') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mt-3">
                                                                {{ Form::open(['route' => 'event_type.setting', 'method' => 'post']) }}
                                                                @csrf
                                                                <div class="form-group col-md-12">
                                                                    {{ Form::label('event_type', __('Event Type'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('event_type',null,['class' => 'form-control ', 'placeholder' => __('Enter Event Type'), 'required' => 'required']) }}
                                                                </div>
                                                                <div class="text-end">
                                                                    {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                                                                </div>
                                                                {{ Form::close() }}
                                                            </div>
                                                            @if(isset($eventtypes) && !empty($eventtypes))
                                                            <div class="row mt-3">
                                                                <div class="form-group col-md-12">
                                                                    <label class="form-label">Events List</label>
                                                                    <div class="badges">
                                                                        @foreach ($eventtypes as $types)
                                                                        <span
                                                                            class="badge rounded p-2 m-1 px-3 bg-primary"
                                                                            style="cursor:pointer">
                                                                            {{ $types }}
                                                                            @if(Gate::check('Delete Role'))
                                                                            @can('Delete Role')
                                                                            <div class="action-btn  ms-2">
                                                                                <a href="#!"
                                                                                    class="mx-3 btn btn-sm  align-items-center text-white event_show_confirm"
                                                                                    data-bs-toggle="tooltip"
                                                                                    title='Delete'
                                                                                    data-url="{{ route('eventedit.setting') }}"
                                                                                    data-token="{{ csrf_token() }}">
                                                                                    <i class="ti ti-trash"></i>
                                                                                </a>
                                                                            </div>
                                                                            @endcan
                                                                            @endif
                                                                        </span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="venue-settings" class="card">
                                                    <div class="col-md-12">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <h5>{{ __('Venue Settings') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mt-3">
                                                                {{ Form::open(['route' => 'venue.setting', 'method' => 'post']) }}
                                                                @csrf
                                                                <div class="form-group col-md-12">
                                                                    {{ Form::label('venue', __('Venue'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('venue',null,['class' => 'form-control ', 'placeholder' => __('Enter Venue'), 'required' => 'required']) }}
                                                                </div>
                                                                <div class="text-end">
                                                                    {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                                                                </div>
                                                                {{ Form::close() }}
                                                            </div>
                                                            @if(isset($venue) && !empty($venue))
                                                            <div class="row mt-3">
                                                                <div class="form-group col-md-12">
                                                                    <label class="form-label">Venue</label>
                                                                    <div class="badges">
                                                                        @foreach ($venue as $value)
                                                                        <span
                                                                            class="badge rounded p-2 m-1 px-3 bg-primary"
                                                                            style="cursor:pointer">
                                                                            {{ $value }}
                                                                            @if(Gate::check('Delete Role'))
                                                                            @can('Delete Role')
                                                                            <div class="action-btn  ms-2">
                                                                                <a href="#!"
                                                                                    class="mx-3 btn btn-sm  align-items-center text-white venue_show_confirm"
                                                                                    data-bs-toggle="tooltip"
                                                                                    title='Delete'
                                                                                    data-url="{{ route('venueedit.setting') }}"
                                                                                    data-token="{{ csrf_token() }}">
                                                                                    <i class="ti ti-trash"></i>
                                                                                </a>
                                                                            </div>
                                                                            @endcan
                                                                            @endif
                                                                        </span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="function-settings" class="card">
                                                    <div class="col-md-12">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <h5>{{ __('Function Settings') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mt-3">
                                                                {{ Form::open(['route' => 'function.setting', 'method' => 'post']) }}
                                                                @csrf
                                                                <div class="form-group col-md-12">
                                                                    {{ Form::label('function', __('Function'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('function',null,['class' => 'form-control ', 'placeholder' => __('Enter Function'), 'required' => 'required']) }}
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    {{ Form::label('package', __('Package'), ['class' => 'form-label']) }}
                                                                    <span
                                                                        class="btn btn-sm btn-primary btn-icon m-1 add"
                                                                        style="border-radius: 20px !important;    font-size: 12px;
                                                                                    "><i
                                                                            class="fa fa-plus "></i></span>
                                                                    <div class="appending_div">
                                                                        <div class="appending_item"
                                                                            style="display:flex">
                                                                            <input type="text" name="package[]"
                                                                                class="form-control"
                                                                                placeholder="Enter Package">
                                                                            <span
                                                                                class="btn btn-sm btn-danger btn-icon m-1 delete"><i
                                                                                    class="fa fa-times"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-end">
                                                                    {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                                                                </div>
                                                                <style>
                                                                .add {
                                                                    cursor: pointer;
                                                                }
                                                                </style>
                                                                {{ Form::close() }}
                                                            </div>
                                                            @if(isset($function) && !empty($function))
                                                            <div class="row mt-3">
                                                                <div class="form-group col-md-12">
                                                                    <label class="form-label">Function</label>
                                                                    <div class="badges">
                                                                        <ul class="nav nav-tabs tabActive"
                                                                            style="border-bottom:none;">
                                                                            @foreach ($function as $key=> $value)
                                                                            <li
                                                                                class="badge rounded p-2 m-1 px-3 bg-primary ">
                                                                                <a style="color: white;"
                                                                                    data-toggle="tab"
                                                                                    href="#menu{{$key}}"
                                                                                    class="<?= $key == 0 ? 'active' : ''; ?> fxnnames">{{$value->function}}
                                                                                </a>

                                                                                <div class="action-btn  ms-2">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="mx-3 btn btn-sm  align-items-center text-white function_show_confirm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-id="{{$key}}"
                                                                                        title='Delete'
                                                                                        data-url="{{ route('functionpackage.setting') }}"
                                                                                        data-token="{{ csrf_token() }}">
                                                                                        <i class="ti ti-trash"></i>
                                                                                    </a>
                                                                                </div>

                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <div class="tab-content">
                                                                            <label
                                                                                class="form-label mt-3"><b>Package</b></label><br>
                                                                            @foreach ($function as $key=> $value)
                                                                            <div id="menu{{$key}}"
                                                                                class="tab-pane fade <?= $key == 0 ? 'in active show' : ''; ?>">
                                                                                @foreach($value->package as $package)
                                                                                <span
                                                                                    class="badge rounded p-2 m-1 px-3 bg-info"
                                                                                    style="cursor:pointer">
                                                                                    {{$package}}
                                                                                    <div class="action-btn ms-2">
                                                                                        <a href="javascript:void(0);"
                                                                                            class="mx-3 btn btn-sm  align-items-center text-white function_package_show_confirm"
                                                                                            data-bs-toggle="tooltip"
                                                                                            title='Delete'
                                                                                            data-url="{{ route('functionedit.setting') }}"
                                                                                            data-id="{{$key}}"
                                                                                            data-token="{{ csrf_token() }}">
                                                                                            <i class="ti ti-trash"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </span>
                                                                                @endforeach
                                                                            </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="bar-settings" class="card">
                                                    <div class="col-md-12">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <h5>{{ __('Bar Settings') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mt-3">
                                                                {{ Form::open(['route' => 'bar.setting', 'method' => 'post']) }}
                                                                @csrf
                                                                <div class="form-group col-md-12">
                                                                    {{ Form::label('bar', __('Bar'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('bar',null,['class' => 'form-control ', 'placeholder' => __('Enter Bar'), 'required' => 'required']) }}
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    {{ Form::label('barpackage', __('Bar Package'), ['class' => 'form-label']) }}
                                                                    <span
                                                                        class="btn btn-sm btn-primary btn-icon m-1 addbar"
                                                                        style="border-radius: 20px !important;    font-size: 12px;
                                                                                    "><i
                                                                            class="fa fa-plus "></i></span>
                                                                    <div class="appending_div_for_bar">
                                                                        <div class="appending_item_for_bar"
                                                                            style="display:flex">
                                                                            <input type="text" name="barpackage[]"
                                                                                class="form-control"
                                                                                placeholder="Enter Bar Package">
                                                                            <span
                                                                                class="btn btn-sm btn-danger btn-icon m-1 deletebar"><i
                                                                                    class="fa fa-times"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-end">
                                                                    {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                                                                </div>

                                                                <style>
                                                                .add {
                                                                    cursor: pointer;
                                                                }
                                                                </style>
                                                                {{ Form::close() }}
                                                            </div>
                                                            @if(isset($bar) && !empty($bar))
                                                            <div class="row mt-3">
                                                                <div class="form-group col-md-12">
                                                                    <label class="form-label">Bar</label>
                                                                    <div class="badges">
                                                                        <ul class="nav nav-tabs tabActive"
                                                                            style="border-bottom:none;">
                                                                            @foreach ($bar as $key=> $value)
                                                                            <li
                                                                                class="badge rounded p-2 m-1 px-3 bg-primary ">
                                                                                <a style="color: white;"
                                                                                    data-toggle="tab"
                                                                                    href="#barmenu{{$key}}"
                                                                                    class="<?= $key == 0 ? 'active' : ''; ?> barnmes">{{$value->bar}}
                                                                                </a>

                                                                                <div class="action-btn  ms-2">
                                                                                    <a href="javascript:void(0);"
                                                                                        class="mx-3 btn btn-sm  align-items-center text-white bar_show_confirm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-id="{{$key}}"
                                                                                        title='Delete'
                                                                                        data-url="{{ route('barpackage.setting') }}"
                                                                                        data-token="{{ csrf_token() }}">
                                                                                        <i class="ti ti-trash"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>

                                                                        <div class="tab-content">
                                                                            <label
                                                                                class="form-label mt-3"><b>Package</b></label><br>
                                                                            @foreach ($bar as $key=> $value)
                                                                            <div id="barmenu{{$key}}"
                                                                                class="tab-pane fade <?= $key == 0 ? 'in active show' : ''; ?>">
                                                                                @foreach($value->barpackage as $package)
                                                                                @if(!empty($package))
                                                                                <span
                                                                                    class="badge rounded p-2 m-1 px-3 bg-info"
                                                                                    style="cursor:pointer">
                                                                                    {{$package}}
                                                                                    <div class="action-btn ms-2">
                                                                                        <a href="javascript:void(0);"
                                                                                            class="mx-3 btn btn-sm  align-items-center text-white bar_package_show_confirm"
                                                                                            data-bs-toggle="tooltip"
                                                                                            title='Delete'
                                                                                            data-url="{{ route('baredit.setting') }}"
                                                                                            data-id="{{$key}}"
                                                                                            data-token="{{ csrf_token() }}">
                                                                                            <i class="ti ti-trash"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </span>
                                                                                @endif
                                                                                @endforeach
                                                                            </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="floor-plan-setting" class="card">
                                                    <div class="col-md-12">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div id="floor-plan-setting"
                                                                    class="col-lg-8 col-md-8 col-sm-8">
                                                                    <h5>{{ __('Upload Setup') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mt-3">
                                                                <form method="POST" action="{{ url('/floor-images') }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="setup" class="form-label">Choose
                                                                                Image</label></br>
                                                                            <input type="file" name="setup"
                                                                                class="form-control" required />
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="title"
                                                                                class="form-label">Title</label></br>
                                                                            <input type="text" class="form-control"
                                                                                name="title" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-12">
                                                                        <label for="description"
                                                                            class="form-label">Description</label></br>
                                                                        <!-- <input type="textarea" class="form-control" name="description" rows="3" >      -->
                                                                        <textarea name="description" id="description"
                                                                            class="form-control" rows="3"></textarea>
                                                                    </div>
                                                                    <div class="text-end">
                                                                        <button type="submit"
                                                                            class="btn-submit btn btn-primary">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                @foreach($setup as $s)
                                                                <div class="col-6">
                                                                    <input type="radio" id="image_{{ $loop->index }}"
                                                                        name="uploadedImage" class="form-check-input"
                                                                        value="{{ asset('floor_images/' . $s->image) }}">
                                                                    <label for="image_{{ $loop->index }}"
                                                                        class="form-check-label">
                                                                        <img src="{{asset('floor_images/'.$s->image)}}"
                                                                            alt="Uploaded Image"
                                                                            class="img-thumbnail floorimages zoom">
                                                                        <span
                                                                            class=" rounded p-2 m-1 px-3 bg-danger text-white"
                                                                            style="float: inline-end;"><i
                                                                                class="ti ti-trash "
                                                                                data-image="{{ $s->image }}"
                                                                                onclick="deleteImage(this)"></i></span>
                                                                    </label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="campaign-type" class="card">
                                                    <div class="col-md-12">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <h5>{{ __('Campaign Settings') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="POST" action="{{route('settings.campaign-type')}}"
                                                            id='campaign'>
                                                            @csrf
                                                            <div class="card-body">
                                                                <div class="row mt-3">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            {{ Form::label('campaign_type', __('Campaign Type'), ['class' => 'form-label']) }}
                                                                            {!! Form::text('campaign_type',null,
                                                                            ['class' => 'form-control',
                                                                            'required' => 'required']) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-end">
                                                                        <input type="submit" value="Save"
                                                                            class="btn-submit btn btn-primary">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    @if(isset($campaign) && !empty($campaign))
                                                    <div class="row mt-3">
                                                        <div class="form-group col-md-12">
                                                            <label class="form-label">Campaign</label>
                                                            <div class="badges">
                                                                @foreach ($campaign as $value)
                                                                <span class="badge rounded p-2 m-1 px-3 bg-primary"
                                                                    style="cursor:pointer">
                                                                    {{ $value }}
                                                                    <div class="action-btn  ms-2">
                                                                        <a href="#!"
                                                                            class="mx-3 btn btn-sm  align-items-center text-white campaign_show_confirm"
                                                                            data-bs-toggle="tooltip" title='Delete'
                                                                            data-url="{{ route('settings.delete.campaign-type') }}"
                                                                            data-token="{{ csrf_token() }}">
                                                                            <i class="ti ti-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div id="additional-settings" class="card">
                                                    <div class="col-md-12">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <h5>{{ __('Additional Settings') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mt-3">
                                                                {{ Form::open(['route' => 'additional.setting', 'method' => 'post']) }}
                                                                @csrf
                                                                <div id="additional-items-container">
                                                                    <div class="row form-group">
                                                                        <label for='additional_function'>Select
                                                                            Package</label>

                                                                        <div class="col-md-6">
                                                                            @if(isset($function) && !empty($function))
                                                                            <select name="additional_function"
                                                                                id="additional_function"
                                                                                class="form-select">
                                                                                <option value="0" selected disabled>
                                                                                    Select Function</option>
                                                                                @foreach($function as $key =>$value)
                                                                                <option value="{{$key}}">
                                                                                    {{$value->function}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div id="additional_packages_checkboxes">
                                                                            </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-5">
                                                                            {{ Form::label('additional_items[]', __('Additional Item ' . $i=1), ['class' => 'form-label']) }}
                                                                            {{ Form::text('additional_items[]', null, ['class' => 'form-control', 'placeholder' => __('Enter Additional Item'), 'required' => 'required']) }}
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            {{ Form::label('additional_items_cost[]', __('Cost'), ['class' => 'form-label']) }}
                                                                            {{ Form::number('additional_items_cost[]', null, ['class' => 'form-control', 'placeholder' => __('Enter Cost'), 'required' => 'required']) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-end">
                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="addAdditionalItem()"
                                                                        title="Add Additional items"><i
                                                                            class="fa fa-plus"></i></button>
                                                                    <input type="submit" value="Save"
                                                                        class="btn-submit btn btn-primary">
                                                                </div>

                                                                {{ Form::close() }}
                                                            </div>
                                                            @if(isset($additional_items) && !empty($additional_items))
                                                            <div class="row mt-3">
                                                                <div class="form-group col-md-12">
                                                                    <label class="form-label">Additional Items</label>
                                                                    <div class="table-responsive">
                                                                    <table class="table table-striped table-bordered"
                                                                        style=" border: 1px solid #9b8c8c">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Function</th>
                                                                                <th scope="col">Package</th>
                                                                                <th scope="col">Additional Item</th>
                                                                                <th scope="col">Cost</th>
                                                                                <th scope="col">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                @foreach ($additional_items as $functionName => $packages)
                                                                                @foreach ($packages as $packageName => $items)
                                                                            <tr>
                                                                                <td data-td-data="{{ $functionName }}"
                                                                                    rowspan="{{ count($items) }}"
                                                                                    class="functionname">
                                                                                    {{ $functionName }}</td>
                                                                                <td data-td-data="{{ $packageName }}"
                                                                                    rowspan="{{ count($items) }}"
                                                                                    class="package">
                                                                                    {{ $packageName }}</td>
                                                                                @php $firstItem = true; @endphp
                                                                                @foreach ($items as $itemName => $cost)
                                                                                @if (!$firstItem)
                                                                            <tr>
                                                                                @endif

                                                                                <td class="item">{{ $itemName }}</td>
                                                                                <td class="cost">{{ $cost }}</td>
                                                                                <td data-function="{{ $functionName }}"
                                                                                    data-package="{{ $packageName }}">
                                                                                    <button
                                                                                        class="btn btn-sm edit-cost-btn bg-info">
                                                                                        <i
                                                                                            class="ti ti-edit"></i></button>
                                                                                    <a href="#!"
                                                                                        class="mx-3 btn btn-sm  align-items-center bg-info text-white additional_show_confirm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title='Delete'
                                                                                        data-function="{{ $functionName }}"
                                                                                        data-package="{{ $packageName }}"
                                                                                        data-item="{{$itemName}}"
                                                                                        data-url="{{ route('additionaldelete.setting') }}"
                                                                                        data-token="{{ csrf_token() }}">
                                                                                        <i class="ti ti-trash"></i>
                                                                                    </a>
                                                                                </td>

                                                                                @php $firstItem = false; @endphp
                                                                                @endforeach
                                                                            </tr>

                                                                            @endforeach
                                                                            @endforeach
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                            </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    @can('Manage Payment')
                                    <div id="billing-setting" class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse20" aria-expanded="false"
                                                aria-controls="collapse20">
                                                <h5>{{ __('Billing Settings') }}</h5>
                                                <small class="text-muted">{{ __('Edit your billing details') }}</small>
                                            </button>
                                        </h2>
                                        <div id="collapse20" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                {{ Form::open(['route' => 'billing.setting', 'method' => 'post']) }}
                                                @csrf

                                                <div class="row cst-border">
                                                    @if(isset($venue) && !empty($venue))
                                                    <div class="col-sm-6 venue">
                                                        <table class="table table-responsive table-bordered"
                                                            style="width:100%">
                                                            <tr>
                                                                <th>{{__('Venue')}}</th>
                                                                <th>{{__('Venue Cost')}}</th>
                                                            </tr>
                                                            @foreach($venue as $venueKey => $venueValue)
                                                            <tr>
                                                                <td>{{__($venueKey)}}</td>
                                                                <td><input type="number" class="form-control"
                                                                        name="venue[{{ isset($venueKey) ? $venueKey : '' }}]"
                                                                        id="venue_{{$venueKey}}"
                                                                        value="{{ isset($billing['venue'][$venueKey]) ? $billing['venue'][$venueKey] : '' }}"
                                                                        placeholder="{{__($venueKey)}}" min="0">
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                    @endif
                                                    @if(isset($function) && !empty($function))
                                                    <div class="col-sm-6 function">
                                                        <table class="table table-responsive table-bordered"
                                                            style="width:100%">
                                                            <tr>
                                                                <th>{{__('Package')}}</th>
                                                                <th>{{__('Package Cost')}}</th>
                                                            </tr>
                                                            @foreach($function as $functionKey => $functionValue)
                                                            <tr>
                                                                <td><b>{{__($functionValue->function)}}</b></td>
                                                                <td>
                                                                    @foreach($functionValue->package as $packageKey=> $packageValue)
                                                                    {{ Form::label($packageValue, __($packageValue), ['class' => 'form-label']) }}
                                                                    <input type="number" class="form-control"
                                                                        name="package[{{isset($functionValue->function)? $functionValue->function :''}}][{{ isset($packageValue) ? $packageValue : '' }}]"
                                                                        id="package_{{isset($packageKey)? $packageKey :''}}"
                                                                        value="{{ isset($billing['package'][$functionValue->function][$packageValue]) ? $billing['package'][$functionValue->function][$packageValue] : '' }}"
                                                                        placeholder="Enter {{ isset($packageValue) ? $packageValue :''}} Cost"
                                                                        min="0">
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                    @endif
                                                    @if(isset($bar) && !empty($bar))
                                                    <div class="col-sm-6 bar mt-3">
                                                        <table class="table table-responsive table-bordered"
                                                            style="width:100%">
                                                            <tr>
                                                                <th>{{__('Bar')}}</th>
                                                                <th>{{__('Bar Cost')}}</th>
                                                            </tr>
                                                            @foreach($bar as $barKey => $barValue)
                                                            <tr>
                                                                <td><b>{{__($barValue->bar)}}</b></td>
                                                                <td>
                                                                    @foreach($barValue->barpackage as $barpackageKey=>$barpackageValue)
                                                                    {{ Form::label($barpackageValue, __($barpackageValue), ['class' => 'form-label']) }}
                                                                    <input type="number" class="form-control"
                                                                        name="barpackage[{{ isset($barValue->bar) ? $barValue->bar : '' }}][{{ isset($barpackageValue) ? $barpackageValue : '' }}]"
                                                                        id="barpackage_{{ isset($barpackageKey) ? $barpackageKey : '' }}"
                                                                        value="{{ isset($billing['barpackage'][isset($barValue->bar) ? $barValue->bar : ''][$barpackageValue]) ? $billing['barpackage'][isset($barValue->bar) ? $barValue->bar : ''][$barpackageValue] : '' }}"
                                                                        placeholder="{{ isset($barpackageValue) ? $barpackageValue : '' }}"
                                                                        min="0">
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                    @endif
                                                    <div class="col-sm-6 equipment">
                                                        <div class="form-group">
                                                            {{ Form::label('equipment', __('Equipment'), ['class' => 'form-label']) }}
                                                            <input type="number" name="equipment" id=""
                                                                class="form-control"
                                                                value="{{ isset($billing['equipment']) ? $billing['equipment'] : ''}}"
                                                                placeholder="Enter Equipments Cost (eg. Tent, Tables, Chairs)"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('welcomesetup', __('Welcome Setup'), ['class' => 'form-label']) }}
                                                            <input type="number" name="welcomesetup" id=""
                                                                class="form-control"
                                                                value="{{ isset($billing['welcomesetup']) ? $billing['welcomesetup'] : ''}}"
                                                                placeholder="Enter Welcome Setup Cost" required>
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('rehearsalsetup', __('Rehearsel Setup'), ['class' => 'form-label']) }}
                                                            <input type="number" name="rehearsalsetup"
                                                                class="form-control"
                                                                value="{{ isset($billing['rehearsalsetup']) ? $billing['rehearsalsetup'] : ''}}"
                                                                placeholder="Enter Rehearsel Setup Cost" required>
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('hotel_rooms', __('Hotel Rooms'), ['class' => 'form-label']) }}
                                                            <input type="number" name="hotel_rooms" class="form-control"
                                                                value="{{ isset($billing['hotel_rooms']) ? $billing['hotel_rooms'] : ''}}"
                                                                placeholder="Enter Hotel Rooms Cost" required>
                                                        </div>
                                                        <div class="form-group">
                                                            {{ Form::label('special_req', __('Special Request/Others'), ['class' => 'form-label']) }}
                                                            <input type="number" name="special_req" class="form-control"
                                                                value="{{ isset($billing['special_req']) ? $billing['special_req'] : ''}}"
                                                                placeholder="Enter  Cost" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                    @if (\Auth::user()->type == 'owner')
                                    <div id="buffer-settings" class=" accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse21" aria-expanded="false"
                                                aria-controls="collapse21">
                                                <h5>{{ __('Buffer Settings') }}</h5>
                                                <small class="text-muted">{{ __('Edit your buffer settings') }}</small>
                                            </button>
                                        </h2>
                                        <div id="collapse21" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                {{ Form::open(['route' => 'buffer.setting', 'method' => 'post']) }}
                                                @csrf
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('buffer_time', __('Add Buffer Time'), ['class' => 'form-label']) }}
                                                        {!! Form::input('time', 'buffer_time', $settings['buffer_time'],
                                                        ['class' =>
                                                        'form-control', 'required' => 'required']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('buffer_day', __('Add Buffer Day'), ['class' => 'form-label']) }}
                                                        {!! Form::number('buffer_day', $settings['buffer_day'], ['class'
                                                        =>
                                                        'form-control', 'required' => 'required','min' => '0']) !!}
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="text-end">
                                                    {{ Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary']) }}
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div id="add-signature" class="accordion-item  card">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse22" aria-expanded="false"
                                                aria-controls="collapse22">
                                                <h5>{{ __('Authorised Signature') }}</h5>
                                            </button>
                                        </h2>
                                        <div id="collapse22" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                            <form method="POST" id='sign'>
                                                @csrf
                                                <div class="card-body1">
                                                    <div class="row mt-3">
                                                        <div class="col-6 need_full">
                                                            <strong>Existing Signature:</strong> <br>
                                                            <img src="{{$base64Image}}"
                                                                style=" width: 55%;padding-right: 39px;border-bottom: 1px solid black;">
                                                        </div>
                                                        <div class="col-6 need_full">
                                                            <strong> Signature:</strong>
                                                            <br>
                                                            <div id="sig" class="mt-5">
                                                                <canvas id="signatureCanvas" width="300"
                                                                    class="signature-canvas"></canvas>
                                                                <input type="hidden" name="imageData" id="imageData">
                                                            </div>
                                                            <div class="row">
                                                            <div class="col-6 need_full">
                                                            <button type="button" id="clearButton"
                                                                class="btn btn-danger btn-sm mt-1">Clear
                                                                Signature</button>
                                                        </div>
                                                        <div class="col-6 need_full">
                                                                <div class="text-end mobile-text">
                                                            <input type="submit" value="Save"
                                                                class="btn-submit btn btn-primary">
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- <div id="pusher-settings" class="card">
                        <div class="card-header">
                            <h5>{{ __('Pusher Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit your pusher details') }}</small>
                        </div>
                        <div class="card-body">
                            {{ Form::model($settings, ['route' => 'pusher.setting', 'method' => 'post']) }}
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_id', __('Pusher App Id *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_id', isset($settings['pusher_app_id']) ? $settings['pusher_app_id'] : '', ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Id', 'required' => 'required']) }}
                                    @error('pusher_app_id')
                                        <span class="invalid-pusher_app_id" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_key', __('Pusher App Key *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_key', isset($settings['pusher_app_key']) ? $settings['pusher_app_key'] : '', ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Key', 'required' => 'required']) }}
                                    @error('pusher_app_key')
                                        <span class="invalid-pusher_app_key" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_secret', __('Pusher App Secret *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_secret', isset($settings['pusher_app_secret']) ? $settings['pusher_app_secret'] : '', ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Key', 'required' => 'required']) }}
                                    @error('pusher_app_secret')
                                        <span class="invalid-pusher_app_secret" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_cluster', __('Pusher App Cluster *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_cluster', isset($settings['pusher_app_cluster']) ? $settings['pusher_app_cluster'] : '' , ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Cluster', 'required' => 'required']) }}
                                    @error('pusher_app_cluster')
                                        <span class="invalid-pusher_app_cluster" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div> -->
                        <!-- <div id="brand-settings" class="card">
                            <div class="card-header">
                                <h5>{{ __('Brand Settings') }}</h5>
                                <small class="text-muted">{{ __('Edit your brand details') }}</small>
                            </div>
                            {{ Form::model($settings, ['route' => 'business.setting', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title">{{ __('Dark Logo') }}</h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content logo-set-bg py-2" style="height:65px">
                                                            {{-- <a href="{{ asset(Storage::url('uploads/logo/logo-dark.png')) }}"
                                                            target="_blank">
                                                            <img id="blah4" alt="your image"
                                                                src="{{ asset(Storage::url('uploads/logo/logo-dark.png')) }}"
                                                                width="170px" class="">
                                                            </a> --}}
                                                            <a href="{{ $logo . 'logo-dark.png' . '?' . time() }}"
                                                                target="_blank" style="height: 50px; width:150px;">
                                                                <img id="blah4" alt="your image"
                                                                    src="{{ $logo . 'logo-dark.png' . '?' . time() }}"
                                                                    style="height: 50px; width:150px;" class="big-logo">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">

                                                        <div class="choose-files mt-5">
                                                            <label for="logo_dark">
                                                                <div class=" bg-primary"> <i
                                                                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                </div>
                                                                <input type="file" name="logo_dark" id="logo_dark"
                                                                    class="form-control file"
                                                                    data-filename="company_logo_update"
                                                                    onchange="document.getElementById('blah4').src = window.URL.createObjectURL(this.files[0])">

                                                                {{-- <input type="file" name="logo_dark" id="logo_dark" class="form-control file" data-filename="company_logo_update"> --}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title">{{ __('Light Logo') }}</h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content logo-set-bg py-2" style="height:65px">
                                                            {{-- <a href="{{ asset(Storage::url('uploads/logo/logo-light.png')) }}"
                                                            target="_blank">
                                                            <img id="blah5" alt="your image"
                                                                src="{{ asset(Storage::url('uploads/logo/logo-light.png')) }}"
                                                                width="170px" class="img_setting">
                                                            </a> --}}
                                                            <a href="{{ $logo . 'logo-light.png' . '?' . time() }}"
                                                                target="_blank" style="height: 50px; width:150px;">
                                                                <img id="blah5" alt="your image"
                                                                    src="{{ $logo . 'logo-light.png' . '?' . time() }}"
                                                                    style="height: 50px; width:150px;"
                                                                    class="img_setting">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">

                                                        <div class="choose-files mt-5">
                                                            <label for="logo_light">
                                                                <div class=" bg-primary"> <i
                                                                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                </div>
                                                                <input type="file" name="logo_light" id="logo_light"
                                                                    class="form-control file"
                                                                    data-filename="company_logo_update"
                                                                    onchange="document.getElementById('blah5').src = window.URL.createObjectURL(this.files[0])">

                                                                {{-- <input type="file" name="logo_light" id="logo_light" class="form-control file" data-filename="company_logo_update"> --}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title">{{ __('Favicon') }}</h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content logo-set-bg py-2" style="height:65px">
                                                            {{-- <a href="{{ asset(Storage::url('uploads/logo/favicon.png')) }}"
                                                            target="_blank">
                                                            <img id="blah6" alt="your image"
                                                                src="{{ $logo . '/' . (isset($favicon) && !empty($favicon) ? $favicon : 'favicon.png') }}"
                                                                width="50px" class="img_setting">
                                                            </a> --}}
                                                            <a href="{{ $logo . 'favicon.png' . '?' . time() }}"
                                                                target="_blank">
                                                                <img id="blah6" alt="your image"
                                                                    src="{{ $logo . 'favicon.png' . '?' . time() }}"
                                                                    width="50px" class="img_setting">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="choose-files mt-5">
                                                            <label for="favicon">
                                                                <div class=" bg-primary"> <i
                                                                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                </div>
                                                                <input type="file" name="favicon" id="favicon"
                                                                    class="form-control file"
                                                                    data-filename="company_logo_update"
                                                                    onchange="document.getElementById('blah6').src = window.URL.createObjectURL(this.files[0])">
                                                                {{-- <input type="file" name="favicon" id="favicon" class="form-control file" data-filename="company_logo_update"> --}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            {{ Form::label('title_text', __('Title Text'), ['class' => 'form-label']) }}
                                            {{ Form::text('title_text', null, ['class' => 'form-control', 'placeholder' => __('Title Text')]) }}
                                            @error('title_text')
                                            <span class="invalid-title_text" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        @if (\Auth::user()->type == 'super admin')
                                        <div class="form-group col-md-4">
                                            {{ Form::label('footer_text', __('Footer Text'), ['class' => 'form-label']) }}
                                            {{ Form::text('footer_text', null, ['class' => 'form-control', 'placeholder' => __('Footer Text')]) }}
                                            @error('footer_text')
                                            <span class="invalid-footer_text" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            {{ Form::label('default_language', __('Default Language'), ['class' => 'form-label']) }}
                                            <div class="changeLanguage">
                                                <select name="default_language" id="default_language"
                                                    class="form-control custom-select">
                                                    @foreach (\App\Models\Utility::languages() as $code => $language)
                                                    <option @if ($lang==$code) selected @endif value="{{ $code }}">
                                                        {{ ucfirst($language) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="col switch-width">
                                                <div class="form-group ml-2 mr-3">
                                                    <label
                                                        class="form-label mb-1">{{ __('Enable Landing Page') }}</label>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" class="" name="display_landing_page"
                                                            id="display_landing_page"
                                                            {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label mb-1"
                                                            for="display_landing_page"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="col switch-width">
                                                <div class="form-group ml-2 mr-3 ">

                                                    {{ Form::label('verified_button', __('Email Verification'), ['class' => 'form-label']) }}
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" class="" name="verified_button"
                                                            id="verified_button"
                                                            {{ Utility::getValByName('verified_button') == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="verified_button"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="col switch-width">
                                                <div class="form-group ml-2 mr-3 ">
                                                    {{ Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'form-label']) }}
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" class="" name="SITE_RTL"
                                                            id="SITE_RTL"
                                                            {{ $settings['SITE_RTL'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label" for="SITE_RTL"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-4">
                                            <div class="col switch-width">
                                                <div class="form-group ml-2 mr-3 ">
                                                    {{ Form::label('signup_button', __('Enable Sign-Up Page'), ['class' => 'form-label']) }}
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" class="" name="signup_button"
                                                            id="signup_button"
                                                            {{ Utility::getValByName('signup_button') == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label" for="signup_button"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <h4 class="small-title">{{ __('Theme Customizer') }}</h4>
                                        <div class="setting-card setting-logo-box p-3">
                                            <div class="row">
                                                <div class="pct-body">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-xl-4 col-md-4">
                                                            <h6>
                                                                <i data-feather="credit-card"
                                                                    class="me-2"></i>{{ __('Primary color settings') }}
                                                            </h6>
                                                            <hr class="my-2" />
                                                            <div class="theme-color themes-color">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-1' ? 'active_color' : '' }}"
                                                                    data-value="theme-1"
                                                                    onclick="check_theme('theme-1')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-1" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-2' ? 'active_color' : '' }} "
                                                                    data-value="theme-2"
                                                                    onclick="check_theme('theme-2')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-2" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-3' ? 'active_color' : '' }}"
                                                                    data-value="theme-3"
                                                                    onclick="check_theme('theme-3')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-3" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-4' ? 'active_color' : '' }}"
                                                                    data-value="theme-4"
                                                                    onclick="check_theme('theme-4')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-4" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-5' ? 'active_color' : '' }}"
                                                                    data-value="theme-5"
                                                                    onclick="check_theme('theme-5')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-5" style="display: none;">
                                                                <br>
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-6' ? 'active_color' : '' }}"
                                                                    data-value="theme-6"
                                                                    onclick="check_theme('theme-6')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-6" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-7' ? 'active_color' : '' }}"
                                                                    data-value="theme-7"
                                                                    onclick="check_theme('theme-7')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-7" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-8' ? 'active_color' : '' }}"
                                                                    data-value="theme-8"
                                                                    onclick="check_theme('theme-8')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-8" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-9' ? 'active_color' : '' }}"
                                                                    data-value="theme-9"
                                                                    onclick="check_theme('theme-9')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-9" style="display: none;">
                                                                <a href="#!"
                                                                    class="{{ $settings['color'] == 'theme-10' ? 'active_color' : '' }}"
                                                                    data-value="theme-10"
                                                                    onclick="check_theme('theme-10')"></a>
                                                                <input type="radio" class="theme_color" name="color"
                                                                    value="theme-10" style="display: none;">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <h6>
                                                                <i data-feather="layout"
                                                                    class="me-2"></i>{{ __('Sidebar Settings') }}
                                                            </h6>
                                                            <hr class="my-2" />
                                                            <div class="form-check form-switch">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="cust-theme-bg" name="cust_theme_bg"
                                                                    {{ Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : '' }} />
                                                                <label class="form-check-label f-w-600 pl-1"
                                                                    for="cust-theme-bg">{{ __('Transparent layout') }}</label>

                                                                {{-- <input type="checkbox" class="form-check-input" id="cust-theme-bg" name="cust_theme_bg"  @if ($settings['cust_theme_bg'] == 'on') checked @endif/>

                                                                        <label class="form-check-label f-w-600 pl-1" for="cust-theme-bg">Transparent layout</label> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <h6>
                                                                <i data-feather="sun"
                                                                    class=""></i>{{ __('Layout settings') }}
                                                            </h6>
                                                            <hr class=" my-2" />
                                                            <div class="form-check form-switch">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="cust-darklayout" name="cust_darklayout"
                                                                    {{ Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : '' }} />
                                                                <label class="form-check-label f-w-600 pl-1"
                                                                    for="cust-darklayout">{{ __('Dark Layout') }}</label>

                                                                {{-- <input type="checkbox" class="form-check-input" id="cust-darklayout" name="cust_darklayout"@if ($settings['cust_darklayout'] == 'on') checked @endif/>

                                                                            <label class="form-check-label f-w-600 pl-1" for="cust-darklayout" >Dark Layout</label> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                            </div>
                            {{ Form::close() }}
                        </div> -->

                        <!-- <div id="twilio-settings" class="card">
                        <div class="card-header">
                            <h5>{{ __('Twilio Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit your twilio details') }}</small>
                        </div>
                        <div class="card-body">
                            <h4 class="small-title">{{ __('Twilio') }}</h4>
                            {{ Form::model($settings, ['route' => 'twilio.setting', 'method' => 'post']) }}
                            @csrf
                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    {{ Form::label('SID', __('SID'), ['class' => 'form-label']) }}
                                    {{ Form::text('twilio_sid', isset($settings['twilio_sid']) ? $settings['twilio_sid'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Twilio Sid'), 'required' => 'required']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('Token', __('Token'), ['class' => 'form-label']) }}
                                    {{ Form::text('twilio_token', isset($settings['twilio_token']) ? $settings['twilio_token'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Twilio Token'), 'required' => 'required']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('From', __('From'), ['class' => 'form-label']) }}

                                    {{ Form::text('twilio_from', isset($settings['twilio_from']) ? $settings['twilio_from'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Twilio From'), 'required' => 'required']) }}
                                </div>
                                <div class="col-md-12 mt-4 mb-2">
                                    <h4 class="small-title">{{ __('Module Settings') }}</h4>
                                </div>
                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>{{ __('New User') }}</span>
                                            <div class="form-check form-switch float-end">
                                                {{ Form::checkbox('twilio_user_create', '1', isset($settings['twilio_user_create']) && $settings['twilio_user_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_user_create']) }}
                                                <label class="form-check-label" for="twilio_user_create"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>{{ __('New Lead') }}</span>
                                            <div class="form-check form-switch float-end">
                                                {{ Form::checkbox('twilio_lead_create', '1', isset($settings['twilio_lead_create']) && $settings['twilio_lead_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_lead_create']) }}
                                                <label class="form-check-label" for="twilio_lead_create"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>{{ __('New Meeting') }}</span>
                                            <div class="form-check form-switch float-end">
                                                {{ Form::checkbox('twilio_meeting_create', '1', isset($settings['twilio_meeting_create']) && $settings['twilio_meeting_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_meeting_create']) }}
                                                <label class="form-check-label" for="twilio_meeting_create"></label>
                                            </div>
                                        </li> -->
                        <!-- <li class="list-group-item">
                                                                                            <span>{{ __('New Quotes') }}</span>
                                                                                            <div class="form-check form-switch float-end">
                                                                                                {{ Form::checkbox('twilio_quotes_create', '1', isset($settings['twilio_quotes_create']) && $settings['twilio_quotes_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_quotes_create']) }}
                                                                                                <label class="form-check-label" for="twilio_quotes_create"></label>
                                                                                            </div>
                                                                                        </li> -->
                        <!-- </ul>
                                            </div> -->
                        <!-- <div class="col-md-4">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        <span>{{ __('New Sales Order') }}</span>
                                                                        <div class="form-check form-switch float-end">
                                                                            {{ Form::checkbox('twilio_salesorder_create', '1', isset($settings['twilio_salesorder_create']) && $settings['twilio_salesorder_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_salesorder_create']) }}
                                                                            <label class="form-check-label" for="twilio_salesorder_create"></label>
                                                                        </div>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <span>{{ __('New Invoice') }}</span>
                                                                        <div class="form-check form-switch float-end">
                                                                            {{ Form::checkbox('twilio_invoice_create', '1', isset($settings['twilio_invoice_create']) && $settings['twilio_invoice_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_invoice_create']) }}
                                                                            <label class="form-check-label" for="twilio_invoice_create"></label>
                                                                        </div>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <span>{{ __('New Invoice Payment') }}</span>
                                                                        <div class="form-check form-switch float-end">
                                                                            {{ Form::checkbox('twilio_invoicepay_create', '1', isset($settings['twilio_invoicepay_create']) && $settings['twilio_invoicepay_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_invoicepay_create']) }}
                                                                            <label class="form-check-label" for="twilio_invoicepay_create"></label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        <span>{{ __('New Meeting') }}</span>
                                                                        <div class="form-check form-switch float-end">
                                                                            {{ Form::checkbox('twilio_meeting_create', '1', isset($settings['twilio_meeting_create']) && $settings['twilio_meeting_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_meeting_create']) }}
                                                                            <label class="form-check-label" for="twilio_meeting_create"></label>
                                                                        </div>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <span>{{ __('New Task') }}</span>
                                                                        <div class="form-check form-switch float-end">
                                                                            {{ Form::checkbox('twilio_task_create', '1', isset($settings['twilio_task_create']) && $settings['twilio_task_create'] == '1' ? 'checked' : '', ['class' => 'form-check-input input-primary', 'id' => 'twilio_task_create']) }}
                                                                            <label class="form-check-label" for="twilio_task_create"></label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div> -->
                        <!-- <div class="text-end">
                                                {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div> -->




                        @if (\Auth::user()->type == 'super admin')
                        <!-- <div id="brand-settings" class="card">
                                        <div class="card-header">
                                            <h5>{{ __('Brand Settings') }}</h5>
                                            <small class="text-muted">{{ __('Edit your brand details') }}</small>
                                        </div>
                                        {{ Form::model($settings, ['route' => 'business.setting', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="small-title">{{ __('Dark Logo') }}</h5>
                                                        </div>
                                                        <div class="card-body setting-card setting-logo-box p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="logo-content logo-set-bg py-2" style="height:65px">
                                                                        {{-- <a href="{{ asset(Storage::url('uploads/logo/logo-dark.png')) }}" target="_blank">
                                                                                <img id="blah4" alt="your image" src="{{ asset(Storage::url('uploads/logo/logo-dark.png')) }}" width="170px" class="">
                                                                            </a> --}}
                                                                        <a href="{{ $logo . 'logo-dark.png' . '?' . time() }}"
                                                                            target="_blank" style="height: 50px; width:150px;">
                                                                            <img id="blah4" alt="your image"
                                                                                src="{{ $logo . 'logo-dark.png' . '?' . time() }}"
                                                                                style="height: 50px; width:150px;" class="big-logo">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">

                                                                    <div class="choose-files mt-5">
                                                                        <label for="logo_dark">
                                                                            <div class=" bg-primary"> <i
                                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                            </div>
                                                                            <input type="file"name="logo_dark" id="logo_dark"
                                                                                class="form-control file"
                                                                                data-filename="company_logo_update"
                                                                                onchange="document.getElementById('blah4').src = window.URL.createObjectURL(this.files[0])">

                                                                            {{-- <input type="file" name="logo_dark" id="logo_dark" class="form-control file" data-filename="company_logo_update"> --}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="small-title">{{ __('Light Logo') }}</h5>
                                                        </div>
                                                        <div class="card-body setting-card setting-logo-box p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="logo-content logo-set-bg py-2" style="height:65px">
                                                                        {{-- <a href="{{ asset(Storage::url('uploads/logo/logo-light.png')) }}" target="_blank">
                                                                                <img id="blah5" alt="your image" src="{{ asset(Storage::url('uploads/logo/logo-light.png')) }}" width="170px" class="img_setting">
                                                                            </a> --}}
                                                                        <a href="{{ $logo . 'logo-light.png' . '?' . time() }}"
                                                                            target="_blank" style="height: 50px; width:150px;">
                                                                            <img id="blah5" alt="your image"
                                                                                src="{{ $logo . 'logo-light.png' . '?' . time() }}"
                                                                                style="height: 50px; width:150px;" class="img_setting">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">

                                                                    <div class="choose-files mt-5">
                                                                        <label for="logo_light">
                                                                            <div class=" bg-primary"> <i
                                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                            </div>
                                                                            <input type="file"name="logo_light" id="logo_light"
                                                                                class="form-control file"
                                                                                data-filename="company_logo_update"
                                                                                onchange="document.getElementById('blah5').src = window.URL.createObjectURL(this.files[0])">

                                                                            {{-- <input type="file" name="logo_light" id="logo_light" class="form-control file" data-filename="company_logo_update"> --}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="small-title">{{ __('Favicon') }}</h5>
                                                        </div>
                                                        <div class="card-body setting-card setting-logo-box p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="logo-content logo-set-bg py-2" style="height:65px">
                                                                        {{-- <a href="{{ asset(Storage::url('uploads/logo/favicon.png')) }}" target="_blank">
                                                                                <img id="blah6" alt="your image" src="{{ $logo . '/' . (isset($favicon) && !empty($favicon) ? $favicon : 'favicon.png') }}"  width="50px" class="img_setting">
                                                                            </a> --}}
                                                                        <a href="{{ $logo . 'favicon.png' . '?' . time() }}"
                                                                            target="_blank">
                                                                            <img id="blah6" alt="your image"
                                                                                src="{{ $logo . 'favicon.png' . '?' . time() }}"
                                                                                width="50px" class="img_setting">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="choose-files mt-5">
                                                                        <label for="favicon">
                                                                            <div class=" bg-primary"> <i
                                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                            </div>
                                                                            <input type="file"name="favicon" id="favicon"
                                                                                class="form-control file"
                                                                                data-filename="company_logo_update"
                                                                                onchange="document.getElementById('blah6').src = window.URL.createObjectURL(this.files[0])">
                                                                            {{-- <input type="file" name="favicon" id="favicon" class="form-control file" data-filename="company_logo_update"> --}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        {{ Form::label('title_text', __('Title Text'), ['class' => 'form-label']) }}
                                                        {{ Form::text('title_text', null, ['class' => 'form-control', 'placeholder' => __('Title Text')]) }}
                                                        @error('title_text')
                                                            <span class="invalid-title_text" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    @if (\Auth::user()->type == 'super admin')
                                                        <div class="form-group col-md-4">
                                                            {{ Form::label('footer_text', __('Footer Text'), ['class' => 'form-label']) }}
                                                            {{ Form::text('footer_text', null, ['class' => 'form-control', 'placeholder' => __('Footer Text')]) }}
                                                            @error('footer_text')
                                                                <span class="invalid-footer_text" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            {{ Form::label('default_language', __('Default Language'), ['class' => 'form-label']) }}
                                                            <div class="changeLanguage">
                                                                <select name="default_language" id="default_language"
                                                                    class="form-control custom-select">
                                                                    @foreach (\App\Models\Utility::languages() as $code => $language)
                                                                        <option @if ($lang == $code) selected @endif
                                                                            value="{{ $code }}">{{ ucfirst($language) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="col switch-width">
                                                                <div class="form-group ml-2 mr-3">
                                                                    <label
                                                                        class="form-label mb-1">{{ __('Enable Landing Page') }}</label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" data-toggle="switchbutton"
                                                                            data-onstyle="primary" class=""
                                                                            name="display_landing_page" id="display_landing_page"
                                                                            {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>
                                                                        <label class="custom-control-label mb-1"
                                                                            for="display_landing_page"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-4">
                                                            <div class="col switch-width">
                                                                <div class="form-group ml-2 mr-3 ">

                                                                    {{ Form::label('verified_button', __('Email Verification'), ['class' => 'form-label']) }}
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" data-toggle="switchbutton"
                                                                            data-onstyle="primary" class=""
                                                                            name="verified_button" id="verified_button"
                                                                            {{ Utility::getValByName('verified_button') == 'on' ? 'checked="checked"' : '' }}>
                                                                        <label class="custom-control-label"
                                                                            for="verified_button"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-4">
                                                            <div class="col switch-width">
                                                                <div class="form-group ml-2 mr-3 ">
                                                                    {{ Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'form-label']) }}
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" data-toggle="switchbutton"
                                                                            data-onstyle="primary" class="" name="SITE_RTL"
                                                                            id="SITE_RTL"{{ $settings['SITE_RTL'] == 'on' ? 'checked="checked"' : '' }}>
                                                                        <label class="custom-control-label" for="SITE_RTL"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-4">
                                                            <div class="col switch-width">
                                                                <div class="form-group ml-2 mr-3 ">
                                                                    {{ Form::label('signup_button', __('Enable Sign-Up Page'), ['class' => 'form-label']) }}
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" data-toggle="switchbutton"
                                                                            data-onstyle="primary" class=""
                                                                            name="signup_button" id="signup_button"
                                                                            {{ Utility::getValByName('signup_button') == 'on' ? 'checked="checked"' : '' }}>
                                                                        <label class="custom-control-label"
                                                                            for="signup_button"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <h4 class="small-title">{{ __('Theme Customizer') }}</h4>
                                                    <div class="setting-card setting-logo-box p-3">
                                                        <div class="row">
                                                            <div class="pct-body">
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                                        <h6>
                                                                            <i data-feather="credit-card"
                                                                                class="me-2"></i>{{ __('Primary color settings') }}
                                                                        </h6>
                                                                        <hr class="my-2" />
                                                                        <div class="theme-color themes-color">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-1' ? 'active_color' : '' }}"
                                                                                data-value="theme-1"
                                                                                onclick="check_theme('theme-1')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-1" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-2' ? 'active_color' : '' }} "
                                                                                data-value="theme-2"
                                                                                onclick="check_theme('theme-2')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-2" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-3' ? 'active_color' : '' }}"
                                                                                data-value="theme-3"
                                                                                onclick="check_theme('theme-3')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-3" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-4' ? 'active_color' : '' }}"
                                                                                data-value="theme-4"
                                                                                onclick="check_theme('theme-4')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-4" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-5' ? 'active_color' : '' }}"
                                                                                data-value="theme-5"
                                                                                onclick="check_theme('theme-5')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-5" style="display: none;">
                                                                            <br>
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-6' ? 'active_color' : '' }}"
                                                                                data-value="theme-6"
                                                                                onclick="check_theme('theme-6')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-6" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-7' ? 'active_color' : '' }}"
                                                                                data-value="theme-7"
                                                                                onclick="check_theme('theme-7')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-7" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-8' ? 'active_color' : '' }}"
                                                                                data-value="theme-8"
                                                                                onclick="check_theme('theme-8')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-8" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-9' ? 'active_color' : '' }}"
                                                                                data-value="theme-9"
                                                                                onclick="check_theme('theme-9')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-9" style="display: none;">
                                                                            <a href="#!"
                                                                                class="{{ $settings['color'] == 'theme-10' ? 'active_color' : '' }}"
                                                                                data-value="theme-10"
                                                                                onclick="check_theme('theme-10')"></a>
                                                                            <input type="radio" class="theme_color" name="color"
                                                                                value="theme-10" style="display: none;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <h6>
                                                                            <i data-feather="layout"
                                                                                class="me-2"></i>{{ __('Sidebar Settings') }}
                                                                        </h6>
                                                                        <hr class="my-2" />
                                                                        <div class="form-check form-switch">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                id="cust-theme-bg" name="cust_theme_bg"
                                                                                {{ Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : '' }} />
                                                                            <label class="form-check-label f-w-600 pl-1"
                                                                                for="cust-theme-bg">{{ __('Transparent layout') }}</label>

                                                                            {{-- <input type="checkbox" class="form-check-input" id="cust-theme-bg" name="cust_theme_bg"  @if ($settings['cust_theme_bg'] == 'on') checked @endif/>

                                                                        <label class="form-check-label f-w-600 pl-1" for="cust-theme-bg">Transparent layout</label> --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <h6>
                                                                            <i data-feather="sun"
                                                                                class=""></i>{{ __('Layout settings') }}
                                                                        </h6>
                                                                        <hr class=" my-2" />
                                                                        <div class="form-check form-switch">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                id="cust-darklayout" name="cust_darklayout"
                                                                                {{ Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : '' }} />
                                                                            <label class="form-check-label f-w-600 pl-1"
                                                                                for="cust-darklayout">{{ __('Dark Layout') }}</label>

                                                                            {{-- <input type="checkbox" class="form-check-input" id="cust-darklayout" name="cust_darklayout"@if ($settings['cust_darklayout'] == 'on') checked @endif/>

                                                                            <label class="form-check-label f-w-600 pl-1" for="cust-darklayout" >Dark Layout</label> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                                        </div>
                                        {{ Form::close() }}
                                        </div>  -->

                        <!-- <div id="email-settings" class="card">
                                                    <div class="card-header">
                                                        <h5>{{ __('Email Settings') }}</h5>
                                                        <small class="text-muted">{{ __('Edit your email details') }}</small>
                                                    </div>
                                                    {{ Form::open(['route' => 'email.setting', 'method' => 'post']) }}
                                                    <div class="card-body">
                                                        <div class="row mt-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_driver"
                                                                        class="col-form-label text-dark">{{ __('Mail Driver') }}</label>
                                                                    <input type="text" name="mail_driver" id="mail_driver"
                                                                        class="form-control {{ $errors->has('mail_driver') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_driver']) || is_null($settings['mail_driver']) ? '' : $settings['mail_driver'] }}"
                                                                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_driver_placeholder') }}" />
                                                                    @if ($errors->has('mail_driver'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_driver') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_host"
                                                                        class="col-form-label text-dark">{{ __('Mail Host') }}</label>
                                                                    <input type="text" name="mail_host" id="mail_host"
                                                                        class="form-control {{ $errors->has('mail_host') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_host']) || is_null($settings['mail_host']) ? '' : $settings['mail_host'] }}"
                                                                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_host_placeholder') }}" />
                                                                    @if ($errors->has('mail_host'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_host') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_port"
                                                                        class="col-form-label text-dark">{{ __('Mail Port') }}</label>
                                                                    <input type="number" name="mail_port" id="mail_port"
                                                                        class="form-control {{ $errors->has('mail_port') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_port']) || is_null($settings['mail_port']) ? '' : $settings['mail_port'] }}"
                                                                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_port_placeholder') }}" />
                                                                    @if ($errors->has('mail_port'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_port') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_username"
                                                                        class="col-form-label text-dark">{{ __('Mail Username') }}</label>
                                                                    <input type="text" name="mail_username" id="mail_username"
                                                                        class="form-control {{ $errors->has('mail_username') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_username']) || is_null($settings['mail_username']) ? '' : $settings['mail_username'] }}"
                                                                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_username_placeholder') }}" />
                                                                    @if ($errors->has('mail_username'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_username') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_password"
                                                                        class="col-form-label text-dark">{{ __('Mail Password') }}</label>
                                                                    <input type="text" name="mail_password" id="mail_password"
                                                                        class="form-control {{ $errors->has('mail_password') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_password']) || is_null($settings['mail_password']) ? '' : $settings['mail_password'] }}"
                                                                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_password_placeholder') }}" />
                                                                    @if ($errors->has('mail_password'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_password') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_encryption"
                                                                        class="col-form-label text-dark">{{ __('Mail Encryption') }}</label>
                                                                    <input type="text" name="mail_encryption" id="mail_encryption"
                                                                        class="form-control {{ $errors->has('mail_encryption') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_encryption']) || is_null($settings['mail_encryption']) ? '' : $settings['mail_encryption'] }}"
                                                                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_encryption_placeholder') }}" />
                                                                    @if ($errors->has('mail_encryption'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_encryption') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_from_address"
                                                                        class="col-form-label text-dark">{{ __('Mail From Address') }}</label>
                                                                    <input type="text" name="mail_from_address" id="mail_from_address"
                                                                        class="form-control {{ $errors->has('mail_from_address') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_from_address']) || is_null($settings['mail_from_address']) ? '' : $settings['mail_from_address'] }}"
                                                                        placeholder="{{ __('Enter Mail From Address') }}" />
                                                                    @if ($errors->has('mail_from_address'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_from_address') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mail_from_name"
                                                                        class="col-form-label text-dark">{{ __('Mail From Name') }}</label>
                                                                    <input type="text" name="mail_from_name" id="mail_from_name"
                                                                        class="form-control {{ $errors->has('mail_from_name') ? 'is-invalid' : '' }}"
                                                                        value="{{ !isset($settings['mail_from_name']) || is_null($settings['mail_from_name']) ? '' : $settings['mail_from_name'] }}"
                                                                        placeholder="{{ __('Enter Mail From Name') }}" />
                                                                    @if ($errors->has('mail_from_name'))
                                                                        <span class="invalid-feedback text-danger text-xs">
                                                                            {{ $errors->first('mail_from_name') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="footer-row justify-content-end felx-wrap d-flex">
                                                                <a href="#"
                                                                    class="btn btn-print-invoice  btn-primary m-r-10 send_email mb-2"
                                                                    data-ajax-popup="true" data-title="{{ __('Send Test Mail') }}"
                                                                    data-url="{{ route('test.mail') }}">
                                                                    {{ __('Send Test Mail') }}
                                                                </a>
                                                                <input type="submit" value="{{ __('Save Changes') }}"
                                                                    class="btn btn-print-invoice  btn-primary m-r-10 mb-2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{ Form::close() }}
                                                </div> -->

                        <!-- <div id="pusher-settings" class="card">
                        <div class="card-header">
                            <h5>{{ __('Pusher Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit your pusher details') }}</small>
                        </div>
                        <div class="card-body">
                            {{ Form::model($settings, ['route' => 'pusher.setting', 'method' => 'post']) }}
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_id', __('Pusher App Id *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_id', isset($settings['pusher_app_id']) ? $settings['pusher_app_id'] : '', ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Id', 'required' => 'required']) }}
                                    @error('pusher_app_id')
                                        <span class="invalid-pusher_app_id" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_key', __('Pusher App Key *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_key', isset($settings['pusher_app_key']) ? $settings['pusher_app_key'] : '', ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Key', 'required' => 'required']) }}
                                    @error('pusher_app_key')
                                        <span class="invalid-pusher_app_key" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_secret', __('Pusher App Secret *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_secret', isset($settings['pusher_app_secret']) ? $settings['pusher_app_secret'] : '', ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Key', 'required' => 'required']) }}
                                    @error('pusher_app_secret')
                                        <span class="invalid-pusher_app_secret" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('pusher_app_cluster', __('Pusher App Cluster *'), ['class' => 'form-label']) }}
                                    {{ Form::text('pusher_app_cluster', isset($settings['pusher_app_cluster']) ? $settings['pusher_app_cluster'] : '' , ['class' => 'form-control font-style', 'placeholder' => 'Pusher App Cluster', 'required' => 'required']) }}
                                    @error('pusher_app_cluster')
                                        <span class="invalid-pusher_app_cluster" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div> -->
                        <div id="payment-settings" class="card">
                            <div class="card-header">
                                <h5>{{ __('Payment Settings') }}</h5>
                                <small
                                    class="text-muted">{{ __('These details will be used to collect subscription plan payments.Each subscription plan will have a payment button based on the below configuration') }}</small>
                            </div>
                            {{ Form::model($settings, ['route' => 'payment.setting', 'method' => 'POST']) }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                                <label class="col-form-label">{{ __('Currency') }} *</label>
                                                <input type="text" name="currency" class="form-control" id="currency"
                                                    value="{{ !isset($payment['currency']) || is_null($payment['currency']) ? '' : $payment['currency'] }}"
                                                    placeholder="USD" required>
                                                <small class="text-xs">
                                                    {{ __('Note: Add currency code as per three-letter ISO code.') }}.
                                                    <a href="https://stripe.com/docs/currencies"
                                                        target="_blank">{{ __('You can find out how to do that here.') }}</a>
                                                </small>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                                <label for="currency_symbol"
                                                    class="col-form-label">{{ __('Currency Symbol') }}</label>
                                                <input type="text" name="currency_symbol" class="form-control"
                                                    id="currency_symbol"
                                                    value="{{ !isset($payment['currency_symbol']) || is_null($payment['currency_symbol']) ? '' : $payment['currency_symbol'] }}"
                                                    placeholder="$" required>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="faq justify-content-center">
                                    <div class="col-sm-12 col-md-10 col-xxl-12">
                                        <div class="accordion accordion-flush setting setting-accordion1"
                                            id="accordionExample">

                                            {{-- maually --}}
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-15">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse15"
                                                        aria-expanded="false" aria-controls="collapse15">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Manually') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_manually_enabled" value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_manually_enabled" id="is_manually_enabled"
                                                                {{ isset($payment['is_manually_enabled']) && $payment['is_manually_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-1"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse15" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-15" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                <div class="row pt-2">
                                                                    <label class="pb-2"
                                                                        for="is_manually_enabled">{{ __('Requesting manual payment for the planned amount for the subscriptions paln.') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- bank-transfer --}}
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-16">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse16"
                                                        aria-expanded="false" aria-controls="collapse16">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Bank Transfer') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_bank_enabled" value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_bank_enabled" id="is_bank_enabled"
                                                                {{ isset($payment['is_bank_enabled']) && $payment['is_bank_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-1"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse16" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-16" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row gy-4">
                                                            <div class="col-md-12 mt-3">
                                                                <div class="form-group">
                                                                    {{ Form::label('bank_details', __('Bank Details'), ['class' => 'col-form-label']) }}
                                                                    {{ Form::textarea('bank_details', isset($payment['bank_details']) ? $payment['bank_details'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Your Bank Details'), 'rows' => 4]) }}
                                                                    <small class="text-xs">
                                                                        {{ __('Example : Bank : bank name </br> Account Number : 0000 0000 </br>') }}
                                                                    </small>
                                                                    @if ($errors->has('bank_details'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('bank_details') }}
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stripe -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-2">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse1"
                                                        aria-expanded="false" aria-controls="collapse1">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Stripe') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_stripe_enabled" value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_stripe_enabled" id="is_stripe_enabled"
                                                                {{ isset($payment['is_stripe_enabled']) && $payment['is_stripe_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-1"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse1" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-2" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row gy-4">
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="stripe_key"
                                                                        class="form-label">{{ __('Stripe Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('Stripe Key') }}"
                                                                        name="stripe_key" type="text"
                                                                        value="{{ !isset($payment['stripe_key']) || is_null($payment['stripe_key']) ? '' : $payment['stripe_key'] }}"
                                                                        id="stripe_key">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="stripe_secret"
                                                                        class="form-label">{{ __('Stripe Secret') }}</label>
                                                                    <input class="form-control "
                                                                        placeholder="{{ __('Stripe Secret') }}"
                                                                        name="stripe_secret" type="text"
                                                                        value="{{ !isset($payment['stripe_secret']) || is_null($payment['stripe_secret']) ? '' : $payment['stripe_secret'] }}"
                                                                        id="stripe_secret">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paypal -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-3">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse2"
                                                        aria-expanded="false" aria-controls="collapse2">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Paypal') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paypal_enabled" value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                id="customswitchv1-2" name="is_paypal_enabled"
                                                                id="is_paypal_enabled"
                                                                {{ isset($payment['is_paypal_enabled']) && $payment['is_paypal_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-2"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse2" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-3" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                <div class="row pt-2">
                                                                    <label class="pb-2"
                                                                        for="paypal_mode">{{ __('Paypal Mode') }}</label>
                                                                    <div class="col-lg-3">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    class="form-check-input input-primary "
                                                                                    name="paypal_mode" value="sandbox"
                                                                                    {{ !isset($payment['paypal_mode']) || $payment['paypal_mode'] == '' || $payment['paypal_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                                <label class="form-check-label d-block"
                                                                                    for="">
                                                                                    <span>
                                                                                        <span class="h5 d-block"><strong
                                                                                                class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    class="form-check-input input-primary "
                                                                                    name="paypal_mode" value="live"
                                                                                    {{ isset($payment['paypal_mode']) && $payment['paypal_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                                <label class="form-check-label d-block"
                                                                                    for="">
                                                                                    <span>
                                                                                        <span class="h5 d-block"><strong
                                                                                                class="float-end"></strong>{{ __('Live') }}</span>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id"
                                                                        class="form-label">{{ __('Client ID') }}</label>
                                                                    <input type="text" name="paypal_client_id"
                                                                        id="paypal_client_id" class="form-control"
                                                                        value="{{ !isset($payment['paypal_client_id']) || is_null($payment['paypal_client_id']) ? '' : $payment['paypal_client_id'] }}"
                                                                        placeholder="{{ __('Client ID') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paypal_secret_key"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="paypal_secret_key"
                                                                        id="paypal_secret_key" class="form-control"
                                                                        value="{{ !isset($payment['paypal_secret_key']) || is_null($payment['paypal_secret_key']) ? '' : $payment['paypal_secret_key'] }}"
                                                                        placeholder="{{ __('Secret Key') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paystack -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-4">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse3"
                                                        aria-expanded="true" aria-controls="collapse3">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Paystack') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paystack_enabled" value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                id="customswitchv1-2" name="is_paystack_enabled"
                                                                id="is_paystack_enabled"
                                                                {{ isset($payment['is_paystack_enabled']) && $payment['is_paystack_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-2"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse3" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-4" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id"
                                                                        class="form-label">{{ __(' Key') }}</label>
                                                                    <input type="text" name="paystack_public_key"
                                                                        id="paystack_public_key" class="form-control"
                                                                        value="{{ !isset($payment['paystack_public_key']) || is_null($payment['paystack_public_key']) ? '' : $payment['paystack_public_key'] }}"
                                                                        placeholder="{{ __(' Key') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="paystack_secret_key"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="paystack_secret_key"
                                                                        id="paystack_secret_key" class="form-control"
                                                                        value="{{ !isset($payment['paystack_secret_key']) || is_null($payment['paystack_secret_key']) ? '' : $payment['paystack_secret_key'] }}"
                                                                        placeholder="{{ __('Secret Key') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- FLUTTERWAVE -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-5">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse4"
                                                        aria-expanded="true" aria-controls="collapse4">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Flutterwave') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_flutterwave_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                id="customswitchv1-2" name="is_flutterwave_enabled"
                                                                id="is_flutterwave_enabled"
                                                                {{ isset($payment['is_flutterwave_enabled']) && $payment['is_flutterwave_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-2"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse4" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-5" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id"
                                                                        class="form-label">{{ __(' Key') }}</label>
                                                                    <input type="text" name="flutterwave_public_key"
                                                                        id="flutterwave_public_key" class="form-control"
                                                                        value="{{ !isset($payment['flutterwave_public_key']) || is_null($payment['flutterwave_public_key']) ? '' : $payment['flutterwave_public_key'] }}"
                                                                        placeholder="Public Key">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="paystack_secret_key"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="flutterwave_secret_key"
                                                                        id="flutterwave_secret_key" class="form-control"
                                                                        value="{{ !isset($payment['flutterwave_secret_key']) || is_null($payment['flutterwave_secret_key']) ? '' : $payment['flutterwave_secret_key'] }}"
                                                                        placeholder="Secret Key">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Razorpay -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-6">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse5"
                                                        aria-expanded="true" aria-controls="collapse5">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Razorpay') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_razorpay_enabled" value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                id="customswitchv1-2" name="is_razorpay_enabled"
                                                                id="is_razorpay_enabled"
                                                                {{ isset($payment['is_razorpay_enabled']) && $payment['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-2"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse5" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-6" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id"
                                                                        class="form-label">{{ __(' Key') }}</label>

                                                                    <input type="text" name="razorpay_public_key"
                                                                        id="razorpay_public_key" class="form-control"
                                                                        value="{{ !isset($payment['razorpay_public_key']) || is_null($payment['razorpay_public_key']) ? '' : $payment['razorpay_public_key'] }}"
                                                                        placeholder="Public Key">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group">
                                                                    <label for="paystack_secret_key"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="razorpay_secret_key"
                                                                        id="razorpay_secret_key" class="form-control"
                                                                        value="{{ !isset($payment['razorpay_secret_key']) || is_null($payment['razorpay_secret_key']) ? '' : $payment['razorpay_secret_key'] }}"
                                                                        placeholder="Secret Key">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paytm -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="heading-2-7">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse6"
                                                        aria-expanded="true" aria-controls="collapse6">
                                                        <span class="d-flex align-items-center">
                                                            {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                            {{ __('Paytm') }}
                                                        </span>
                                                        {{ __('Enable:') }}
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paytm_enabled" value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_paytm_enabled" id="is_paytm_enabled"
                                                                {{ isset($payment['is_paytm_enabled']) && $payment['is_paytm_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customswitchv1-2"></label>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse6" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-2-7" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body1">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                <div class="row pt-2">
                                                                    <label class="pb-2"
                                                                        for="paypal_mode">{{ __('Paytm Environment') }}</label>
                                                                    <div class="col-lg-3">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    class="form-check-input input-primary "
                                                                                    name="paytm_mode" value="local"
                                                                                    {{ !isset($payment['paytm_mode']) || $payment['paytm_mode'] == '' || $payment['paytm_mode'] == 'local' ? 'checked="checked"' : '' }}>


                                                                                <label class="form-check-label d-block"
                                                                                    for="">
                                                                                    <span>
                                                                                        <span class="h5 d-block"><strong
                                                                                                class="float-end"></strong>{{ __('Local') }}</span>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    class="form-check-input input-primary"
                                                                                    name="paytm_mode" value="production"
                                                                                    {{ isset($payment['paytm_mode']) && $payment['paytm_mode'] == 'production' ? 'checked="checked"' : '' }}>
                                                                                <label class="form-check-label d-block"
                                                                                    for="">
                                                                                    <span>
                                                                                        <span class="h5 d-block"><strong
                                                                                                class="float-end"></strong>{{ __('Production') }}</span>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-12 pb-4">
                                                                                                <label class="paypal-label form-control-label" for="paypal_mode">Paytm Environment</label> <br>
                                                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                                                    <label class="btn btn-primary btn-sm {{ !isset($payment['paytm_mode']) || $payment['paytm_mode'] == '' || $payment['paytm_mode'] == 'local' ? 'active' : '' }}">
                                                            <input type="radio" name="paytm_mode" value="local"
                                                                {{ !isset($payment['paytm_mode']) || $payment['paytm_mode'] == '' || $payment['paytm_mode'] == 'local' ? 'checked="checked"' : '' }}>Local
                                                            </label>
                                                            <label
                                                                class="btn btn-primary btn-sm {{ isset($payment['paytm_mode']) && $payment['paytm_mode'] == 'production' ? 'active' : '' }}">
                                                                <input type="radio" name="paytm_mode" value="production"
                                                                    {{ isset($payment['paytm_mode']) && $payment['paytm_mode'] == 'production' ? 'checked="checked"' : '' }}>Production
                                                            </label>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_public_key"
                                                                class="form-label">{{ __('Merchant ID') }}</label>
                                                            <input type="text" name="paytm_merchant_id"
                                                                id="paytm_merchant_id" class="form-control"
                                                                value="{{ !isset($payment['paytm_merchant_id']) || is_null($payment['paytm_merchant_id']) ? '' : $payment['paytm_merchant_id'] }}"
                                                                placeholder="Merchant ID">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_secret_key"
                                                                class="form-label">{{ __('Merchant Key') }}</label>
                                                            <input type="text" name="paytm_merchant_key"
                                                                id="paytm_merchant_key" class="form-control"
                                                                value="{{ !isset($payment['paytm_merchant_key']) || is_null($payment['paytm_merchant_key']) ? '' : $payment['paytm_merchant_key'] }}"
                                                                placeholder="Merchant Key">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_industry_type"
                                                                class="form-label">{{ __('Industry Type') }}</label>
                                                            <input type="text" name="paytm_industry_type"
                                                                id="paytm_industry_type" class="form-control"
                                                                value="{{ !isset($payment['paytm_industry_type']) || is_null($payment['paytm_industry_type']) ? '' : $payment['paytm_industry_type'] }}"
                                                                placeholder="Industry Type">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mercado Pago-->
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-8">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse7"
                                                aria-expanded="true" aria-controls="collapse7">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('MercadoPago') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_mercado_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_mercado_enabled" id="is_mercado_enabled"
                                                        {{ isset($payment['is_mercado_enabled']) && $payment['is_mercado_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>

                                            </button>
                                        </h2>
                                        <div id="collapse7" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-8" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                        <div class="row pt-2">
                                                            <label class="pb-2"
                                                                for="paypal_mode">{{ __('Mercado Mode') }}</label>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary "
                                                                            name="mercado_mode" value="sandbox"
                                                                            {{ (isset($payment['mercado_mode']) && $payment['mercado_mode'] == '') || (isset($payment['mercado_mode']) && $payment['mercado_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>


                                                                        <label class="form-check-label d-block" for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary "
                                                                            name="mercado_mode" value="live"
                                                                            {{ isset($payment['mercado_mode']) && $payment['mercado_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                        <label class="form-check-label d-block" for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Live') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mercado_access_token"
                                                                class="form-label">{{ __('Access Token') }}</label>
                                                            <input type="text" name="mercado_access_token"
                                                                id="mercado_access_token" class="form-control"
                                                                value="{{ isset($payment['mercado_access_token']) ? $payment['mercado_access_token'] : '' }}" />
                                                            @if ($errors->has('mercado_secret_key'))
                                                            <span class="invalid-feedback d-block">
                                                                {{ $errors->first('mercado_access_token') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mollie -->
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-9">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse8"
                                                aria-expanded="true" aria-controls="collapse8">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('Mollie') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_mollie_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_mollie_enabled" id="is_mollie_enabled"
                                                        {{ isset($payment['is_mollie_enabled']) && $payment['is_mollie_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>

                                            </button>
                                        </h2>
                                        <div id="collapse8" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-9" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">

                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mollie_api_key"
                                                                    class="form-label">{{ __('Mollie Api Key') }}</label>
                                                                <input type="text" name="mollie_api_key"
                                                                    id="mollie_api_key" class="form-control"
                                                                    value="{{ !isset($payment['mollie_api_key']) || is_null($payment['mollie_api_key']) ? '' : $payment['mollie_api_key'] }}"
                                                                    placeholder="Mollie Api Key">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mollie_profile_id"
                                                                    class="form-label">{{ __('Mollie Profile Id') }}</label>
                                                                <input type="text" name="mollie_profile_id"
                                                                    id="mollie_profile_id" class="form-control"
                                                                    value="{{ !isset($payment['mollie_profile_id']) || is_null($payment['mollie_profile_id']) ? '' : $payment['mollie_profile_id'] }}"
                                                                    placeholder="Mollie Profile Id">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mollie_partner_id"
                                                                    class="form-label">{{ __('Mollie Partner Id') }}</label>
                                                                <input type="text" name="mollie_partner_id"
                                                                    id="mollie_partner_id" class="form-control"
                                                                    value="{{ !isset($payment['mollie_partner_id']) || is_null($payment['mollie_partner_id']) ? '' : $payment['mollie_partner_id'] }}"
                                                                    placeholder="Mollie Partner Id">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Skrill -->
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-10">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse9"
                                                aria-expanded="true" aria-controls="collapse9">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('Skrill') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_skrill_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_skrill_enabled" id="is_skrill_enabled"
                                                        {{ isset($payment['is_skrill_enabled']) && $payment['is_skrill_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>

                                            </button>
                                        </h2>
                                        <div id="collapse9" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-10" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">

                                                    <div class="col-md-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="mollie_api_key"
                                                                class="form-label">{{ __('Skrill Email') }}</label>
                                                            <input type="text" name="skrill_email" id="skrill_email"
                                                                class="form-control"
                                                                value="{{ !isset($payment['skrill_email']) || is_null($payment['skrill_email']) ? '' : $payment['skrill_email'] }}"
                                                                placeholder="Enter Skrill Email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CoinGate -->
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-11">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse10"
                                                aria-expanded="true" aria-controls="collapse10">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('CoinGate') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_coingate_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_coingate_enabled" id="is_coingate_enabled"
                                                        {{ isset($payment['is_coingate_enabled']) && $payment['is_coingate_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>

                                            </button>
                                        </h2>
                                        <div id="collapse10" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-11" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                        <div class="row pt-2">
                                                            <label class="pb-2"
                                                                for="paypal_mode">{{ __('CoinGate Mode') }}</label>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary"
                                                                            name="coingate_mode" value="sandbox"
                                                                            {{ !isset($payment['coingate_mode']) || $payment['coingate_mode'] == '' || $payment['coingate_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>


                                                                        <label class="form-check-label d-block" for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary"
                                                                            name="coingate_mode" value="live"
                                                                            {{ isset($payment['coingate_mode']) && $payment['coingate_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                        <label class="form-check-label d-block" for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Live') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="coingate_auth_token"
                                                                class="form-label">{{ __('CoinGate Auth Token') }}</label>
                                                            <input type="text" name="coingate_auth_token"
                                                                id="coingate_auth_token" class="form-control"
                                                                value="{{ !isset($payment['coingate_auth_token']) || is_null($payment['coingate_auth_token']) ? '' : $payment['coingate_auth_token'] }}"
                                                                placeholder="CoinGate Auth Token">
                                                        </div>
                                                        @if ($errors->has('coingate_auth_token'))
                                                        <span class="invalid-feedback d-block">
                                                            {{ $errors->first('coingate_auth_token') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PaymentWall -->
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-12">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse11"
                                                aria-expanded="true" aria-controls="collapse11">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('PaymentWall') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_paymentwall_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_paymentwall_enabled" id="is_paymentwall_enabled"
                                                        {{ isset($payment['is_paymentwall_enabled']) && $payment['is_paymentwall_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>

                                            </button>
                                        </h2>
                                        <div id="collapse11" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-12" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paymentwall_public_key"
                                                                class="form-label">{{ __(' Key') }}</label>
                                                            <input type="text" name="paymentwall_public_key"
                                                                id="paymentwall_public_key" class="form-control"
                                                                value="{{ !isset($payment['paymentwall_public_key']) || is_null($payment['paymentwall_public_key']) ? '' : $payment['paymentwall_public_key'] }}"
                                                                placeholder="{{ __(' Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paymentwall_private_key"
                                                                class="form-label">{{ __('Private Key') }}</label>
                                                            <input type="text" name="paymentwall_private_key"
                                                                id="paymentwall_private_key" class="form-control"
                                                                value="{{ !isset($payment['paymentwall_private_key']) || is_null($payment['paymentwall_private_key']) ? '' : $payment['paymentwall_private_key'] }}"
                                                                placeholder="{{ __('Private Key') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Toyyibpay --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-13">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse12"
                                                aria-expanded="true" aria-controls="collapse12">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('Toyyibpay') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_toyyibpay_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_toyyibpay_enabled" id="is_toyyibpay_enabled"
                                                        {{ isset($payment['is_toyyibpay_enabled']) && $payment['is_toyyibpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label for="customswitch1-2" class="form-check-label"></label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse12" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-13" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="toyyibpay_secret_key"
                                                                class="form-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="toyyibpay_secret_key"
                                                                id="toyyibpay_secret_key" class="form-control"
                                                                value="{{ !isset($payment['toyyibpay_secret_key']) || is_null($payment['toyyibpay_secret_key']) ? '' : $payment['toyyibpay_secret_key'] }}"
                                                                placeholder="{{ __('Secret Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="category_code"
                                                                class="form-label">{{ __('Category Code') }}</label>
                                                            <input type="text" name="category_code" id="category_code"
                                                                class="form-control"
                                                                value="{{ !isset($payment['category_code']) || is_null($payment['category_code']) ? '' : $payment['category_code'] }}"
                                                                placeholder="{{ __('Category Code') }}">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- PayFast --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-14">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse14"
                                                aria-expanded="true" aria-controls="collapse14">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('Payfast') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_payfast_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_payfast_enabled" id="is_payfast_enabled"
                                                        {{ isset($payment['is_payfast_enabled']) && $payment['is_payfast_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapse14" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-14" data-bs-parent="#accordionExample">

                                            <div class="accordion-body1">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                    <div class="row pt-2">
                                                        <label class="pb-2"
                                                            for="payfast_mode">{{ __('Payfast Mode') }}</label>
                                                        <div class="col-lg-3">
                                                            <div class="border card p-3">
                                                                <div class="form-check">
                                                                    <input type="radio"
                                                                        class="form-check-input input-primary "
                                                                        name="payfast_mode" value="sandbox"
                                                                        {{ !isset($payment['payfast_mode']) || $payment['payfast_mode'] == '' || $payment['payfast_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label d-block" for="">
                                                                        <span>
                                                                            <span class="h5 d-block"><strong
                                                                                    class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="border card p-3">
                                                                <div class="form-check">
                                                                    <input type="radio"
                                                                        class="form-check-input input-primary "
                                                                        name="payfast_mode" value="live"
                                                                        {{ isset($payment['payfast_mode']) && $payment['payfast_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label d-block" for="">
                                                                        <span>
                                                                            <span class="h5 d-block"><strong
                                                                                    class="float-end"></strong>{{ __('Live') }}</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payfast_merchant_id"
                                                                class="form-label">{{ __('Merchant Id') }}</label>
                                                            <input type="text" name="payfast_merchant_id"
                                                                id="payfast_merchant_id" class="form-control"
                                                                value="{{ !isset($payment['payfast_merchant_id']) || is_null($payment['payfast_merchant_id']) ? '' : $payment['payfast_merchant_id'] }}"
                                                                placeholder="{{ __('Merchant Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payfast_merchant_key"
                                                                class="form-label">{{ __('Merchant Key') }}</label>
                                                            <input type="text" name="payfast_merchant_key"
                                                                id="payfast_merchant_key" class="form-control"
                                                                value="{{ !isset($payment['payfast_merchant_key']) || is_null($payment['payfast_merchant_key']) ? '' : $payment['payfast_merchant_key'] }}"
                                                                placeholder="{{ __('Merchant Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payfast_signature"
                                                                class="form-label">{{ __('Salt Passphrase') }}</label>
                                                            <input type="text" name="payfast_signature"
                                                                id="payfast_signature" class="form-control"
                                                                value="{{ !isset($payment['payfast_signature']) || is_null($payment['payfast_signature']) ? '' : $payment['payfast_signature'] }}"
                                                                placeholder="{{ __('Salt Passphrase') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- iyzipay --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-15">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse15"
                                                aria-expanded="true" aria-controls="collapse15">
                                                <span class="d-flex align-items-center">
                                                    {{-- <i class="ti ti-credit-card text-primary"></i> --}}
                                                    {{ __('IyziPay') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_iyzipay_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_iyzipay_enabled" id="is_iyzipay_enabled"
                                                        {{ isset($payment['is_iyzipay_enabled']) && $payment['is_iyzipay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapse15" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-14" data-bs-parent="#accordionExample">

                                            <div class="accordion-body1">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                    <div class="row pt-2">
                                                        <label class="pb-2"
                                                            for="iyzipay_mode">{{ __('IyziPay Mode') }}</label>
                                                        <div class="col-lg-3">
                                                            <div class="border card p-3">
                                                                <div class="form-check">
                                                                    <input type="radio"
                                                                        class="form-check-input input-primary "
                                                                        name="iyzipay_mode" value="sandbox"
                                                                        {{ !isset($payment['iyzipay_mode']) || $payment['iyzipay_mode'] == '' || $payment['iyzipay_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label d-block" for="">
                                                                        <span>
                                                                            <span class="h5 d-block"><strong
                                                                                    class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="border card p-3">
                                                                <div class="form-check">
                                                                    <input type="radio"
                                                                        class="form-check-input input-primary "
                                                                        name="iyzipay_mode" value="live"
                                                                        {{ isset($payment['iyzipay_mode']) && $payment['iyzipay_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label d-block" for="">
                                                                        <span>
                                                                            <span class="h5 d-block"><strong
                                                                                    class="float-end"></strong>{{ __('Live') }}</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="iyzipay_key"
                                                                class="form-label">{{ __('IyziPay Key') }}</label>
                                                            <input type="text" name="iyzipay_key" id="iyzipay_key"
                                                                class="form-control"
                                                                value="{{ !isset($payment['iyzipay_key']) || is_null($payment['iyzipay_key']) ? '' : $payment['iyzipay_key'] }}"
                                                                placeholder="{{ __('IyziPay Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="iyzipay_secret"
                                                                class="form-label">{{ __('IyziPay Secret') }}</label>
                                                            <input type="text" name="iyzipay_secret" id="iyzipay_secret"
                                                                class="form-control"
                                                                value="{{ !isset($payment['iyzipay_secret']) || is_null($payment['iyzipay_secret']) ? '' : $payment['iyzipay_secret'] }}"
                                                                placeholder="{{ __('IyziPay Secret') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SSPay --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-16">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse16"
                                                aria-expanded="true" aria-controls="collapse16">
                                                <span class="d-flex align-items-center">
                                                    {{ __('SSPay') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_sspay_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_sspay_enabled" id="is_sspay_enabled"
                                                        {{ isset($payment['is_sspay_enabled']) && $payment['is_sspay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label for="customswitch1-2" class="form-check-label"></label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse16" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-16" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="sspay_secret_key"
                                                                class="form-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="sspay_secret_key"
                                                                id="sspay_secret_key" class="form-control"
                                                                value="{{ !isset($payment['sspay_secret_key']) || is_null($payment['sspay_secret_key']) ? '' : $payment['sspay_secret_key'] }}"
                                                                placeholder="{{ __('Secret Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="sspay_category_code"
                                                                class="form-label">{{ __('Category Code') }}</label>
                                                            <input type="text" name="sspay_category_code"
                                                                id="sspay_category_code" class="form-control"
                                                                value="{{ !isset($payment['sspay_category_code']) || is_null($payment['sspay_category_code']) ? '' : $payment['sspay_category_code'] }}"
                                                                placeholder="{{ __('Category Code') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PayTab  --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-17">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse17"
                                                aria-expanded="true" aria-controls="collapse17">
                                                <span class="d-flex align-items-center">
                                                    {{ __('PayTab') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_paytab_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_paytab_enabled" id="is_paytab_enabled"
                                                        {{ isset($payment['is_paytab_enabled']) && $payment['is_paytab_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label for="customswitch1-2" class="form-check-label"></label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse17" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-17" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paytab_profile_id"
                                                                class="form-label">{{ __('Profile Id') }}</label>
                                                            <input type="text" name="paytab_profile_id"
                                                                id="paytab_profile_id" class="form-control"
                                                                value="{{ !isset($payment['paytab_profile_id']) || is_null($payment['paytab_profile_id']) ? '' : $payment['paytab_profile_id'] }}"
                                                                placeholder="{{ __('Profile Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paytab_server_key"
                                                                class="form-label">{{ __('Server Key') }}</label>
                                                            <input type="text" name="paytab_server_key"
                                                                id="paytab_server_key" class="form-control"
                                                                value="{{ !isset($payment['paytab_server_key']) || is_null($payment['paytab_server_key']) ? '' : $payment['paytab_server_key'] }}"
                                                                placeholder="{{ __('Server Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paytab_region"
                                                                class="form-label">{{ __('Paytab Region') }}</label>
                                                            <input type="text" name="paytab_region" id="paytab_region"
                                                                class="form-control"
                                                                value="{{ !isset($payment['paytab_region']) || is_null($payment['paytab_region']) ? '' : $payment['paytab_region'] }}"
                                                                placeholder="{{ __('Paytab Region') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Benefit  --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-18">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse18"
                                                aria-expanded="true" aria-controls="collapse18">
                                                <span class="d-flex align-items-center">
                                                    {{ __('Benefit') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_benefit_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_benefit_enabled" id="is_benefit_enabled"
                                                        {{ isset($payment['is_benefit_enabled']) && $payment['is_benefit_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label for="customswitch1-2" class="form-check-label"></label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse18" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-18" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="benefit_api_key"
                                                                class="form-label">{{ __('Benefit Key') }}</label>
                                                            <input type="text" name="benefit_api_key"
                                                                id="benefit_api_key" class="form-control"
                                                                value="{{ !isset($payment['benefit_api_key']) || is_null($payment['benefit_api_key']) ? '' : $payment['benefit_api_key'] }}"
                                                                placeholder="{{ __('Enter Benefit Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="benefit_secret_key"
                                                                class="form-label">{{ __('Benefit Secret Key') }}</label>
                                                            <input type="text" name="benefit_secret_key"
                                                                id="benefit_secret_key" class="form-control"
                                                                value="{{ !isset($payment['benefit_secret_key']) || is_null($payment['benefit_secret_key']) ? '' : $payment['benefit_secret_key'] }}"
                                                                placeholder="{{ __('Enter Benefit Secret key') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Cashfree  --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-19">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse19"
                                                aria-expanded="true" aria-controls="collapse19">
                                                <span class="d-flex align-items-center">
                                                    {{ __('Cashfree') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_cashfree_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_cashfree_enabled" id="is_cashfree_enabled"
                                                        {{ isset($payment['is_cashfree_enabled']) && $payment['is_cashfree_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label for="customswitch1-2" class="form-check-label"></label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse19" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-19" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cashfree_api_key"
                                                                class="form-label">{{ __(' Cashfree Key') }}</label>
                                                            <input type="text" name="cashfree_api_key"
                                                                id="cashfree_api_key" class="form-control"
                                                                value="{{ !isset($payment['cashfree_api_key']) || is_null($payment['cashfree_api_key']) ? '' : $payment['cashfree_api_key'] }}"
                                                                placeholder="{{ __('Enter Cashfree Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cashfree_secret_key"
                                                                class="form-label">{{ __('Cashfree Secret Key') }}</label>
                                                            <input type="text" name="cashfree_secret_key"
                                                                id="cashfree_secret_key" class="form-control"
                                                                value="{{ !isset($payment['cashfree_secret_key']) || is_null($payment['cashfree_secret_key']) ? '' : $payment['cashfree_secret_key'] }}"
                                                                placeholder="{{ __('Enter Cashfree Secret Key') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Aamarpay  --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-20">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse20"
                                                aria-expanded="true" aria-controls="collapse20">
                                                <span class="d-flex align-items-center">
                                                    {{ __('Aamarpay') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_aamarpay_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_aamarpay_enabled" id="is_aamarpay_enabled"
                                                        {{ isset($payment['is_aamarpay_enabled']) && $payment['is_aamarpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label for="customswitch1-2" class="form-check-label"></label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse20" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-20" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="aamarpay_store_id"
                                                                class="form-label">{{ __(' Store Id') }}</label>
                                                            <input type="text" name="aamarpay_store_id"
                                                                id="aamarpay_store_id" class="form-control"
                                                                value="{{ !isset($payment['aamarpay_store_id']) || is_null($payment['aamarpay_store_id']) ? '' : $payment['aamarpay_store_id'] }}"
                                                                placeholder="{{ __('Enter Store Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="aamarpay_signature_key"
                                                                class="form-label">{{ __('Signature Key') }}</label>
                                                            <input type="text" name="aamarpay_signature_key"
                                                                id="aamarpay_signature_key" class="form-control"
                                                                value="{{ !isset($payment['aamarpay_signature_key']) || is_null($payment['aamarpay_signature_key']) ? '' : $payment['aamarpay_signature_key'] }}"
                                                                placeholder="{{ __('Enter Signature Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="aamarpay_description"
                                                                class="form-label">{{ __('Description') }}</label>
                                                            <input type="text" name="aamarpay_description"
                                                                id="aamarpay_description" class="form-control"
                                                                value="{{ !isset($payment['aamarpay_description']) || is_null($payment['aamarpay_description']) ? '' : $payment['aamarpay_description'] }}"
                                                                placeholder="{{ __('Enter Signature Key') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PayTR --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-21">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse21"
                                                aria-expanded="true" aria-controls="collapse21">
                                                <span class="d-flex align-items-center">
                                                    {{ __('Pay TR') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_paytr_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_paytr_enabled" id="is_paytr_enabled"
                                                        {{ isset($payment['is_paytr_enabled']) && $payment['is_paytr_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapse21" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-21" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paytr_merchant_id"
                                                                class="form-label">{{ __('Merchant Id') }}</label>
                                                            <input type="text" name="paytr_merchant_id"
                                                                id="paytr_merchant_id" class="form-control"
                                                                value="{{ !isset($payment['paytr_merchant_id']) || is_null($payment['paytr_merchant_id']) ? '' : $payment['paytr_merchant_id'] }}"
                                                                placeholder="{{ __('Merchant Id') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paytr_merchant_key"
                                                                class="form-label">{{ __('Merchant Key') }}</label>
                                                            <input type="text" name="paytr_merchant_key"
                                                                id="paytr_merchant_key" class="form-control"
                                                                value="{{ !isset($payment['paytr_merchant_key']) || is_null($payment['paytr_merchant_key']) ? '' : $payment['paytr_merchant_key'] }}"
                                                                placeholder="{{ __('Merchant Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paytr_merchant_salt"
                                                                class="form-label">{{ __('Salt Passphrase') }}</label>
                                                            <input type="text" name="paytr_merchant_salt"
                                                                id="paytr_merchant_salt" class="form-control"
                                                                value="{{ !isset($payment['paytr_merchant_salt']) || is_null($payment['paytr_merchant_salt']) ? '' : $payment['paytr_merchant_salt'] }}"
                                                                placeholder="{{ __('Salt Passphrase') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Yookassa --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-22">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse22"
                                                aria-expanded="true" aria-controls="collapse22">
                                                <span class="d-flex align-items-center">
                                                    {{ __('Yookassa') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_yookassa_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_yookassa_enabled" id="is_yookassa_enabled"
                                                        {{ isset($payment['is_yookassa_enabled']) && $payment['is_yookassa_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapse22" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-22" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="yookassa_shop_id"
                                                                class="form-label">{{ __('Shop ID Key') }}</label>
                                                            <input type="text" name="yookassa_shop_id"
                                                                id="yookassa_shop_id" class="form-control"
                                                                value="{{ !isset($payment['yookassa_shop_id']) || is_null($payment['yookassa_shop_id']) ? '' : $payment['yookassa_shop_id'] }}"
                                                                placeholder="{{ __('Enter Shop ID Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="yookassa_secret"
                                                                class="form-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="yookassa_secret"
                                                                id="yookassa_secret" class="form-control"
                                                                value="{{ !isset($payment['yookassa_secret']) || is_null($payment['yookassa_secret']) ? '' : $payment['yookassa_secret'] }}"
                                                                placeholder="{{ __('Enter Secret Key') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Midtrans --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-23">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse23"
                                                aria-expanded="true" aria-controls="collapse23">
                                                <span class="d-flex align-items-center">
                                                    {{ __('Midtrans') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_midtrans_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_midtrans_enabled" id="is_midtrans_enabled"
                                                        {{ isset($payment['is_midtrans_enabled']) && $payment['is_midtrans_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapse23" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-23" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="midtrans_secret"
                                                                class="form-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="midtrans_secret"
                                                                id="midtrans_secret" class="form-control"
                                                                value="{{ !isset($payment['midtrans_secret']) || is_null($payment['midtrans_secret']) ? '' : $payment['midtrans_secret'] }}"
                                                                placeholder="{{ __('Enter Secret Key') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Xendit --}}
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-2-24">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse24"
                                                aria-expanded="true" aria-controls="collapse24">
                                                <span class="d-flex align-items-center">
                                                    {{ __('Xendit') }}
                                                </span>
                                                {{ __('Enable:') }}
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input type="hidden" name="is_xendit_enabled" value="off">
                                                    <input type="checkbox" class="form-check-input input-primary"
                                                        name="is_xendit_enabled" id="is_xendit_enabled"
                                                        {{ isset($payment['is_xendit_enabled']) && $payment['is_xendit_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="form-check-label" for="customswitchv1-2"></label>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapse24" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2-24" data-bs-parent="#accordionExample">
                                            <div class="accordion-body1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="xendit_api"
                                                                class="form-label">{{ __('API Key') }}</label>
                                                            <input type="text" name="xendit_api" id="xendit_api"
                                                                class="form-control"
                                                                value="{{ !isset($payment['xendit_api']) || is_null($payment['xendit_api']) ? '' : $payment['xendit_api'] }}"
                                                                placeholder="{{ __('Enter API Key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="xendit_token"
                                                                class="form-label">{{ __('Token') }}</label>
                                                            <input type="text" name="xendit_token" id="xendit_token"
                                                                class="form-control"
                                                                value="{{ !isset($payment['xendit_token']) || is_null($payment['xendit_token']) ? '' : $payment['xendit_token'] }}"
                                                                placeholder="{{ __('Enter Token') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                {{-- recaptcha --}}
                <div id="recaptcha-settings" class="card">
                    <form method="POST" action="{{ route('recaptcha.settings.store') }}" accept-charset="UTF-8">
                        @csrf
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('ReCaptcha settings') }}</h5>
                                    <a href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                        target="_blank" class="text-blue">
                                        <small>({{ __('How to Get Google reCaptcha Site and Secret key') }})</small>
                                    </a>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="col switch-width">
                                        <div class="form-group ml-2 mb-0">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    data-onstyle="primary" data-toggle="switchbutton"
                                                    name="recaptcha_module" id="recaptcha_module" value="yes"
                                                    {{ $settings['recaptcha_module'] == 'yes' ? ' checked ' : '' }}>
                                                <label class="custom-control-label form-control-label px-2"
                                                    for="recaptcha_module"></label><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-0">
                                <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                    <label for="google_recaptcha_key"
                                        class="form-label">{{ __('Google Recaptcha Key') }}</label>
                                    <input class="form-control" placeholder="{{ __('Enter Google Recaptcha Key') }}"
                                        name="google_recaptcha_key" type="text"
                                        value=" {{!isset($settings['google_recaptcha_key']) || is_null($settings['google_recaptcha_key']) ? '' : $settings['google_recaptcha_key'] }}"
                                        id="google_recaptcha_key">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                    <label for="google_recaptcha_secret"
                                        class="form-label">{{ __('Google Recaptcha Secret') }}</label>
                                    <input class="form-control " placeholder="{{ __('Enter Google Recaptcha Secret') }}"
                                        name="google_recaptcha_secret" type="text"
                                        value=" {{!isset($settings['google_recaptcha_secret']) || is_null($settings['google_recaptcha_secret']) ? '' : $settings['google_recaptcha_secret'] }}"
                                        id="google_recaptcha_secret">
                                </div>
                                <div class="text-end">
                                    {{ Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary']) }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--storage Setting-->
                <div id="storage-settings" class="card mb-3">
                    {{ Form::open(['route' => 'storage.setting.store', 'enctype' => 'multipart/form-data']) }}
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-10">
                                <h5 class="">{{ __('Storage Settings') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="pe-2">
                                <input type="radio" class="btn-check" name="storage_setting" id="local-outlined"
                                    autocomplete="off" {{ $settings['storage_setting'] == 'local' ? 'checked' : '' }}
                                    value="local" checked>
                                <label class="btn btn-outline-primary" for="local-outlined">{{ __('Local') }}</label>
                            </div>
                            <div class="pe-2">
                                <input type="radio" class="btn-check" name="storage_setting" id="s3-outlined"
                                    autocomplete="off" {{ $settings['storage_setting'] == 's3' ? 'checked' : '' }}
                                    value="s3">
                                <label class="btn btn-outline-primary" for="s3-outlined">
                                    {{ __('AWS S3') }}</label>
                            </div>

                            <div class="pe-2">
                                <input type="radio" class="btn-check" name="storage_setting" id="wasabi-outlined"
                                    autocomplete="off" {{ $settings['storage_setting'] == 'wasabi' ? 'checked' : '' }}
                                    value="wasabi">
                                <label class="btn btn-outline-primary" for="wasabi-outlined">{{ __('Wasabi') }}</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="local-setting row">
                                <div class="col-lg-7">
                                    {{-- <h4 class="small-title">{{ __('Local Settings') }}</h4> --}}
                                    <div class="form-group col-12 switch-width">
                                        {{ Form::label('local_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                        <select name="local_storage_validation[]" class="select2"
                                            id="local_storage_validation" multiple>
                                            @foreach ($file_type as $f)
                                            <option @if (in_array($f, $local_storage_validations)) selected @endif>
                                                {{ $f }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="local_storage_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                        <input type="number" name="local_storage_max_upload_size" class="form-control"
                                            value="{{ !isset($settings['local_storage_max_upload_size']) || is_null($settings['local_storage_max_upload_size']) ? '' : $settings['local_storage_max_upload_size'] }}"
                                            placeholder="{{ __('Max upload size') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="s3-setting row {{ $settings['storage_setting'] == 's3' ? ' ' : 'd-none' }}">

                                <div class=" row ">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_key">{{ __('S3 Key') }}</label>
                                            <input type="text" name="s3_key" class="form-control"
                                                value="{{ !isset($settings['s3_key']) || is_null($settings['s3_key']) ? '' : $settings['s3_key'] }}"
                                                placeholder="{{ __('S3 Key') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_secret">{{ __('S3 Secret') }}</label>
                                            <input type="text" name="s3_secret" class="form-control"
                                                value="{{ !isset($settings['s3_secret']) || is_null($settings['s3_secret']) ? '' : $settings['s3_secret'] }}"
                                                placeholder="{{ __('S3 Secret') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_region">{{ __('S3 Region') }}</label>
                                            <input type="text" name="s3_region" class="form-control"
                                                value="{{ !isset($settings['s3_region']) || is_null($settings['s3_region']) ? '' : $settings['s3_region'] }}"
                                                placeholder="{{ __('S3 Region') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_bucket">{{ __('S3 Bucket') }}</label>
                                            <input type="text" name="s3_bucket" class="form-control"
                                                value="{{ !isset($settings['s3_bucket']) || is_null($settings['s3_bucket']) ? '' : $settings['s3_bucket'] }}"
                                                placeholder="{{ __('S3 Bucket') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_url">{{ __('S3 URL') }}</label>
                                            <input type="text" name="s3_url" class="form-control"
                                                value="{{ !isset($settings['s3_url']) || is_null($settings['s3_url']) ? '' : $settings['s3_url'] }}"
                                                placeholder="{{ __('S3 URL') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_endpoint">{{ __('S3 Endpoint') }}</label>
                                            <input type="text" name="s3_endpoint" class="form-control"
                                                value="{{ !isset($settings['s3_endpoint']) || is_null($settings['s3_endpoint']) ? '' : $settings['s3_endpoint'] }}"
                                                placeholder="{{ __('S3 Endpoint') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group col-12 switch-width">
                                            {{ Form::label('s3_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                            <select name="s3_storage_validation[]" class="select2"
                                                id="s3_storage_validation" multiple>
                                                @foreach ($file_type as $f)
                                                <option @if (in_array($f, $s3_storage_validations)) selected @endif>
                                                    {{ $f }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="s3_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                            <input type="number" name="s3_max_upload_size" class="form-control"
                                                value="{{ !isset($settings['s3_max_upload_size']) || is_null($settings['s3_max_upload_size']) ? '' : $settings['s3_max_upload_size'] }}"
                                                placeholder="{{ __('Max upload size') }}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div
                                class="wasabi-setting row {{ $settings['storage_setting'] == 'wasabi' ? ' ' : 'd-none' }}">
                                <div class=" row ">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_key">{{ __('Wasabi Key') }}</label>
                                            <input type="text" name="wasabi_key" class="form-control"
                                                value="{{ !isset($settings['wasabi_key']) || is_null($settings['wasabi_key']) ? '' : $settings['wasabi_key'] }}"
                                                placeholder="{{ __('Wasabi Key') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_secret">{{ __('Wasabi Secret') }}</label>
                                            <input type="text" name="wasabi_secret" class="form-control"
                                                value="{{ !isset($settings['wasabi_secret']) || is_null($settings['wasabi_secret']) ? '' : $settings['wasabi_secret'] }}"
                                                placeholder="{{ __('Wasabi Secret') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="s3_region">{{ __('Wasabi Region') }}</label>
                                            <input type="text" name="wasabi_region" class="form-control"
                                                value="{{ !isset($settings['wasabi_region']) || is_null($settings['wasabi_region']) ? '' : $settings['wasabi_region'] }}"
                                                placeholder="{{ __('Wasabi Region') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="wasabi_bucket">{{ __('Wasabi Bucket') }}</label>
                                            <input type="text" name="wasabi_bucket" class="form-control"
                                                value="{{ !isset($settings['wasabi_bucket']) || is_null($settings['wasabi_bucket']) ? '' : $settings['wasabi_bucket'] }}"
                                                placeholder="{{ __('Wasabi Bucket') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="wasabi_url">{{ __('Wasabi URL') }}</label>
                                            <input type="text" name="wasabi_url" class="form-control"
                                                value="{{ !isset($settings['wasabi_url']) || is_null($settings['wasabi_url']) ? '' : $settings['wasabi_url'] }}"
                                                placeholder="{{ __('Wasabi URL') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="wasabi_root">{{ __('Wasabi Root') }}</label>
                                            <input type="text" name="wasabi_root" class="form-control"
                                                value="{{ !isset($settings['wasabi_root']) || is_null($settings['wasabi_root']) ? '' : $settings['wasabi_root'] }}"
                                                placeholder="{{ __('Wasabi Root') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-group col-12 switch-width">
                                            {{ Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => 'form-label']) }}

                                            <select name="wasabi_storage_validation[]" class="select2"
                                                id="wasabi_storage_validation" multiple>
                                                @foreach ($file_type as $f)
                                                <option @if (in_array($f, $wasabi_storage_validations)) selected @endif>
                                                    {{ $f }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="wasabi_root">{{ __('Max upload size ( In KB)') }}</label>
                                            <input type="number" name="wasabi_max_upload_size" class="form-control"
                                                value="{{ !isset($settings['wasabi_max_upload_size']) || is_null($settings['wasabi_max_upload_size']) ? '' : $settings['wasabi_max_upload_size'] }}"
                                                placeholder="{{ __('Max upload size') }}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit"
                                value="{{ __('Save Changes') }}">
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                {{-- SEO setting --}}
                <div class="card" id="SEO">
                    {{ Form::open(['url' => route('seo.settings'), 'enctype' => 'multipart/form-data']) }}
                    <div class="card-header">

                        <h5>{{ __('SEO Settings') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (!empty($settings['chatgpt_key']))
                            <div class="text-end">
                                <a href="#" data-size="md" class="btn btn-sm btn-primary " data-ajax-popup-over="true"
                                    data-size="md" data-title="{{ __('Generate content with AI') }}"
                                    data-url="{{ route('generate', ['seo']) }}" data-toggle="tooltip"
                                    title="{{ __('Generate') }}">
                                    <i class="fas fa-robot"></span><span
                                            class="robot">{{ __('Generate With AI') }}</span></i>
                                </a>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('meta_keywords', Utility::getValByName('meta_keywords'), ['class' => 'form-control ', 'placeholder' => 'Meta Keywords']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('meta_description', __('Meta Description'), ['class' => 'form-label']) }}
                                    {{ Form::textarea('meta_description', Utility::getValByName('meta_description'), ['class' => 'form-control ', 'rows' => '5', 'placeholder' => 'Enter Meta Description']) }}
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label']) }}
                                    <div class="">
                                        {{-- @php
                                                                            $src = isset($settings['meta_image']) && !empty($settings['meta_image']) ? asset(Storage::url('uploads/metaevent/meta_image.png' . $settings['meta_image'])) : '';
                                                                        @endphp --}}

                                        <a href="{{ $meta_image . '/' . (isset($settings['meta_image']) && !empty($settings['meta_image']) ? $settings['meta_image'] : 'meta_image.png') }}"
                                            target="_blank"> <img id="meta"
                                                src="{{ $meta_image . '/' . (isset($settings['meta_image']) && !empty($settings['meta_image']) ? $settings['meta_image'] : 'meta_image.png') }}"
                                                width="300px" class="img_setting"> </a>
                                    </div>
                                    <div class="choose-files mt-4">
                                        <label for="meta_image">
                                            <div class=" bg-primary logo"> <i
                                                    class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                            </div>
                                            <input style="margin-top: -40px;" type="file" class="form-control file"
                                                name="meta_image" id="meta_image" data-filename="meta_image"
                                                onchange="document.getElementById('meta_image_pre').src = window.URL.createObjectURL(this.files[0])" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn-submit btn btn-primary" type="submit">
                                    {{ __('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
                {{-- cache setting --}}
                <div class="card" id="cache">
                    <div class="card-header">
                        <div class="row">

                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <h5>{{ __('Cache Settings') }}</h5>
                                <p class="text-muted">This is a page meant for more advanced users, simply
                                    ignore it if you don't understand what cache is.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                        </div>
                        <div class="row">
                            <div class="row col-xl-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="size">Current cache size</label>
                                        <div class="input-group">
                                            <input id="size" name="size" type="text" class="form-control"
                                                value="{{ Utility::GetCacheSize() }}" readonly="readonly">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    MB
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url('config-cache') }}"
                                class="btn btn-print-invoice btn-primary m-r-10">{{ __('Clear Cache') }}</a>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                {{-- Cookie Setting --}}
                <div class="card" id="cookie">
                    {{ Form::model($settings, ['route' => 'cookie.setting', 'method' => 'post']) }}
                    <div
                        class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                        <h5>{{ __('Cookie Settings') }}</h5>
                        <div class="d-flex align-items-center">
                            {{ Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3']) }}
                            <div class="custom-control custom-switch" onclick="enablecookie()">

                                <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                    name="enable_cookie" class="form-check-input input-primary " id="enable_cookie"
                                    {{ $settings['enable_cookie'] == 'on' ? ' checked ' : '' }}>
                                <label class="custom-control-label mb-1" for="enable_cookie"></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body cookieDiv {{ $settings['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}">
                        <div class="row">
                            @if (!empty($settings['chatgpt_key']))
                            <div class="text-end">
                                <a href="#" data-size="md" class="btn btn-sm btn-primary" data-ajax-popup-over="true"
                                    data-size="md" data-title="{{ __('Generate content with AI') }}"
                                    data-url="{{ route('generate', ['account']) }}" data-toggle="tooltip"
                                    title="{{ __('Generate') }}">
                                    <i class="fas fa-robot"></span><span
                                            class="robot">{{ __('Generate With AI') }}</span></i>
                                </a>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                    <input type="checkbox" name="cookie_logging"
                                        class="form-check-input tem input-primary cookie_setting str"
                                        id="cookie_logging"
                                        {{ $settings['cookie_logging'] == 'on' ? ' checked ' : '' }}>
                                    <label class="form-check-label" style="margin-left:5px"
                                        for="cookie_logging">{{ __('Enable logging') }}</label>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                                <div class="form-group ">
                                    {{ Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label']) }}
                                    {!! Form::textarea('cookie_description', null, ['class' => 'form-control
                                    cookie_setting', 'rows' => '3']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch custom-switch-v1 ">
                                    <input type="checkbox" name="necessary_cookies"
                                        class="form-check-input tem input-primary str" id="necessary_cookies" checked
                                        onclick="return false">
                                    <label class="form-check-label" style="margin-left:5px"
                                        for="necessary_cookies">{{ __('Strictly necessary cookies') }}</label>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('strictly_cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label']) }}
                                    {!! Form::textarea('strictly_cookie_description', null, [
                                    'class' => 'form-control cookie_setting ',
                                    'rows' => '3',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-12">
                                <h5>{{ __('More Information') }}</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    {{ Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('more_information_description', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    {{ Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('contactus_url', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card-footer d-flex align-items-center gap-2 flex-sm-column flex-lg-row justify-content-between">
                        <div>
                            @if (isset($settings['cookie_logging']) && $settings['cookie_logging'] == 'on')
                            <label for="file" class="form-label">{{ __('Download cookie accepted data') }}</label>
                            <a href="{{ asset(Storage::url('uploads/sample')) . '/data.csv' }}"
                                class="btn btn-primary mr-2 ">
                                <i class="ti ti-download"></i>
                            </a>
                            @endif
                        </div>
                        <input type="submit" value="{{ __(' Save Changes') }}" class="btn btn-primary">
                    </div>
                    {{ Form::close() }}
                </div>
                {{-- ChatGPT  --}}
                @if (\Auth::user()->type == 'super admin')
                <div class="card" id="pills-chatgpt-settings">
                    {{ Form::model($settings, ['route' => 'settings.chatgptkey', 'method' => 'post']) }}
                    <div class="card-header">
                        <h5>{{ __('Chat GPT Key Settings') }}</h5>
                        <small>{{ __('Edit your key details') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                {{ Form::text('chatgpt_key', isset($settings['chatgpt_key']) ? $settings['chatgpt_key'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Chatgpt Key Here')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">{{ __('Save Changes') }}</button>
                    </div>
                    {{ Form::close() }}
                </div>
                @endif

            </div>
            @endif
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="editForm">
                <label for="newCost">New Cost:</label>
                <input type="text" id="newCost" name="newCost">
                <button type="button" id="saveBtn">Save</button>
            </form>
        </div>
    </div>
    @endsection
    @push('script-page')
    <script>
        
    $('.fxnnames').click(function() {
        var value = $(this).text();
        var funrr = <?= (isset($function) && !empty($function)) ? json_encode($function) : 'null' ?>;
        $.each(funrr, function(item, valueee) {
            if (value.toLowerCase().indexOf(valueee.function.trim().toLowerCase()) !== -1) {
                $('input[name="function"]').val(valueee.function);
                var packages = valueee.package;
                $('.appending_div .appending_item').remove();
                packages.forEach(function(packageName) {
                    var inputField =
                        '<div class="appending_item" style="margin-bottom: 21px;display: flex;margin-top: 5px;">' +
                        '<input type="text" name="package[]" class="form-control" value="' +
                        packageName + '" placeholder="Enter Package">' +
                        '<span class="btn btn-sm btn-danger btn-icon m-1 delete"><i class="fa fa-times"></i></span>' +
                        '</div>';
                    $('.appending_div').append(inputField);
                });
                return false; // Exit the loop once a match is found
            }
        });
    })
    $('.barnmes').click(function() {
        var value = $(this).text();
        var bararr = <?= (isset($bar) && !empty($bar)) ? json_encode($bar) : 'null' ?>;
        console.log(bararr);
        $.each(bararr, function(item, valueee) {
            if (value.toLowerCase().indexOf(valueee.bar.trim().toLowerCase()) !== -1) {
                $('input[name="bar"]').val(valueee.bar);
                var packages = valueee.barpackage;
                $('.appending_div_for_bar .appending_item_for_bar').remove();
                packages.forEach(function(packageName) {
                    var inputField =
                        '<div class="appending_item_for_bar" style="margin-bottom: 21px;display: flex;margin-top: 5px;">' +
                        '<input type="text" name="barpackage[]" class="form-control" value="' +
                        packageName + '" placeholder="Enter Package">' +
                        '<span class="btn btn-sm btn-danger btn-icon m-1 delete"><i class="fa fa-times"></i></span>' +
                        '</div>';
                    $('.appending_div_for_bar').append(inputField);
                });
                return false; // Exit the loop once a match is found
            }
        });
    })
    </script>
    <script>
    $(document).ready(function() {
        $("select#additional_function").change(function() {
            let val = $(this).val();
            const functionData =
                <?= (isset($function) && !empty($function)) ? json_encode($function) : 'null' ?>[val];
            let packages = functionData.package;
            $('#additional_packages_checkboxes').empty();
            $.each(packages, function(index, package) {
                $('#additional_packages_checkboxes').append(
                    '<label><input type="checkbox" name="additional_package[]" value="' +
                    package + '"> ' + package + '</label><br>');
            });
        })
    });
    </script>
    <script>
    var additionalItemCount = 2;

    function addAdditionalItem() {
        var container = document.getElementById('additional-items-container');

        // Create a new row
        var newRow = document.createElement('div');
        newRow.classList.add('row', 'form-group');
        newRow.id = 'additional-row-' + additionalItemCount;

        // Create name input
        newRow.innerHTML += `
                        <div class="col-md-5">
                            <label for="additional_items_${additionalItemCount}">Additional Item ${additionalItemCount}</label>
                            <input type="text" name="additional_items[]" id="additional_items_${additionalItemCount}" class="form-control" placeholder="Enter Additional Item" required>
                        </div>
                    `;
        newRow.innerHTML += `
                        <div class="col-md-6">
                            <label for="additional_items_cost_${additionalItemCount}">Cost</label>
                            <input type="number" name="additional_items_cost[]" id="additional_items_cost_${additionalItemCount}" class="form-control" placeholder="Enter Cost" required>
                        </div>
                    `;
        newRow.innerHTML += `
                <div class="col-md-1 mt-3">
                    <button type="button" class="btn btn-danger" style="    margin-top: 4px;
                " onclick="removeAdditionalItem(${additionalItemCount})"><i class="fa fa-times"></i></button>
                        </div>
                    `;
        additionalItemCount++;
        container.appendChild(newRow);
    }

    function removeAdditionalItem(rowId) {
        var rowToRemove = document.getElementById('additional-row-' + rowId);
        rowToRemove.remove();
    }
    </script>
    <script>
    $('#function_names').change(function() {
        $('#package_inputs').empty();
        var value = $(this).val();
        if (value) {
            $('.function_cost').show();
            var functionarr = <?= (isset($function) && !empty($function)) ? json_encode($function) : 'null' ?>;
            $.each(functionarr, function(index, function_val) {
                if (index == value) {
                    var packagevalue = function_val.package;
                    $.each(packagevalue, function(index, val) {
                        var inputField = '<div class = "form-group"><label for="package_' +
                            index +
                            '">' + val + ' Cost:</label>';
                        inputField += '<input type="number" name="package_cost[' + index +
                            ']" class="form-control" placeholder="Enter ' + val +
                            ' Cost"  min="0"></div>';
                        $('#package_inputs').append(inputField);
                    });
                }
            });
        } else {
            $('.function_cost').hide();
        }
    });
    $('#bar_names').change(function() {
        $('#bar_package_inputs').empty();
        var value = $(this).val();
        if (value) {
            $('.bar_cost').show();
            var bararr = <?= (isset($bar) && !empty($bar)) ? json_encode($bar) : 'null' ?>;
            $.each(bararr, function(index, val) {
                if (index == value) {
                    var packagevalue = val.barpackage;
                    $.each(packagevalue, function(index, val) {
                        // Dynamically generate input fields for each package
                        var inputField = '<div class = "form-group"><label for="barpackage_' +
                            index + '">' + val + ' Cost:</label>';
                        inputField += '<input type="number" name="bar_package_cost[' + index +
                            ']" class="form-control" placeholder="Enter ' + val +
                            ' Cost"  min="0"></div>';

                        $('#bar_package_inputs').append(inputField);
                    });
                }
            });
        } else {
            $('.bar_cost').hide();
        }
    });
    </script>
    <script>
    $(document).ready(function() {
        $('.add').on('click', function() {
            var field =
                '<br><div class="appending_item" style="display:flex"><input type="text" name="package[]" class="form-control" placeholder ="Enter Package">';
            field +=
                '<span class="btn btn-sm btn-danger btn-icon m-1 delete"><i class="fa fa-times"></i></span></div>';
            $('.appending_div').append(field);
        })
        $('.appending_div').on('click', '.delete', function() {
            $(this).closest('.appending_item').remove();
        });
        $('.addbar').on('click', function() {
            var field =
                '<br><div class="appending_item_for_bar" style="display:flex"><input type="text" name="barpackage[]" class="form-control" placeholder ="Enter Package">';
            field +=
                '<span class="btn btn-sm btn-danger btn-icon m-1 deletebar"><i class="fa fa-times"></i></span></div>';
            $('.appending_div_for_bar').append(field);
        })
        $('.appending_div_for_bar').on('click', '.deletebar', function() {
            $(this).closest('.appending_item_for_bar').remove();
        });
    })
    </script>
    <script>
    $(document).ready(function() {
        $("#checkall").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $(".ischeck").click(function() {
            var ischeck = $(this).data('id');
            $('.isscheck_' + ischeck).prop('checked', this.checked);

        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    function deleteImage(icon) {
        var imageName = icon.getAttribute('data-image');
        var url = "{{ url('/delete-image') }}";
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "This action can not be undone. Do you want to continue?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "imageName": imageName,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result) {
                        if (result.success == true) {
                            swal.fire("Done!", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            swal.fire("Error!", result.message, "error");
                        }
                    }
                });
            }
        })
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('signatureCanvas');
        var signaturePad = new SignaturePad(canvas);

        function clearCanvas() {
            signaturePad.clear();
        }
        document.getElementById('clearButton').addEventListener('click', function(e) {
            e.preventDefault();
            clearCanvas();
        });
        // Access the data (image or coordinates) from the signature pad on form submit
        document.getElementById('sign').addEventListener('submit', function(event) {
            event.preventDefault();
            if (signaturePad.isEmpty()) {
                alert('Please provide your signature before submitting.');
            } else {
                var signatureData = signaturePad.toDataURL();
                document.getElementById('imageData').value = signatureData;
                $.ajax({
                    url: "{{ route('authorised.signature') }}",
                    type: 'POST',
                    data: {
                        "signature": signatureData,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        document.querySelectorAll('.edit-cost-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get the current cost value
                console.log(button);
                const costElement = this.closest('tr').querySelector('.cost');
                let currentCost = costElement.textContent.trim();
                const itemName = this.closest('tr').querySelector('.item').textContent.trim();
                const packageName = this.closest('td').getAttribute('data-function').trim();
                const functionname = this.closest('td').getAttribute('data-package').trim();
                const newCost = prompt('Enter new cost:', currentCost);

                // Update the cost if the user provided a new value
                if (newCost !== null && newCost !== '' && !isNaN(newCost)) {
                    costElement.textContent = newCost;
                }
                $.ajax({
                    url: "{{route('additionalitems.edit')}}",
                    type: 'POST',
                    data: {
                        function_name: functionname,
                        package_name: packageName,
                        item_name: itemName,
                        cost: newCost,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        console.log(data);
                    },
                });
            });
        });
        // Get the modal

    });
    </script>
    @endpush