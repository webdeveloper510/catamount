@extends('layouts.admin')
@section('page-title')
{{ __('Report') }}
@endsection
@section('title')
{{ __('Event Analytics') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Report') }}</li>
<li class="breadcrumb-item">{{ __('Event Analytics') }}</li>
@endsection
@section('action-btn')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="cardcard-body">

                <div class="collapse show float-end" id="collapseExample" style="">

                    {{ Form::open(['route' => ['report.eventanalytic'], 'method' => 'get']) }}
                    <div class="row filter-css">

                        <div class="col-auto">
                            {{ Form::month('start_month', isset($_GET['start_month']) ? $_GET['start_month'] : date('Y-01'), ['class' => 'form-control']) }}
                        </div>
                        <div class="col-auto">
                            {{ Form::month('end_month', isset($_GET['end_month']) ? $_GET['end_month'] : date('Y-12'), ['class' => 'form-control']) }}
                        </div>

                        <div class="col-auto" style="margin-left: -29px;">
                        <select name="status" id="status" class="form-control" style="margin-left: 29px;">
                                <option value="">Select Status</option>
                                @foreach($eventstatus as $stat)
                                <option value="{{$stat->status}}"  {{ isset($_GET['status']) && $stat->status == $_GET['status'] ? 'selected' : '' }}>{{App\Models\Meeting::$status[$stat->status]}}</option>
                                @endforeach
                            </select>
                            <!-- {{ Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control', 'style' => 'margin-left: 29px;']) }} -->
                        </div>
                        <div class=" new-ac">
                        <div class="action-btn bg-primary ">
                            
                            <div class="new-btn ">
                                <button type="submit" class="btn btn-sm align-items-center text-white"
                                    data-bs-toggle="tooltip" title="{{ __('Apply') }}" data-title="{{ __('Apply') }}"><i
                                        class="ti ti-search"></i></button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="action-btn bg-danger ">
                            <div class="new-btn">
                                <a href="{{ route('report.leadsanalytic') }}" data-bs-toggle="tooltip"
                                    title="{{ __('Reset') }}" data-title="{{ __('Reset') }}"
                                    class=" btn btn-sm align-items-center text-white"><i class="ti ti-refresh" style="    margin-right: 0px;" aria-hidden="true"></i></a>
                            </div>
                        </div>
</div>
                        <!-- <div class="action-btn bg-primary ms-2">
                            <div class="col-auto">
                                <a href="#" onclick="saveAsPDF();" class="mx-3 btn btn-sm align-items-center text-white"
                                    data-bs-toggle="tooltip" data-title="{{ __('Download') }}"
                                    title="{{ __('Download') }}" id="download-buttons">
                                    <i class="ti ti-download"></i>
                                </a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="printableArea">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <dl class="row">
                        @if (isset($report['startDateRange']) || isset($report['endDateRange']))
                        <input type="hidden"
                            value="{{ __('Event Report of') . ' ' . $report['startDateRange'] . ' to ' . $report['endDateRange'] }}"
                            id="filesname">
                        @else
                        <input type="hidden" value="{{ __('Event Report') }}" id="filesname">
                        @endif

                        <div class="col">
                            {{ __('Report') }} : <h6>{{ __('Event Summary') }}</h6>
                        </div>
                        <div class="col">
                            {{ __('Duration') }} : <h6>
                                {{ $report['startDateRange'] . ' to ' . $report['endDateRange'] }}
                            </h6>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="report-chart"></div>
            </div>
        </div>
    </div> -->


</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div>
                    <button class="btn btn-light-primary btn-sm csv">Export CSV</button>
                    {{-- <button class="btn btn-light-primary btn-sm sql">Export SQL</button> --}}
                    {{--<button class="btn btn-light-primary btn-sm txt">Export TXT</button> --}}
                    {{-- <button class="btn btn-light-primary btn-sm json">Export JSON</button>
                        <button class="btn btn-light-primary btn-sm excel">Export Excel</button>
                        <button class="btn btn-light-primary btn-sm pdf">Export pdf</button> --}}
                </div>
                <div class="table-responsive mt-3">
                    <table class="table" id="pc-dt-export">
                        <thead>
                            <tr>
                            <th scope="col" class="sort" data-sort="budget">{{ __(' Status') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Name') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Created By') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Type') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Phone') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Email') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Date') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Assigned Staff') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Rooms required') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Function') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Comments') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Invoice Created') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Payment Status') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Total Amount') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Adjustments') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Late Fee') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Amount Paid') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Due Amount') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Created At') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Invoice view') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $result)
                            <?php $invoice = App\Models\Billing::where('event_id',$result['id'])->exists(); ?>
                            <tr>
                            <td> {{ __(\App\Models\Meeting::$status[$result['status']]) }}</td>

                                <td>{{ ucfirst($result['name'])  }}</td>
                                <td>{{ucfirst(App\Models\User::where('id',$result['created_by'])->first()->name)}}</td>
                                <td>{{ ucfirst($result['type']) }}</td>
                                <td>{{ $result['phone'] }}</td>
                                <td>{{ $result['email'] }}</td>
                                <td> @if($result['start_date'] == $result['end_date'])
                                    {{ \Auth::user()->dateFormat($result['start_date']) }}
                                    @else
                                    {{ \Auth::user()->dateFormat($result['start_date']) }} -
                                    {{ \Auth::user()->dateFormat($result['end_date'])}}
                                    @endif</td>
                                <td>{{!empty($result['assign_user'])? $result['assign_user']->name:'--' }}
                                    ({{$result['assign_user']->type}})</td>
                                <td>{{$result['room']}}</td>
                                <td>{{ isset($result['function']) ? ucfirst($result['function']) : '--' }}</td>
                                <td><?php $comment = App\Models\Agreement::where('event_id',$result['id'])->orderby('id','desc')->first(); ?>
                                    @if(isset($comment) && !empty($comment))
                                    {{App\Models\Agreement::where('event_id',$result['id'])->orderby('id','desc')->first()->notes}}
                                    @else -- @endif</td>
                                <td>
                                @if($invoice) Yes @else No @endif
                            </td>
                                <td>
                                    <?php 
                                    $paymentLog = App\Models\PaymentLogs::where('event_id', $result['id'])->orderBy('id', 'desc')->first();
                                    $paymentInfo = App\Models\PaymentInfo::where('event_id', $result['id'])->orderBy('id', 'desc')->first();
                                ?>
                                    @if($paymentLog && $paymentInfo)
                                    @if($paymentLog->amount < $paymentInfo->amounttobepaid && $paymentLog->amount != 0)
                                        Partially Paid
                                        @else
                                        Completed
                                        @endif
                                        @else
                                        No Payment
                                        @endif
                                </td>
                                <td>@if($result['total'] != 0) 
                                    ${{$result['total']}} 
                                    @else {{ __('Invoice Not Created') }}
                                    @endif
                                </td>
                               
                                
                                <td>
                                    @if($paymentInfo)
                                        ${{$paymentInfo->adjustments}}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td>
                                    @if($paymentInfo )
                                    ${{$paymentInfo->latefee}}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td>
                                    @if($paymentLog)
                                    ${{$paymentLog->amount}}

                                    @else
                                    --
                                    @endif
                                </td>
                                <td> @if($paymentLog && $paymentInfo)
                                    ${{ $paymentInfo->amounttobepaid - $paymentLog->amount}}
                                    @else
                                    --
                                    @endif </td>
                                <td>{{ __(\Auth::user()->dateFormat($result['created_at'])) }}

                                </td>
                                <td>  @if($invoice) <a href="{{ route('billing.estimateview',urlencode(encrypt($result['id'])))}}"style="color: #1551c9 !important;"> 
               {{ __('View Invoice') }}
            @else  No Invoice @endif</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    @push('script-page')

    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

    <script>
    $(document).ready(function() {
        $('#pc-dt-export').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    $('row c[r^="C"]', sheet).attr('s', '2');
                }
            }]
        });
    });
    </script>

    <script>
    const table = new simpleDatatables.DataTable("#pc-dt-export");
    document.querySelector("button.csv").addEventListener("click", () => {
        table.export({
            type: "csv",
            download: true,
            lineDelimiter: "\n\n",
            columnDelimiter: ";"
        })
    })
    document.querySelector("button.txt").addEventListener("click", () => {
        table.export({
            type: "txt",
            download: true,
        })
    })
    document.querySelector("button.sql").addEventListener("click", () => {
        table.export({
            type: "sql",
            download: true,
            tableName: "export_table"
        })
    })

    document.querySelector("button.json").addEventListener("click", () => {
        table.export({
            type: "json",
            download: true,
            escapeHTML: true,
            space: 3
        })
    })
    document.querySelector("button.excel").addEventListener("click", () => {
        table.export({
            type: "excel",
            download: true,

        })
    })
    document.querySelector("button.pdf").addEventListener("click", () => {
        table.export({
            type: "pdf",
            download: true,
        })
    })
    </script>


    <script>
    $(document).ready(function() {
        var filename = $('#filename').val();
        setTimeout(function() {
            $('#pc-dt-export').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: filename
                }, {
                    extend: 'csvHtml5',
                    title: filename
                }, {
                    extend: 'pdfHtml5',
                    title: filename
                }, ],

            });
        }, 500);

    });
    </script>

    <script>
    var filename = $('#filesname').val();

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: filename,
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'A2'
            }
        };
        html2pdf().set(opt).from(element).save();
    }
    </script>


    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>

    <script>
    var WorkedHoursChart = (function() {
        var $chart = $('#report-chart');

        (function() {
            var options = {
                chart: {
                    height: 180,
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
                    name: 'Lead',
                    data: {
                        !!json_encode($data) !!
                    },
                }],
                xaxis: {
                    categories: {
                        !!json_encode($labels) !!
                    },
                    title: {
                        text: '{{ __('
                        Lead ') }}'
                    },
                },
                colors: ['#3ec9d6', '#FF3A6E'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },

            };
            var chart = new ApexCharts(document.querySelector("#report-chart"), options);
            chart.render();
        })();



        // Events
        if ($chart.length) {
            $chart.each(function() {
                init($(this));
            });
        }
    })();
    </script>
    @endpush