<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(__('Customer Analytics')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Report')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Financial Analytics')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="cardcard-body">

                <div class="collapse show float-end" id="collapseExample" style="">

                    <?php echo e(Form::open(['route' => ['report.billinganalytic'], 'method' => 'get'])); ?>

                    <div class="row filter-css">

                        <div class="col-auto">
                            <?php echo e(Form::month('start_month', isset($_GET['start_month']) ? $_GET['start_month'] : date('Y-01'), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="col-auto">
                            <?php echo e(Form::month('end_month', isset($_GET['end_month']) ? $_GET['end_month'] : date('Y-12'), ['class' => 'form-control'])); ?>

                        </div>

                        <div class="col-auto" style="margin-left: -29px;">

                        </div>
                        <div class=" new-ac">
                        <div class="action-btn bg-primary ">
                            <div class="new-btn">
                                <button type="submit" class="btn btn-sm align-items-center text-white"
                                    data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>" data-title="<?php echo e(__('Apply')); ?>"><i
                                        class="ti ti-search"></i></button>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                        <div class="action-btn bg-danger">
                            <div class="new-btn">
                                <a href="<?php echo e(route('report.billinganalytic')); ?>" data-bs-toggle="tooltip"
                                    title="<?php echo e(__('Reset')); ?>" data-title="<?php echo e(__('Reset')); ?>"
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
                        <?php if(isset($report['startDateRange']) || isset($report['endDateRange'])): ?>
                        <input type="hidden"
                            value="<?php echo e(__('Event Report of') . ' ' . $report['startDateRange'] . ' to ' . $report['endDateRange']); ?>"
                            id="filesname">
                        <?php else: ?>
                        <input type="hidden" value="<?php echo e(__('Financial Report')); ?>" id="filesname">
                        <?php endif; ?>

                        <div class="col">
                            <?php echo e(__('Report')); ?> : <h6><?php echo e(__('Financial Summary')); ?></h6>
                        </div>
                        <div class="col">
                            <?php echo e(__('Duration')); ?> : <h6>
                                <?php echo e($report['startDateRange'] . ' to ' . $report['endDateRange']); ?>

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
                    
                    
                    
                </div>
                <div class="table-responsive mt-3">
                    <table class="table" id="pc-dt-export">
                        <thead>
                            <tr>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Name')); ?></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Event')); ?></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Transaction Id')); ?></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Amount')); ?></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Phone')); ?></th>
                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Email')); ?></th>
                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Created At')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $event = App\Models\Meeting::where('id',$pay['event_id'])->first();?>
                            <tr>
                                <td><?php echo e(ucfirst($pay['name_of_card'])); ?></td>
                                <td><?php echo e($event->type); ?></td>
                                <td><?php echo e(($pay['transaction_id'])); ?></td>
                                <td>$<?php echo e(($pay['amount'])); ?></td>
                                <td><?php echo e($event->phone); ?></td>
                                <td><?php echo e($event->email); ?></td>
                                <td><?php echo e(__(\Auth::user()->dateFormat($pay['created_at']))); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
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
<script src="<?php echo e(asset('assets/js/plugins/simple-datatables.js')); ?>"></script>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/report/billsanalytic.blade.php ENDPATH**/ ?>