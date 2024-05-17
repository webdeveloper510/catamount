<?php
$selectedvenue = explode(',', $lead->venue_selection);
$billing = App\Models\ProposalInfo::where('lead_id',$lead->id)->orderby('id','desc')->first();
if(isset($billing) && !empty($billing)){
    $billing= json_decode($billing->proposal_info,true);
}
$startdate = \Carbon\Carbon::createFromFormat('Y-m-d', $lead->start_date)->format('d/m/Y');
$enddate = \Carbon\Carbon::createFromFormat('Y-m-d', $lead->end_date)->format('d/m/Y');
?>
<div class="row card" style="display:none">
    <div class="col-md-12 ">
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
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Venue Rental</td>
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
                        <?php echo e($lead->venue_selection); ?></td>
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
                        <?php echo e($lead->function); ?></td>

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
                    <td
                        style="background-color:#ffff00;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
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
<div class="row ">
    <div class="col-md-12 half-col">
        <div class="card ">
            <div class="card-body">

                <dl class="row">
                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Lead')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e($lead->leadname); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Email')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e($lead->email); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Phone')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e($lead->phone); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Address')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e($lead->lead_address ?? '--'); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Event Date')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e(\Auth::user()->dateFormat($lead->start_date)); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Time')); ?></span></dt>
                    <dd class="col-md-6"><span class="">
                            <?php if($lead->start_time == $lead->end_time): ?>
                            --
                            <?php else: ?>
                            <?php echo e(date('h:i A', strtotime($lead->start_time))); ?> -
                            <?php echo e(date('h:i A', strtotime($lead->end_time))); ?>

                            <?php endif; ?>
                        </span>
                    </dd>
                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Venue')); ?></span></dt>
                    <dd class="col-md-6">
                        <span class=""><?php echo e(!empty($lead->venue_selection)? $lead->venue_selection :'--'); ?></span>
                    </dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Type')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e($lead->type); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Guest Count')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e($lead->guest_count); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Assigned Staff')); ?></span></dt>
                    <dd class="col-md-6"><span
                            class=""><?php echo e(!empty($lead->assign_user)?$lead->assign_user->name:'Not Assigned Yet'); ?>

                            <?php echo e(!empty($lead->assign_user)? '('.$lead->assign_user->type.')' :''); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Lead Created')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e(\Auth::user()->dateFormat($lead->created_at)); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Any Special Requirements')); ?></span></dt>
                    <?php if($lead->spcl_req): ?>
                    <dd class="col-md-6"><span class=""><?php echo e($lead->spcl_req); ?></span></dd>
                    <?php else: ?>
                    <dd class="col-md-6"><span class="">--</span></dd>
                    <?php endif; ?>
                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Estimate Amount')); ?></span></dt>
                    <dd class="col-md-6"><span class=""><?php echo e($grandtotal != 0 ? '$'. $grandtotal : '--'); ?></span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Status')); ?></span></dt>
                    <dd class="col-md-6"><span class="">
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
                    </dd>
                </dl>
            </div>
            <?php if($lead->status == 0): ?>
            <div class="card-footer">
                <div class="w-100 text-end pr-2">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Lead')): ?>
                    <div class="action-btn bg-info ms-2">
                        <a href="<?php echo e(route('lead.edit',$lead->id)); ?>"
                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white" data-bs-toggle="tooltip"
                            data-title="<?php echo e(__('Lead Edit')); ?>" title="<?php echo e(__('Edit')); ?>"><i class="ti ti-edit"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/lead/view.blade.php ENDPATH**/ ?>