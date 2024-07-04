<?php $__env->startPush('script-page'); ?>
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
                            name: "<?php echo e(__('Order')); ?>",
                            data: <?php echo json_encode($chartData['data']); ?>

                        }],
                        xaxis: {
                            categories: <?php echo json_encode($chartData['label']); ?>,
                            title: {
                            text: '<?php echo e(__("Days")); ?>'
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
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

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
                                    <p class="text-muted text-sm mt-4 mb-2"> <?php echo e(__('Total Users')); ?> : <span class="text-dark"><?php echo e($user->total_user); ?></span></p>
                                    <h6 class="mb-3"><?php echo e(__('Paid Users')); ?></h6>
                                    <h3 class="mb-0"><?php echo e($user['total_paid_user']); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-warning mb-3">
                                        <i class="ti ti-shopping-cart-plus"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"> <?php echo e(__('Total Orders')); ?> : <span class="text-dark"><?php echo e($user->total_orders); ?></span></p>
                                    <h6 class="mb-3"><?php echo e(__('Total Order Amount')); ?></h6>
                                    <h3 class="mb-0"><?php echo e(env("CURRENCY_SYMBOL").$user['total_orders_price']); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-danger mb-3">
                                        <i class="ti ti-award"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total Plans')); ?> : <span class="text-dark"><?php echo e(env("CURRENCY_SYMBOL").$user['total_orders_price']); ?></span></p>
                                    <h6 class="mb-3"><?php echo e(__('Most Purchase Plan')); ?></h6>
                                    <h3 class="mb-0"><?php echo e(!empty($user['most_purchese_plan'])?$user['most_purchese_plan']:'-'); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Recent Order')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div id="plan_order" data-color="primary" data-height="230"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/super_admin.blade.php ENDPATH**/ ?>