<?php
$pay = App\Models\PaymentLogs::where('event_id', $event->id)->get();
$billing = App\Models\Billing::where('event_id', $event->id)->first();
$total = 0;
foreach ($pay as $p) {
    $total += $p->amount;
}
$total = $total + $billing->deposits + $billing->paymentCredit;
/* $total = 0;
foreach ($pay as $p) {
    $total += $p->amount;
} */
?>
<div class="row">
    <div class="col-md-12">
        <dl class="row">
            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Type')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e($event->type); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Customer Name')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e($event->name); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Email')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e($event->email); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Phone')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e($event->phone); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Address')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e($event->lead_address); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Date')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e(\Auth::user()->dateFormat($event->start_date)); ?></span></dd>


            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__(' Time')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class="">
                    <?php if($event->start_time == $event->end_time): ?>
                    --
                    <?php else: ?>
                    <?php echo e(date('h:i A', strtotime($event->start_time))); ?> -
                    <?php echo e(date('h:i A', strtotime($event->end_time))); ?>

                    <?php endif; ?>
                </span>
            </dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Training Location')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e($event->venue_selection); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Invoice Amount')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class="">$<?php echo e(number_format($event->total)); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__(' Amount Due')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class="">$<?php echo e(number_format($event->total - $total)); ?></span></dd>


            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Training Created')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class=""><?php echo e(\Auth::user()->dateFormat($event->created_at)); ?></span></dd>

            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Any Special Requirements')); ?></span></dt>
            <?php if($event->spcl_req): ?>
            <dd class="col-md-6 need_half"><span class=""><?php echo e($event->spcl_req); ?></span></dd>
            <?php else: ?>
            <dd class="col-md-6 need_half"><span class="">--</span></dd>
            <?php endif; ?>
            <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Status')); ?></span></dt>
            <dd class="col-md-6 need_half"><span class="">

                    
                <?php

                $pay = App\Models\PaymentLogs::where('event_id', $event->id)->get();
                $deposit = App\Models\Billing::where('event_id', $event->id)->first() ?? [];
                $total = 0;
                foreach ($pay as $p) {
                    $total += $p->amount;
                }
                $totalALL = '$' . $total + @$deposit->deposits + @$deposit->paymentCredit;
                ?>

                <?php if(\App\Models\Billing::where('event_id',$event->id)->exists()): ?>
                <?php $bill = \App\Models\Billing::where('event_id', $event->id)->pluck('status')->first();

                if ($event->total == ($total + @$deposit->deposits + @$deposit->paymentCredit)) {
                    $bill = 4;
                } else {
                    $bill = 3;
                }
                ?>
                <?php if($bill == 1): ?>
                <span class=" text-info"><?php echo e(__(\App\Models\Billing::$status[$bill])); ?></span>
                <?php elseif($bill == 2): ?>
                <span class=" text-warning "><?php echo e(__(\App\Models\Billing::$status[$bill])); ?></span>
                <?php elseif($bill == 3): ?>
                <span class=" text-warning "><?php echo e(__(\App\Models\Billing::$status[$bill])); ?></span>
                <?php else: ?>
                <span class=" text-success"><?php echo e(__(\App\Models\Billing::$status[$bill])); ?></span>
                <?php endif; ?>
                <?php else: ?>
                <span class=" text-danger "><?php echo e(__(\App\Models\Billing::$status[0])); ?></span>
                <?php endif; ?>
            </dd>
        </dl>
    </div>
    <div class="w-100 text-end pr-2">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Payment')): ?>
        <div class="action-btn bg-warning ms-2">
            <a href="<?php echo e(route('meeting.agreement',urlencode(encrypt($event->id)))); ?>">
                <button data-bs-toggle="tooltip" title="<?php echo e(__('View Invoice')); ?>" class="btn btn-sm btn-secondary btn-icon m-1">
                    <i class="fa fa-print"></i></button>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/billing/view.blade.php ENDPATH**/ ?>