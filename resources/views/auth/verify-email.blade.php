@extends('layouts.auth')

@php
    if (empty($lang)) {
        $lang = Utility::getValByName('default_language');
    }
@endphp
@php
    $logo = asset(Storage::url('uploads/logo/'));
    if ($lang == 'ar' || $lang == 'he') {
        $setting['SITE_RTL'] = 'on';
    }
    $lang = \App::getLocale('lang');
    $LangName = \App\Models\Languages::where('code', $lang)->first();
    if (empty($LangName)) {
        $LangName = new App\Models\Utility();
        $LangName->fullName = 'English';
    }
@endphp


{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$setting['SITE_RTL'] == 'on'?'rtl':''}}">    --}}

@section('title')
    {{ __('Reset Password') }}
@endsection


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
                    <a href="{{ route('verification.notice', $code) }}" tabindex="0"
                        class="dropdown-item @if ($lang == $code) text-primary @endif">
                        <span>{{ ucfirst($language) }}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection


@section('content')
        <div class="col-xl-6 col-12">
            <div class="card-body">
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 text-primary">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="row">
                        <div class="col-auto">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>
                        </div>

                        <div class="col-auto">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"> {{ __('Logout') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('content')
@endsection
