<?php
$agreestatus= \App\Models\Meeting::$status;
?>

<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Trainings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(__('Trainings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Trainings')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Training')): ?>
<div class="col-12 text-end mt-3">
    <a href="<?php echo e(route('meeting.create',['meeting',0])); ?>">
        <button id="rmLocalStorage" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" class="btn btn-sm btn-primary btn-icon m-1">
            <i class="ti ti-plus"></i></button>
    </a>
</div>
<script>
    document.getElementById('rmLocalStorage').onclick = function() {
        localStorage.removeItem('leadId');
    }
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('filter'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-field">
    <div id="wrapper0">
        <div id="page-content-wrapper" class="p0">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <div class="table-responsive overflow_hidden">
                                    <table id="datatable" class="table datatable align-items-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Leads')); ?> <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="status"><?php echo e(__('Status')); ?> <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    <?php echo e(__('Date Start')); ?> <span class="opticy"> dddd</span>
                                                </th>
                                                <th scope="col" class="sort" data-sort="completion"><?php echo e(__('Trainings')); ?>

                                                    <span class="opticy"> dddd</span>
                                                </th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    <?php echo e(__('Assigned Staff')); ?> <span class="opticy"> dddd</span>
                                                </th>
                                                <?php if(Gate::check('Show Training') || Gate::check('Edit Training') ||
                                                Gate::check('Delete Training')): ?>
                                                <th scope="col" class="text-end"><?php echo e(__('Action')); ?> <span class="opticy"> dddd</span></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo e(route('meeting.edit', $meeting->id)); ?>" data-size="md" data-title="<?php echo e(__('Training Details')); ?>" class="action-item text-primary" style=" color: #1551c9 !important;">
                                                        <?php if($meeting->attendees_lead != 0): ?>
                                                        <?php echo e(ucfirst(\App\Models\Lead::where('id',$meeting->attendees_lead)->pluck('leadname')->first())); ?>

                                                        <?php else: ?>
                                                        <?php echo e(ucfirst($meeting->eventname)); ?>

                                                        <?php endif; ?>
                                                    </a>
                                                </td>
                                                <td>

                                                    <select name="drop_status" id="drop_status" class="form-select" data-id="<?php echo e($meeting->id); ?>">
                                                        <?php $__currentLoopData = $agreestatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>" <?php echo e(isset($meeting->status) && $meeting->status == $key ? "selected" : ""); ?>>
                                                            <?php echo e($stat); ?>

                                                        </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>


                                                    
                                                </td>
                                                <td>
                                                    <span class="budget"><?php echo e(\Auth::user()->dateFormat($meeting->start_date)); ?></span>
                                                </td>
                                                <td>
                                                    <span class="budget"><?php echo e($meeting->type); ?></span>
                                                </td>

                                                <td>
                                                    <span class="budget"><?php echo e(App\Models\User::where('id',$meeting->user_id)->pluck('name')->first()); ?></span>
                                                </td>
                                                <?php if(Gate::check('Show Training') || Gate::check('Edit Training') ||
                                                Gate::check('Delete Training')): ?>
                                                <td class="text-end">
                                                    <?php if($meeting->status == 0): ?>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" data-size="md" data-url="<?php echo e(route('meeting.share', $meeting->id)); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="<?php echo e(__('Event Details')); ?>" title="<?php echo e(__('Share')); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-share"></i>
                                                        </a>
                                                    </div>
                                                    <?php elseif($meeting->status == 1 ||$meeting->status == 4): ?>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" data-size="md" data-title="<?php echo e(__('Agreement')); ?>" title="<?php echo e(__('Agreement Sent')); ?>" data-bs-toggle="tooltip" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-clock"></i>
                                                        </a>
                                                    </div>
                                                    <?php elseif($meeting->status == 2): ?>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="<?php echo e(route('meeting.review',urlencode(encrypt($meeting->id)))); ?>" data-size="md" data-title="<?php echo e(__('Agreement')); ?>" title="<?php echo e(__('Review Agreement')); ?>" data-bs-toggle="tooltip" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="fa fa-pen"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if(App\Models\Billing::where('event_id',$meeting->id)->exists()): ?>
                                                    <div class="action-btn bg-success ms-2">
                                                        <a href="<?php echo e(route('meeting.agreement',urlencode(encrypt($meeting->id)))); ?>" target="_blank" data-bs-toggle="tooltip" data-title="<?php echo e(__('Agreement')); ?>" title="<?php echo e(__('View Agreement')); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                            <i class="ti ti-receipt"></i>
                                                        </a>
                                                    </div>

                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Training')): ?>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" data-size="md" data-url="<?php echo e(route('meeting.show', $meeting->id)); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="<?php echo e(__('Training Details')); ?>" title="<?php echo e(__('Quick View')); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Training')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="<?php echo e(route('meeting.edit', $meeting->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white" data-bs-toggle="tooltip" data-title="<?php echo e(__('Details')); ?>" title="<?php echo e(__('Edit')); ?>"><i class="ti ti-edit"></i></a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Training')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' =>
                                                        ['meeting.destroy', $meeting->id]]); ?>


                                                        <a href="#!" class="mx-3 btn btn-sm   align-items-center text-white show_confirmdlt" data-bs-toggle="tooltip" title='Delete'>
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
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
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<script>
    $('select[name="drop_status"]').on('change', function() {
        var val = $(this).val();
        var id = $(this).attr('data-id');
        var url = "<?php echo e(route('event.changeagreementstat')); ?>";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "status": val,
                'id': id,
                "_token": "<?php echo e(csrf_token()); ?>"
            },
            success: function(data) {
                console.log(data)
                if (data == 1) {

                    show_toastr('Primary', 'Event Status Updated Successfully', 'success');
                    location.reload();
                } else {
                    show_toastr('Success', 'Event Status is not updated', 'danger');

                }
            }
        });
    })


    /*  $(document).on('change', 'select[name=parent]', function() {

         var parent = $(this).val();

         getparent(parent);
     });

     function getparent(bid) {

         $.ajax({
             url: '<?php echo e(route("meeting.getparent")); ?>',
             type: 'POST',
             data: {
                 "parent": bid,
                 "_token": "<?php echo e(csrf_token()); ?>",
             },
             success: function(data) {
                 console.log(data);
                 $('#parent_id').empty();
                 {
                     {
                         $('#parent_id').append('<option value=""><?php echo e(__("Select Parent")); ?></option>');
                     }
                 }
                 $.each(data, function(key, value) {
                     $('#parent_id').append('<option value="' + key + '">' + value + '</option>');
                 });
             }
         });
     } */
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/meeting/index.blade.php ENDPATH**/ ?>