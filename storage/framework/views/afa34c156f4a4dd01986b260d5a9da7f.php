<?php
$total = [];
$bar_pck = json_decode($event['bar_package'], true);
?>
<h6>Invoice Summary -Estimate</h6>
<table>
    <thead>
        <tr>
            <th style="text-align:left; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">Name : <?php echo e($event['name']); ?></th>
            <th colspan="2" style="padding:5px 0px;margin-left :5px;font-size:13px"></th>
            <th colspan="3" style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;">Date:<?php echo date("d/m/Y"); ?> </th>
            <th style="text-align:left; font-size:13px;padding:5px 5px; margin-left:5px;">Event: <?php echo e($event['type']); ?></th>
        </tr>
        <tr style="background-color:#063806;">
            <th style="color:#ffffff; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">Description</th>
            <th colspan="2" style="color:#ffffff; font-size:13px;padding:5px 5px; margin-left:5px;"></th>
            <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left: 5px;font-size:13px">Cost</th>
            <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left: 5px;font-size:13px">Quantity</th>
            <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left :5px;font-size:13px">Total Price</th>
            <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left :5px;font-size:13px">Notes</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Special Requests / Others</td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">$<?php echo e(@$billing_data['additional_items']['cost']); ?></td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;"><?php echo e(@$billing_data['additional_items']['quantity']); ?></td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">$<?php echo e($total[] =@$billing_data['additional_items']['cost'] * @$billing_data['additional_items']['quantity']); ?></td>
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
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">$<?php echo e(array_sum($total)); ?></td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
        </tr>
        <tr>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Sales, Occupancy Tax</td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">$<?php echo e(7* array_sum($total)/100); ?></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">Service Charges & Gratuity</td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">$<?php echo e(20 * array_sum($total)/100); ?></td>

            <td></td>
        </tr>
        <tr>
            <td>-</td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

            <td></td>
        </tr>
        <tr>
            <td style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">Grand Total / Estimated Total</td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td style="padding:5px 5px; margin-left:5px;font-size:13px;">$<?php echo e($grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100); ?></td>

            <td></td>
        </tr>
        <tr>
            <td style="background-color:#d7e7d7; padding:5px 5px; margin-left:5px;font-size:13px;">Deposits on file</td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td colspan="2" style="background-color:#d7e7d7;padding:5px 5px; margin-left:5px;font-size:13px;">$<?php echo e($deposit= $billing->deposits); ?></td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
        </tr>
        <tr>
            <td style="background-color:#ffff00;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">balance due</td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
            <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;background-color:#9fdb9f;">$<?php echo e($grandtotal - $deposit); ?></td>
            <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
        </tr>
    </tbody>
</table><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/billing/estimateview.blade.php ENDPATH**/ ?>