
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Lead Client')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="page-header-title">
    <?php echo e(__('Lead Client')); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('siteusers')); ?>"><?php echo e(__('Clients')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('lead_customers')); ?>"><?php echo e(__('Lead Clients')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Client Details')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-field">
    <div id="wrapper">

        <div id="page-content-wrapper">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="row align-items-center">
                                    <div class="table-responsive">
                                        <table class="table datatable" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="sort" data-sort="name"><?php echo e(__('Name')); ?></th>
                                                    <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Training Type')); ?></th>
                                                    <th scope="col" class="sort"><?php echo e(__('Guest Count')); ?></th>
                                                    <th scope="col" class="sort"><?php echo e(__('Event Date')); ?></th>
                                                    <!--<th scope="col" class="sort"><?php echo e(__('Function')); ?></th>-->
                                                    <!--<th scope="col" class="sort"><?php echo e(__('Bar')); ?></th>-->
                                                    <!-- <th scope="col" class="sort"><?php echo e(__('Proposal Status')); ?></th> -->
                                                    <th scope="col" class="sort"><?php echo e(__('Created On')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <!-- <a href="<?php echo e(route('lead.info',urlencode(encrypt($lead->id)))); ?>"
                                                        data-size="md" title="<?php echo e(__('Lead Details')); ?>"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;"> -->
                                                        <?php echo e(ucfirst($lead->name)); ?>

                                                        <!-- </a> -->
                                                    </td>
                                                    <td><b> <?php echo e(ucfirst($lead->type)); ?></b></td>
                                                    <td>
                                                        <span class="budget"><?php echo e($lead->guest_count); ?></span>
                                                    </td>
                                                    <td><?php echo e(\Auth::user()->dateFormat($lead->start_date)); ?></td>

                                                    <!--<td><?php echo e(ucfirst($lead->function)); ?></td>-->
                                                    <!--<td><?php echo e(($lead->bar)); ?></td>-->

                                                    <!-- <td><?php echo e(__(\App\Models\Lead::$status[$lead->status])); ?></td> -->
                                                    <td><?php echo e(\Auth::user()->dateFormat($lead->created_at)); ?></td>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container-fluid xyz mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card" id="useradd-1">
                                <div class="card-body table-border-style">
                                    <h3>Attachments</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Attachment</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $docs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(Storage::disk('public')->exists($doc->filepath)): ?>
                                                <tr>
                                                    <td><?php echo e($doc->filename); ?></td>
                                                    <td><a href="<?php echo e(Storage::url('app/public/'.$doc->filepath)); ?>" download style="color: teal;" title="Download">View Document<i class="fa fa-download"></i></a>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" id="useradd-1">
                                <div class="card-body table-border-style">
                                    <h3>Notes</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Notes</th>
                                                <th>Created By</th>
                                                <th>Date</th>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(ucfirst($note->notes)); ?></td>
                                                    <td><?php echo e((App\Models\User::where('id',$note->created_by)->first()->name)); ?>

                                                    </td>
                                                    <td><?php echo e(\Auth::user()->dateFormat($note->created_at)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" id="useradd-1">
                                <div class="card-body table-border-style">
                                    <h3>Upload Documents</h3>
                                    <?php echo e(Form::open(array('route' => ['lead.uploaddoc', $lead->id],'method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))); ?>

                                    <label for="customerattachment">Attachment</label>
                                    <input type="file" name="customerattachment" id="customerattachment" class="form-control" required>
                                    <input type="submit" value="Submit" class="btn btn-primary mt-4" style="float: right;">
                                    <?php echo e(Form::close()); ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body table-border-style">
                                    <h3>Add Notes/Comments</h3>
                                    <form method="POST" id="addnotes">
                                        <?php echo csrf_field(); ?>
                                        <label for="notes">Notes</label>
                                        <input type="text" class="form-control" name="notes" required>
                                        <input type="submit" value="Submit" class="btn btn-primary mt-4" style=" float: right;">
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function() {
            $('#addnotes').on('submit', function(e) {
                e.preventDefault();
                var id = <?php echo  $lead->id; ?>;
                var notes = $('input[name="notes"]').val();
                var createrid = <?php echo Auth::user()->id; ?>;

                $.ajax({
                    url: "<?php echo e(route('addleadnotes', ['id' => $lead->id])); ?>", // URL based on the route with the actual user ID
                    type: 'POST',
                    data: {
                        "notes": notes,
                        "createrid": createrid,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        location.reload();
                    }
                });

            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/customer/leaduserview.blade.php ENDPATH**/ ?>