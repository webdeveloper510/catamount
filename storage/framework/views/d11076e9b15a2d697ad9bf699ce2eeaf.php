<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Blocked Date')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(__('Blocked Date')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Blocked Date')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="">
            <dl class="row">
                <dt class="col-md-5"><span class="h6 text-md mb-0"><?php echo e(__('Start Date')); ?></span></dt>
                <dd class="col-md-5"><span class="text-md"><?php echo e(\Auth::user()->dateFormat($user_data->start_date)); ?></span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0"><?php echo e(__('End Date')); ?></span></dt>
                <dd class="col-md-5"><span class="text-md"><?php echo e(\Auth::user()->dateFormat($user_data->end_date)); ?></span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0"><?php echo e(__('Start Time')); ?></span></dt>
                <dd class="col-md-5"><span class="text-md"><?php echo e(date('h:i A', strtotime($user_data->start_time))); ?></span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0"><?php echo e(__('End Time')); ?></span></dt>
                <dd class="col-md-5"><span class="text-md"><?php echo e(date('h:i A', strtotime($user_data->end_time))); ?></span>
                </dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0"><?php echo e(__('Venue')); ?></span></dt>
                <dd class="col-md-5"><span class="text-md"><?php echo e($user_data->venue); ?></span></dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0"><?php echo e(__('Purpose')); ?></span></dt>
                <dd class="col-md-5"><span class="text-md"><?php echo e($user_data->purpose); ?></span></dd>

                <dt class="col-md-5"><span class="h6 text-md mb-0"><?php echo e(__('Blocked_by')); ?></span></dt>
                <dd class="col-md-5"><span class="text-md"><?php echo e($blocked_username); ?></span></dd>
            </dl>
        </div>
    </div>
    <div>
        <?php if(\Auth::user()->type == 'owner'): ?>
        <div>
            <a href="<?php echo e(url('/unblock-date/' . $user_data->id)); ?>"class="btn btn-secondary">Unblock This
                Date</a>
        </div>
        <?php else: ?>
        <?php if(\Auth::user()->id == $user_data->created_by): ?>
        <div >
            <a href="<?php echo e(url('/unblock-date/' . $user_data->id)); ?>" class="btn btn-secondary">Unblock This
                Date</a>
        </div>
        <?php endif; ?>
        <?php endif; ?>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/calendar/view.blade.php ENDPATH**/ ?>