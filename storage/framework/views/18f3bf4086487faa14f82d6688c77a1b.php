<div class="col-lg-12 order-lg-1">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('User Name')); ?> </small>
                </div>
                <div class="col-md-5">
                    <span class="text-md"><?php echo e($user->username); ?></span>
                </div>
                <div class="col-md-3 text-md-end">
                    <?php
                    $profile=\App\Models\Utility::get_file('upload/profile/');

                    ?>
                    <img src="<?php echo e((!empty($user->avatar))? ($profile.$user->avatar): ($profile.'avatar.png')); ?>"
                        width="50px;">

                </div>
                <div class="col-md-4 mt-1">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('Name')); ?> </small>
                </div>
                <div class="col-sm-5  mt-1">
                    <span class="text-md"><?php echo e($user->name); ?></span>
                </div>


                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('Email')); ?></small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md"><?php echo e($user->email); ?></span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('Phone')); ?></small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md"><?php echo e($user->phone); ?></span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('Gender')); ?></small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md"><?php echo e($user->gender); ?></span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('Role')); ?></small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md"><?php echo e($user->type); ?></span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('Created At :')); ?> </small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md"><?php echo e(\Auth::user()->dateFormat($user->created_at )); ?></span>
                </div>
                <div class="col-sm-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0"><?php echo e(__('Status')); ?></small>
                </div>
                <div class="col-md-5  mt-1">
                    <?php if($user->is_active == 1): ?>
                    <span class="badge bg-success p-2 px-3 rounded"><?php echo e(__('Active')); ?></span>
                    <?php else: ?>
                    <span class="badge bg-danger p-2 px-3 rounded"><?php echo e(__('In Active')); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </li>
    </ul>
    <div class=" text-end ">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit User')): ?>
        <div class="action-btn bg-info ms-2">
            <a href="<?php echo e(route('user.edit',$user->id)); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"
                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"><i class="ti ti-edit"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<style>
.list-group-flush .list-group-item {
    background: none;
}
</style><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/user/view.blade.php ENDPATH**/ ?>