<?php
    $settings = \App\Models\Utility::settings();
    $color = !empty($settings['color']) ? $settings['color'] : 'theme-3';
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $company_favicon = Utility::getValByName('company_favicon');
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
    $languages = \App\Models\Utility::languages();
    $footer_text = isset($settings['footer_text']) ? $settings['footer_text'] : '';
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo e($settings['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<?php echo $__env->make('partials.admin.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body class="<?php echo e($color); ?>">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Mobile header ] End -->

    <!-- [ navigation menu ] start -->
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <?php echo $__env->make('partials.admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->

    <div class="page-content">
        <?php echo $__env->make('partials.admin.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <!-- [ Main Content ] end -->

    <!-- <footer class="dash-footer" id="footer-main">
        <div class="footer-wrapper">
            <div class="py-1">
                <span class="text-muted">&copy;
                    <?php echo e(date('Y')); ?> <?php echo e(App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Salesy Saas')); ?></span>
            </div>
        </div>
    </footer> -->

    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelCommanModelLabel"></h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="commonModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelCommanModelLabel"></h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Chatify::layouts.footerLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Apex Chart -->
    <script src="<?php echo e(asset('/assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (!document.querySelector(".pct-customizer").classList.contains("active")) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }

        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });



        var custdarklayout = document.querySelector("#cust-darklayout");
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {

                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "<?php echo e(asset('assets/css/style-dark.css')); ?>");
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "<?php echo e(asset('/storage/uploads/logo/logo.png')); ?>");
            } else {

                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "<?php echo e(asset('assets/css/style.css')); ?>");
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "<?php echo e(asset('/storage/uploads/logo/logo.png')); ?>");
            }
        });


        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>

</body>


</html>
<?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/layouts/admin.blade.php ENDPATH**/ ?>