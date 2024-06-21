<?php $event = App\Models\Meeting::find($newpayment->event_id); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('Invoice')); ?></title>
    <style>
        /* Add your email styles here */
    </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="border-collapse:collapse;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;">
                    <tr>
                        <td align="center" style="padding:40px 0;">
                            <h1 style="font-family: Arial, sans-serif; color: #333333;">Payment Confirmation</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 40px;">
                            <p style="font-family: Arial, sans-serif; color: #333333;">
                                Dear <?php echo e($event->name); ?>,
                            </p>
                            <p style="font-family: Arial, sans-serif; color: #333333;">
                                We are delighted to inform you that your payment for the event <strong><?php echo e($event->type); ?></strong> has been successfully processed.
                            </p>
                            <p style="font-family: Arial, sans-serif; color: #333333;">
                                Here are the event details:
                            </p>
                            <ul style="font-family: Arial, sans-serif; color: #333333;">
                                <li><strong>Event Name:</strong> <?php echo e($event->name); ?></li>
                                <li><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($event->start_date)->format('M d, Y')); ?> </li>
                                <li><strong>Venue:</strong> <?php echo e($event->venue_selection); ?></li>
                            </ul>
                            <p style="font-family: Arial, sans-serif; color: #333333;">
                                Below are the Invoice details:
                            </p>
                            <ul style="font-family: Arial, sans-serif; color: #333333;">
                                <li><strong>Amount Paid:</strong> $<?php echo e($newpayment->amount); ?></li>
                                <li><strong>Payment Method:</strong> </li>
                                <li><strong>Transaction ID:</strong> <?php echo e($newpayment->transaction_id); ?></li>
                            </ul>
                            <p style="font-family: Arial, sans-serif; color: #333333;">
                                Thank you for your booking. We look forward to seeing you at the event!
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/billing/invoice.blade.php ENDPATH**/ ?>