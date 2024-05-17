@extends('layouts.admin')
@section('page-title')
{{ __('Report') }}
@endsection
@section('title')
{{ __('Customer Analytics') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Report') }}</li>
<li class="breadcrumb-item">{{ __('Customer Analytics') }}</li>
@endsection
@section('action-btn')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="cardcard-body">

                <div class="collapse show float-end" id="collapseExample" style="">

                    {{ Form::open(['route' => ['report.customersanalytic'], 'method' => 'get']) }}
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
                                @foreach($customerstat as $stat)
                                <option value="{{$stat->status}}"  {{ isset($_GET['status']) && $stat->status == $_GET['status'] ? 'selected' : '' }}>{{App\Models\UserImport::$status[$stat->status]}}</option>
                                @endforeach
                            </select>
                            <!-- {{ Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control', 'style' => 'margin-left: 29px;']) }} -->
                        </div>
                        <div class=" new-ac">
                        <div class="action-btn bg-primary ">
                            <div class="new-btn ">
                                <button type="submit" class=" btn btn-sm align-items-center text-white"
                                    data-bs-toggle="tooltip" title="{{ __('Apply') }}" data-title="{{ __('Apply') }}"><i
                                        class="ti ti-search"></i></button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="action-btn bg-danger">
                            <div class="new-btn">
                                <a href="{{ route('report.customersanalytic') }}" data-bs-toggle="tooltip"
                                    title="{{ __('Reset') }}" data-title="{{ __('Reset') }}"
                                    class=" btn btn-sm align-items-center text-white"><i class="ti ti-refresh" style="    margin-right: 0px;" aria-hidden="true"></i></a>
                            </div>
                        </div>
</div>
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
                        <input type="hidden" value="{{ __('Customers Report') }}" id="filesname">
                        @endif

                        <div class="col">
                            {{ __('Report') }} : <h6>{{ __('Customer Summary') }}</h6>
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
                            <th scope="col" class="sort" data-sort="name">{{ __('Name') }}</th>
                            <th scope="col" class="sort" data-sort="budget">{{ __('Status') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Created By') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Type') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Phone') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Email') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Address') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Organization') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Created At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $result)

                            <tr>
                                <td>{{ ucfirst($result['name'])  }}</td>
                                <td>{{App\Models\UserImport::$status[$result['status']]}}</td>
                                <td>{{ucfirst(App\Models\User::where('id',$result['created_by'])->first()->name)}}</td>
                                <td>{{ ucfirst($result['category']) }}</td>
                                <td>{{ $result['phone'] }}</td>
                                <td>{{ $result['email'] }}</td>
                                <td> {{ $result['address'] }}</td>
                                <td>{{ $result['organization'] }}</td>
                                <td>{{ __(\Auth::user()->dateFormat($result['created_at'])) }}

                                </td>

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