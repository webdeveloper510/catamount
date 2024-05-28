<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Contract')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Contract')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Contracts')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <?php if(\Auth::user()->type == 'owner' && \Auth::user()->type != 'Accountant' && \Auth::user()->type != 'Manager'): ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Contract')): ?>
            <!-- <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" data-bs-placement="top"
                title="<?php echo e(__('Create')); ?>" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Create New Contract')); ?>"
                data-url="<?php echo e(route('contracts.create')); ?>"><i class="ti ti-plus text-white"></i></a> -->
                <a href="<?php echo e(route('contracts.create')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" data-bs-placement="top"
                title="<?php echo e(__('Create New Contract')); ?>" ><i class="ti ti-plus text-white"></i></a>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive" id="useradd-1">
                        <table id="datatable" class="table datatable align-items-center">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('User')); ?></th>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Created By')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                     
                                        <td><?php echo e($contract->name); ?></td>
                                        <td><?php echo e(App\Models\User::find($contract->user_id)->first()->name); ?></td>
                                        <td><?php echo e($contract->subject); ?></td>
                                      
                                        <td><?php echo e(Auth::user()->name); ?></td>
                                        <td><?php echo e(Auth::user()->dateFormat($contract->created_at)); ?></td>
                                        <td>
                                            <?php if($contract->status == 'accept'): ?>
                                                <span
                                                    class="status_badge badge bg-primary  p-2 px-3 rounded"><?php echo e(__('Accept')); ?></span>
                                            <?php elseif($contract->status == 'decline'): ?>
                                                <span
                                                    class="status_badge badge bg-danger p-2 px-3 rounded"><?php echo e(__('Decline')); ?></span>
                                            <?php elseif($contract->status == 'pending'): ?>
                                                <span
                                                    class="status_badge badge bg-warning p-2 px-3 rounded"><?php echo e(__('Pending')); ?></span>
                                            <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/contract/index.blade.php ENDPATH**/ ?>