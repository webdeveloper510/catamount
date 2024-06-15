<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Proposal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="page-header-title">
    <?php echo e(__('Proposal')); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('lead.index')); ?>"><?php echo e(__('Leads')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Proposal Information')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
<?php $status= App\Models\Lead::find($decryptedId)->status; ?>
<?php if($status > 1): ?>
<a href="#" data-size="md" data-url="<?php echo e(route('lead.shareproposal',urlencode(encrypt($decryptedId)))); ?>"
    data-ajax-popup="true" data-bs-toggle="tooltip" data-title="<?php echo e(__('Proposal')); ?>" title="<?php echo e(__('Share Proposal')); ?>"
    class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-share"></i>
</a>
<?php endif; ?>
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
                                                <!-- <th scope="col" class="sort" data-sort="name"><?php echo e(__('Lead')); ?></th> -->
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Proposal')); ?></th>
                                                <!-- <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Email')); ?></th> -->
                                                <th scope="col" class="sort"><?php echo e(__('Notes')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Document')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Created On')); ?></th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $proposal_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(App\Models\Lead::where('id',$info->lead_id)->first()->name); ?></td>
                                                <!-- <td><?php echo e(App\Models\Lead::where('id',$info->lead_id)->first()->email); ?></td> -->
                                                <td><?php echo e($info->notes ?? '--'); ?></td>
                                                <td><a href="<?php echo e(route('lead.viewproposal',urlencode(encrypt($info->lead_id)))); ?>"
                                                        style=" color: teal;">View
                                                        Document</a></td>
                                                <td><?php echo e(\Auth::user()->dateFormat($info->created_at)); ?></td>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/lead/proposal_information.blade.php ENDPATH**/ ?>