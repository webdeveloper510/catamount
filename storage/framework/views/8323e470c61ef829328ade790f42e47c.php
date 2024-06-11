<div class="row">
    <div class="col-lg-12 half-col">
        <div class="">
            <dl class="row">
                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Lead')); ?></span></dt>
                <?php if($meeting->attendees_lead != 0): ?>
                <dd class="col-md-6"><span class=""><?php echo e(!empty($meeting->attendees_leads->leadname)?$meeting->attendees_leads->leadname:'--'); ?></span>
                </dd>
                <?php else: ?>
                <dd class="col-md-6"><span class=""><?php echo e($meeting->eventname); ?></span></dd>
                <?php endif; ?>

                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Date')); ?></span></dt>
                <dd class="col-md-6"><span class="">
                        <?php if($meeting->start_date == $meeting->end_date): ?>
                        <?php echo e(\Auth::user()->dateFormat($meeting->start_date)); ?>

                        <?php else: ?>
                        <?php echo e(\Auth::user()->dateFormat($meeting->start_date)); ?> -
                        <?php echo e(\Auth::user()->dateFormat($meeting->end_date)); ?>

                        <?php endif; ?>
                    </span></dd>

                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Time')); ?></span></dt>
                <dd class="col-md-6"><span class="">
                        <?php if($meeting->start_time == $meeting->end_time): ?>
                        --
                        <?php else: ?>
                        <?php echo e(date('h:i A', strtotime($meeting->start_time))); ?> -
                        <?php echo e(date('h:i A', strtotime($meeting->end_time))); ?>

                        <?php endif; ?>
                    </span>
                </dd>

                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Guest Count')); ?></span></dt>
                <dd class="col-md-6"><span class=""><?php echo e($meeting->guest_count); ?></span></dd>

                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Training Location')); ?></span></dt>
                <dd class="col-md-6"><span class=""><?php echo e($meeting->venue_selection); ?></span></dd>

                <!-- <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Function')); ?></span></dt>
                <dd class="col-md-6"><span class=""><?php echo e($meeting->function); ?></span></dd> -->

                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Training Type')); ?></span></dt>
                <dd class="col-md-6"><span class=""><?php echo e($meeting->type); ?></span></dd>

                <dt class="col-md-6"><span class="h6 text-sm mb-0"><?php echo e(__('Assigned Staff')); ?></span></dt>
                <dd class="col-md-6"><span class=""><?php echo e($name); ?></span></dd>

                <dt class="col-md-6"><span class="h6 text-sm mb-0"><?php echo e(__('Created')); ?></span></dt>
                <dd class="col-md-6"><span class=""><?php echo e(\Auth::user()->dateFormat($meeting->created_at)); ?></span>
                </dd>
            </dl>
        </div>

    </div>

    <div class="w-100 text-end pr-2">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Meeting')): ?>
        <div class="action-btn bg-info ms-2">
            <a href="<?php echo e(route('meeting.edit',$meeting->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white" data-bs-toggle="tooltip" data-title="<?php echo e(__('Edit Call')); ?>" title="<?php echo e(__('Edit')); ?>"><i class="ti ti-edit"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/meeting/view.blade.php ENDPATH**/ ?>