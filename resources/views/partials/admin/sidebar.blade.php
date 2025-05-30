<?php

use Spatie\Permission\Models\Role;
use App\Models\PowerBiReport;

$settings = App\Models\Utility::settings();
//$category= explode(',',$settings['campaign_type']);
$powerBiReports = PowerBiReport::all();
?>

<style>
    #powerbi-report-dropdown {
        display: none;
        width: 100%;
    }

    #powerbi-report-dropdown.show {
        display: block;
    }
</style>

<div id="sidebar-wrapper">
    <div class="card">
        <div class="list-group list-group-flush sidebar-nav nav-pills nav-stacked" id="menu">
            <div class="navbar-brand-box">
                <a href="#" class="navbar-brand">
                    <img src="{{$logo.'3_logo-light.png'}}" alt="{{ config('app.name', 'The Sector Eight') }}" class="logo logo-lg nav-sidebar-logo" height="50" />
                </a>
            </div>
            <div class="scrollbar">
                @if(\Request::route()->getName() == 'lead.review')
                <a href="#useradd-1" class="list-group-item list-group-item-action border-0">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-home-2"></i></span>
                    <span class="dash-mtext">{{ __('Review Lead') }}</span>
                    <!-- <div class="float-end"><i class="ti ti-chevron-right"></i></div> -->
                </a>
                @endif
                @if(\Request::route()->getName() == 'dashboard')
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="ti ti-home-2"></i></span>
                    <span class="dash-mtext">{{ __('Dashboard') }} </span></a>
                </a>
                @endif
                @if(\Request::route()->getName() == 'settings')
                @if (\Auth::user()->type == 'owner')
                <a href="#company-email-setting" class="list-group-item list-group-item-action" data-id="collapse_01"
                    onclick="showAccordion('collapse_01')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-file-invoice"></i></span>
                    <span class="dash-mtext">{{ __('Contract Settings') }}</span>
                </a>

                <a href="#company-email-setting" class="list-group-item list-group-item-action" data-id="collapse16" onclick="showAccordion('collapse16')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-envelope"></i></span>
                    <span class="dash-mtext">{{ __('Email') }}</span>
                </a>

                <!-- <a href="javascript:void(0);" class="list-group-item list-group-item-action" data-id="collapse16"
                    onclick="toggleCollapse(this.getAttribute('data-id'))">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-envelope  "></i></span>
                    <span class="dash-mtext">{{ __('Email') }} </span></a>
                </a> -->
                <a href="#twilio-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse15')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-sms"></i></span>
                    <span class="dash-mtext">{{ __('Twilio') }}</span>
                </a>
                @endif
                @if (\Auth::user()->type == 'super admin')
                <a href="#recaptcha-settings" class="list-group-item list-group-item-action border-0">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-cog"></i></span>
                    <span class="dash-mtext">{{ __('Recaptcha') }}</span>
                </a>
                @endif
                @can('Manage User')
                <a href="#proposal-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse188')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-user"></i></span>
                    <span class="dash-mtext">{{ __('Proposal') }}</span>
                </a>
                @endcan
                @can('Manage User')
                <a href="#user-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse17')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-user"></i></span>
                    <span class="dash-mtext">{{ __('Staff') }}</span>
                </a>
                @endcan
                @can('Manage Role')
                <a href="#role-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse18')">
                    <span class="fa-stack fa-lg pull-left"><img src="{{asset('icons/user.png')}}" alt="" style="    width: 22px;"></span>
                    <span class="dash-mtext">{{ __('Role') }}</span>
                </a>
                @endif
                @if(Gate::check('Manage Lead') || Gate::check('Manage Training'))
                <a href="#eventsettings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext">{{ __('Trainings') }}</span>
                </a>

                <!-- <a href="#venue-settings" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><img src="{{asset('icons/location.png')}}" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext">{{ __('Location') }}</span>
                </a>
                <a href="#function-settings" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><img src="{{asset('icons/restaurant.png')}}" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext">{{ __('Function') }}</span>
                </a>
                <a href="#bar-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><i class="fas fa-cocktail"></i></span>
                    <span class="dash-mtext">{{ __('Bar') }}</span>
                </a>
                <a href="#floor-plan-setting" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><img src="{{asset('icons/roadmap.png')}}" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext">{{ __('Setup') }}</span>
                </a> -->
                @endif
                @can('Manage Payment')
                <a href="#billing-setting" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse20')">
                    <span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span>
                    <span class="dash-mtext">{{ __('Invoice') }}</span>
                </a>
                @endcan
                @if (\Auth::user()->type == 'owner')
                <a href="#buffer-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse21')">
                    <span class="fa-stack fa-lg pull-left"><img src="{{asset('icons/loading.png')}}" alt="" style="width: 22px;"></span>
                    <span class="dash-mtext">{{ __('Buffer') }}</span>
                </a>
                <a href="#add-signature" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse22')">
                    <span class="fa-stack fa-lg pull-left"><img src="{{asset('icons/signature.png')}}" alt="" style="    width: 22px;"></span>
                    <span class="dash-mtext">{{ __('Authorised Signature') }}</span>
                </a>
                <a href="#power-bi" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse222')">
                    <span class="fa-stack fa-lg pull-left"><img src="{{asset('icons/power-bi.png')}}" alt="" style="    width: 22px;"></span>
                    <span class="dash-mtext">{{ __('Power BI') }}</span>
                </a>
                @endif
                @endif
                @if(\Request::route()->getName() == 'billing.index' || \Request::route()->getName() == 'billing.quick_create_invoice')
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span><span class="dash-mtext">{{ __('Invoice') }} </span></a>
                <a href="{{route('billing.quick_create_invoice')}}" class="list-group-item list-group-item-action  @if(\Request::route()->getName() == 'billing.quick_create_invoice') active @endif" ><span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span><span class="dash-mtext">{{ __('Quick invoice') }} </span></a>
                @endif
                @if(\Request::route()->getName() == 'calendernew.index')
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-calendar"></i></span>
                    <span class="dash-mtext">{{ __('Calender') }} </span></a>
                @endif

                @if(\Request::route()->getName() == 'billing.create')
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span>
                    <span class="dash-mtext">{{ __('Create Invoice') }} </span></a>
                @endif
                @if(\Request::route()->getName() == 'customer.index' || \Request::route()->getName() == 'campaign-list')
                <a href="{{route('customer.index')}}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'customer.index' ?'active' : ''}}">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-bullhorn"></i></span>
                    <span class="dash-mtext">{{ __('Campaign') }} </span></a>
                <a href="{{route('campaign-list')}}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'campaign-list' ?'active' : ''}}">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-list"></i></span>
                    <span class="dash-mtext">{{ __('View Campaigns') }} </span></a>
                @endif
                @if(\Request::route()->getName() == 'customer.info' ||
                \Request::route()->getName() == 'event_customers'||\Request::route()->getName() == 'siteusers' ||
                \Request::route()->getName() == 'lead_customers' || \Request::route()->getName() ==
                'lead.userinfo'||\Request::route()->getName() ==
                'event.userinfo'||\Request::route()->getName()=='categ')
                <a href="{{route('siteusers')}}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'siteusers' ?'active' : ''}}">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-users"></i></span>
                    <span class="dash-mtext">{{ __('All Clients') }} </span></a>

                <a href="{{route('event_customers')}}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'event_customers' ?'active' : ''}}">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-user" title="Training Clients"></i></span>
                    <span class="dash-mtext">{{ __('Trainings') }} </span></a>
                <a href="{{route('lead_customers')}}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'lead_customers' ?'active' : ''}}">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-user" title="Lead Clients"></i></span>
                    <span class="dash-mtext">{{ __('Leads') }} </span></a>

                {{--@if(isset($category) && !empty($category))
                @foreach($category as $cat)
                <a href="{{route('categ', $cat)}}" class="list-group-item list-group-item-action">
                <span class="fa-stack fa-lg pull-left"><i class="ti ti-user" title="{{$cat}}"></i></span>
                <span class="dash-mtext">{{ $cat }} </span></a>
                @endforeach
                @endif--}}
                @endif

                @if(\Request::route()->getName() == 'meeting.index')
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext">{{ __('Trainings') }} </span></a>

                </a>
                @endif
                @if( \Request::route()->getName() == 'report.index' || \Request::route()->getName() == 'report.show' ||
                \Request::route()->getName() == 'report.edit' || \Request::route()->getName() == 'report.leadsanalytic'
                ||
                \Request::route()->getName() == 'report.eventanalytic' || \Request::route()->getName() ==
                'report.customersanalytic' || \Request::route()->getName() == 'report.billinganalytic' ? ' active ' :
                '' || request()->segment(1) == 'powerbi')

                <a href="{{ route('report.leadsanalytic') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'report.leadsanalytic' ?'active' : ''}}"><span class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext">{{ __('Leads') }} </span></a>

                </a>

                <a href="{{ route('report.eventanalytic') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'report.eventanalytic' ?'active' : ''}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext">{{ __('Trainings') }} </span></a>

                </a>
                <a href="{{ route('report.customersanalytic') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'report.customersanalytic' ?'active' : ''}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-users"></i></span>
                    <span class="dash-mtext">{{ __('Clients') }} </span></a>

                </a>
                <a href="{{ route('report.billinganalytic') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'report.billinganalytic' ?'active' : ''}}"><span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span>
                    <span class="dash-mtext">{{ __('Financial') }} </span></a>

                </a>

                <!-- Power BI Reports -->
                <a href="#" id="powerbi-report-toggle" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left">
                        <i class="fas fa-chart-bar"></i>
                    </span>
                    <span class="dash-mtext">{{ __('BI Reports') }}</span>
                </a>

                <!-- Dropdown Menu -->
                <select id="powerbi-report-dropdown" class="form-select" style="display: none;">
                    <option value="" disabled selected>Select a report</option>
                    @foreach($powerBiReports as $report)
                    <option value="{{ $report->id }}">{{ $report->report_name }}</option>
                    @endforeach
                </select>
                @endif
                @if(\Request::route()->getName() == 'meeting.create' ||\Request::route()->getName() == 'meeting.edit' )
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext">{{ __('Training Details') }} </span></a>
                <!-- <a href="#event-details" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-info"></i></span>
                    <span class="dash-mtext">{{ __('Training Details') }} </span></a>
                <a href="#special_req" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"></span>
                    <span class="dash-mtext">{{ __('Special Requirements') }} </span></a>
                <a href="#other_info" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"></span>
                    <span class="dash-mtext">{{ __('Other Information') }} </span></a> -->
                @endif
                @if(\Request::route()->getName() == 'meeting.review' )
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext">{{ __('Review Training') }} </span></a>
                @endif
                @if(\Request::route()->getName() == 'lead.index' )
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext">{{ __('Leads') }} </span></a>
                </a>
                @endif
                @if(\Request::route()->getName() == 'lead.edit' )
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext">{{ __('Edit Lead') }} </span></a>
                </a>
                @endif
                @if(\Request::route()->getName() == 'lead.info')
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext">{{ __('Leads') }} </span></a>
                </a>
                @endif
                @if(\Request::route()->getName() == 'email.index' ||\Request::route()->getName() == 'email.details'||\Request::route()->getName() == 'email.conversations')
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <span class="dash-mtext">{{ __('Emails') }} </span></a>
                </a>
                @endif
                {{--@if(\Request::route()->getName() == 'contracts.index' ||\Request::route()->getName() == 'contracts.create')
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span class="fa-stack fa-lg pull-left"><i class="fa fa-file-contract"></i></span>
                    <span class="dash-mtext">{{ __('Contracts') }} </span></a>
                </a>
                @endif--}}
                <!-- <li
                    class="dash-item {{ \Request::route()->getName() == 'calendar' || \Request::route()->getName() == 'calendar.index' ? ' active' : '' }}">
                    <a href="{{ route('calendar.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="far fa-calendar-alt"></i></span><span
                            class="dash-mtext">{{ __('Calendar') }}</span>
                    </a>
                </li> -->
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showAccordion(dataId) {
        $('.accordion-collapse').css('display', 'none')
        if ($('#' + dataId).hasClass('show')) {
            $('#' + dataId).css('display', 'none');
            $('#' + dataId).removeClass('show');
        } else {
            $('#' + dataId).css('display', 'block');
            $('#' + dataId).addClass('show');
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#powerbi-report-toggle').click(function(event) {
            event.preventDefault();
            $('#powerbi-report-dropdown').toggle();
        });

        $('#powerbi-report-dropdown').change(function() {
            var reportId = $(this).val();
            if (reportId) {
                var baseUrl = "{{ url('/') }}";
                var encodedId = btoa(reportId);
                var url = baseUrl + '/powerbi/report/' + encodedId;
                console.log('Redirecting to URL:', url);
                window.location.href = url;
            }
        });
    });
</script>