<?php 
$settings = App\Models\Utility::settings();
$category= explode(',',$settings['campaign_type']);
?>

<div id="sidebar-wrapper">
    <div class="card">
        <div class="list-group list-group-flush sidebar-nav nav-pills nav-stacked" id="menu">
            <div class="navbar-brand-box">
                <a href="#" class="navbar-brand">
                    <img src="<?php echo e($logo.'3_logo-light.png'); ?>" alt="<?php echo e(config('app.name', 'The Sector Eight')); ?>"
                        class="logo logo-lg nav-sidebar-logo" height="50" />
                </a>
            </div>
            <div class="scrollbar">
                <?php if(\Request::route()->getName() == 'lead.review'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action border-0">
                <span class="fa-stack fa-lg pull-left"><i class="ti ti-home-2"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Review Lead')); ?></span>
                    <!-- <div class="float-end"><i class="ti ti-chevron-right"></i></div> -->
                </a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'dashboard'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span
                        class="fa-stack fa-lg pull-left"><i class="ti ti-home-2"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Dashboard')); ?> </span></a>
                </a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'settings'): ?>
                <?php if(\Auth::user()->type == 'owner'): ?>
                <a href="#company-email-setting" class="list-group-item list-group-item-action" data-id="collapse16"
                    onclick="showAccordion('collapse16')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-envelope"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Email')); ?></span>
                </a>

                <!-- <a href="javascript:void(0);" class="list-group-item list-group-item-action" data-id="collapse16"
                    onclick="toggleCollapse(this.getAttribute('data-id'))">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-envelope  "></i></span>
                    <span class="dash-mtext"><?php echo e(__('Email')); ?> </span></a>
                </a> -->
                <a href="#twilio-settings" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse15')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-sms"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Twilio')); ?></span>
                </a>
                <?php endif; ?>
                <?php if(\Auth::user()->type == 'super admin'): ?>
                <a href="#recaptcha-settings" class="list-group-item list-group-item-action border-0">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-cog"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Recaptcha')); ?></span>
                </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage User')): ?>
                <a href="#user-settings" class="list-group-item list-group-item-action border-0"    onclick="showAccordion('collapse17')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-user"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Staff')); ?></span>
                </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Role')): ?>
                <a href="#role-settings" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse18')">
                    <span class="fa-stack fa-lg pull-left"><img src="<?php echo e(asset('icons/user.png')); ?>" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext"><?php echo e(__('Role')); ?></span>
                </a>
                <?php endif; ?>
                <?php if(Gate::check('Manage Lead') || Gate::check('Manage Meeting')): ?>
                <a href="#eventtype-settings" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Events')); ?></span>
                </a>

                <!-- <a href="#venue-settings" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><img src="<?php echo e(asset('icons/location.png')); ?>" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext"><?php echo e(__('Venue')); ?></span>
                </a>
                <a href="#function-settings" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><img src="<?php echo e(asset('icons/restaurant.png')); ?>" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext"><?php echo e(__('Function')); ?></span>
                </a>
                <a href="#bar-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><i class="fas fa-cocktail"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Bar')); ?></span>
                </a>
                <a href="#floor-plan-setting" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse19')">
                    <span class="fa-stack fa-lg pull-left"><img src="<?php echo e(asset('icons/roadmap.png')); ?>" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext"><?php echo e(__('Setup')); ?></span>
                </a> -->
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Payment')): ?>
                <a href="#billing-setting" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse20')">
                    <span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Invoice')); ?></span>
                </a>
                <?php endif; ?>
                <?php if(\Auth::user()->type == 'owner'): ?>
                <a href="#buffer-settings" class="list-group-item list-group-item-action border-0" onclick="showAccordion('collapse21')">
                    <span class="fa-stack fa-lg pull-left"><img src="<?php echo e(asset('icons/loading.png')); ?>" alt=""
                            style="width: 22px;"></span>
                    <span class="dash-mtext"><?php echo e(__('Buffer')); ?></span>
                </a>
                 <a href="#add-signature" class="list-group-item list-group-item-action border-0"  onclick="showAccordion('collapse22')">
                    <span class="fa-stack fa-lg pull-left"><img src="<?php echo e(asset('icons/signature.png')); ?>" alt=""
                            style="    width: 22px;"></span>
                    <span class="dash-mtext"><?php echo e(__('Authorised Signature')); ?></span>
                </a>
             
                <?php endif; ?>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'billing.index'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Billing')); ?> </span></a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'calendernew.index'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-calendar"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Calender')); ?> </span></a>
                <?php endif; ?>

                <?php if(\Request::route()->getName() == 'billing.create'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Create Billing')); ?> </span></a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'customer.index' || \Request::route()->getName() == 'campaign-list'): ?>
                <a href="<?php echo e(route('customer.index')); ?>"class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'customer.index' ?'active' : ''); ?>">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-bullhorn"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Campaign')); ?> </span></a>
                <a href="<?php echo e(route('campaign-list')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'campaign-list' ?'active' : ''); ?>">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-list"></i></span>
                    <span class="dash-mtext"><?php echo e(__('View Campaigns')); ?> </span></a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'customer.info' ||
                \Request::route()->getName() == 'event_customers'||\Request::route()->getName() == 'siteusers' ||
                \Request::route()->getName() == 'lead_customers' || \Request::route()->getName() ==
                'lead.userinfo'||\Request::route()->getName() ==
                'event.userinfo'||\Request::route()->getName()=='categ'): ?>
                <a href="<?php echo e(route('siteusers')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'siteusers' ?'active' : ''); ?>">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-users"></i></span>
                    <span class="dash-mtext"><?php echo e(__('All Customers')); ?> </span></a>

                <a href="<?php echo e(route('event_customers')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'event_customers' ?'active' : ''); ?>">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-user" title="Event Customers"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Events ')); ?> </span></a>
                <a href="<?php echo e(route('lead_customers')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'lead_customers' ?'active' : ''); ?>">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-user" title="Lead Customers"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Leads')); ?> </span></a>

                <?php if(isset($category) && !empty($category)): ?>
                <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('categ', $cat)); ?>" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="ti ti-user" title="<?php echo e($cat); ?>"></i></span>
                    <span class="dash-mtext"><?php echo e($cat); ?> </span></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php endif; ?>

                <?php if(\Request::route()->getName() == 'meeting.index'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span
                        class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Events')); ?> </span></a>

                </a>
                <?php endif; ?>
                <?php if( \Request::route()->getName() == 'report.index' || \Request::route()->getName() == 'report.show' ||
                \Request::route()->getName() == 'report.edit' || \Request::route()->getName() == 'report.leadsanalytic'
                ||
                \Request::route()->getName() == 'report.eventanalytic' || \Request::route()->getName() ==
                'report.customersanalytic' || \Request::route()->getName() == 'report.billinganalytic' ? ' active ' :
                ''): ?>

                <a href="<?php echo e(route('report.leadsanalytic')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'report.leadsanalytic' ?'active' : ''); ?>"><span
                        class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Leads')); ?> </span></a>

                </a>

                <a href="<?php echo e(route('report.eventanalytic')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'report.eventanalytic' ?'active' : ''); ?>"><span
                        class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Events')); ?> </span></a>

                </a>
                <a href="<?php echo e(route('report.customersanalytic')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'report.customersanalytic' ?'active' : ''); ?>"><span
                        class="fa-stack fa-lg pull-left"><i class="fa fa-users"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Customers')); ?> </span></a>

                </a>
                <a href="<?php echo e(route('report.billinganalytic')); ?>" class="list-group-item list-group-item-action <?php echo e(\Request::route()->getName() == 'report.billinganalytic' ?'active' : ''); ?>"><span
                        class="fa-stack fa-lg pull-left"><i class="fas fa-file-invoice"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Financial')); ?> </span></a>

                </a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'meeting.create' ||\Request::route()->getName() == 'meeting.edit' ): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Event Details')); ?> </span></a>
                <!-- <a href="#event-details" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-info"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Event Details')); ?> </span></a>
                <a href="#special_req" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"></span>
                    <span class="dash-mtext"><?php echo e(__('Special Requirements')); ?> </span></a>
                <a href="#other_info" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"></span>
                    <span class="dash-mtext"><?php echo e(__('Other Information')); ?> </span></a> -->
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'meeting.review' ): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action">
                    <span class="fa-stack fa-lg pull-left"><i class="fa fa-tasks"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Review Event')); ?> </span></a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'lead.index' ): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span
                        class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Leads')); ?> </span></a>
                </a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'lead.edit' ): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span
                        class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Edit Lead')); ?> </span></a>
                </a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'lead.info'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span
                        class="fa-stack fa-lg pull-left"><i class="fas fa-address-card"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Leads')); ?> </span></a>
                </a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'email.index' ||\Request::route()->getName() == 'email.details'||\Request::route()->getName() == 'email.conversations'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span
                        class="fa-stack fa-lg pull-left"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Emails')); ?> </span></a>
                </a>
                <?php endif; ?>
                <?php if(\Request::route()->getName() == 'contracts.index' ||\Request::route()->getName() == 'contracts.create'): ?>
                <a href="#useradd-1" class="list-group-item list-group-item-action"><span
                        class="fa-stack fa-lg pull-left"><i class="fa fa-file-contract"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Contracts')); ?> </span></a>
                </a>
                <?php endif; ?>
                <!-- <li
                    class="dash-item <?php echo e(\Request::route()->getName() == 'calendar' || \Request::route()->getName() == 'calendar.index' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('calendar.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="far fa-calendar-alt"></i></span><span
                            class="dash-mtext"><?php echo e(__('Calendar')); ?></span>
                    </a>
                </li> -->
            </div>
        </div>
    </div>
</div>
    <script>
    function showAccordion(dataId) {
        $('.accordion-collapse').css('display', 'none')
        if ($('#' + dataId).hasClass('show')) {
            $('#' + dataId).css('display', 'none');
            $('#' + dataId).removeClass('show');
        } else {
            $('#' + dataId).css('display', 'block');
            $('#' + dataId).addClass('show');
        }
    }
</script>

<?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/partials/admin/sidebar.blade.php ENDPATH**/ ?>