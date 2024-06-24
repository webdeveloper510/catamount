<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Emails')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="page-header-title">
    <?php echo e(__('Email Communication')); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('email.index')); ?>"><?php echo e(__('Emails')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Communication')); ?></li>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <div class="chat-container" style="padding: 35px;">
                                        <?php $__currentLoopData = $emailCommunications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $communication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="conversation border p-3 rounded"
                                                    style="cursor: pointer; background-color: #cce7e6;">
                                                    <strong>Subject: </strong><?php echo e(ucfirst($communication->subject)); ?>

                                                    <span style="float:right;"><b>Sent:</b>
                                                        <?php echo e($communication->created_at->format('M d, Y H:i A')); ?>

                                                    </span>
                                                </div>
                                                <div class="email-details" style="display: none;">
                                                    <div class="card mb-3"
                                                        style="box-shadow: 0 6px 30px rgb(182 186 203 / 54%);">
                                                        <div class="card-body">
                                                            <p class="card-text"><strong>To:</strong>
                                                                <?php echo e($communication->email); ?></p>
                                                            <p class="card-text"><strong>Message:</strong>
                                                                <?php echo e($communication->content); ?></p>
                                                            <?php if($communication->attachments != ''): ?>
                                                            <p class="card-text"><strong>Attachments:</strong>
                                                                <a href="<?php echo e(Storage::url('app/public/Proposal_attachments/' . $communication->lead_id . '/' . $communication->attachments)); ?>"
                                                                    download><?php echo e($communication->attachments); ?></a>
                                                            </p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <?php $prop = App\Models\Proposal::where('proposal_id', $communication->id)->first(); ?>
                                            <?php if(isset($prop) && !empty($prop)): ?>
                                            <div class="col-md-6 offset-md-6">
                                                <div class="proposal-notes border p-3 rounded"
                                                    style="background-color:#d6e9e9">
                                                    <strong>Customer Response:</strong> <?php echo e($prop->notes); ?>

                                                    <div style="    margin-bottom: 15px;">
                                                        <span style="float:right;"><b>Signed on :</b>
                                                            <?php echo e($prop->created_at->format('M d, Y H:i A')); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Get all conversation elements
var conversationThreads = document.querySelectorAll('.conversation');

// Attach click event listener to each conversation thread
conversationThreads.forEach(function(thread) {
    thread.addEventListener('click', function() {
        // Toggle visibility of the email details
        var emailDetails = this.nextElementSibling;
        emailDetails.style.display = (emailDetails.style.display === 'none') ? 'block' : 'none';
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/email_integration/conversation.blade.php ENDPATH**/ ?>