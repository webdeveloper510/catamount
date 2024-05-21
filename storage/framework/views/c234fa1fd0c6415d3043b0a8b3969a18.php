<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(__('Lead Analytics')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Report')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Lead Analytics')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="cardcard-body">

                <div class="collapse show float-end2" id="collapseExample" style="">

                    <?php echo e(Form::open(['route' => ['report.leadsanalytic'], 'method' => 'get'])); ?>

                    <div class="row filter-css">

                        <div class="col-auto">
                            <?php echo e(Form::month('start_month', isset($_GET['start_month']) ? $_GET['start_month'] : date('Y-01'), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="col-auto">
                            <?php echo e(Form::month('end_month', isset($_GET['end_month']) ? $_GET['end_month'] : date('Y-12'), ['class' => 'form-control'])); ?>

                        </div>

                        <div class="col-auto" style="margin-left: -29px;">
                            <select name="status" id="status" class="form-control" style="margin-left: 29px;">
                                <option value="">Select Status</option>
                                <?php $__currentLoopData = $leadstatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($stat->status); ?>"
                                    <?php echo e(isset($_GET['status']) && $stat->status == $_GET['status'] ? 'selected' : ''); ?>>
                                    <?php echo e(App\Models\Lead::$status[$stat->status]); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <!-- <?php echo e(Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control', 'style' => 'margin-left: 29px;'])); ?> -->
                        </div>
                        <!-- <div class="c"> -->
                        <div class=" new-ac">
                            <div class="action-btn bg-primary ">
                                <div class="new-btn">
                                    <button type="submit" class=" btn btn-sm align-items-center text-white"
                                        data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                        data-title="<?php echo e(__('Apply')); ?>"><i class="ti ti-search"></i></button>
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                            <div class="action-btn bg-danger ">
                                <div class="new-btn">
                                    <a href="<?php echo e(route('report.leadsanalytic')); ?>" data-bs-toggle="tooltip"
                                        title="<?php echo e(__('Reset')); ?>" data-title="<?php echo e(__('Reset')); ?>"
                                        class=" btn btn-sm align-items-center text-white"><i class="ti ti-refresh"
                                            style="    margin-right: 0px;" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="action-btn bg-primary ms-2">
                            <div class="col-auto">
                                <a href="#" onclick="saveAsPDF();" class="mx-3 btn btn-sm align-items-center text-white"
                                    data-bs-toggle="tooltip" data-title="<?php echo e(__('Download')); ?>"
                                    title="<?php echo e(__('Download')); ?>" id="download-buttons">
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
                        <?php if(isset($report['startDateRange']) || isset($report['endDateRange'])): ?>
                        <input type="hidden"
                            value="<?php echo e(__('Lead Report of') . ' ' . $report['startDateRange'] . ' to ' . $report['endDateRange']); ?>"
                            id="filesname">
                        <?php else: ?>
                        <input type="hidden" value="<?php echo e(__('Lead Report')); ?>" id="filesname">
                        <?php endif; ?>

                        <div class="col-md-6 need_full">
                            <?php echo e(__('Report')); ?> : <h6><?php echo e(__('Lead Summary')); ?></h6>
                        </div>
                        <div class="col-md-6 need_full">
                            <?php echo e(__('Duration')); ?> : <h6>
                                <?php echo e($report['startDateRange'] . ' to ' . $report['endDateRange']); ?>

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
                    
                    
                </div>
                <div class="table-responsive mt-3">
                    <table class="table datatable" id="pc-dt-export">
                        <thead>
                            <tr>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Name')); ?></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__(' Lead Status')); ?> <span
                                        class="opticy"> dddd</span> </th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Status')); ?> <span class="opticy">
                                        dddd</span> </th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Created By')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Type')); ?> <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Phone')); ?><span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Email')); ?><span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Date')); ?> <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Time')); ?> <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Assigned Staff')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Rooms required')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Bar')); ?> <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Bar Package')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Function')); ?> <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Package')); ?> <span class="opticy">
                                        dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Additional Items')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Any Special Requests')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Guest Count')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Converted To Event')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Created At')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Comments')); ?> <span
                                        class="opticy"> dddd</span></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Proposal Signed By Customer')); ?>

                                    <span class="opticy"> dddd</span>
                                </th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Any Attachments')); ?> <span
                                        class="opticy"> dddd</span></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $event = App\Models\Meeting::where('attendees_lead',$result['id'])->exists();
                           ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('lead.info',urlencode(encrypt($result['id'])))); ?>" data-size="md"
                                        title="<?php echo e(__('Lead Details')); ?>" class="action-item text-primary"
                                        style="color:#1551c9 !important;">
                                        <b> <?php echo e(ucfirst($result['name'])); ?></b>
                                    </a>
                                </td>
                                <td> <?php echo e(__(\App\Models\Lead::$stat[$result->lead_status])); ?> <span
                                        class="empytu"></span></td>
                                <td> <?php echo e(__(\App\Models\Lead::$status[$result['status']])); ?> <span class="empytu"></span>
                                </td>

                                <td><?php echo e(ucfirst(App\Models\User::where('id',$result['created_by'])->first()->name)); ?> <span
                                        class="empytu"></span></td>
                                <td><?php echo e(ucfirst($result['type'])); ?> <span class="empytu"></span></td>
                                <td><?php echo e($result['phone']); ?> <span class="empytu"></span></td>
                                <td><?php echo e($result['email']); ?> <span class="empytu"></span></td>
                                <td> <?php if($result['start_date'] == $result['end_date']): ?>
                                    <?php echo e(\Auth::user()->dateFormat($result['start_date'])); ?>

                                    <?php else: ?>
                                    <?php echo e(\Auth::user()->dateFormat($result['start_date'])); ?> -
                                    <?php echo e(\Auth::user()->dateFormat($result['end_date'])); ?>

                                    <?php endif; ?> <span class="empytu"></span></td>
                                <td> <?php if($result['start_time'] == $result['end_time']): ?>
                                    --
                                    <?php else: ?>
                                    <?php echo e(date('h:i A', strtotime($result['start_time']))); ?> -
                                    <?php echo e(date('h:i A', strtotime($result['end_time']))); ?>

                                    <?php endif; ?> <span class="empytu"></span></td>
                                <td><?php echo e(!empty($result['assign_user'])? $result['assign_user']->name :'Not Assigned Yet'); ?>

                                    <?php echo e(!empty($result['assign_user'])?'('.$result['assign_user']->type.')':''); ?></td>
                                <td><?php echo e($result['rooms']); ?> <span class="empytu"></span></td>
                                <td><?php echo e($result['bar'] ?? '--'); ?> <span class="empytu"></span></td>
                                <td><?php $barpackage = json_decode($result['bar_package'],true);
                                    if(isset($barpackage) && !empty($barpackage)){
                                            echo implode(',',$barpackage);
                                    }else{
                                        echo '--';
                                    }     
                                ?> <span class="empytu"></span></td>
                                <td><?php echo e(isset($result['function'])&& !empty($result['function']) ? ucfirst($result['function']) : '--'); ?>

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
                                <td><?php echo e($result['spcl_req'] ?? '--'); ?> <span class="empytu"></span></td>
                                <td><?php echo e($result['guest_count']); ?> <span class="empytu"></span></td>
                                <td>

                                    <?php if($event): ?> Yes <?php else: ?> No <?php endif; ?>
                                </td>
                                <td><?php echo e(__(\Auth::user()->dateFormat($result['created_at']))); ?></td>
                                <td><?php $comment = App\Models\Proposal::where('lead_id',$result['id'])->orderby('id','desc')->first(); ?>
                                    <?php if(isset($comment) && !empty($comment)): ?>
                                    <?php echo e($comment->notes); ?>

                                    <?php else: ?> -- <?php endif; ?>
                                    <span class="empytu"></span>
                                </td>
                                <td><?php $prop = App\Models\Proposal::where('lead_id',$result['id'])->orderby('id','desc')->exists(); ?>
                                    <?php if($prop): ?> Yes <?php else: ?> No <?php endif; ?>
                                    <span class="empytu"></span>
                                </td>
                                <td><?php  $attachment=   App\Models\LeadDoc::where('lead_id',$result['id'])->get();?>
                                    <?php if($attachment): ?>
                                    <?php $__currentLoopData = $attachment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(Storage::disk('public')->exists($attach->filepath)): ?>

                                    <a href="<?php echo e(Storage::url('app/public/'.$attach->filepath)); ?>" download
                                        style="color: teal;" title="Download"><?php echo e($attach->filename); ?></a>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                    <span class="empytu"></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('script-page'); ?>

    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/dataTables.buttons.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jszip.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/pdfmake.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/vfs_fonts.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/buttons.html5.min.js')); ?>"></script>


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
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
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
                        text: '<?php echo e(__('
                        Lead ')); ?>'
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
    <?php $__env->stopPush(); ?>
    <style>
    span.opticy {
        opacity: 0;
    }
    </style>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\catamount\resources\views/report/leadsanalytic.blade.php ENDPATH**/ ?>