<?php
if (isset($event->func_package) && !empty($event->func_package)) {
    $package = json_decode($event->func_package, true);
}
if (isset($event->ad_opts) && !empty($event->ad_opts)) {
    $additional = json_decode($event->ad_opts, true);
}
if (isset($event->bar_package) && !empty($event->bar_package)) {
    $bar = json_decode($event->bar_package, true);
}
/* $payments = App\Models\PaymentLogs::where('event_id', $event->id)->get();
$payinfo = App\Models\PaymentInfo::where('event_id', $event->id)->get(); */
$files = Storage::files('app/public/Event/' . $event->id);


if (App\Models\PaymentLogs::where('event_id', $event->id)->exists()) {
    $payments = App\Models\PaymentLogs::where('event_id', $event->id)->orderBy('id', 'desc')->get();
    $payinfo = App\Models\PaymentInfo::where('event_id', $event->id)->get();
}
if (App\Models\Billing::where('event_id', $event->id)->exists()) {
    $deposit = App\Models\Billing::where('event_id', $event->id)->first();
}
$beforedeposit = App\Models\Billing::where('event_id', $event->id)->first();

?>

<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Training Information')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(__('Training Information')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Training Information')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('filter'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <dl class="row ">
                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Training')); ?></span></dt>
                        <?php if($event->attendees_lead != 0): ?>
                        <dd class="col-md-6 need_half"><span class=""><?php echo e(!empty($event->attendees_leads->leadname)?$event->attendees_leads->leadname:'--'); ?></span>
                        </dd>
                        <?php else: ?>
                        <dd class="col-md-6 need_half"><span class=""><?php echo e($event->eventname); ?></span></dd>
                        <?php endif; ?>
                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Training Type')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class=""><?php echo e($event->type); ?></span></dd>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Date')); ?></span></dt>
                        <?php if($event->start_date == $event->end_date): ?>
                        <dd class="col-md-6 need_half"><span class=""><?php echo e(\Auth::user()->dateFormat($event->start_date)); ?></span>
                        </dd>
                        <?php else: ?>
                        <dd class="col-md-6 need_half "><span class=""><?php echo e(\Auth::user()->dateFormat($event->start_date)); ?> -
                                <?php echo e(\Auth::user()->dateFormat($event->end_date)); ?></span></dd>
                        <?php endif; ?>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Time')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class=""><?php echo e(date('h:i A', strtotime($event->start_time))); ?> -
                                <?php echo e(date('h:i A', strtotime($event->end_time))); ?></span></dd>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Guest Count')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class=""><?php echo e($event->guest_count); ?></span></dd>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Trainings Location')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class=""><?php echo e($event->venue_selection); ?></span></dd>
                        
                        <?php if(isset($package) && !empty($package)): ?>
                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Package')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class=""><?php $__currentLoopData = $package; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e(implode(',',$value)); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
                        </dd>
                        <?php endif; ?>

                        <?php if(isset($additional) && !empty($additional)): ?>
                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Additional Items')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class=""><?php $__currentLoopData = $additional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e(implode(',',$value)); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
                        </dd>
                        <?php endif; ?>
                        <?php if(isset($bar) && !empty($bar)): ?>
                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Bar Package')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class="">
                                <?php echo e(implode(',',$bar)); ?>

                            </span>
                        </dd>
                        <?php endif; ?>

                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Billing Amount')); ?></span></dt>
                        <dd class="col-md-6 need_half"><span class=""><?php if($event->total != 0): ?>$<?php echo e($event->total); ?><?php else: ?> Billing Not
                                Created <?php endif; ?></span>
                        </dd>
                        <hr class="mt-5">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <h3><?php echo e(__('Setup')); ?></h3>
                            </div>
                        </div>
                        <hr>
                        <img src="<?php echo e($event->floor_plan); ?>" alt="" style="    width: 40% ;" class="need_full">
                    </dl>
                    <?php if(isset($payments) && !empty($payments)): ?>
                    <?php
                    $latefee = 0;
                    $adj = 0;
                    $collect_amount = 0;
                    foreach ($payinfo as $k => $val) {
                        $latefee += $val->latefee;
                        $adj += $val->adjustments;
                    }
                    foreach ($payments as  $value) {
                        $collect_amount += $value->amount;
                    }

                    ?>
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <h3 class="mt-3 text-center">Transaction Summary</h3>
                                <div class="table-responsive overflow_hidden">
                                    <table id="datatable" class="table datatable align-items-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Created On')); ?></th>
                                                <th scope="col" class="sort" data-sort="status"><?php echo e(__('Name')); ?></th>
                                                <th scope="col" class="sort" data-sort="completion"><?php echo e(__('Transaction Id')); ?>

                                                </th>
                                                <th><?php echo e(__('Invoice')); ?></th>
                                                <th scope="col" class="sort" data-sort="completion"><?php echo e(__('Event Amount')); ?>

                                                </th>
                                                <th scope="col" class="sort" data-sort="completion"><?php echo e(__('Amount Collected')); ?>

                                                </th>
                                                <th scope="col" class="sort" data-sort="completion"><?php echo e(__('Amount Due')); ?></th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payKey => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->created_at)->format('M d, Y')); ?>

                                                </td>
                                                <td><?php echo e($payment->name_of_card); ?></td>
                                                <td><?php echo e($payment->transaction_id ?? '--'); ?></td>
                                                <td><a href="<?php echo e(Storage::url('app/public/Invoice/'.$payment->event_id.'/'.$payment->invoices)); ?>" download style="    color: #1551c9 !important;"><?php echo e(ucfirst($payment->invoices )); ?></a>
                                                </td>
                                                <td>$<?php echo e($event->total); ?></td>
                                                <td>$<?php echo e($payment->amount); ?></td>
                                                <td><?php echo e($event->total - $payinfo[$payKey]->deposits - $payinfo[$payKey]->paymentCredit - $payinfo[$payKey]->collect_amount); ?>

                                                </td>
                                            </tr>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <hr>
                                            <tr style="    background: aliceblue;">
                                                <td></td>
                                                <td colspan='3'><b>Deposits on File:</b></td>
                                                <td colspan='3'>
                                                    <?php echo e(( $beforedeposit->deposits != 0) ? '$'.$beforedeposit->deposits : '--'); ?>

                                                </td>
                                            </tr>
                                            <tr style="    background: aliceblue;">
                                                <td></td>
                                                <td colspan='3'><b>Payments /Credit (-):</b></td>
                                                <td colspan='3'>
                                                    <?php echo e(( $beforedeposit->paymentCredit != 0 ) ? '$'.$beforedeposit->paymentCredit : '--'); ?>

                                                </td>
                                            </tr>
                                            <tr style="background: darkgray;">
                                                <td></td>
                                                <td colspan='3'><b>Adjustments:</b></td>
                                                <td colspan='3'><?php echo e(($adj != 0) ? '$'.$adj : '--'); ?></td>
                                            </tr>
                                            <tr style=" background: #c0e3c0;">
                                                <td></td>
                                                <td colspan='3'><b>Latefee:</b></td>
                                                <td colspan='3'><?php echo e(($latefee != 0) ? '$'. $latefee :'--'); ?></td>
                                            </tr>
                                            <tr style="    background: floralwhite;">
                                                <td></td>
                                                <td colspan='3'><b>Total Amount Recieved:</b></td>
                                                <td colspan='3'>
                                                    <?php echo e(((isset($beforedeposit->deposits) && isset($beforedeposit->paymentCredit) ? $beforedeposit->deposits + $beforedeposit->paymentCredit : 0) + $collect_amount<=0) ? '--' : '$'.((isset($beforedeposit->deposits) && isset($beforedeposit->paymentCredit) ? $beforedeposit->deposits + $beforedeposit->paymentCredit : 0) + $collect_amount)); ?>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <?php if(isset($files) && !empty($files)): ?>
                                <h3>Attachments</h3>
                                <hr>
                                <div class="col-md-12" style="display:flex;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Attachment</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(basename($file)); ?></td>
                                                <td>
                                                    <a href="<?php echo e(Storage::url($file)); ?>" download style=" position: absolute;color: #1551c9 !important">
                                                        View Document</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/meeting/detailed_view.blade.php ENDPATH**/ ?>