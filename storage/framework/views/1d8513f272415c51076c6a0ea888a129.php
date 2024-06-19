<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Lead Information')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="page-header-title">
    <?php echo e(__('Lead Information')); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('lead.index')); ?>"><?php echo e(__('Leads')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Lead Details')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$converted_to_event = App\Models\Meeting::where('attendees_lead', $lead->id)->exists();
?>
<div class="row card" style="display:none">
    <div class="col-md-12">
        <h5 class="headings"><b>Billing Summary - ESTIMATE</b></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align:left; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">
                        Name : <?php echo e(ucfirst($lead->name)); ?></th>
                    <th colspan="2" style="padding:5px 0px;margin-left: 5px;font-size:13px"></th>
                    <th colspan="3" style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;">
                        Date:<?php echo date("d/m/Y"); ?> </th>
                    <th style="text-align:left; font-size:13px;padding:5px 5px; margin-left:5px;">
                        Event: <?php echo e(ucfirst($lead->type)); ?></th>
                </tr>
                <tr style="background-color:#063806;">
                    <th>Description</th>
                    <th colspan="2"> Additional</th>
                    <th>Cost</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Training Location Rental</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e($billing['venue_rental']['cost'] ?? 0); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        <?php echo e($billing['venue_rental']['quantity'] ?? 1); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e($total[] = ($billing['venue_rental']['cost']?? 0)  * ($billing['venue_rental']['quantity'] ?? 1)); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        <?php echo e($lead->venue_selection); ?>

                    </td>
                </tr>

                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Brunch / Lunch /
                        Dinner Package</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e($billing['food_package']['cost'] ?? 0); ?></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        <?php echo e($billing['food_package']['quantity'] ?? 1); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e($total[] = ($billing['food_package']['cost'] ?? 0) * ($billing['food_package']['quantity'] ?? 1)); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        <?php echo e($lead->function); ?>

                    </td>

                </tr>

                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Hotel Rooms</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e($billing['hotel_rooms']['cost'] ?? 0); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        <?php echo e($billing['hotel_rooms']['quantity'] ?? 1); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">

                        $<?php echo e($total[] =($billing['hotel_rooms']['cost'] ?? 0)* ( $billing['hotel_rooms']['quantity']??1)); ?>



                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>

                <tr>
                    <td>-</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Total</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e(array_sum($total)); ?>

                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Sales, Occupancy
                        Tax</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e(7* array_sum($total)/100); ?>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                        Service Charges & Gratuity</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e(20 * array_sum($total)/100); ?>

                    </td>

                    <td></td>
                </tr>
                <tr>
                    <td>-</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>

                    <td></td>
                </tr>
                <tr>
                    <td style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">
                        Grand Total / Estimated Total</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        $<?php echo e($grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100); ?>

                    </td>

                    <td></td>
                </tr>
                <tr>
                    <td style="background-color:#d7e7d7; padding:5px 5px; margin-left:5px;font-size:13px;">
                        Deposits on file</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="3" style="background-color:#d7e7d7;padding:5px 5px; margin-left:5px;font-size:13px;">
                        No Deposits yet
                    </td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
                <tr>
                    <td style="background-color:#ffff00;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                        balance due</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;background-color:#9fdb9f;">
                        $<?php echo e($grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100); ?>


                    </td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
            </tbody>

        </table>
    </div>
</div>
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
                                                <!-- <th scope="col" class="sort" data-sort="name"><?php echo e(__('Lead')); ?></th> -->
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Name')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Phone')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Email')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Address')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Status')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Training')); ?></th>
                                                <th scope="col" class="sort"><?php echo e(__('Converted to Training')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(ucfirst($lead->name)); ?></td>
                                                <td><?php echo e($lead->primary_contact); ?></td>
                                                <td><?php echo e($lead->email ?? '--'); ?></td>
                                                <td><?php echo e($lead->lead_address ?? '--'); ?></td>

                                                <td><?php echo e(__(\App\Models\Lead::$stat[$lead->lead_status])); ?></td>
                                                <td><?php echo e($lead->type); ?></td>
                                                <?php if(App\Models\Meeting::where('attendees_lead',$lead->id)->exists()): ?>
                                                <td> Yes </td>
                                                <?php else: ?>
                                                <td> No </td>
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
            <div class="container-fluid xyz mt-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">

                            <div class="card-body table-border-style">
                                <h3>Lead Details</h3>
                                <hr>
                                <div class=" mt-4">
                                    <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lKey => $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <h4> <?php echo e(ucfirst($lead->name)); ?></h4>
                                    <hr>
                                    <dl class="row">
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Guest Count')); ?></span></dt>
                                        <dd class="col-md-6 need_half"><span class=""><?php echo e($lead->guest_count); ?></span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Training Location')); ?></span></dt>
                                        <dd class="col-md-6 need_half"><span class=""><?php echo e($lead->venue_selection ??'--'); ?></span></dd>
                                        
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Assigned User')); ?></span></dt>
                                        <dd class="col-md-6 need_half"><span class=""><?php if($lead->assigned_user != 0): ?>
                                                <?php echo e(App\Models\User::where('id', $lead->assigned_user)->first()->name); ?>

                                                <?php else: ?>
                                                --
                                                <?php endif; ?></span>
                                        </dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Description')); ?></span></dt>
                                        <dd class="col-md-6 need_half"><span class=""><?php echo e($lead->description ??' --'); ?></span></dd>
                                        <!-- <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Bar')); ?></span></dt> -->
                                        <!-- <dd class="col-md-6 need_half"><span class=""><?php echo e($lead->bar ?? '--'); ?></span></dd> -->
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Package')); ?></span></dt>
                                        <dd class="col-md-6 need_half"><span class="">
                                                <?php $package = json_decode($lead->func_package, true);
                                                if (isset($package) && !empty($package)) {
                                                    foreach ($package as $key => $value) {
                                                        echo implode(',', $value);
                                                    }
                                                } else {
                                                    echo '--';
                                                }
                                                ?>
                                            </span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Additional Items')); ?></span>
                                        </dt>
                                        <dd class="col-md-6 need_half"><span class="">
                                                <?php $additional = json_decode($lead->ad_opts, true);
                                                if (isset($additional) && !empty($additional)) {
                                                    foreach ($additional as $key => $value) {
                                                        echo implode(',', $value);
                                                    }
                                                } else {
                                                    echo "--";
                                                }

                                                ?>
                                            </span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Any Special Requests')); ?></span></dt>
                                        <dd class="col-md-6 need_half"><span class=""><?php echo e($lead->spcl_req ?? '--'); ?></span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Proposal Response')); ?></span>
                                        </dt>
                                        <dd class="col-md-6 need_half"><span class=""><?php if(App\Models\Proposal::where('lead_id',$lead->id)->exists()): ?>
                                                <?php $proposal = App\Models\Proposal::where('lead_id', $lead->id)->first()->notes; ?>
                                                <?php echo e($proposal); ?>

                                                <?php else: ?> --
                                                <?php endif; ?></span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Estimate Amount')); ?></span>
                                        </dt>
                                        <dd class="col-md-6 need_half"><span class=""><?php echo e($grandtotal != 0 ? '$'. $grandtotal : '--'); ?></span></dd>
                                        <?php
                                        @$imgPath = App\Models\Proposal::where('lead_id', $lead->id)->orderBy('created_at','desc')->first();
                                        @$imgPathss = explode('/', @$imgPath->image);
                                        ?>
                                        <?php if($imgPath): ?>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Proposal signature')); ?></span>
                                        </dt>
                                        <dd class="col-md-6 need_half" style="border: 1px solid #000;"><span class=""><img src="<?php echo e(asset('upload/' . @$imgPathss[1])); ?>" alt="" srcset=""></span></dd>
                                        <?php endif; ?>
                                    </dl>

                                    <?php if(count($filteredMeetings[$lKey]) >= 1): ?>
                                    <h4> Training Detail</h4>
                                    <hr>
                                    <dl class="row">
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0"><?php echo e(__('Trainer name')); ?></span>
                                        </dt>
                                        <dd class="col-md-6 need_half"><span class="">
                                                <?php $__currentLoopData = $filteredMeetings[$lKey]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fmKey =>$fmValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $trainerName = \App\Models\User::where('id',$fmValue->user_id)->first();
                                                ?>
                                                <h6><?php echo e($trainerName->name); ?></h6>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </span>
                                        </dd>
                                    </dl>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid xyz mt-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">

                            <div class="card-body table-border-style">
                                <h3>Billing Details</h3>
                                <div class="table-responsive mt-4">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col" class="sort" data-sort="name"><?php echo e(__('Lead')); ?></th> -->
                                                <th scope="col" class="sort" data-sort="name"><?php echo e(__('Created On')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Name')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Amount')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget"><?php echo e(__('Due')); ?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $event = App\Models\Meeting::where('attendees_lead', $lead->id)->first();

                                            if ($event) {
                                                $billing = App\Models\PaymentLogs::where('event_id', $event->id)->get();

                                                $lastpaid = App\Models\PaymentLogs::where('event_id', $event->id)->orderby('id', 'DESC')->first();

                                                if (isset($lastpaid) && !empty($lastpaid)) {
                                                    $amount = App\Models\PaymentInfo::where('event_id', $event->id)->first();
                                                    $amountpaid = 0;
                                                    foreach ($billing as $pay) {
                                                        $amountpaid += $pay->amount;
                                                    }
                                                    echo "<tr>";
                                                    echo "<td>" . Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $lastpaid->created_at)->format('M d, Y') . "</td>";
                                                    echo "<td>" . $lead->name . "</td>";
                                                    echo "<td>" . $amount->amount . "</td>";
                                                    echo "<td>" . $amount->amounttobepaid - $amountpaid . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr>";
                                                echo "<td></td>";
                                                echo "<td style='text-align: center;'><b><h6 class='text-secondary'>Lead Not Converted to Trainings Yet.</h6><b></td>";
                                                echo "<td></td>";
                                                echo "</tr>";
                                            }
                                            ?>
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
                    <div class="col-lg-12">
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
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <h3>Attachments</h3>
                                <div class="table-responsive ">
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
                                                <td><a href="<?php echo e(Storage::url('app/public/'.$doc->filepath)); ?>" download style="color: teal;" title="Download">View Document <i class="fa fa-download"></i></a>
                                            </tr>
                                            <?php endif; ?>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/lead/leadinfo.blade.php ENDPATH**/ ?>