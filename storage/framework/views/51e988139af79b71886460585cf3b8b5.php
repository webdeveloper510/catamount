<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Training Clients')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(__('Training Clients')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('siteusers')); ?>"><?php echo e(__('Clients')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Training Clients')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-field">
    <div id="wrapper">

        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Name')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Email')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Phone')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Address')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Category')); ?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $eventcustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <a href="<?php echo e(route('event.userinfo',urlencode(encrypt($user->ref_id)))); ?>" title="<?php echo e(__('User Details')); ?>" class="action-item text-primary" style="color:#1551c9 !important;">
                                                        <b> <?php echo e(ucfirst($user->name)); ?></b>
                                                    </a></td>
                                                <!-- <td><span><?php echo e(ucfirst($user->name)); ?></span></td> -->
                                                <td><span><?php echo e($user->email); ?></span></td>
                                                <td><span><?php echo e($user->phone); ?></span></td>
                                                <td><span><?php echo e($user->address); ?></span></td>
                                                <td><span><?php echo e($user->type); ?></span></td>
                                                <td>

                                                </td>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<script>
    function storeIdInLocalStorage(link) {
        var id = link.id;
        localStorage.setItem('clickedLinkId', id);
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/customer/event_customer.blade.php ENDPATH**/ ?>