<?php
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$selectedvenue = explode(',', $lead->venue_selection);
$settings = App\Models\Utility::settings();
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;

// $data['lead'] = $lead->toArray();
// $data['users'] = $users->toArray();
// $data['venue'] = $venue;
// $data['settings'] = $settings;
// $data['fixed_cost'] = $fixed_cost;
// $data['proposal_info'] = $proposal_info;

$proposal = unserialize($proposal_info['proposal_data']);
// echo "old : {$proposal['address']}";
$token = array(
    'USER_EMAIL'  => $users->email,
);
$pattern = '[%s]';
foreach ($token as $key => $val) {
    $varMap[sprintf($pattern, $key)] = $val;
}
$proposal['address'] = strtr($proposal['address'], $varMap);
// echo '<pre>';
// print_r($proposal_info);
// echo '</pre>';
// echo "new : {$proposal['address']}";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
</head>

<style>
    .border-new {
        border: 1px solid #000 !important;
        padding: 25px 0;
    }

    .border-new1 {
        padding: 40px 0 60px 0;
    }

    .input-new:nth-child(2) {
        justify-content: center;
    }

    .center-new {
        display: block;
        margin: 3px auto;
        text-align: center;
    }

    .input-new {
        padding: 0 10px;
        display: flex;
        column-gap: 20px;
    }

    .input-new1 {
        display: flex;
        column-gap: 20px;
    }
</style>

<body>
    <div class="container mt-5">
        <div class="row card">
            <div class="col-md-12">
                <form method="POST" action="<?php echo e(route('lead.proposalresponse',urlencode(encrypt($lead->id)))); ?>" id='formdata'>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="proposal" value="<?= isset($_GET['prop']) ? $_GET['prop'] : '' ?>">
                    <div class="row">
                        <div class="col-sm-12 mt-4 border-new">
                            <div class="img-section">
                                <img class="logo-img center-new" src="<?php echo e(url('storage/uploads/logo/3_logo-light.png')); ?>" style="width: auto;">
                            </div>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h4 class="center-new"><?php echo __(@$proposal['title']); ?></h4>
                        </div>
                        <div class="col-sm-12 border-new">
                            <?php echo __($proposal['address']); ?>

                            <!--  <h5 class="center-new">PLEASE RETURN TO: Catamount Consulting, PO Box 442, Warrensburg NY 12885</br>Or</h5>
                            <h5 class="center-new input-new">
                                <label for="email"><?php echo e(__('Email')); ?>: </label><?php echo e(__($users->email)); ?>

                            </h5>
                            <h5 class="center-new">Feel free to call our office at (518) 623-2352 with any questions</h5> -->
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="client"><?php echo e(__('Client')); ?>:</label><?php echo e(__($lead->name)); ?>

                            </h5>
                        </div>
                        <div class="col-sm-6 border-new">
                            <h5 class="input-new">
                                <label for="phone"><?php echo e(__('Phone')); ?>:</label><?php echo e(__($lead->primary_contact)); ?>

                            </h5>
                        </div>
                        <div class="col-sm-6 border-new">
                            <h5 class="input-new">
                                <label for="email2"><?php echo e(__('Email')); ?></label><?php echo e(__($lead->email)); ?>

                            </h5>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="servicesDate"><?php echo e(__('Date of service')); ?>:</label><?php echo e(__($lead->start_date)); ?>

                            </h5>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="services"><?php echo e(__('Services')); ?>:</label><?php echo e(__($lead->type)); ?>

                            </h5>
                        </div>
                        <div class="col-sm-12 border-new border-new1" style="min-height: 250px;">
                            <h5 class="input-new">
                                <label for="agreement"><?php echo e(__('Agreement')); ?>:</label>
                            </h5>
                            <?php echo @$proposal['agreement']; ?>

                            <!-- <textarea name="agreement" id="agreement" class="agreement"></textarea> -->
                        </div>
                        <div class="col-sm-12 border-new">
                            <div id="sig">
                                <h5 class="input-new">
                                    <label for="signature"><?php echo e(__('Signature')); ?>:</label>
                                    <canvas id="signatureCanvas" width="300" class="signature-canvas"></canvas>
                                    <input type="hidden" name="imageData" id="imageData">
                                </h5>
                            </div>
                            <button type="button" id="clearButton" class="btn btn-danger btn-sm mt-1">Clear Signature</button>
                        </div>
                        <div class="col-sm-12 border-new border-new1" style="min-height: 250px;">
                            <h5 class="input-new">
                                <label for="remarks"><?php echo e(__('Remarks')); ?>:</label>
                            </h5>
                            <?php echo @$proposal['remarks']; ?>

                            <!-- <textarea name="remarks" id="remarks" class="remarks"></textarea> -->

                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new">
                                <label for="date"><?php echo e(__('Date')); ?>: <?php echo e(__($lead->start_date)); ?></label>
                            </h5>
                        </div>
                        <?php echo __(@$proposal['footer']); ?>

                        <div class="table">
                            <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
                                <tr style="color: #000; text-align: left;">
                                    <th style="padding: 12px;">Label</th>
                                    <th style="padding: 12px;">Details</th>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Name</td>
                                    <td style="padding: 8px;"><?php echo e(__($users->name)); ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Designation</td>
                                    <td style="padding: 8px;"><?php echo e(__($users->type)); ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Date</td>
                                    <td style="padding: 8px;"><?php echo e(__(date('Y-m-d'))); ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;" colspan="2" style="text-align: center; background-color: #f2f2f2; font-weight: bold;">To</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Name</td>
                                    <td style="padding: 8px;"><input type="text" name="to_name" id="to_name" value="" /></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Designation</td>
                                    <td style="padding: 8px;"><input type="text" name="to_designation" id="to_designation" value="" /></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px;">Date</td>
                                    <td style="padding: 8px;"><input type="date" name="to_date" id="to_date" value="" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4 mb-3">
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<style>
    canvas#signatureCanvas {
        border: 1px solid black;
        width: auto;
        height: auto;
        border-radius: 8px;
    }

    .mt-3.auuthsig {
        border: 1px solid black;
        width: 100%;
        height: 165px;
        border-radius: 8px;
    }

    .row {
        --bs-gutter-x: -9rem;
    }
</style>
<?php echo $__env->make('partials.admin.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('partials.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('signatureCanvas');
        var signaturePad = new SignaturePad(canvas);

        function clearCanvas() {
            signaturePad.clear();
        }
        document.getElementById('clearButton').addEventListener('click', function(e) {
            e.preventDefault();
            clearCanvas();
        });
        document.querySelector('form').addEventListener('submit', function() {
            if (signaturePad.points.length != 0) {
                document.getElementById('imageData').value = signaturePad.toDataURL();
            } else {
                document.getElementById('imageData').value = '';
            }
        });
    });
</script><?php /**PATH /home/crmcentraverse/public_html/catamount/resources/views/lead/proposal.blade.php ENDPATH**/ ?>