<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Leads')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="page-header-title">
    <?php echo e(__('Leads')); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Leads')); ?></li>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Lead')): ?>
<a href="#" data-url="<?php echo e(route('lead.create',['lead',0])); ?>" data-size="lg" data-ajax-popup="true"
    data-bs-toggle="tooltip" data-title="<?php echo e(__('Create New Lead')); ?>" title="<?php echo e(__('Create')); ?>"
    class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-plus"></i>
</a>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-field">

    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz p0">

                <div class="row">
                    <div class="col-lg-12 ">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col" class="sort" data-sort="name"><?php echo e(__('Lead')); ?></th> -->
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Name')); ?> <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Email')); ?> <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort"><?php echo e(__('Status')); ?> <span class="opticy"> dddd</span></th>
                                                <!-- <th scope="col" class="sort"><?php echo e(__('Proposal Status')); ?></th> -->
                                                <th scope="col" class="sort"><?php echo e(__('Lead Status')); ?><span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort"><?php echo e(__('Created On')); ?><span class="opticy"> dddd</span></th>
                                                <?php if(Gate::check('Show Lead') || Gate::check('Edit Lead') ||
                                                Gate::check('Delete Lead')): ?>
                                                <th scope="col" class="text-end"><?php echo e(__('Action')); ?> <span class="opticy"> dddd</span></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo e(route('lead.info',urlencode(encrypt($lead->id)))); ?>"
                                                        data-size="md" title="<?php echo e(__('Lead Details')); ?>"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;">
                                                        <b> <?php echo e(ucfirst($lead->name)); ?></b>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="budget"><?php echo e($lead->email); ?></span>
                                                </td>
                                                <td><select name="lead_status" id="lead_status" class="form-select"
                                                        data-id="<?php echo e($lead->id); ?>">
                                                        <?php $__currentLoopData = $statuss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>"
                                                            <?php echo e(isset($lead->lead_status) && $lead->lead_status == $key ? "selected" : ""); ?>>
                                                            <?php echo e($stat); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                                <td>
                                                    <?php if($lead->status == 0): ?>
                                                    <span
                                                        class="badge bg-info p-2 px-3 rounded"><?php echo e(__(\App\Models\Lead::$status[$lead->status])); ?></span>
                                                    <?php elseif($lead->status == 1): ?>
                                                    <span
                                                        class="badge bg-warning p-2 px-3 rounded"><?php echo e(__(\App\Models\Lead::$status[$lead->status])); ?></span>
                                                    <?php elseif($lead->status == 2): ?>
                                                    <span
                                                        class="badge bg-secondary p-2 px-3 rounded"><?php echo e(__(\App\Models\Lead::$status[$lead->status])); ?></span>
                                                    <?php elseif($lead->status == 3): ?>
                                                    <span
                                                        class="badge bg-danger p-2 px-3 rounded"><?php echo e(__(\App\Models\Lead::$status[$lead->status])); ?></span>
                                                    <?php elseif($lead->status == 4): ?>
                                                    <span
                                                        class="badge bg-success p-2 px-3 rounded"><?php echo e(__(\App\Models\Lead::$status[$lead->status])); ?></span>
                                                    <?php elseif($lead->status == 5): ?>
                                                    <span
                                                        class="badge bg-warning p-2 px-3 rounded"><?php echo e(__(\App\Models\Lead::$status[$lead->status])); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e(\Auth::user()->dateFormat($lead->created_at)); ?></td>
                                                <?php if(Gate::check('Show Lead') || Gate::check('Edit Lead') ||
                                                Gate::check('Delete Lead') ||Gate::check('Manage Lead') ): ?>
                                                <td class="text-end">
                                                    <?php if($lead->status == 4): ?>
                                                    <div class="action-btn bg-secondary ms-2">
                                                        <a href="<?php echo e(route('meeting.create',['meeting',0])); ?>"
                                                            id="convertLink" data-size="md" data-url="#"
                                                            data-bs-toggle="tooltip" data-title="<?php echo e(__('Convert')); ?>"
                                                            title="<?php echo e(__('Convert To Event')); ?>" data-id="<?php echo e($lead->id); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="fas fa-exchange-alt"></i> </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if($lead->status == 0 ): ?>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="javascript:void(0);" data-size="md"
                                                            data-url="<?php echo e(route('lead.shareproposal',urlencode(encrypt($lead->id)))); ?>"
                                                            data-ajax-popup="true" data-bs-toggle="tooltip"
                                                            data-title="<?php echo e(__('Proposal')); ?>"
                                                            title="<?php echo e(__('Share Proposal')); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-share"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if($lead->status >= 2 ): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="<?php echo e(route('lead.review',urlencode(encrypt($lead->id)))); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white "
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Review')); ?>"
                                                            data-title="<?php echo e(__('Review Lead')); ?>">
                                                            <i class="fas fa-pen"></i></a>
                                                    </div>
                                                   <?php endif; ?>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="<?php echo e(route('lead.clone',urlencode(encrypt($lead->id)))); ?>"
                                                            data-size="md" data-url="#" data-bs-toggle="tooltip"
                                                            title="<?php echo e(__('Clone')); ?>" data-title="<?php echo e(__('Clone')); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="fa fa-clone"></i>
                                                        </a>
                                                    </div>
                                                    <?php if($lead->status >= 1): ?>
                                                    <div class="action-btn bg-success ms-2">
                                                        <a href="<?php echo e(route('lead.proposal',urlencode(encrypt($lead->id)))); ?>"
                                                            data-bs-toggle="tooltip" data-title="<?php echo e(__('Proposal')); ?>"
                                                            title="<?php echo e(__('View Proposal')); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                            <i class="ti ti-receipt"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Lead')): ?>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <!-- <a href="<?php echo e(route('lead.show',$lead->id)); ?>" title="<?php echo e(__('Quick View')); ?>"
                                                            data-ajax-popup="true" data-title="<?php echo e(__('Lead Details')); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i> -->
                                                            <a href="javascript:void(0);" data-size="md"
                                                            data-url="<?php echo e(route('lead.show',$lead->id)); ?>"
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Quick View')); ?>"
                                                            data-ajax-popup="true" data-title="<?php echo e(__('Lead Details')); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if($lead->status == 0): ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Lead')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="<?php echo e(route('lead.edit',$lead->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white "
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>"
                                                            data-title="<?php echo e(__('Edit Lead')); ?>"><i
                                                                class="ti ti-edit"></i></a>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Lead')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' =>
                                                        ['lead.destroy', $lead->id]]); ?>

                                                        <a href="javascript:void(0);"
                                                            class="mx-3 btn btn-sm  align-items-center text-white show_confirm"
                                                            data-bs-toggle="tooltip" title='Delete'>
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
$(document).ready(function() {
    $('#convertLink').on('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        
        var leadId = $(this).data('id');
        
        // Set the lead ID in localStorage after a delay
        setTimeout(function() {
            localStorage.setItem('leadId', leadId);
            
            // Redirect to the specified URL after setting the item
            window.location.href = "<?php echo e(route('meeting.create',['meeting',0])); ?>";
        }, 1000); // Adjust the delay time as needed (1000 milliseconds = 1 second)
    });
});
</script>
<script>
function duplicate(id) {
    var url = "<?php echo e(route('lead.create',['lead',0])); ?>";
    $.ajax({
        url: "<?php echo e(route('meeting.lead')); ?>",
        type: 'POST',
        data: {
            "venue": venu,
            "_token": "<?php echo e(csrf_token()); ?>",
        },
        success: function(data) {
            console.log(data);
        }
    });
}
$('select[name= "lead"]').on('change', function() {
    $('#breakfast').hide();
    $('#lunch').hide();
    $('#dinner').hide();
    $('#wedding').hide();
    var venu = this.value;
    $.ajax({
        url: "<?php echo e(route('meeting.lead')); ?>",
        type: 'POST',
        data: {
            "venue": venu,
            "_token": "<?php echo e(csrf_token()); ?>",
        },
        success: function(data) {
            console.log(data);
            venue_str = data.venue_selection;
            venue_arr = venue_str.split(",");
            func_str = data.function;
            func_arr = func_str.split(",");
            $('input[name ="company_name"]').val(data.company_name);
            $('input[name ="name"]').val(data.name);
            $('input[name ="phone"]').val(data.phone);
            $('input[name ="relationship"]').val(data.relationship);
            $('input[name ="start_date"]').val(data.start_date);
            // $('input[name ="end_date"]').val(data.end_date);
            $('input[name ="start_time"]').val(data.start_time);
            $('input[name ="end_time"]').val(data.end_time);
            $('input[name ="rooms"]').val(data.rooms);
            $('input[name ="email"]').val(data.email);
            $('input[name ="lead_address"]').val(data.lead_address);
            $("select[name='type'] option[value='" + data.type + "']").prop("selected", true);
            $("input[name='bar'][value='" + data.bar + "']").prop('checked', true);
            // $("select[name='user'] option[value='"+data.assigned_user+"']").prop("selected", true);
            $("input[name='user[]'][value='" + data.assigned_user + "']").prop('checked', true);
            $.each(venue_arr, function(i, val) {
                $("input[name='venue[]'][value='" + val + "']").prop('checked', true);
            });

            $.each(func_arr, function(i, val) {
                $("input[name='function[]'][value='" + val + "']").prop('checked', true);
            });

            $('input[name ="guest_count"]').val(data.guest_count);

            var checkedFunctions = $('input[name="function[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            console.log("check", checkedFunctions);

            if (checkedFunctions.includes('Breakfast') || checkedFunctions.includes('Brunch')) {
                // console.log("fdsfdsfds")
                $('#breakfast').show();
            }
            if (checkedFunctions.includes('Lunch')) {
                $('#lunch').show();
            }
            if (checkedFunctions.includes('Dinner')) {
                $('#dinner').show();
            }
            if (checkedFunctions.includes('Wedding')) {
                $('#wedding').show();
            }
        }
    });
});
$('select[name = "lead_status"]').on('change', function() {
    var val = $(this).val();
    var id = $(this).attr('data-id');
    var url = "<?php echo e(route('lead.changeleadstat')); ?>";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            "status": val,
            'id': id,
            "_token": "<?php echo e(csrf_token()); ?>"
        },
        success: function(data) {
            if(val == 1){
                show_toastr('Primary', 'Lead Activated', 'success');
            }else{
                show_toastr('Success', 'Lead InActivated', 'danger');

            }
            console.log(val)
        
        }
    });
})
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/lead/index.blade.php ENDPATH**/ ?>