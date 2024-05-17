@extends('layouts.admin')
@php
    $dir = asset(Storage::url('uploads/plan'));
    $settings = Utility::settings();
@endphp
@push('script-page')
@endpush
@section('page-title')
    {{ __('Plan') }}
@endsection
@section('title')
    {{ __('Plan') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Plan') }}</li>
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'super admin')
        <div class="action-btn ms-2">
            <a href="#" data-url="{{ route('plan.create') }}" data-size="md" data-ajax-popup="true"
                data-bs-toggle="tooltip" data-title="{{ __('Create New Plan') }}"title="{{ __('Create') }}"
                class="btn btn-sm btn-primary btn-icon m-1">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endif
@endsection
@section('content')

    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                    style="
               visibility: visible;
               animation-delay: 0.2s;
               animation-name: fadeInUp;
               ">
                    <div class="card-body {{ !empty(\Auth::user()->type != 'super admin') ? 'plan-box' : '' }}"
                        style="height: 407px;">
                        <span class="price-badge bg-primary">{{ $plan->name }}</span>
                        @if (\Auth::user()->type == 'super admin')
                            <div class="d-flex flex-row-reverse m-0 p-0 ">
                                <div class="action-btn bg-primary ms-2">
                                    <a title="Edit Plan" data-size="md" href="#"
                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                        data-url="{{ route('plan.edit', $plan->id) }}" data-ajax-popup="true"
                                        data-title="{{ __('Edit Plan') }}" data-bs-toggle="tooltip"
                                        data-bs-original-title="{{ __('Edit') }}"><i class="ti ti-edit"></i></a>
                                </div>
                            </div>
                        @endif
                        @if (\Auth::user()->type == 'owner' && \Auth::user()->plan == $plan->id)
                            <div class="d-flex flex-row-reverse m-0 p-0 ">
                                <span class="d-flex align-items-center ">
                                    <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                    <span class="ms-2">{{ __('Active') }}</span>
                                </span>
                            </div>
                        @endif

                        <h1 class="mb-4 f-w-600 ">
                            {{ $settings['site_currency_symbol'] ? env('CURRENCY_SYMBOL') : '$' }}{{ number_format($plan->price) }}<small
                                class="text-sm">/{{ env('CURRENCY_SYMBOL') . __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</small>
                                
                        </h1>
                        {{-- <p class="mb-0">
                        {{$plan->name}}<br/>
                    </p> --}}
                        <p class="my-4">{{ $plan->description }}</p>

                        <ul class="list-unstyled">
                            <li> <span class="theme-avtar"><i
                                        class="text-primary ti ti-circle-plus"></i></span>{{ $plan->max_user == -1 ? __('Unlimited') : $plan->max_user}}
                                {{ __('Users') }}</li>
                            <li><span class="theme-avtar"><i
                                        class="text-primary ti ti-circle-plus"></i></span>{{ $plan->max_account == -1 ? __('Unlimited') : $plan->max_account}}
                                {{ __('Account') }}</li>
                            <li><span class="theme-avtar"><i
                                        class="text-primary ti ti-circle-plus"></i></span>{{ $plan->max_contact == -1 ? __('Unlimited') : $plan->max_contact}}
                                {{ __('Contact') }}</li>
                            <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                        class="text-primary ti ti-circle-plus"></i></span>{{ $plan->storage_limit == -1 ? __('Unlimited') : $plan->storage_limit }}
                                {{ __('MB') }} {{ __('Storage') }}</li>
                            <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                        class="text-primary ti ti-circle-plus"></i></span>{{ $plan->enable_chatgpt == 'on' ? __('Enable') : __('Disable') }}
                                {{ __('Chat GPT') }}</li>

                        </ul>
                        <br>
                        <div class=" row ">
                            <div class="col-8">
                                @if ($plan->id != \Auth::user()->plan && \Auth::user()->type != 'super admin')
                                    @if ($plan->price > 0)
                                        {{-- <button class="btn btn-primary d-flex justify-content-center align-items-center w-100"> --}}
                                        <a href="{{ route('plan.payment', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                            id="interested_plan_2"
                                            class="btn btn-primary d-flex justify-content-center align-items-center">
                                            <i class="ti ti-shopping-cart m-1 text-white"></i>{{ __('Subscribe') }}
                                        </a>
                                        {{-- </button> --}}
                                    @endif
                                @endif
                            </div>
                            <div class="col-4">

                                @if (\Auth::user()->type != 'super admin' && \Auth::user()->plan != $plan->id)
                                    @if ($plan->id != 1)
                                        @if (\Auth::user()->requested_plan != $plan->id)
                                            <a href="{{ route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}"
                                                class="btn btn-primary btn-icon m-1" data-title="{{ __('Send Request') }}"
                                                title="{{ __('Send Request') }}" data-bs-toggle="tooltip">
                                                <span class="btn-inner--icon"><i class="ti ti-corner-up-right"></i></span>

                                            </a>
                                        @else
                                            <a href="{{ route('request.cancel', \Auth::user()->id) }}"
                                                class="btn btn-danger btn-icon m-1" data-title="{{ __('Cancle Request') }}"
                                                title="{{ __('Cancle Request') }}" data-bs-toggle="tooltip">
                                                <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>


                        @if (\Auth::user()->type == 'owner' && \Auth::user()->plan == $plan->id)
                            <p class="server-plan ">
                                {{ __('Expired : ') }}
                                {{ \Auth::user()->plan_expire_date ? \Auth::user()->dateFormat(\Auth::user()->plan_expire_date) : __('lifetime') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
