<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('User')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Staff')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Staff')); ?></li>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create User')): ?>
        <a href="#" data-url="<?php echo e(route('user.create')); ?>" data-size="md" data-ajax-popup="true" data-bs-toggle="tooltip"
            title="<?php echo e(__('Create')); ?>"data-title="<?php echo e(__('Create Staff Member')); ?>" class="btn btn-sm btn-primary btn-icon">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('filter'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive overflow_hidden">
                        <table id="datatable" class="table align-items-center datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="username"><?php echo e(__('Avatar')); ?></th>
                                    <!-- <th scope="col" class="sort" data-sort="username"><?php echo e(__('User Name')); ?></th> -->
                                    <th scope="col" class="sort" data-sort="name"><?php echo e(__('Name')); ?></th>
                                    <th scope="col" class="sort" data-sort="email"><?php echo e(__('Email')); ?></th>
                                    <?php if(\Auth::user()->type != 'super admin'): ?>
                                        <th scope="col" class="sort" data-sort="title"><?php echo e(__('Type')); ?></th>
                                        <th scope="col" class="sort" data-sort="isactive"><?php echo e(__('Status')); ?></th>
                                    <?php endif; ?>
                                    <?php if(Gate::check('Edit User') || Gate::check('Delete User')): ?>
                                        <th class="text-end" scope="col"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $profile = \App\Models\Utility::get_file('upload/profile/');
                                ?>
                               
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <span class="avatar">
                                                <a href="<?php echo e($profile); ?><?php echo e(!empty($user->avatar) ? $user->avatar : 'avatar.png'); ?>"
                                                    target="_blank">
                                                <img class="rounded-circle" width="25%"
                                                    <?php if($user->avatar): ?> src="<?php echo e($profile); ?><?php echo e(!empty($user->avatar) ? $user->avatar : 'avatar.png'); ?>" <?php else: ?> src="<?php echo e($profile . 'avatar.png'); ?>" <?php endif; ?>
                                                    alt="<?php echo e($user->name); ?>">
                                                </a>
                                            </span>
                                        </td>
                                        <!-- <td class="budget">
                                            <a href="#" data-size="md" data-url="<?php echo e(route('user.show', $user->id)); ?>"
                                                data-ajax-popup="true" data-title="<?php echo e(__('User Details')); ?>"
                                                class="action-item text-primary">
                                                <?php echo e(ucfirst($user->username)); ?>

                                            </a>
                                        </td> -->
                                        <td>
                                            <span class="budget"> <?php echo e(ucfirst($user->name)); ?> </span>
                                        </td>
                                        <td>
                                            <span class="budget"><?php echo e($user->email); ?></span>
                                        </td>
                                        <?php if(\Auth::user()->type != 'super admin'): ?>
                                            <td>
                                                <?php echo e(ucfirst($user->type)); ?>

                                            </td>
                                            <td>
                                                <?php if($user->is_active == 1): ?>
                                                    <span
                                                        class="badge bg-success p-2 px-3 rounded"><?php echo e(__('Active')); ?></span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge bg-danger p-2 px-3 rounded"><?php echo e(__('In Active')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        <?php if(Gate::check('Edit User') || Gate::check('Delete User')): ?>
                                            <td class="text-end">
                                                <?php if(\Auth::user()->type == 'super admin'): ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Plan')): ?>
                                                        <div class="action-btn bg-secondary ms-2">
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                                data-size="md"
                                                                data-url="<?php echo e(route('plan.upgrade', $user->id)); ?>"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-title="<?php echo e(__('Upgrade Plan')); ?>"
                                                                title="<?php echo e(__('Upgrade Plan')); ?>">
                                                                <i class="ti ti-trophy"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <div class="action-btn bg-success ms-2">
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                        data-size="md"
                                                        data-url="<?php echo e(route('user.reset', \Crypt::encrypt($user->id))); ?>"
                                                        data-ajax-popup="true" title="<?php echo e(__('Reset Password')); ?>"
                                                        data-bs-toggle="tooltip" data-title="<?php echo e(__('Reset Password')); ?>">
                                                        <i class="ti ti-key"></i>
                                                    </a>
                                                </div>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show User')): ?>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" data-size="md"
                                                            data-url="<?php echo e(route('user.show', $user->id)); ?>"
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>"
                                                            data-ajax-popup="true" data-title="<?php echo e(__('User Details')); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit User')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="<?php echo e(route('user.edit', $user->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                            data-bs-toggle="tooltip"
                                                            title="<?php echo e(__('Edit')); ?>"data-title="<?php echo e(__('Edit User')); ?>"><i
                                                                class="ti ti-edit"></i></a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete User')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]); ?>

                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm align-items-center text-white show_confirm"
                                                            data-bs-toggle="tooltip" title='Delete'>
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/user/index.blade.php ENDPATH**/ ?>