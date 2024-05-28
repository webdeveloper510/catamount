<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Campaign')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="page-header-title">
        <?php echo e(__('Campaign')); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('customer.index')); ?>"><?php echo e(__('Campaigns')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('View Campaigns')); ?></li>
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
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Campaign Title')); ?> <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Campaign Type')); ?> <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Created At')); ?> <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort"><?php echo e(__('Action')); ?> <span class="opticy"> dddd</span></th>                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $campaignlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><span class="budget"><b><?php echo e(ucfirst($campaign->title)); ?></b></span></td>
                                                    <td><span class="budget"><b><?php echo e(ucfirst($campaign->type)); ?></b></span></td>
                                                    <td><span class="budget"><?php echo e(\Carbon\Carbon::parse($campaign->created_at)->format('d M, Y')); ?></span></td>
                                                    <td><button onclick="toggleRowVisibility(<?php echo $key + 1 ?>)" style="border-radius: 35px;">
                                                    <span class="dash-arrow"><i class="ti ti-chevron-right"></i> </span>
                                                    </button></td>
                                                </tr>
                                                <tr class="hidden-row" id="hiddenRow<?php echo e($key + 1); ?>" style="display: none;    background: #e6ebf2;">
                                                    <th scope="col">Users</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col" >Actions</th>
                                                    <th></th>
                                                </tr>
                                                <tr class="hidden-row" id="hiddenRowContent<?php echo e($key + 1); ?>" style="display: none;    background: #e6ebf2;">
                                                    <td><span class="budget"><b><?php echo e(ucfirst($campaign->recipients)); ?></b></span></td>
                                                    <td><span class="budget"><b><?php echo e(ucfirst($campaign->description)); ?></b></span></td>
                                                    <td><button type="button"style="border-radius: 35px;" title="Resend" onclick="resendcampaign(<?php  echo $campaign->id?>)">
                                                    <i class="ti ti-share"></i>
                                                </button></td>
                                                <td></td>
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
<script>
    function toggleRowVisibility(rowNumber) {
        var row = document.getElementById('hiddenRow' + rowNumber);
        var rowContent = document.getElementById('hiddenRowContent' + rowNumber);
        if (row.style.display === "table-row") {
            row.style.display = "none";
            rowContent.style.display = "none";
        } else {
            row.style.display = "table-row";
            rowContent.style.display = "table-row";
        }
    }
    function resendcampaign(id){
       $.ajax({
                url: "<?php echo e(route('resend-campaign')); ?>",
                type: 'POST',
                data: {
                    "id": id,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    console.log(data);
                   
                }
            });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/customer/campaignlist.blade.php ENDPATH**/ ?>