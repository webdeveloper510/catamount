<?php
$setting = Utility::settings();

$color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
$logo = \App\Models\Utility::get_file('uploads/logo/');
$company_favicon = $setting['company_favicon'] ?? '';
$company_logo = \App\Models\Utility::GetLogo();
$users = \Auth::user();

$lang = \App::getLocale('lang');
if ($lang == 'ar' || $lang == 'he') {
$setting['SITE_RTL'] = 'on';
}
$LangName = \App\Models\Languages::where('code', $lang)->first();
if (empty($LangName)) {
$LangName = new App\Models\Utility();
$LangName->fullName = 'English';
}
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($setting['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Salesy Saas- Business Sales CRM" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />
    <title>
        <?php echo e(Utility::getValByName('header_text') ? Utility::getValByName('header_text') : config('app.name', 'Salesy SaaS')); ?>

        - <?php echo $__env->yieldContent('page-title'); ?></title>
    <!-- Primary Meta Tags -->

    <meta name="title" content="<?php echo e($setting['meta_keywords']); ?>">
    <meta name="description" content="<?php echo e($setting['meta_description']); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($setting['meta_keywords']); ?>">
    <meta property="og:description" content="<?php echo e($setting['meta_description']); ?>">
    <meta property="og:image" content="<?php echo e(asset('uploads/metaevent/' . $setting['meta_image'])); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($setting['meta_keywords']); ?>">
    <meta property="twitter:description" content="<?php echo e($setting['meta_description']); ?>">
    <meta property="twitter:image" content="<?php echo e(asset('uploads/metaevent/' . $setting['meta_image'])); ?>">
    <link rel="icon" href="<?php echo e($logo . '/favicon.png'); ?>" type="image/png">

    <?php if($setting['cust_darklayout'] == 'on'): ?>
    <style>
    .g-recaptcha {
        filter: invert(1) hue-rotate(180deg) !important;
    }
    </style>
    <?php endif; ?>
    <?php if($setting['cust_darklayout'] == 'on'): ?>
    <?php if(isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
    <?php if(isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
    <?php else: ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth-rtl.css')); ?>" id="main-style-link">
    <?php else: ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php if($setting['cust_darklayout'] == 'on'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth-dark.css')); ?>" id="main-style-link">
    <?php endif; ?>
</head>

<body class="<?php echo e($color); ?>">
    <div class="custom-login">
        <!-- <div class="login-bg-img">
            <img src="<?php echo e(asset('assets/images/auth/'.$color.'.svg')); ?>" class="login-bg-1">
            <img src="<?php echo e(asset('assets/images/auth/common.svg')); ?>" class="login-bg-2">
        </div> -->
        <!-- <div class="bg-login bg-primary"></div> -->
        <div class="custom-login-inner">
            <main class="custom-wrapper">
                <div class="custom-row">
                    <div class="card">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

<script src="<?php echo e(asset('assets/js/vendor-all.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<?php echo $__env->yieldPushContent('custom-scripts'); ?>

<?php if($setting['enable_cookie'] == 'on'): ?>
<?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<style>
.custom-login {
    background-image: url(<?php echo Storage::url('uploads/background_img/image.jpg'); ?>);
    background-size: cover;
}
</style>

</html><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/layouts/auth.blade.php ENDPATH**/ ?>