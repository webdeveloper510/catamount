@extends('layouts.auth')

@section('page-title')
    {{ __('Register') }}
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
                @foreach (Utility::languages() as $code => $language)
                    <a href="{{ route('register', $code) }}" tabindex="0"
                        class="dropdown-item @if ($lang == $code) text-primary @endif">
                        <span>{{ ucfirst($language) }}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection

@section('content')
        <div class="card-body">
            <div class="">
            <h2 class="mb-3 f-w-600">{{ __('Register') }}</h2>

            </div>
            @if (session('status'))
                <div class="mb-4 font-medium text-lg text-green-600 text-danger">
                    {{ __('User is not Active Please Activate User.') }}
                </div>
            @endif
            {{ Form::open(['route' => 'register', 'method' => 'post', 'id' => 'loginForm']) }}
            @if (session('status'))
                <div class="mb-4 font-medium text-lg text-green-600 text-danger">
                    {{ __('Email SMTP settings does not configured so please contact to your site admin.') }}
                </div>
            @endif
            <div class="custom-login-form">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Name') }}</label>
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Name')]) }}
                    @error('name')
                        <span class="invalid-name text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Email')]) }}
                    @error('email')
                        <span class="invalid-email text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Your Password')]) }}
                    @error('password')
                        <span class="invalid-password text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Confirm Password') }}</label>
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => __('Enter Your Confirm Password')]) }}
                    @error('password_confirmation')
                        <span class="invalid-password_confirmation text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if ($settings['recaptcha_module'] == 'yes')
                    <div class="form-group mt-3">
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                            <span class="small text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif


                <div class="d-grid">
                    {{ Form::submit(__('Register'), ['class' => 'btn btn-primary btn-block mt-2', 'id' => 'saveBtn']) }}
                </div>
                <p class="my-4 text-center">{{ __('Already have an account?') }} <a href="{{ route('login') }}"
                        class="my-4 text-center text-primary"> {{ __('Login') }}</a></p>
            </div>
            {{ Form::close() }}
        </div>
@endsection
@push('custom-scripts')
    @if ($settings['recaptcha_module'] == 'yes')
        {{-- {!! NoCaptcha::renderJs() !!} --}}
        {!! NoCaptcha::renderJs() !!}

    @endif
@endpush
