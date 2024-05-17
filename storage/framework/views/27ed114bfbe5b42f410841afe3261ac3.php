<script src="<?php echo e(asset('js/site.core.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/dash.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>

<script src="<?php echo e(asset ('assets/js/plugins/apexcharts.min.js')); ?>"></script>
<script src="<?php echo e(asset ('js/plugins/sweetalert2.all.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/letter.avatar.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>

<script>
(function () {
  const d_week = new Datepicker(document.querySelector('#pc-datepicker-2_modal'), {
    buttonClass: 'btn',
  });
})();
</script>
<script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            offset: 300
        })
</script>
<script src="<?php echo e(asset('assets/js/plugins/dropzone-amd-module.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>

<!-- <script src="<?php echo e(asset('libs/select2/dist/css/select2.min.css')); ?>"></script> -->
<link rel="stylesheet" href="<?php echo e(asset('libs/select2/dist/css/select2.min.css')); ?>">

<script src="<?php echo e(asset ('assets/js/plugins/simple-datatables.js')); ?>"></script>

<script>
    if ($(".datatable").length > 0) {
        $( $(".datatable") ).each(function( index,element ) {
            var id = $(element).attr('id');
            const dataTable = new simpleDatatables.DataTable("#"+id);
        });
    }
</script>
<script src="<?php echo e(asset('assets/js/plugins/simplebar.min.js')); ?>"></script>
<!-- Time picker -->
<script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>
<!-- datepicker -->
<script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/custom.js')); ?>"></script>
<script>
$(document).ready(function() {
        $('.list-group-item').on('click', function() {
            var href = $(this).attr('data-href');
            $('.tabs-card').addClass('d-none');
            $(href).removeClass('d-none');
            $('#tabs .list-group-item').removeClass('text-primary');
        });
    });
</script>
<!-- Demo JS - remove it when starting your project -->

<script>
          $(".dash-navbar li a").click(function() {
           $(this).parent().addClass('active').siblings().removeClass('active'); 
          } );
            </script>
<script>
    function show_toastr(title, message, type) {
        var o, i;
        var icon = '';
        var cls = '';
        if (type == 'success') {
            icon = 'fas fa-check-circle';
            // cls = 'success';
            cls = 'primary';
        } else {
            icon = 'fas fa-times-circle';
            cls = 'danger';
        }
        console.log(type, cls);
        $.notify({
            icon: icon,
            title: " " + title,
            message: message,
            url: ""
        }, {
            element: "body",
            type: cls,
            allow_dismiss: !0,
            placement: {
                from: 'top',
                align: 'right'
            },
            offset: {
                x: 15,
                y: 15
            },
            spacing: 10,
            z_index: 1080,
            delay: 2500,
            timer: 2000,
            url_target: "_blank",
            mouse_over: !1,
            animate: {
                enter: o,
                exit: i
            },
            //// danger
            template: '<div class="toast text-white bg-' + cls +
                ' fade show" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="d-flex">' +
                '<div class="toast-body"> ' + message + ' </div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div>' +
                '</div>'
            // template: '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
        });
    }
</script>


<script>
    var dataTabelLang = {
        paginate: {previous: "<?php echo e(__('Previous')); ?>", next: "<?php echo e(__('Next')); ?>"},
        lengthMenu: "<?php echo e(__('Show')); ?> _MENU_ <?php echo e(__('entries')); ?>",
        zeroRecords: "<?php echo e(__('No data available in table')); ?>",
        info: "<?php echo e(__('Showing')); ?> _START_ <?php echo e(__('to')); ?> _END_ <?php echo e(__('of')); ?> _TOTAL_ <?php echo e(__('entries')); ?>",
        infoEmpty: " ",
        search: "<?php echo e(__('Search:')); ?>"
    }
</script>
<script>
    var toster_pos="<?php echo e(env('SITE_RTL') =='on' ?'left' : 'right'); ?>";
</script>

<script>
    var date_picker_locale = {
        format: 'YYYY-MM-DD',
        daysOfWeek: [
            "<?php echo e(__('Sun')); ?>",
            "<?php echo e(__('Mon')); ?>",
            "<?php echo e(__('Tue')); ?>",
            "<?php echo e(__('Wed')); ?>",
            "<?php echo e(__('Thu')); ?>",
            "<?php echo e(__('Fri')); ?>",
            "<?php echo e(__('Sat')); ?>"
        ],
        monthNames: [
            "<?php echo e(__('January')); ?>",
            "<?php echo e(__('February')); ?>",
            "<?php echo e(__('March')); ?>",
            "<?php echo e(__('April')); ?>",
            "<?php echo e(__('May')); ?>",
            "<?php echo e(__('June')); ?>",
            "<?php echo e(__('July')); ?>",
            "<?php echo e(__('August')); ?>",
            "<?php echo e(__('September')); ?>",
            "<?php echo e(__('October')); ?>",
            "<?php echo e(__('November')); ?>",
            "<?php echo e(__('December')); ?>"
        ],
    };
    var calender_header = {
        today: "<?php echo e(__('today')); ?>",
        month: '<?php echo e(__("month")); ?>',
        week: '<?php echo e(__("week")); ?>',
        day: '<?php echo e(__("day")); ?>',
        list: '<?php echo e(__("list")); ?>'
    };
</script>


<?php if(Session::has('success')): ?>
    <script>
        show_toastr('<?php echo e(__("Success")); ?>', '<?php echo session("success"); ?>', 'success');
    </script>
    <?php echo e(Session::forget('success')); ?>

<?php endif; ?>
<?php if(Session::has('error')): ?>
    <script>
        show_toastr('<?php echo e(__("Error")); ?>', '<?php echo session("error"); ?>', 'error');
    </script>
    <?php echo e(Session::forget('error')); ?>

<?php endif; ?>








<?php echo $__env->yieldPushContent('script-page'); ?>

<?php
    $status = [
            __('Draft'),
            __('In Review'),
            __('Presented'),
            __('Approved'),
            __('Rejected'),
            __('Canceled'),
        ];
?>
<?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/partials/admin/footer.blade.php ENDPATH**/ ?>