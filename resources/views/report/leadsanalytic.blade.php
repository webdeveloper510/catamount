@extends('layouts.admin')
@section('page-title')
{{ __('Report') }}
@endsection
@section('title')
{{ __('Lead Analytics') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Report') }}</li>
<li class="breadcrumb-item">{{ __('Lead Analytics') }}</li>
@endsection
@section('action-btn')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="cardcard-body">

                <div class="collapse show float-end2" id="collapseExample" style="">

                    {{ Form::open(['route' => ['report.leadsanalytic'], 'method' => 'get']) }}
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
                                @foreach($leadstatus as $stat)
                                <option value="{{$stat->status}}"
                                    {{ isset($_GET['status']) && $stat->status == $_GET['status'] ? 'selected' : '' }}>
                                    {{App\Models\Lead::$status[$stat->status]}}</option>
                                @endforeach
                            </select>
                            <!-- {{ Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control', 'style' => 'margin-left: 29px;']) }} -->
                        </div>
                        <!-- <div class="c"> -->
                        <div class=" new-ac">
                            <div class="action-btn bg-primary ">
                                <div class="new-btn">
                                    <button type="submit" class=" btn btn-sm align-items-center text-white"
                                        data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                        data-title="{{ __('Apply') }}"><i class="ti ti-search"></i></button>
                                </div>
                            </div>
                            {{ Form::close() }}
                            <div class="action-btn bg-danger ">
                                <div class="new-btn">
                                    <a href="{{ route('report.leadsanalytic') }}" data-bs-toggle="tooltip"
                                        title="{{ __('Reset') }}" data-title="{{ __('Reset') }}"
                                        class=" btn btn-sm align-items-center text-white"><i class="ti ti-refresh"
                                            style="    margin-right: 0px;" aria-hidden="true"></i></a>
                                </div>
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
                    <dl class="row d">
                        @if (isset($report['startDateRange']) || isset($report['endDateRange']))
                        <input type="hidden"
                            value="{{ __('Lead Report of') . ' ' . $report['startDateRange'] . ' to ' . $report['endDateRange'] }}"
                            id="filesname">
                        @else
                        <input type="hidden" value="{{ __('Lead Report') }}" id="filesname">
                        @endif

                        <div class="col-md-6 need_full">
                            {{ __('Report') }} : <h6>{{ __('Lead Summary') }}</h6>
                        </div>
                        <div class="col-md-6 need_full">
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
                    {{--<button class="btn btn-light-primary btn-sm txt">Export TXT</button> 
                     <button class="btn btn-light-primary btn-sm json">Export JSON</button>
                       <button class="btn btn-light-primary btn-sm excel">Export Excel</button>
                        <button class="btn btn-light-primary btn-sm pdf">Export pdf</button> --}}
                </div>
                <div class="table-responsive mt-3">
                    <table class="table datatable" id="pc-dt-export">
                        <thead>
                            <tr>
                                <th scope="col" class="sort" data-sort="name">{{ __('Name') }}</th>
                                <th scope="col" class="sort" data-sort="budget">{{ __(' Lead Status') }} <span
                                        class="opticy"> dddd</span> </th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Status') }} <span class="opticy">
                                        dddd</span> </th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Created By') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Type') }} <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Phone') }}<span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Email') }}<span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Date') }} <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Time') }} <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Assigned Staff') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Rooms required') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Bar') }} <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Bar Package') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Function') }} <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Package') }} <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Additional Items') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Any Special Requests') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Guest Count') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Converted To Event') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Created At') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Comments') }} <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Proposal Signed By Customer') }}
                                    <span class="opticy"> dddd</span>
                                </th>
                                <th scope="col" class="sort" data-sort="budget">{{ __('Any Attachments') }} <span
                                        class="opticy"> dddd</span></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leads as $result)
                            <?php $event = App\Models\Meeting::where('attendees_lead',$result['id'])->exists();
                           ?>
                            <tr>
                                <td>
                                    <a href="{{ route('lead.info',urlencode(encrypt($result['id']))) }}" data-size="md"
                                        title="{{ __('Lead Details') }}" class="action-item text-primary"
                                        style="color:#1551c9 !important;">
                                        <b> {{ ucfirst($result['name'])  }}</b>
                                    </a>
                                </td>
                                <td> {{ __(\App\Models\Lead::$stat[$result->lead_status]) }} <span
                                        class="empytu"></span></td>
                                <td> {{ __(\App\Models\Lead::$status[$result['status']]) }} <span class="empytu"></span>
                                </td>

                                <td>{{ucfirst(App\Models\User::where('id',$result['created_by'])->first()->name)}} <span
                                        class="empytu"></span></td>
                                <td>{{ ucfirst($result['type']) }} <span class="empytu"></span></td>
                                <td>{{ $result['phone'] }} <span class="empytu"></span></td>
                                <td>{{ $result['email'] }} <span class="empytu"></span></td>
                                <td> @if($result['start_date'] == $result['end_date'])
                                    {{ \Auth::user()->dateFormat($result['start_date']) }}
                                    @else
                                    {{ \Auth::user()->dateFormat($result['start_date']) }} -
                                    {{ \Auth::user()->dateFormat($result['end_date'])}}
                                    @endif <span class="empytu"></span></td>
                                <td> @if($result['start_time'] == $result['end_time'])
                                    --
                                    @else
                                    {{date('h:i A', strtotime($result['start_time']))}} -
                                    {{date('h:i A', strtotime($result['end_time']))}}
                                    @endif <span class="empytu"></span></td>
                                <td>{{!empty($result['assign_user'])? $result['assign_user']->name :'Not Assigned Yet' }}
                                    {{!empty($result['assign_user'])?'('.$result['assign_user']->type.')':''}}</td>
                                <td>{{$result['rooms']}} <span class="empytu"></span></td>
                                <td>{{$result['bar'] ?? '--' }} <span class="empytu"></span></td>
                                <td><?php $barpackage = json_decode($result['bar_package'],true);
                                    if(isset($barpackage) && !empty($barpackage)){
                                            echo implode(',',$barpackage);
                                    }else{
                                        echo '--';
                                    }     
                                ?> <span class="empytu"></span></td>
                                <td>{{ isset($result['function'])&& !empty($result['function']) ? ucfirst($result['function']) : '--' }}
                                    <span class="empytu"></span>
                                </td>
                                <td><?php $package = json_decode($result['func_package'],true);
                                 if(isset($package) && !empty($package)){
                                                    foreach ($package as $key => $value) {
                                                        echo implode(',',$value);
                                                    } 
                                                }
                                                ?> <span class="empytu"></span></td>
                                <td> <?php
                                 if(isset($additional) && !empty($additional)){
                                     $additional = json_decode($result['ad_opts'],true);
                                                    foreach ($additional as $key => $value) {
                                                        echo implode(',',$value);
                                                    } 
                                                }
                                ?> <span class="empytu"></span></td>
                                <td>{{$result['spcl_req'] ?? '--'}} <span class="empytu"></span></td>
                                <td>{{$result['guest_count']}} <span class="empytu"></span></td>
                                <td>

                                    @if($event) Yes @else No @endif
                                </td>
                                <td>{{ __(\Auth::user()->dateFormat($result['created_at'])) }}</td>
                                <td><?php $comment = App\Models\Proposal::where('lead_id',$result['id'])->orderby('id','desc')->first(); ?>
                                    @if(isset($comment) && !empty($comment))
                                    {{$comment->notes}}
                                    @else -- @endif
                                    <span class="empytu"></span>
                                </td>
                                <td><?php $prop = App\Models\Proposal::where('lead_id',$result['id'])->orderby('id','desc')->exists(); ?>
                                    @if($prop) Yes @else No @endif
                                    <span class="empytu"></span>
                                </td>
                                <td><?php  $attachment=   App\Models\LeadDoc::where('lead_id',$result['id'])->get();?>
                                    @if($attachment)
                                    @foreach ($attachment as $attach)
                                    @if(Storage::disk('public')->exists($attach->filepath))

                                    <a href="{{ Storage::url('app/public/'.$attach->filepath) }}" download
                                        style="color: teal;" title="Download">{{$attach->filename}}</a>
                                    @endif
                                    @endforeach
                                    @endif

                                    <span class="empytu"></span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('script-page')

    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jszip.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/buttons.html5.min.js')}}"></script>


    <script src="../assets/js/plugins/simple-datatables.js"></script>
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
    <script>
    $(document).ready(function() {
        var startMonthInput = $('input[name = "start_month"]').val();
        var endMonthInput = $('input[name = "end_month"]').val();
        endMonthInput.addEventListener('change', function() {
            // Parse the values to compare
            var startMonth = new Date(startMonthInput.value);
            var endMonth = new Date(endMonthInput.value);
            if (startMonth > endMonth) {
                startMonthInput.value = endMonthInput.value;
            }
        });
    })
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
    <style>
    span.opticy {
        opacity: 0;
    }
    </style>