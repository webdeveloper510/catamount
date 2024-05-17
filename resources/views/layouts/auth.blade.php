@php
$setting = Utility::settings();

$color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
$logo = \App\Models\Utility::get_file('uploads/logo/');
$company_favicon = $setting['company_favicon'] ?? '';
$company_logo = \App\Models\Utility::GetLogo();
$users = \Auth::user();

$lang = \App::getLocale('lang');
if ($lang == 'ar' || $lang == 'he') {
$setting['SITE_RTL'] = 'on';
}
$LangName = \App\Models\Languages::where('code', $lang)->first();
if (empty($LangName)) {
$LangName = new App\Models\Utility();
$LangName->fullName = 'English';
}
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Salesy Saas- Business Sales CRM" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />
    <title>
        {{ Utility::getValByName('header_text') ? Utility::getValByName('header_text') : config('app.name', 'Salesy SaaS') }}
        - @yield('page-title')</title>
    <!-- Primary Meta Tags -->

    <meta name="title" content="{{ $setting['meta_keywords'] }}">
    <meta name="description" content="{{ $setting['meta_description'] }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $setting['meta_keywords'] }}">
    <meta property="og:description" content="{{ $setting['meta_description'] }}">
    <meta property="og:image" content="{{ asset('uploads/metaevent/' . $setting['meta_image']) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $setting['meta_keywords'] }}">
    <meta property="twitter:description" content="{{ $setting['meta_description'] }}">
    <meta property="twitter:image" content="{{ asset('uploads/metaevent/' . $setting['meta_image']) }}">
    <link rel="icon" href="{{ $logo . '/favicon.png' }}" type="image/png">

    @if ($setting['cust_darklayout'] == 'on')
    <style>
    .g-recaptcha {
        filter: invert(1) hue-rotate(180deg) !important;
    }
    </style>
    @endif
    @if ($setting['cust_darklayout'] == 'on')
    @if (isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on')
    <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
    @if (isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on')
    <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @else
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif
    @endif

    @if (isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on')
    <link rel="stylesheet" href="{{ asset('assets/css/custom-auth-rtl.css') }}" id="main-style-link">
    @else
    <link rel="stylesheet" href="{{ asset('assets/css/custom-auth.css') }}" id="main-style-link">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
    <link rel="stylesheet" href="{{ asset('assets/css/custom-auth-dark.css') }}" id="main-style-link">
    @endif
</head>

<body class="{{ $color }}">
    <div class="custom-login">
        <!-- <div class="login-bg-img">
            <img src="{{ asset('assets/images/auth/'.$color.'.svg') }}" class="login-bg-1">
            <img src="{{ asset('assets/images/auth/common.svg') }}" class="login-bg-2">
        </div> -->
        <!-- <div class="bg-login bg-primary"></div> -->
        <div class="custom-login-inner">
            <main class="custom-wrapper">
                <div class="custom-row">
                    <div class="card">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

<script src="{{ asset('assets/js/vendor-all.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
@stack('custom-scripts')

@if ($setting['enable_cookie'] == 'on')
@include('layouts.cookie_consent')
@endif

<style>
.custom-login {
    background-image: url(<?php echo Storage::url('uploads/background_img/image.jpg'); ?>);
    background-size: cover;
}
</style>

</html>