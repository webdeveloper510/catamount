@php
$users = \Auth::user();
// $profile = asset(Storage::url('upload/profile/'));
$profile = \App\Models\Utility::get_file('upload/profile/');
$unseenCounter = App\Models\ChMessage::where('to_id', Auth::user()->id)
->where('seen', 0)
->count();
$lang = isset($users->lang) ? $users->lang : 'en';
if ($lang == null) {
$lang = 'en';
}
$LangName = \App\Models\Languages::where('code', $lang)->first();
if (empty($LangName)) {
$LangName = new App\Models\Utility();
$LangName->fullName = 'English';
}
$logo=\App\Models\Utility::get_file('uploads/logo/');


$company_logo = \App\Models\Utility::GetLogo();

$users = \Auth::user();
$currantLang = $users->currentLanguage();
$emailTemplate = App\Models\EmailTemplate::getemailtemplate();
$defaultView = App\Models\UserDefualtView::select('module','route')->where('user_id', $users->id)->get()->pluck('route',
'module')->toArray();

@endphp

@if (isset($settings['cust_theme_bg']) && $settings['cust_theme_bg'] == 'on')
<style>
@media screen and (max-width: 1024px) {
    li.dash-item.active a span.dash-mtext {
        color: #0e0e0e !important;

    }
}
</style>
<div class="outer-layout">
    <header class="dash-header transprent-bg">
        @else
        <header class="dash-header">
            @endif
            <div class="new_header">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li class="active">
                                    <button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"
                                        style=" background: #dbdbdb;"> <span class="navbar-toggler-icon"></span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="mobile collapse navbar-collapse" id="navbarCollapse">
                            <div class="navbar-nav">
                                <ul class="dash-navbar">
                                    <li
                                        class="dash-item {{ \Request::route()->getName() == 'dashboard' ? ' active' : '' }}">
                                        <a href="{{ route('dashboard') }}" class="dash-link"><span
                                                class="dash-mtext">{{ __('Dashboard') }}</span></a>
                                    </li>
                                    @if(Gate::check('Manage Lead') || Gate::check('Manage Meeting') ||
                                    Gate::check('Manage User'))
                                    <li class="dash-item {{ \Request::route()->getName() == 'siteusers'||\Request::route()->getName() == 'customer.info' ||
                \Request::route()->getName() == 'event_customers'||
                \Request::route()->getName() == 'lead_customers' || \Request::route()->getName() ==
                'lead.userinfo'||\Request::route()->getName() ==
                'event.userinfo'||\Request::route()->getName()=='categ' ? ' active' : '' }}">
                                        <a href="{{route('siteusers')}}" class="dash-link">
                                            <span class="dash-mtext">{{ __('Customers') }}</span>
                                        </a>
                                    </li>

                                    @endif
                                    @if(\Auth::user()->type!='super admin')
                                    <li
                                        class="dash-item {{ \Request::route()->getName() == 'calendar-new' || \Request::route()->getName() == 'calendernew.index' ? ' active' : '' }}">
                                        <a href="{{ route('calendernew.index') }}" class="dash-link">
                                            <span class="dash-mtext">{{ __('Calendar') }}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @can('Manage Lead')
                                    <li
                                        class="dash-item {{ \Request::route()->getName() == 'lead.index' || \Request::route()->getName() == 'lead.edit' ? ' active' : '' }}">
                                        <a href="{{  array_key_exists('lead',$defaultView) ? route($defaultView['lead']) : route('lead.index') }}"
                                            class="dash-link">
                                            <span class="dash-mtext">{{ __('Leads') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('Manage Meeting')
                                    <li
                                        class="dash-item {{ \Request::route()->getName() == 'meeting.index' || \Request::route()->getName() == 'meeting.show' || \Request::route()->getName() == 'meeting.edit' ? ' active' : '' }}">
                                        <a href="{{ array_key_exists('meeting',$defaultView) ? route($defaultView['meeting']) : route('meeting.index') }}"
                                            class="dash-link">
                                            <span class="dash-mtext">{{ __('Events') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('Manage Report')
                                    <li
                                        class="dash-item {{ \Request::route()->getName() == 'billing' || \Request::route()->getName() == 'billing.index' ? ' active' : '' }}">
                                        <a href="{{ route('billing.index') }}" class="dash-link">
                                            <span class="dash-mtext">{{ __('Invoice') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('Manage Payment')
                                    <li
                                        class="dash-item {{ \Request::route()->getName() =='report.leadsanalytic' ||  \Request::route()->getName() =='report.eventanalytic'|| \Request::route()->getName() =='report.customersanalytic' || \Request::route()->getName() =='report.billinganalytic'? 'active' :'' }}">
                                        <a href="{{ route('report.leadsanalytic') }}" class="dash-link">
                                            <span class="dash-mtext">{{ __('Reports') }}</span></a>
                                    </li>
                                    @endcan
                                    @can('Manage Campaign')
                                    <li
                                        class="dash-item  {{ \Request::route()->getName() == 'customer.index' ||\Request::route()->getName() ==  'campaign-list' ? ' active' : '' }}">
                                        <a href="{{ route('customer.index') }}" class="dash-link">
                                            <span class="dash-mtext">{{ __('Campaigns') }}</span></a>
                                    </li>
                                    @endcan

                                    <li
                                        class="dash-item  {{ Request::route()->getName() == 'email.index' ? 'active' : '' }}">
                                        <a href="{{ route('email.index') }}" class="dash-link">
                                            <span class="dash-mtext">{{ __('Emails') }}</span></a>
                                    </li>
                                    <li
                                        class="dash-item  {{ (Request::route()->getName() == 'contracts.index' || Request::route()->getName() == 'contract.show') ? 'active' : '' }}">
                                        <a href="{{route('contracts.index')}}" class="dash-link"><span
                                                class="dash-mtext">{{__('Contracts')}}</span></a>
                                    </li>
                                    <li
                                        class="dash-item  {{ Request::route()->getName() == 'settings' ? 'active' : '' }}">
                                        <a href="{{ route('settings') }}" class="dash-link">
                                            <!-- <span class="dash-micon"><i class="ti ti-settings"></i></span> -->
                                            <span class="dash-mtext">{{ __('Settings') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="navbar-nav ">
                                <li class="dropdown dash-h-item drp-company">
                                    <a class="dash-head-link dropdown-toggle arrow-none me-0"
                                        data-target="#sidenav-main" data-bs-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="false" aria-expanded="false">
                                        <span class="theme-avtar">
                                            @php
                                            $profile = \App\Models\Utility::get_file('upload/profile/');
                                            @endphp
                                            @if (\Request::route()->getName() == 'chats')
                                            <img class="rounded-circle"
                                                src="{{ !empty($users->avatar) ? $users->avatar : 'avatar.png' }}"
                                                style="width:30px;">
                                            @else
                                            <img class="rounded-circle" @if ($users->avatar)
                                            src="{{ $profile }}{{ !empty($users->avatar) ? $users->avatar : 'avatar.png' }}"
                                            @else src="{{ $profile . 'avatar.png' }}" @endif
                                            alt="{{ $users->name }}"style="width:30px;">
                                            @endif
                                        </span>
                                        <span class="hide-mob ms-2">{{ __('Hi') }}, {{ $users->name }}</span>
                                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                                    </a>
                                    <div class="dropdown-menu dash-h-dropdown">

                                        <a href="{{ route('profile') }}" class="dropdown-item">
                                            <i class="ti ti-user"></i>
                                            <span>{{ __('Profile') }}</span>
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                                            class="dropdown-item">
                                            <i class="ti ti-power"></i>
                                            <span>{{ __('Logout') }}</span>
                                        </a>
                                        <form id="frm-logout" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </div>

                        </div>
                    </div>
                </nav>
            </div>

            <!-- <div class="header-wrapper">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled" >
                <li class="dash-h-item mob-hamburger">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin"
                        data-target="#sidenav-main"></a>
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="dropdown dash-h-item drp-company">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-target="#sidenav-main"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="theme-avtar">
                            @php
                                $profile = \App\Models\Utility::get_file('upload/profile/');
                            @endphp
                            @if (\Request::route()->getName() == 'chats')
                                <img class="rounded-circle"
                                    src="{{ !empty($users->avatar) ? $users->avatar : 'avatar.png' }}" style="width:30px;">
                            @else
                                <img class="rounded-circle"
                                    @if ($users->avatar) src="{{ $profile }}{{ !empty($users->avatar) ? $users->avatar : 'avatar.png' }}" @else src="{{ $profile . 'avatar.png' }}" @endif
                                                        alt="{{ $users->name }}"style="width:30px;">
                            @endif
                        </span>
                        <span class="hide-mob ms-2">{{ __('Hi') }}, {{ $users->name }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">

                        <a href="{{ route('profile') }}" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                            class="dropdown-item">
                            <i class="ti ti-power"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
            
            </ul>
        </div>
    </div> -->

        </header>

        @include('partials.admin.sidebar')

</div>