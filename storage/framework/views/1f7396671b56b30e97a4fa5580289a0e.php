<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Reset Password')); ?>

<?php $__env->stopSection(); ?>

<?php
    if ($lang == 'ar' || $lang == 'he') {
        $setting['SITE_RTL'] = 'on';
    }
    $lang = \App::getLocale('lang');
    $LangName = \App\Models\Languages::where('code', $lang)->first();
    if (empty($LangName)) {
        $LangName = new App\Models\Utility();
        $LangName->fullName = 'English';
    }
    $settings = \App\Models\Utility::settings();

?>
<?php $__env->startSection('language-bar'); ?>
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text">
                    
                <?php echo e(ucfirst($LangName->fullName)); ?>

                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                <?php $__currentLoopData = Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('password.request', $code)); ?>" tabindex="0"
                    class="dropdown-item <?php if($lang == $code): ?> text-primary <?php endif; ?>">
                    <span><?php echo e(ucfirst($language)); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </li>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card-body">
        <div class="">
            <h2 class="mb-3 f-w-600"><span class="text-primary"><?php echo e(__('Reset Password!')); ?></span>
            </h2>
        </div>
        <?php if(session('status')): ?>
            <small class="text-muted"><?php echo e(session('status')); ?></small>
        <?php endif; ?>
        <?php echo e(Form::open(['route' => 'password.email', 'method' => 'post', 'id' => 'loginForm'])); ?>

        <div class="custom-login-form">
            <div class="form-group mb-3">
                <label class="form-label"><?php echo e(__('Email')); ?></label>
                <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Email')])); ?>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-email text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="d-grid">
                <?php echo e(Form::submit(__('Forgot Password'), ['class' => 'btn btn-primary btn-block mt-2', 'id' => 'saveBtn'])); ?>

            </div>
            <p class="my-4 text-center"><?php echo e(__('Back to?')); ?> <a href="<?php echo e(url('login', $lang)); ?>"
                    class="my-4 text-center text-primary"><?php echo e(__('Login')); ?></a></p>
        </div>
        <?php echo e(Form::close()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
    <?php if($settings['recaptcha_module'] == 'yes'): ?>
    <?php echo NoCaptcha::renderJs(); ?>


    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>