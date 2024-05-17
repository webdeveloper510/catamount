@extends('layouts.auth')
@section('page-title')
    {{ __('Login') }}
@endsection
@php
    if ($lang == 'ar' || $lang == 'he') {
        $setting['SITE_RTL'] = 'on';
    }
    $lang = \App::getLocale('lang');
    $LangName = \App\Models\Languages::where('code', $lang)->first();
    if (empty($LangName)) {
        $LangName = new App\Models\Utility();
        $LangName->fullName = 'English';
    }
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
    $settings = \App\Models\Utility::settings();


@endphp
@section('language-bar')
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text">
                    {{-- @if (array_key_exists($LangName->fullName, App\Models\Utility::flagOfCountryLogin()))
                    {{ App\Models\Utility::flagOfCountryLogin()[ucfirst($LangName->fullName)] }}
                @endif --}}
                {{ ucfirst($LangName->fullName) }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach(Utility::languages() as $code => $language)
                    <a href="{{ route('login',$code) }}" tabindex="0" class="dropdown-item {{ $code == $lang ? 'active':'' }}">
                        <span>{{ ucFirst($language)}}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection

@section('content')
       <div class="form-box">
           <div class="header-text">
			Login Form
		</div>
            <div class="custom-login-form">
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror"
                            name="email" placeholder="{{ __('Enter your email') }}" required autofocus>
                        @error('email')
                            <span class="error invalid-email text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3 pss-field">
                        <label class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror"
                            name="password" placeholder="{{ __('Password') }}" required>
                        @error('password')
                            <span class="error invalid-password text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <!-- <div class="form-group mb-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            @if (Route::has('password.request'))
                                <span>
                                    <a href="{{ route('password.request', $lang) }}"
                                        tabindex="0">{{ __('Forgot Your Password?') }}</a>
                                </span>
                            @endif
                        </div>
                    </div> -->
                    @if ($settings['recaptcha_module'] == 'yes')
                        <div class="form-group mb-4">
                            {!! NoCaptcha::display() !!}
                            @error('g-recaptcha-response')
                                <span class="error small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                    <div class="d-grid">
                        <button class="btn btn-primary mt-2" type="submit">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form> 
                <!-- @if (Utility::getValByName('signup_button') == 'on')
                    <p class="my-4 text-center">{{ __("Don't have an account?") }}
                        <a href="{{ route('register', $lang) }}" tabindex="0">{{ __('Register') }}</a>
                    </p>
                @endif -->
            </div>
        </div>
               
<style>
    * {
	box-sizing: border-box;
}
body {
	font-family: poppins;
	font-size: 16px;
	color: #fff;
}
.form-box {
	background-color: rgba(0, 0, 0, 0.5);
	margin: auto auto;
	padding: 40px;
	border-radius: 5px;
	box-shadow: 0 0 10px #000;
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	width: 500px;
	height: 430px;
}
.form-box:before {
	background-image: url("<?php Storage::files('uploads/background_img/image.jpg') ?>");
	width: 100%;
	height: 100%;
	background-size: cover;
	content: "";
	position: fixed;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	z-index: -1;
	display: block;
	filter: blur(2px);
}
.form-box .header-text {
	font-size: 32px;
	font-weight: 600;
	padding-bottom: 30px;
	text-align: center;
}
.form-box input {
	margin: 10px 0px;
	border: none;
	padding: 10px;
	border-radius: 5px;
	width: 100%;
	font-size: 18px;
	font-family: poppins;
}
.form-box input[type=checkbox] {
	display: none;
}
.form-box label {
	/* position: relative; */
	margin-left: 5px;
	margin-right: 10px;
	top: 5px;
	display: inline-block;
	/* width: 20px; */
	height: 20px;
	cursor: pointer;
}
.form-box label:before {
	/* content: ""; */
	display: inline-block;
	width: 20px;
	height: 20px;
	border-radius: 5px;
	position: absolute;
	left: 0;
	bottom: 1px;
	background-color: #ddd;
}
/* .form-box input[type=checkbox]:checked+label:before {
	content: "\2713";
	font-size: 20px;
	color: #000;
	text-align: center;
	line-height: 20px;
} */
.form-box span {
	font-size: 14px;
}
.form-box button {
	background-color: deepskyblue;
	color: #fff;
	border: none;
	border-radius: 5px;
	cursor: pointer;
	width: 100%;
	font-size: 18px;
	padding: 10px;
	margin: 20px 0px;
}
span a {
	color: #BBB;
}

</style>
@endsection

@push('custom-scripts')
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".form_data").submit(function(e) {
                $(".login_button").attr("disabled", true);
                return true;
            });
        });
    </script>

    @if ($settings['recaptcha_module'] == 'yes')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
