@extends('layouts.admin')
@push('script-page')
    <script>
        EngagementChart = function () {
            var e = $("#plan_order");
            e.length && e.each(function () {

                (function () {
                    var options = {
                        chart: {
                            height: 150,
                            type: 'area',
                            toolbar: {
                                show: false,
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 2,
                            curve: 'smooth'
                        },
                        series: [{
                            name: "{{__('Order')}}",
                            data: {!! json_encode($chartData['data']) !!}
                        }],
                        xaxis: {
                            categories: {!! json_encode($chartData['label']) !!},
                            title: {
                            text: '{{ __("Days") }}'
                            }
                        },
                        colors: ['#453b85'],

                        grid: {
                            strokeDashArray: 4,
                        },
                        legend: {
                            show: false,
                        },
                        
                        yaxis: {
                            tickAmount: 3,
                            min: 10,
                            max: 70,
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#plan_order"), options);
                    chart.render();
                })();
                
            })
        }()
    </script>
@endpush
@section('page-title')
    {{__('Dashboard')}}
@endsection
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('breadcrumb')
  
@endsection
@section('content')

    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-7">
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-info mb-3">
                                        <i class="ti ti-user"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"> {{__('Total Users')}} : <span class="text-dark">{{$user->total_user}}</span></p>
                                    <h6 class="mb-3">{{__('Paid Users')}}</h6>
                                    <h3 class="mb-0">{{$user['total_paid_user']}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-warning mb-3">
                                        <i class="ti ti-shopping-cart-plus"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"> {{__('Total Orders')}} : <span class="text-dark">{{$user->total_orders}}</span></p>
                                    <h6 class="mb-3">{{__('Total Order Amount')}}</h6>
                                    <h3 class="mb-0">{{env("CURRENCY_SYMBOL").$user['total_orders_price']}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-danger mb-3">
                                        <i class="ti ti-award"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{__('Total Plans')}} : <span class="text-dark">{{env("CURRENCY_SYMBOL").$user['total_orders_price']}}</span></p>
                                    <h6 class="mb-3">{{__('Most Purchase Plan')}}</h6>
                                    <h3 class="mb-0">{{!empty($user['most_purchese_plan'])?$user['most_purchese_plan']:'-'}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Recent Order') }}</h5>
                        </div>
                        <div class="card-body">
                            <div id="plan_order" data-color="primary" data-height="230"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection

