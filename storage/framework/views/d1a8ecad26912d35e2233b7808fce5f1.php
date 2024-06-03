<?php
$proposalUrl = route('lead.signedproposal',urlencode(encrypt($lead->id)));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        p {
            margin-bottom: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <p>Dear <?php echo e(ucfirst($lead->name)); ?></p>
    <div class="container">
        <h1>Proposal Details</h1>

        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Event Type</td>
                    <td><?php echo e($lead->type ?? '--'); ?></td>
                </tr>
                <tr>
                    <td>No. of Guests</td>
                    <td><?php echo e($lead->guest_count ?? '--'); ?></td>
                </tr>
                <tr>
                    <td>Training Location.</td>
                    <td><?php echo e($lead->venue ?? '--'); ?></td>
                </tr>
                <tr>
                    <td>Function</td>
                    <td><?php echo e($lead->function ?? '--'); ?></td>
                </tr>
                <tr>
                    <td>Package</td>
                    <td>
                        <?php if(isset($package) && !empty($package)): ?>
                            <?php $__currentLoopData = $package; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e(implode(',', $value)); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <p><?php echo e($content); ?></p>

        <p>Click the link below to see the Lead details/proposal with estimated billing:</p>
        <p><a href="<?php echo e($proposalUrl); ?>?prop=<?php echo e($propid); ?>"><?php echo e($proposalUrl); ?></a></p>

        <p>Thank you for your time and collaboration.</p>
        <p><strong>With regards,</strong></p>
    </div>

    <div class="footer">
        <p>This email was generated automatically. Please do not reply.</p>
    </div>
</body>

</html>
<?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/lead/mail/view.blade.php ENDPATH**/ ?>